<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;

class IndexController extends Controller {

    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request) {
        $languageServer = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
        $language = ($languageServer == 'en') ? 'en' : $request->getLocale();
        
        return $this->redirectToRoute('index', array('_locale' => $language));
    }

    /**
     * @Route(
     *     "/{_locale}",
     *     name="index",
     *     defaults={"_locale": "fr"},
     *     requirements={
     *         "_locale": "en|fr"
     *     }
     * )
     */
    public function indexLangueAction(Request $request) {
        $language = $request->getLocale();
        $path = $this->get('kernel')->getRootDir() . '/../web' 
                . '/Resources/public/data/index'.$language.'.json';
        $lang = json_decode(file_get_contents($path));
        
        return $this->render('index/index.html.twig', array(
                    'lang' => $lang,
        ));
    }
    
    /**
     * @Route(
     *     "/{_locale}/menu",
     *     name="menu",
     *     defaults={"_locale": "fr"},
     *     requirements={
     *         "_locale": "en|fr"
     *     }
     * )
     */
    public function menuAction(Request $request) {
        $language = $request->getLocale();
        
        return $this->render('index/menu.html.twig', array(
                    'menu' => 'menu',
        ));
    }
    
    /**
     * @Route(
     *     "/{_locale}/menu/{id}",
     *     name="menuId",
     *     defaults={"_locale": "fr"},
     *     requirements={
     *         "_locale": "en|fr"
     *     }
     * )
     */
    public function menuIdAction(Request $request, $id) {

        return $this->render('index/menuId.html.twig', array(
                    'menu' => $id,
        ));
    }

}
