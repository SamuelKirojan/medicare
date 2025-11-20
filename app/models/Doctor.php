<?php
require_once APP_ROOT . '/app/core/Database.php';

class Doctor {
    public static function findByEmail(string $email): ?array {
        $pdo = Database::getInstance();
        $stmt = $pdo->prepare('SELECT * FROM doctors WHERE email = ? LIMIT 1');
        $stmt->execute([$email]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ?: null;
    }

    public static function findById(int $id): ?array {
        $pdo = Database::getInstance();
        $stmt = $pdo->prepare('SELECT * FROM doctors WHERE id = ? LIMIT 1');
        $stmt->execute([$id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ?: null;
    }

    public static function getAll(): array {
        $pdo = Database::getInstance();
        $stmt = $pdo->query('SELECT * FROM doctors ORDER BY name ASC');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function create(string $name, string $email, string $password, ?string $specialty = null, ?string $phone = null): int {
        $pdo = Database::getInstance();
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare('INSERT INTO doctors (name, email, password_hash, specialty, phone, created_at) VALUES (?, ?, ?, ?, ?, NOW())');
        $stmt->execute([$name, $email, $hash, $specialty, $phone]);
        return (int)$pdo->lastInsertId();
    }

    public static function update(int $id, array $data): bool {
        $pdo = Database::getInstance();
        $fields = [];
        $values = [];
        
        foreach (['name', 'email', 'specialty', 'phone'] as $field) {
            if (isset($data[$field])) {
                $fields[] = "$field = ?";
                $values[] = $data[$field];
            }
        }
        
        if (empty($fields)) return false;
        
        $values[] = $id;
        $sql = 'UPDATE doctors SET ' . implode(', ', $fields) . ' WHERE id = ?';
        $stmt = $pdo->prepare($sql);
        return $stmt->execute($values);
    }
}
