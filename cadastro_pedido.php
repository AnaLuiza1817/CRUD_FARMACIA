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
        $mensagem = "cadastro concluído com sucesso";
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
<h1>Cadastro de Pedido</h1>
<?php if ($mensagem): ?><p class="mensagem"><?= htmlspecialchars($mensagem) ?></p><?php endif; ?>
<form method="post">
    <label>Medicamento: <input type="text" name="medicamento" required></label>
    <label>Quantidade: <input type="number" name="quantidade" min="1" required></label>
    <label>Categoria:
        <select name="categoria" required>
            <option value="">-- Selecione --</option>
            <option>genérico</option>
            <option>referência</option>
            <option>controlado</option>
            <option>higiene</option>
        </select>
    </label>
    <label>Urgência:
        <select name="urgencia" required>
            <option value="">-- Selecione --</option>
            <option>baixa</option>
            <option>média</option>
            <option>alta</option>
        </select>
    </label>
    <label>Funcionário:
        <select name="funcionario_id" required>
            <option value="">-- Selecione --</option>
            <?php foreach ($funcionarios as $f): ?>
                <option value="<?= $f['id'] ?>"><?= htmlspecialchars($f['nome']) ?></option>
            <?php endforeach; ?>
        </select>
    </label>
    <button type="submit">Salvar</button>
</form>
<a href="../index.php">← Voltar ao painel</a>
</body>
</html>
