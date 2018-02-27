<?php
namespace AppBundle\Controller\Repertoire;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Repertoire\Agence;
use AppBundle\Entity\Repertoire\Region;
use AppBundle\Entity\Repertoire\Hotel;
use AppBundle\Entity\Repertoire\commentaireHotel;
use AppBundle\Entity\Repertoire\Ville;





class HomeRepertoireController extends Controller
{

  /**
   * @Route("/repertoire/", name="home_repertoire")
   */
  public function indexAction(Request $request)
  {
    $region = $this->getDoctrine()->getRepository(Region::class)->findAll();
    $ville= $this->getDoctrine()->getRepository(Ville::class)->findAll();

      // replace this example code with whatever you need
      return $this->render('repertoire/indexrep.html.twig', [
      'region' =>  $region,
      'ville' => $ville,
      ]);
  }


  /**
   * @Route("/repertoire/list/Agence/{page}", requirements={"page" = "\d+"}, name="list_agence")
   */
  public function listAgenceAction(Request $request, $page){

    $nbArticlesParPage = $this->container->getParameter('front_nb_agences_par_page');

       $em = $this->getDoctrine()->getManager();

       $agences = $em->getRepository(Agence::class)
           ->findAllPagineEtTrie($page, $nbArticlesParPage);

       $pagination = array(
           'page' => $page,
           'nbPages' => ceil(count($agences) / $nbArticlesParPage),
           'nomRoute' => 'front_articles_index',
           'paramsRoute' => array()
       );

    $region = $this->getDoctrine()->getRepository(Region::class)->findAll();
    $ville= $this->getDoctrine()->getRepository(Ville::class)->findAll();


    return $this->render('repertoire/list_agence.html.twig', [
    'region' =>  $region,
    'ville' => $ville,
    'agences'=> $agences,
    'pagination' => $pagination
    ]);
  }


  /**
   * @Route("/repertoire/list/Hotel/{page}", requirements={"page" = "\d+"}, name="list_hotel")
   */
  public function listHotelAction(Request $request, $page){

    $nbArticlesParPage = $this->container->getParameter('front_nb_hotels_par_page');

       $em = $this->getDoctrine()->getManager();

       $hotels = $em->getRepository(Hotel::class)
           ->findAllPagineEtTrie($page, $nbArticlesParPage);

       $pagination = array(
           'page' => $page,
           'nbPages' => ceil(count($hotels) / $nbArticlesParPage),
           'nomRoute' => 'front_articles_index',
           'paramsRoute' => array()
       );


    $region = $this->getDoctrine()->getRepository(Region::class)->findAll();
    $ville= $this->getDoctrine()->getRepository(Ville::class)->findAll();
    return $this->render('repertoire/list_hotel.html.twig', [
    'region' =>  $region,
    'ville' => $ville,
    'hotels' => $hotels,
    'pagination' => $pagination
    ]);
  }



}
