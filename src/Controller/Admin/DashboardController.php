<?php

namespace App\Controller\Admin;

use App\Entity\Article;
use App\Entity\Competence;
use App\Entity\Message;
use App\Entity\Project;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\UserMenu;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        /** @var AdminUrlGenerator */
        $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);

        return $this->redirect($adminUrlGenerator->setController(ProjectCrudController::class)->generateUrl());
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Portfolio');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToCrud('Liste des projets', 'fa fa-code', Project::class);
        yield MenuItem::linkToCrud('Liste des articles', 'fa fa-feather-pointed', Article::class);
        yield MenuItem::linkToCrud('Liste des compétences', 'fa fa-tags', Competence::class);
        yield MenuItem::linkToCrud('Messages', 'fa fa-envelope', Message::class);
    }

    /**
     * configureUserMenu.
     *
     * @param User $user
     */
    public function configureUserMenu(UserInterface $user): UserMenu
    {
        /** @var AdminUrlGenerator */
        $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        $url = $adminUrlGenerator
            ->setController(UserCrudController::class)
            ->setEntityId($user->getId())
            ->setAction(Action::DETAIL)
            ->generateUrl()
        ;

        return parent::configureUserMenu($user)
            ->addMenuItems([
                MenuItem::linkToUrl('Mon profil', 'fa fa-id-card', $url),
            ]);
    }
}
