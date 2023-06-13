<?php
require_once "./configuration/Connect.php";

class ProductModel
{
    private $connection;

    public function __construct()
    {
        $this->connection = Connect::connection_database();
    }

    public function getAll(string $filter = "", int $limit = 5, int $page = 1, string $direction = "ASC")
    {
        $countStmt = $this->connection->prepare("SELECT COUNT(*) FROM produto WHERE nome LIKE :filter");
        $countStmt->bindValue(":filter", '%' . $filter . '%');
        $countStmt->execute();
        $totalCount = $countStmt->fetchColumn();

        $offset = ($page - 1) * $limit;

        $stmt = $this->connection->prepare("SELECT * FROM produto WHERE nome LIKE :filter ORDER BY nome {$direction} LIMIT :limit OFFSET :offset");
        $stmt->bindValue(":filter", '%' . $filter . '%');
        $stmt->bindValue(":limit", $limit, PDO::PARAM_INT);
        $stmt->bindValue(":offset", $offset, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return [
            'totalCount' => $totalCount,
            'currentPage' => $page,
            'limit' => $limit,
            'data' => $result
        ];
    }

    public function create($values = array())
    {
        try {
            $id_category = (int)$values['Categoria'];
            $amount = (int)$values['Quantidade'];
            $unitary_value = (float)$values['Valor_unitario'];
            $stmt = $this->connection->prepare("INSERT INTO produto(id_categoria,nome,quantidade,valor_unitario) VALUES (:id_categoria,:nome,:quantidade,:valor_unitario)");

            $stmt->bindValue(":id_categoria", $id_category, PDO::PARAM_INT);
            $stmt->bindValue(":nome", $values['Nome']);
            $stmt->bindValue(":quantidade", $amount);
            $stmt->bindValue(":valor_unitario", $unitary_value);
            $stmt->execute();
            return "Registro atualizado com sucesso!";
        } catch (\PDOException $th) {
            return  "Erro ao cadastrar o resgistro!";
        }
    }
    public function deleteById(int $id)
    {
        try {
            //code...
            $stmt = $this->connection->prepare("DELETE FROM produto WHERE id = :id");
            $stmt->bindValue(":id", $id, PDO::PARAM_INT);
            $stmt->execute();
            return "Registro excluido com sucesso!";
        } catch (\Throwable $th) {
            return "Registro excluido com sucesso!";
        }
    }

    public function updateById(int $id, $values = array())
    {
        try {
            $id_category = isset($values['Categoria']) ? $values['Categoria'] : (isset($values['id_categoria']) ? $values['id_categoria'] : null);
            $name = isset($values['Nome']) ? $values['Nome'] : (isset($values['nome']) ? $values['nome'] : null);
            $quantidade = isset($values['Quantidade']) ? $values['Quantidade'] : (isset($values['quantidade']) ? $values['quantidade'] : null);
            $valor_unitario = isset($values['Valor_unitario']) ? $values['Valor_unitario'] : (isset($values['valor_unitario']) ? $values['valor_unitario'] : null);

            $stmt = $this->connection->prepare("UPDATE produto SET id_categoria = :id_categoria, nome = :nome, quantidade = :quantidade, valor_unitario = :valor_unitario WHERE id = :id ");
            $stmt->bindValue(":id", (int) $id, PDO::PARAM_INT);
            $stmt->bindValue(":id_categoria", (int) $id_category, PDO::PARAM_INT);
            $stmt->bindValue(":nome", $name);
            $stmt->bindValue(":quantidade", (int)$quantidade, PDO::PARAM_INT);
            $stmt->bindValue(":valor_unitario", $valor_unitario);
            $stmt->execute();

            return "Registro atualizado com sucesso!";
        } catch (PDOException $e) {
            // Tratar a exceção aqui, como exibir uma mensagem de erro ou registrar em um log
            return "Erro ao atualizar o produto: ";
        }
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
    public function getByname(string $name)
    {
        try {
            //code...
            $stmt = $this->connection->prepare("SELECT * FROM produto WHERE nome = :nome");
            $stmt->bindValue(":nome", $name);
            $stmt->execute();
            $result = array();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        } catch (\Throwable $th) {
            return $th;
        }
    }
    public function getBynameGetId(string $name)
    {
        try {
            $stmt = $this->connection->prepare("SELECT * FROM produto WHERE nome = :nome");
            $stmt->bindValue(":nome", $name);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result;
        } catch (\Throwable $th) {
            return $th;
        }
    }
}
