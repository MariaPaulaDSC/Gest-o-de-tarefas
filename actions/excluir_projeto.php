<?php
declare(strict_types=1);
require_once __DIR__ . '/../classes/Projeto.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && filter_var($_POST['id'] ?? null, FILTER_VALIDATE_INT)) {
    (new Projeto())->excluir((int) $_POST['id']);
}
header('Location: ../pages/projetos.php?msg=excluido');
exit;
