<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>Welcome to Sample App</h1>
        <form class="form-container" method="post" action="">
            <input type="text" name="content" placeholder="Enter some data" required>
            <button type="submit">Save</button>
        </form>

        <h2>Data Records</h2>
        <table>
            <thead>
                <tr>
                    <th>Content</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                include 'db.php';
                session_start();

                if (!isset($_SESSION['user_id'])) {
                    header("Location: login.php");
                    exit;
                }

                $user_id = $_SESSION['user_id'];

                if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['content'])) {
                    $content = $_POST['content'];
                    $sql = "INSERT INTO data (user_id, content) VALUES ('$user_id', '$content')";
                    $conn->query($sql);
                }

                if (isset($_GET['delete'])) {
                    $id = $_GET['delete'];
                    $sql = "DELETE FROM data WHERE id='$id'";
                    $conn->query($sql);
                }

                $sql = "SELECT * FROM data WHERE user_id='$user_id'";
                $result = $conn->query($sql);

                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['content'] . "</td>";
                    echo "<td><a href='index.php?delete=" . $row['id'] . "'>Delete</a></td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
