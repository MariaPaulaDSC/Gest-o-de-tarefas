<?php
declare(strict_types=1);

class Database
{
    private static ?PDO $connection = null;

    private function __construct() {}

    public static function getConnection(): PDO
    {
        if (self::$connection === null) {
            $host = 'localhost';
            $dbname = 'taskmanager';
            $username = 'root';
            $password = '';

            $dsn = "mysql:host={$host};dbname={$dbname};charset=utf8mb4";
            self::$connection = new PDO($dsn, $username, $password, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ]);
        }

        return self::$connection;
    }
}
