<?php

namespace AppBundle\Controller\Home;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Galerie;
use AppBundle\Entity\Info\Info;


class HomeController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('home/index.html.twig');
    }

    /**
     * @Route("/admin", name="admin")
     */
    public function adminAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('admin/index.html.twig');
    }

    /**
     * @Route("/taux/", name="taux")
     */
    public function tauxAction(Request $request)
    {
      $code=file_get_contents('http://www.xe.com/fr/currencyconverter/convert/?Amount=1&From=EUR&To=SAR');
      preg_match('`([0-9.]+) SAR`i', $code, $devise);
      $codes= 4+ $devise[1]/100000;
        // replace this example code with whatever you need
        return $this->json($codes);
    }

    /**
     * @Route("/convertisseur/", name="convertisseur")
     */
     public function convertAction(Request $request)
     {
       return $this->render('widget/convertisseur.html.twig');
     }

     /**
      * @Route("/mention_legale/", name="mention_legale")
      */
      public function mentionAction(Request $request)
      {
        return $this->render('home/mention.html.twig');
      }

      /**
       * @Route("/galerie/", name="galerie")
       */
       public function galerieAction(Request $request)
       {
           $picture = $this->getDoctrine()->getRepository(Galerie::class)->findAll();
           $infos = $this->getDoctrine()->getRepository(Info::class)->findAll();
         return $this->render('info/galerie.html.twig', [
           'picture' => $picture,
           'infos' => $infos,
         ]);
       }
}
