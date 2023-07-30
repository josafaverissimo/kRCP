<?php

namespace Src\App\Controllers;

use Src\App\Pages\Home as HomePage;

class Home
{
    public function index(): void
    {
        $homePage = new HomePage();

        echo $homePage;
    }
}
