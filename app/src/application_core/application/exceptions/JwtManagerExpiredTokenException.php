<?php

namespace toubilib\core\application\exceptions;

class JwtManagerExpiredTokenException extends \Exception
{
    public function __construct(
        string $message = "Expired JWT token.",
        int $code = 401,
        ?\Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }
}
