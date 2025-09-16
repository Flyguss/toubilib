<?php

namespace toubilib\api\actions;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Exception\HttpNotFoundException;
use Slim\Routing\RouteContext;

;
use toubilib\api\actions\AbstractAction;
use toubilib\core\application\ports\api\ServicePraticienInterface;

class GetPraticienById extends AbstractAction {
    
    protected ServicePraticienInterface $praticienService;

    public function __construct(ServicePraticienInterface $praticienService) {
        $this->praticienService = $praticienService;
    }

    public function __invoke(ServerRequestInterface $rq, ResponseInterface $rs, array $args): ResponseInterface
    {
        $id = $args['id'];

        $praticien = $this->praticienService->PraticiensDetaille($id);
            $praticienTableau = [
                    'nom' => $praticien->getNom(),
                    'prenom' => $praticien->getPrenom(),
                    'ville' => $praticien->getVille(),
                    'email' => $praticien->getEmail(),
                    'specialite' => $praticien->getSpecialite(),
                    'telephone' =>$praticien->getTelephone() ,
                    'Moyen de Paiment' => $praticien->getMoyenPaiment(),
                    'Motif de visite' => $praticien->getMotifVisite()
                ];


            $rs->getBody()->write(json_encode($praticienTableau));
            return $rs->withHeader('Content-Type', 'application/json');
        }
    }


