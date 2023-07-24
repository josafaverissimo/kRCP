<?php

namespace Source\Core\Database;

use http\Exception;
use \PDOException;

class Sql
{
    private static PDOException $fail;

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
            $query = "INSERT INTO {$entity} ({$columns}) values ({$values})";

            $stmt = Connect::getInstance()->prepare($query);
            $stmt->execute($data);

            return true;
        } catch (PDOException $exception) {
            self::$fail = $exception;

            return false;
        }
    }

    public static function getAll(string $entity, string $columns = "*"): ?array
    {
        try {
            $query = "SELECT * FROM {$entity}";

            $stmt = Connect::getInstance()->prepare($query);
            $stmt->execute();

            return $stmt->fetchAll();
        } catch(PDOException $exception) {
            self::$fail = $exception;

            return null;
        }


    }
}