<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

$conn = new mysqli("localhost", "root", "", "task_manager");

if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login'])) {
    $email = $conn->real_escape_string($_POST['email']);
    // echo isset($_POST['login']);

    $password = $_POST['password'];
    $uid = uniqid();

    // Fetch user data
    // $sql = "SELECT * FROM test2 WHERE email = ?";
    $sql = "SELECT * FROM test2 WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user'] = $user;
        echo $user['name'];
          echo "Generated UID: "  . " | Email: " . $email . "<br>" .$password ." <br>".$uid ." ";
          header('location:dashboard.php');// Redirect to dashboard
        exit();
    } else {
        echo "<script>alert('Invalid email or password!');</script>";
    }
}
?>