<?php

require_once "Source/autoload.php";

use Source\Core\Routes;

$routes = new Routes();

$routes->route("/", CONF_DEFAULT_CONTROLLER);

$routes->route("/user", "User:index");
$routes->route("/user/form", "User:form");
$routes->route("/user/create", "User:create");

$routes->dispatch();
