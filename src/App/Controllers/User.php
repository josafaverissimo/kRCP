<?php

namespace Src\App\Controllers;

use Src\App\Pages\User\Index as UserIndexPage;
use Src\App\Pages\User\Form as UserFormPage;
use Src\App\DTOs\User as UserDTO;
use Src\Core\Database\ORMs\User as UserORM;
use Src\Core\Response;

class User
{
    public function index(): void
    {
        $userORM = new UserORM();
        $users = $userORM->getAll();

        $userIndexPage = new UserIndexPage();
        $userIndexPage->users = $users;

        echo $userIndexPage;
    }

    public function form(): void
    {
        $userFormPage = new UserFormPage();

        echo $userFormPage;
    }

    public function create(): void
    {
        $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_SPECIAL_CHARS);
        $response = new Response();
        $response->success = false;

        if(empty($post)) {
            echo $response->jsonOutput();
            return;
        }

        $userDTO = new UserDTO($post["username"], $post["password"]);
        $userORM = new UserORM($userDTO);

        $response->success = $userORM->persist();

        echo $response->jsonOutput();
    }

    public function getUser(string $hash): void
    {
        $userORM = new UserORM();
        $data = $userORM->get("hash", $hash);

        echo json_encode($data);
    }
}