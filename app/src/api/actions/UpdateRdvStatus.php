<?php
namespace toubilib\api\actions;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use toubilib\core\application\ports\api\ServiceRDVInterface;

class UpdateRdvStatus
{
    protected ServiceRDVInterface $rdvService;

    private array $statusAutorise = [0 , 1 , 2] ;

    public function __construct(ServiceRDVInterface $rdvService) {
        $this->rdvService = $rdvService;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $status = $_GET['status'] ?? null;
        $id = $args['id'];

        if ($status != null && in_array($status , $this->statusAutorise)) {
            $this->rdvService->updateStatus($id , $status) ;
        } else {
            $response->getBody()->write(json_encode([
                "error" => "Bad Request",
                "message" => "Missing required parameter: status"
            ]));

            return $response
                ->withStatus(400)
                ->withHeader('Content-Type', 'application/json');
        }

        $response->getBody()->write(json_encode([
            "message" => "RDV Status modifié"
        ]));

        return $response->withStatus(200)->withHeader('Content-Type', 'application/json');
    }
}
