<?php

namespace App\Tests;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use App\Repository\TaskRepository;
use App\Repository\UserRepository;
use App\Entity\Task;



class TaskControllerTest extends WebTestCase
{
    private $client;
    private $route;

    public function setUp(): void
    {
        $this->route = '/tasks/1/edit';
        $this->client = static::createClient();
    }

    public function loginUser(): void
    {

        $userRepository = static::getContainer()->get(UserRepository::class);
        $testUser = $userRepository->findOneByEmail('ragnar@test.com');

        $this->client->loginUser($testUser);
    }
     public function testMakeTask()
    {
        $this->loginUser();
        $crawler = $this->client->request('GET', '/tasks/create');
  
        $form = $crawler->selectButton('Ajouter')->form([
            'task[title]'=>'test5555',
            'task[content]'=>'lorem5555'
        ]);
  
        
  
        $this->client->submit($form);
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode(), $this->client->getResponse()->getContent());

        $this->assertSelectorTextContains('div.alert-success', "Superbe ! Votre tache a bien été envoyé");
    }

     public function testEditTask()
    {
        $client = $this->loginUser('ragnar');
        
        $crawler = $this->client->request('GET', $this->route);
        $this->assertResponseIsSuccessful();

        $form = $crawler->selectButton('Modifier')->form([
            'task[title]' => 'anothertest',
            'task[content]' => 'anothertest2'
        ]);
        $task = self::getContainer()->get(TaskRepository::class);
    

        $this->client->submit($form);
        $crawler = $this->client->followRedirect();
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    }

    public function testToggleTask()
    {
        $this->loginUser();
        
        $crawler = $this->client->request('GET', '/tasks/9/toggle');
        $this->assertEquals(Response::HTTP_FOUND, $this->client->getResponse()->getStatusCode());
        $crawler = $this->client->followRedirect();

        $this->assertEquals(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
        $this->assertEquals(1, $crawler->filter('div.alert-success')->count());
        
    }  


   public function testDeleteTask()
    {
        $this->loginUser();
        
        $this->client->request('GET', '/tasks/44/delete');
        $this->assertEquals(Response::HTTP_FOUND, $this->client->getResponse()->getStatusCode());
        $this->client->followRedirect();

        $this->assertEquals(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
    } 
}
