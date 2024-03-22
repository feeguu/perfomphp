<?php
namespace App;
require "../vendor/autoload.php";

use App\Controller\IndexController;

$frontController = new FrontController();

$frontController->bind('/clientes', IndexController::class);

$frontController->run();