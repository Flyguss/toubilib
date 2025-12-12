<?php

namespace toubilib\core\application\ports\spi\repositoryInterfaces;

interface PraticienRepositoryInterface
{

    public function getPraticiens() ;

    public function GetPraticienById($id);

    public function GetPraticienBySpecialityId(mixed $specialiteId);

    public function GetPraticienByVille($ville);

    public function GetPraticienBySpecialityIdandVille(mixed $specialiteId, mixed $ville);

}