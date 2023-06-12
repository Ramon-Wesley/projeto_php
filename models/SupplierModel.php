<?php
require_once "./configuration/Connect.php";

class SupplierModel
{
    private $connection;

    public function __construct()
    {
        $this->connection = Connect::connection_database();
    }

    public function getAll(string $filter = "", string $direction = "ASC", int $page = 1, int $limit = 10)
    {
        try {
            $countStmt = $this->connection->prepare("SELECT COUNT(*) FROM fornecedor WHERE cnpj LIKE :filter");
            $countStmt->bindValue(":filter", '%' . $filter . '%');
            $countStmt->execute();
            $totalCount = $countStmt->fetchColumn();

            $offset = ($page - 1) * $limit;

            $stmt = $this->connection->prepare("
                SELECT fornecedor.id, fornecedor.cnpj, fornecedor.nome, fornecedor.email, fornecedor.telefone, endereco.cep, endereco.estado, endereco.cidade, endereco.bairro, endereco.rua, endereco.numero, endereco.complemento
                FROM fornecedor
                LEFT JOIN endereco ON fornecedor.id_endereco = endereco.id
                WHERE fornecedor.cnpj LIKE :filter
                ORDER BY fornecedor.nome {$direction}
                LIMIT :limit OFFSET :offset
            ");
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
        } catch (\PDOException $e) {
            throw new \Exception("Erro ao recuperar os registros de fornecedores.");
        }
    }


    public function create($values = array())
    {
        try {
            $address = new AddressModel();
            $id_address = $address->create($values);

            $stmt = $this->connection->prepare("INSERT INTO fornecedor(nome,cnpj,id_endereco,email,telefone) VALUES (:nome,:cnpj,:id_endereco,:email,:telefone)");
            $id_address = intval($id_address);
            $stmt->bindValue(":nome", $values['Nome']);
            $stmt->bindValue(":cnpj", $values['CNPJ']);
            $stmt->bindValue(":id_endereco", $id_address);
            $stmt->bindValue(":telefone", $values['telefone']);
            $stmt->bindValue(":email", $values['Email']);
            $stmt->execute();

            return "Registro atualizado com sucesso!";
        } catch (\PDOException $e) {
            return "Erro ao cadastrar o registro de fornecedor.";
        }
    }

    public function deleteById(int $id)
    {
        try {
            $stmt = $this->connection->prepare("DELETE FROM fornecedor WHERE id = :id");
            $stmt->bindValue(":id", $id, PDO::PARAM_INT);
            $stmt->execute();

            return "Registro excluido com sucesso!";
        } catch (\PDOException $e) {
            return "Erro ao deletar o registro de fornecedor.";
        }
    }

    public function updateById(int $id, int $idAddress, $values = array())
    {
        try {
            $endereco = new AddressModel();
            $enderecoValues = array(
                'id_endereco' => $idAddress,
                'cep' => $values['Cep'],
                'estado' => $values['estado'],
                'cidade' => $values['cidade'],
                'bairro' => $values['bairro'],
                'rua' => $values['rua'],
                'numero' => $values['numero'],
                'complemento' => $values['complemento']
            );

            $endereco->updateById($idAddress, $enderecoValues);

            $stmt = $this->connection->prepare("UPDATE fornecedor SET nome = :nome, cnpj = :cnpj, id_endereco = :id_endereco, email = :email, telefone = :telefone WHERE id = :id");
            $stmt->bindValue(":nome", $values['Nome']);
            $stmt->bindValue(":cnpj", $values['CNPJ']);
            $stmt->bindValue(":id_endereco", $idAddress, PDO::PARAM_INT);
            $stmt->bindValue(":telefone", $values['telefone']);
            $stmt->bindValue(":email", $values['Email']);
            $stmt->bindValue(":id", $id, PDO::PARAM_INT);
            $stmt->execute();

            return "Registro atualizado com sucesso!";
        } catch (\PDOException $e) {
            return "Erro ao atualizar o registro de fornecedor.";
        }
    }

    public function getById(int $id)
    {
        try {
            $stmt = $this->connection->prepare("
                SELECT f.id AS fornecedor_id, f.cnpj, f.nome, f.email, f.telefone,
                       e.id AS endereco_id, e.cep, e.estado, e.cidade, e.bairro, e.rua, e.numero, e.complemento
                FROM fornecedor f
                INNER JOIN endereco e ON f.id_endereco = e.id
                WHERE f.id = :id
            ");
            $stmt->bindValue(":id", $id, PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            return $result;
        } catch (\PDOException $e) {
            throw new \Exception("Erro ao recuperar o registro de fornecedor pelo ID.");
        }
    }

    public function getByCnpj($cnpj)
    {
        try {
            $stmt = $this->connection->prepare("SELECT * FROM fornecedor WHERE cnpj = :cnpj");
            $stmt->bindValue(":cnpj", $cnpj);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $result;
        } catch (\PDOException $e) {
            throw new \Exception("Erro ao recuperar os registros de fornecedores pelo CNPJ.");
        }
    }
}
