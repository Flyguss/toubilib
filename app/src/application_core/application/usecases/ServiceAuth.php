<?php

namespace toubilib\core\application\usecases;

use toubilib\core\application\exceptions\AuthenticationFailedException;
use toubilib\core\application\exceptions\RepositoryEntityNotFoundException;
use toubilib\core\application\ports\api\dtos\CredentialDTO;
use toubilib\core\application\ports\api\dtos\ProfileDTO;
use toubilib\core\application\ports\api\ServiceAuthInterface;
use toubilib\core\application\ports\spi\repositoryInterfaces\AuthRepositoryInterface;
use toubilib\core\domain\entities\praticien\User;


class ServiceAuth implements ServiceAuthInterface
{

    private AuthRepositoryInterface $AuthRepository;

    public function __construct(AuthRepositoryInterface $AuthRepository)
    {
        $this->AuthRepository = $AuthRepository;
    }

    public function register(CredentialDTO $credentials, int $role): ProfileDTO {
        try {
            $user = new User($credentials->getEmail(), $credentials->getMdp(), $role);
            $id = $this->AuthRepository->save($user);
            $user->setId($id);
        } catch( \Exception $e) {
            throw new AuthenticationFailedException('Registration failed: ' . $e->getMessage());
        }
        return new ProfileDTO($user->getID(), $user->getEmail(), $user->getRole());
    }

    public function authentification($dto)
    {
        try {
            $user = $this->AuthRepository->getUserByEmail($dto->getEmail , $dto->getMdp());
        } catch (RepositoryEntityNotFoundException $e) {
            throw new AuthenticationFailedException('Invalid credentials');
        }
        if (password_verify($dto->password, $user->getPassword())) {
            return new ProfileDTO($user->getID(), $user->getEmail(), $user->getRole());
        }
        throw new AuthenticationFailedException('Invalid credentials');

    }
}