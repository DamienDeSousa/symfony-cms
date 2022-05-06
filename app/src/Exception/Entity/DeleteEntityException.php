<?php

/**
 * File that defines the DeleteEntityException class.
 *
 * @author Damien DE SOUSA
 * @copyright 2022
 */

namespace App\Exception\Entity;

use Throwable;
use App\Exception\TranslateException;

/**
 * Exception to throw when something wrong happens during the deletion of an entity.
 */
class DeleteEntityException extends TranslateException
{
    public const ERROR_CODE = 1501;

    public function __construct(
        string $transMessage,
        array $transMessageParams = [],
        string $message = "",
        int $code = 0,
        ?Throwable $previous = null
    ) {
        $code = self::ERROR_CODE;
        parent::__construct($message, $code, $previous);

        $this->transMessage = $transMessage;
        $this->transMessageParams = $transMessageParams;
    }

    public function getTransMessage(): string
    {
        return $this->transMessage;
    }

    public function getTransMessageParams(): array
    {
        return $this->transMessageParams;
    }
}
