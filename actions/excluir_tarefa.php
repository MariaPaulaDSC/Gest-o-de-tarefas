<?php
declare(strict_types=1);
require_once __DIR__ . '/../classes/Tarefa.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && filter_var($_POST['id'] ?? null, FILTER_VALIDATE_INT)) {
    (new Tarefa())->excluir((int) $_POST['id']);
}
header('Location: ../pages/tarefas.php?msg=excluido');
exit;
