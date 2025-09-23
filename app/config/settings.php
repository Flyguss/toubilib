<?php

use Psr\Container\ContainerInterface;
use toubilib\api\actions\GetAllPraticiens;
use toubilib\core\application\ports\api\ServicePraticienInterface;
use toubilib\core\application\ports\api\ServiceRDVInterface;
use toubilib\core\application\ports\spi\repositoryInterfaces\PraticienRepositoryInterface;
use toubilib\core\application\ports\spi\repositoryInterfaces\RDVRepositoryInterface;
use toubilib\core\application\usecases\ServicePraticien;
use toubilib\core\application\usecases\ServiceRDV;
use toubilib\infra\repositories\PraticienRepository;
use toubilib\infra\repositories\RDVRepository;

return [

    // settings
    'displayErrorDetails' => true,
    'db.config' => __DIR__ . '/.env',


    //Action
    GetAllPraticiens::class => function (ContainerInterface $c) {
        return new GetAllPraticiens($c->get(ServicePraticienInterface::class));
    },

    ServicePraticienInterface::class => function (ContainerInterface $c) {
        return new ServicePraticien($c->get(PraticienRepositoryInterface::class));
    },

    ServiceRDVInterface::class => function (ContainerInterface $c) {
        return new ServiceRDV($c->get(RDVRepositoryInterface::class));
    },

    // infra
     'toubilib.pdo' => function (ContainerInterface $c) {
    $config = parse_ini_file($c->get('db.config'));
    $dsn = "{$config['prat.driver']}:host={$config['prat.host']};dbname={$config['prat.database']}";
    $user = $config['prat.username'];
    $password = $config['prat.password'];
    return new \PDO($dsn, $user, $password, [\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION]);
},

    'pdo' => function (ContainerInterface $c) {
        $config = parse_ini_file($c->get('db.config'));
        $dsn = "{$config['rdv.driver']}:host={$config['rdv.host']};dbname={$config['rdv.database']}";
        $user = $config['rdv.username'];
        $password = $config['rdv.password'];
        return new \PDO($dsn, $user, $password, [\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION]);
    },
    PraticienRepositoryInterface::class => fn(ContainerInterface $c) => new PraticienRepository($c->get('toubilib.pdo')),

    RDVRepositoryInterface::class => fn(ContainerInterface $c) => new RDVRepository($c->get('pdo')),
    ];

