<?php

namespace Source\App\Pages;

class Card extends HTML
{
    private array $data;

    public function __construct(array $data)
    {
        $title = "Card";

        $this->data = $data;

        parent::__construct($title);
    }

    public function __set(string $key, mixed $value)
    {
        $this->data[$key] = $value;
    }

    public function __get(string $key): mixed
    {
        if (!empty($this->data[$key])) {
            return $this->data[$key];
        }

        return null;
    }

    protected function getStyles(): array
    {
        return [

        ];
    }

    protected function getScripts(): array
    {
        return [

        ];
    }

    protected function body(): string
    {
        $cardsHTML = "";
        $cards = $this->data["cards"];

        if (!empty($cards)) {
            foreach ($cards as $card) {
                $cardsHTML .= <<<HTML
                    <h1>{$card->name}</h1>
                    <p>{$card->description}</p>
                HTML;
            }
        }

        return <<<HTML
            <main>
                {$cardsHTML}
            </main>
        HTML;
    }
}