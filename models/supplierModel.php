<?php
require_once "./configuration/Connect.php";

class SupplierModel
{
    private $connection;

    public function __construct()
    {
        $this->connection = Connect::connection_database();
    }

    public function getAll(string $filter = "", int $limit = 5, string $direction = "ASC")
    {

        $stmt = $this->connection->prepare("SELECT * FROM fornecedor WHERE cnpj LIKE :filter ORDER BY nome {$direction} LIMIT :limit");
        $stmt->bindValue(":filter", '%' . $filter . '%');
        $stmt->bindValue(":limit", $limit, PDO::PARAM_INT);
        $stmt->execute();
        $result = array();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function create(string $name, string $cnpj, string $email, string $phone, int $id_address)
    {
        $stmt = $this->connection->prepare("INSERT INTO fornecedor(nome,cnpj,id_endereco,email,telefone) VALUES (:nome,cnpj,:id_endereco,:email,:telefone)");

        $stmt->bindValue(":nome", $name);
        $stmt->bindValue(":cnpj", $cnpj);
        $stmt->bindValue("id_endereco", $id_address, PDO::PARAM_INT);
        $stmt->bindValue(":telefone", $phone);
        $stmt->bindValue(":email", $email);
        $stmt->execute();
    }
    public function deleteById(int $id)
    {
        $stmt = $this->connection->prepare("DELETE FROM fornecedor WHERE id = :id");
        $stmt->bindValue(":id", $id, PDO::PARAM_INT);
        $stmt->execute();
    }
    public function updateById(int $id, string $name, string $cnpj, string $email, string $phone, int $id_address)
    {
        $stmt = $this->connection->prepare("UPDATE fornecedor WHERE SET nome = :nome ,cnpj = :cnpj,id_endereco = :id_endereco,email=:email,telefone=:telefone WHERE id = :id");
        $stmt->bindValue(":nome", $name);
        $stmt->bindValue(":cnpj", $cnpj);
        $stmt->bindValue("id_endereco", $id_address, PDO::PARAM_INT);
        $stmt->bindValue(":telefone", $phone);
        $stmt->bindValue(":email", $email);
        $stmt->execute();
    }
    public function getById(int $id)
    {
        $stmt = $this->connection->prepare("SELECT * FROM fornecedor WHERE id = :id");
        $stmt->bindValue(":id", $id, PDO::PARAM_INT);
        $stmt->execute();
        $result = array();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
}
