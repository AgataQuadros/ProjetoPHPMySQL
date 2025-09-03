<?php
// Configurações de conexão
$host = "localhost";   // Servidor do banco
$user = "root";        // Usuário (padrão do XAMPP)
$pass = "";            // Senha (vazia no XAMPP por padrão)
$db   = "tarefas_db";  // Nome do banco

// Cria a conexão
$conn = new mysqli($host, $user, $pass, $db);

// Verifica se ocorreu algum erro
if ($conn->connect_error) {
   die("Erro na conexão: " . $conn->connect_error);
}
