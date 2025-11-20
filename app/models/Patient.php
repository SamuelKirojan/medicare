<?php
require_once APP_ROOT . '/app/core/Database.php';

class Patient {
    public static function getAll(): array {
        $pdo = Database::getInstance();
        $stmt = $pdo->query('SELECT p.*, n.name as created_by_name FROM patients p LEFT JOIN nurses n ON p.created_by = n.id ORDER BY p.updated_at DESC');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function findById(int $id): ?array {
        $pdo = Database::getInstance();
        $stmt = $pdo->prepare('SELECT p.*, n.name as created_by_name FROM patients p LEFT JOIN nurses n ON p.created_by = n.id WHERE p.id = ? LIMIT 1');
        $stmt->execute([$id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ?: null;
    }

    public static function search(string $query): array {
        $pdo = Database::getInstance();
        $search = '%' . $query . '%';
        $stmt = $pdo->prepare('SELECT p.*, n.name as created_by_name FROM patients p LEFT JOIN nurses n ON p.created_by = n.id WHERE p.name LIKE ? OR p.phone LIKE ? OR p.allergies LIKE ? ORDER BY p.name ASC');
        $stmt->execute([$search, $search, $search]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function create(array $data): int {
        $pdo = Database::getInstance();
        $stmt = $pdo->prepare('INSERT INTO patients (name, age, gender, phone, address, allergies, blood_type, emergency_contact, emergency_phone, notes, created_by, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())');
        $stmt->execute([
            $data['name'],
            $data['age'],
            $data['gender'] ?? 'Male',
            $data['phone'] ?? null,
            $data['address'] ?? null,
            $data['allergies'] ?? null,
            $data['blood_type'] ?? null,
            $data['emergency_contact'] ?? null,
            $data['emergency_phone'] ?? null,
            $data['notes'] ?? null,
            $data['created_by'] ?? null
        ]);
        return (int)$pdo->lastInsertId();
    }

    public static function update(int $id, array $data): bool {
        $pdo = Database::getInstance();
        $fields = [];
        $values = [];
        
        $allowedFields = ['name', 'age', 'gender', 'phone', 'address', 'allergies', 'blood_type', 'emergency_contact', 'emergency_phone', 'notes'];
        
        foreach ($allowedFields as $field) {
            if (array_key_exists($field, $data)) {
                $fields[] = "$field = ?";
                $values[] = $data[$field];
            }
        }
        
        if (empty($fields)) return false;
        
        $values[] = $id;
        $sql = 'UPDATE patients SET ' . implode(', ', $fields) . ' WHERE id = ?';
        $stmt = $pdo->prepare($sql);
        return $stmt->execute($values);
    }

    public static function delete(int $id): bool {
        $pdo = Database::getInstance();
        $stmt = $pdo->prepare('DELETE FROM patients WHERE id = ?');
        return $stmt->execute([$id]);
    }

    public static function count(): int {
        $pdo = Database::getInstance();
        $stmt = $pdo->query('SELECT COUNT(*) FROM patients');
        return (int)$stmt->fetchColumn();
    }

    public static function getRecent(int $limit = 5): array {
        $pdo = Database::getInstance();
        $stmt = $pdo->prepare('SELECT p.*, n.name as created_by_name FROM patients p LEFT JOIN nurses n ON p.created_by = n.id ORDER BY p.updated_at DESC LIMIT ?');
        $stmt->execute([$limit]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getPatientsNeedingAttention(): array {
        $pdo = Database::getInstance();
        // Get patients with medications ending soon or with specific notes
        $stmt = $pdo->query("
            SELECT DISTINCT p.*, n.name as created_by_name 
            FROM patients p 
            LEFT JOIN nurses n ON p.created_by = n.id
            LEFT JOIN medications m ON p.id = m.patient_id
            WHERE m.end_date IS NOT NULL 
            AND m.end_date <= DATE_ADD(CURDATE(), INTERVAL 7 DAY)
            AND m.status = 'Active'
            ORDER BY m.end_date ASC
            LIMIT 10
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
