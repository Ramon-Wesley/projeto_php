<?php

define("LOCALHOST", "localhost");
define("USER", "ramon");
define("DB", "sistema");
define("PASSWORD", "12345678");
$conn = new mysqli(LOCALHOST, USER, PASSWORD, DB);
if ($conn->connect_error) {
    die("Falha na conexão com o banco de dados: " . $conn->connect_error);
}

$termo = $_GET['cpf'];

$sql = "SELECT * FROM cliente WHERE cpf LIKE '%{$termo}%'";

$resultado = $conn->query($sql);

$clientes = array();

if ($resultado->num_rows > 0) {
    while ($row = $resultado->fetch_assoc()) {

        $clientes[] = $row;
    }
}
echo json_encode($clientes);
$conn->close();
