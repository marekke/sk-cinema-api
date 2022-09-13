<?php


namespace App\Controller;


use App\Security\TokenAuthenticator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Http\Attribute\CurrentUser;

class ApiLoginController extends AbstractController
{


    #[Route('/login', name: 'api_login')]
    public function login(#[CurrentUser] ?UserInterface $user): Response
    {
        if (null === $user) {
            return $this->json([
                'message' => 'missing credentials',
            ], Response::HTTP_UNAUTHORIZED);
        }

        return $this->json([
            'user' => $user->getUserIdentifier(),
            'token' => TokenAuthenticator::TOKENS[$user->getUserIdentifier()],
        ]);
    }

    #[Route('/logout', name: 'logout')]
    public function logout(#[CurrentUser] ?UserInterface $user)
    {
        return $this->json([]);
    }
}