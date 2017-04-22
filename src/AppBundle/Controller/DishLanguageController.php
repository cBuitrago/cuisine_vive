<?php

namespace AppBundle\Controller;

use AppBundle\Entity\DishLanguage;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Dishlanguage controller.
 *
 * @Route("admin/dishlanguage")
 */
class DishLanguageController extends Controller
{
    /**
     * Lists all dishLanguage entities.
     *
     * @Route("/", name="dishlanguage_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $dishLanguages = $em->getRepository('AppBundle:DishLanguage')->findAll();

        return $this->render('dishlanguage/index.html.twig', array(
            'dishLanguages' => $dishLanguages,
        ));
    }

    /**
     * Creates a new dishLanguage entity.
     *
     * @Route("/new", name="dishlanguage_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $dishLanguage = new Dishlanguage();
        $form = $this->createForm('AppBundle\Form\DishLanguageType', $dishLanguage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($dishLanguage);
            $em->flush($dishLanguage);

            return $this->redirectToRoute('dishlanguage_show', array('id' => $dishLanguage->getId()));
        }

        return $this->render('dishlanguage/new.html.twig', array(
            'dishLanguage' => $dishLanguage,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a dishLanguage entity.
     *
     * @Route("/{id}", name="dishlanguage_show")
     * @Method("GET")
     */
    public function showAction(DishLanguage $dishLanguage)
    {
        $deleteForm = $this->createDeleteForm($dishLanguage);

        return $this->render('dishlanguage/show.html.twig', array(
            'dishLanguage' => $dishLanguage,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing dishLanguage entity.
     *
     * @Route("/{id}/edit", name="dishlanguage_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, DishLanguage $dishLanguage)
    {
        $deleteForm = $this->createDeleteForm($dishLanguage);
        $editForm = $this->createForm('AppBundle\Form\DishLanguageType', $dishLanguage);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('dishlanguage_edit', array('id' => $dishLanguage->getId()));
        }

        return $this->render('dishlanguage/edit.html.twig', array(
            'dishLanguage' => $dishLanguage,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a dishLanguage entity.
     *
     * @Route("/{id}", name="dishlanguage_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, DishLanguage $dishLanguage)
    {
        $form = $this->createDeleteForm($dishLanguage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($dishLanguage);
            $em->flush($dishLanguage);
        }

        return $this->redirectToRoute('dishlanguage_index');
    }

    /**
     * Creates a form to delete a dishLanguage entity.
     *
     * @param DishLanguage $dishLanguage The dishLanguage entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(DishLanguage $dishLanguage)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('dishlanguage_delete', array('id' => $dishLanguage->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
