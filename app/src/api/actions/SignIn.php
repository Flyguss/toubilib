<?php

namespace toubilib\api\actions;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use toubilib\core\application\usecases\AuthProvider;

class SignIn extends AbstractAction
{
    private AuthProvider $authProvider;

    public function __construct(AuthProvider $authProvider)
    {
        $this->authProvider = $authProvider;
    }

    public function __invoke(ServerRequestInterface $rq, ResponseInterface $rs, array $args): ResponseInterface
    {
        $data = $rq->getParsedBody();

        // Validation des champs
        if (empty($data['email']) || empty($data['password'])) {
            $rs->getBody()->write(json_encode(['error' => 'Email et mot de passe requis']));
            return $rs->withStatus(400)->withHeader('Content-Type', 'application/json');
        }

        try {
            $authDTO = $this->authProvider->signin($data['email'], $data['password']);

            $rs->getBody()->write(json_encode([
                'id' => $authDTO->getId(),
                'email' => $authDTO->getEmail(),
                'role' => $authDTO->getRole(),
                'access_token' => $authDTO->getAccessToken(),
                'refresh_token' => $authDTO->getRefreshToken()
            ]));

            return $rs->withStatus(200)->withHeader('Content-Type', 'application/json');
        } catch (\DomainException $e) {
            $rs->getBody()->write(json_encode(['error' => $e->getMessage()]));
            return $rs->withStatus(401)->withHeader('Content-Type', 'application/json');
        }
    }
}
