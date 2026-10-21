<?php
require __DIR__ . '/Infra/conexao.php';

$consulta = "SELECT p.*, f.nome AS funcionario
             FROM pedido p
             JOIN funcionario f ON f.id = p.funcionario_id
             ORDER BY FIELD(p.urgencia,'alta','média','baixa'), p.id DESC";
$pedidos = $conexao->query($consulta)->fetchAll();

$colunas = ['solicitado' => [], 'em separação' => [], 'recebido' => []];
foreach ($pedidos as $p) {
    $colunas[$p['status']][] = $p;
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<title>Painel de Reposição</title>
<link rel="stylesheet" href="CSS/style.css">
</head>
<body>
<header>
    <h1>Painel de Reposição</h1>
    <nav>
        <a href="Pages/cadastro_funcionario.php">+ Funcionário</a>
        <a href="Pages/cadastro_pedido.php">+ Pedido</a>
    </nav>
</header>

<div class="painel">
<?php foreach ($colunas as $status => $lista): ?>
    <div class="coluna">
        <h2><?= ucfirst($status) ?></h2>
        <?php foreach ($lista as $p): ?>
            <div class="card urgencia-<?= $p['urgencia'] ?>">
                <strong><?= htmlspecialchars($p['medicamento']) ?></strong>
                <p>Quantidade: <?= $p['quantidade'] ?></p>
                <p>Categoria: <?= htmlspecialchars($p['categoria']) ?></p>
                <p>Urgência: <?= htmlspecialchars($p['urgencia']) ?></p>
                <p>Funcionário: <?= htmlspecialchars($p['funcionario']) ?></p>

                <form action="Actions/atualizar.php" method="post" class="linha">
                    <input type="hidden" name="id" value="<?= $p['id'] ?>">
                    <select name="status">
                        <option <?= $p['status']=='solicitado'?'selected':'' ?>>solicitado</option>
                        <option <?= $p['status']=='em separação'?'selected':'' ?>>em separação</option>
                        <option <?= $p['status']=='recebido'?'selected':'' ?>>recebido</option>
                    </select>
                    <button type="submit">Atualizar</button>
                </form>

                <a class="botao" href="Actions/editar.php?id=<?= $p['id'] ?>">Editar</a>
                <a class="botao excluir" href="Actions/excluir.php?id=<?= $p['id'] ?>"
                   onclick="return confirm('Confirma exclusão?')">Excluir</a>
            </div>
        <?php endforeach; ?>
    </div>
<?php endforeach; ?>
</div>
</body>
</html>
