<?php
// Include database configuration
require_once 'config.php';

// Database configuration (using config.php constants)
$servername = DB_SERVER;
$username = DB_USERNAME;
$password = DB_PASSWORD;
$dbname = DB_NAME;

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>All Students - Student Information System</title>
	<link rel="stylesheet" href="style.css">
</head>

<body>
	<div class="container">
		<h1>All Students</h1>

		<?php
		try {
			// Create connection
			$conn = new mysqli($servername, $username, $password, $dbname);

			// Check connection
			if ($conn->connect_error) {
				throw new Exception("Connection failed: " . $conn->connect_error);
			}

			// Query to get all students
			$sql = "SELECT id, name, student_id, department, created_at FROM students ORDER BY created_at DESC";
			$result = $conn->query($sql);

			if ($result->num_rows > 0) {
				echo '<div style="padding: 20px 30px;">';
				echo '<table class="students-table">';
				echo '<thead>';
				echo '<tr>';
				echo '<th>ID</th>';
				echo '<th>Name</th>';
				echo '<th>Student ID</th>';
				echo '<th>Department</th>';
				echo '<th>Registration Date</th>';
				echo '</tr>';
				echo '</thead>';
				echo '<tbody>';

				while ($row = $result->fetch_assoc()) {
					echo '<tr>';
					echo '<td>' . htmlspecialchars($row["id"]) . '</td>';
					echo '<td>' . htmlspecialchars($row["name"]) . '</td>';
					echo '<td>' . htmlspecialchars($row["student_id"]) . '</td>';
					echo '<td>' . htmlspecialchars($row["department"]) . '</td>';
					echo '<td>' . date('M d, Y H:i', strtotime($row["created_at"])) . '</td>';
					echo '</tr>';
				}

				echo '</tbody>';
				echo '</table>';
				echo '<p style="color: #666; margin-top: 15px;"><strong>Total Students:</strong> ' . $result->num_rows . '</p>';
				echo '</div>';
			} else {
				echo '<div class="no-records">';
				echo '<h3>No students found</h3>';
				echo '<p>No student records have been added to the database yet.</p>';
				echo '</div>';
			}

			// Close connection
			$conn->close();
		} catch (Exception $e) {
			echo '<div class="error-message" style="margin: 20px 30px;">';
			echo '<h2>❌ Database Error</h2>';
			echo '<p>Unable to retrieve student records: ' . htmlspecialchars($e->getMessage()) . '</p>';
			echo '</div>';
		}
		?>

		<div class="actions">
			<a href="index.html" class="btn">← Add New Student</a>
		</div>
	</div>
</body>

</html>