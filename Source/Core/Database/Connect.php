<?php

namespace Source\Core\Database;

use \PDO;
use \PDOException;

class Connect
{
    private const HOST = CONF_DB["host"];
    private const USER = CONF_DB["user"];
    private const DBNAME = CONF_DB["name"];
    private const PASSWORD = CONF_DB["password"];

    private const OPTIONS = [
        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
        PDO::ATTR_CASE => PDO::CASE_NATURAL
    ];

    private static PDO $instance;

    /**
     * @return PDO
     */
    public static function getInstance(): PDO
    {
        if(empty(self::$instance)) {
            try {
                self::$instance = new PDO(
                    "mysql:host=" . self::HOST . ";dbname=" . self::DBNAME,
                    self::USER,
                    self::PASSWORD,
                    self::OPTIONS
                );
            } catch(PDOException $exception) {
                die("<h1>Erro ao conectar ao banco de dados</h1>");
            }
        }

        return self::$instance;
    }

    final private function __construct()
    {
    }

    private function __clone()
    {

    }
}