<?php

namespace App\DataFixtures;

use App\Entity\Comment;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker;

class CommentFixtures extends Fixture implements DependentFixtureInterface
{
    const COMMENTS_COUNT = 30;

    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');

        for ($i = 0; $i < self::COMMENTS_COUNT; $i++) {
            $comment = new Comment();
            $comment->setUser($this->getReference('user_' . rand(2, UserFixtures::USERS_COUNT - 1 )))
                ->setRecipe($this->getReference('recipe_' . rand(0, RecipeFixtures::RECIPES_COUNT - 1)))
                ->setComment($faker->text)
                ->setRate(rand(0, 5));
            $manager->persist($comment);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            UserFixtures::class,
            RecipeFixtures::class,
        ];
    }
}
