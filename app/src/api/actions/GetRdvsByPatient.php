<?php

namespace toubilib\api\actions;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Exception\HttpNotFoundException;
use Slim\Routing\RouteContext;

;
use toubilib\api\actions\AbstractAction;
use toubilib\core\application\ports\api\ServicePraticienInterface;
use toubilib\core\application\ports\api\ServiceRDVInterface;

class GetRdvsByPatient extends AbstractAction {

    protected ServiceRDVInterface $rdvService;

    public function __construct(ServiceRDVInterface $rdvService) {
        $this->rdvService = $rdvService;
    }

    public function __invoke(ServerRequestInterface $rq, ResponseInterface $rs, array $args): ResponseInterface
    {

        $id = $args['id'];

        $rdvs = $this->rdvService->listeRdvbyPatient($id);


        $rdvsArray = array_map(function ($rdv) {
            return [
                'motif' => $rdv->getMotif() ,
                'dateDebut' =>$rdv->getDateDebut() ,
                'dateFin' => $rdv->getDateFin()

            ];
        }, $rdvs);

        $rs->getBody()->write(json_encode($rdvsArray));
        return $rs->withStatus(200)->withHeader('Content-Type', 'application/json');
    }
}


