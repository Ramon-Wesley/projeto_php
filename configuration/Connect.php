<?php
define("LOCALHOST", "localhost");
define("USER", "ramon");
define("DB", "sistema");
define("PASSWORD", "12345678");
class Connect
{
    private static $connection;
    public function __construct()
    {
        self::connection_database();
    }

    private static function connection_database()
    {

        try {
            self::$connection = new PDO("mysql:host = " . LOCALHOST . "; dbname =  " . DB, USER, PASSWORD);
            self::$connection->exec("USE sistema");
        } catch (\PDOException $th) {
            die();
        }
        return self::$connection;
    }
}
