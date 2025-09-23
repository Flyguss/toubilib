<?php

namespace toubilib\core\application\usecases;


use toubilib\core\application\ports\api\dtos;
use toubilib\core\application\ports\api\dtos\InputRdvDTO;
use toubilib\core\application\ports\api\ServiceRDVInterface;
use toubilib\core\application\ports\spi\repositoryInterfaces\PraticienRepositoryInterface;
use toubilib\core\application\ports\spi\repositoryInterfaces\RDVRepositoryInterface;

class ServiceRDV implements ServiceRDVInterface
{
    private RDVRepositoryInterface $RDVRepository;

    public function __construct(RDVRepositoryInterface $RDVRepository)
    {
        $this->RDVRepository = $RDVRepository;
    }


    public function rdvPraticienBetween2Date($id, $dateD, $dateF): array
    {
        return $this->RDVRepository->GetRDVForPraticienBetween2Date($id , $dateD , $dateF) ;
    }

    public function Rdv($id)
    {
        return $this->RDVRepository->getRdvById($id) ;
    }

    public function CreerRdv(InputRdvDTO $input)
    {
        return $this->RDVRepository->createRDV($input->getIdPrat() , $input->getIdPat() , $input->getDate() , $input->getHeure() , $input->getMotif() , $input->getDuree()) ;
    }
}