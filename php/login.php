<?php
session_start();
include 'db_connection.php'; // Include database connection

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    $query = "SELECT * FROM users WHERE username = '$username'";
    $result = mysqli_query($conn, $query);

    // Check if any user was found
    if ($result && mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
        
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            
            // Update last login
            $login_time = date('Y-m-d H:i:s');
            $update_query = "UPDATE users SET last_login = '$login_time' WHERE id = {$user['id']}";
            mysqli_query($conn, $update_query);
            
            echo "Login successful!"; // This message will be displayed in the modal
        } else {
            echo "Invalid username or password";
        }
    } else {
        echo "Invalid username or password";
    }
}
?>
