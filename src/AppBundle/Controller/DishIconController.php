<?php

namespace AppBundle\Controller;

use AppBundle\Entity\DishIcon;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Dishicon controller.
 *
 * @Route("dishicon")
 */
class DishIconController extends Controller
{
    /**
     * Lists all dishIcon entities.
     *
     * @Route("/", name="dishicon_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $dishIcons = $em->getRepository('AppBundle:DishIcon')->findAll();

        return $this->render('dishicon/index.html.twig', array(
            'dishIcons' => $dishIcons,
        ));
    }

    /**
     * Creates a new dishIcon entity.
     *
     * @Route("/new", name="dishicon_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $dishIcon = new Dishicon();
        $form = $this->createForm('AppBundle\Form\DishIconType', $dishIcon);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($dishIcon);
            $em->flush($dishIcon);

            return $this->redirectToRoute('dishicon_show', array('id' => $dishIcon->getId()));
        }

        return $this->render('dishicon/new.html.twig', array(
            'dishIcon' => $dishIcon,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a dishIcon entity.
     *
     * @Route("/{id}", name="dishicon_show")
     * @Method("GET")
     */
    public function showAction(DishIcon $dishIcon)
    {
        $deleteForm = $this->createDeleteForm($dishIcon);

        return $this->render('dishicon/show.html.twig', array(
            'dishIcon' => $dishIcon,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing dishIcon entity.
     *
     * @Route("/{id}/edit", name="dishicon_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, DishIcon $dishIcon)
    {
        $deleteForm = $this->createDeleteForm($dishIcon);
        $editForm = $this->createForm('AppBundle\Form\DishIconType', $dishIcon);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('dishicon_edit', array('id' => $dishIcon->getId()));
        }

        return $this->render('dishicon/edit.html.twig', array(
            'dishIcon' => $dishIcon,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a dishIcon entity.
     *
     * @Route("/{id}", name="dishicon_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, DishIcon $dishIcon)
    {
        $form = $this->createDeleteForm($dishIcon);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($dishIcon);
            $em->flush($dishIcon);
        }

        return $this->redirectToRoute('dishicon_index');
    }

    /**
     * Creates a form to delete a dishIcon entity.
     *
     * @param DishIcon $dishIcon The dishIcon entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(DishIcon $dishIcon)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('dishicon_delete', array('id' => $dishIcon->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
