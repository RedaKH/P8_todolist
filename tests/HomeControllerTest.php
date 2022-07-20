<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use App\Repository\UserRepository;

class HomeControllerTest extends WebTestCase
{
    private $client;

    public function setUp(): void
    {
        $this->client = static::createClient();
    }
    public function loginUser(): void
    {
        
        $userRepository = static::getContainer()->get(UserRepository::class);
        $testUser = $userRepository->findOneByEmail('ragnar@test.com');

        $this->client->loginUser($testUser);
    }

    public function testLogin()
    {
        $this->loginUser();
        $this->client->request('GET', '/');
        $this->assertSelectorTextContains('h1', 'Bienvenue sur Todo List');
    }
}