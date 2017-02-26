<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class AdminController extends Controller {

    /**
     * @Route(
     *     "/administracion",
     *     defaults={"_locale": "fr"},
     *     requirements={
     *         "_locale": "en|fr"
     *     }
     * )
     */
    public function indexAction($locale = 'fr') {
        $number ='Cuisine_vive';

        return $this->render('admin/login.html.twig', array(
                    'number' => $number,
        ));
    }

}
