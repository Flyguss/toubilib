<?php

namespace toubilib\core\application\ports\api\dtos;

class PraticienDetailleDTO
{
    private string $nom , $prenom  , $ville , $email , $telephone , $specialite ;
    private array $moyenPaiment , $motifVisite ;

    public function __construct ($n , $p , $v , $e , $s , $t , $mv , $mp) {
        $this->nom = $n ;
        $this->prenom = $p ;
        $this->ville = $v ;
        $this->email = $e ;
        $this->specialite = $s ;
        $this->telephone = $t ;
        $this->motifVisite = $mv ;
        $this->moyenPaiment = $mp ;
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

    public function getTelephone() {
        return $this->telephone ;
    }

    public function getMoyenPaiment() {
        return $this->moyenPaiment ;
    }

    public function getMotifVisite() {
        return $this->motifVisite ;
    }

}