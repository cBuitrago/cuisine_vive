<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Orden;
use AppBundle\Entity\FirstUser;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Orden controller.
 *
 * @Route("admin/orden")
 */
class OrdenController extends Controller {

    /**
     * Lists all orden entities.
     *
     * @Route("/", name="orden_index")
     * @Method("GET")
     */
    public function indexAction() {
        $em = $this->getDoctrine()->getManager();

        $ordens = $em->getRepository('AppBundle:Orden')
                ->findByStatus();

        return $this->render('orden/index.html.twig', array(
                    'ordens' => $ordens,
        ));
    }

    /**
     * Creates a new orden entity.
     *
     * @Route("/all", name="orden_all")
     * @Method({"GET", "POST"})
     */
    public function allAction() {
        $em = $this->getDoctrine()->getManager();

        $ordens = $em->getRepository('AppBundle:Orden')
                ->findAll();

        return $this->render('orden/all.html.twig', array(
                    'ordens' => $ordens,
        ));
    }

    /**
     * Finds and displays a orden entity.
     *
     * @Route("/newsletter", name="orden_newsletter")
     * @Method("GET")
     */
    public function newsletterAction(Request $request) {
        $em = $this->getDoctrine()->getManager();

        $users = $em->getRepository('AppBundle:FirstUser')
                ->findByNewsletter(true);

        return $this->render('orden/newsletter.html.twig', array(
                    'users' => $users,
        ));
    }
    
    /**
     * Finds and displays a orden entity.
     *
     * @Route("/{id}", name="orden_show")
     * @Method("GET")
     */
    public function showAction(Orden $orden) {
        $deleteForm = $this->createDeleteForm($orden);

        return $this->render('orden/show.html.twig', array(
                    'orden' => $orden,
                    'delete_form' => $deleteForm->createView(),
        ));
    }
    
    /**
     * Displays a form to edit an existing orden entity.
     *
     * @Route("/{id}/edit", name="orden_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Orden $orden) {

        if (NULL !== $request->request->get('status')) {

            if ($request->request->get('delivered')) {
                $orden->setStatus('delivered');
            } else {
                $orden->setStatus('En cours');
            }
            $em = $this->getDoctrine()->getManager();
            $em->merge($orden);
            $em->flush($orden);
            
            return $this->redirectToRoute('orden_index');
        }

        return $this->render('orden/edit.html.twig', array(
                    'orden' => $orden,
        ));
    }

    /**
     * Deletes a orden entity.
     *
     * @Route("/{id}", name="orden_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Orden $orden) {
        $form = $this->createDeleteForm($orden);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($orden);
            $em->flush($orden);
        }

        return $this->redirectToRoute('orden_index');
    }

    /**
     * Creates a form to delete a orden entity.
     *
     * @param Orden $orden The orden entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Orden $orden) {
        return $this->createFormBuilder()
                        ->setAction($this->generateUrl('orden_delete', array('id' => $orden->getId())))
                        ->setMethod('DELETE')
                        ->getForm()
        ;
    }

}
