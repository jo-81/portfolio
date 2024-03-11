<?php

namespace App\Tests\Controller;

use Hautelook\AliceBundle\PhpUnit\RefreshDatabaseTrait;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class SecurityControllerTest extends WebTestCase
{
    use RefreshDatabaseTrait;

    public function testRouteLoginExist(): void
    {
        $client = static::createClient();
        $client->request('GET', '/login');
        $this->assertResponseIsSuccessful();
    }

    public function testLoginUserWithGoodCredentials(): void
    {
        $client = static::createClient();
        $client->request('GET', '/login');

        $client->submitForm('Connectez-vous', [
            '_username' => 'admin',
            '_password' => '0',
        ]);

        $client->followRedirects();
        $this->assertResponseRedirects('/admin');
    }

    public function testLoginUserWithBadCredentials(): void
    {
        $client = static::createClient();
        $client->request('GET', '/login');

        $client->submitForm('Connectez-vous', [
            '_username' => 'admin',
            '_password' => '0000',
        ]);

        $client->followRedirects();
        $this->assertResponseRedirects('/login');
    }
}
