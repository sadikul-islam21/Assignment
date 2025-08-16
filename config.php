<?php
// Database configuration file
// Copy this file to config.php and update the values according to your setup

define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');        // Change this to your MySQL username
define('DB_PASSWORD', '');            // Change this to your MySQL password
define('DB_NAME', 'student_db');

// Try to connect to MySQL database
function getDatabaseConnection()
{
	try {
		$conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

		// Check connection
		if ($conn->connect_error) {
			throw new Exception("Connection failed: " . $conn->connect_error);
		}

		return $conn;
	} catch (Exception $e) {
		throw new Exception("Database connection error: " . $e->getMessage());
	}
}

// Test database connection
function testDatabaseConnection()
{
	try {
		$conn = getDatabaseConnection();
		$conn->close();
		return true;
	} catch (Exception $e) {
		return false;
	}
}
