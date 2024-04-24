<?php

session_start();
require_once __DIR__ . '/routes.php';

class Router extends RouteSwitch
{
    public function run(string $requestUri)
    {
        $urlParts = explode('/', $requestUri);

        $route = end($urlParts);

        if (empty($route)) {
            $route = "";
        }

        if ($route === '') {
            if(isset($_SESSION['token'])) {
                header("Location: Home");
            } else {
                header("Location: Login");
            }
        } else {
            include "src/componentes/header.php";
            $this->$route();
        }
    }
}

$requestUri = $_SERVER['REQUEST_URI'];
$router = new Router;
$router->run($requestUri);