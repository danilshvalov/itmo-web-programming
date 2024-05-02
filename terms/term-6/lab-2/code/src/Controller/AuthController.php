<?php

namespace App\Controller;

use App\Controller\BaseController;
use App\Entity\UserAccount;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\FormError;

class AuthController extends BaseController
{
    #[Route('/login', name: 'login')]
    public function login(
        Request $request,
        EntityManagerInterface $entityManager
    ): Response {
        if ($this->isLoggedIn($request)) {
            return $this->redirectToRoute('index');
        }

        $user = new UserAccount();
        $form = $this->createFormBuilder($user)
            ->add('username', TextType::class, ['label' => 'Имя пользователя'])
            ->add('password', PasswordType::class, ['label' => 'Пароль'])
            ->add('submit', SubmitType::class, ['label' => 'Войти'])
        ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $user = $entityManager
            ->getRepository(UserAccount::class)
            ->findByUsernamePassword(
                $data->getUsername(),
                $data->getPassword()
            );
            if (!$user) {
                $form->addError(
                    new FormError('Неверное имя пользователя или пароль')
                );
                return $this->render('login.html.twig', ['form' => $form]);
            }

            $response = $this->redirectToRoute('index');
            $headers = $response->headers;
            $headers->setCookie(new Cookie('user_id', $user->getId()));
            $headers->setCookie(new Cookie('username', $user->getUsername()));
            $headers->setCookie(new Cookie('password', $user->getPassword()));
            return $response;
        }

        return $this->render('login.html.twig', ['form' => $form]);
    }

    #[Route('/register', name: 'register')]
    public function register(
        Request $request,
        EntityManagerInterface $entityManager
    ): Response {
        $user = new UserAccount();

        $form = $this->createFormBuilder($user)
            ->add('username', TextType::class, ['label' => 'Имя пользователя'])
            ->add('password', PasswordType::class, ['label' => 'Пароль'])
            ->add('submit', SubmitType::class, ['label' => 'Зарегистрироваться'])
        ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('login');
        }

        return $this->render('register.html.twig', ['form' => $form]);
    }

    #[Route('/logout', name: 'logout')]
    public function logout(Request $request): Response
    {
        $response = $this->redirectToRoute('login');
        $headers = $response->headers;
        $headers->clearCookie('user_id');
        $headers->clearCookie('username');
        $headers->clearCookie('password');
        return $response;
    }

    private function findUser(
        EntityManagerInterface $entityManager,
        string $username,
        string $password
    ): array {
        $query = $entityManager->createQuery(
            'SELECT user.id, user.username, user.password
            FROM App\Entity\UserAccount user
            WHERE user.username = :username AND user.password = :password'
        )
        ->setParameter('username', $username)
        ->setParameter('password', $password);
        $result = $query->getResult();
        if (!$result) {
            return null;
        }
        return $result[0];
    }
}
