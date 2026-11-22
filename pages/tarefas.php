<?php
declare(strict_types=1);
require_once __DIR__ . '/../classes/Projeto.php';
require_once __DIR__ . '/../classes/Tarefa.php';
$projetoModel = new Projeto();
$tarefaModel = new Tarefa();
$projetos = $projetoModel->listar();
$tarefas = $tarefaModel->listar();
function e(?string $valor): string { return htmlspecialchars($valor ?? '', ENT_QUOTES, 'UTF-8'); }
$mensagem = $_GET['msg'] ?? '';
?>
<!DOCTYPE html><html lang="pt-BR"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0"><title>Tarefas | TaskManager</title><link rel="stylesheet" href="../css/style.css"></head><body>
<div class="layout"><aside class="sidebar"><a class="brand" href="../index.php"><span class="brand-icon">✓</span> TaskManager</a><p class="menu-label">MENU PRINCIPAL</p><a class="nav-link" href="../index.php">▦ <span>Dashboard</span></a><a class="nav-link" href="projetos.php">▣ <span>Projetos</span></a><a class="nav-link active" href="tarefas.php">☷ <span>Tarefas</span></a><div class="sidebar-bottom"><span class="avatar">TM</span><div><strong>Meu espaço</strong><small>Organização pessoal</small></div></div></aside>
<main class="main-content"><header class="topbar"><div><span class="eyebrow">ACOMPANHAMENTO</span><h1>Tarefas</h1></div><a class="button button-primary" href="#nova-tarefa">＋ Nova tarefa</a></header>
<?php if ($mensagem === 'sucesso'): ?><div class="alert success">Tarefa cadastrada com sucesso!</div><?php elseif ($mensagem === 'atualizado'): ?><div class="alert success">Status atualizado!</div><?php elseif ($mensagem === 'excluido'): ?><div class="alert success">Tarefa excluída!</div><?php endif; ?>
<section class="panel form-panel" id="nova-tarefa"><div class="panel-heading"><div><h3>Cadastrar tarefa</h3><p>Associe a tarefa a um projeto e defina prazo e prioridade.</p></div></div>
<?php if (!$projetos): ?><div class="empty-inline">Antes de cadastrar tarefas, <a class="text-link" href="projetos.php">crie um projeto</a>.</div><?php else: ?>
<form action="../actions/salvar_tarefa.php" method="POST" class="form-grid">
<label class="full">Título da tarefa<input type="text" name="titulo" maxlength="160" required placeholder="Ex.: Criar a página inicial"></label>
<label>Projeto<select name="projeto_id" required><option value="">Selecione um projeto</option><?php foreach ($projetos as $p): ?><option value="<?= (int)$p['id'] ?>"><?= e($p['nome']) ?></option><?php endforeach; ?></select></label>
<label>Prazo<input type="date" name="prazo"></label>
<label>Prioridade<select name="prioridade"><option value="media">Média</option><option value="baixa">Baixa</option><option value="alta">Alta</option></select></label>
<label class="full">Descrição<textarea name="descricao" rows="2" placeholder="Detalhes da atividade..."></textarea></label>
<div class="full"><button class="button button-primary" type="submit">Salvar tarefa</button></div>
</form><?php endif; ?></section>
<section class="panel table-panel"><div class="panel-heading"><div><h3>Lista de tarefas</h3><p>Atualize o andamento das suas atividades.</p></div></div>
<?php if (!$tarefas): ?><div class="empty-inline">Nenhuma tarefa cadastrada ainda.</div><?php else: ?><div class="table-wrap"><table><thead><tr><th>TAREFA</th><th>PROJETO</th><th>PRAZO</th><th>PRIORIDADE</th><th>STATUS</th><th>AÇÃO</th></tr></thead><tbody>
<?php foreach ($tarefas as $t): ?><tr><td><strong><?= e($t['titulo']) ?></strong><?php if ($t['descricao']): ?><small class="table-subtitle"><?= e($t['descricao']) ?></small><?php endif; ?></td><td><?= e($t['projeto_nome']) ?></td><td><?= $t['prazo'] ? date('d/m/Y', strtotime($t['prazo'])) : '—' ?></td><td><span class="priority <?= e($t['prioridade']) ?>"><?= ucfirst(e($t['prioridade'])) ?></span></td><td><form action="../actions/atualizar_status.php" method="POST" class="inline-form"><input type="hidden" name="id" value="<?= (int)$t['id'] ?>"><select name="status" aria-label="Status" onchange="this.form.submit()"><option value="pendente" <?= $t['status']==='pendente'?'selected':'' ?>>Pendente</option><option value="andamento" <?= $t['status']==='andamento'?'selected':'' ?>>Em andamento</option><option value="concluida" <?= $t['status']==='concluida'?'selected':'' ?>>Concluída</option></select></form></td><td><form action="../actions/excluir_tarefa.php" method="POST" onsubmit="return confirm('Deseja excluir esta tarefa?');"><input type="hidden" name="id" value="<?= (int)$t['id'] ?>"><button class="button button-danger button-small" type="submit">Excluir</button></form></td></tr><?php endforeach; ?>
</tbody></table></div><?php endif; ?></section><footer class="footer">TaskManager · Sistema de Gestão de Tarefas</footer></main></div></body></html>
