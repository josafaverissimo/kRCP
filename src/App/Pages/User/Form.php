<?php

namespace Src\App\Pages\User;

use Src\App\Pages\HTML;
use Src\Core\Helpers;

class Form extends HTML
{
    protected const TITLE = "User Form";

    protected const STYLES = [
        "user/form.css"
    ];
    protected const SCRIPTS = [
        "user/form.js"
    ];

    public function __construct()
    {
        parent::__construct();
    }

    protected function body(): string
    {
        $formAction = Helpers::baseUrl("/user/create");

        return <<<HTML
            <main>
                <h1>User Form</h1>
                
                <form id="main-form" action="{$formAction}">
                    <div>
                        <label for="username">Username</label>
                        <input id="username" type="text" name="username">
                    </div>
                    
                    <div>
                        <label for="password">Password</label>
                        <input id="password" type="password" name="password">
                    </div>
                    
                    <button type="submit">Create User</button>
                </form>
            </main>
        HTML;
    }
}