<?php

namespace toubilib\api\provider;

use toubilib\core\application\exceptions\AuthenticationFailedException;
use toubilib\core\application\exceptions\AuthProviderExpiredAccessToken;
use toubilib\core\application\exceptions\AuthProviderInvalidAccessToken;
use toubilib\core\application\exceptions\AuthProviderInvalidCredentials;
use toubilib\core\application\exceptions\JwtManagerExpiredTokenException;
use toubilib\core\application\exceptions\JwtManagerInvalidTokenException;
use toubilib\core\application\ports\api\dtos\AuthDTO;
use toubilib\core\application\ports\api\dtos\CredentialDTO;
use toubilib\core\application\ports\api\dtos\ProfileDTO;
use toubilib\core\application\ports\api\ServiceAuthInterface;
use toubilib\core\application\ports\spi\exceptions\Interface\AuthProviderInterface;
use toubilib\core\application\ports\spi\exceptions\Interface\JwtManagerInterface;

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

    public function getSignedInUser(string $token): ProfileDTO {
        try {
            $payload = $this->jwtManager->validate($token);
        } catch (JwtManagerExpiredTokenException $e) {
            throw new AuthProviderExpiredAccessToken('expired access token :'. $e->getMessage());
        } catch (JwtManagerInvalidTokenException $e) {
            throw new AuthProviderInvalidAccessToken('invalid access token :'. $e->getMessage());
        }
        return new ProfileDTO($payload['id'], $payload['email'], $payload['role']);
    }

}