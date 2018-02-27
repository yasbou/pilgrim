<?php

namespace AppBundle\Controller\Repertoire\Admin;

use AppBundle\Entity\Repertoire\Agence;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Agence controller.
 *
 * @Route("admin/repertoire_agence")
 */
class AgenceController extends Controller
{
    /**
     * Lists all agence entities.
     *
     * @Route("/", name="admin_repertoire_agence_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $agences = $em->getRepository('AppBundle:Repertoire\Agence')->findAll();

        return $this->render('repertoire/admin/agence/index.html.twig', array(
            'agences' => $agences,
        ));
    }

    /**
     * Creates a new agence entity.
     *
     * @Route("/new", name="admin_repertoire_agence_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $agence = new Agence();
        $form = $this->createForm('AppBundle\Form\Repertoire\AgenceType', $agence);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($agence);
            $em->flush();

            return $this->redirectToRoute('admin_repertoire_agence_show', array('id' => $agence->getId()));
        }

        return $this->render('repertoire/admin/agence/new.html.twig', array(
            'agence' => $agence,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a agence entity.
     *
     * @Route("/{id}", name="admin_repertoire_agence_show")
     * @Method("GET")
     */
    public function showAction(Agence $agence)
    {
        $deleteForm = $this->createDeleteForm($agence);

        return $this->render('repertoire/admin/agence/show.html.twig', array(
            'agence' => $agence,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing agence entity.
     *
     * @Route("/{id}/edit", name="admin_repertoire_agence_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Agence $agence)
    {
        $deleteForm = $this->createDeleteForm($agence);
        $editForm = $this->createForm('AppBundle\Form\Repertoire\AgenceType', $agence);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_repertoire_agence_edit', array('id' => $agence->getId()));
        }

        return $this->render('repertoire/admin/agence/edit.html.twig', array(
            'agence' => $agence,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a agence entity.
     *
     * @Route("/{id}", name="admin_repertoire_agence_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Agence $agence)
    {
        $form = $this->createDeleteForm($agence);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($agence);
            $em->flush();
        }

        return $this->redirectToRoute('admin_repertoire_agence_index');
    }

    /**
     * Creates a form to delete a agence entity.
     *
     * @param Agence $agence The agence entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Agence $agence)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_repertoire_agence_delete', array('id' => $agence->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
