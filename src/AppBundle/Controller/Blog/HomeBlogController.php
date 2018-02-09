<?php

namespace AppBundle\Controller\Blog;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\File\File;
use AppBundle\Entity\Blog\Post;
use AppBundle\Entity\Blog\Commentaires;
use AppBundle\Entity\Blog\Categories;
use AppBundle\Form\Blog\CommentaireShowType;
use AppBundle\Entity\User;
use AppBundle\Entity\Roles;
use AppBundle\Form\UserLogupType;

class HomeBlogController extends Controller
{
    /**
     * @Route("/blog", name="homeBlogpage")
     */
    public function BlogHomeAction()
    {
        $posts = $this->getDoctrine()->getRepository(Post::class)->findAll();
        $categories= $this->getDoctrine()->getRepository(Categories::class)->findAll();



        return $this->render('blog/index.html.twig', [
          'posts' => $posts,
          'categories'=>$categories,
        ]);
    }


    /**
     * @Route("/blog/{id}/show", name="show")
     */
    public function showAction(Request $request, Post $post, User $user, $id){

      $commentaire = new Commentaires();
      $form = $this->createForm('AppBundle\Form\Blog\CommentaireShowType', $commentaire);
      $form->handleRequest($request);

      if ($form->isSubmitted() && $form->isValid()) {

        $user = $this->getUser();
        $username = $user->getUsername();

        $datetime = time();
        $commentaire->setAuteurCom($username);
        $commentaire->setDatecom($datetime);
        $commentaire->setPosts($post);


          $em = $this->getDoctrine()->getManager();
          $em->persist($commentaire);
          $em->flush();

      }

      $posts = $this->getDoctrine()->getRepository(Post::class)->findById($id);
      $categories= $this->getDoctrine()->getRepository(Categories::class)->findById($id);
      $commentaires= $this->getDoctrine()->getRepository(Commentaires::class)->findById($id);

      return $this->render('blog/show.html.twig', [
        'posts' => $posts,
        'categories'=>$categories,
        'commentaires' => $commentaires,
        'form' => $form->createView(),
      ]);
    }


    /**
     * @Route("/logup", name="logup")
     */
    public function prestataireAction(Request $request, UserPasswordEncoderInterface $encoder)
    {
        $user = new User();
        $form = $this->createForm('AppBundle\Form\UserLogupType', $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $plainPassword = $user->getPassword();
            $encoded = $encoder->encodePassword($user, $plainPassword);
            $user->setPassword($encoded);
            $user->setIsActive('1');

            $roleUser = $this->getDoctrine()->getRepository(Roles::class)->findById(2);
            $user->setRole($roleUser['0']);


            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
            return $this->redirectToRoute('show', array('id' => $user->getId()));
        }
        return $this->render('log_form/logup.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }




}
