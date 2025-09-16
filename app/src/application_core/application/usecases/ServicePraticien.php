<?php

namespace toubilib\core\application\usecases;




use toubilib\api\actions\GetPraticienById;
use toubilib\core\application\ports\api\dtos\PraticienDetailleDTO;
use toubilib\core\application\ports\api\ServicePraticienInterface;
use toubilib\core\application\ports\spi\repositoryInterfaces\PraticienRepositoryInterface;

class ServicePraticien implements ServicePraticienInterface
{
    private PraticienRepositoryInterface $praticienRepository;

    public function __construct(PraticienRepositoryInterface $praticienRepository)
    {
        $this->praticienRepository = $praticienRepository;
    }

    public function listerPraticiens(): array {
    	return $this->praticienRepository->getPraticiens() ;
    }

    public function PraticiensDetaille($id): PraticienDetailleDTO
    {
        return $this->praticienRepository->GetPraticienById($id) ;
    }
}