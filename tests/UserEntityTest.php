<?php

namespace App\Tests;

use PHPUnit\Framework\TestCase;

use App\Entity\User;

class UserEntityTest extends TestCase
{
    private $user;
   
    public function setUp(): void
    {
       $this->user = new User();
    }
    public function testId(): void
    {
        $this->assertNull($this->user->getId());
    }

    public function testName():void
    {
        $this->user->setName('test');
        $this->assertSame('test',$this->user->getName());

    }
    public function testPassword():void
    {
        $this->user->setPassword('pwd');
        $this->assertSame('pwd',$this->user->getPassword());

    }

    public function testEmail():void
    {
        $this->user->setEmail('test@test.com');
        $this->assertSame('test@test.com',$this->user->getEmail());

    }

    public function testRoles():void
    {
        $this->user->setRoles(['ROLE_USER']);
        $this->assertSame(['ROLE_USER'],$this->user->getRoles());

    }

    public function testSalt(): void
    {
        $this->assertNull($this->user->getSalt());
    }

    public function testEraseCredentials(): void
    {
        $this->assertNull($this->user->eraseCredentials());
    }






}