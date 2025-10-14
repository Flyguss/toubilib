<?php

namespace toubilib\core\application\exceptions;

class RepositoryEntityNotFoundException extends \Exception
{
    public function __construct(
        string $message = "Entity not found in repository.",
        int $code = 404,
        ?\Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }
}
