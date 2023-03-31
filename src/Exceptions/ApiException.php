<?php

namespace Dimaveresklia\Akurateco\Exceptions;

use Exception;

/**
 * Class ApiException
 *
 * @package Dimaveresklia\Akurateco\Exceptions
 */
class ApiException extends Exception
{
    /**
     * @param string $message
     * @param int|null $code
     */
    public function __construct(string $message, ?int $code = null)
    {
        parent::__construct($message, $code);
    }
}