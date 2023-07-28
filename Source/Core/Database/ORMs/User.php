<?php

namespace Source\Core\Database\ORMs;

use Source\App\DTOs\User as UserDTO;
use Source\Core\Database\Sql;
use Source\Core\Helpers;


class User
{
    private const ENTITY = "krcp_users";

    private ?int $id;
    private ?string $username;
    private ?string $password;
    private string $hash;

    public function __construct(?UserDTO $userDTO = null)
    {
        $this->id = null;
        $this->setHash();

        if(!empty($userDTO)) {
            $this->setUsername($userDTO->username);
            $this->setPassword($userDTO->password);
        } else {
            $this->setUsername(null);
            $this->setPassword(null);
        }
    }


    public function getUsername(): string
    {
        return $this->username;
    }

    public function setUsername(?string $username): void
    {
        $this->username = $username;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(?string $password): void
    {
        $this->password = !empty($password) ? Helpers::passwordHash($password) : null;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getHash(): string
    {
        return $this->hash;
    }

    public function setHash(): void
    {
        if (!isset($this->hash)) {
            $this->hash = base64_encode(random_bytes(25));
        }
    }

    private function getUserData(): array
    {
        return [
            "username" => $this->getUsername(),
            "password" => $this->getPassword(),
            "hash" => $this->getHash()
        ];
    }

    public function getAll(): array
    {
        return Sql::select(self::ENTITY);
    }

    public function persist(): bool
    {
        return Sql::insert(self::ENTITY, $this->getUserData());
    }
}