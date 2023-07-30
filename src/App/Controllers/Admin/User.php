<?php

namespace src\App\Controllers\Admin;

class User
{
    public function deleteUser(string $name): void
    {
        echo "{$name} was deleted";
    }
}