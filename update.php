<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if both username and user_id fields are not empty
    if (!empty($_POST['username']) && !empty($_POST['user_id'])) {
        $username = $_POST['username'];
        $user_id = $_POST['user_id'];

        // Check if the password field is not empty
        if (!empty($_POST['password'])) {
            $password = $_POST['password'];

            // Password validation
            if (strlen($password) < 8 ||
                !preg_match('/[A-Z]/', $password) ||
                !preg_match('/[a-z]/', $password) ||
                !preg_match('/[0-9]/', $password) ||
                !preg_match('/[!@#$%^&*(),.?":{}|<>]/', $password)) {
                echo "Password must be at least 8 characters long and include at least one uppercase letter, one lowercase letter, one number, and one special character.";
            } else {
                // Hash the password
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);

                // Update query
                $sql_update = "UPDATE users SET username=?, password=? WHERE id=?";

                // Prepare and bind the statement
                $stmt = $conn->prepare($sql_update);
                $stmt->bind_param("ssi", $username, $hashed_password, $user_id);

                // Execute the statement
                if ($stmt->execute()) {
                    header("location: home.php");
                } else {
                    echo "Error updating username and password: " . $conn->error;
                }

                // Close the statement
                $stmt->close();
            }
        } else {
            // If password field is empty, update only the username
            $sql_update = "UPDATE users SET username=? WHERE id=?";
            $stmt = $conn->prepare($sql_update);
            $stmt->bind_param("si", $username, $user_id);
            if ($stmt->execute()) {
                header("location: home.php");
            } else {
                echo "Error updating username: " . $conn->error;
            }
            $stmt->close();
        }
    } else {
        echo "Username and user ID are required.";
    }
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update Username and Password</title>
</head>
<body>
    <h2>Update Username and Password</h2>
    <form action="update.php" method="POST">
        <p>User Name</p>
        <input type="text" id="username" name="username" required><br><br>
        <p>Password</p>
        <input type="password" id="password" name="password"><br><br>
        <p>ID</p>
        <input type="number" id="user_id" name="user_id" required><br><br>
        <input type="submit" value="Update">
    </form>
</body>
</html>
