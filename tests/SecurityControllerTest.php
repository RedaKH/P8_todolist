<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

use App\Entity\User;
use App\Repository\UserRepository;

class SecurityControllerTest extends WebTestCase
{
    public function testLoginWithBadCredentials()
    {
        $client = static::createClient();
        $userRepository = static::getContainer()->get(UserRepository::class);

<<<<<<< Updated upstream
        // retrieve the test user
        $testUser = $userRepository->findOneByEmail('john.doe@example.com');

        // simulate $testUser being logged in
        $client->loginUser($testUser);

        // test e.g. the profile page
        $client->request('GET', '/app_home');
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Bienvenue');
=======
    public function loginUser(): void
    {
        $userRepository = static::getContainer()->get(UserRepository::class);
    $testUser = $userRepository->findOneByEmail('vegeta@test.com');

    $this->client->loginUser($testUser);
>>>>>>> Stashed changes
    }
    

    public function testLoginWithGoodCredentials()
    {
        $client = static::createClient();
        $userRepository = static::getContainer()->get(UserRepository::class);

        // retrieve the test user
        $testUser = $userRepository->findOneByEmail('vegeta@test.com');

        // simulate $testUser being logged in
        $client->loginUser($testUser);

        // test e.g. the profile page
        $client->request('GET', '/app_home');
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Bienvenue sur Todo List');
    }
}
