<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\Serializer\Encoder\JsonEncode;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;
use Symfony\Component\Serializer\Serializer;
use DateTime;

class HelloController extends Controller
{
    /**
     * @Route("index", name="index")
     */
    public function indexAction(){
        $exchangeRate = $this->get('exchange_rate')->getExchangeRate(["USD", "EUR", "CHF"]);

        return $this->render(':default:index.html.twig', $exchangeRate);
    }
}
