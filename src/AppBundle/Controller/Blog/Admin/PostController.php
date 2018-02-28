<?php

namespace AppBundle\Controller\Blog\Admin;

use AppBundle\Entity\Blog\Post;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\File\File;

/**
 * Post controller.
 *
 * @Route("admin/blog_post")
 */
class PostController extends Controller
{
    /**
     * Lists all post entities.
     *
     * @Route("/", name="blog_post_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $posts = $em->getRepository('AppBundle:Blog\Post')->findAll();

        return $this->render('blog/post/index.html.twig', array(
            'posts' => $posts,
        ));
    }

    /**
     * Creates a new post entity.
     *
     * @Route("/new", name="blog_post_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $post = new Post();
        $form = $this->createForm('AppBundle\Form\Blog\PostType', $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

          $pictureName= $post->getImage();
          $filename= md5(uniqid()).'.'.$pictureName->guessExtension();
          $pictureName->move($this->getParameter('upload_directory'), $filename);
          $post->setImage($filename);


            $em = $this->getDoctrine()->getManager();
            $em->persist($post);
            $em->flush();

            return $this->redirectToRoute('blog_post_show', array('id' => $post->getId()));
        }

        return $this->render('blog/post/new.html.twig', array(
            'post' => $post,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a post entity.
     *
     * @Route("/{id}", name="blog_post_show")
     * @Method("GET")
     */
    public function showAction(Post $post)
    {
        $deleteForm = $this->createDeleteForm($post);

        return $this->render('blog/post/show.html.twig', array(
            'post' => $post,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing post entity.
     *
     * @Route("/{id}/edit", name="blog_post_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Post $post)
    {
      $currentLogo= $post->getImage();
        if (!empty($post->getImage())) {
            $post->setImage(new File($this->getParameter('upload_directory').'/'.$post->getImage()));
        }

        $deleteForm = $this->createDeleteForm($post);
        $editForm = $this->createForm('AppBundle\Form\Blog\PostType', $post);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {

          $logoname= $post->getImage();
          if ($logoname) {
            $filename= md5(uniqid()).'.'.$logoname->guessExtension();
            $logoname->move($this->getParameter('upload_directory'), $filename);
            $post->setImage($filename);
            }


            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('blog_post_show', array('id' => $post->getId()));
        }

        return $this->render('blog/post/edit.html.twig', array(
            'post' => $post,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a post entity.
     *
     * @Route("/{id}", name="blog_post_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Post $post)
    {
        $form = $this->createDeleteForm($post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($post);
            $em->flush();
        }

        return $this->redirectToRoute('blog_post_index');
    }

    /**
     * Creates a form to delete a post entity.
     *
     * @param Post $post The post entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Post $post)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('blog_post_delete', array('id' => $post->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
