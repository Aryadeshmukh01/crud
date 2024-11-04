<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "feedback";

$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "DELETE FROM feed WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        echo "<p>Feedback deleted successfully!</p>";
    } else {
        echo "<p>Error deleting feedback: " . $stmt->error . "</p>";
    }
    $stmt->close();
    header("Location: index.php");
    exit();
}

$conn->close();
?>