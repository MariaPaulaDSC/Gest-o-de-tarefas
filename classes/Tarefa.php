<?php
declare(strict_types=1);

require_once __DIR__ . '/Model.php';

class Tarefa extends Model
{
    public function listar(?int $projetoId = null): array
    {
        $sql = "SELECT t.*, p.nome AS projeto_nome
                FROM tarefas t
                INNER JOIN projetos p ON p.id = t.projeto_id";
        if ($projetoId !== null) {
            $sql .= " WHERE t.projeto_id = :projeto_id";
        }
        $sql .= " ORDER BY t.prazo IS NULL, t.prazo ASC, t.criado_em DESC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute($projetoId !== null ? ['projeto_id' => $projetoId] : []);
        return $stmt->fetchAll();
    }

    public function criar(int $projetoId, string $titulo, string $descricao, ?string $prazo, string $prioridade): bool
    {
        $stmt = $this->db->prepare(
            "INSERT INTO tarefas (projeto_id, titulo, descricao, prazo, prioridade)
             VALUES (:projeto_id, :titulo, :descricao, :prazo, :prioridade)"
        );
        return $stmt->execute([
            'projeto_id' => $projetoId,
            'titulo' => $titulo,
            'descricao' => $descricao,
            'prazo' => $prazo ?: null,
            'prioridade' => $prioridade,
        ]);
    }

    public function atualizarStatus(int $id, string $status): bool
    {
        $stmt = $this->db->prepare("UPDATE tarefas SET status = :status WHERE id = :id");
        return $stmt->execute(['id' => $id, 'status' => $status]);
    }

    public function excluir(int $id): bool
    {
        $stmt = $this->db->prepare("DELETE FROM tarefas WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }

    public function contar(?string $status = null): int
    {
        if ($status === null) {
            return (int) $this->db->query("SELECT COUNT(*) FROM tarefas")->fetchColumn();
        }
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM tarefas WHERE status = :status");
        $stmt->execute(['status' => $status]);
        return (int) $stmt->fetchColumn();
    }
}
