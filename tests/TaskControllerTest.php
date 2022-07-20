<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

use App\Repository\TaskRepository;


class TaskControllerTest extends WebTestCase
{//s
{

    public function login(){
        $client = static::createClient();

        $testUser = static::getContainer()->get(UserRepository::class)->findOneByUser('user');
        
        return $client->loginUser($testUser);
    }
    public function testMakeTask()
    {
        $client = static::createClient();
        $client->request('GET', '/tasks/create');

        $form = $client->submitForm('Ajouter', [
            'task[title]' => 'lorem',
            'task[content]'=>'test'
        ]);


        $client->submit($form);
        $crawler = $client->followRedirect();
        $this->assertSelectorTextContains('div.alert-success', "Superbe ! La tâche a été bien été ajoutée.");

        $client->submit($form);
        $crawler = $client->followRedirect();
        $this->assertSelectorTextContains('div.alert-success', "Superbe ! La tâche a été bien été ajoutée.");
    }

    public function testEditOwnTask()
    {
        $client = $this->login();
        
        $crawler = $client->request('GET', '/tasks/6/edit');
        $this->assertResponseIsSuccessful();

        $form = $crawler->selectButton('Modifier')->form([
            'task[title]' => 'anothertest',
            'task[content]' => 'anothertest2'
        ]);

        $client->submit($form);
        $crawler = $client->followRedirect();
        $this->assertSelectorTextContains('div.alert-success', "Superbe ! La tâche a bien été modifiée.");
    }

    public function testToggleTask()
    {
        $client = $this->login();
        
        $crawler = $client->request('GET', '/tasks/1/toggle');
        $this->assertEquals(Response::HTTP_FOUND, $client->getResponse()->getStatusCode());
        $crawler = $client->followRedirect();

        $this->assertEquals(Response::HTTP_OK, $client->getResponse()->getStatusCode());
        $this->assertEquals(1, $crawler->filter('div.alert-success')->count());
        
    }



    public function testListDoneTask()
    {
        $client = $this->login();

        $router = $client->getContainer()->get('router');

        $crawler = $client->request('GET', $router->generate('task_list', ['isDone' => 1]));

        $this->assertSelectorExists('.glyphicon.glyphicon-ok');
    }

    public function testListNoDoneTask()
    {
        $client = $this->login();

        $router = $client->getContainer()->get('router');

        $crawler = $client->request('GET', $router->generate('task_list', ['isDone' => 0]));


    public function testListDoneTask()
    {
        $client = $this->login();

        $router = $client->getContainer()->get('router');

        $crawler = $client->request('GET', $router->generate('task_list', ['isDone' => 1]));

        $this->assertSelectorExists('.glyphicon.glyphicon-ok');
    }

    public function testListNoDoneTask()
    {
        $client = $this->login();

        $router = $client->getContainer()->get('router');

        $crawler = $client->request('GET', $router->generate('task_list', ['isDone' => 0]));

        $this->assertSelectorNotExists('.glyphicon.glyphicon-ok');
    }

    public function testDeleteTask()
    {
        $client = $this->login();
        

        $crawler = $client->request('GET', '/tasks/6/delete');
        $this->assertEquals(Response::HTTP_FOUND, $client->getResponse()->getStatusCode());
        $crawler = $client->followRedirect();
        $this->client->request('GET', '/tasks/42/delete');
        $this->assertEquals(Response::HTTP_FOUND, $this->client->getResponse()->getStatusCode());
        $this->client->followRedirect();

        $this->assertEquals(Response::HTTP_OK, $client->getResponse()->getStatusCode());
        $this->assertSelectorTextContains('div.alert-success', "Superbe ! La tâche a bien été supprimée.");
    }
