<?php

namespace Source\App\Pages\User;

use Source\App\Pages\HTML;

class Index extends HTML
{
    protected const TITLE = "User";

    protected const STYLES = [];
    protected  const SCRIPTS = [];

    private array $data;

    public function __construct()
    {
        parent::__construct();

        $this->data = [];
    }

    public function __set(string $key, mixed $value): void
    {
        $this->data[$key] = $value;
    }

    protected function body(): string
    {
        $usersHTML = "";

        if(!empty($this->data["users"])) {
            foreach($this->data["users"] as $user) {
                $usersHTML .= "<code>" . json_encode($user) . "</code>";
            }
        }

        return <<<HTML
            <main>
                <h1>Index</h1>
                {$usersHTML}
            </main>
        HTML;
    }
}