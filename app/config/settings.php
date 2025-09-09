<?php

use Psr\Container\ContainerInterface;
use toubilib\api\actions\GetAllPraticiens;
use toubilib\core\application\ports\api\ServicePraticienInterface;
use toubilib\core\application\ports\spi\repositoryInterfaces\PraticienRepositoryInterface;
use toubilib\core\application\usecases\ServicePraticien;
use toubilib\infra\repositories\PraticienRepository;

return [

    // settings
    'displayErrorDetails' => true,
    'toubilib.db.config' => __DIR__ . '/.env',

    GetAllPraticiens::class => function (ContainerInterface $c) {
        return new GetAllPraticiens($c->get(ServicePraticienInterface::class));
    },

    ServicePraticienInterface::class => function (ContainerInterface $c) {
        return new ServicePraticien($c->get(PraticienRepositoryInterface::class));
    },

    // infra
     'toubilib.pdo' => function (ContainerInterface $c) {
    $config = parse_ini_file($c->get('toubilib.db.config'));
    $dsn = "{$config['prat.driver']}:host={$config['prat.host']};dbname={$config['prat.database']}";
    $user = $config['prat.username'];
    $password = $config['prat.password'];
    return new \PDO($dsn, $user, $password, [\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION]);
},
    PraticienRepositoryInterface::class => fn(ContainerInterface $c) => new PraticienRepository($c->get('toubilib.pdo')),
    ];

