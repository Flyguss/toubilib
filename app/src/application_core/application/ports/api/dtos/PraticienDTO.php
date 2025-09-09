<?php

namespace toubilib\core\application\ports\api\dtos;

class PraticienDTO
{
    private string $nom , $prenom , $ville , $email , $specialite ;

    public function __construct ($n , $p , $v , $e , $s) {
        $this->nom = $n ;
        $this->prenom = $p ;
        $this->ville = $v ;
        $this->email = $e ;
        $this->specialite = $s ;
    }

    public function getNom () {
        return $this->nom ;
    }

    public function getPrenom () {
        return $this->prenom ;
    }

    public function getVille () {
        return $this->ville ;
    }

    public function getEmail () {
        return $this->email ;
    }

    public function getSpecialite () {
        return $this->specialite ;
    }

}