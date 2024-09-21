<?php

session_start();


$host = 'localhost'; 
$db = 'myhours_db';  
$user = 'root';      
$pass = '';          

// Create connection
$conn = new mysqli($host, $user, $pass, $db);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];
    
    
    if (empty($email) || empty($password)) {
        echo "Email and password are required.";
    } else {
        
        $password = md5($password); 
        
        
        $stmt = $conn->prepare("SELECT * FROM users WHERE email = ? AND password = ?");
        $stmt->bind_param('ss', $email, $password);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
           
            $_SESSION['email'] = $email;  
            echo "Login successful. Redirecting to the homepage...";
            header("Location: myhours.html");  
            exit();
        } else {
            echo "Invalid email or password.";
        }

        $stmt->close();
    }
}

$conn->close();
?>
