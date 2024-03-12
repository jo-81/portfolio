<?php

namespace App\Tests\Controller\Admin;

use App\Controller\Admin\UserCrudController;
use App\Repository\UserRepository;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Security\Core\User\UserInterface;

final class DashboardControllerTest extends WebTestCase
{
    public function testNotAccessWhenUserNotLogged(): void
    {
        $client = static::createClient();
        $client->request('GET', '/admin');
        $this->assertResponseRedirects('/login');
    }

    public function testAccessWhenUserLogged(): void
    {
        $client = static::createClient();
        /** @var UserRepository */
        $userRepository = static::getContainer()->get(UserRepository::class);
        /** @var UserInterface */
        $testUser = $userRepository->find(1);
        $client->loginUser($testUser);

        /** @var AdminUrlGenerator */
        $adminUrlGenerator = static::getContainer()->get(AdminUrlGenerator::class);
        $path = $adminUrlGenerator->setController(UserCrudController::class)
            ->setEntityId(1)
            ->setAction(Action::DETAIL)
            ->generateUrl()
        ;

        $client->request('GET', $path);

        $this->assertResponseIsSuccessful();
    }
}
