<?php
$servername = "localhost:3306";
$username = "root";
$password = "";
$dbname = "dswdb";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["mail"];
    $password = $_POST["pass"];

    // Hash the password (assuming you store hashed passwords in the database)
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Query to check user credentials
    $sql = "SELECT * FROM users WHERE email = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // User found, check password
        $row = $result->fetch_assoc();
        if (password_verify($password, $row["password"])) {
            // Authentication successful
            echo "Login successful!";
            // You can redirect the user to a dashboard or another page here
        } else {
            // Invalid password
            echo "Invalid password";
        }
    } else {
        // User not found
        echo "User not found";
    }
} else {
    // Redirect or handle the case where the form is not submitted via POST
    // For example, you can redirect to the form page or display an error message
    header("Location: form.html");
    exit();
}

// Close the database connection
$conn->close();
?>
