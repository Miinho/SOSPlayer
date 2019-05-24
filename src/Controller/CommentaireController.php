<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use App\Entity\Commentaire;
use App\Entity\Post;
use App\Form\CommentaireType;

class CommentaireController extends AbstractController
{
    private $urlGenerator;

    public function __construct(UrlGeneratorInterface $urlGenerator)
    {
        $this->urlGenerator = $urlGenerator;
    }

    /**
     * @Route("/comment/{idPost}", name="comment")
     */
    public function index(Request $request, $idPost, UrlGeneratorInterface $urlGenerator)
    {
        $commentaire = new Commentaire();
        $formCom = $this->createForm(CommentaireType::class, $commentaire);
        $formCom->handleRequest($request);

        if ($formCom->isSubmitted() && $formCom->isValid()) {

            $commentaire->setCreatedAt(new \DateTime());
            $user = $this->getUser();
            $commentaire->setAuthor($user);
            $post = $this->getDoctrine()->getManager()->getRepository(Post::class)->find($idPost);
            $commentaire->setPost($post);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($commentaire);
            $entityManager->flush();
            
            return new RedirectResponse($this->urlGenerator->generate('dashboard'));
        }

        return $this->render('commentaire/index.html.twig', [
            'formCom' => $formCom->createView(),
        ]);
    }
}
