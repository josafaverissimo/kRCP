<?php

namespace Source\App\Pages;

use Source\Core\Helpers;

class Home extends HTML
{
    public function __construct()
    {
        $title = "Home";

        parent::__construct($title);
    }

    protected function getStyles(): ?array
    {
        return null;
    }

    protected function getScripts(): ?array
    {
        return null;
    }

    protected function body(): string
    {
        return <<<HTML
            <main>
                <h1>Home page</h1>
            </main>
        HTML;
    }
}
