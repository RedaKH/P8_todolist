<?php

namespace App\Tests;

use App\Entity\User;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use App\Repository\UserRepository;

class UserControllerTest extends WebTestCase
{
   private $client;
   private $route;


    public function setUp(): void
    {
        $this->route = '/users/2/edit';

        $this->client = static::createClient();

    }
    
   public function loginAdmin(){

    $userRepository = static::getContainer()->get(UserRepository::class);
    $testUser = $userRepository->findOneByEmail('vegeta@test.com');

    $this->client->loginUser($testUser);

   }
   public function loginUser(): void
   {

       $userRepository = static::getContainer()->get(UserRepository::class);
       $testUser = $userRepository->findOneByEmail('test@test.com');

       $this->client->loginUser($testUser);
   } 

    public function testMakeAccount(){
      $this->loginAdmin();
            $crawler = $this->client->request('GET', '/user_create');
      $this->assertEquals(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
      $form = $crawler->selectButton('Ajouter')->form([
          'user[name]' => "rollo3",
          'user[plainPassword][first]' => "rollo3",
          'user[plainPassword][second]' => "rollo3",
          'user[email]' => "rollo3@test.com",
        ]);
      $this->client->submit($form);
      $crawler = $this->client->followRedirect();
      $this->assertEquals(1, $crawler->filter('div.alert-success')->count());


   } 
   
   public function testListUser()
   {
       $this->loginAdmin();
       $crawler = $this->client->request('GET', '/user');

       $this->assertEquals(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
       $this->assertSelectorTextContains('h1', 'Liste des utilisateurs');
   } 


   public function testEditUser()
   {
       $client = $this->loginAdmin('vegeta');
       
       $crawler = $this->client->request('GET', $this->route);
       $this->assertResponseIsSuccessful();

       $form = $crawler->selectButton('Modifier')->form([
        'user[name]' => 'test2',
        'user[plainPassword][first]' => 'test2password',
        'user[plainPassword][second]' => 'test2password',
        'user[email]' => 'test2@test2.fr',
        'user[roles]' => 'ROLE_USER'
       ]);
       $user = self::getContainer()->get(UserRepository::class);
   

       $this->client->submit($form);
       $crawler = $this->client->followRedirect();
       $this->assertResponseStatusCodeSame(Response::HTTP_OK);
   }

   


}