<?php

declare(strict_types=1);

namespace App;

use PDO;
use PDOException;

class Contact
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
        $this->initTable();
    }

    private function initTable(): void
    {
        $this->pdo->exec('
            CREATE TABLE IF NOT EXISTS contacts (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                name TEXT NOT NULL,
                email TEXT NOT NULL,
                message TEXT NOT NULL,
                created_at TEXT NOT NULL
            )
        ');
    }

    public function all(): array
    {
        $stmt = $this->pdo->query('SELECT * FROM contacts ORDER BY id DESC');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function save(string $name, string $email, string $message): int
    {
        $stmt = $this->pdo->prepare(
            'INSERT INTO contacts (name, email, message, created_at) VALUES (:name, :email, :message, :created)'
        );
        $stmt->execute([
            ':name' => $name,
            ':email' => $email,
            ':message' => $message,
            ':created' => date('c'),
        ]);
        return (int) $this->pdo->lastInsertId();
    }
}
