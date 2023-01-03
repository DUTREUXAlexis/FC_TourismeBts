<?php

namespace App\DataFixtures;

use App\Entity\Utilisateur;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Repository\UtilisateurRepository;
use Faker\Factory;
use Symfony\Component\Validator\Constraints\Date;

class UtilisateurFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker= Factory::create('fr_FR');

        for($i=1;$i<50;$i++){
            $utilisateur = new Utilisateur();
            $utilisateur->setNom($faker->firstName)
                ->setPrenom($faker->lastName)
                ->setActif($faker->boolean(50))
                ->setPseudo($faker->name)
                ->setCreatedAt(New \DateTime())
                ->setEmail($faker->email)
                ->setPassword('password')
                ->setroles(['ROLE_USER']);
            $manager->persist($utilisateur);
        }
        $manager->flush();
    }


}
