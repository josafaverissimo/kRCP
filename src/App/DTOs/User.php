<?php

namespace Src\App\DTOs;

class User
{
    public ?string $username;
    public ?string $password;

    public function __construct(?string $username, ?string $password) {
        $this->username = $username;
        $this->password = $password;
    }
}