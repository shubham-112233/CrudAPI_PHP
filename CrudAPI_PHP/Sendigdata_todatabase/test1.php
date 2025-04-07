<?php
$conn = new mysqli("localhost", "root", "", "tms_db");

if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

// Insert data to my database
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    $name = $conn->real_escape_string($_POST["name"]);
    $email = $conn->real_escape_string($_POST["email"]);
    
    if ($conn->query("INSERT INTO ins (name, email) VALUES ('$name', '$email')")) {
        echo "Data inserted successfully!";
    } else {
        echo "Error: " . $conn->error;
    }
}

// Update data
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
    $id = $_POST['id'];
    $name = $conn->real_escape_string($_POST["name"]);
    $email = $conn->real_escape_string($_POST["email"]);
    
    if ($conn->query("UPDATE ins SET name='$name', email='$email' WHERE id=$id")) {
        echo "Record updated successfully!";
    } else {
        echo "Error: " . $conn->error;
    }
}

// Delete data
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    if ($conn->query("DELETE FROM ins WHERE id=$id")) {
        echo "Record deleted successfully!";
    } else {
        echo "Error: " . $conn->error;
    }
}

// Fetch records
$result = $conn->query("SELECT * FROM ins");
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users</title>
</head>
<body>
    <h2>Insert / Update User Data</h2>
    <form method="POST">
        <input type="hidden" name="id" id="userId">
        <label>Name:</label>
        <input type="text" name="name" id="name" required><br><br>
        <label>Email:</label>
        <input type="email" name="email" id="email" required><br><br>
        <button type="submit" name="submit">Submit</button>
        <button type="submit" name="update">Update</button>
    </form>

    <h2>Users List</h2>
    <table borde="1">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Action</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()) { ?>
        <tr>
            <td><?php echo $row['id']; ?></td>
            <td><?php echo $row['name']; ?></td>
            <td><?php echo $row['email']; ?></td>
            <td>
                <button onclick="editUser(<?php echo $row['id']; ?>, '<?php echo $row['name']; ?>', '<?php echo $row['email']; ?>')">Edit</button>
                <a href="?delete=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure?')">Delete</a>
            </td>
        </tr>
        <?php } ?>
    </table>

    <script>
        function editUser(id, name, email) {
            document.getElementById('userId').value = id;
            document.getElementById('name').value = name;
            document.getElementById('email').value = email;
        }
    </script>
</body>
</html>
