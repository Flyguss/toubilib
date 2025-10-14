<?php

namespace toubilib\core\application\ports\api\dtos;

class AuthDTO
{
    private string $id;
    private string $email;
    private int $role;
    private string $accessToken;
    private string $refreshToken;

    public function __construct($dto, string $accessToken, string $refreshToken)
    {
        $this->id = $dto->getId();
        $this->email = $dto->getEmail();
        $this->role = $dto->getRole();
        $this->accessToken = $accessToken;
        $this->refreshToken = $refreshToken;
    }

    public function getId(): string { return $this->id; }
    public function getEmail(): string { return $this->email; }
    public function getRole(): int { return $this->role; }
    public function getAccessToken(): string { return $this->accessToken; }
    public function getRefreshToken(): string { return $this->refreshToken; }
}
