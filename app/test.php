<?php

require __DIR__ . '/vendor/autoload.php';

use toubilib\core\application\usecases\ServicePraticien;


$config = parse_ini_file(__DIR__ . '/config/.env');
$dsn = "{$config['prat.driver']}:host={$config['prat.host']};dbname={$config['prat.database']}";
$user = $config['prat.username'];
$password = $config['prat.password'];
$pdo = new \PDO($dsn, $user, $password, [\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION]);

$repo = new \toubilib\infra\repositories\PraticienRepository($pdo) ;

$service = new ServicePraticien($repo) ;

$praticiens = $service->listerPraticiens() ;

foreach ($praticiens as $p) {
    echo $p->getSpecialite() . "\n" ;
}
