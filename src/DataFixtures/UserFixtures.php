<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Faker;

class UserFixtures extends Fixture
{
    const USERS_COUNT = 11;

    /**
     * @var UserPasswordEncoderInterface
     */
    private UserPasswordEncoderInterface $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }
    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create();

        $admin = new User();
        $admin->setEmail('admin@qcm.com');
        $admin->setRoles(['ROLE_ADMIN']);
        $admin->setPassword($this->passwordEncoder->encodePassword(
            $admin,
            'admin'
        ));
        $admin->setNickname($faker->lastName);
        $manager->persist($admin);

        for ($i = 2; $i < self::USERS_COUNT; $i++) {
            $user = new User();
            $user->setEmail($faker->email);
            $user->setRoles(['ROLE_USER']);
            $user->setPassword($this->passwordEncoder->encodePassword(
                $user,
                'user'
            ));
            $user->setNickname($faker->lastName);
            $manager->persist($user);
            $this->addReference('user_' . $i, $user);
        }

        $manager->flush();
    }
}
