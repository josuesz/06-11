<?php
include 'conexao.php';  // Verifique o caminho para o arquivo de conexão

// Verifica a conexão
if ($conn->connect_error) {
    die("Erro de conexão: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recebe os dados do formulário
    $setor = $_POST['setor'];
    $prioridade = $_POST['prioridade'];
    $descricao = $_POST['descricao'];
    $status = $_POST['status'];
    $usu_codigo = $_POST['usu_codigo'];

    // Prepara a consulta SQL com prepared statements para evitar SQL Injection
    $stmt = $conn->prepare("INSERT INTO tbl_tarefa (tar_setor, tar_prioridade, tar_descricao, tar_status, usu_codigo) 
                            VALUES (?, ?, ?, ?, ?)");

    if ($stmt) {
        // Vincula os parâmetros ('s' = string, 'i' = integer)
        $stmt->bind_param("ssssi", $setor, $prioridade, $descricao, $status, $usu_codigo); 

        // Executa a consulta
        if ($stmt->execute()) {
            echo "Tarefa cadastrada com sucesso!";
        } else {
            echo "Erro ao cadastrar tarefa: " . $stmt->error;
        }

        // Fecha a declaração
        $stmt->close();
    } else {
        echo "Erro ao preparar a consulta: " . $conn->error;
    }
}

// Fecha a conexão
$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Tarefa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h2>Cadastro de Tarefa</h2>
        <form method="POST" action="">
            <div class="mb-3">
                <label for="setor" class="form-label">Setor</label>
                <input type="text" class="form-control" id="setor" name="setor" required>
            </div>
            <div class="mb-3">
                <label for="prioridade" class="form-label">Prioridade</label>
                <input type="text" class="form-control" id="prioridade" name="prioridade" required>
            </div>
            <div class="mb-3">
                <label for="descricao" class="form-label">Descrição</label>
                <input type="text" class="form-control" id="descricao" name="descricao" required>
            </div>
            <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <input type="text" class="form-control" id="status" name="status" required>
            </div>
            <div class="mb-3">
                <label for="usu_codigo" class="form-label">Usuário</label>
                <select class="form-control" id="usu_codigo" name="usu_codigo" required>
                    <?php
                    // Consulta os usuários
                    $result = $conn->query("SELECT * FROM tbl_usuario");
                    
                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            echo "<option value='{$row['usu_codigo']}'>{$row['usu_nome']}</option>";
                        }
                    } else {
                        echo "<option value=''>Nenhum usuário encontrado</option>";
                    }
                    ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Cadastrar</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
