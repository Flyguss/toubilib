<?php

namespace toubilib\core\application\ports\api\dtos;

class InputRdvDTO
{
    private string $motif , $date , $heure , $idPrat , $idPat , $duree  ;

    public function __construct ($m , $d , $h , $idPrat , $idPat , $duree) {
        $this->date = $d ;
        $this->heure = $h ;
        $this->motif = $m ;
        $this->idPrat = $idPrat ;
        $this->idPat = $idPat ;
        $this->duree = $duree ;
    }

    public function getMotif () {
        return $this->motif ;
    }

    public function getDate () {
        return $this->date ;
    }

    public function getHeure() {
        return $this->heure ;
    }

    public function getIdPrat() {
        return $this->idPrat ;
    }

    public function getIdPat() {
        return $this->idPat ;
    }

    public function getDuree() {
        return $this->duree ;
    }

}