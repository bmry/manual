<?php

namespace Manual\Exception;

class NotFoundException extends ManualException
{
    public function __construct($message, $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
