<?php

namespace toubilib\core\application\exceptions;

class JwtManagerInvalidTokenException extends \Exception
{
    public function __construct(
        string $message = "Invalid JWT token.",
        int $code = 401,
        ?\Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }
}
