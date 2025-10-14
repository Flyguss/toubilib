<?php

namespace toubilib\api\actions;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use toubilib\core\application\ports\api\dtos\CredentialDTO;
use toubilib\core\application\ports\spi\exceptions\AuthProvider;

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

        $dto = new CredentialDTO($data['email'] , $data['password']) ;

        try {
            $authDTO = $this->authProvider->signin($dto);
        } catch (\Exception $e) {
            $rs->getBody()->write(json_encode(['error' => $e->getMessage()]));
            return $rs->withStatus(401)->withHeader('Content-Type', 'application/json');
        }

        return $rs->withStatus(200)->withHeader('Content-Type', 'application/json');
    }
}
