<?php

namespace toubilib\core\application\ports\api\dtos;

class RdvDTO
{
    private string $motif , $dateD , $dateF ;

    public function __construct ($m , $dd , $df) {
        $this->dateF = $df ;
        $this->dateD = $dd ;
        $this->motif = $m ;
    }

    public function getMotif () {
        return $this->motif ;
    }

    public function getDateDebut () {
        return $this->dateD ;
    }

    public function getDateFin () {
        return $this->dateF ;
    }

}