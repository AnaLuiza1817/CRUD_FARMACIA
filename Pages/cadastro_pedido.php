<?php
require __DIR__ . '/../Infra/conexao.php';
$mensagem = '';
$funcionarios = $conexao->query("SELECT id, nome FROM funcionario ORDER BY nome")->fetchAll();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $medicamento    = trim($_POST['medicamento'] ?? '');
    $quantidade     = (int)($_POST['quantidade'] ?? 0);
    $categoria      = $_POST['categoria'] ?? '';
    $urgencia       = $_POST['urgencia'] ?? '';
    $funcionario_id = (int)($_POST['funcionario_id'] ?? 0);

    if ($medicamento === '' || $quantidade <= 0 || !$categoria || !$urgencia || !$funcionario_id) {
        $mensagem = "Preencha todos os campos corretamente!";
    } else {
        $comando = $conexao->prepare(
            "INSERT INTO pedido
             (funcionario_id, medicamento, quantidade, categoria, urgencia, status)
             VALUES (?, ?, ?, ?, ?, 'solicitado')"
        );
        $comando->execute([$funcionario_id, $medicamento, $quantidade, $categoria, $urgencia]);
        $mensagem = "Pedido cadastrado com sucesso!";
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<title>Cadastro de Pedido</title>
<link rel="stylesheet" href="../CSS/style.css">
</head>
<body>
<div class="container-formulario">
    <h1>Cadastro de Pedido</h1>
    
    <?php if ($mensagem): ?>
        <p class="mensagem"><?= htmlspecialchars($mensagem) ?></p>
    <?php endif; ?>
    
    <form method="post">
        <label>Medicamento:</label>
        <input type="text" name="medicamento" required>
        
        <label>Quantidade:</label>
        <input type="number" name="quantidade" min="1" required>
        
        <label>Categoria:</label>
        <select name="categoria" required>
            <option value="">-- Selecione --</option>
            <option>genérico</option>
            <option>referência</option>
            <option>controlado</option>
            <option>higiene</option>
        </select>
        
        <label>Urgência:</label>
        <select name="urgencia" required>
            <option value="">-- Selecione --</option>
            <option>baixa</option>
            <option>média</option>
            <option>alta</option>
        </select>
        
        <label>Funcionário:</label>
        <select name="funcionario_id" required>
            <option value="">-- Selecione --</option>
            <?php foreach ($funcionarios as $f): ?>
                <option value="<?= $f['id'] ?>"><?= htmlspecialchars($f['nome']) ?></option>
            <?php endforeach; ?>
        </select>
        
        <button type="submit">Salvar Pedido</button>
    </form>
    
    <a href="../index.php" class="botao voltar">← Voltar ao painel</a>
</div>
</body>
</html>