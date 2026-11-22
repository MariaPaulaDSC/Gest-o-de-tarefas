<?php
declare(strict_types=1);
require_once __DIR__ . '/classes/Projeto.php';
require_once __DIR__ . '/classes/Tarefa.php';

$projetoModel = new Projeto();
$tarefaModel = new Tarefa();
$projetos = $projetoModel->listar();
$tarefasRecentes = array_slice($tarefaModel->listar(), 0, 6);
$totalTarefas = $tarefaModel->contar();
$pendentes = $tarefaModel->contar('pendente');
$andamento = $tarefaModel->contar('andamento');
$concluidas = $tarefaModel->contar('concluida');
function e(?string $valor): string {
    return htmlspecialchars($valor ?? '', ENT_QUOTES, 'UTF-8');
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TaskManager | Painel</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<div class="layout">
    <aside class="sidebar">
        <a class="brand" href="index.php"><span class="brand-icon">✓</span> TaskManager</a>
        <p class="menu-label">MENU PRINCIPAL</p>
        <a class="nav-link active" href="index.php">▦ <span>Dashboard</span></a>
        <a class="nav-link" href="pages/projetos.php">▣ <span>Projetos</span></a>
        <a class="nav-link" href="pages/tarefas.php">☷ <span>Tarefas</span></a>
        <div class="sidebar-bottom"><span class="avatar">TM</span><div><strong>Meu espaço</strong><small>Organização pessoal</small></div></div>
    </aside>

    <main class="main-content">
        <header class="topbar"><div><span class="eyebrow">VISÃO GERAL</span><h1>Dashboard</h1></div><a class="button button-primary" href="pages/tarefas.php">＋ Nova tarefa</a></header>
        <section class="welcome">
            <div><span class="eyebrow light">SEU ESPAÇO DE ORGANIZAÇÃO</span><h2>Organize suas ideias.<br>Conclua seus objetivos.</h2><p>Acompanhe seus projetos e mantenha cada tarefa no prazo.</p></div>
            <div class="welcome-symbol">✓</div>
        </section>

        <section class="stats-grid">
            <article class="stat-card"><div class="stat-top"><span>Total de tarefas</span><span class="stat-icon purple">☷</span></div><strong><?= $totalTarefas ?></strong><small>Todas as atividades cadastradas</small></article>
            <article class="stat-card"><div class="stat-top"><span>Pendentes</span><span class="stat-icon orange">◷</span></div><strong><?= $pendentes ?></strong><small>Aguardando início</small></article>
            <article class="stat-card"><div class="stat-top"><span>Em andamento</span><span class="stat-icon blue">↗</span></div><strong><?= $andamento ?></strong><small>Atividades em execução</small></article>
            <article class="stat-card"><div class="stat-top"><span>Concluídas</span><span class="stat-icon green">✓</span></div><strong><?= $concluidas ?></strong><small>Atividades finalizadas</small></article>
        </section>

        <section class="content-grid">
            <div class="panel">
                <div class="panel-heading"><div><h3>Projetos</h3><p>Acompanhe seus projetos cadastrados</p></div><a class="text-link" href="pages/projetos.php">Ver todos →</a></div>
                <?php if (!$projetos): ?>
                    <div class="empty-state"><span>▣</span><strong>Nenhum projeto por aqui</strong><p>Crie seu primeiro projeto para começar.</p><a class="button button-primary" href="pages/projetos.php">Criar projeto</a></div>
                <?php else: ?>
                    <div class="project-list">
                    <?php foreach (array_slice($projetos, 0, 4) as $projeto): 
                        $total = (int) $projeto['total_tarefas'];
                        $done = (int) $projeto['tarefas_concluidas'];
                        $percent = $total > 0 ? (int) round(($done / $total) * 100) : 0;
                    ?>
                        <div class="project-item"><div class="project-mark">▣</div><div class="project-info"><strong><?= e($projeto['nome']) ?></strong><small><?= $done ?> de <?= $total ?> tarefas concluídas</small><div class="progress"><span style="width: <?= $percent ?>%"></span></div></div><b class="percent"><?= $percent ?>%</b></div>
                    <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
            <div class="panel">
                <div class="panel-heading"><div><h3>Atalhos</h3><p>Acesse rapidamente</p></div></div>
                <a class="shortcut" href="pages/projetos.php"><span class="shortcut-icon purple">▣</span><span><strong>Gerenciar projetos</strong><small>Crie e organize projetos</small></span><b>→</b></a>
                <a class="shortcut" href="pages/tarefas.php"><span class="shortcut-icon blue">☷</span><span><strong>Gerenciar tarefas</strong><small>Defina prazos e prioridades</small></span><b>→</b></a>
            </div>
        </section>

        <section class="panel table-panel">
            <div class="panel-heading"><div><h3>Tarefas recentes</h3><p>As últimas atividades cadastradas</p></div><a class="text-link" href="pages/tarefas.php">Ver todas →</a></div>
            <?php if (!$tarefasRecentes): ?><div class="empty-inline">Ainda não existem tarefas cadastradas.</div><?php else: ?>
            <div class="table-wrap"><table><thead><tr><th>TAREFA</th><th>PROJETO</th><th>PRAZO</th><th>PRIORIDADE</th><th>STATUS</th></tr></thead><tbody>
            <?php foreach ($tarefasRecentes as $tarefa): ?>
                <tr><td><strong><?= e($tarefa['titulo']) ?></strong></td><td><?= e($tarefa['projeto_nome']) ?></td><td><?= $tarefa['prazo'] ? date('d/m/Y', strtotime($tarefa['prazo'])) : '—' ?></td><td><span class="priority <?= e($tarefa['prioridade']) ?>"><?= ucfirst(e($tarefa['prioridade'])) ?></span></td><td><span class="status <?= e($tarefa['status']) ?>"><?= $tarefa['status'] === 'andamento' ? 'Em andamento' : ucfirst(e($tarefa['status'])) ?></span></td></tr>
            <?php endforeach; ?></tbody></table></div><?php endif; ?>
        </section>
        <footer class="footer">TaskManager · Sistema de Gestão de Tarefas</footer>
    </main>
</div>
</body>
</html>
