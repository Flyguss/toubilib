<?php

namespace toubilib\core\application\ports\spi\repositoryInterfaces;

interface RDVRepositoryInterface
{

    public function GetRDVForPraticienBetween2Date($id , $dateDebut , $dateFin) : array ;

}