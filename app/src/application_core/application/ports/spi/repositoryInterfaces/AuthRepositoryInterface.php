<?php

namespace toubilib\core\application\ports\spi\repositoryInterfaces;

use toubilib\core\domain\entities\praticien\User;

interface AuthRepositoryInterface
{

    public function getUserByEmail($email , $mdp) ;

    public function save(User $user);

}