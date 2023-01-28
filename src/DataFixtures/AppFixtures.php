<?php

namespace App\DataFixtures;

use App\Entity\Annonce;
use App\Entity\Categorie;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;

class AppFixtures extends Fixture
{
    //to execute : bin/console doctrine:fixtures:load
    public function load(ObjectManager $manager): void
    {
        $faker = Faker\Factory::create('fr_FR');
        // on crée 4 Catégories & 4 Annonces
        $categories = Array();
        $annonces = Array();
        for ($i = 0; $i < 4; $i++) {
            $categories[$i] = new Categorie();
            $categories[$i]->setNom($faker->text(10));
            $categories[$i]->setCouleur($faker->colorName);

            $annonces[$i] = new Annonce();
            $annonces[$i]->setCodePostal(intval($faker->postcode));
            $annonces[$i]->setContenu($faker->text(254));
            $annonces[$i]->setDateCreation($faker->dateTimeThisDecade);
            $annonces[$i]->setTitre($faker->sentence($nbWords = 6, $variableNbWords = true));
            $annonces[$i]->setPrix($faker->randomDigitNotNull);

            //set clés étrangères random
            $randomCategorie = $faker->randomDigitNotNull%sizeof($categories);
            $annonces[$i]->setCategorie($categories[$randomCategorie]);
            $categories[$randomCategorie]->getAnnonces()->add($annonces[$i]);

            $manager->persist($categories[$i]);
            $manager->persist($annonces[$i]);
        }

        $manager->flush();
    }
}
