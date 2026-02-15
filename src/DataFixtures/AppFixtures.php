<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private $hasher;
    public function load(ObjectManager $manager): void
    {
        $user = new User();
        $user->setName('Sorin');
        $user->setPhone('642980754');
        $user->setIsVerified(true);
        $user->setEmail('csorin.dev@gmail.com');
        $user->setRoles(['ROLE_ADMIN']);
        $password = $this->hasher->hashPassword($user, 'parola');
        $user->setPassword($password);

        $manager->persist($user);
        $manager->flush();
    }

    public function __construct(UserPasswordHasherInterface $hasher) {
        $this->hasher = $hasher;
    }
}
