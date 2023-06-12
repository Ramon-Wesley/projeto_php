<?php

require_once './controllers/ClienteController.php';


function mapRoutes($method, $uri)
{
    switch ($uri) {
        case '/consultar-cliente':

            $clienteController = new ClienteController();
            $clienteController->consultarCliente();
            break;
    }
}


$method = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

mapRoutes($method, $uri);
