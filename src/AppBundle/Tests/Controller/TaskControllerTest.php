<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TaskControllerTest extends WebTestCase
{
    public function testAddtask()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/task/add');
    }

    public function testEdittask()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/task/edit/{id}');
    }

}
