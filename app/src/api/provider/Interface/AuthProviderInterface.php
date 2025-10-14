<?php

namespace toubilib\core\application\ports\spi\exceptions\Interface;
use toubilib\core\application\ports\api\dtos\AuthDTO;
use toubilib\core\application\ports\api\dtos\CredentialDTO;
use toubilib\core\application\ports\api\dtos\ProfileDTO;

interface AuthProviderInterface {
    public function register(CredentialDTO $credentials, int $role): ProfileDTO;
    public function signin(CredentialDTO $credentials): AuthDTO;
    public function getSignedInUser(string $token): ProfileDTO;
}