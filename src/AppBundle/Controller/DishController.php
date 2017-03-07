<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Dish;
use AppBundle\Entity\DishLanguage;
use AppBundle\Entity\DishPortion;
use AppBundle\Entity\DishIcon;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Dish controller.
 *
 * @Route("dish")
 */
class DishController extends Controller {

    /**
     * Lists all dish entities.
     *
     * @Route("/", name="administracion_dish_index")
     * @Method("GET")
     */
    public function indexAction() {
        $em = $this->getDoctrine()->getManager();

        $dishes = $em->getRepository('AppBundle:Dish')->findAll();

        return $this->render('dish/index.html.twig', array(
                    'dishes' => $dishes,
        ));
    }

    /**
     * Creates a new dish entity.
     *
     * @Route("/new", name="administracion_dish_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request) {
        $dish = new Dish();
        $em = $this->getDoctrine()->getManager();
        $languages = $em->getRepository('AppBundle:Language')->findAll();
        foreach ($languages as $language) {
            $newDishLanguage = new DishLanguage();
            $newDishLanguage->setLanguage($language);
            $dish->addLanguage($newDishLanguage);
        }
        $portions = $em->getRepository('AppBundle:Portion')->findAll();
        foreach ($portions as $portion) {
            $newDishPortion = new DishPortion();
            $newDishPortion->setPortion($portion);
            $dish->addPortion($newDishPortion);
        }
        /*$icons = $em->getRepository('AppBundle:Icon')->findAll();
        foreach ($icons as $icon) {
            $newDishIcon = new DishIcon();
            $newDishIcon->setIcon($icon);
            //$dish->addIcon($newDishIcon);
        }*/


        $form = $this->createForm('AppBundle\Form\DishType', $dish);
        $form->handleRequest($request);



        if ($form->isSubmitted() && $form->isValid()) {

            $file = $dish->getPhoto();

            $fileName = md5(uniqid()).'.'.$file->guessExtension();

            $file->move(
                $this->getParameter('images_directory'),
                $fileName
            );

            $dish->setPhoto($fileName);
            
            $em = $this->getDoctrine()->getManager();
            $em->persist($dish);
            $em->flush($dish);

            return $this->redirectToRoute('administracion_dish_show', array('id' => $dish->getId()));
        }

        return $this->render('dish/new.html.twig', array(
                    'dish' => $dish,
                    'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a dish entity.
     *
     * @Route("/{id}", name="administracion_dish_show")
     * @Method("GET")
     */
    public function showAction(Dish $dish) {
        $deleteForm = $this->createDeleteForm($dish);

        return $this->render('dish/show.html.twig', array(
                    'dish' => $dish,
                    'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing dish entity.
     *
     * @Route("/{id}/edit", name="administracion_dish_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Dish $dish) {
        $deleteForm = $this->createDeleteForm($dish);
        $editForm = $this->createForm('AppBundle\Form\DishType', $dish);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            
            $file = $dish->getPhoto();

            $fileName = md5(uniqid()).'.'.$file->guessExtension();

            $file->move(
                $this->getParameter('images_directory'),
                $fileName
            );

            $dish->setPhoto($fileName);
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('administracion_dish_edit', array('id' => $dish->getId()));
        }

        return $this->render('dish/edit.html.twig', array(
                    'dish' => $dish,
                    'edit_form' => $editForm->createView(),
                    'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a dish entity.
     *
     * @Route("/{id}", name="administracion_dish_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Dish $dish) {
        $form = $this->createDeleteForm($dish);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($dish);
            $em->flush($dish);
        }

        return $this->redirectToRoute('administracion_dish_index');
    }

    /**
     * Creates a form to delete a dish entity.
     *
     * @param Dish $dish The dish entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Dish $dish) {
        return $this->createFormBuilder()
                        ->setAction($this->generateUrl('administracion_dish_delete', array('id' => $dish->getId())))
                        ->setMethod('DELETE')
                        ->getForm()
        ;
    }

}
