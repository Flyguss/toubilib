<?php

namespace toubilib\core\application\ports\spi\repositoryInterfaces;

interface PraticienRepositoryInterface
{

    public function getPraticiens() ;

    public function GetPraticienById($id);

}