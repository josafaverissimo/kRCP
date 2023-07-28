<?php

namespace Source\Core\Database;

use \PDOException;
use \PDO;

class Sql
{
    private static ?PDOException $fail;

    final private function __construct()
    {
    }

    public static function getError(): ?string
    {
        return isset(self::$fail) ? self::$fail->getMessage() : null;
    }

    public static function insert(string $entity, array $data): bool
    {
        try {
            $columns = implode(",", array_keys($data));
            $values = ":" . implode(",:", array_keys($data));
            $query = "INSERT INTO {$entity} ({$columns}) VALUES ({$values})";

            $statement = Connect::getInstance()->prepare($query);
            $statement->execute($data);

            return true;
        } catch(PDOException $exception) {
            self::$fail = $exception;
            return false;
        }
    }

    public static function select(string $entity, string $columns = "*"): ?array
    {
        $query = "SELECT {$columns} FROM {$entity}";

        $statement = Connect::getInstance()->prepare($query);
        $statement->execute();

        return $statement->fetchAll();
    }
}