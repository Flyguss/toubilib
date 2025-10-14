<?php

namespace toubilib\api\provider;

use toubilib\core\application\exceptions\AuthenticationFailedException;
use toubilib\core\application\exceptions\AuthProviderInvalidCredentials;
use toubilib\core\application\ports\api\dtos\AuthDTO;
use toubilib\core\application\ports\api\dtos\CredentialDTO;
use toubilib\core\application\ports\api\ServiceAuthInterface;
use toubilib\core\application\ports\spi\exceptions\Interface\JwtManagerInterface;

class AuthProvider
{
    private ServiceAuthInterface $authService;
    private JwtManagerInterface $jwtManager ;

    public function __construct(ServiceAuthInterface $authService , JwtManagerInterface $jwtManager)
    {
        $this->authService = $authService;
        $this->jwtManager = $jwtManager ;

    }

    public function signin(CredentialDTO $dto): AuthDTO
    {
        try {
            // Vérifie les credentials avec ton service de l’exercice 1
            $user = $this->authService->authentification($dto);

            $accesstoken = $this->jwtManager->create([
                'id' => $user->ID,
                'email' => $user->email,
                'role' => $user->role
            ], JwtManagerInterface::ACCESS_TOKEN);
            $refreshtoken = $this->jwtManager->create([
                'id' => $user->ID,
                'email' => $user->email,
                'role' => $user->role
            ], JwtManagerInterface::REFRESH_TOKEN);

            $dto = new AuthDTO($user->getId(), $user->getEmail(), $user->getRole(), $accesstoken, $refreshtoken
            );
        }catch (AuthenticationFailedException $e) {
                throw new AuthProviderInvalidCredentials('Invalid credentials');
            }
        return $dto ;
    }
}
