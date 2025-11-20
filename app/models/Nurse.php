<?php
require_once APP_ROOT . '/app/core/Database.php';

class Nurse {
    public static function findByEmail(string $email): ?array {
        $pdo = Database::getInstance();
        $stmt = $pdo->prepare('SELECT * FROM nurses WHERE email = ? LIMIT 1');
        $stmt->execute([$email]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ?: null;
    }

    public static function findById(int $id): ?array {
        $pdo = Database::getInstance();
        $stmt = $pdo->prepare('SELECT * FROM nurses WHERE id = ? LIMIT 1');
        $stmt->execute([$id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ?: null;
    }

    public static function getAll(): array {
        $pdo = Database::getInstance();
        $stmt = $pdo->query('SELECT * FROM nurses ORDER BY name ASC');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function create(string $name, string $email, string $password, ?string $department = null, ?string $phone = null): int {
        $pdo = Database::getInstance();
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare('INSERT INTO nurses (name, email, password_hash, department, phone, created_at) VALUES (?, ?, ?, ?, ?, NOW())');
        $stmt->execute([$name, $email, $hash, $department, $phone]);
        return (int)$pdo->lastInsertId();
    }

    public static function update(int $id, array $data): bool {
        $pdo = Database::getInstance();
        $fields = [];
        $values = [];
        
        foreach (['name', 'email', 'department', 'phone'] as $field) {
            if (isset($data[$field])) {
                $fields[] = "$field = ?";
                $values[] = $data[$field];
            }
        }
        
        if (empty($fields)) return false;
        
        $values[] = $id;
        $sql = 'UPDATE nurses SET ' . implode(', ', $fields) . ' WHERE id = ?';
        $stmt = $pdo->prepare($sql);
        return $stmt->execute($values);
    }
}
