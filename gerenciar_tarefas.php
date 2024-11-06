<?php
include 'conexao.php';  // Verifique o caminho do arquivo de conexão

// Verifica a conexão
if ($conn->connect_error) {
    die("Erro de conexão: " . $conn->connect_error);
}

if (isset($_GET['delete'])) {
    $tar_codigo = $_GET['delete'];

    // Preparando a query para prevenir SQL Injection
    $stmt = $conn->prepare("DELETE FROM tbl_tarefa WHERE tar_codigo = ?");
    $stmt->bind_param("i", $tar_codigo); // 'i' indica que é um inteiro
    $stmt->execute();
    $stmt->close();

    // Redireciona após excluir
    header("Location: gerenciar_tarefas.php");
    exit(); // Importante para garantir que o script pare após o redirecionamento
}

// Consulta de tarefas com JOIN para pegar o nome do usuário
$result = $conn->query("
    SELECT t.tar_codigo, t.tar_setor, t.tar_prioridade, t.tar_descricao, t.tar_status, u.usu_nome
    FROM tbl_tarefa t
    JOIN tbl_usuario u ON t.usu_codigo = u.usu_codigo
");
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciar Tarefas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h2>Gerenciar Tarefas</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>Setor</th>
                    <th>Prioridade</th>
                    <th>Descrição</th>
                    <th>Status</th>
                    <th>Usuário</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= $row['tar_setor'] ?></td>
                        <td><?= $row['tar_prioridade'] ?></td>
                        <td><?= $row['tar_descricao'] ?></td>
                        <td><?= $row['tar_status'] ?></td>
                        <td><?= $row['usu_nome'] ?></td>
                        <td>
                            <a href="editar_tarefa.php?id=<?= $row['tar_codigo'] ?>" class="btn btn-warning btn-sm">Editar</a>
                            <a href="gerenciar_tarefas.php?delete=<?= $row['tar_codigo'] ?>" class="btn btn-danger btn-sm" 
                               onclick="return confirm('Tem certeza que deseja excluir esta tarefa?');">Excluir</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
