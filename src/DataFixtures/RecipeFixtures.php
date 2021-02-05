<?php

namespace App\DataFixtures;

use App\Entity\Recipe;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker;

class RecipeFixtures extends Fixture implements DependentFixtureInterface
{
    const RECIPES_COUNT = 50;

    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');

        $preparationTime = new DateTime();
        $cookingTime = new DateTime();

        for ($i = 0; $i < self::RECIPES_COUNT; $i++) {
            $recipe = new Recipe();
            $preparationTime->setTime(0, rand(10, 60));
            $cookingTime->setTime(0, rand(30, 90));
            $recipe->setTitle($faker->sentence)
                ->setIngredient($faker->text)
                ->setPreparation($faker->sentence)
                ->setPreparationTime($preparationTime)
                ->setCookingTime($cookingTime)
                ->setServing(rand(1, 6))
                ->setImage('image-test.jpg')
                ->setCategory($this->getReference('category_' . rand(0, count(CategoryFixtures::CATEGORIES)-1)));
            $manager->persist($recipe);
            $this->addReference('recipe_' . $i, $recipe);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [CategoryFixtures::class];
    }
}
