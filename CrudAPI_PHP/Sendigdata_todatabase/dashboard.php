 <?php
session_start();

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

$conn = new mysqli("localhost", "root", "", "task_manager");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$user = $_SESSION['user'];
$user_email = $user['email']; // Current logged-in user's email

// Fetch remaining users
$sql = "SELECT * FROM test2 WHERE email != ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $user_email);
$stmt->execute();
$result = $stmt->get_result();
$remaining_users = $result->fetch_all(MYSQLI_ASSOC);
?> 

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <style>
    body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            height: 100vh;
        }
        .sidebar {
            width: 30%;
            background: #2c3e50;
            color: white;
            padding: 20px;
        }
        .content {
            width: 70%;
            padding: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }
        th {
            background: #3498db;
            color: white;
        }
        .logout {
            display: block;
            margin-top: 300px;
            padding: 10px;
            margin-left: 10px;
            background: red;
            color: white;
            text-align: center;
            text-decoration: none;
            width: 100px;
            border-radius: 5px;
        }
    
        </style>
</head>
<body>

    <!-- Left Section (Logged-in User Details) -->
    <div class="sidebar">
        <h2>Logged in as</h2>
        <p><strong>SR No:</strong> <?php echo $user['sr.no']; ?></p>
        <p><strong>ID:</strong> <?php echo $user['id']; ?></p>
        <p><strong>Email:</strong> <?php echo $user['email']; ?></p>
        <a href="logout.php" class="logout">Logout</a>
    </div>

    <!-- Right Section (Remaining Users) -->
    <div class="content">
        <h2>Other Users</h2>
        <table>
            <tr>
                <th>SR No</th>
                <th>ID</th>
                <th>Email</th>
            </tr>
            <?php foreach ($remaining_users as $row) { ?>
                <tr>
                    <td><?php echo $row['sr.no']; ?></td>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['email']; ?></td>
                    <!-- <td><?php echo $row['name']; ?></td> -->
                </tr>
            <?php } ?>
        </table>
    </div>

</body>
</html>
