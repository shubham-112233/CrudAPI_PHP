<?php
$host = "localhost"; // Change if your database is hosted remotely
$user = "root"; // Your MySQL username
$pass = ""; // Your MySQL password
$dbname = "tms_db"; // Your database name

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$users = array();
$sql = mysqli_query($conn,"SELECT * FROM `user` ");

//to store and display values from mysql table to arry
if (mysqli_num_rows($sql)>0){
    while($row = mysqli_fetch_assoc($sql)){
        $users[] = $row;
    }
   
} print_r($users);
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insert Data in MySQL</title>
</head>
<body>
    <h2>Insert User Data</h2>
    <form action="" method="POST">
        <label for="name">Name:</label>
        <input type="text" name="name" required><br><br>

        <label for="email">Email:</label>
        <input type="email" name="email" required><br><br>

        <button type="submit">Submit</button>

    </form>
</body>
</html>
