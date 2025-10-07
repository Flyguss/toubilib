<?php
declare(strict_types=1);


use toubilib\api\middlewares\ValidateRDVInputMiddleware;

return function(\Slim\App $app):\Slim\App {


    $app->get('/praticiens', \toubilib\api\actions\GetAllPraticiens::class)->setName('liste-praticiens');
    $app->get('/praticiens/{id}', \toubilib\api\actions\GetPraticienById::class)->setName('PraticienDetaille');
    $app->get('/praticiens/{id}/rdvs', \toubilib\api\actions\GetAllRDVOfPraticienBetween2Date::class)->setName('RdvOccupées');
    $app->get('/rdvs/{id}', \toubilib\api\actions\GetRdvById::class)->setName('RDVDetaille');
    $app->post('/praticiens/{id}/rdvs', \toubilib\api\actions\CreateRDV::class)->add(ValidateRDVInputMiddleware::class);
    $app->delete('/rdv/{id}', \toubilib\api\actions\DeleteRDV::class)->add(ValidateRDVInputMiddleware::class);
    $app->post('/auth/login', \toubilib\api\actions\AuthAction::class);




    return $app;
};