<?php

define("LOCALHOST", "localhost");
define("USER", "ramon");
define("DB", "sistema");
define("PASSWORD", "12345678");
$conn = new mysqli(LOCALHOST, USER, PASSWORD, DB);
if ($conn->connect_error) {
    die("Falha na conexão com o banco de dados: " . $conn->connect_error);
}

// Receber o termo de pesquisa do cliente
$termo = $_GET['valor'];

$sql = "SELECT * FROM produto WHERE nome LIKE '%{$termo}%'";

$resultado = $conn->query($sql);

$clientes = array();

if ($resultado->num_rows > 0) {
    while ($row = $resultado->fetch_assoc()) {
        // Adicionar o nome do cliente ao array
        $clientes[] = $row;
    }
}
echo json_encode($clientes);
$conn->close();
