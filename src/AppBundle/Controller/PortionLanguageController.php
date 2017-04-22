<?php

namespace AppBundle\Controller;

use AppBundle\Entity\PortionLanguage;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Portionlanguage controller.
 *
 * @Route("admin/portionlanguage")
 */
class PortionLanguageController extends Controller
{
    /**
     * Lists all portionLanguage entities.
     *
     * @Route("/", name="portionlanguage_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $portionLanguages = $em->getRepository('AppBundle:PortionLanguage')->findAll();

        return $this->render('portionlanguage/index.html.twig', array(
            'portionLanguages' => $portionLanguages,
        ));
    }

    /**
     * Creates a new portionLanguage entity.
     *
     * @Route("/new", name="portionlanguage_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $portionLanguage = new Portionlanguage();
        $form = $this->createForm('AppBundle\Form\PortionLanguageType', $portionLanguage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($portionLanguage);
            $em->flush($portionLanguage);

            return $this->redirectToRoute('portionlanguage_show', array('id' => $portionLanguage->getId()));
        }

        return $this->render('portionlanguage/new.html.twig', array(
            'portionLanguage' => $portionLanguage,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a portionLanguage entity.
     *
     * @Route("/{id}", name="portionlanguage_show")
     * @Method("GET")
     */
    public function showAction(PortionLanguage $portionLanguage)
    {
        $deleteForm = $this->createDeleteForm($portionLanguage);

        return $this->render('portionlanguage/show.html.twig', array(
            'portionLanguage' => $portionLanguage,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing portionLanguage entity.
     *
     * @Route("/{id}/edit", name="portionlanguage_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, PortionLanguage $portionLanguage)
    {
        $deleteForm = $this->createDeleteForm($portionLanguage);
        $editForm = $this->createForm('AppBundle\Form\PortionLanguageType', $portionLanguage);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('portionlanguage_edit', array('id' => $portionLanguage->getId()));
        }

        return $this->render('portionlanguage/edit.html.twig', array(
            'portionLanguage' => $portionLanguage,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a portionLanguage entity.
     *
     * @Route("/{id}", name="portionlanguage_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, PortionLanguage $portionLanguage)
    {
        $form = $this->createDeleteForm($portionLanguage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($portionLanguage);
            $em->flush($portionLanguage);
        }

        return $this->redirectToRoute('portionlanguage_index');
    }

    /**
     * Creates a form to delete a portionLanguage entity.
     *
     * @param PortionLanguage $portionLanguage The portionLanguage entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(PortionLanguage $portionLanguage)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('portionlanguage_delete', array('id' => $portionLanguage->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
