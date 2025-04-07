<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$conn = new mysqli("localhost", "root", "", "task_manager");

if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    $email = $conn->real_escape_string($_POST["email"]);
    $password = password_hash($_POST["password"], PASSWORD_BCRYPT); // Hashing the password
    $uid = uniqid(); // Generates a unique ID

    // Debugging output
    echo "Generated UID: " . $uid . " | Email: " . $email . "<br>";

    // Corrected SQL Query
    $sql = "INSERT INTO test2 (id, email, password) VALUES ('$uid', '$email', '$password')";

    if ($conn->query($sql)) {
        echo "Registration  successfully!";
        header('location:login.html');
    } else {
        echo "Error: " . $conn->error;
    }
}

?>




<!DOCTYPE html>
<html>
<head>
    <title>Login Page</title>
</head>
<body>
    <form action="" method="POST" onsubmit="return checkpassword()">
        <label for="email">Username</label>
        <input type="email" name="email" id="email" required>
        <br><br>
        <label for="password">Password</label>
        <input type="password" name="password" id="password" required>
        <br><br>
        <label for="cpassword">Confirm Password</label>
        <input type="password" name="conformpasword" id="cpassword" required>
        <br><br>
        <button type="submit" name="submit">Submit</button>
        <p id="demo" style="color: red;"></p>
    </form>
</body>
<script>
function checkpassword() {
    var password = document.getElementById("password").value;
    var confirmPassword = document.getElementById("cpassword").value;
    var message = document.getElementById("demo");

    if (password !== confirmPassword) {
        message.innerHTML = "bhau password bagun taka ";
        return false; // Prevent form submission
    } else {
        message.innerHTML = "jhal bhau ek number ja gheri mang";
        return true; // Allow form submission
    }
}
</script>
</html>
