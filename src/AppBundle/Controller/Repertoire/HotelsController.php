<?php
namespace AppBundle\Controller\Repertoire;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Repertoire\Agence;
use AppBundle\Entity\Repertoire\Region;
use AppBundle\Entity\Repertoire\Hotel;
use AppBundle\Entity\Repertoire\CommentaireHotel;
use AppBundle\Entity\Repertoire\Ville;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;





class HotelsController extends Controller
{

  /**
   * @Route("/repertoire/Hotel/{id}", name="hotel_details")
   */
  public function detailsAction(Request $request, Hotel $hotel, $id)
  {



    $region = $this->getDoctrine()->getRepository(Region::class)->findAll();
    $ville= $this->getDoctrine()->getRepository(Ville::class)->findAll();

      // replace this example code with whatever you need
      return $this->render('repertoire/hotel_details.html.twig', [
      'region' =>  $region,
      'ville' => $ville,
      'hotel' => $hotel,
      ]);
  }


  /**
   * @Route("/repertoire/Hotel/", name="hotel_commentaire")
   *@Method("POST")
   */
  public function commentaireAction(Request $request)
  {

    $commentaire = new CommentaireHotel();

    //$params = $request->getRequestUri();
    //$test= $params{strlen($params)-1};
    //$test2= intval($test);
    //$id= $test2;

    $com =  $request->getcontent();

    $number= substr($com, 0);
    $texte= substr($com, 1);
    $id= intval($number);




     $user = $this->getUser();
    $username = $user->getUsername();


   $hotel = $this->getDoctrine()->getRepository(Hotel::class)->findById($id);



     $datetime = time();
     $commentaire->setAuteur($username);
     $commentaire->setDate($datetime);
     $commentaire->setCommentaire($texte);
     $commentaire->setHotel($hotel['0']);




       $em = $this->getDoctrine()->getManager();
       $em->persist($commentaire);
       $em->flush();

       return $this->render('blog/com.html.twig');



  }




}
