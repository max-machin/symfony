<?php

namespace App\Controller;

use App\Repository\ArticlesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function show(ArticlesRepository $articlesRepository): Response
    {
        return $this->render('home/show.html.twig', [
            'articles' => $articlesRepository->findAll()
        ]);
    }
}
