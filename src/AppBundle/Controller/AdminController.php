<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class AdminController extends Controller {

    /**
     * @Route(
     *     "/administracion",
     *     name="administracion"
     * )
     */
    public function indexAction($locale = 'fr') {
        $number ='Cuisine_vive';

        return $this->render('admin/index.html.twig', array(
                    'number' => 'administracion',
        ));
    }

}
