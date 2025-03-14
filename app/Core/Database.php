<?php

namespace App\Core;

use PDO;
use PDOException;

class Database
{
    private static $instance = null;
    private $connection;


    private function __construct()
    {
        try {
            $config = require __DIR__ . '/../config/database.php';

            $dsn = "mysql:host={$config['host']};dbname={$config['dbname']};charset={$config['charset']}";


            $this->connection = new PDO($dsn, $config['username'], $config['password'], [
              PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
              PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
              PDO::ATTR_EMULATE_PREPARES => false
            ]);

        } catch (PDOException $e) {
            die('Connection failed'. $e->getMessage());
        }

    }

    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function getConnection()
    {
        return $this->connection;
    }

}
