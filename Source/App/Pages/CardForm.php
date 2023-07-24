<?php

namespace Source\App\Pages;

use Source\Core\Helpers;

class CardForm extends HTML
{
    public function __construct()
    {
        $title = "Card Form";

        parent::__construct($title);
    }

    protected function getStyles(): array
    {
        return [
            "card/form.css",
        ];
    }

    protected function getScripts(): array
    {
        return [
            "card/form.js"
        ];
    }

    private function form(): string
    {
        $action = Helpers::baseUrl("card/create");

        return <<<HTML
            <form action="{$action}">
                <div>
                    <label for="card-name">Nome</label>
                    <input id="card-name" name="card-name">
                </div>

                <div>
                    <label for="card-description">Description</label>
                    <input id="card-description" name="card-description">
                </div>

                <div>
                    <button type="submit">Enviar</button>
                </div>
            </form>
        HTML;
    }

    protected function body(): string
    {
        return <<<HTML
            <main>
                <h1>YU-GI-OH</h1>

                {$this->form()}
            </main>
        HTML;
    }
}
