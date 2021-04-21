<?php

namespace App\Exceptions;

use Exception;

class CreateTopicException extends Exception
{
    protected $message = "error while creating topic";
    protected $code = "TOP_01";
}
