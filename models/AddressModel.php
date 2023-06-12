<?php
require_once "./configuration/Connect.php";

class AddressModel
{
    private $connection;

    public function __construct()
    {
        $this->connection = Connect::connection_database();
    }

    public function getAll(string $filter = "", int $limit = 5, string $direction = "ASC")
    {

        $stmt = $this->connection->prepare("SELECT * FROM produtos WHERE cep LIKE :filter ORDER BY cidade {$direction} LIMIT :limit");
        $stmt->bindValue(":filter", '%' . $filter . '%');
        $stmt->bindValue(":limit", $limit, PDO::PARAM_INT);
        $stmt->execute();
        $result = array();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function create($values = array())
    {

        try {
            /* 'Cep' => 'text',
            'estado' => 'text',
            'cidade' => 'text',
            'bairro' => 'text',
            'rua' => 'text',
            'numero' => 'text',
            'complemento' => 'text'...*/
            $stmt = $this->connection->prepare("INSERT INTO endereco(cep,estado,cidade,bairro,rua,numero,complemento) VALUES (:cep,:estado,:cidade,:bairro,:rua,:numero,:complemento)");

            $stmt->bindValue(":cep", $values['Cep']);
            $stmt->bindValue(":estado", $values['estado']);
            $stmt->bindValue(":cidade", $values['cidade']);
            $stmt->bindValue(":bairro", $values['bairro']);
            $stmt->bindValue(":rua", $values['rua']);
            $stmt->bindValue(":numero", $values['numero']);
            $stmt->bindValue(":complemento", $values['complemento']);
            $stmt->execute();
            return  $this->connection->lastInsertId();
        } catch (\PDOException $th) {
            return "endereco: " . $th;
        }
    }
    public function deleteById(int $id)
    {
        $stmt = $this->connection->prepare("DELETE FROM endereco WHERE id = :id");
        $stmt->bindValue(":id", $id, PDO::PARAM_INT);
        $stmt->execute();
    }


    public function updateById(int $id, $values = array())
    {
        try {
            $stmt = $this->connection->prepare("UPDATE endereco SET cep = :cep, estado = :estado, cidade = :cidade, bairro = :bairro, rua = :rua, numero = :numero, complemento = :complemento WHERE id = :id");

            $stmt->bindValue(":cep", $values['cep']);
            $stmt->bindValue(":estado", $values['estado']);
            $stmt->bindValue(":cidade", $values['cidade']);
            $stmt->bindValue(":bairro", $values['bairro']);
            $stmt->bindValue(":rua", $values['rua']);
            $stmt->bindValue(":numero", $values['numero']);
            $stmt->bindValue(":complemento", $values['complemento']);
            $stmt->bindValue(":id", $id, PDO::PARAM_INT);
            $stmt->execute();
        } catch (\PDOException $e) {
            return "Erro ao atualizar o registro"; // Propague a exceção para que possa ser tratada em um nível superior, se necessário
        }
    }

    public function getById(int $id)
    {
        $stmt = $this->connection->prepare("SELECT * FROM endereco WHERE id = :id");
        $stmt->bindValue(":id", $id, PDO::PARAM_INT);
        $stmt->execute();
        $result = array();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
}
