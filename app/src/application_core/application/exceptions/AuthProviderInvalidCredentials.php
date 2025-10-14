<?php

namespace toubilib\core\application\exceptions;

class AuthProviderInvalidCredentials extends \Exception
{
    public function __construct(
        string $message = "Invalid authentication credentials provided.",
        int $code = 401,
        ?\Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }
}
