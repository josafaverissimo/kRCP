<?php

namespace src\App\Controllers\Admin;

use Src\App\Pages\Admin\Index as AdminIndexPage;

class Admin
{
    public function index(): void
    {
        $adminIndexPage = new AdminIndexPage();

        echo $adminIndexPage;
    }
}
