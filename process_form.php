<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "portfolio";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// If the form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Get the form data and sanitize it
  $name = mysqli_real_escape_string($conn, $_POST['name']);
  $email = mysqli_real_escape_string($conn, $_POST['email']);
  $message = mysqli_real_escape_string($conn, $_POST['message']);

  // Validate the email address
  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo "Invalid email address";
    exit;
  }

  // Prepare the SQL statement
  $stmt = mysqli_prepare($conn, "INSERT INTO messages (name, email, message) VALUES (?, ?, ?)");

  // Check if the prepare statement failed
  if (!$stmt) {
    echo "Error: " . mysqli_error($conn);
    exit;
  }

  // Bind parameters to the prepared statement
  mysqli_stmt_bind_param($stmt, "sss", $name, $email, $message);

  // Execute the prepared statement
  if (mysqli_stmt_execute($stmt)) {
    echo "Message sent successfully";
    echo '<meta http-equiv="refresh" content="1; url=/my portfolio website/index.html" />';
  } else {
    echo "Error: " . mysqli_stmt_error($stmt);
  }
  
}
?>
