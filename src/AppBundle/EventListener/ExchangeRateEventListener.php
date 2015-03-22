<?php

namespace AppBundle\EventListener;

use DateTime;
use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Symfony\Component\DomCrawler\Crawler;

class ExchangeRateEventListener {

    function getExchangeRate($neededCurrency){
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
                if(array_search($value['code'], $neededCurrency) !== false){
                    $currency[$value['code']][] = floatval(str_replace(",",".",$value['rate']));
                }
            }
        }
        return ['rateDates' => $rateDates, 'currency' => $currency];
    }

}