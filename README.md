index.php 


<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "feedback";

$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $subject = $_POST['subject'];
    $message = $_POST['message'];

    $sql = "INSERT INTO feed (name, email, subject, message) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $name, $email, $subject, $message);
    if ($stmt->execute()) {
        echo "<p>Feedback submitted successfully!</p>";
    } else {
        echo "<p>Error submitting feedback: " . $stmt->error . "</p>";
    }
    $stmt->close();
}

// Fetch records for Read operation
$result = $conn->query("SELECT * FROM feed");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedback Form</title>
</head>
<body>
    <h2>Feedback Form</h2>
    <form method="post" action="">
        <label for="name">Name:</label><br>
        <input type="text" id="name" name="name" required><br><br>
        <label for="email">Email:</label><br>
        <input type="email" id="email" name="email" required><br><br>
        <label for="subject">Subject:</label><br>
        <input type="text" id="subject" name="subject" required><br><br>
        <label for="message">Message:</label><br>
        <textarea id="message" name="message" cols="50" rows="4"></textarea><br><br>
        <input type="submit" name="submit" value="Submit Feedback">
    </form>

    <h2>All Feedbacks</h2>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Subject</th>
            <th>Message</th>
            <th>Actions</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()) { ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['name']; ?></td>
                <td><?php echo $row['email']; ?></td>
                <td><?php echo $row['subject']; ?></td>
                <td><?php echo $row['message']; ?></td>
                <td>
                    <a href="update.php?id=<?php echo $row['id']; ?>">Edit</a> | 
                    <a href="delete.php?id=<?php echo $row['id']; ?>">Delete</a>
                </td>
            </tr>
        <?php } ?>
    </table>
</body>
</html>
<?php
$conn->close();
?>


UPDATE .PHP
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




DELETE.PHP

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



COOKIE .HTML
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Validation with Cookies</title>
    <script src="script.js" defer></script>
</head>
<body>
    <h1>Contact Form</h1>
    <form id="contactForm">
        <label for="name">Name:</label>
        <input type="text" id="name" required>
        <br>
        <label for="email">Email:</label>
        <input type="email" id="email" required>
        <br>
        <label for="message">Message:</label>
        <textarea id="message" required></textarea>
        <br>
        <button type="submit">Submit</button>
    </form>
</body>
</html>

COOKIE.JS
document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('contactForm');

    // Load cookies if available
    loadCookies();

    form.addEventListener('submit', (event) => {
        event.preventDefault(); // Prevent form submission

        // Validate the form
        if (validateForm()) {
            // If valid, store the values in cookies
            setCookies();
            alert('Form submitted successfully!');
            // Optionally, clear the form
            form.reset();
        } else {
            alert('Please fill out all fields correctly.');
        }
    });

    function validateForm() {
        const name = document.getElementById('name').value;
        const email = document.getElementById('email').value;
        const message = document.getElementById('message').value;

        return name && email && message; // Simple validation
    }

    function setCookies() {
        const name = document.getElementById('name').value;
        const email = document.getElementById('email').value;
        const message = document.getElementById('message').value;

        document.cookie = name=${encodeURIComponent(name)}; path=/; max-age=3600; // 1 hour
        document.cookie = email=${encodeURIComponent(email)}; path=/; max-age=3600; // 1 hour
        document.cookie = message=${encodeURIComponent(message)}; path=/; max-age=3600; // 1 hour
    }

    function loadCookies() {
        const cookies = document.cookie.split('; ');
        cookies.forEach(cookie => {
            const [key, value] = cookie.split('=');
            if (key === 'name') {
                document.getElementById('name').value = decodeURIComponent(value);
            } else if (key === 'email') {
                document.getElementById('email').value = decodeURIComponent(value);
            } else if (key === 'message') {
                document.getElementById('message').value = decodeURIComponent(value);
            }
        });
    }
});
