<?php

/**
 * File that defines the LogAction trait.
 *
 * @author    Damien DE SOUSA <desousadamien30@gmail.com>
 * @copyright 2021 Damien DE SOUSA
 */

declare(strict_types=1);

namespace App\Tests\Provider\Actions;

use App\Entity\User;
use Symfony\Component\Panther\Client;
use Symfony\Component\Panther\DomCrawler\Crawler;
use App\Tests\Provider\Selector\Admin\UtilsAdminSelector;

/**
 * This trait is used to provides log actions to the tests.
 */
trait LogAction
{
    public function login(User $user, string $loginUrl, Client $client): Crawler
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
        $client->waitFor(UtilsAdminSelector::USER_DETAIL_SELECTOR);
        $client->executeScript(
            sprintf("document.querySelector('%s').click()", UtilsAdminSelector::USER_DETAIL_SELECTOR)
        );
        sleep(1);
        $link = $crawler->filter(UtilsAdminSelector::USER_LOGOUT_LINK_SELECTOR)->attr('href');

        return $client->request('GET', $link);
    }

    public function initUserConnection(): Crawler
    {
        $this->setUpTrait();
        /** @var User $user */
        $user = $this->fixtureRepository->getReference('user');
        $this->client = static::createPantherClient();

        return $this->login($user, $this->provideAdminLoginUri(), $this->client);
    }
}
