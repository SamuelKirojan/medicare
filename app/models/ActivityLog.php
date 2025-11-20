<?php
require_once APP_ROOT . '/app/core/Database.php';

class ActivityLog {
    public static function create(string $userType, int $userId, string $action, ?string $description = null, ?string $entityType = null, ?int $entityId = null): int {
        $pdo = Database::getInstance();
        $stmt = $pdo->prepare('INSERT INTO activity_logs (user_type, user_id, action, description, entity_type, entity_id, created_at) VALUES (?, ?, ?, ?, ?, ?, NOW())');
        $stmt->execute([$userType, $userId, $action, $description, $entityType, $entityId]);
        return (int)$pdo->lastInsertId();
    }

    public static function getRecent(int $limit = 10): array {
        $pdo = Database::getInstance();
        $stmt = $pdo->prepare('
            SELECT al.*, 
                CASE 
                    WHEN al.user_type = "doctor" THEN d.name 
                    WHEN al.user_type = "nurse" THEN n.name 
                END as user_name
            FROM activity_logs al
            LEFT JOIN doctors d ON al.user_type = "doctor" AND al.user_id = d.id
            LEFT JOIN nurses n ON al.user_type = "nurse" AND al.user_id = n.id
            ORDER BY al.created_at DESC 
            LIMIT ?
        ');
        $stmt->execute([$limit]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getByEntity(string $entityType, int $entityId): array {
        $pdo = Database::getInstance();
        $stmt = $pdo->prepare('
            SELECT al.*, 
                CASE 
                    WHEN al.user_type = "doctor" THEN d.name 
                    WHEN al.user_type = "nurse" THEN n.name 
                END as user_name
            FROM activity_logs al
            LEFT JOIN doctors d ON al.user_type = "doctor" AND al.user_id = d.id
            LEFT JOIN nurses n ON al.user_type = "nurse" AND al.user_id = n.id
            WHERE al.entity_type = ? AND al.entity_id = ?
            ORDER BY al.created_at DESC
        ');
        $stmt->execute([$entityType, $entityId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getByUser(string $userType, int $userId, int $limit = 50): array {
        $pdo = Database::getInstance();
        $stmt = $pdo->prepare('
            SELECT * FROM activity_logs 
            WHERE user_type = ? AND user_id = ?
            ORDER BY created_at DESC 
            LIMIT ?
        ');
        $stmt->execute([$userType, $userId, $limit]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
