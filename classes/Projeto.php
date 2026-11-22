<?php
declare(strict_types=1);

require_once __DIR__ . '/Model.php';

class Projeto extends Model
{
    public function listar(): array
    {
        $sql = "SELECT p.*,
                       COUNT(t.id) AS total_tarefas,
                       SUM(CASE WHEN t.status = 'concluida' THEN 1 ELSE 0 END) AS tarefas_concluidas
                FROM projetos p
                LEFT JOIN tarefas t ON t.projeto_id = p.id
                GROUP BY p.id
                ORDER BY p.criado_em DESC";
        return $this->db->query($sql)->fetchAll();
    }

    public function buscarPorId(int $id): ?array
    {
        $stmt = $this->db->prepare("SELECT * FROM projetos WHERE id = :id");
        $stmt->execute(['id' => $id]);
        $projeto = $stmt->fetch();
        return $projeto ?: null;
    }

    public function criar(string $nome, string $descricao): bool
    {
        $stmt = $this->db->prepare(
            "INSERT INTO projetos (nome, descricao) VALUES (:nome, :descricao)"
        );
        return $stmt->execute(['nome' => $nome, 'descricao' => $descricao]);
    }

    public function atualizar(int $id, string $nome, string $descricao): bool
    {
        $stmt = $this->db->prepare(
            "UPDATE projetos SET nome = :nome, descricao = :descricao WHERE id = :id"
        );
        return $stmt->execute(['id' => $id, 'nome' => $nome, 'descricao' => $descricao]);
    }

    public function excluir(int $id): bool
    {
        $stmt = $this->db->prepare("DELETE FROM projetos WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }

    public function contar(): int
    {
        return (int) $this->db->query("SELECT COUNT(*) FROM projetos")->fetchColumn();
    }
}
