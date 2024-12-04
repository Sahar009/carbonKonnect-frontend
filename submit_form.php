<?php
// Database connection parameters
$host = "your_host";
$dbname = "your_database_name";
$username = "your_username";
$password = "your_password";

// Get form data
$name = $_POST['name'];
$email = $_POST['email'];
$message = $_POST['message'];
$date = date('Y-m-d H:i:s');

try {
    // Create database connection
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Prepare SQL statement
    $sql = "INSERT INTO contact_messages (name, email, message, submission_date) 
            VALUES (:name, :email, :message, :date)";
    
    $stmt = $conn->prepare($sql);
    
    // Bind parameters
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':message', $message);
    $stmt->bindParam(':date', $date);
    
    // Execute the statement
    $stmt->execute();

    // Send email notification
    $to = "your-email@example.com"; // Replace with your email
    $subject = "New Contact Form Submission";
    $email_content = "Name: $name\n";
    $email_content .= "Email: $email\n\n";
    $email_content .= "Message:\n$message\n";
    
    $headers = "From: $email";

    mail($to, $subject, $email_content, $headers);

    // Return success response
    $response = array(
        'status' => 'success',
        'message' => 'Thank you for your message. We will get back to you soon!'
    );
    echo json_encode($response);

} catch(PDOException $e) {
    // Return error response
    $response = array(
        'status' => 'error',
        'message' => 'Sorry, there was an error sending your message.'
    );
    echo json_encode($response);
}
?> 



<!-- CREATE TABLE contact_messages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    message TEXT NOT NULL,
    submission_date DATETIME NOT NULL,
    status ENUM('new', 'read', 'replied') DEFAULT 'new'
); -->