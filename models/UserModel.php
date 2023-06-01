<?php



require_once "./configuration/Connect.php";
class UserModel
{
    private $tableName;
    private $connection;

    public function __construct()
    {
        $this->connection = Connect::connection_database();
        $this->tableName = "usuario";
    }

    public function SignIn(
        $email,
        $password
    ) {
        $data = array();
        $sql = "SELECT * FROM usuario WHERE email ='$email'";

        $resultQuery = $this->connection->query($sql);
        $data = $resultQuery->fetchAll(PDO::FETCH_ASSOC);

        return $data;
    }
}
