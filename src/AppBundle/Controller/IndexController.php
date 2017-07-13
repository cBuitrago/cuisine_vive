<?php

namespace AppBundle\Controller;

use AppBundle\Entity\FirstUser;
use AppBundle\Entity\Orden;
use AppBundle\Entity\OrdenDishPortion;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Session\Session;
use \DateTime;

class IndexController extends Controller {

    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request) {

        $session = $request->getSession();
        $language = $this->getLanguage($session);
        $em = $this->getDoctrine()->getManager();
        $categories = $em->getRepository('AppBundle:Category')->getCategoriesIndex($language);
        $cart_info = $this->cartInformation($session, $language);

        return $this->render('index/index.html.twig', array(
                    'lang' => $this->getLang($language),
                    'language' => $language,
                    'categories' => $categories,
                    'modal' => FALSE,
                    'cart' => $cart_info,
                    'liv' => $this->dateLivraison(),
        ));
    }

    /**
     * @Route("/menu", name="menu",
     * defaults={"_fragment": "home"})
     */
    public function menuAction(Request $request) {

        $session = $request->getSession();
        $language = $this->getLanguage($session);
        $em = $this->getDoctrine()->getManager();

        $cart_info = $this->cartInformation($session, $language);

        $categories = $em->getRepository('AppBundle:Category')->getCategoriesMenu($language);

        return $this->render('index/menu.html.twig', array(
                    'lang' => $this->getLang($language),
                    'language' => $language,
                    'categories' => $categories,
                    'modal' => FALSE,
                    'cart' => $cart_info,
                    'liv' => $this->dateLivraison(),
        ));
    }

    /**
     * @Route("/menu/{id}", name="menuId")
     */
    public function menuIdAction(Request $request, $id) {

        $em = $this->getDoctrine()->getManager();
        $dish = $em->getRepository('AppBundle:DishLanguage')
                ->getDishLanguageByName(str_replace("-", " ", $id), $request);

        if ($dish === FALSE) {
            throw new NotFoundHttpException("Page not found");
        }

        $session = $request->getSession();
        $language = $dish->language;

        if (!empty($language) && $session->get('language') != $language) {
            $session->set("language", $language);
        }

        $cart_info = $this->cartInformation($session, $language);

        return $this->render('index/menuId.html.twig', array(
                    'lang' => $this->getLang($language),
                    'language' => $language,
                    'dish' => $dish,
                    'modal' => FALSE,
                    'cart' => $cart_info,
                    'liv' => $this->dateLivraison(),
        ));
    }

    /**
     * @Route("/order", name="order")
     */
    public function orderAction(Request $request) {

        $session = $request->getSession();
        $language = $this->getLanguage($session);
        $cart_info = [];
        $modal = FALSE;
        $em = $this->getDoctrine()->getManager();

        if ($session->has("items")) {
            $cart_array = $session->get("items");
        } else {
            $cart_array = [];
        }
        $modal = FALSE;
        if (!empty($_POST["dish_item"])) {

            $validator = TRUE;
            foreach ($cart_array as $key => $item) {
                if ($item[0] == $_POST["dish_item"]) {
                    $cart_array[$key][1] = $cart_array[$key][1] + 1;
                    $validator = FALSE;
                    break;
                }
            }
            if ($validator === TRUE) {
                $item_cart = [];
                $item_cart[0] = $_POST["dish_item"];
                $item_cart[1] = 1;
                array_push($cart_array, $item_cart);
            }

            $session->set("items", $cart_array);
        }
        $cart_info = $this->cartInformation($session, $language);

        if (isset($_POST["shipping"])) {

            $firstUser = $em->getRepository('AppBundle:FirstUser')
                    ->findOneByEmail($_POST["email"]);

            if ($firstUser == NULL) {
                $firstUser = new FirstUser();
                $firstUser->setEmail($_POST["email"])
                        ->setName($_POST["name"]);
                if (!empty($_POST["input_newsletter"])) {
                    $firstUser->setNewsletter(true);
                }
                $em->persist($firstUser);
                $em->flush($firstUser);
            } else {
                if ($firstUser->getName() == NULL) {
                    $firstUser->setName($_POST["name"]);
                    $em->merge($firstUser);
                    $em->flush($firstUser);
                }
                if (!empty($_POST["input_newsletter"]) && $firstUser->getNewsletter() == FALSE) {
                    $firstUser->setNewsletter(true);
                    $em->merge($firstUser);
                    $em->flush($firstUser);
                }
            }

            $date = new DateTime();
            $order = new Orden();
            $order->setFirstUser($firstUser)
                    ->setDateOrder($date)
                    ->setDateDelivery($date)
                    ->setStatus("En cours")
                    ->setTel($_POST["tel"])
                    ->setDeliPrice($_POST["deli_total"])
                    ->setUserPrice(floatval($_POST["total_total"]))
                    ->setCalculatePrice(0);
            if (!empty($_POST["input_newsletter"])) {
                $order->setInCash(TRUE);
            } else {
                $order->setInCash(FALSE);
            }
            if (!empty($_POST["comments"])) {
                $order->setComments($_POST["comments"]);
            } else {
                $order->setComments(NULL);
            }
            if (!empty($_POST["paiment"])) {
                $order->setInCash(TRUE);
            } else {
                $order->setInCash(FALSE);
            }
            if ($_POST["shipping"] == 1) {
                $order->setInSitu(true)
                        ->setAddress($_POST["address"])
                        ->setZipCode($_POST["postalCode"]);
            } else {
                $order->setInSitu(true)
                        ->setAddress(NULL)
                        ->setZipCode(NULL);
            }

            $em->persist($order);
            $em->flush($order);

            $priceCalculate = 0;
            $orderEmail = array();
            foreach ($_POST as $key => $item) {
                if (preg_match('/^qte_/', $key) == true) {
                    $index = intval(substr($key, 4));
                    $dish_portion = $em->getRepository('AppBundle:DishPortion')->find($index);
                    $orderDishPortion = new OrdenDishPortion();
                    $orderDishPortion->setOrden($order)
                            ->setDishPortion($dish_portion)
                            ->setQuantity(intval($item));
                    $priceCalculate = $priceCalculate + floatval($item * $dish_portion->getPrice());
                    $em->persist($orderDishPortion);
                    $em->flush($orderDishPortion);
                    $order->addItem($orderDishPortion);
                    $orderEmail[$index] = array();
                    $orderEmail[$index][0] = $dish_portion->getDish()->getLanguageOfDish($language);
                    $orderEmail[$index][1] = $dish_portion->getPortion()->getLanguageOfPortion($language);
                    $orderEmail[$index][2] = $dish_portion->getPrice();
                    $orderEmail[$index][3] = intval($item);
                    $orderEmail[$index][4] = intval($item) * $dish_portion->getPrice();
                }
            }
            $priceCalculate = $priceCalculate + floatval($_POST["deli_total"]);
            $priceCalculate = $priceCalculate * 1.1475;

            $order->setCalculatePrice($priceCalculate);
            $em->merge($order);
            $em->flush($order);
            $subject = ($language == 'en') ? 'Cuisine Vive - Order confirmation' : 'Cuisine Vive - Confirmation de commande';
            $message = \Swift_Message::newInstance()
                    ->setSubject($subject)
                    ->setFrom('info@cuisinevive.ca')
                    ->setTo(array($order->getFirstUser()->getEmail()));
            $image_src = $message->embed(\Swift_Image::fromPath('Resources/public/images/logo.png'));
            $message->setBody(
                    $this->renderView(
                            'emails/orderConfirmation.html.twig', array(
                        'lang' => $this->getLang($language),
                        'order' => $order,
                        'orderEmail' => $orderEmail,
                        'image' => $image_src,
                            )
                    ), 'text/html'
            );

            $this->get('mailer')->send($message);
            $session->remove("items");

            return $this->render('index/orderReceived.html.twig', array(
                        'lang' => $this->getLang($language),
                        'language' => $language,
                        'liv' => $this->dateLivraison(),
            ));
        } else {
            return $this->render('index/order.html.twig', array(
                        'lang' => $this->getLang($language),
                        'language' => $language,
                        'modal' => $modal,
                        'cart' => $cart_info,
                        'liv' => $this->dateLivraison(),
            ));
        }
    }

    /**
     * @Route("/updateCart", name="updateCart")
     */
    public function updateCart(Request $request) {

        if (!$request->isXmlHttpRequest()) {
            return $this->redirectToRoute('homepage');
        }

        $session = $request->getSession();
        $language = $this->getLanguage($session);
        $em = $this->getDoctrine()->getManager();
        if ($session->has("items")) {
            $cart_array = $session->get("items");
        } else {
            $cart_array = [];
        }

        if (!empty($_POST["dish_item"])) {
            $validator = TRUE;
            foreach ($cart_array as $key => $item) {
                if ($item[0] == $_POST["dish_item"]) {
                    $cart_array[$key][1] = $cart_array[$key][1] + 1;
                    $validator = FALSE;
                    break;
                }
            }
            if ($validator === TRUE) {
                $item_cart = [];
                $item_cart[0] = $_POST["dish_item"];
                $item_cart[1] = 1;
                array_push($cart_array, $item_cart);
            }

            $session->set("items", $cart_array);
        }

        $cart_info = $this->cartInformation($session, $language);

        $lang = $this->getLang($language);
        $cartHtml = $this->cartView($cart_info, $lang);
        return new JsonResponse(array('cart' => $cartHtml), 200);
    }

    /**
     * @Route("/updateQteCart", name="updateQteCart")
     */
    public function updateQteCart(Request $request) {

        if (!$request->isXmlHttpRequest()) {
            return $this->redirectToRoute('homepage');
        }

        $session = $request->getSession();
        if (!$session->has("items")) {
            return new JsonResponse(array('message' => 'No aplica!'), 400);
        }

        $cart_array = $session->get("items");
        if (!empty($_POST["item"])) {

            foreach ($cart_array as $key => $item) {
                if ($item[0] == $_POST["item"]) {
                    $cart_array[$key][1] = $_POST["qte"];
                    $session->set("items", $cart_array);

                    return new JsonResponse(array('message' => 'OK'), 200);
                }
            }
        }

        return new JsonResponse(array('message' => 'NOT FOUND'), 404);
    }

    /**
     * @Route("/addToNewsletter", name="addToNewsletter")
     */
    public function addToNewsletter(Request $request) {

        if (!$request->isXmlHttpRequest()) {
            return $this->redirectToRoute('homepage');
        }

        if (empty($request->get('email'))) {
            return new JsonResponse(array('message' => 'BAD_REQUEST'), 400);
        }
        $em = $this->getDoctrine()->getManager();

        $firstUser = $em->getRepository('AppBundle:FirstUser')
                ->findOneByEmail($request->get('email'));

        if ($firstUser == NULL) {
            $firstUser = new FirstUser();
            $firstUser->setEmail($request->get('email'))
                    ->setNewsletter(1);
            $em->persist($firstUser);
            $em->flush($firstUser);
            return new JsonResponse(array('message' => 'OK'), 200);
        } else {
            if ($firstUser->getNewsletter() == 0) {
                $firstUser->setNewsletter(1);
                $em->merge($firstUser);
                $em->flush($firstUser);
                return new JsonResponse(array('message' => 'OK'), 200);
            } else {
                return new JsonResponse(array('message' => 'ALREADY_EXISTS'), 200);
            }
        }

        return new JsonResponse(array('message' => 'BAD_REQUEST'), 400);
    }

    /**
     * @Route("/deleteItemCart", name="deleteItemCart")
     */
    public function deleteItemCart(Request $request) {

        if (!$request->isXmlHttpRequest()) {
            return $this->redirectToRoute('homepage');
        }

        $session = $request->getSession();
        if (!$session->has("items")) {
            return new JsonResponse(array('message' => 'No aplica!'), 400);
        }

        $cart_array = $session->get("items");
        if (!empty($_POST["item"])) {

            foreach ($cart_array as $key => $item) {
                if ($item[0] == $_POST["item"]) {
                    unset($cart_array[$key]);
                    $session->set("items", $cart_array);
                    if (count($session->get("items")) > 0) {
                        return new JsonResponse(array('message' => 'OK'), 200);
                    } else {
                        $language = $this->getLanguage($session);
                        $lang = $this->getLang($language);
                        $cart_view = $this->cartView(array(), $lang);
                        return new JsonResponse(array('message' => 'view',
                            'view' => $cart_view), 200);
                    }
                }
            }
        }

        return new JsonResponse(array('message' => $_POST["item"]), 404);
    }

    private function getLanguage($session) {

        if (!empty($_POST["language"])) {

            $language = $_POST["language"];
            $session->set("language", $language);
        } elseif (!$session->has("language") || empty($session->get("language"))) {

            $languageServer = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
            $language = ($languageServer == "en") ? "en" : "fr";
            $session->set("language", $language);
        }

        return $session->get("language");
    }

    private function getLang($language) {
        $path = $this->get('kernel')->getRootDir() . '/../web'
                . '/Resources/public/data/index' . $language . '.json';
        return json_decode(file_get_contents($path));
    }

    private function cartInformation($session, $language) {
        $em = $this->getDoctrine()->getManager();
        $cart_info = [];
        if (!empty($session->get("items"))) {
            foreach ($session->get("items") as $item) {
                $itemToAdd = [];
                $dish_portion = $em->getRepository('AppBundle:DishPortion')->find($item[0]);
                $itemToAdd["id"] = $dish_portion->getId();
                $itemToAdd["photo"] = $dish_portion->getDish()->getPhoto();
                foreach ($dish_portion->getDish()->getLanguages() as $dishLanguage) {
                    if ($dishLanguage->getLanguage()->getName() == $language) {
                        $itemToAdd["dishName"] = $dishLanguage->getName();
                    }
                }
                foreach ($dish_portion->getPortion()->getLanguages() as $portionLanguage) {
                    if ($portionLanguage->getLanguage()->getName() == $language) {
                        $itemToAdd["portionName"] = $portionLanguage->getName();
                    }
                }
                $itemToAdd["price"] = $dish_portion->getPrice();
                $itemToAdd["qte"] = $item[1];
                array_push($cart_info, $itemToAdd);
            }
        }

        return $cart_info;
    }

    private function cartView($cart_info, $lang) {
        $reponse_view = [];

        if (!empty($cart_info)) {
            $reponse_view_body = '<table class="table table-condensed">
                            <tr>
                                <th></th>
                                <th class="name">' . $lang->shoppingCart->contenu->dishName . '</th>
                                <th class="portion">' . $lang->shoppingCart->contenu->dishPortion . '</th>
                                <th>' . $lang->shoppingCart->contenu->dishPrice . '</th>
                                <th class="qty">' . $lang->shoppingCart->contenu->dishQty . '</th>
                                <th class="total">' . $lang->shoppingCart->contenu->dishTotal . '</th>
                            </tr>';
            foreach ($cart_info as $item) {
                $reponse_view_body = $reponse_view_body . '<tr id="item_' . $item["id"] . '">' .
                        '<td><img class="" src="/Resources/public/images/' . $item["photo"] . '" alt="' . $item["dishName"] . '" /></td>' .
                        '<td >' . $item["dishName"] . '</td>' .
                        '<td >' . $item["portionName"] . '</td>' .
                        '<td>$<input type="text" class="price"  id="price_' . $item["id"] . '" value="' . $item["price"] . '" disabled="disabled" ></td>' .
                        '<td>' .
                        '<div class="editQte">' .
                        '<span class="glyphicon glyphicon-minus-sign" data-minus="_' . $item["id"] . '"></span>' .
                        '<input type="text" class="chartQte" id="qte_' . $item["id"] . '" data-total="_' . $item["id"] . '" value="' . $item["qte"] . '">' .
                        '<span class="glyphicon glyphicon-plus-sign" data-plus="_' . $item["id"] . '"></span>' .
                        '</div>' .
                        '</td>' .
                        '<td><input type="text" id="total_' . $item["id"] . '" class="orderTotal chartTotal" disabled="disabled"></td>' .
                        '<td><span class="glyphicon glyphicon-trash" data-delete="_' . $item["id"] . '"></span></td>' .
                        '</tr>';
            }
            $reponse_view_body = $reponse_view_body . '<tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>' . $lang->shoppingCart->contenu->GST . '</td>
                                <td><input type="text" id="tps_total" class="chartTotal" disabled="disabled"></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>' . $lang->shoppingCart->contenu->QST . '</td>
                                <td><input type="text" id="tvq_total" class="chartTotal" disabled="disabled"></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>TOTAL</td>
                                <td><input type="text" id="total_total" class="total_total" disabled="disabled"></td>
                                <td></td>
                            </tr>
                       </table>';

            $reponse_view_footer = '<a type="button" class="btn-2" data-dismiss="modal">' . $lang->shoppingCart->button1->text . '</a>
                        <a type="button" class="btn-1" href="/order">' . $lang->shoppingCart->button2->text . '</a>';
        } else {
            $reponse_view_body = '<p class="emptyText">' . $lang->shoppingCart->contenu->emptyText . '</p>';
            $reponse_view_footer = '<a type="button" class="btn-2" href="/menu">' . $lang->shoppingCart->button3->text . '</a>';
        }
        $reponse_view['body'] = $reponse_view_body;
        $reponse_view['footer'] = $reponse_view_footer;

        return $reponse_view;
    }

    private function dateLivraison() {

        $dayWeek = jddayofweek(unixtojd(time()));

        switch ($dayWeek) {
            case 0:
                $day = 6;
                break;
            case 1:
                $day = 5;
                break;
            case 2:
                $day = 4;
                break;
            case 3:
                $day = 3;
                break;
            case 4:
                $day = 2;
                break;
            case 5:
                $day = 8;
                break;
            case 6:
                $day = 7;
                break;

            default:
                $day = 7;
                break;
        }

        $date = new \DateTime();
        $nextSamedi = $date->setTimestamp(time() + (86400 * intval($day)));

        return $nextSamedi;
    }

}
