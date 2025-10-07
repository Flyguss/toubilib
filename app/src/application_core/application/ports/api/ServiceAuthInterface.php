<?php

namespace toubilib\core\application\ports\api;

interface ServiceAuthInterface {

    public function authentification($email , $mdp) ;

}