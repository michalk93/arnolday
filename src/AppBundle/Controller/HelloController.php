<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class HelloController extends Controller
{
    /**
     * @Route("index", name="index")
     */
    public function indexAction(){
        return $this->render('AppBundle:default:hello.html.twig');
    }
}
