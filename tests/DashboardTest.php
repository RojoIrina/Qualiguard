<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DashboardTest extends WebTestCase
{
    public function testHealthIsGreenByDefault(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('div', 'SANTÉ OPTIMALE');
    }

    public function testAlertWhenDebtIsHigh(): void
    {
        $client = static::createClient();
        // On simule une dette de 20% via l'URL
        $crawler = $client->request('GET', '/?dette=20');

        $this->assertSelectorTextContains('div', 'ALERTE : Dette technique critique');
    }
}
