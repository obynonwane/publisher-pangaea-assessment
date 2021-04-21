<?php

namespace App\Exceptions;

use Exception;

class CreatePublisherException extends Exception
{
    protected $message = "error while publishing message";
    protected $code = "MSG_01";
}
