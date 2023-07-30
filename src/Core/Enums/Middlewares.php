<?php

use Src\Core\Middlewares\Auth;
enum Middlewares: string
{
    case Auth = Auth::class;
}