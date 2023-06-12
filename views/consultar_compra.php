<?php

define("LOCALHOST", "localhost");
define("USER", "ramon");
define("DB", "sistema");
define("PASSWORD", "12345678");

$conn = new mysqli(LOCALHOST, USER, PASSWORD, DB);
if ($conn->connect_error) {
    die("Falha na conexão com o banco de dados: " . $conn->connect_error);
}

$compra = filter_input(INPUT_GET, 'compra', FILTER_VALIDATE_INT);

if ($compra !== null && $compra !== false) {
    $offset = ($compra - 1) * 5;
    $sql = "SELECT compra.id,fornecedor.cnpj, fornecedor.nome, fornecedor.email, fornecedor.telefone, compra.valor_total, compra.data_compra
            FROM compra
            LEFT JOIN fornecedor ON compra.id_fornecedor = fornecedor.id
            LIMIT 5 OFFSET $offset";

    $resultado = $conn->query($sql);

    $clientes = array();

    if ($resultado !== false && $resultado->num_rows > 0) {
        while ($row = $resultado->fetch_assoc()) {
            $clientes[] = $row;
        }
    }

    echo json_encode($clientes);
} else {
    echo "Parâmetro 'compra' inválido.";
}

$conn->close();
