<?php
// Include SQLite database configuration for demo
require_once 'config_sqlite.php';

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Function to sanitize input data
function sanitize_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Check if form is submitted via POST method
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get and sanitize form data
    $name = sanitize_input($_POST["name"]);
    $student_id = sanitize_input($_POST["student_id"]);
    $department = sanitize_input($_POST["department"]);

    // Validate input data
    $errors = array();

    if (empty($name)) {
        $errors[] = "Name is required";
    }

    if (empty($student_id)) {
        $errors[] = "Student ID is required";
    } elseif (!preg_match("/^[0-9]{9}$/", $student_id)) {
        $errors[] = "Student ID must be exactly 9 digits";
    }

    if (empty($department)) {
        $errors[] = "Department is required";
    }

    // If no errors, proceed with database insertion
    if (empty($errors)) {
        try {
            // Create connection
            $pdo = getDatabaseConnection();

            // Prepare and bind statement to prevent SQL injection
            $stmt = $pdo->prepare("INSERT INTO students (name, student_id, department) VALUES (?, ?, ?)");
            
            // Execute the statement
            if ($stmt->execute([$name, $student_id, $department])) {
                $success_message = "Student information has been successfully saved!";
                $student_record_id = $pdo->lastInsertId();
            } else {
                throw new Exception("Error executing query");
            }

        } catch (Exception $e) {
            // Handle duplicate student ID error
            if (strpos($e->getMessage(), 'UNIQUE constraint failed') !== false) {
                $errors[] = "Student ID already exists. Please use a different Student ID.";
            } else {
                $errors[] = "Database error: " . $e->getMessage();
            }
        }
    }
} else {
    // If not POST request, redirect to form
    header("Location: index.html");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Submission Result</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="container">
        <h1>Form Submission Result</h1>

        <?php if (isset($success_message)): ?>
            <div class="success-message">
                <h2>✓ Success!</h2>
                <p><?php echo $success_message; ?></p>
                <div class="student-info">
                    <h3>Submitted Information:</h3>
                    <p><strong>Name:</strong> <?php echo htmlspecialchars($name); ?></p>
                    <p><strong>Student ID:</strong> <?php echo htmlspecialchars($student_id); ?></p>
                    <p><strong>Department:</strong> <?php echo htmlspecialchars($department); ?></p>
                    <p><strong>Record ID:</strong> <?php echo $student_record_id; ?></p>
                </div>
            </div>
        <?php endif; ?>

        <?php if (!empty($errors)): ?>
            <div class="error-message">
                <h2>❌ Error!</h2>
                <p>Please correct the following errors:</p>
                <ul>
                    <?php foreach ($errors as $error): ?>
                        <li><?php echo htmlspecialchars($error); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <div class="actions">
            <a href="index.html" class="btn">← Back to Form</a>
            <a href="view_students_demo.php" class="btn">View All Students</a>
        </div>
    </div>
</body>

</html>