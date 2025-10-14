<?php

namespace toubilib\core\domain\entities\praticien;

class User
{
    private string $id;
    private string $email;
    private string $mdp;
    private int $role;

    public function __construct(string $email, string $mdp, int $role)
    {

        $this->email = $email;
        $this->mdp = $mdp;
        $this->role = $role;
    }

    public function setId($id)
    {
        $this->id = $id ;
    }

    public function getEmail(): string { return $this->email; }
    public function getMdp(): string { return $this->mdp; }
    public function getRole(): int { return $this->role; }

    public function getID(){
        return $this->id ;
    }
}
