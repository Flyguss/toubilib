<?php

namespace toubilib\infra\repositories;



use toubilib\core\application\ports\api\dtos\PraticienDetailleDTO;
use toubilib\core\application\ports\api\dtos\PraticienDTO;
use toubilib\core\application\ports\api\dtos\RdvDTO;
use toubilib\core\application\ports\spi\repositoryInterfaces\PraticienRepositoryInterface;
use toubilib\core\application\ports\spi\repositoryInterfaces\RDVRepositoryInterface;
use toubilib\core\domain\entities\praticien\Praticien;

class RDVRepository implements RDVRepositoryInterface
{


    private \PDO $pdo;

    public function __construct(\PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function GetRDVForPraticienBetween2Date($id, $dateDebut, $dateFin): array {
        $requete = $this->pdo->prepare( "SELECT *
                                                    FROM rdv
                                                    WHERE praticien_id = :id
                                                      AND date_heure_debut >= :dateD
                                                      AND date_heure_debut < (:dateF::date + interval '1 day')
                                                    ORDER BY date_heure_debut ASC;
                                                    ") ;
        $requete->execute([
           'id' => $id,
           'dateD' => $dateDebut,
           'dateF' => $dateFin
        ]);

        $rdvs = [] ;
        while($row = $requete->fetch(\PDO::FETCH_ASSOC)) {
            $rdv = new RdvDTO($row['motif_visite'] , $row['date_heure_debut'] , $row['date_heure_fin'])  ;
            $rdvs[] = $rdv ;
        }

        return $rdvs ;
    }
}