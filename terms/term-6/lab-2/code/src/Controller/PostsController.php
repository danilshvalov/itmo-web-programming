<?php

namespace App\Controller;

use App\Controller\BaseController;
use App\Entity\Blog;
use App\Entity\Comment;
use App\Entity\Like;
use App\Entity\Post;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\FormError;

class PostsController extends BaseController
{
    #[Route('/posts/create', name: 'create_post')]
    public function createPost(
        Request $request,
        EntityManagerInterface $entityManager
    ): Response {
        if (!$this->isLoggedIn($request)) {
            return $this->redirectToRoute('login');
        }

        $user = $this->getCurrentUser($request, $entityManager);

        $blog_id = $request->query->get('blog_id');
        $blog = $entityManager->getRepository(Blog::class)->find($blog_id);
        if (!$blog) {
            return $this->redirectToRoute('not_found');
        }

        $post = new Post();
        $post->setBlog($blog);
        $post->setAuthor($user);
        $form = $this->createFormBuilder($post)
            ->add('title', TextType::class, ['label' => 'Название'])
            ->add('content', TextareaType::class, ['label' => 'Содержание'])
            ->add('submit', SubmitType::class, ['label' => 'Создать'])
        ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $entityManager->persist($data);
            $entityManager->flush();

            $response = $this->redirectToRoute(
                'get_post',
                ['id' => $data->getId()]
            );
            return $response;
        }

        return $this->render('post_create.html.twig', ['form' => $form]);
    }

    #[Route('/posts/like', name: 'like_post')]
    public function likePost(
        Request $request,
        EntityManagerInterface $entityManager
    ): Response {
        if (!$this->isLoggedIn($request)) {
            return $this->redirectToRoute('login');
        }

        $post_id = $request->query->get('post_id');
        $user = $this->getCurrentUser($request, $entityManager);
        $post = $entityManager->getRepository(Post::class)->find($post_id);

        $like = $entityManager
            ->getRepository(Like::class)
            ->findUserPostLike($user->getId(), $post->getId());

        if ($like) {
            $entityManager->remove($like);
            $entityManager->flush();
        } else {
            $like = new Like();
            $like->setAuthor($user);
            $like->setPost($post);
            $entityManager->persist($like);
            $entityManager->flush();
        }

        return $this->redirectToRoute('get_post', ['id' => $post->getId()]);
    }

    #[Route('/posts/{id}', name: 'get_post')]
    public function getPost(
        Request $request,
        string $id,
        EntityManagerInterface $entityManager
    ): Response {
        $user = $this->getCurrentUser($request, $entityManager);
        $post = $entityManager->getRepository(Post::class)->find($id);
        if (!$post) {
            return $this->redirectToRoute('not_found');
        }
        if ($user) {
            $like = $entityManager
                ->getRepository(Like::class)
                ->findUserPostLike($user->getId(), $post->getId());
        } else {
            $like = null;
        }

        $comment = new Comment();
        $comment->setPost($post);
        $comment->setAuthor($user);
        $form = $this->createFormBuilder($comment)
            ->add('content', TextareaType::class, ['label' => 'Содержание'])
            ->add('submit', SubmitType::class, ['label' => 'Добавить'])
        ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $entityManager->persist($data);
            $entityManager->flush();
            return $this->redirectToRoute('get_post', ['id' => $post->getId()]);
        }

        return $this->render(
            'post.html.twig',
            [
                'post' => $post,
                'user' => $user,
                'commentForm' => $form,
                'liked' => $like != null
            ]
        );
    }
}
