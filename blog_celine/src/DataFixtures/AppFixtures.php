<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Faker\Factory;

class AppFixtures extends Fixture
{

    private $encoder;
    
    public function __construct(UserPasswordEncoderInterface $encoder) {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');
        $faker->seed(0);

        $user = new User();
        $user
            ->setEmail('user@ex.com')
            ->setPassword($this->encoder->encodePassword($user,'user'))
            ->setFirstname($faker->firstName)
            ->setLastname($faker->lastName)
            ->setUsername($faker->firstName)
        ;

        $manager->persist($user);
        
        $admin = new User();
        $admin
            ->setEmail('admin@ex.com')
            ->setPassword($this->encoder->encodePassword($admin,'admin'))
            ->setFirstname($faker->firstName)
            ->setLastname($faker->lastName)
            ->setUsername($faker->firstName)
            ->setRoles(['ROLE_ADMIN'])
        ;

        $manager->persist($admin);

        $manager->flush();
    }
}
