<?php

namespace App\Controller;

use App\Entity\Comments;
use App\Entity\User;
use App\Repository\ArticlesRepository;
use App\Repository\CommentsRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @method User getUser()
*/
class CommentsController extends AbstractController
{
    #[Route('/ajax/comments', name: 'comment-add')]

    public function add(
        Request $request, 
        ArticlesRepository $articlesRepository, 
        UserRepository $userRepository, 
        CommentsRepository $commentsRepository,
        EntityManagerInterface $en
        ): Response
    {
        $commentData = $request->request->all('comment');

        if (!$this->isCsrfTokenValid('comment-add', $commentData['_token'])){
            dd($commentData['_token']);
            return $this->json([
                'code' => 'INVALID_CSRF_TOKEN'
            ], Response::HTTP_BAD_REQUEST);
        };

        $article = $articlesRepository->findOneBy(['id' => $commentData['article']]);

        if (!$article){
            return $this->json([
                'code' => 'ARTICLE_NOT_FOUND'
            ], Response::HTTP_BAD_REQUEST);
        }

        $user = $this->getUser();

        if (!$user){
            return $this->json([
                'code' => 'USER_NOT_AUTHENTICATED_FULLY'
            ], Response::HTTP_BAD_REQUEST);
        }

        $comment = new Comments($article);
        $comment->setContent($commentData['content']);
        $comment->setUser($user);
        $comment->setCreatedAt(new \DateTime());

        $en->persist($comment);
        $en->flush();

        $html = $this->renderView('comments/show.html.twig', [
            'comment' => $comment
        ]);

        return $this->json([
            'code' => 'COMMENT_ADDED_SUCCESSFULLY',
            'message' => $html,
            'NumberOfComments' => $commentsRepository->count(['article' => $article])
        ]);


    }
}
