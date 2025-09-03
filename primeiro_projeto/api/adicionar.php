<?php

header("Content-Type: aplication/json");

include("../conexao/conexao.php");

$dados = json_decode(file_get_contents("php://input"), true);

$titulo = $conn->real_escape_string($dados['titulo']);

$sql = "INSERT INTO tarefas (titulo) VALUES ('$titulo')";

$conn->query($sql);

echo json_encode(["id" => $conn->insert_id, "titulo" => $titulo, "concluida" => 0]);

?>