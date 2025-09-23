<?php

namespace toubilib\infra\repositories;

use toubilib\core\application\ports\api\dtos\PatientDTO;
use toubilib\core\application\ports\spi\repositoryInterfaces\PatientRepositoryInterface;


class PatientRepository implements PatientRepositoryInterface
{


    private \PDO $pdo;

    public function __construct(\PDO $pdo) {
        $this->pdo = $pdo;
    }


    public function getPatientByid($id)
    {
        $requete = $this->pdo->prepare('SELECT * from patient where id=:id') ;
        $requete->execute([
            'id' => $id
        ]) ;

        $row = $requete->fetch(\PDO::FETCH_ASSOC) ;

        if (!$row) {
            return null; // ou false
        }

        $praticien = new PatientDTO( $row['nom'] , $row['prenom'] ) ;
        return $praticien ;
    }
}