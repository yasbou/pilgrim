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





class RepertoireController extends Controller
{

  /**
   * @Route("/repertoire/{id}/agence/{page}", requirements={"page" = "\d+"}, name="list_by_region")
   */
  public function listRegionAction(Request $request, $id, $page){

    $region = $this->getDoctrine()->getRepository(Region::class)->findAll();
    $ville= $this->getDoctrine()->getRepository(Ville::class)->findAll();
    $nbArticlesParPage = $this->container->getParameter('front_nb_agences_par_page');

       $em = $this->getDoctrine()->getManager();

       $agence = $em->getRepository(Agence::class)
           ->findByIdPagineEtTrie($page, $nbArticlesParPage, $id);



       $pagination = array(
           'page' => $page,
           'nbPages' => ceil(count($agence)/$nbArticlesParPage),
           'nomRoute' => 'list_by_region',
           'paramsRoute' => array()
       );


    $region = $this->getDoctrine()->getRepository(Region::class)->findAll();
    $ville= $this->getDoctrine()->getRepository(Ville::class)->findAll();



    return $this->render('repertoire/list_by_region.html.twig', [
    'region' =>  $region,
    'ville' => $ville,
    'pagination' => $pagination,
    'id' => $id,
    'agence' => $agence,
    ]);
  }


  /**
   * @Route("/repertoire/ville/{id}/{page}", requirements={"page" = "\d+"}, name="list_by_ville")
   */
  public function listVilleAction(Request $request, $page, $id){

    $nbArticlesParPage = $this->container->getParameter('front_nb_hotels_par_page');

       $em = $this->getDoctrine()->getManager();

       $hotels = $em->getRepository(Hotel::class)
           ->findByIdPagineEtTrie($page, $nbArticlesParPage, $id);

       $pagination = array(
           'page' => $page,
           'nbPages' => ceil(count($hotels) / $nbArticlesParPage),
           'nomRoute' => 'front_articles_index',
           'paramsRoute' => array()
       );




    $region = $this->getDoctrine()->getRepository(Region::class)->findAll();
    $ville= $this->getDoctrine()->getRepository(Ville::class)->findAll();
    $hotel= $this->getDoctrine()->getRepository(Hotel::class)->findAll();


    return $this->render('repertoire/list_by_ville.html.twig', [
    'region' =>  $region,
    'ville' => $ville,
    'hotel' => $hotel,
    'hotels'=> $hotels,
    'pagination' => $pagination,
    'id' => $id,
    ]);
  }
}
