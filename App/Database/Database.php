<?php
namespace App\Database;
use PDO;
use PDOException;
use MongoDB\Client as MongoClient;
use Exception;

class Database {
    private static $instance = null;
    private $conn;
    private $config;

    private function __construct() {
        $this->config = require 'config.php';
        
        $driver = $this->config['driver'];

        if ($driver === 'mysql') {
            $this->conn = new PDO(
                $driver . ':host=' . $this->config['host'] . ';port=' . $this->config['port'] . ';dbname=' . $this->config['db_name'] . ';charset=' . $this->config['charset'],
                $this->config['username'],
                $this->config['password']
            );
        } else {
            throw new Exception("Driver não suportado.");
        }

    }
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance->conn;
    }

    private function __clone() {}
}
