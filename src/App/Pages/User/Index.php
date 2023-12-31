<?php

namespace Src\App\Pages\User;

use Src\App\Pages\HTML;
use Src\Core\Helpers;

class Index extends HTML
{
    protected const TITLE = "User";

    protected const STYLES = [];
    protected  const SCRIPTS = [];

    public function __construct()
    {
        parent::__construct();
    }

    protected function body(): string
    {
        $formLink = Helpers::baseUrl("user/form");
        $usersHTML = "";

        if(!empty($this->data["users"])) {
            foreach($this->data["users"] as $user) {
                $usersHTML .= "<div><code>" . json_encode($user) . "</code></div>";
            }
        }

        return <<<HTML
            <main>
                <div>
                    <h1>Index</h1>
                    <a href="{$formLink}">Form</a>
                </div>
                
                <div>
                    {$usersHTML}
                </div>
            </main>
        HTML;
    }
}