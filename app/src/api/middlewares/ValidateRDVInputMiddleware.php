<?php

namespace toubilib\api\middlewares;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Slim\Psr7\Response;
use toubilib\core\application\ports\api\dtos\InputRdvDTO;

class ValidateRDVInputMiddleware
{
    public function __invoke(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $data = $request->getParsedBody(); // Pour JSON POST

        $errors = [];

        // Vérifications
        if (empty($data['idPraticien']) || !is_string($data['idPraticien'])) {
            $errors[] = "idPraticien manquant ou invalide";
        }
        if (empty($data['idPatient']) || !is_string($data['idPatient'])) {
            $errors[] = "idPatient manquant ou invalide";
        }
        if (empty($data['date']) || !preg_match('/^\d{4}-\d{2}-\d{2}$/', $data['date'])) {
            $errors[] = "date manquante ou au mauvais format (YYYY-MM-DD)";
        }
        if (empty($data['heure']) || !preg_match('/^\d{2}:\d{2}$/', $data['heure'])) {
            $errors[] = "heure manquante ou au mauvais format (HH:MM)";
        }
        if (empty($data['motif']) || !is_string($data['motif'])) {
            $errors[] = "motif manquant ou invalide";
        }
        if (!isset($data['duree']) || !is_numeric($data['duree']) || $data['duree'] <= 0) {
            $errors[] = "duree manquante ou invalide";
        }

        // Si erreur, renvoyer un JSON 400
        if (!empty($errors)) {
            $response = new Response();
            $response->getBody()->write(json_encode(['errors' => $errors]));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(400);
        }

        // Créer le DTO
        $dto = new InputRdvDTO(
            $data['motif'],
            $data['date'],
            $data['heure'],
            $data['idPraticien'],
            $data['idPatient'],
            (int)$data['duree']
        );

        // Ajouter le DTO à l'objet Request pour qu'il soit accessible dans l'action
        $request = $request->withAttribute('rdvDTO', $dto);

        // Passer au handler suivant (l'action)
        return $handler->handle($request);
    }
}
