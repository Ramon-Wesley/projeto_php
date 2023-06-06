<?php
require_once "./configuration/Connect.php";
class SaleModel
{
    private $connection;
    public function __construct()
    {
        $this->connection = Connect::connection_database();
    }

    public function sale_items(int $id_sale, float $id_product, int $amount, float $partial_value)
    {
        $stmt = $this->connection->prepare("INSERT INTO itens_venda (id_venda,id_produto,quantidade,valor_parcial) VALUES (:id_venda,:id_produto,:quantidade,:valor_parcial");
        $stmt->bindValue(":id_venda", $id_sale, PDO::PARAM_INT);
        $stmt->bindValue(":id_produto", $id_product, PDO::PARAM_INT);
        $stmt->bindValue(":quantidade", $amount, PDO::PARAM_INT);
        $stmt->bindValue(":valor_parcial", $partial_value);
        $stmt->execute();
    }
    public function sale(int $id_client, int $total_value)
    {
        $stmt = $this->connection->prepare("INSERT INTO venda (id_cliente,valor_total,data_compra) VALUES (:id_cliente,:valor_total,:data_compra");
        $stmt->bindValue(":id_client", $id_client, PDO::PARAM_INT);
        $stmt->bindValue(":valor_total", $total_value);
        $stmt->bindValue(":data_compra", date('d/m/Y'));
        $stmt->execute();
    }
}
