<?php

namespace App\Exceptions;

use Exception;

class HasAccountsException extends Exception
{
    protected $message;

    public function __construct(string $message = 'User has linked accounts.')
    {
        parent::__construct($message);
    }
}
