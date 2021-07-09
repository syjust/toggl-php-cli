<?php

namespace App\Toggl;

use Exception;
use Throwable;

/**
 * Class TogglClientException
 *
 * @package App\Client
 */
class TogglClientException extends Exception
{

    /**
     * TogglClientException constructor.
     */
    public function __construct(string $message, Throwable $previous)
    {
        parent::__construct($message, $previous->getCode(), $previous);
    }
}
