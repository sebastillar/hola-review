<?php


namespace App\Security;


use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Http\Authorization\AccessDeniedHandlerInterface;

class AccessDeniedHandler implements AccessDeniedHandlerInterface
{

    /**
     * @inheritDoc
     */
    public function handle(Request $request, AccessDeniedException $accessDeniedException)
    {
        $request = null;
        $accessDeniedException = null;
        return new Response(
            'You are not allowed to see this amazing page.',
            403
        );
    }
}