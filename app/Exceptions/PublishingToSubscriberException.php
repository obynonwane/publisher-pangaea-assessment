<?php

namespace App\Exceptions;

use Exception;

class PublishingToSubscriberException extends Exception
{
    protected $message = "Error while Publishing to Subscribers";
    protected $code = "SUB_02";
}
