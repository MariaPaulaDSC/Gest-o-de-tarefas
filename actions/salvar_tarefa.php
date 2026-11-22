<?php
declare(strict_types=1);
require_once __DIR__ . '/../classes/Tarefa.php';
if ($_SERVER['REQUEST_METHOD'] !== 'POST') { header('Location: ../pages/tarefas.php'); exit; }
$projetoId = filter_var($_POST['projeto_id'] ?? null, FILTER_VALIDATE_INT);
$titulo = trim($_POST['titulo'] ?? '');
$descricao = trim($_POST['descricao'] ?? '');
$prazo = trim($_POST['prazo'] ?? '');
$prioridade = $_POST['prioridade'] ?? 'media';
if (!$projetoId || $titulo === '' || !in_array($prioridade, ['baixa', 'media', 'alta'], true)) {
    header('Location: ../pages/tarefas.php?msg=erro'); exit;
}
if ($prazo !== '' && !DateTime::createFromFormat('Y-m-d', $prazo)) {
    header('Location: ../pages/tarefas.php?msg=erro'); exit;
}
try {
    (new Tarefa())->criar($projetoId, $titulo, $descricao, $prazo ?: null, $prioridade);
    header('Location: ../pages/tarefas.php?msg=sucesso');
} catch (PDOException $e) {
    error_log($e->getMessage());
    header('Location: ../pages/tarefas.php?msg=erro');
}
exit;
