<?php

namespace toubilib\api\actions;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use toubilib\core\application\ports\api\ServiceRDVInterface;

class DeleteRDV extends AbstractAction
{
    protected ServiceRDVInterface $rdvService;

    public function __construct(ServiceRDVInterface $rdvService)
    {
        $this->rdvService = $rdvService;
    }

    public function __invoke(ServerRequestInterface $rq, ResponseInterface $rs, array $args): ResponseInterface
    {
        $idRdv = $args['id'] ?? null;

        if (!$idRdv) {
            $rs->getBody()->write(json_encode(['error' => 'ID de rendez-vous manquant']));
            return $rs->withStatus(400)->withHeader('Content-Type', 'application/json');
        }


        $this->rdvService->deleteRDV($idRdv);
        return $rs->withStatus(204); // No content

    }
}
