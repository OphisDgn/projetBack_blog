<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Article;
use App\Entity\Category;
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

        /*
            L'utilisateur n'étant ni administrateur, ni auteur.
        */
        $user = new User();
        $user
            ->setEmail('user@ex.com')
            ->setPassword($this->encoder->encodePassword($user,'user'))
            ->setFirstname($faker->firstName)
            ->setLastname($faker->lastName)
            ->setUsername($faker->firstName)
        ;

        $manager->persist($user);
        
        /*
            L'utilisateur étant administrateur.
        */
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
        
        $category = new Category();
        $category->setName('Première catégorie');
        $manager->persist($category);

        /* on passe à la création fausse d'article */
        for ($i = 0;$i < 10; $i++) {
            $article = new Article();
            $article->setTitle($faker->sentence($nbWords=10, $variableNbWords=true))
                ->setContent($faker->sentence($nbWords=10, $variableNbWords=true))
                ->setIsVisible(true)
                ->setPostDate($faker->dateTimeBetween('-6 months'))
                ->setCategory($category)
                ->setAuthor($admin);
                
                $manager->persist($article);
        }

        $manager->flush();

    }
}
