<?php

namespace toubilib\infra\repositories;



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
            $praticien = new PraticienDTO($row['nom'] , $row['prenom'] , $row['ville'] , $row['email'] ,$this->getSpecialiteFromId( $row['specialite_id'])) ;            $praticiens[] = $praticien ;
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
 
}