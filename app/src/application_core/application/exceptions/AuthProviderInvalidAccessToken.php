<?php

namespace toubilib\core\application\exceptions;

class AuthProviderInvalidAccessToken extends \Exception
{
    public function __construct(
        string $message = "Invalid access token.",
        int $code = 401,
        ?\Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }
}
