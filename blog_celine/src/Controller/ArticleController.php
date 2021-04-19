<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Article;

class ArticleController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function list(PaginatorInterface $paginator, Request $request)
    {
        $donnees = $this->getDoctrine()->getRepository(Article::class)->findBy([], ['postDate' => 'desc']);
        $articles = $paginator->paginate(
            $donnees,
            $request->query->getInt('page', 1),
            6
        );

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
