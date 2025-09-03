<?php

header("Content-Type: aplication/json");

include("../conexao/conexao.php");

$sql = "SELECT * FROM tarefas ORDER BY id DESC";

$result = $conn->query($sql);

$tarefas = [];

while($row = $result->fetch_assoc()){
    $tarefas[] = $row;
}

echo json_encode($tarefas);

?>