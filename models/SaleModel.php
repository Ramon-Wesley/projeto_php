<?php
require_once "./configuration/Connect.php";
class SaleModel
{
    private $connection;
    public function __construct()
    {
        $this->connection = Connect::connection_database();
    }

    public function sale_items($id, $value = array())
    {

        $length = count($value);
        if ($length > 0) {
            try {
                $this->connection->beginTransaction();

                $stmt = $this->connection->prepare("INSERT INTO itens_venda(id_venda, id_produto, quantidade, valor_parcial) VALUES (:id_venda, :id_produto, :quantidade, :valor_parcial)");

                for ($i = 0; $i < $length; $i++) {

                    $product = new ProductModel();
                    $res =  $product->getBynameGetId($value[$i]->product);
                    $val = (float)$value[$i]->partial_value;
                    $amount = (int)$value[$i]->amount;
                    $res['quantidade'] =  $res['quantidade'] - $amount;

                    $product->updateById($res['id'], $res);
                    $stmt->bindValue(":id_produto", $res['id'], PDO::PARAM_INT);
                    $stmt->bindValue(":quantidade", $amount, PDO::PARAM_INT);
                    $stmt->bindValue(":valor_parcial", $val);

                    $stmt->execute();
                }

                // Confirmar a transação
                $this->connection->commit();

                return "Registros inseridos com sucesso!";
            } catch (\PDOException $th) {
                // Caso ocorra algum erro, desfazer a transação
                $this->connection->rollBack();
                return "Erro ao inserir registros: " . $th->getMessage();
            }
        }
    }

    public function sale($value, $valueItems)
    {

        try {
            $this->connection->beginTransaction();
            $cliente = new  ClientModel();
            $id_cliente = $cliente->getByCpf($value["CPF"]);
            $id_cliente = $id_cliente[0]['id'];
            $stmt = $this->connection->prepare("INSERT INTO venda(id_cliente,valor_total,data_compra) VALUES (:id_cliente,:valor_total,:data_compra)");
            $stmt->bindValue(":id_cliente", $id_cliente, PDO::PARAM_INT);
            $stmt->bindValue(":valor_total", $value['total_value']);
            $stmt->bindValue(":data_compra", date('Y-m-d'));
            $stmt->execute();
            $id = (int)$this->connection->lastInsertId();
            $this->connection->commit();
            if ($id > 0) {
                $this->sale_items($id, $valueItems);
            }
            return "Registro atualizado com sucesso!";
        } catch (\PDOException $th) {
            $this->connection->rollBack();
            return "Erro ao inserir registros: ";
        }
    }

    public function getAll(string $filter = "", int $limit = 5, int $page = 1, string $direction = "ASC")
    {
        $countStmt = $this->connection->prepare("SELECT COUNT(*) FROM venda ");
        // $countStmt->bindValue(":filter", '%' . $filter . '%');
        $countStmt->execute();
        $totalCount = $countStmt->fetchColumn();

        $offset = ($page - 1) * $limit;

        $stmt = $this->connection->prepare("
        SELECT venda.id,cliente.cpf, cliente.nome, cliente.email, cliente.telefone, venda.valor_total, venda.data_compra
        FROM venda
        LEFT JOIN cliente ON venda.id_cliente = cliente.id
        LIMIT :limit OFFSET :offset
    ");
        //$stmt->bindValue(":filter", '%' . $filter . '%');
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
    public function saleSum()
    {
        try {
            $query = "SELECT MONTH(data_compra) AS mes, YEAR(data_compra) AS ano, SUM(valor_total) AS total_vendas
            FROM venda WHERE data_compra >= DATE_SUB(CURDATE(), INTERVAL 1 YEAR) AND data_compra <= CURDATE()
            GROUP BY YEAR(data_compra), MONTH(data_compra)
            ORDER BY YEAR(data_compra), MONTH(data_compra)";

            $stmt = $this->connection->prepare($query);
            $stmt->execute();

            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $values = array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
            foreach ($results as $row) {
                $values[$row['mes'] - 1] = $row['total_vendas'];
            }
            return $values;
        } catch (PDOException $e) {
            return 'Erro ao executar consulta: ' . $e->getMessage();
            exit();
        }
    }

    public function deleteById(int $id)
    {
        try {

            $stmt = $this->connection->prepare("DELETE FROM venda WHERE id = :id");
            $stmt->bindValue(":id", $id, PDO::PARAM_INT);
            $stmt->execute();
            return "Registro excluido com sucesso!";
        } catch (\PDOException $th) {
            return "Erro ao deletar o registro!";
        }
    }
    public function getItemsSale(int $id)
    {
        try {
            $stmt = $this->connection->prepare("SELECT * FROM itens_venda WHERE id_venda = :id_venda ");
            $stmt->bindValue(":id_venda", $id);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        } catch (\Throwable $th) {
        }
    }
}
