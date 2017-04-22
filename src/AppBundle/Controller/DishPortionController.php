<?php

namespace AppBundle\Controller;

use AppBundle\Entity\DishPortion;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Dishportion controller.
 *
 * @Route("admin/dishportion")
 */
class DishPortionController extends Controller
{
    /**
     * Lists all dishPortion entities.
     *
     * @Route("/", name="dishportion_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $dishPortions = $em->getRepository('AppBundle:DishPortion')->findAll();

        return $this->render('dishportion/index.html.twig', array(
            'dishPortions' => $dishPortions,
        ));
    }

    /**
     * Creates a new dishPortion entity.
     *
     * @Route("/new", name="dishportion_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $dishPortion = new Dishportion();
        $form = $this->createForm('AppBundle\Form\DishPortionType', $dishPortion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($dishPortion);
            $em->flush($dishPortion);

            return $this->redirectToRoute('dishportion_show', array('id' => $dishPortion->getId()));
        }

        return $this->render('dishportion/new.html.twig', array(
            'dishPortion' => $dishPortion,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a dishPortion entity.
     *
     * @Route("/{id}", name="dishportion_show")
     * @Method("GET")
     */
    public function showAction(DishPortion $dishPortion)
    {
        $deleteForm = $this->createDeleteForm($dishPortion);

        return $this->render('dishportion/show.html.twig', array(
            'dishPortion' => $dishPortion,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing dishPortion entity.
     *
     * @Route("/{id}/edit", name="dishportion_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, DishPortion $dishPortion)
    {
        $deleteForm = $this->createDeleteForm($dishPortion);
        $editForm = $this->createForm('AppBundle\Form\DishPortionType', $dishPortion);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('dishportion_edit', array('id' => $dishPortion->getId()));
        }

        return $this->render('dishportion/edit.html.twig', array(
            'dishPortion' => $dishPortion,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a dishPortion entity.
     *
     * @Route("/{id}", name="dishportion_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, DishPortion $dishPortion)
    {
        $form = $this->createDeleteForm($dishPortion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($dishPortion);
            $em->flush($dishPortion);
        }

        return $this->redirectToRoute('dishportion_index');
    }

    /**
     * Creates a form to delete a dishPortion entity.
     *
     * @param DishPortion $dishPortion The dishPortion entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(DishPortion $dishPortion)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('dishportion_delete', array('id' => $dishPortion->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
