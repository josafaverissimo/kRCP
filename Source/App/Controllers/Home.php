<?php

namespace Source\App\Controllers;

use Source\App\Pages\Home as HomePage;

class Home
{
    public function index(): void
    {
        $homePage = new HomePage();

        echo $homePage;
    }
}
