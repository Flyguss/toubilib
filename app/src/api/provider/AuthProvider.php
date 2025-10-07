<?php

namespace toubilib\core\application\usecases;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use toubilib\core\application\ports\api\dtos\AuthDTO;
use toubilib\core\application\ports\api\ServiceAuthInterface;
use toubilib\core\application\ports\api\dtos\AuthTokensDTO;

class AuthProvider
{
    private ServiceAuthInterface $authService;
    private string $jwtSecret = 'super_secret_key';
    private string $jwtIssuer = 'toubilib.api';
    private int $accessTokenTTL = 3600;
    private int $refreshTokenTTL = 86400;

    public function __construct(ServiceAuthInterface $authService)
    {
        $this->authService = $authService;
    }

    public function signin(string $email, string $password): AuthDTO
    {
        // Vérifie les credentials avec ton service de l’exercice 1
        $user = $this->authService->authentification($email, $password);

        // Génère les JWT
        $issuedAt = time();

        $accessToken = JWT::encode([
            'iss' => $this->jwtIssuer,
            'iat' => $issuedAt,
            'exp' => $issuedAt + $this->accessTokenTTL,
            'sub' => $user->getId(),
            'role' => $user->getRole(),
            'email' => $user->getEmail()
        ], $this->jwtSecret, 'HS256');

        $refreshToken = JWT::encode([
            'iss' => $this->jwtIssuer,
            'iat' => $issuedAt,
            'exp' => $issuedAt + $this->refreshTokenTTL,
            'sub' => $user->getId()
        ], $this->jwtSecret, 'HS256');

        return new AuthDTO( $user->getId(), $user->getEmail(), $user->getRole(), $accessToken, $refreshToken
        );
    }
}
