<?php

namespace src\App\Controllers\Admin;

class User
{
    public function deleteUser(string $name, int $age): void
    {
        echo "{$name} was deleted, it was {$age} years old";
    }
}