<?php

namespace Source\App\Controllers;

use Source\App\Pages\Card as CardPage;
use Source\App\Pages\CardForm as CardFormPage;
use Source\Core\Database\ORMs\Card as CardORM;

class Card
{
    private CardORM $orm;

    private function post(): ?array
    {
        $postValidation = [
            "name" => FILTER_SANITIZE_SPECIAL_CHARS,
            "description" => FILTER_SANITIZE_SPECIAL_CHARS
        ];
        return filter_input_array(INPUT_POST, $postValidation);
    }

    public function index(): void
    {
        $orm = new CardORM();
        $cardPage = new CardPage([
            "cards" => $orm->getAll()
        ]);

        echo $cardPage;
    }

    public function form(): void
    {
        $cardFormPage = new CardFormPage();

        echo $cardFormPage;
    }

    public function create(): void
    {
        header("Content-type: application/json; charset=utf-8");

        $data = $this->post();


        if (empty($data)) {
            echo json_encode([
                "success" => false,
                "message" => "Dados vazios"
            ]);
            return;
        }

        $orm = new CardORM($data["name"], $data["description"]);
        $success = $orm->persist();

        echo json_encode([
            "success" => $success
        ]);
    }
}
