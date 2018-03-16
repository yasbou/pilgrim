<?php

namespace AppBundle\Controller\Blog;

use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
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
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use JMS\Serializer\SerializerBuilder;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\BrowserKit\Cookie;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;

class HomeBlogController extends Controller
{
    /**
     * @Route("/blog/list_article/{page}", name="homeBlogpage")
     */
    public function BlogHomeAction(Request $request, $page)
    {
      $nbArticlesParPage = $this->container->getParameter('front_nb_post_par_page');
        $em = $this->getDoctrine()->getManager();

        $posts = $em->getRepository(Post::class)
            ->findAllPagineEtTrie($page, $nbArticlesParPage);
        $categories= $this->getDoctrine()->getRepository(Categories::class)->findAll();

        $pagination = array(
            'page' => $page,
            'nbPages' => ceil(count($posts) / $nbArticlesParPage),
            'nomRoute' => 'front_articles_index',
            'paramsRoute' => array()
        );



        return $this->render('blog/index.html.twig', [
          'posts' => $posts,
          'categories'=>$categories,
          'pagination' => $pagination,
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
     * @Route("/blog/categorie/{id}/{page}", name="categories")
     */
    public function BlogcategoriesAction(Request $request, Categories $categorie, $id, $page)
    {


      $nbArticlesParPage = $this->container->getParameter('front_nb_post_par_page');

         $em = $this->getDoctrine()->getManager();

         $posts = $em->getRepository(Post::class)
             ->findByIdPagineEtTrie($page, $nbArticlesParPage, $id);

         $pagination = array(
             'page' => $page,
             'nbPages' => ceil(count($posts) / $nbArticlesParPage),
             'nomRoute' => 'front_articles_index',
             'paramsRoute' => array()
         );


        $categories = $this->getDoctrine()->getRepository(Categories::class)->findAll();
        $post= $this->getDoctrine()->getRepository(Post::class)->findAll();



        return $this->render('blog/categories.html.twig', [
          'categories' => $categories,
          'posts' => $posts,
          'categorie'=>$categorie,
          'post' => $post,
          'pagination'=> $pagination,
          'id' => $id
        ]);
    }



    /**
     * @Route("/blog/contact", name="contact")
     */
    public function BlogcontactAction()
    {
        $posts = $this->getDoctrine()->getRepository(Post::class)->findAll();
        $categories= $this->getDoctrine()->getRepository(Categories::class)->findAll();



        return $this->render('blog/contact.html.twig', [
          'posts' => $posts,
          'categories'=>$categories,
        ]);
    }



    /**
     * @Route("/logup/{id}", name="logup")
     */
    public function prestataireAction(Request $request, UserPasswordEncoderInterface $encoder, $id)
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

            $token = new UsernamePasswordToken($user, null, 'main', $user->getRoles());
            $this->get('security.token_storage')->setToken($token);

        // If the firewall name is not main, then the set value would be instead:
        // $this->get('session')->set('_security_XXXFIREWALLNAMEXXX', serialize($token));
          $this->get('session')->set('_security_main', serialize($token));

        // Fire the login event manually
          $event = new InteractiveLoginEvent($request, $token);
          $this->get("event_dispatcher")->dispatch("security.interactive_login", $event);



            return $this->redirectToRoute('commentaires', array('id' => $id));
        }
        return $this->render('log_form/logup.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }




    /**
     * @Route("/blog/commentaires/register", name="commentaires_register")
     * @Method("POST")
     */

     public function comAction(SessionInterface $session, Request $request){




       $commentaire = new Commentaires();

       //$params = $request->getRequestUri();
       //$test= $params{strlen($params)-1};
       //$test2= intval($test);
       //$id= $test2;

       $com =  $request->getcontent();

       $number= substr($com, 0);
       $texte= stristr($com, "/");
       $id= intval($number);




        $user = $this->getUser();
        $username = $user->getUsername();


      $post = $this->getDoctrine()->getRepository(Post::class)->findById($id);



        $datetime = time();
        $commentaire->setAuteurCom($username);
        $commentaire->setDatecom($datetime);
        $commentaire->setTextCom($texte);
        $commentaire->setPosts($post['0']);




          $em = $this->getDoctrine()->getManager();
          $em->persist($commentaire);
          $em->flush();

          return $this->render('blog/com.html.twig');

     }

     /**
      * @Route("/blog/commentaires/{id}", name="commentaires")
      */
     public function commentairesAction(SessionInterface $session, EntityManagerInterface $em, Request $request, $id)
     {


     $posts = $this->getDoctrine()->getRepository(Post::class)->findById($id);
     $categories= $this->getDoctrine()->getRepository(Categories::class)->findById($id);
     $commentaires= $this->getDoctrine()->getRepository(Commentaires::class)->findById($id);



     return $this->render('blog/commentaires.html.twig', [
     'posts' => $posts,
     'categories'=>$categories,

     ]);

     }



}
