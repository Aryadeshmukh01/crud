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
    $result = $conn->query("SELECT * FROM feed WHERE id = $id");
    $row = $result->fetch_assoc();
}

if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $subject = $_POST['subject'];
    $message = $_POST['message'];

    $sql = "UPDATE feed SET name=?, email=?, subject=?, message=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssi", $name, $email, $subject, $message, $id);
    if ($stmt->execute()) {
        echo "<p>Feedback updated successfully!</p>";
    } else {
        echo "<p>Error updating feedback: " . $stmt->error . "</p>";
    }
    $stmt->close();
    header("Location: index.php");
    exit();
}
?>

<form method="post" action="">
    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
    <label>Name:</label><br>
    <input type="text" name="name" value="<?php echo $row['name']; ?>"><br><br>
    <label>Email:</label><br>
    <input type="email" name="email" value="<?php echo $row['email']; ?>"><br><br>
    <label>Subject:</label><br>
    <input type="text" name="subject" value="<?php echo $row['subject']; ?>"><br><br>
    <label>Message:</label><br>
    <textarea name="message"><?php echo $row['message']; ?></textarea><br><br>
    <input type="submit" name="update" value="Update Feed">
</form>