<?php
// signup_process.php

// Include database connection (replace with your actual database details)
include 'database.php';

$conn = new mysqli($servername, $username, $password, $dbname);

// Check for connection errors
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstName = trim($_POST['first_name']);
    $lastName = trim($_POST['last_name']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $workAs = trim($_POST['work_as']);

    // Hash password for security
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // SQL to insert data into the users table
    $sql = "INSERT INTO sign_up (first_name, last_name, email, password, work_as)
            VALUES ('$firstName', '$lastName', '$email', '$hashedPassword', '$workAs')";

    if ($conn->query($sql) === TRUE) {
        // Get the inserted record's ID
        $userId = $conn->insert_id;

        // Redirect to login page with details in URL parameters
        header("Location: login.html?serial_id=$userId&name=" . urlencode($firstName) . "&email=" . urlencode($email));
        exit();
    } else {
        // Error in insertion
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Close connection
$conn->close();
?>
