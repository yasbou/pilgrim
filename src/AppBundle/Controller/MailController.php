<?php
namespace AppBundle\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
class MailController extends Controller
{

  public function simplemailAction(Request $request)
    {

  // Create the form according to the FormType created previously.
          // And give the proper parameters
          $form = $this->createForm('AppBundle\Form\ContactType',null,array(
              // To set the action use $this->generateUrl('route_identifier')
              'action' => $this->generateUrl('myapplication_contact'),
              'method' => 'POST'
          ));

          if ($request->isMethod('POST')) {
              // Refill the fields in case the form is not valid.
              $form->handleRequest($request);

              if($form->isValid()){
                $data = $form->getData();
                  // Send mail
                  if($this->sendEmail($data)){

                      // Everything OK, redirect to wherever you want ! :

                      return $this->redirectToRoute('myapplication_contact');
                  }else{
                      // An error ocurred, handle
                      var_dump("Errooooor :(");
                  }
              }
          }

          return $this->render('Emails/simple_mail.html.twig', array(
              'form' => $form->createView()
          ));
      }

      private function sendEmail($data){
          $myappContactMail = 'yassko77@hotmail.com';
          $myappContactPassword = 'muslim77';

          // In this case we'll use the ZOHO mail services.
          // If your service is another, then read the following article to know which smpt code to use and which port
          // http://ourcodeworld.com/articles/read/14/swiftmailer-send-mails-from-php-easily-and-effortlessly
          $transport = \Swift_SmtpTransport::newInstance()
            ->setUsername('yassko77@hotmail.com')->setPassword('muslim77')
            ->setHost('smtp-mail.outlook.com')
            ->setPort(587)->setEncryption('tls');

            $mailer = \Swift_Mailer::newInstance($transport);

        $message = \Swift_Message::newInstance('message pilgrim de '.$data["email"]."//". $data["subject"])
        ->setFrom(array($myappContactMail => "Message by ".$data["name"]))
        ->setTo(array(
            $myappContactMail => $myappContactMail
        ))
        ->setBody($data['name'].' vous dit : '.$data["message"]);

        return $mailer->send($message);
    }
  }
