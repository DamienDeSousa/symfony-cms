<?php

/**
 * File that defines the LogAction trait. This trait is used to provides log actions to the tests.
 *
 * @author    Damien DE SOUSA <desousadamien30@gmail.com>
 * @copyright 2021 Damien DE SOUSA
 */

declare(strict_types=1);

namespace App\Tests\Provider\Actions;

use App\Entity\User;
use Symfony\Component\Panther\Client;
use Symfony\Component\Panther\DomCrawler\Crawler;

trait LogAction
{
    public function login(User $user, $loginUrl, Client $client): Crawler
    {
        $crawler = $client->request('GET', $loginUrl);
        $loginForm = $crawler->selectButton('_submit')->form([
            '_username' => $user->getUsername(),
            '_password' => $user->getPassword()
        ]);

        return $client->submit($loginForm);
    }

    public function adminLogout(Client $client, Crawler $crawler): Crawler
    {
        $client->waitFor('#dropdownMenuButton');
        $client->executeScript("document.querySelector('#dropdownMenuButton').click()");

        $link = $crawler->filter('#logout')->attr('href');

        return $client->request('GET', $link);
    }
}
