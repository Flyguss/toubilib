<?php

namespace toubilib\api\actions;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Exception\HttpNotFoundException;
use Slim\Routing\RouteContext;

;
use toubilib\api\actions\AbstractAction;
use toubilib\core\application\ports\api\ServicePraticienInterface;

class GetAllPraticiens extends AbstractAction {
    
    protected ServicePraticienInterface $praticienService;

    public function __construct(ServicePraticienInterface $praticienService) {
        $this->praticienService = $praticienService;
    }

    public function __invoke(ServerRequestInterface $rq, ResponseInterface $rs, array $args): ResponseInterface
    {
        $praticiens = $this->praticienService->listerPraticiens();
            $praticiensArray = array_map(function ($praticien) {
                return [
                    'nom' => $praticien->getNom(),
                    'prenom' => $praticien->getPrenom(),
                    'ville' => $praticien->getVille(),
                    'email' => $praticien->getEmail(),
                    'specialite' => $praticien->getSpecialite()
                ];
            }, $praticiens);

            $rs->getBody()->write(json_encode($praticiensArray));
            return $rs->withStatus(200)->withHeader('Content-Type', 'application/json');
        }
    }


