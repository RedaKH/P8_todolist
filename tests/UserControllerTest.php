<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserControllerTest extends WebTestCase
{
   public function loginAdmin(){
      $client = static::createClient();

      $testUser = static::getContainer()->get(UserRepository::class)->findOneByUser('user');
      
      return $client->loginUser($testUser);

   }
   public function loginUser(){
      $client = static::createClient();

      $testUser = static::getContainer()->get(UserRepository::class)->findOneByUser('user');
      
      return $client->loginUser($testUser);

   }

   public function testMakeAccount(){
      $client = static::createClient();
      $crawler = $client->request('GET', '/user/create');
      $this->assertEquals(Response::HTTP_OK, $client->getResponse()->getStatusCode());

      $form = $crawler->selectButton('Ajouter')->form([
          'user[username]' => 'test',
          'user[password][first]' => 'testpassword',
          'user[password][second]' => 'testpassword',
          'user[email]' => 'test@test.com',
          'user[roles]' => 'ROLE_USER'
      ]);

      $client->submit($form);
      $crawler = $client->followRedirect();
      $this->assertSelectorTextContains('div.alert-success', "Superbe ! L'utilisateur a bien été ajouté.");

      $testUser = static::getContainer()->get(UserRepository::class)->findOneBy('test');
      $this->assertInstanceOf(User::class,$testUser);



   }
   public function testSuccesssListUser()
    public function testMakeAccount(){
      $crawler = $this->client->request('GET', '/user_create');
      $this->assertEquals(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
      $form = $crawler->selectButton('Ajouter')->form([
          'user[name]' => "rollo4",
          'user[plainPassword][first]' => "rollo4",
          'user[plainPassword][second]' => "rollo4",
          'user[email]' => "rollo4@test.com",
        ]);
      $this->client->submit($form);
      $this->assertEquals(200, $this->client->getResponse()->getStatusCode(), $this->client->getResponse()->getContent());


   } 
   
  
}
