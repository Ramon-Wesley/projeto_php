<?php
define("LOCALHOST", "localhost");
define("USER", "ramon");
define("DB", "sistema");
define("PASSWORD", "12345678");
class Connect
{
    private static $instance;
    public function __construct()
    {
    }

    public static function connection_database()
    {
        if (!isset(self::$instance)) {
            try {
                self::$instance = new PDO("mysql:host = " . LOCALHOST . "; dbname =  " . DB, USER, PASSWORD);
                self::$instance->exec("USE sistema");
            } catch (\PDOException $th) {
                die();
            }
        }
        return self::$instance;
    }
}
