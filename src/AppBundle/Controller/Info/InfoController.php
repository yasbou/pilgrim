<?php

namespace AppBundle\Controller\Info;

use AppBundle\Entity\Info\Info;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\File\File;

/**
 * Info controller.
 *
 * @Route("admin/info_info")
 */
class InfoController extends Controller
{
    /**
     * Lists all info entities.
     *
     * @Route("/", name="admin_info_info_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $infos = $em->getRepository('AppBundle:Info\Info')->findAll();

        return $this->render('info/info/index.html.twig', array(
            'infos' => $infos,
        ));
    }

    /**
     * Creates a new info entity.
     *
     * @Route("/new", name="admin_info_info_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $info = new Info();
        $form = $this->createForm('AppBundle\Form\Info\InfoType', $info);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

          $pictureName= $info->getImage();
          $filename= md5(uniqid()).'.'.$pictureName->guessExtension();
          $pictureName->move($this->getParameter('upload_directory'), $filename);
          $info->setImage($filename);

            $em = $this->getDoctrine()->getManager();
            $em->persist($info);
            $em->flush();

            return $this->redirectToRoute('admin_info_info_show', array('id' => $info->getId()));
        }

        return $this->render('info/info/new.html.twig', array(
            'info' => $info,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a info entity.
     *
     * @Route("/{id}", name="admin_info_info_show")
     * @Method("GET")
     */
    public function showAction(Info $info)
    {
        $deleteForm = $this->createDeleteForm($info);

        return $this->render('info/info/show.html.twig', array(
            'info' => $info,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing info entity.
     *
     * @Route("/{id}/edit", name="admin_info_info_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Info $info)
    {
      $currentLogo= $info->getImage();
        if (!empty($info->getImage())) {
            $info->setImage(new File($this->getParameter('upload_directory').'/'.$info->getImage()));
        }


        $deleteForm = $this->createDeleteForm($info);
        $editForm = $this->createForm('AppBundle\Form\Info\InfoType', $info);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {

          $logoname= $info->getImage();
          if ($logoname) {
            $filename= md5(uniqid()).'.'.$logoname->guessExtension();
            $logoname->move($this->getParameter('upload_directory'), $filename);
            $info->setImage($filename);
            }

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_info_info_show', array('id' => $info->getId()));
        }

        return $this->render('info/info/edit.html.twig', array(
            'info' => $info,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a info entity.
     *
     * @Route("/{id}", name="admin_info_info_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Info $info)
    {
        $form = $this->createDeleteForm($info);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($info);
            $em->flush();
        }

        return $this->redirectToRoute('admin_info_info_index');
    }

    /**
     * Creates a form to delete a info entity.
     *
     * @param Info $info The info entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Info $info)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_info_info_delete', array('id' => $info->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
