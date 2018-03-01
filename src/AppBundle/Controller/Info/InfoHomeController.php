<?php

namespace AppBundle\Controller\Info;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Info\Info;
use AppBundle\Service\Contact;

class InfoHomeController extends Controller
{
    /**
     * @Route("/info/", name="home_info")
     */
    public function indexAction(Request $request)
    {

      $infos = $this->getDoctrine()->getRepository(Info::class)->findAll();
        // replace this example code with whatever you need
        return $this->render('info/info_home.html.twig', [
          'infos' => $infos,
        ]);
    }

    /**
     * @Route("/info/{id}", name="show_info")
     */
    public function showInfoAction(Request $request, $id, Info $info){

      $infos = $this->getDoctrine()->getRepository(Info::class)->findAll();

        return $this->render('info/info_show.html.twig', [
          'info' => $info,
          'infos' => $infos,

        ]);
    }

}
