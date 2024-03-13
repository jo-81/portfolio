<?php

namespace App\Tests\Controller\Admin;

use App\Controller\Admin\ArticleCrudController;
use App\Controller\Admin\DashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Test\AbstractCrudTestCase;

final class ArticleControllerTest extends AbstractCrudTestCase
{
    protected function getControllerFqcn(): string
    {
        return ArticleCrudController::class;
    }

    protected function getDashboardFqcn(): string
    {
        return DashboardController::class;
    }

    /**
     * testAccessNotUserLoggedForCreatePage.
     *
     * @dataProvider getDataForPageWhenUserNotLogged
     */
    public function testAccessNotUserLoggedForCreatePage(string $action, ?int $id): void
    {
        $this->client->request('GET', $this->getCrudUrl($action, $id));
        $this->assertResponseRedirects('/login');
    }

    /**
     * getDataForPageWhenUserNotLogged.
     *
     * @return array<mixed>
     */
    public static function getDataForPageWhenUserNotLogged(): array
    {
        return [
            ['index', null],
            ['detail', 1],
            ['new', null],
            ['edit', 1],
            ['delete', 1],
        ];
    }
}
