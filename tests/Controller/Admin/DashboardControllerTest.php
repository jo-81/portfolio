<?php

namespace App\Tests\Controller\Admin;

use App\Repository\UserRepository;
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
        $client->request('GET', '/admin');

        $this->assertResponseIsSuccessful();
    }
}
