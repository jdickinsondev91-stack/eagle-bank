<?php

namespace App\Exceptions;

use Exception;

class InsufficientFundsException extends Exception
{
    protected $message;

    public function __construct(string $message = 'Insufficient funds.')
    {
        parent::__construct($message);
    }
}
