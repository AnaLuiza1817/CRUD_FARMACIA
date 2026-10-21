<?php
require __DIR__ . '/../Infra/conexao.php';
$id = (int)($_GET['id'] ?? 0);
$comando = $conexao->prepare("DELETE FROM pedido WHERE id = ?");
$comando->execute([$id]);
header("Location: ../index.php");
exit;
?>