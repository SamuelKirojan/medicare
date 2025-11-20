<?php
require_once APP_ROOT . '/app/core/Database.php';

class Medication {
    public static function getAll(): array {
        $pdo = Database::getInstance();
        $stmt = $pdo->query('
            SELECT m.*, p.name as patient_name, n.name as created_by_name, nu.name as updated_by_name
            FROM medications m 
            LEFT JOIN patients p ON m.patient_id = p.id 
            LEFT JOIN nurses n ON m.created_by = n.id
            LEFT JOIN nurses nu ON m.updated_by = nu.id
            ORDER BY m.created_at DESC
        ');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function findById(int $id): ?array {
        $pdo = Database::getInstance();
        $stmt = $pdo->prepare('
            SELECT m.*, p.name as patient_name, n.name as created_by_name, nu.name as updated_by_name
            FROM medications m 
            LEFT JOIN patients p ON m.patient_id = p.id 
            LEFT JOIN nurses n ON m.created_by = n.id
            LEFT JOIN nurses nu ON m.updated_by = nu.id
            WHERE m.id = ? LIMIT 1
        ');
        $stmt->execute([$id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ?: null;
    }

    public static function getByPatientId(int $patientId): array {
        $pdo = Database::getInstance();
        $stmt = $pdo->prepare('
            SELECT m.*, n.name as created_by_name, nu.name as updated_by_name
            FROM medications m 
            LEFT JOIN nurses n ON m.created_by = n.id
            LEFT JOIN nurses nu ON m.updated_by = nu.id
            WHERE m.patient_id = ? 
            ORDER BY m.status ASC, m.start_date DESC
        ');
        $stmt->execute([$patientId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getActiveByPatientId(int $patientId): array {
        $pdo = Database::getInstance();
        $stmt = $pdo->prepare('
            SELECT m.*, n.name as created_by_name
            FROM medications m 
            LEFT JOIN nurses n ON m.created_by = n.id
            WHERE m.patient_id = ? AND m.status = "Active"
            ORDER BY m.start_date DESC
        ');
        $stmt->execute([$patientId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function create(array $data): int {
        $pdo = Database::getInstance();
        $stmt = $pdo->prepare('INSERT INTO medications (patient_id, name, dosage, frequency, route, start_date, end_date, status, instructions, created_by, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())');
        $stmt->execute([
            $data['patient_id'],
            $data['name'],
            $data['dosage'],
            $data['frequency'],
            $data['route'] ?? 'Oral',
            $data['start_date'],
            $data['end_date'] ?? null,
            $data['status'] ?? 'Active',
            $data['instructions'] ?? null,
            $data['created_by'] ?? null
        ]);
        return (int)$pdo->lastInsertId();
    }

    public static function update(int $id, array $data): bool {
        $pdo = Database::getInstance();
        $fields = [];
        $values = [];
        
        $allowedFields = ['name', 'dosage', 'frequency', 'route', 'start_date', 'end_date', 'status', 'instructions', 'updated_by'];
        
        foreach ($allowedFields as $field) {
            if (array_key_exists($field, $data)) {
                $fields[] = "$field = ?";
                $values[] = $data[$field];
            }
        }
        
        if (empty($fields)) return false;
        
        $values[] = $id;
        $sql = 'UPDATE medications SET ' . implode(', ', $fields) . ' WHERE id = ?';
        $stmt = $pdo->prepare($sql);
        return $stmt->execute($values);
    }

    public static function delete(int $id): bool {
        $pdo = Database::getInstance();
        $stmt = $pdo->prepare('DELETE FROM medications WHERE id = ?');
        return $stmt->execute([$id]);
    }

    public static function countActive(): int {
        $pdo = Database::getInstance();
        $stmt = $pdo->query('SELECT COUNT(*) FROM medications WHERE status = "Active"');
        return (int)$stmt->fetchColumn();
    }

    public static function getRecent(int $limit = 5): array {
        $pdo = Database::getInstance();
        $stmt = $pdo->prepare('
            SELECT m.*, p.name as patient_name, n.name as created_by_name
            FROM medications m 
            LEFT JOIN patients p ON m.patient_id = p.id 
            LEFT JOIN nurses n ON m.created_by = n.id
            ORDER BY m.updated_at DESC 
            LIMIT ?
        ');
        $stmt->execute([$limit]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getHistory(int $patientId): array {
        $pdo = Database::getInstance();
        $stmt = $pdo->prepare('
            SELECT m.*, n.name as created_by_name, nu.name as updated_by_name
            FROM medications m 
            LEFT JOIN nurses n ON m.created_by = n.id
            LEFT JOIN nurses nu ON m.updated_by = nu.id
            WHERE m.patient_id = ? 
            ORDER BY m.created_at DESC
        ');
        $stmt->execute([$patientId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
