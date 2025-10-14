<?php

namespace toubilib\api\provider\jwt;
use Firebase\JWT\JWT;
use toubilib\core\application\ports\spi\exceptions\Interface\JwtManagerInterface;

class JwtManager implements JwtManagerInterface {
    private string $secret;
    private int $access_expiration_time;
    private int $refresh_expiration_time;
    private string $issuer;
    public function __construct(string $secret, int $expirationTime, int $refreshExpirationTime) {
        $this->secret = $secret;
        $this->access_expiration_time = $expirationTime;
        $this->refresh_expiration_time = $refreshExpirationTime;
    }
    public function setIssuer(string $issuer): void {
        $this->issuer = $issuer;
    }
    public function create(array $payload, int $type): string {
        if ($type === JwtManagerInterface::ACCESS_TOKEN) {
            $expirationTime = time() + $this->access_expiration_time;
        } else {
            $expirationTime = time() +$this->refresh_expiration_time;
        }
        return JWT::encode([
            'iss' => $this->issuer,
            'sub' => $payload['id'],
            'iat' => time(),
            'exp' => $expirationTime,
            'upr' => $payload
        ], $this->secret, 'HS512');

    }

}