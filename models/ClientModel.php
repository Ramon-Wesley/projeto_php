<?php
require_once "./configuration/Connect.php";

class ClientModel
{
    private $connection;

    public function __construct()
    {
        $this->connection = Connect::connection_database();
    }

    public function getAll(string $filter = "", int $limit = 5, int $page = 1, string $direction = "ASC")
    {
        $countStmt = $this->connection->prepare("SELECT COUNT(*) FROM cliente WHERE cpf LIKE :filter");
        $countStmt->bindValue(":filter", '%' . $filter . '%');
        $countStmt->execute();
        $totalCount = $countStmt->fetchColumn();

        $offset = ($page - 1) * $limit;

        $stmt = $this->connection->prepare("
        SELECT cliente.id, cliente.cpf, cliente.nome, cliente.email, cliente.telefone, endereco.cep, endereco.estado, endereco.cidade, endereco.bairro, endereco.rua, endereco.numero, endereco.complemento
        FROM cliente
        LEFT JOIN endereco ON cliente.id_endereco = endereco.id
        WHERE cliente.cpf LIKE :filter
        ORDER BY cliente.nome {$direction}
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
    }

    public function create($values = array())
    {
        try {
            //code...
            $address = new AddressModel();
            $id_address = $address->create($values);
            $stmt = $this->connection->prepare("INSERT INTO cliente(nome,cpf,id_endereco,email,telefone) VALUES (:nome,:cpf,:id_endereco,:email,:telefone)");
            $id_address = intval($id_address);
            var_dump($id_address);
            $stmt->bindValue(":nome", $values['Nome']);
            $stmt->bindValue(":cpf", $values['CPF']);
            $stmt->bindValue(":id_endereco", $id_address);
            $stmt->bindValue(":telefone", $values['telefone']);
            $stmt->bindValue(":email", $values['Email']);
            $stmt->execute();
        } catch (\PDOException $th) {
            return "Erro ao criar o registro! ";
        }
    }
    public function deleteById(int $id)
    {
        try {

            $stmt = $this->connection->prepare("DELETE FROM cliente WHERE id = :id");
            $stmt->bindValue(":id", $id, PDO::PARAM_INT);
            $stmt->execute();
            return "Registro excluido com sucesso!";
        } catch (\Throwable $th) {
            return "Erro ao excluir o registro!";
        }
    }

    public function updateById(int $id, int $idAddress, $values = array())
    {
        try {
            $endereco = new AddressModel();
            $enderecoValues = array(
                'id_endereco' => $idAddress,
                'cpf' => $values['Cpf'],
                'estado' => $values['estado'],
                'cidade' => $values['cidade'],
                'bairro' => $values['bairro'],
                'rua' => $values['rua'],
                'numero' => $values['numero'],
                'complemento' => $values['complemento']
            );

            $endereco->updateById($idAddress, $enderecoValues);

            $stmt = $this->connection->prepare("UPDATE cliente SET nome = :nome, cpf = :cpf, id_endereco = :id_endereco, email = :email, telefone = :telefone WHERE id = :id");
            $stmt->bindValue(":nome", $values['Nome']);
            $stmt->bindValue(":cpf", $values['CPF']);
            $stmt->bindValue(":id_endereco", $idAddress, PDO::PARAM_INT);
            $stmt->bindValue(":telefone", $values['telefone']);
            $stmt->bindValue(":email", $values['Email']);
            $stmt->bindValue(":id", $id, PDO::PARAM_INT);
            $stmt->execute();

            return "Registro atualizado com sucesso!";
        } catch (\PDOException $e) {
            return "Erro ao atualizar o registro.";
        }
    }
    public function getById(int $id)
    {
        try {
            $stmt = $this->connection->prepare("
                SELECT f.id AS cliente_id, f.cpf, f.nome, f.email, f.telefone,
                       e.id AS endereco_id, e.cep, e.estado, e.cidade, e.bairro, e.rua, e.numero, e.complemento
                FROM cliente f
                INNER JOIN endereco e ON f.id_endereco = e.id
                WHERE f.id = :id
            ");
            $stmt->bindValue(":id", $id, PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            return $result;
        } catch (\PDOException $e) {
            throw new \Exception("Erro ao recuperar o registro de cliente .");
        }
    }
    public function getByCpf(string $cpf)
    {
        try {
            $stmt = $this->connection->prepare("SELECT * FROM cliente WHERE cpf = :cpf");
            $stmt->bindValue(":cpf", $cpf);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $result;
        } catch (\PDOException $e) {
            throw new \Exception("Erro ao recuperar os registros .");
        }
    }
}
