<?php

namespace toubilib\infra\repositories;



use DateTime;
use toubilib\core\application\ports\api\dtos\InputRdvDTO;
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

    public function getRdvById($id)
    {
        $requete = $this->pdo->prepare('SELECT * from rdv where id=:id') ;
        $requete->execute([
            'id' => $id
        ]) ;

        $row = $requete->fetch(\PDO::FETCH_ASSOC) ;
        $rdv = new RdvDTO($row['motif_visite'] , $row['date_heure_debut'] , $row['date_heure_fin'])  ;
        return $rdv ;
    }

    /**
     * @throws \Exception
     */
    public function createRDV($idprat, $idpat, $date, $heure, $motif, $duree)
    {
        // Créer les objets DateTime
        $dateHeureDebut = new DateTime("$date $heure");
        $dateFin = (clone $dateHeureDebut)->add(\DateInterval::createFromDateString($duree . ' minutes'));

        // Formatage en string pour PostgreSQL
        $debutStr = $dateHeureDebut->format('Y-m-d H:i:s');
        $finStr = $dateFin->format('Y-m-d H:i:s');

        $stmt = $this->pdo->prepare("
        INSERT INTO rdv (
            id, praticien_id, patient_id, date_heure_debut, date_heure_fin, motif_visite, duree, status, date_creation
        ) VALUES (
            :id, :prat, :pat, :debut, :fin, :motif, :duree, 0, NOW()
        )
    ");

        $idRdv = $this->generateUuid() ;

        $stmt->execute([
            ':id' => $idRdv,
            ':prat' => $idprat,
            ':pat' => $idpat,
            ':debut' => $debutStr,
            ':fin' => $finStr,
            ':motif' => $motif,
            ':duree' => $duree
        ]);

        return "Insertion réussie du rdv d'id $idRdv";
    }

    public function generateUuid() {
        return sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            random_int(0, 0xffff), random_int(0, 0xffff),
            random_int(0, 0xffff),
            random_int(0, 0x0fff) | 0x4000,
            random_int(0, 0x3fff) | 0x8000,
            random_int(0, 0xffff), random_int(0, 0xffff), random_int(0, 0xffff)
        );
    }

    public function DeleteRDVById($idRdv)
    {
        $stmt = $this->pdo->prepare("DELETE FROM rdv WHERE id = :id");
        $stmt->execute(['id' => $idRdv]);
    }
}