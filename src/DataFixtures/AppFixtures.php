<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Task;
use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

/**
 * @codeCoverageIgnore
 */
class AppFixtures extends Fixture
{
    private UserPasswordHasherInterface $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        for ($i = 0; $i < 4; ++$i) {
            $task = new Task();
            $task->setTitle($faker->sentence(3));
            $task->setContent($faker->sentence(25));
            $task->setCreatedAt(new \DateTime());
            $task->toggle(rand(0, 1));

            $manager->persist($task);
        }

        $admin = new User();
        $admin->setName("Vegeta");
        $admin->setEmail("vegeta@test.com");
        $admin->setRoles(array('ROLE_ADMIN'));
        $admin->setPassword($this->hasher->hashPassword($admin, 'test'));
        $manager->persist($admin); 

        $user = new User();
        $user->setName("cell");
        $user->setEmail("cell@test.com");
        $user->setRoles(array('ROLE_USER'));
        $user->setPassword($this->hasher->hashPassword($user, 'test'));
        $manager->persist($user);
    
        $manager->flush();
    }
}
