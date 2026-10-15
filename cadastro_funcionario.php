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
        $comando = $conexao->prepare(
            "INSERT INTO funcionario (nome, email) VALUES (?, ?)"
        );
        $comando->execute([$nome, $email]);
        $mensagem = "cadastro concluído com sucesso";
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
<h1>Cadastro de Funcionário</h1>
<?php if ($mensagem): ?><p class="mensagem"><?= htmlspecialchars($mensagem) ?></p><?php endif; ?>
<form method="post">
    <label>Nome: <input type="text" name="nome" required></label>
    <label>E-mail: <input type="email" name="email" required></label>
    <button type="submit">Salvar</button>
</form>
<a href="../index.php">← Voltar ao painel</a>
</body>
</html>
