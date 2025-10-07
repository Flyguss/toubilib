<?php

namespace toubilib\api\actions;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use toubilib\core\application\ports\api\ServiceAuthInterface;


class AuthAction extends AbstractAction {
    
    protected ServiceAuthInterface $authService;

    public function __construct(ServiceAuthInterface $authService) {
        $this->authService = $authService;
    }

    public function __invoke(ServerRequestInterface $rq, ResponseInterface $rs, array $args): ResponseInterface
    {
        $data = $rq->getParsedBody();

        if (!isset($data['email'], $data['password'])) {
            $rs->getBody()->write(json_encode(['error' => 'Email et mot de passe requis']));
            return $rs->withStatus(400)->withHeader('Content-Type', 'application/json');
        }

            $authDTO = $this->authService->authentification($data['email'], $data['password']);
            $rs->getBody()->write(json_encode([
                'resultat' => 'Authentification réussi'
            ]));
            return $rs->withStatus(200)->withHeader('Content-Type', 'application/json');


    }
}


