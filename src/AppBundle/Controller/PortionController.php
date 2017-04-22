<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Portion;
use AppBundle\Entity\PortionLanguage;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Portion controller.
 *
 * @Route("admin/portion")
 */
class PortionController extends Controller
{
    /**
     * Lists all portion entities.
     *
     * @Route("/", name="portion_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $portions = $em->getRepository('AppBundle:Portion')->findAll();

        return $this->render('portion/index.html.twig', array(
            'portions' => $portions,
        ));
    }

    /**
     * Creates a new portion entity.
     *
     * @Route("/new", name="portion_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $portion = new Portion();
        
        $em = $this->getDoctrine()->getManager();
        $languages = $em->getRepository('AppBundle:Language')->findAll();
        foreach ($languages as $language) {
            $newPortionLanguage = new PortionLanguage();
            $newPortionLanguage->setLanguage($language);
            $portion->addLanguage($newPortionLanguage);
        }
        
        $form = $this->createForm('AppBundle\Form\PortionType', $portion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($portion);
            $em->flush($portion);

            return $this->redirectToRoute('portion_show', array('id' => $portion->getId()));
        }

        return $this->render('portion/new.html.twig', array(
            'portion' => $portion,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a portion entity.
     *
     * @Route("/{id}", name="portion_show")
     * @Method("GET")
     */
    public function showAction(Portion $portion)
    {
        $deleteForm = $this->createDeleteForm($portion);

        return $this->render('portion/show.html.twig', array(
            'portion' => $portion,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing portion entity.
     *
     * @Route("/{id}/edit", name="portion_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Portion $portion)
    {
        $deleteForm = $this->createDeleteForm($portion);
        $editForm = $this->createForm('AppBundle\Form\PortionType', $portion);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('portion_edit', array('id' => $portion->getId()));
        }

        return $this->render('portion/edit.html.twig', array(
            'portion' => $portion,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a portion entity.
     *
     * @Route("/{id}", name="portion_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Portion $portion)
    {
        $form = $this->createDeleteForm($portion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($portion);
            $em->flush($portion);
        }

        return $this->redirectToRoute('portion_index');
    }

    /**
     * Creates a form to delete a portion entity.
     *
     * @param Portion $portion The portion entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Portion $portion)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('portion_delete', array('id' => $portion->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
