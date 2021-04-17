<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ArticleRepository;
use App\Entity\Article;

class ArticleController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function list(ArticleRepository $repo)
    {
        $articles = $repo->findAll();

        return $this->render('article/home.html.twig', [
            'articles' => $articles,
        ]);
    }

    /**
     * @Route("/article/{id}", name="show")
     */
    public function show(Article $article) {
        return $this->render('article/show.html.twig', [
            'article' => $article,
        ]);
    }
}
