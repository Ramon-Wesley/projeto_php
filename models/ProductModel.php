<?php
require_once "./configuration/Connect.php";

class ProductModel
{
    private $connection;

    public function __construct()
    {
        $this->connection = Connect::connection_database();
    }

    public function getAll(string $filter = "", int $limit = 5, string $direction = "ASC")
    {

        $stmt = $this->connection->prepare("SELECT * FROM produtos WHERE nome LIKE :filter ORDER BY nome {$direction} LIMIT :limit");
        $stmt->bindValue(":filter", '%' . $filter . '%');
        $stmt->bindValue(":limit", $limit, PDO::PARAM_INT);
        $stmt->execute();
        $result = array();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function create(int $id_category, string $name, string $description = "")
    {
        $stmt = $this->connection->prepare("INSERT INTO produto(id_categoria,nome,descricao) VALUES (:id_categoria,:nome,:descricao)");

        $stmt->bindValue(":id_categoria", $id_category, PDO::PARAM_INT);
        $stmt->bindValue(":nome", $name);
        $stmt->bindValue("descricao", $description);
        $stmt->execute();
    }
    public function deleteById(int $id)
    {
        $stmt = $this->connection->prepare("DELETE FROM produto WHERE id = :id");
        $stmt->bindValue(":id", $id, PDO::PARAM_INT);
        $stmt->execute();
    }

    public function updateById(int $id, int $id_category, string $name, string $description = "")
    {
        $stmt = $this->connection->prepare("UPDATE produto WHERE SET id_categoria=:id_categoria,nome = :nome ,descricao = :descricao WHERE id = :id");
        $stmt->bindValue(":id", $id, PDO::PARAM_INT);
        $stmt->bindValue(":id_categoria", $id_category, PDO::PARAM_INT);
        $stmt->bindValue(":nome", $name);
        $stmt->bindValue("descricao", $description);
        $stmt->execute();
    }
    public function getById(int $id)
    {
        $stmt = $this->connection->prepare("SELECT * FROM produto WHERE id = :id");
        $stmt->bindValue(":id", $id, PDO::PARAM_INT);
        $stmt->execute();
        $result = array();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
}
