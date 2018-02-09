<?php

namespace AppBundle\Controller\Blog\Admin;

use AppBundle\Entity\Blog\Commentaires;
use AppBundle\Form\Blog\CommentairesType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Commentaire controller.
 *
 * @Route("admin/blog_commentaires")
 */
class CommentairesController extends Controller
{
    /**
     * Lists all commentaire entities.
     *
     * @Route("/", name="blog_commentaires_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $commentaires = $em->getRepository('AppBundle:Blog\Commentaires')->findAll();

        return $this->render('blog/commentaires/index.html.twig', array(
            'commentaires' => $commentaires,
        ));
    }

    /**
     * Creates a new commentaire entity.
     *
     * @Route("/new", name="blog_commentaires_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $commentaire = new Commentaires();
        $form = $this->createForm('AppBundle\Form\Blog\CommentairesType', $commentaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($commentaire);
            $em->flush();

            return $this->redirectToRoute('blog_commentaires_show', array('id' => $commentaire->getId()));
        }

        return $this->render('blog/commentaires/new.html.twig', array(
            'commentaire' => $commentaire,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a commentaire entity.
     *
     * @Route("/{id}", name="blog_commentaires_show")
     * @Method("GET")
     */
    public function showAction(Commentaires $commentaire)
    {
        $deleteForm = $this->createDeleteForm($commentaire);

        return $this->render('blog/commentaires/show.html.twig', array(
            'commentaire' => $commentaire,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing commentaire entity.
     *
     * @Route("/{id}/edit", name="blog_commentaires_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Commentaires $commentaire)
    {
        $deleteForm = $this->createDeleteForm($commentaire);
        $editForm = $this->createForm('AppBundle\Form\Blog\commentairesType', $commentaire);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('blog_commentaires_edit', array('id' => $commentaire->getId()));
        }

        return $this->render('blog/commentaires/edit.html.twig', array(
            'commentaire' => $commentaire,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a commentaire entity.
     *
     * @Route("/{id}", name="blog_commentaires_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Commentaires $commentaire)
    {
        $form = $this->createDeleteForm($commentaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($commentaire);
            $em->flush();
        }

        return $this->redirectToRoute('blog_commentaires_index');
    }

    /**
     * Creates a form to delete a commentaire entity.
     *
     * @param Commentaires $commentaire The commentaire entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Commentaires $commentaire)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('blog_commentaires_delete', array('id' => $commentaire->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
