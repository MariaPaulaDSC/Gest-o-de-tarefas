<?php
declare(strict_types=1);
require_once __DIR__ . '/../classes/Projeto.php';
if ($_SERVER['REQUEST_METHOD'] !== 'POST') { header('Location: ../pages/projetos.php'); exit; }
$nome = trim($_POST['nome'] ?? '');
$descricao = trim($_POST['descricao'] ?? '');
if ($nome === '') { header('Location: ../pages/projetos.php?msg=erro'); exit; }
try {
    (new Projeto())->criar($nome, $descricao);
    header('Location: ../pages/projetos.php?msg=sucesso');
} catch (PDOException $e) {
    error_log($e->getMessage());
    header('Location: ../pages/projetos.php?msg=erro');
}
exit;
