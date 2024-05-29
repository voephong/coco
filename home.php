<?php
include 'db.php';

if (isset($_POST['delete'])) {
    $id_to_delete = $_POST['id']; // Get the ID of the row to delete
    // Step 3: Execute DELETE query
    $sql = "DELETE FROM users WHERE id = $id_to_delete"; // Change 'your_table' to your actual table name
    if ($conn->query($sql) === TRUE) {
        echo "Record deleted successfully";
    } else {
        echo "Error deleting record: " . $conn->error;
    }
}

$sql = "SELECT * FROM users"; // Change 'your_table' to your actual table name
$result = $conn->query($sql);

// Step 3: Display data in an HTML table
?>

<!DOCTYPE html>
<html>
<head>
    <title>Homepage with MySQL Data</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }
        th, td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
 <h2>MySQL Data</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Action</th>
            <!-- Add more columns as needed -->
        </tr>
        <?php
        // Output data of each row
        while($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>".$row["id"]."</td>";
            echo "<td>".$row["username"]."</td>";
            echo "<td>
                    <form method='post' action='update.php'>
                        <input type='hidden' name='id' value='".$row["id"]."'>
                        <input type='submit' name='update' value='Edit'>
                    </form>
                    <form method='post'>
                        <input type='hidden' name='id' value='".$row["id"]."'>
                        <input type='submit' name='delete' value='Delete' onclick='return confirm (\"Are you sure you wnt to delete this users?\");' >
                    </form>
                </td>";
            echo "</tr>";
        }
        ?>
    </table>
<button>
<a href=login.php>Logout</a>
</button>
</body>
</html>

<?php
// Step 4: Close the MySQL connection
$conn->close();
?>
