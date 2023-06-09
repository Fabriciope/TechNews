<?php

namespace App\Core\Database;

use PDO;
use PDOException;

/**
 * Classe responsável por fazer a conexão com o banco de dados usando o design pattern Singleton
 */
class Connection
{
    private const OPTIONS = [
        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
        PDO::ATTR_CASE => PDO::CASE_NATURAL
    ];

    private static PDO $instance;
    
    /**
     * getInstance
     *
     * @return ?PDO
     */
    public static function getInstance(): ?PDO
    {
        if(empty(self::$instance)) {
            try {
                self::$instance = new PDO (
                    "mysql:host=" . CONF_DB_HOST . ";dbname=" . CONF_DB_NAME,
                    CONF_DB_USER,
                    CONF_DB_PASSWORD,
                    self::OPTIONS
                );
            } catch (PDOException) {
                redirect("/oops/problemas");
                return null;
            }
        }
        return self::$instance;
    }

    final private function __construct(){}
    private function __clone(){}
    // private function __wakeup(){}
}