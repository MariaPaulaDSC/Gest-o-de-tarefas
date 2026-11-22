<?php
declare(strict_types=1);
require_once __DIR__ . '/../classes/Tarefa.php';
$id = filter_var($_POST['id'] ?? null, FILTER_VALIDATE_INT);
$status = $_POST['status'] ?? '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $id && in_array($status, ['pendente', 'andamento', 'concluida'], true)) {
    (new Tarefa())->atualizarStatus($id, $status);
}
header('Location: ../pages/tarefas.php?msg=atualizado');
exit;
