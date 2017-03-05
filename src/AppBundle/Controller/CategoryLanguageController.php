<?php

namespace AppBundle\Controller;

use AppBundle\Entity\CategoryLanguage;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Categorylanguage controller.
 *
 * @Route("categorylanguage")
 */
class CategoryLanguageController extends Controller
{
    /**
     * Lists all categoryLanguage entities.
     *
     * @Route("/", name="categorylanguage_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $categoryLanguages = $em->getRepository('AppBundle:CategoryLanguage')->findAll();

        return $this->render('categorylanguage/index.html.twig', array(
            'categoryLanguages' => $categoryLanguages,
        ));
    }

    /**
     * Creates a new categoryLanguage entity.
     *
     * @Route("/new", name="categorylanguage_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $categoryLanguage = new Categorylanguage();
        $form = $this->createForm('AppBundle\Form\CategoryLanguageType', $categoryLanguage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($categoryLanguage);
            $em->flush($categoryLanguage);

            return $this->redirectToRoute('categorylanguage_show', array('id' => $categoryLanguage->getId()));
        }

        return $this->render('categorylanguage/new.html.twig', array(
            'categoryLanguage' => $categoryLanguage,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a categoryLanguage entity.
     *
     * @Route("/{id}", name="categorylanguage_show")
     * @Method("GET")
     */
    public function showAction(CategoryLanguage $categoryLanguage)
    {
        $deleteForm = $this->createDeleteForm($categoryLanguage);

        return $this->render('categorylanguage/show.html.twig', array(
            'categoryLanguage' => $categoryLanguage,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing categoryLanguage entity.
     *
     * @Route("/{id}/edit", name="categorylanguage_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, CategoryLanguage $categoryLanguage)
    {
        $deleteForm = $this->createDeleteForm($categoryLanguage);
        $editForm = $this->createForm('AppBundle\Form\CategoryLanguageType', $categoryLanguage);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('categorylanguage_edit', array('id' => $categoryLanguage->getId()));
        }

        return $this->render('categorylanguage/edit.html.twig', array(
            'categoryLanguage' => $categoryLanguage,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a categoryLanguage entity.
     *
     * @Route("/{id}", name="categorylanguage_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, CategoryLanguage $categoryLanguage)
    {
        $form = $this->createDeleteForm($categoryLanguage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($categoryLanguage);
            $em->flush($categoryLanguage);
        }

        return $this->redirectToRoute('categorylanguage_index');
    }

    /**
     * Creates a form to delete a categoryLanguage entity.
     *
     * @param CategoryLanguage $categoryLanguage The categoryLanguage entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(CategoryLanguage $categoryLanguage)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('categorylanguage_delete', array('id' => $categoryLanguage->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
