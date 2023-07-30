<?php

require_once __DIR__ . "/vendor/autoload.php";

use Src\Core\Router;

$routes = new Router();

$routes->route("/", CONF_DEFAULT_CONTROLLER);

$routes->route("/user", "User:index");
$routes->route("/user/form", "User:form");
$routes->route("/user/create", "User:create");
$routes->route("/user/get/:hash", "User:getUser");

$routes->dispatch();
