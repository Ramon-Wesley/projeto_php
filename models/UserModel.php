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

    public function signIn(
        string $email,
        string $password
    ) {


        try {
            $stmt = $this->connection->prepare("SELECT * FROM usuario WHERE email = :email ");
            $stmt->bindValue(':email', $email);
            $stmt->execute();
            $result = array();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if (password_verify($password, $result[0]['senha'])) {
                return $result;
            }
        } catch (\PDOException $th) {
            echo "erro:  " . $th;
        }
    }
    public function SignUp(
        $email,
        $password
    ) {
        try {
            $pass_hash = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $this->connection->prepare("INSERT INTO usuario (email,senha) VALUES (:email,:senha)");
            $stmt->bindValue(":email", $email);
            $stmt->bindValue(":senha", $pass_hash);
            $stmt->execute();
            //code...
        } catch (\PDOException $th) {
            echo "erro:  " . $th;
        }
    }
}
