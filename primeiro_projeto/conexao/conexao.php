<?php 
// configuração de conexão
$host = "localhost"; // 
$user = "root";
$pass = "";
$bd = "tarefa_bd";

$conn = new mysqli($host, $user, $pass, $bd);

if ($conn->connect_error) {
    die("ERRO NA CONEXÃO: " . $conn->connection_error);
}

?>