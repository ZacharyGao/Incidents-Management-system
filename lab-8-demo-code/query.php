<!-- <link rel="stylesheet" href="../css/mvp.css"> -->

<?php
// Step 1: Create a connection to the database
$servername = "mariadb";
$username = "root";
$password = "rootpwd";
$database = "PeopleWithPHP";

$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Step 2: Check if a query is submitted
if (isset($_POST['query'])) {
    // Check if user is logged in
    session_start();
    if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
        echo "Please log in to execute queries.";
        exit;
    }

    $query = $_POST['query'];

    // Step 3: Write the SQL query
    $sql = $query;

    // Step 4: Execute the query and fetch the results
    $result = $conn->query($sql);

    // Step 5: Display the results in an HTML table
    if ($result->num_rows > 0) {
        echo "<table>";
        echo "<tr><th>ID</th><th>Name</th><th>Phone</th></tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr><td>" . $row["id"] . "</td><td>" . $row["name"] . "</td><td>" . $row["phone"] . "</td></tr>";
        }
        echo "</table>";
    } else {
        echo "No results found.";
    }
}

// Step 6: Handle login form submission
if (isset($_POST['name']) && isset($_POST['phone'])) {
    $name = $_POST['name'];
    $phone = $_POST['phone'];

    // Step 7: Validate user credentials
    $sql = "SELECT * FROM People WHERE name = '$name' AND phone = '$phone'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        // Set session variables
        session_start();
        $_SESSION['loggedin'] = true;
        $_SESSION['name'] = $name;
        echo "Login successful. You can now execute queries.";
    } else {
        echo "Invalid username or password.";
    }
}

// Close the connection
$conn->close();
?>

<!-- Add the login form -->
<form method="POST" action="">
    <input type="text" name="name" placeholder="name">
    <input type="text" name="phone" placeholder="phone">
    <!-- <input type="password" name="phone" placeholder="Password"> -->
    <input type="submit" value="Log In">
</form>

<!-- Add the query form -->
<form method="POST" action="">
    <input type="text" name="query" placeholder="Enter your query">
    <input type="submit" value="Submit">
</form>