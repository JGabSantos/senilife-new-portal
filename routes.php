<?php

abstract class RouteSwitch
{
    protected function home()
    {
        require __DIR__ . '/src/html/home.html';
        include __DIR__ . '/src/componentes/footer2.php';
    }

    protected function login()
    {
        require __DIR__ . '/src/html/login.html';
        include __DIR__ . '/src/componentes/footer.php';
    }

}