<?php

namespace App\Controller;

use App\Entity\UserAccount;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class BaseController extends AbstractController
{
    protected function isLoggedIn(Request $request): bool
    {
        $cookies = $request->cookies;
        return $cookies->get('user_id') && $cookies->get('username') && $cookies->get('password');
    }

    protected function getCurrentUser(
        Request $request,
        EntityManagerInterface $entityManager
    ): ?UserAccount {
        $user_id = $request->cookies->get('user_id');
        if (!$user_id) {
            return null;
        }
        return $entityManager->getRepository(UserAccount::class)->find($user_id);
    }
}
