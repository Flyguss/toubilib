<?php

namespace toubilib\core\application\usecases;


use DateTime;
use toubilib\core\application\ports\api\dtos;
use toubilib\core\application\ports\api\dtos\InputRdvDTO;
use toubilib\core\application\ports\api\ServiceRDVInterface;
use toubilib\core\application\ports\spi\repositoryInterfaces\PatientRepositoryInterface;
use toubilib\core\application\ports\spi\repositoryInterfaces\PraticienRepositoryInterface;
use toubilib\core\application\ports\spi\repositoryInterfaces\RDVRepositoryInterface;

class ServiceRDV implements ServiceRDVInterface
{
    private RDVRepositoryInterface $RDVRepository;
    private PraticienRepositoryInterface $PraticienRepository;
    private PatientRepositoryInterface $PatientRepository;

    public function __construct(RDVRepositoryInterface $RDVRepository , PraticienRepositoryInterface $PraticienRepository , PatientRepositoryInterface $PatientRepository)
    {
        $this->RDVRepository = $RDVRepository;
        $this->PatientRepository = $PatientRepository ;
        $this->PraticienRepository = $PraticienRepository ;

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
        if (!$this->PraticienRepository->GetPraticienById($input->getIdPrat())) {
            throw new \DomainException("Le praticien n'existe pas.");
        }

        if (!$this->PatientRepository->getPatientByid($input->getIdPat())) {
            throw new \DomainException("Le patient n'existe pas.");
        }

        if (!$this->PraticienRepository->verifyMotifOfPraticienByLibelleAndIdPraticien($input->getMotif() , $input->getIdPrat())) {
            throw new \DomainException("Le motif n'existe pas ou le praticiens n'accepte pas ce motif");
        }

        $d = $input->getDate() ;
        $h = $input->getHeure() ;

        $dateDebut = new DateTime("$d $h");
        $dateFin = (clone $dateDebut)->add(\DateInterval::createFromDateString($input->getDuree() . ' minutes'));

        $jourSemaine = (int) $dateDebut->format('N'); // 1 = lundi, ..., 7 = dimanche
        $heureDebut = (int) $dateDebut->format('H');
        $heureFin   = (int) $dateFin->format('H');

        if ($jourSemaine > 5) {
            throw new \DomainException("Les rendez-vous ne sont possibles que du lundi au vendredi.");
        }
        if ($heureDebut < 8 || $heureFin >= 19) {
            throw new \DomainException("Les rendez-vous doivent être pris entre 8h et 19h.");
        }

        $rdvsExistants = $this->RDVRepository->GetRDVForPraticienBetween2Date($input->getIdPrat(), $dateDebut->format('Y-m-d H:i:s'), $dateFin->format('Y-m-d H:i:s')
        );

        foreach ($rdvsExistants as $rdv) {
            $rdvDebut = new DateTime($rdv->getDateDebut());
            $rdvFin   = new DateTime($rdv->getDateFin());
            if ($dateDebut < $rdvFin && $dateFin > $rdvDebut) {
                throw new \DomainException("Le praticien n'est pas disponible sur ce créneau.");
            }
        }


        return $this->RDVRepository->createRDV($input->getIdPrat() , $input->getIdPat() , $input->getDate() , $input->getHeure() , $input->getMotif() , $input->getDuree()) ;
    }

    public function deleteRDV($idRdv) {
        $rdv = $this->RDVRepository->GetRDVById($idRdv);
        if (!$rdv) {
            throw new \DomainException("Le rendez-vous avec l'ID $id n'existe pas.");
        }

        $this->RDVRepository->DeleteRDVById($idRdv);
    }

    public function updateStatus($id, mixed $status)
    {
        $this->RDVRepository->updateStatus($id , $status);
    }
}