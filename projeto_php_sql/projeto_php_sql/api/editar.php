<?php
header("Content-Type: application/json");
include("../conexao/conexao.php");

// Recebe os dados do corpo da requisição
$dados = json_decode(file_get_contents("php://input"), true);
/**
 * Extrai o id da tarefa do array de dados e o converte para inteiro, 
 * garantindo segurança e evitando injeção de SQL através de tipos inesperados.
 */
$id = (int)$dados["id"];

/*Extrai o novo título e aplica real_escape_string, que escapa 
caracteres especiais para evitar injeção de SQL.*/
$titulo = $conn->real_escape_string($dados["titulo"]);

/*Cria a query SQL que atualiza(Altera) o campo titulo da tabela 
tarefas para a linha com o id correspondente.*/
$sql = "UPDATE tarefas SET titulo = '$titulo' WHERE id = $id";

// Executa o comando SQL no banco de dados.
$conn->query($sql);

//Retorna uma resposta JSON ao cliente indicando que a operação foi concluída com sucesso.
echo json_encode(["status" => "ok"]); //Devolva um texto JSON com o conteúdo { "status": "ok" }.
?>

