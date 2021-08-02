<?php


namespace App\Controller;


class RestGetByUsernameController extends \Symfony\Bundle\FrameworkBundle\Controller\AbstractController
{
    public function __invoke(string $username)
    {
        $user = $this->getDoctrine()
            ->getRepository(user::class)
            ->findBy(
                ['username' => $username],
            );

        if (!$user) {
            throw $this->createNotFoundException(
                'No user found for this username'
            );
        }

        return $user;
    }
}