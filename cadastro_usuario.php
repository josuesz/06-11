<?php
// Incluir a conexão com o banco de dados
include 'conexao.php';  // Ajuste o caminho conforme necessário

// Verifica se a conexão foi bem-sucedida
if (!$conn) {
    die("Erro de conexão: " . $conn->connect_error);
}

// Verifica se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recebe os dados do formulário
    $nome = trim($_POST['nome']);
    $email = trim($_POST['email']);

    // Verifica se o nome e o email são válidos
    if (empty($nome) || empty($email)) {
        echo "Nome e email são obrigatórios!";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Por favor, insira um email válido.";
    } else {
        // Prepara a consulta SQL com prepared statements para evitar SQL Injection
        $stmt = $conn->prepare("INSERT INTO tbl_usuario (usu_nome, usu_email) VALUES (?, ?)");

        // Verifica se a preparação foi bem-sucedida
        if ($stmt) {
            // Vincula os parâmetros
            $stmt->bind_param("ss", $nome, $email); // 'ss' indica que ambos são strings

            // Executa a consulta e verifica o sucesso
            if ($stmt->execute()) {
                echo "Usuário cadastrado com sucesso!";
            } else {
                echo "Erro ao cadastrar usuário: " . $stmt->error;
            }

            // Fecha a declaração preparada
            $stmt->close();
        } else {
            echo "Erro ao preparar a consulta: " . $conn->error;
        }
    }
}

// Fecha a conexão
$conn->close();
?>
