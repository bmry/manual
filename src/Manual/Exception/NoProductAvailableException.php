<?php

namespace Manual\Exception;

class NoProductAvailableException extends ManualException
{
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        $message = "No Product Available";
        parent::__construct($message, $code, $previous);
    }
}
