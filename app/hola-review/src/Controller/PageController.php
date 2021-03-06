<?php

namespace App\Controller;

use App\Security\AccessDeniedHandler;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use App\Entity\Role;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class PageController extends AbstractController
{
    private $exception;
    private $handler;

    public function __construct(
        AccessDeniedException $accessDeniedException,
        AccessDeniedHandler $handler
    )
    {
        $this->exception = $accessDeniedException;
        $this->handler = $handler;
    }

    public function index(Request $request, $num_page): Response
    {
        if(!is_null($this->getUser())){
            $role = $this->getUser()->getRole();

            if (
                in_array($this->getUser()->getRoles(),'ROLE_PAGE_1') && $num_page == 2 ||
                in_array($this->getUser()->getRoles(),'ROLE_PAGE_2') && $num_page == 1
            ) {
                $response = $this->handler->handle($request, $this->exception);
                return $this->render('error/error.html.twig', [
                    'response' => $response
                ]);
            }

            return $this->render('page/index.html.twig', [
                'num_page' => $num_page
            ]);
        }

        return $this->redirectToRoute('login', [],302);
    }
}
