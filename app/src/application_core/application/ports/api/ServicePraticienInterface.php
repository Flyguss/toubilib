<?php

namespace toubilib\core\application\ports\api;

use toubilib\core\application\ports\api\dtos\PraticienDetailleDTO;

interface ServicePraticienInterface
{

    public function listerPraticiens(): array ;

    public function PraticiensDetaille($id) : PraticienDetailleDTO;

}