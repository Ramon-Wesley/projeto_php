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

    public function create(string $cep, string $state, string  $city, string $neighborhood, string  $street, string $number, string  $complement)
    {
        $stmt = $this->connection->prepare("INSERT INTO endereco(cep,estado,cidade,bairro,rua,numero,complemento) VALUES (:cep,:estado,:cidade,:bairro,:rua,:numero,:complemento)");

        $stmt->bindValue(":cep", $cep);
        $stmt->bindValue(":estado", $state);
        $stmt->bindValue(":cidade", $city);
        $stmt->bindValue(":bairro", $neighborhood);
        $stmt->bindValue(":rua", $street);
        $stmt->bindValue(":numero", $number);
        $stmt->bindValue(":complemento", $complement);
        $stmt->execute();
    }
    public function deleteById(int $id)
    {
        $stmt = $this->connection->prepare("DELETE FROM endereco WHERE id = :id");
        $stmt->bindValue(":id", $id, PDO::PARAM_INT);
        $stmt->execute();
    }


    public function updateById(int $id, string $cep, string $state, string  $city, string $neighborhood, string  $street, string $number, string  $complement)
    {
        $stmt = $this->connection->prepare("UPDATE endereco WHERE SET cep=:cep,estado= :estado,cidade= :cidade,bairro= :bairro,rua= :rua,numero= :numero,complemento= :complemento) WHERE id= :id");

        $stmt->bindValue(":id", $id, PDO::PARAM_INT);
        $stmt->bindValue(":cep", $cep);
        $stmt->bindValue(":estado", $state);
        $stmt->bindValue(":cidade", $city);
        $stmt->bindValue(":bairro", $neighborhood);
        $stmt->bindValue(":rua", $street);
        $stmt->bindValue(":numero", $number);
        $stmt->bindValue(":complemento", $complement);
        $stmt->execute();
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
