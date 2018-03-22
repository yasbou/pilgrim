<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Galerie;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Galerie controller.
 *
 * @Route("admin/galerie")
 */
class GalerieController extends Controller
{
    /**
     * Lists all galerie entities.
     *
     * @Route("/", name="galerie_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $galeries = $em->getRepository(Galerie::class)->findAll();

        return $this->render('galerie/index.html.twig', array(
            'galeries' => $galeries,
        ));
    }

    /**
     * Creates a new galerie entity.
     *
     * @Route("/new", name="galerie_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $galerie = new Galerie();
        $form = $this->createForm('AppBundle\Form\galerieType', $galerie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

          $pictureName= $galerie->getPictureName();
          $filename= md5(uniqid()).'.'.$pictureName->guessExtension();
          $pictureName->move($this->getParameter('upload_directory'), $filename);
          $galerie->setPictureName($filename);

            $em = $this->getDoctrine()->getManager();
            $em->persist($galerie);
            $em->flush();

            return $this->redirectToRoute('galerie_show', array('id' => $galerie->getId()));
        }

        return $this->render('galerie/new.html.twig', array(
            'galerie' => $galerie,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a galerie entity.
     *
     * @Route("/{id}", name="galerie_show")
     * @Method("GET")
     */
    public function showAction(Galerie $galerie)
    {
        $deleteForm = $this->createDeleteForm($galerie);

        return $this->render('galerie/show.html.twig', array(
            'galerie' => $galerie,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing galerie entity.
     *
     * @Route("/{id}/edit", name="galerie_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Galerie $galerie)
    {
        $deleteForm = $this->createDeleteForm($galerie);
        $editForm = $this->createForm('AppBundle\Form\galerieType', $galerie);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('galerie_edit', array('id' => $galerie->getId()));
        }

        return $this->render('galerie/edit.html.twig', array(
            'galerie' => $galerie,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a galerie entity.
     *
     * @Route("/{id}", name="galerie_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Galerie $galerie)
    {
        $form = $this->createDeleteForm($galerie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($galerie);
            $em->flush();
        }

        return $this->redirectToRoute('galerie_index');
    }

    /**
     * Creates a form to delete a galerie entity.
     *
     * @param galerie $galerie The galerie entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Galerie $galerie)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('galerie_delete', array('id' => $galerie->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
