<?php

namespace toubilib\core\application\ports\api\dtos;

class AuthDTO
{
    private string $email , $mdp   ;
    private int $role ;

    public function __construct ($e , $mdp ,$r ) {
        $this->mdp = $mdp ;
        $this->email = $e ;
        $this->role = $r ;

    }

    public function getEmail () {
        return $this->email ;
    }

    public function getMdp () {
        return $this->mdp ;
    }

    public function getRole () {
        return $this->role ;
    }
}