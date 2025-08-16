<?php
// Include database configuration
require_once 'config.php';

echo "<h1>Database Connection Test</h1>";

try {
	// Test database connection
	$conn = getDatabaseConnection();

	echo "<div style='color: green; padding: 20px; border: 2px solid green; margin: 10px; border-radius: 5px;'>";
	echo "<h2>✓ Database Connection Successful!</h2>";
	echo "<p><strong>Server:</strong> " . DB_SERVER . "</p>";
	echo "<p><strong>Database:</strong> " . DB_NAME . "</p>";
	echo "<p><strong>Username:</strong> " . DB_USERNAME . "</p>";

	// Check if students table exists
	$result = $conn->query("SHOW TABLES LIKE 'students'");
	if ($result->num_rows > 0) {
		echo "<p><strong>Students Table:</strong> ✓ Exists</p>";

		// Count existing records
		$count_result = $conn->query("SELECT COUNT(*) as count FROM students");
		$count = $count_result->fetch_assoc()['count'];
		echo "<p><strong>Existing Records:</strong> " . $count . " students</p>";
	} else {
		echo "<p><strong>Students Table:</strong> ❌ Not found - Please run the database_setup.sql script</p>";
	}
	echo "</div>";

	$conn->close();
} catch (Exception $e) {
	echo "<div style='color: red; padding: 20px; border: 2px solid red; margin: 10px; border-radius: 5px;'>";
	echo "<h2>❌ Database Connection Failed!</h2>";
	echo "<p><strong>Error:</strong> " . htmlspecialchars($e->getMessage()) . "</p>";
	echo "<h3>Troubleshooting Steps:</h3>";
	echo "<ol>";
	echo "<li>Make sure XAMPP is running (Apache + MySQL)</li>";
	echo "<li>Check if MySQL service is started in XAMPP Control Panel</li>";
	echo "<li>Verify database credentials in config.php</li>";
	echo "<li>Run the database_setup.sql script in phpMyAdmin</li>";
	echo "</ol>";
	echo "</div>";
}

echo "<div style='margin: 20px; padding: 15px; background: #f8f9fa; border-radius: 5px;'>";
echo "<h3>Quick Links:</h3>";
echo "<a href='index.html' style='margin-right: 10px; padding: 8px 15px; background: #007bff; color: white; text-decoration: none; border-radius: 3px;'>Student Form</a>";
echo "<a href='view_students.php' style='margin-right: 10px; padding: 8px 15px; background: #28a745; color: white; text-decoration: none; border-radius: 3px;'>View Students</a>";
echo "<a href='http://localhost/phpmyadmin' target='_blank' style='padding: 8px 15px; background: #dc3545; color: white; text-decoration: none; border-radius: 3px;'>phpMyAdmin</a>";
echo "</div>";
?>

<!DOCTYPE html>
<html>

<head>
	<title>Database Test</title>
	<style>
		body {
			font-family: Arial, sans-serif;
			margin: 20px;
		}

		h1 {
			color: #333;
		}
	</style>
</head>

<body>
</body>

</html>