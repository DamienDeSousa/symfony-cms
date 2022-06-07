<?php

/**
 * Defines the AssertMessageProvider abstract class.
 *
 * @author Damien DE SOUSA
 */

declare(strict_types=1);

namespace App\Tests\Provider;

/**
 * Provides messages for test assertions.
 */
abstract class AssertMessageProvider
{
    public const EXPECTED_ERROR_ALERT_MESSAGE = 'Expected %s alert messages, got %s';

    public const EXPECTED_ERROR_ON_PAGE_MESSAGE = 'Expected to be on page %s, actual page is %s';

    public const EXPECTED_ROWS_NUMBER_ERROR_MESSAGE = 'Expected %s rows, got %s';

    public const EXPECTED_NO_RESULT_ERROR_MESSAGE = 'Expected no result message but wasnt displayed';

    public const COUNT_EXPECTED_NO_RESULT_MESSAGE = 1;

    public const EXPECTED_ROW_ENTITY_ID_ERROR_MESSAGE = 'Expected row with entity id %d, got %s';
}
