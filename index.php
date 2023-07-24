<?php

require_once "Source/autoload.php";

use Source\Core\Routes;

$routes = new Routes();

$routes->route("/", CONF_DEFAULT_CONTROLLER);

$routes->route("/route", "Controller:method");

$routes->dispatch();
