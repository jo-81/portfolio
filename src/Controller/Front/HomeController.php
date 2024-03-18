<?php

namespace App\Controller\Front;

use App\Entity\Article;
use App\Entity\Project;
use App\Repository\ArticleRepository;
use App\Repository\CompetenceRepository;
use App\Repository\PostRepository;
use App\Repository\ProjectRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    public function __construct(
        private CompetenceRepository $competenceRepository
    ) {
    }

    #[Route('/', name: 'homepage', methods: ['GET'])]
    public function index(PostRepository $postRepository): Response
    {
        return $this->render('front/home/homepage.html.twig', [
            'posts' => $postRepository->findBy(['published' => true], ['createdAt' => 'DESC']),
            'numberPost' => $postRepository->count(['published' => true]),
            'competences' => $this->competenceRepository->findCompetencesByPost(),
        ]);
    }

    #[Route('/projects', name: 'projects', methods: ['GET'])]
    public function projects(ProjectRepository $projectRepository): Response
    {
        return $this->render('front/project/projects.html.twig', [
            'posts' => $projectRepository->findBy(['published' => true], ['createdAt' => 'DESC']),
            'numberPost' => $projectRepository->count(['published' => true]),
            'competences' => $this->competenceRepository->findCompetencesByPost(Project::class),
        ]);
    }

    #[Route('/articles', name: 'articles', methods: ['GET'])]
    public function articles(ArticleRepository $articleRepository): Response
    {
        return $this->render('front/article/articles.html.twig', [
            'posts' => $articleRepository->findBy(['published' => true], ['createdAt' => 'DESC']),
            'numberPost' => $articleRepository->count(['published' => true]),
            'competences' => $this->competenceRepository->findCompetencesByPost(Article::class),
        ]);
    }
}
