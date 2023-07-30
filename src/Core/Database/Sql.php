<?php

namespace Src\Core\Database;

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
        } catch (PDOException $exception) {
            self::$fail = $exception;
            return false;
        }
    }

    public static function select(string $entity, array $param = [], array $columns = []): ?array
    {
        $columns = !empty($columns) ? implode(",", $columns) : "*";
        $where = "";

        if (!empty($param)) {
            $paramColumn = array_keys($param)[0];
            $where = " WHERE {$paramColumn}=:{$paramColumn}";
        }

        $query = "SELECT {$columns} FROM {$entity}" . $where;

        $statement = Connect::getInstance()->prepare($query);
        $statement->execute($param);

        return $statement->fetchAll();
    }
}