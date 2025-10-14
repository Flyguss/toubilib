<?php

namespace toubilib\api\provider;

use toubilib\core\application\exceptions\AuthenticationFailedException;
use toubilib\core\application\exceptions\AuthProviderInvalidCredentials;
use toubilib\core\application\ports\spi\exceptions\Interface\AuthProviderInterface;
use toubilib\core\application\ports\spi\exceptions\Interface\JwtManagerInterface;
use toubilib\core\application\ports\api\dtos\AuthDTO;
use toubilib\core\application\ports\api\dtos\CredentialDTO;
use toubilib\core\application\ports\api\dtos\ProfileDTO;
use toubilib\core\application\ports\api\ServiceAuthInterface;

class JwtAuthProvider implements AuthProviderInterface {
    private ServiceAuthInterface $authnService;
    private JwtManagerInterface $jwtManager;
    public function __construct(ServiceAuthInterface $authnService, JwtManagerInterface
                                                              $jwtManager) {
        $this->authnService = $authnService;
        $this->jwtManager = $jwtManager;
    }
    public function signin(CredentialDTO $credentials): AuthDTO {
        try {
            $profile = $this->authnService->authentification($credentials);
            $access_token = $this->jwtManager->create([
                'id' => $profile->ID,
                'email' => $profile->email,
                'role' => $profile->role
            ], JwtManagerInterface::ACCESS_TOKEN);
            $refresh_token = $this->jwtManager->create([
                'id' => $profile->ID,
                'email' => $profile->email,
                'role' => $profile->role
            ], JwtManagerInterface::REFRESH_TOKEN);
            $authDTO = new AuthDTO($profile, $access_token, $refresh_token);
        } catch (AuthenticationFailedException $e) {
            throw new AuthProviderInvalidCredentials('Invalid credentials');
        }
        return $authDTO;
    }

    public function register(CredentialDTO $credentials, int $role): ProfileDTO
    {
        // TODO: Implement register() method.
    }

    public function getSignedInUser(string $token): ProfileDTO
    {
        // TODO: Implement getSignedInUser() method.
    }
}