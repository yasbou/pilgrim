<?php

namespace AppBundle\Controller\Blog;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Blog\Post;
use AppBundle\Entity\Blog\Commentaires;
use AppBundle\Entity\Blog\Categories;

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
}
