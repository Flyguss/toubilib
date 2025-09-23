<?php

namespace toubilib\core\application\ports\api;

use toubilib\core\application\ports\api\dtos\PraticienDetailleDTO;

interface ServiceRDVInterface
{

    public function rdvPraticienBetween2Date($id , $dateD , $dateF) : array ;

    public function Rdv(mixed $id);

    public function CreerRdv(dtos\InputRdvDTO $input);

}