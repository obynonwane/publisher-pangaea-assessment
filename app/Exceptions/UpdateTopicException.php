<?php

namespace App\Exceptions;

use Exception;

class UpdateTopicException extends Exception
{
    protected $message = "error while updating topic";
    protected $code = "TOP_03";
}
