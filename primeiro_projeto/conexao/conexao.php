<?php 
$host = "localhost";
$user = "root";
$pass = "";
$bd = "tarefas_bd";

$conn = new mysqli($host, $user, $pass, $bd);

if ($conn->connection_error) {
    die("ERRO NA CONEXÃO: " . $conn->connection_error);
}

?>