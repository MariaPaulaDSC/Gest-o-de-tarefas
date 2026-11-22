<?php
declare(strict_types=1);
require_once __DIR__ . '/../classes/Projeto.php';
$projetoModel = new Projeto();
$projetos = $projetoModel->listar();
function e(?string $valor): string { return htmlspecialchars($valor ?? '', ENT_QUOTES, 'UTF-8'); }
$mensagem = $_GET['msg'] ?? '';
?>
<!DOCTYPE html><html lang="pt-BR"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0"><title>Projetos | TaskManager</title><link rel="stylesheet" href="../css/style.css"></head><body>
<div class="layout"><aside class="sidebar"><a class="brand" href="../index.php"><span class="brand-icon">✓</span> TaskManager</a><p class="menu-label">MENU PRINCIPAL</p><a class="nav-link" href="../index.php">▦ <span>Dashboard</span></a><a class="nav-link active" href="projetos.php">▣ <span>Projetos</span></a><a class="nav-link" href="tarefas.php">☷ <span>Tarefas</span></a><div class="sidebar-bottom"><span class="avatar">TM</span><div><strong>Meu espaço</strong><small>Organização pessoal</small></div></div></aside>
<main class="main-content"><header class="topbar"><div><span class="eyebrow">ORGANIZAÇÃO</span><h1>Projetos</h1></div><a class="button button-primary" href="#novo-projeto">＋ Novo projeto</a></header>
<?php if ($mensagem === 'sucesso'): ?><div class="alert success">Projeto salvo com sucesso!</div><?php elseif ($mensagem === 'excluido'): ?><div class="alert success">Projeto excluído com sucesso!</div><?php endif; ?>
<section class="panel form-panel" id="novo-projeto"><div class="panel-heading"><div><h3>Cadastrar projeto</h3><p>Preencha os dados para criar um novo projeto.</p></div></div><form action="../actions/salvar_projeto.php" method="POST" class="form-grid"><label>Nome do projeto<input type="text" name="nome" maxlength="120" required placeholder="Ex.: Desenvolvimento do site"></label><label class="full">Descrição<textarea name="descricao" rows="3" placeholder="Descreva o objetivo deste projeto..."></textarea></label><div class="full"><button class="button button-primary" type="submit">Salvar projeto</button></div></form></section>
<section class="panel table-panel"><div class="panel-heading"><div><h3>Todos os projetos</h3><p><?= count($projetos) ?> projeto(s) cadastrado(s)</p></div></div>
<?php if (!$projetos): ?><div class="empty-inline">Nenhum projeto cadastrado. Use o formulário acima para começar.</div><?php else: ?><div class="table-wrap"><table><thead><tr><th>NOME</th><th>DESCRIÇÃO</th><th>TAREFAS</th><th>CONCLUÍDAS</th><th>AÇÃO</th></tr></thead><tbody>
<?php foreach ($projetos as $p): ?><tr><td><strong><?= e($p['nome']) ?></strong></td><td><?= e($p['descricao']) ?: '—' ?></td><td><?= (int)$p['total_tarefas'] ?></td><td><?= (int)$p['tarefas_concluidas'] ?></td><td><form action="../actions/excluir_projeto.php" method="POST" onsubmit="return confirm('Tem certeza? As tarefas deste projeto também serão excluídas.');"><input type="hidden" name="id" value="<?= (int)$p['id'] ?>"><button class="button button-danger button-small" type="submit">Excluir</button></form></td></tr><?php endforeach; ?>
</tbody></table></div><?php endif; ?></section><footer class="footer">TaskManager · Sistema de Gestão de Tarefas</footer></main></div></body></html>
