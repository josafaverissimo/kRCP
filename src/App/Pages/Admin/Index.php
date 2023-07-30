<?php

namespace Src\App\Pages\Admin;

use Src\App\Pages\HTML;
use Src\Core\Helpers;

class Index extends HTML
{
    protected const TITLE = "Admin";

    protected const STYLES = [];
    protected  const SCRIPTS = [];

    public function __construct()
    {
        parent::__construct();
    }

    public function __set(string $key, $value): void
    {
        $this->data[$key] = $value;
    }

    protected function body(): string
    {

        return <<<HTML
            <main>
                <div>
                    <h1>Hello, admin</h1>
                </div>
                
                <div>
                    Admin page, hello
                </div>
            </main>
        HTML;
    }
}