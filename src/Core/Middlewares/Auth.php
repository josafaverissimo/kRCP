<?php

namespace Src\Core\Middlewares;

use Src\Core\Interfaces\Middleware as MiddlewareInterface;

class Auth implements MiddlewareInterface
{
    public function execute()
    {
        xdebug_var_dump("Execute auth ");
    }
}