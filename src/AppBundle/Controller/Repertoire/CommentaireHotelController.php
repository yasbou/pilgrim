<?php

namespace AppBundle\Controller\Repertoire;

use AppBundle\Entity\Repertoire\CommentaireHotel;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Commentairehotel controller.
 *
 * @Route("admin/repertoire_commentairehotel")
 */
class CommentaireHotelController extends Controller
{
    /**
     * Lists all commentaireHotel entities.
     *
     * @Route("/", name="admin_repertoire_commentairehotel_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $commentaireHotels = $em->getRepository('AppBundle:Repertoire\CommentaireHotel')->findAll();

        return $this->render('repertoire/commentairehotel/index.html.twig', array(
            'commentaireHotels' => $commentaireHotels,
        ));
    }

    /**
     * Creates a new commentaireHotel entity.
     *
     * @Route("/new", name="admin_repertoire_commentairehotel_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $commentaireHotel = new Commentairehotel();
        $form = $this->createForm('AppBundle\Form\Repertoire\CommentaireHotelType', $commentaireHotel);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($commentaireHotel);
            $em->flush();

            return $this->redirectToRoute('admin_repertoire_commentairehotel_show', array('id' => $commentaireHotel->getId()));
        }

        return $this->render('repertoire/commentairehotel/new.html.twig', array(
            'commentaireHotel' => $commentaireHotel,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a commentaireHotel entity.
     *
     * @Route("/{id}", name="admin_repertoire_commentairehotel_show")
     * @Method("GET")
     */
    public function showAction(CommentaireHotel $commentaireHotel)
    {
        $deleteForm = $this->createDeleteForm($commentaireHotel);

        return $this->render('repertoire/commentairehotel/show.html.twig', array(
            'commentaireHotel' => $commentaireHotel,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing commentaireHotel entity.
     *
     * @Route("/{id}/edit", name="admin_repertoire_commentairehotel_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, CommentaireHotel $commentaireHotel)
    {
        $deleteForm = $this->createDeleteForm($commentaireHotel);
        $editForm = $this->createForm('AppBundle\Form\Repertoire\CommentaireHotelType', $commentaireHotel);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_repertoire_commentairehotel_edit', array('id' => $commentaireHotel->getId()));
        }

        return $this->render('repertoire/commentairehotel/edit.html.twig', array(
            'commentaireHotel' => $commentaireHotel,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a commentaireHotel entity.
     *
     * @Route("/{id}", name="admin_repertoire_commentairehotel_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, CommentaireHotel $commentaireHotel)
    {
        $form = $this->createDeleteForm($commentaireHotel);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($commentaireHotel);
            $em->flush();
        }

        return $this->redirectToRoute('admin_repertoire_commentairehotel_index');
    }

    /**
     * Creates a form to delete a commentaireHotel entity.
     *
     * @param CommentaireHotel $commentaireHotel The commentaireHotel entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(CommentaireHotel $commentaireHotel)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_repertoire_commentairehotel_delete', array('id' => $commentaireHotel->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
