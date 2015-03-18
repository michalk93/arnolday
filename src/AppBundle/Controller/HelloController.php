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
        $allFiles = file("http://www.nbp.pl/kursy/xml/dir.txt");
        $lastFiles = array_slice($allFiles, -100);
        $lastFiles = array_filter($lastFiles, function($item){
            return preg_match("/^a.*/", $item);
        });
        $currencyArr = [];
        foreach($lastFiles as $file){
            $file = rtrim($file);
            $data = file_get_contents("http://www.nbp.pl/kursy/xml/".$file.".xml");
            $crawler = new Crawler($data);
            $currencyArr[substr($file, -6, 6)] = $crawler->filter('pozycja')->each(function(Crawler $node, $i){
                    return ['code' => $node->children()->eq(2)->text(), 'rate' => $node->children()->eq(3)->text()];
            });
        }
        $rateDates = [];
        $currency = [];
        foreach($currencyArr as $date => $data){
            $newDate = new DateTime("20".$date);
            $rateDates[] = $newDate->format("d-m-Y");
            foreach($data as $value){
                if(array_search($value['code'], ["USD","EUR","CHF"]) !== false){
                    $currency[$value['code']][] = floatval(str_replace(",",".",$value['rate']));
                }
            }
        }

        return $this->render(':default:index.html.twig', ['rateDates' => $rateDates, 'currency' => $currency]);
    }
}
