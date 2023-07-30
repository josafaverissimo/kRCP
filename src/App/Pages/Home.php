<?php

namespace Src\App\Pages;

use Src\Core\Helpers;

class Home extends HTML
{
    protected const TITLE = "Home";

    protected const STYLES = [
        "home/styles.css"
    ];
    protected const SCRIPTS = [
        "home/scripts.js"
    ];

    public function __construct()
    {
        parent::__construct();
    }

    protected function body(): string
    {
        $userLink = Helpers::baseUrl("user");
        return <<<HTML
            <main>
                <h1>Welcome to my MVC Framework, kRCP</h1>
                <p>k - Kiris</p>
                <p>R - Routing</p>
                <p>C - Centralizer</p>
                <p>P - Page</p>
                
                <a href="{$userLink}">A simple crud</a>
            </main>
        HTML;
    }
}
