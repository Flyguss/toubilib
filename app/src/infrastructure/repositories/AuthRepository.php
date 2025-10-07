<?php

namespace toubilib\infra\repositories;


use toubilib\core\application\ports\spi\repositoryInterfaces\AuthRepositoryInterface;
class AuthRepository implements AuthRepositoryInterface
{


    private \PDO $pdo;

    public function __construct(\PDO $pdo) {
        $this->pdo = $pdo;
    }


    public function getUserByEmail($email) {
        $requete = $this->pdo->prepare('SELECT * from users where email=:email') ;
        $requete->execute([
            'email' => $email
        ]) ;

        $row = $requete->fetch(\PDO::FETCH_ASSOC) ;
        $user = ['email' => $row['email'] , 'mdp' =>  $row['password'] , 'role' =>  $row['role'] ] ;
        return $user ;

    }
}