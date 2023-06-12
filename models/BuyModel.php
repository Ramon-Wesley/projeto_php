<?php
require_once "./configuration/Connect.php";
class BuyModel
{
    private $connection;
    public function __construct()
    {
        $this->connection = Connect::connection_database();
    }

    public function buy_items($id, array $value)
    {
        $length = count($value);
        if ($length > 0) {
            try {
                $this->connection->beginTransaction();

                $stmt = $this->connection->prepare("INSERT INTO itens_compra(id_compra, id_produto, quantidade, valor_parcial) VALUES (:id_compra, :id_produto, :quantidade, :valor_parcial)");

                for ($i = 0; $i < $length; $i++) {

                    $product = new ProductModel();
                    $res = $product->getByname($value[$i]->product);
                    $res = $res[0]['id'];
                    $val = (float)$value[$i]->partial_value;
                    $amount = (int)$value[$i]->amount;

                    $stmt->bindValue(":id_compra", $id, PDO::PARAM_INT);
                    $stmt->bindValue(":id_produto", $res, PDO::PARAM_INT);
                    $stmt->bindValue(":quantidade", $amount, PDO::PARAM_INT);
                    $stmt->bindValue(":valor_parcial", $val);

                    $stmt->execute();
                }
                $this->connection->commit();

                return "Registros inseridos com sucesso!";
            } catch (\PDOException $th) {
                $this->connection->rollBack();
                return "Erro ao inserir registros: " . $th->getMessage();
            }
        }
    }

    public function buy($value, $valueItems)
    {
        try {
            $this->connection->beginTransaction();
            $supplier = new  SupplierModel();
            $id_fornecedor = $supplier->getByCnpj($value['CNPJ']);
            $id_fornecedor = $id_fornecedor[0]['id'];
            $stmt = $this->connection->prepare("INSERT INTO compra (id_fornecedor,valor_total,data_compra) VALUES (:id_fornecedor,:valor_total,:data_compra)");
            $stmt->bindValue(":id_fornecedor", $id_fornecedor, PDO::PARAM_INT);
            $stmt->bindValue(":valor_total", $value['total_value']);
            $stmt->bindValue(":data_compra", date('Y-m-d'));
            $stmt->execute();
            $id = (int)$this->connection->lastInsertId();
            $this->connection->commit();
            if ($id > 0) {
                $this->buy_items($id, $valueItems);
            }
            return "Registro atualizado com sucesso!";
        } catch (\PDOException $th) {
            $this->connection->rollBack();
            return "Erro ao inserir registros: ";
        }
    }
    public function getAll(string $filter = "", int $limit = 5, int $page = 1, string $direction = "ASC")
    {
        $countStmt = $this->connection->prepare("SELECT COUNT(*) FROM compra ");
        // $countStmt->bindValue(":filter", '%' . $filter . '%');
        $countStmt->execute();
        $totalCount = $countStmt->fetchColumn();

        $offset = ($page - 1) * $limit;

        $stmt = $this->connection->prepare("
        SELECT compra.id, fornecedor.cnpj, fornecedor.nome, fornecedor.email, fornecedor.telefone, compra.valor_total, compra.data_compra
        FROM compra
        LEFT JOIN fornecedor ON compra.id_fornecedor = fornecedor.id
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
    public function deleteById(int $id)
    {
        try {
            //code...
            $stmt = $this->connection->prepare("DELETE FROM compra WHERE id = :id");
            $stmt->bindValue(":id", $id, PDO::PARAM_INT);
            $stmt->execute();
            return "Registro excluido com sucesso!";
        } catch (\PDOException $th) {
            return "Erro ao excluir o registro";
        }
    }
    public function saleSum()
    {
        try {
            $query = "SELECT MONTH(data_compra) AS mes, YEAR(data_compra) AS ano, SUM(valor_total) AS total_vendas
            FROM compra WHERE data_compra >= DATE_SUB(CURDATE(), INTERVAL 1 YEAR) AND data_compra <= CURDATE()
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
}
