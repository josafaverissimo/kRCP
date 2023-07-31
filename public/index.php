<?php

require_once __DIR__ . "/../vendor/autoload.php";

use Src\Core\Router\Router;

$routes = new Router();

$routes->get("/", CONF_DEFAULT_CONTROLLER);

$routes->group(["prefix" => "user"], function() {
    $this->get("/", "User:index");
    $this->get("/form", "User:form");
    $this->post("/create", "User:create");
    $this->get("/get/(:numeric)", "User:getUser");
    $this->get("/name/(:alpha)/age/(:numeric)", "User:doUser");
    $this->get("/money/(:numeric)", "User:showMoney");
});

$routes->group(["prefix" => "admin", "controllersDir" => "Admin", "middlewares" => ["Auth", "Log"]], function() {
    $this->get("/", "Admin:index");
    $this->get("/user/delete/name/(:alpha)/age/(:numeric)", "User:deleteUser");
});

$routes->dispatch();
