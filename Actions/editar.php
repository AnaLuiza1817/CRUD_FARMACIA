<?php
require __DIR__ . '/../Infra/conexao.php';
$id = (int)($_GET['id'] ?? 0);

$funcionarios = $conexao->query("SELECT id, nome FROM funcionario ORDER BY nome")->fetchAll();
$comando = $conexao->prepare("SELECT * FROM pedido WHERE id = ?");
$comando->execute([$id]);
$pedido = $comando->fetch();

if (!$pedido) die("Pedido não encontrado.");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $comando = $conexao->prepare(
        "UPDATE pedido
         SET medicamento=?, quantidade=?, categoria=?, urgencia=?, funcionario_id=?
         WHERE id=?"
    );
    $comando->execute([
        $_POST['medicamento'],
        (int)$_POST['quantidade'],
        $_POST['categoria'],
        $_POST['urgencia'],
        (int)$_POST['funcionario_id'],
        $id
    ]);
    header("Location: ../index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<title>Editar Pedido</title>
<link rel="stylesheet" href="../CSS/style.css">
</head>
<body>
<div class="container-formulario">
    <h1>Editar Pedido</h1>
    
    <form method="post">
        <label>Medicamento:</label>
        <input type="text" name="medicamento" value="<?= htmlspecialchars($pedido['medicamento']) ?>" required>
        
        <label>Quantidade:</label>
        <input type="number" name="quantidade" min="1" value="<?= $pedido['quantidade'] ?>" required>
        
        <label>Categoria:</label>
        <select name="categoria" required>
            <?php foreach (['genérico','referência','controlado','higiene'] as $c): ?>
                <option <?= $pedido['categoria']==$c?'selected':'' ?>><?= $c ?></option>
            <?php endforeach; ?>
        </select>
        
        <label>Urgência:</label>
        <select name="urgencia" required>
            <?php foreach (['baixa','média','alta'] as $u): ?>
                <option <?= $pedido['urgencia']==$u?'selected':'' ?>><?= $u ?></option>
            <?php endforeach; ?>
        </select>
        
        <label>Funcionário:</label>
        <select name="funcionario_id" required>
            <?php foreach ($funcionarios as $f): ?>
                <option value="<?= $f['id'] ?>" <?= $pedido['funcionario_id']==$f['id']?'selected':'' ?>>
                    <?= htmlspecialchars($f['nome']) ?>
                </option>
            <?php endforeach; ?>
        </select>
        
        <button type="submit">Salvar Alterações</button>
    </form>
    
    <a href="../index.php" class="botao voltar">← Voltar ao painel</a>
</div>
</body>
</html>
