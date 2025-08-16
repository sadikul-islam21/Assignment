<?php
// SQLite configuration for demo purposes
// This allows the system to work without MySQL setup

define('DB_TYPE', 'sqlite');
define('DB_PATH', __DIR__ . '/student_db.sqlite');

// Create SQLite database connection
function getDatabaseConnection()
{
    try {
        $pdo = new PDO('sqlite:' . DB_PATH);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        // Create table if it doesn't exist
        $sql = "CREATE TABLE IF NOT EXISTS students (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            name TEXT NOT NULL,
            student_id TEXT UNIQUE NOT NULL,
            department TEXT NOT NULL,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP
        )";
        
        $pdo->exec($sql);
        return $pdo;
    } catch (Exception $e) {
        throw new Exception("Database connection error: " . $e->getMessage());
    }
}

// Test database connection
function testDatabaseConnection()
{
    try {
        $pdo = getDatabaseConnection();
        return true;
    } catch (Exception $e) {
        return false;
    }
}

// Insert sample data for demo
function insertSampleData()
{
    try {
        $pdo = getDatabaseConnection();
        
        // Check if we already have data
        $stmt = $pdo->query("SELECT COUNT(*) FROM students");
        $count = $stmt->fetchColumn();
        
        if ($count == 0) {
            $stmt = $pdo->prepare("INSERT INTO students (name, student_id, department) VALUES (?, ?, ?)");
            $stmt->execute(['Welcome User', '123456789', 'Computer Science']);
            $stmt->execute(['Demo Student', '987654321', 'Engineering']);
            return true;
        }
        return false;
    } catch (Exception $e) {
        return false;
    }
}
?>