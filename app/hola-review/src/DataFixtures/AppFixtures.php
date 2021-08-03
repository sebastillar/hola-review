<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Role;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $encoder) {
        $this->passwordEncoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        $userAdmin = new User("Admin","admin","ADMIN");
        $userAdmin->setPassword($this->passwordEncoder->encodePassword(
            $userAdmin,
            "adminpassword"
        ));
        $manager->persist($userAdmin);

        for ($i = 0; $i < 20; $i++)
        {
            $role = 1;
            if($i%2 == 0)
                $role = 2;

            $user = new User("Name".$i,"user".$i,$role);

            $user->setPassword($this->passwordEncoder->encodePassword(
                $user,
                "password".$i
            ));
            $manager->persist($user);
        }

        $manager->flush();
    }

}
