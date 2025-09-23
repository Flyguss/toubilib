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
        $input = new InputRdvDTO($args['motif'] , $args['date'] , $args['heure'] , $args['idPraticien'] , $args['idPatient'] , $args['duree']) ;

        $result = $this->rdvService->CreerRdv($input) ;

        $rs->getBody()->write(json_encode($result));
        return $rs->withHeader('Content-Type', 'application/json');
    }
}