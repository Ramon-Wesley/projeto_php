<?php
require_once("./configuration/Connect.php");
class UserModel extends Connect
{
    private $tableName;

    public function __construct()
    {
        parent::__construct();
        $this->tableName = "usuario";
    }

    public function getAll()
    {
        $resultQuery = $this->connection->query("SELECT * FROM usuario");
        return $resultQuery->fetchAll();
    }
}
