<?php

 namespace AppBundle\Controller;

 use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
 use Symfony\Bundle\FrameworkBundle\Controller\Controller;
 use Symfony\Component\HttpFoundation\Response;

 class DefaultController extends Controller {

    /**
     * @Route("/app/example", name="homepage")
     */
    public function indexAction() {
       
    }

    /**
     * @Route("/mail", name="mail")
     */
    public function mailAction() {
       $mailer = $this->get('mailer');
       $appName = $this->container->getParameter('app_name');
       $mailerFrom = $this->container->getParameter('mailer_from');
       $message = $mailer->createMessage()
               ->setSubject('Arnolday - test wysyłki emaili')
               ->setFrom(array($mailerFrom => $appName))
               ->setTo($this->getUser()->getEmail())
               ->setBody('To jest testowa wiadomość', 'text/html')
       ;
       $mailer->send($message);
       return new Response('Mail test');
    }

 }
 