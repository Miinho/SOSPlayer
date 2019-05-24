<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class PageController extends AbstractController
{
    /**
     * @route("/", name="home")
     */
    public function home()
    {
        return $this->render('page/home.html.twig', [
            'title' => "On salut l'équipe",

        ]);
    }
}
