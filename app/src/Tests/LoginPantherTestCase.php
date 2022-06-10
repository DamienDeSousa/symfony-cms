<?php

/**
 * Defines the LoginPantherTestCase class.
 *
 * @author Damien DE SOUSA
 */

declare(strict_types=1);

namespace App\Tests;

use Symfony\Component\Panther\Client;
use App\Tests\Provider\Actions\LogAction;

/**
 * Defines functions to login and logout on back office.
 */
abstract class LoginPantherTestCase extends FixturePantherTestCase
{
    use LogAction;

    protected ?Client $client = null;

    /**
     * @inheritdoc
     */
    protected function setUp(): void
    {
        $this->client = $this->initUserConnection();
    }

    /**
     * @inheritdoc
     */
    protected function tearDown(): void
    {
        $this->adminLogout($this->client, $this->client->refreshCrawler());
    }
}
