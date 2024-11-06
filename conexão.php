<?php
// Definindo as credenciais do banco de dados
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', ''); // Senha do banco de dados
define('DB_NAME', 'site'); // Nome do banco de dados

// Criação da conexão
$conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

// Verifica se houve erro na conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error . " (Código de erro: " . $conn->connect_errno . ")");
}

// Definir o charset para UTF-8 (opcional, mas recomendado)
$conn->set_charset("utf8");

echo "Conexão bem-sucedida!";
?>

