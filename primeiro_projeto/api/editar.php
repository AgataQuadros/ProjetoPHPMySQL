<?php

header("Content-Type: aplication/jason");

include("../conexao/conexao.php");

$dados = json_decode(file_get_contents("php://input"), true);


$id = (int)$dados["id"];

$titulo = $conn->real_escape_string($dados["titulo"]);

$sql = "UPDATE tarefas SET titulo = '$titulo'"

echo json_encode(["status" => "ok"]);

?>