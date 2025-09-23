<?php

namespace toubilib\core\application\ports\api\dtos;

class PatientDTO
{
    private string $nom , $prenom  ;

    public function __construct ($n , $p ) {
        $this->nom = $n ;
        $this->prenom = $p ;

    }

    public function getNom () {
        return $this->nom ;
    }

    public function getPrenom () {
        return $this->prenom ;
    }
}