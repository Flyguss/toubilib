<?php

namespace toubilib\api\actions;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use toubilib\core\application\ports\api\dtos\InputRdvDTO;
use toubilib\core\application\ports\api\ServiceRDVInterface;

class CreateRDV extends AbstractAction
{
    protected ServiceRDVInterface $rdvService;

    public function __construct(ServiceRDVInterface $rdvService) {
        $this->rdvService = $rdvService;
    }

    public function __invoke(ServerRequestInterface $rq, ResponseInterface $rs, array $args): ResponseInterface
    {
        $idPraticien = $args['id'];

        $data = $rq->getParsedBody();

        if (
            !isset($data['idPatient'], $data['date'], $data['heure'], $data['motif'], $data['duree'])
        ) {
            $rs->getBody()->write(json_encode(["error" => "Paramètres manquants"]));
            return $rs->withStatus(400)->withHeader('Content-Type', 'application/json');
        }


        $input = new InputRdvDTO(
            $data['motif'],
            $data['date'],
            $data['heure'],
            $idPraticien,
            $data['idPatient'],
            $data['duree']
        );

        // Appel du service métier
        $result = $this->rdvService->CreerRdv($input);

        $rs->getBody()->write(json_encode($result));
        return $rs->withStatus(201)->withHeader('Content-Type', 'application/json');
    }
}
