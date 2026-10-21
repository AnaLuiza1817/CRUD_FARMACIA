<?php
require __DIR__ . '/../Infra/conexao.php';
$mensagem = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome  = trim($_POST['nome'] ?? '');
    $email = trim($_POST['email'] ?? '');

    if ($nome === '' || $email === '') {
        $mensagem = "Preencha todos os campos!";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $mensagem = "E-mail inválido!";
    } else {
        try {
            $comando = $conexao->prepare(
                "INSERT INTO funcionario (nome, email) VALUES (?, ?)"
            );
            $comando->execute([$nome, $email]);
            $mensagem = "Cadastro concluído com sucesso!";
        } catch (PDOException $e) {
            $mensagem = "Erro: Este e-mail já está cadastrado.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<title>Cadastro de Funcionário</title>
<link rel="stylesheet" href="../CSS/style.css">
</head>
<body>
<div class="container-formulario">
    <h1>Cadastro de Funcionário</h1>
    
    <?php if ($mensagem): ?>
        <p class="mensagem"><?= htmlspecialchars($mensagem) ?></p>
    <?php endif; ?>
    
    <form method="post">
        <label>Nome:</label>
        <input type="text" name="nome" required>
        
        <label>E-mail:</label>
        <input type="email" name="email" required>
        
        <button type="submit">Salvar Funcionário</button>
    </form>
    
    <a href="../index.php" class="botao voltar">← Voltar ao painel</a>
</div>
</body>
</html>
