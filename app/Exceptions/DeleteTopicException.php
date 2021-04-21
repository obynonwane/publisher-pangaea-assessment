<?php

namespace App\Exceptions;

use Exception;

class DeleteTopicException extends Exception
{
    protected $message = "error while deleting topic";
    protected $code = "TOP_02";
}
