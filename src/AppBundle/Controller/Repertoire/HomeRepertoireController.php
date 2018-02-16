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
   * @Route("/repertoire/list/Agence/", name="list_agence")
   */
  public function listAgenceAction(Request $request){
    $region = $this->getDoctrine()->getRepository(Region::class)->findAll();
    $ville= $this->getDoctrine()->getRepository(Ville::class)->findAll();

    return $this->render('repertoire/list_agence.html.twig', [
    'region' =>  $region,
    'ville' => $ville,
    ]);
  }


  /**
   * @Route("/repertoire/list/Hotel/", name="list_hotel")
   */
  public function listHotelAction(Request $request){
    $region = $this->getDoctrine()->getRepository(Region::class)->findAll();
    $ville= $this->getDoctrine()->getRepository(Ville::class)->findAll();

    return $this->render('repertoire/list_hotel.html.twig', [
    'region' =>  $region,
    'ville' => $ville,
    ]);
  }

  /**
   * @Route("/repertoire/{id}/agence//", name="list_by_region")
   */
  public function listRegionAction(Request $request, Region $regions, $id){
    $region = $this->getDoctrine()->getRepository(Region::class)->findAll();
    $ville= $this->getDoctrine()->getRepository(Ville::class)->findAll();
    $agence= $this->getDoctrine()->getRepository(Agence::class)->findAll();


    return $this->render('repertoire/list_by_region.html.twig', [
    'region' =>  $region,
    'ville' => $ville,
    'agence' => $agence,
    'regions'=> $regions
    ]);
  }


  /**
   * @Route("/repertoire/ville/{id}/", name="list_by_ville")
   */
  public function listVilleAction(Request $request, Ville $villes,  $id){
    $region = $this->getDoctrine()->getRepository(Region::class)->findAll();
    $ville= $this->getDoctrine()->getRepository(Ville::class)->findAll();
    $hotel= $this->getDoctrine()->getRepository(Hotel::class)->findAll();


    return $this->render('repertoire/list_by_ville.html.twig', [
    'region' =>  $region,
    'ville' => $ville,
    'hotel' => $hotel,
    'villes'=> $villes,
    ]);
  }

}
