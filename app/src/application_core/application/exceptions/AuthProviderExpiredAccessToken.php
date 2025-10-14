<?php

namespace toubilib\core\application\exceptions;

class AuthProviderExpiredAccessToken extends \Exception
{
    public function __construct(
        string $message = "Expired access token.",
        int $code = 401,
        ?\Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }
}
