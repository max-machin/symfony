<?php

namespace App\Controller;

use App\Entity\Articles;
use App\Entity\Comments;
use App\Form\Type\CommentType;
use App\Repository\ArticlesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends AbstractController
{
    
    #[Route('/article/{slug}', name: 'article_show')]
    public function show(?Articles $article, ?ArticlesRepository $articlesRepository): Response
    {

        if(!$article){
            return $this->redirectToRoute('app_home');
        }

        $comment = new Comments($article);

        $commentForm = $this->createForm(CommentType::class, $comment);

        return $this->renderForm('article/show.html.twig', [
            'article' => $article,
            'commentForm' => $commentForm,
            'articles' => $articlesRepository->findAll()
        ]);
    }
}
