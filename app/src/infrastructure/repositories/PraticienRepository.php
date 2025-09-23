<?php

namespace toubilib\infra\repositories;



use toubilib\core\application\ports\api\dtos\PraticienDetailleDTO;
use toubilib\core\application\ports\api\dtos\PraticienDTO;
use toubilib\core\application\ports\spi\repositoryInterfaces\PraticienRepositoryInterface;
use toubilib\core\domain\entities\praticien\Praticien;

class PraticienRepository implements PraticienRepositoryInterface
{


    private \PDO $pdo;

    public function __construct(\PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function getPraticiens() : array {
        $requete = $this->pdo->prepare('SELECT * from praticien') ;
        $requete->execute() ;

        $praticiens = [] ;
        while($row = $requete->fetch(\PDO::FETCH_ASSOC)) {
            $praticien = new PraticienDTO($row['nom'] , $row['prenom'] , $row['ville'] , $row['email'] ,$this->getSpecialiteFromId( $row['specialite_id'])) ;
            $praticiens[] = $praticien ;
        }

        return $praticiens ;
    }

    public function getSpecialiteFromId ($id) : string {
        $requete = $this->pdo->prepare('SELECT libelle from specialite where id=:id') ;
        $requete->execute([
            'id' => $id
        ]) ;

        while($row = $requete->fetch(\PDO::FETCH_ASSOC)) {
            $spe = $row['libelle'];
        }

        return $spe ;

    }

    public function GetPraticienById($id) {
        $requete = $this->pdo->prepare('SELECT * from praticien where id=:id') ;
        $requete->execute([
            'id' => $id
        ]) ;

        $row = $requete->fetch(\PDO::FETCH_ASSOC) ;
        $praticien = new PraticienDetailleDTO($row['nom'] , $row['prenom'] , $row['ville'] , $row['email'] ,$this->getSpecialiteFromId( $row['specialite_id']) , $row['telephone'] , $this->getMotifVisiteFromPraticienId($row['id']) , $this->getMoyenPaimentFromPraticienId($row['id'])) ;
        return $praticien ;
    }

    public function getMoyenPaimentFromPraticienId($id) : array{
        $requete = $this->pdo->prepare('SELECT * from praticien2moyen inner join moyen_paiement on praticien2moyen.moyen_id = moyen_paiement.id where praticien_id=:id') ;
        $requete->execute([
            'id' => $id
        ]) ;

        $moyens = [] ;
        while($row = $requete->fetch(\PDO::FETCH_ASSOC)) {
            $moyen = $row['libelle'] ;
            $moyens[] = $moyen ;
        }

        return $moyens ;
    }

    public function getMotifVisiteFromPraticienId($id) : array{
        $requete = $this->pdo->prepare('SELECT * from praticien2motif inner join motif_visite on praticien2motif.motif_id = motif_visite.id where praticien_id=:id ') ;
        $requete->execute([
            'id' => $id
        ]) ;

        $motifs = [] ;
        while($row = $requete->fetch(\PDO::FETCH_ASSOC)) {
            $motif = $row['libelle'] ;
            $motifs[] = $motif ;
        }

        return $motifs ;
    }

    public function GetRDVForPraticienBetween2Date($id, $dateDebut, $dateFin): array {
        $requete = $this->pdo->prepare('SELECT * FROM rdv  WHERE praticien_id = :id AND date_heure_debut BETWEEN :dateD AND :dateF ORDER BY date_heure_debut ASC;') ;
        $requete->execute([
           'id' => $id,
           'dateD' => $dateDebut,
           'dateF' => $dateFin
        ]);

        $rdvs = [] ;
        while($row = $requete->fetch(\PDO::FETCH_ASSOC)) {
            $rdv = $row[''] ;
            $rdvs[] = $rdv ;
        }

        return $rdvs ;
    }
}