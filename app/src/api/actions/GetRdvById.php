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

class GetRdvById extends AbstractAction {
    
    protected ServiceRDVInterface $rdvService;

    public function __construct(ServiceRDVInterface $rdvService) {
        $this->rdvService = $rdvService;
    }

    public function __invoke(ServerRequestInterface $rq, ResponseInterface $rs, array $args): ResponseInterface
    {
        $id = $args['id'];

        $rdv = $this->rdvService->Rdv($id);
            $rdvTableau = [
                'motif' => $rdv->getMotif() ,
                'dateDebut' =>$rdv->getDateDebut() ,
                'dateFin' => $rdv->getDateFin()

            ];


            $rs->getBody()->write(json_encode($rdvTableau));
            return $rs->withHeader('Content-Type', 'application/json');
        }
    }


