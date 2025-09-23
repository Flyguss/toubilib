<?php
declare(strict_types=1);

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;


return function( \Slim\App $app):\Slim\App {



    $app->get('/', HomeAction::class);
    $app->get('/listePraticiens', \toubilib\api\actions\GetAllPraticiens::class)->setName('liste-praticiens');
    $app->get('/Praticien/{id}', \toubilib\api\actions\GetPraticienById::class)->setName('PraticienDetaille');
    $app->get('/RDV/{id}/{dateDebut}/{dateFin}', \toubilib\api\actions\GetAllRDVOfPraticienBetween2Date::class)->setName('RdvOccupées');
    $app->get('/RDV/{id}', \toubilib\api\actions\GetRdvById::class)->setName('PraticienDetaille');

  

    return $app;
};