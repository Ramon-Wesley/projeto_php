<?php
require_once "./configuration/Connect.php";

class CategoryModel
{
    private $connection;

    public function __construct()
    {
        $this->connection = Connect::connection_database();
    }

    public function getAll(string $filter = "", int $limit = 5, string $direction = "ASC")
    {

        $stmt = $this->connection->prepare("SELECT * FROM categoria WHERE nome LIKE :filter ORDER BY nome {$direction} LIMIT :limit");
        $stmt->bindValue(":filter", '%' . $filter . '%');
        $stmt->bindValue(":limit", $limit, PDO::PARAM_INT);
        $stmt->execute();
        $result = array();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function create(string $name)
    {
        $stmt = $this->connection->prepare("INSERT INTO categoria(nome) VALUES (:nome)");


        $stmt->bindValue(":nome", $name);
        $stmt->execute();
    }
    public function deleteById(int $id)
    {
        $stmt = $this->connection->prepare("DELETE FROM categoria WHERE id = :id");
        $stmt->bindValue(":id", $id, PDO::PARAM_INT);
        $stmt->execute();
    }

    public function updateById(int $id, string $name)
    {
        $stmt = $this->connection->prepare("UPDATE categoria WHERE SET nome = :nome WHERE id = :id");
        $stmt->bindValue(":id", $id, PDO::PARAM_INT);
        $stmt->bindValue(":nome", $name);
        $stmt->execute();
    }
    public function getById(int $id)
    {
        $stmt = $this->connection->prepare("SELECT * FROM categoria WHERE id = :id");
        $stmt->bindValue(":id", $id, PDO::PARAM_INT);
        $stmt->execute();
        $result = array();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
}
