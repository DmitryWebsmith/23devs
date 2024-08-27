<?php

namespace App\Services;

use mysqli;
use Symfony\Component\Dotenv\Dotenv;

class DatabaseService
{
    private static ?DatabaseService $databaseService = null;

    private mysqli $connection;

    public static function getInstance(): DatabaseService
    {
        if (self::$databaseService === null) {
            self::$databaseService = new self();
        }

        return self::$databaseService;
    }

    /**
     * метод возвращает максимальное значение id таблицы. Если записей нет, возвращает null
     */
    public function getMaxId(string $tableName): mixed
    {
        $db = $this->connect();

        $sql = "select MAX(Id) from " . $tableName;

        $result = mysqli_fetch_array($db->query($sql));

        return $result[0];
    }

    public function connect(): mysqli|null
    {
        $dotenv = new Dotenv();
        $dotenv->load(__DIR__.'/../../.env');

        $this->connection = new mysqli(
            $_ENV["DB_HOST"],
            $_ENV["DB_USERNAME"],
            $_ENV["DB_PASSWORD"],
            $_ENV["DB_DATABASE"],
            $_ENV["DB_PORT"]
        );

        if ($this->connection->connect_error) {
            return null;
        }

        $this->connection->set_charset($_ENV["DB_CHARSET"]);

        return $this->connection;
    }

    private function __destruct()
    {
        $this->connection->close();
    }
}
