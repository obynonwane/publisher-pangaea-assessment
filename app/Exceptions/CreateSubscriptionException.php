<?php

namespace App\Exceptions;

use Exception;

class CreateSubscriptionException extends Exception
{
    protected $message = "error while creating subscription";
    protected $code = "SUB_01";
}
