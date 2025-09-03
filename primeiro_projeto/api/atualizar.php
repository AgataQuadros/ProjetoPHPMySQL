<?php

header("Content-Type: aplication/json");

include("../conexao/conexao.php");

$dados = json_decode(file_get_contents("php://input"), true);

$id = (int)$dados["id"];
$concluida = (int)$dados["concluida"];

$sql = "UPDATE tarefas SET concluida = $concluida WHERE id = $id";
$conn->query($sql);

echo json_encode(["status" => "ok"]);

?>