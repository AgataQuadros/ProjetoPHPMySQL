<?php

header("Content-Type: aplication/json");

include("../conexao/conexao.php");

$dados = json_decode(file_get_contents("php://input"), true);

$id = (int)$dados["id"];

$titulo = $conn->real_escape_string($dados["titulo"]);

$sql = "UPDATE tarefas SET titulo = '$titulo' WHERE id = '$id'";

$conn->query($sql);

echo json_encode(["status" => "ok"]);

?>