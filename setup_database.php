<?php
// Include database configuration
require_once 'config.php';

$setup_complete = false;
$errors = array();
$success_messages = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['setup_database'])) {
	try {
		// Connect to MySQL server without specifying database
		$conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD);

		if ($conn->connect_error) {
			throw new Exception("Connection failed: " . $conn->connect_error);
		}

		// Create database
		$sql = "CREATE DATABASE IF NOT EXISTS " . DB_NAME;
		if ($conn->query($sql) === TRUE) {
			$success_messages[] = "Database '" . DB_NAME . "' created successfully or already exists";
		} else {
			throw new Exception("Error creating database: " . $conn->error);
		}

		// Select the database
		$conn->select_db(DB_NAME);

		// Create students table
		$table_sql = "CREATE TABLE IF NOT EXISTS students (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(100) NOT NULL,
            student_id VARCHAR(20) UNIQUE NOT NULL,
            department VARCHAR(100) NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )";

		if ($conn->query($table_sql) === TRUE) {
			$success_messages[] = "Table 'students' created successfully or already exists";
		} else {
			throw new Exception("Error creating table: " . $conn->error);
		}

		// Insert sample data (optional)
		if (isset($_POST['insert_sample_data'])) {
			$sample_data = [
				['John Doe', '222014027', 'Computer Science'],
				['Jane Smith', '222014028', 'Engineering'],
				['Mike Johnson', '222014029', 'Mathematics']
			];

			$stmt = $conn->prepare("INSERT IGNORE INTO students (name, student_id, department) VALUES (?, ?, ?)");
			$inserted_count = 0;

			foreach ($sample_data as $student) {
				$stmt->bind_param("sss", $student[0], $student[1], $student[2]);
				if ($stmt->execute()) {
					$inserted_count++;
				}
			}

			if ($inserted_count > 0) {
				$success_messages[] = "Inserted $inserted_count sample student records";
			} else {
				$success_messages[] = "Sample data already exists or no new records inserted";
			}

			$stmt->close();
		}

		$conn->close();
		$setup_complete = true;
	} catch (Exception $e) {
		$errors[] = $e->getMessage();
	}
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Database Setup - Student Information System</title>
	<link rel="stylesheet" href="style.css">
</head>

<body>
	<div class="container">
		<h1>Database Setup</h1>

		<?php if (!empty($success_messages)): ?>
			<div class="success-message">
				<h2>✓ Setup Successful!</h2>
				<?php foreach ($success_messages as $message): ?>
					<p><?php echo htmlspecialchars($message); ?></p>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>

		<?php if (!empty($errors)): ?>
			<div class="error-message">
				<h2>❌ Setup Failed!</h2>
				<?php foreach ($errors as $error): ?>
					<p><?php echo htmlspecialchars($error); ?></p>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>

		<?php if (!$setup_complete): ?>
			<div style="padding: 30px;">
				<h3>Database Configuration</h3>
				<p><strong>Server:</strong> <?php echo DB_SERVER; ?></p>
				<p><strong>Username:</strong> <?php echo DB_USERNAME; ?></p>
				<p><strong>Database Name:</strong> <?php echo DB_NAME; ?></p>

				<form method="post" style="margin-top: 30px;">
					<div class="form-group">
						<label>
							<input type="checkbox" name="insert_sample_data" checked>
							Insert sample student data for testing
						</label>
					</div>

					<div class="form-group">
						<button type="submit" name="setup_database" class="submit-btn">
							Create Database & Tables
						</button>
					</div>
				</form>

				<div style="margin-top: 20px; padding: 15px; background: #e9ecef; border-radius: 5px;">
					<h4>Prerequisites:</h4>
					<ul>
						<li>XAMPP is running (Apache + MySQL)</li>
						<li>MySQL service is started in XAMPP Control Panel</li>
						<li>Default MySQL credentials are being used (root with no password)</li>
					</ul>
				</div>
			</div>
		<?php else: ?>
			<div class="actions">
				<a href="test_connection.php" class="btn">Test Connection</a>
				<a href="index.html" class="btn">Student Form</a>
				<a href="view_students.php" class="btn">View Students</a>
			</div>
		<?php endif; ?>
	</div>
</body>

</html>