<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Article;
use App\Entity\Comment;
use App\Form\CommentType;
use App\Repository\ArticleRepository;

class ArticleController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function list(ArticleRepository $ripo) {
        $articles = $ripo->findAll();

        return $this->render('article/home.html.twig', [
            'articles' => $articles,
        ]);
    }
    
    /*
    * la pagination ne veux pas fonctionner, cela me met toujours une erreur dont je n'arrive pas à trouver la solution
    * ainsi je laisse le code en commentaire

    public function list(PaginatorInterface $paginator, Request $request)
    {
        $donnees = $this->getDoctrine()->getRepository(Article::class)->findBy([], ['postDate' => 'desc']);
        $articles = $paginator->paginate(
            $donnees, // query not result
            $request->query->getInt('page', 1), // page number
            6 // limit per page
        );

        return $this->render('article/home.html.twig', [
            'articles' => $articles,
        ]);
    }*/

    /**
     * @Route("/article/{id}", name="show")
     */
    public function show(Article $article, Request $request) {
        if(!$article){
            // Si aucun article n'est trouvé, nous créons une exception
            throw $this->createNotFoundException('L\'article n\'existe pas');
        }
        
        // Récupération des commentaires existants sur l'article
        $comments = $this->getDoctrine()->getRepository(Comment::class)->findBy([
            'article' => $article,
            'status' => 1
        ],['created_at' => 'desc']);
        
        // Création de l'instance de Comment et le formulaire
        $comment = new Comment();
        $form = $this->createForm(CommentType::class, $comment);
        
        $form->handleRequest($request);

        /**
         * Le formulaire existe sur les pages de détails des articles cependant je n'arrive pas à mettre d'EventListener
         * (ou je ne comprend pas comment en ajouter un et le lier à ce formulaire) ainsi les commentaires sont indisponibles
         */

        if ($form->isSubmitted() && $form->isValid()) {
            $comment->setArticle($article);
            $doctrine = $this->getDoctrine()->getManager();
            $doctrine->persist($comment);
            $doctrine->flush();
            return $this->redirectToRoute('show', [ 'article' => $article]);
        }

        // On envoie le tout
        return $this->render('article/show.html.twig', [
            'article' => $article,
            'comments' => $comments,
            'form' => $form->createView()
        ]);
    }
}
