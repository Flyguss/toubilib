<?php

namespace toubilib\core\application\usecases;


use toubilib\core\application\ports\api\dtos\AuthDTO;
use toubilib\core\application\ports\api\ServiceAuthInterface;
use toubilib\core\application\ports\spi\repositoryInterfaces\AuthRepositoryInterface;


class ServiceAuth implements ServiceAuthInterface
{

    private AuthRepositoryInterface $AuthRepository;

    public function __construct(AuthRepositoryInterface $AuthRepository)
    {
        $this->AuthRepository = $AuthRepository;
    }

    public function authentification($email, $mdp)
    {
        $user = $this->AuthRepository->getUserByEmail($email) ;

        if (!$user) {
            return null ;
        }

        if ($mdp !== $user['mdp']) {
            return null ;
        }

        return new AuthDTO($user['email'] , $user['mdp'] , $user['role']);

    }
}