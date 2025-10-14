<?php

namespace toubilib\core\application\ports\api\dtos;

class CredentialDTO
{
    private string $mdp;
    private string $email;

    public function __construct(string $email, string $mdp )
    {
        $this->mdp = $mdp;
        $this->email = $email;
    }

    public function getMdp(): string { return $this->mdp; }
    public function getEmail(): string { return $this->email; }
}
