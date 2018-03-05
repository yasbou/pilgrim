<?php
namespace AppBundle\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use AppBundle\Entity\User;
use Symfony\Component\HttpFoundation\Response;

class SecurityController extends Controller
{

    /**
     * @Route("/login", name="login")
     */
    public function loginAction(Request $request, AuthenticationUtils $authUtils)
    {

        $authenticationUtils = $this->get('security.authentication_utils');
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();
        return $this->render('log_form/login.html.twig', array(
            'last_username' => $lastUsername,
            'error'         => $error,
        ));
    }


/**
 * @Route("/resetpassword", name="resetpassword")
 */
public function resetpasswordAction(Request $request, UserPasswordEncoderInterface $encoder, SessionInterface $session)
{
  $form = $this->createForm('AppBundle\Form\ResetpassType');
  $form->handleRequest($request);
  if ($form->isSubmitted() && $form->isValid()) {

    $userEmail= $form->get('Email')->getData();
    $user = $this->getDoctrine()->getRepository(User::class)->findOneBy(array('email' => $userEmail));

    if ($user){

      $char = 'abcdefghijklmnopqrstuvwxyz0123456789';
      $Pass = str_shuffle($char);
      $Password = substr($Pass, 8);

    $encoded = $encoder->encodePassword($user, $Password);
    $user->setPassword($encoded);
    $em = $this->getDoctrine()->getManager();
    $em->persist($user);
    $em->flush();

    $session->getFlashBag()->add('warning','Votre nouveau mot de passe est disponible sur botre boite mail. merci.');
    foreach ($session->getFlashBag()->get('warning', array()) as $message) {
    echo '<div class="alert alert-success">'.$message.' </div>';}

    $myappContactMail = $userEmail;



    $transport = \Swift_SmtpTransport::newInstance()
      ->setUsername('yassko77@hotmail.com')->setPassword('muslim77')
      ->setHost('smtp-mail.outlook.com')
      ->setPort(587)->setEncryption('tls');

      $mailer = \Swift_Mailer::newInstance($transport);

  $message = \Swift_Message::newInstance('votre nouveau mot de passe pilgrim')
  ->setFrom(array($myappContactMail => "Message by Pilgrim.com"))
  ->setTo(array(
      $myappContactMail => $myappContactMail
  ))
  ->setBody('votre nouveau mot de passe:'.$Password );

  $mailer->send($message);


  }
    else {
      $session->getFlashBag()->add('error', 'Je suis désolé, indentifant incorrect!!!');
      foreach ($session->getFlashBag()->get('error', array()) as $message) {
echo '<div class="alert alert-danger">'.$message.'</div>';}
    };
  }

  $form2 = $this->createForm('AppBundle\Form\ChangepasswordType');
  $form2->handleRequest($request);



    if ($form2->isSubmitted() && $form2->isValid()) {
      $user= $this->get('security.token_storage')->getToken()->getUser();

      $username = $user->getUsername();
      $email= $user->getEmail();
      $newpass= $form2->get('newpassword')->getData();
      $name= $form2->get('username')->getData();
      $mail= $form2->get('Email')->getData();

        if ($username==$name && $email==$mail) {
      $encoded = $encoder->encodePassword($user, $newpass);
      // Sauvegarde du nouveau mot de passe
      $user->setPassword($encoded);
      $this->getDoctrine()->getManager()->flush();
      return $this->redirectToRoute('homepage');
      }

        else {
          $session->getFlashBag()->add('error', 'Je suis désolé, indentifant incorrect!!!');
          foreach ($session->getFlashBag()->get('error', array()) as $message) {
    echo '<div class="alert alert-danger">'.$message.'</div>';}
        };
    }

  return $this->render('log_form/resetpass.html.twig', [
      'form' => $form->createView(),
      'form2' => $form2->createView(),
  ]);

}

}
