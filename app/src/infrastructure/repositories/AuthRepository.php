<?php

namespace toubilib\infra\repositories;


use Ramsey\Uuid\Uuid;
use toubilib\core\application\ports\spi\repositoryInterfaces\AuthRepositoryInterface;
class AuthRepository implements AuthRepositoryInterface
{


    private \PDO $pdo;

    public function __construct(\PDO $pdo) {
        $this->pdo = $pdo;
    }


    public function getUserByEmail($email , $mdp) {
        $requete = $this->pdo->prepare('SELECT * from users where email=:email') ;
        $requete->execute([
            'email' => $email
        ]) ;

        $row = $requete->fetch(\PDO::FETCH_ASSOC) ;
        $user = ['email' => $row['email'] , 'mdp' =>  $row['password'] , 'role' =>  $row['role'] ] ;
        return $user ;

    }

    public function save(\toubilib\core\domain\entities\praticien\User $user)
    {
        $requete = $this->pdo->prepare('INSERT INTO users values (:id , :email , :mdp , :role)') ;
        $requete->execute([
            'id' => $this->generateUuid() ,
            'email' => $user->getEmail() ,
            'mdp' => $user->getMdp(),
            'role' => $user->getRole()
        ]) ;
    }

    public function generateUuid(): string
    {
        return Uuid::uuid4()->toString();
    }

}