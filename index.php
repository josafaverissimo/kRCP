<?php

require_once __DIR__ . "/vendor/autoload.php";

use Src\Core\Router\Router;

$routes = new Router();

$routes->get("/", CONF_DEFAULT_CONTROLLER);

$routes->get("/user", "User:index");
$routes->get("/user/form", "User:form");
$routes->get("/user/create", "User:create");
$routes->get("/user/get/(:numeric)", "User:getUser");
$routes->get("/user/name/(:alpha)/age/(:numeric)", "User:doUser");

$routes->group(["prefix" => "admin", "controllersDir" => "Admin", "middlewares" => []], function() {
    $this->get("/", "Admin:index");
    $this->get("/user/delete/name/(:alpha)", "User:deleteUser");
});

$routes->dispatch();
