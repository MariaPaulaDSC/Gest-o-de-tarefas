<?php
declare(strict_types=1);

require_once __DIR__ . '/../config/Database.php';

/**
 * Classe-base: centraliza o acesso ao PDO.
 * Projeto e Tarefa herdam esta responsabilidade de infraestrutura.
 */
abstract class Model
{
    protected PDO $db;

    public function __construct()
    {
        $this->db = Database::getConnection();
    }
}
