<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Post;
use App\Entity\Commentaire;
use App\Form\PostType;
use App\Form\CommentaireType;

class PostController extends AbstractController
{
    /**
     * @Route("/home", name="dashboard")
     */
    public function index(Request $request): Response
    {
        $post = new Post();
        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $post->setCreatedAt(new \DateTime());
            $user = $this->getUser();
            $post->setAuthor($user);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($post);
            $entityManager->flush();
        }

        $posts = $this->getDoctrine()->getManager()->getRepository(Post::class)->findAll();

        return $this->render('post/index.html.twig', [
            'form' => $form->createView(),
            'posts' => $posts
        ]);
    }
}
