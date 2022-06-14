<?php

/**
 * Defines the FixturePantherTestCase class.
 *
 * @author Damien DE SOUSA
 */

declare(strict_types=1);

namespace App\Tests;

use App\Fixture\FixtureAttachedTrait;
use App\Tests\Provider\Uri\UriProvider;
use App\Tests\Provider\Uri\AdminUriProvider;
use App\Tests\Provider\Url\AdminUrlProvider;
use Symfony\Component\Panther\PantherTestCase;
use App\Tests\Provider\Actions\NavigationAction;

/**
 * Defines setUp and tearsDown method and giving some useful methods for tests.
 */
abstract class FixturePantherTestCase extends PantherTestCase
{
    use FixtureAttachedTrait {
        setUp as setUpTrait;
    }

    use AdminUriProvider;

    use NavigationAction;

    use AdminUrlProvider;

    use UriProvider;
}
