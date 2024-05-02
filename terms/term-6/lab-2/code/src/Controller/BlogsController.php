<?php

namespace App\Controller;

use App\Controller\BaseController;
use App\Entity\Post;
use App\Entity\Blog;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\FormError;

class BlogsController extends BaseController
{
    #[Route('/blogs/create', name: 'create_blog')]
    public function createBlog(
        Request $request,
        EntityManagerInterface $entityManager
    ): Response {
        if (!$this->isLoggedIn($request)) {
            return $this->redirectToRoute('login');
        }

        $user = $this->getCurrentUser($request, $entityManager);

        $blog = new Blog();
        $blog->setOwner($user);
        $form = $this->createFormBuilder($blog)
            ->add('name', TextType::class, ['label' => 'Название'])
            ->add('description', TextareaType::class, ['label' => 'Описание'])
            ->add('submit', SubmitType::class, ['label' => 'Создать'])
        ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $entityManager->persist($data);
            $entityManager->flush();

            $response = $this->redirectToRoute(
                'get_blog',
                ['id' => $data->getId()]
            );
            return $response;
        }

        return $this->render('blog_create.html.twig', ['form' => $form]);
    }


    #[Route('/blogs', name: 'blogs')]
    public function blogs(
        Request $request,
        EntityManagerInterface $entityManager
    ): Response {
        $blogs = $entityManager->getRepository(Blog::class)->findAll();
        return $this->render('blogs.html.twig', ['blogs' => $blogs]);
    }

    #[Route('/blogs/{id}', name: 'get_blog')]
    public function getBlog(
        Request $request,
        string $id,
        EntityManagerInterface $entityManager
    ): Response {
        $blog = $entityManager->getRepository(Blog::class)->find($id);
        if (!$blog) {
            return $this->redirectToRoute('not_found');
        }
        return $this->render(
            'blog.html.twig',
            [
                'blog' => $blog,
                'user' => $this->getCurrentUser($request, $entityManager)
            ]
        );
    }
}
