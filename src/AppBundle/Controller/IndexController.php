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
        $language = $this->getLanguage();
        $em = $this->getDoctrine()->getManager();
        $categories = $em->getRepository('AppBundle:Category')->findAll();

        /*if ($session->has("items")) {
            $cart_array = $session->get("items");
        } else {
            $cart_array = [];
        }*/

        $cart_info = $this->cartInformation($session, $language);

        return $this->render('index/index.html.twig', array(
                    'lang' => $this->getLang($language),
                    'language' => $language,
                    'categories' => $categories,
                    'modal' => FALSE,
                    'cart' => $cart_info
        ));
    }

    /**
     * @Route("/menu", name="menu",
     * defaults={"_fragment": "home"})
     */
    public function menuAction(Request $request) {

        $session = $request->getSession();
        $language = $this->getLanguage();
        $em = $this->getDoctrine()->getManager();
        /*if ($session->has("items")) {
            $cart_array = $session->get("items");
        } else {
            $cart_array = [];
        }
        $modal = FALSE;
        if (!empty($_POST["dish_item"])) {
            $modal = TRUE;
            $item_cart = [];
            $item_cart[0] = $_POST["dish_item"];
            $item_cart[1] = 1;
            array_push($cart_array, $item_cart);

            $session->set("items", $cart_array);
        }*/

        $cart_info = $this->cartInformation($session, $language);

        $categories = $em->getRepository('AppBundle:Category')->findAll();

        return $this->render('index/menu.html.twig', array(
                    'lang' => $this->getLang($language),
                    'language' => $language,
                    'categories' => $categories,
                    'modal' => FALSE,
                    'cart' => $cart_info
        ));
    }

    /**
     * @Route("/menu/{id}", name="menuId")
     */
    public function menuIdAction(Request $request, $id) {

        $session = $request->getSession();

        $em = $this->getDoctrine()->getManager();
        $dish = $em->getRepository('AppBundle:DishLanguage')
                ->findOneByName(str_replace("-", " ", $id));

        $language = $dish->getLanguage()->getName();
        /*if ($session->has("items")) {
            $cart_array = $session->get("items");
        } else {
            $cart_array = [];
        }
        $modal = FALSE;
        if (!empty($_POST["dish_item"])) {
            $modal = TRUE;
            $item_cart = [];
            $item_cart[0] = $_POST["dish_item"];
            $item_cart[1] = 1;
            array_push($cart_array, $item_cart);

            $session->set("items", $cart_array);
        }*/

        $cart_info = $this->cartInformation($session, $language);

        return $this->render('index/menuId.html.twig', array(
                    'lang' => $this->getLang($language),
                    'language' => $language,
                    'dish' => $dish,
                    'modal' => FALSE,
                    'cart' => $cart_info
        ));
    }

    /**
     * @Route("/order", name="order")
     */
    public function orderAction(Request $request) {

        $session = $request->getSession();
        $language = $this->getLanguage();
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
            $modal = TRUE;
            $item_cart = [];
            $item_cart[0] = $_POST["dish_item"];
            $item_cart[1] = 1;
            array_push($cart_array, $item_cart);

            $session->set("items", $cart_array);
        }
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

        if (isset($_POST["order"])) {
            $firstUser = $em->getRepository('AppBundle:FirstUser')
                    ->findOneByEmail($_POST["email"]);

            if ($firstUser == NULL) {
                $firstUser = new FirstUser();
                $firstUser->setEmail($_POST["email"])
                        ->setName($_POST["name"])
                        ->setTel($_POST["tel"]);
                $em->persist($firstUser);
                $em->flush($firstUser);
            }

            $date = new DateTime();
            $order = new Orden();
            $order->setFirstUser($firstUser)
                    ->setDateOrder($date)
                    ->setDateDelivery($date)
                    ->setPayType("cash")
                    ->setStatus("En cours");

            $em->persist($order);
            $em->flush($order);

            foreach ($session->get("items") as $item) {
                $dish_portion = $em->getRepository('AppBundle:DishPortion')->find($item[0]);
                $orderDishPortion = new OrdenDishPortion();
                $orderDishPortion->setOrden($order)
                        ->setDishPortion($dish_portion)
                        ->setQuantity($item[1]);
                $em->persist($orderDishPortion);
                $em->flush($orderDishPortion);
            }

            $session->remove("items");

            return $this->render('index/orderReceived.html.twig', array(
                        'lang' => $this->getLang($language),
                        'language' => $language
            ));
        } else {
            return $this->render('index/order.html.twig', array(
                        'lang' => $this->getLang($language),
                        'language' => $language,
                        'modal' => $modal,
                        'cart' => $cart_info
            ));
        }
    }

    /**
     * @Route("/updateCart", name="updateCart")
     */
    public function updateCart(Request $request) {

        if (!$request->isXmlHttpRequest()) {

            //Redireccionar al homepage
            return new JsonResponse(array('message' => 'Redireccionar al homepage!'), 400);
        }

        $session = $request->getSession();
        $language = $this->getLanguage();
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

            //Redireccionar al homepage
            return new JsonResponse(array('message' => 'Redireccionar al homepage!'), 400);
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
        
        
        
        
        
        /*$session = $request->getSession();
        $language = $this->getLanguage();
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
        return new JsonResponse(array('cart' => $cartHtml), 200);*/
    }
    
    /**
     * @Route("/deleteItemCart", name="deleteItemCart")
     */
    public function deleteItemCart(Request $request) {

        if (!$request->isXmlHttpRequest()) {

            //Redireccionar al homepage
            return new JsonResponse(array('message' => 'Redireccionar al homepage!'), 400);
        }

        $session = $request->getSession();
        if (!$session->has("items")) {
            return new JsonResponse(array('message' => 'No aplica!'), 400);;
        } 
        
        $cart_array = $session->get("items");
        if (!empty($_POST["item"])) {

            foreach ($cart_array as $key => $item) {
                if ($item[0] == $_POST["item"]) {
                    unset($cart_array[$key]);
                    $session->set("items", $cart_array);
                    return new JsonResponse(array('message' => 'OK'), 200);
                }
            }            
        }

        return new JsonResponse(array('message' => $_POST["item"]), 404);
    }

    private function getLanguage() {
        $language = "fr";
        if (!empty($_POST["language"])) {
            $language = $_POST["language"];
            $_SESSION["language"] = $language;
        } elseif (!empty($_SESSION["language"])) {
            $language = $_SESSION["language"];
        } else {
            $languageServer = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
            $language = ($languageServer == "en") ? "en" : "fr";
        }

        return $language;
        //return "en";
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

        $reponse_view = '<table class="table table-condensed">
                            <tr>
                                <th></th>
                                <th class="name">' . $lang->shoppingCart->contenu->dishName . '</th>
                                <th class="portion">' . $lang->shoppingCart->contenu->dishPortion . '</th>
                                <th>' . $lang->shoppingCart->contenu->dishPrice . '</th>
                                <th class="qty">' . $lang->shoppingCart->contenu->dishQty . '</th>
                                <th class="total">' . $lang->shoppingCart->contenu->dishTotal . '</th>
                            </tr>';
        if (!empty($cart_info)) {
            foreach ($cart_info as $item) {
                $reponse_view = $reponse_view . '<tr id="item_' . $item["id"] . '">' .
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
        }
        $reponse_view = $reponse_view . '<tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>TPS (5%)</td>
                                <td><input type="text" id="tps_total" class="chartTotal" disabled="disabled"></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>TVQ (9.975%)</td>
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

        return $reponse_view;
    }

}
