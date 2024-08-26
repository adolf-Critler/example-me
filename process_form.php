<?php
require 'vendor/autoload.php'; // Include Composer's autoloader

// MongoDB connection settings
$client = new MongoDB\Client("mongodb+srv://<db_username>:loverain>@lanutemsu.htsyjqj.mongodb.net/?retryWrites=true&w=majority&appName=lanutemsu"); // Replace with your MongoDB connection string
$collection = $client->portfolio->messages; // Database: 'portfolio', Collection: 'messages'

// If the form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the form data and sanitize it
    $name = htmlspecialchars($_POST['name'], ENT_QUOTES, 'UTF-8');
    $email = htmlspecialchars($_POST['email'], ENT_QUOTES, 'UTF-8');
    $message = htmlspecialchars($_POST['message'], ENT_QUOTES, 'UTF-8');

    // Validate the email address
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email address";
        exit;
    }

    // Prepare the document to insert
    $document = [
        'name' => $name,
        'email' => $email,
        'message' => $message,
        'created_at' => new MongoDB\BSON\UTCDateTime() // Optional: add a timestamp
    ];

    // Insert the document into the collection
    $result = $collection->insertOne($document);

    if ($result->getInsertedCount() === 1) {
        echo "Message sent successfully";
        echo '<meta http-equiv="refresh" content="1; url=/my portfolio website/index.html" />';
    } else {
        echo "Error: Message not saved";
    }
}
?>
