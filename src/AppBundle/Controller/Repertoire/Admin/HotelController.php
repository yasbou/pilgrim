<?php

namespace AppBundle\Controller\Repertoire\Admin;

use AppBundle\Entity\Repertoire\Hotel;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\File\File;


/**
 * Hotel controller.
 *
 * @Route("admin/repertoire_hotel")
 */
class HotelController extends Controller
{
    /**
     * Lists all hotel entities.
     *
     * @Route("/", name="admin_repertoire_hotel_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $hotels = $em->getRepository('AppBundle:Repertoire\Hotel')->findAll();

        return $this->render('repertoire/admin/hotel/index.html.twig', array(
            'hotels' => $hotels,
        ));
    }

    /**
     * Creates a new hotel entity.
     *
     * @Route("/new", name="admin_repertoire_hotel_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $hotel = new Hotel();
        $form = $this->createForm('AppBundle\Form\Repertoire\HotelType', $hotel);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

          $pictureName= $hotel->getImage();
          $filename= md5(uniqid()).'.'.$pictureName->guessExtension();
          $pictureName->move($this->getParameter('upload_directory'), $filename);
          $hotel->setImage($filename);

            $em = $this->getDoctrine()->getManager();
            $em->persist($hotel);
            $em->flush();

            return $this->redirectToRoute('admin_repertoire_hotel_show', array('id' => $hotel->getId()));
        }

        return $this->render('repertoire/admin/hotel/new.html.twig', array(
            'hotel' => $hotel,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a hotel entity.
     *
     * @Route("/{id}", name="admin_repertoire_hotel_show")
     * @Method("GET")
     */
    public function showAction(Hotel $hotel)
    {
        $deleteForm = $this->createDeleteForm($hotel);

        return $this->render('repertoire/admin/hotel/show.html.twig', array(
            'hotel' => $hotel,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing hotel entity.
     *
     * @Route("/{id}/edit", name="admin_repertoire_hotel_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Hotel $hotel)
    {
      $currentLogo= $hotel->getImage();
        if (!empty($hotel->getImage())) {
            $hotel->setImage(new File($this->getParameter('upload_directory').'/'.$hotel->getImage()));
        }

        $deleteForm = $this->createDeleteForm($hotel);
        $editForm = $this->createForm('AppBundle\Form\Repertoire\HotelType', $hotel);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {


          $logoname= $hotel->getImage();
          if ($logoname) {
            $filename= md5(uniqid()).'.'.$logoname->guessExtension();
            $logoname->move($this->getParameter('upload_directory'), $filename);
            $hotel->setImage($filename);
            }

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_repertoire_hotel_show', array('id' => $hotel->getId()));
        }

        return $this->render('repertoire/admin/hotel/edit.html.twig', array(
            'hotel' => $hotel,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a hotel entity.
     *
     * @Route("/{id}", name="admin_repertoire_hotel_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Hotel $hotel)
    {
        $form = $this->createDeleteForm($hotel);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($hotel);
            $em->flush();
        }

        return $this->redirectToRoute('admin_repertoire_hotel_index');
    }

    /**
     * Creates a form to delete a hotel entity.
     *
     * @param Hotel $hotel The hotel entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Hotel $hotel)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_repertoire_hotel_delete', array('id' => $hotel->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
