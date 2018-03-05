<?php

namespace AppBundle\Controller\Home;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

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
}
