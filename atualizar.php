<?php
require __DIR__ . '/../Infra/conexao.php';
$id     = (int)($_POST['id'] ?? 0);
$status = $_POST['status'] ?? '';

if (in_array($status, ['solicitado','em separação','recebido'])) {
    $comando = $conexao->prepare("UPDATE pedido SET status = ? WHERE id = ?");
    $comando->execute([$status, $id]);
}
header("Location: ../index.php");
exit;
?>
