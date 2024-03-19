<?php
namespace App;
require "../vendor/autoload.php";

use App\Controller\IndexController;

$frontController = new FrontController();

$frontController->bind('index', IndexController::class);

$frontController->run();