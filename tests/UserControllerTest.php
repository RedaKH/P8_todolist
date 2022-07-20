<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserControllerTest extends WebTestCase
{
   public function testMakeAccount(){
    $client = static::createClient();
    $crawler = $client->request('GET','/user_create');


   }
}
