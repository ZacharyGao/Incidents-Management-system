<?php
// Start the session at the top of the script
session_start();

// Function to establish a database connection
function connectToDatabase($servername, $username, $password, $database)
{
    $conn = new mysqli($servername, $username, $password, $database);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    return $conn;
}

// Function to check login credentials
function checkLogin($conn, $name, $phone)
{
    /* `stmt` is a variable that is used to store a prepared statement in PHP. Prepared statements are
    used to execute SQL queries with parameters, which helps prevent SQL injection attacks. In this
    code, `stmt` is used to prepare and execute a SELECT query to check the login credentials
    provided by the user. */
    $stmt = $conn->prepare("SELECT * FROM People WHERE name = ? AND phone = ?");
    $stmt->bind_param("ss", $name, $phone); // 'ss' specifies the variables are strings
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows == 1) {
        $_SESSION['loggedin'] = true;
        $_SESSION['name'] = $name;
        return true;
    }
    return false;
}

// Function to execute a query and return results
function executeQuery($conn, $query)
{
    $result = $conn->query($query);
    return $result;
}

// Database credentials
$servername = "mariadb";
$username = "root";
$password = "rootpwd";
$database = "PeopleWithPHP";

// Create a connection to the database
$conn = connectToDatabase($servername, $username, $password, $database);

// init login message and query message
$loginMessage = "";
$queryMessage = "";

// Check for login form submission
if (isset($_POST['name']) && isset($_POST['phone'])) {
    // clear the login message
    unset($_SESSION['loginMessage']);

    $name = $_POST['name'];
    $phone = $_POST['phone'];
    if (checkLogin($conn, $name, $phone)) {
        $_SESSION['loginMessage'] = "Login successful. You can now execute queries.";
        // $loginMessage = "Login successful. You can now execute queries.";
    } else {
        $_SESSION['loginMessage'] = "Invalid username or password.";
        // $loginMessage = "Invalid username or password.";
    }
}

// Check for query submission
if (isset($_POST['query']) && $_SESSION['loggedin']) {
    $query = $_POST['query'];
    $result = executeQuery($conn, $query);

    // Display the results in an HTML table
    if ($result->num_rows > 0) {
        echo "<table>";
        echo "<tr><th>ID</th><th>Name</th><th>Phone</th></tr>";
        while ($row = $result->fetch_assoc()) {
            // echo "<tr><td>" . htmlspecialchars($row["id"]) . "</td><td>" . htmlspecialchars($row["name"]) . "</td><td>" . htmlspecialchars($row["phone"]) . "</td></tr>";
            $queryMessage .= "<tr><td>" . htmlspecialchars($row["id"]) . "</td><td>" . htmlspecialchars($row["name"]) . "</td><td>" . htmlspecialchars($row["phone"]) . "</td></tr>";
        }
        // echo "</table>";
        $queryMessage .= "</table>";
    } else {
        // echo "No results found.";
        $queryMessage = "No results found.";
    }
}

// Close the database connection
$conn->close();
?>

<!-- <link rel="stylesheet" href="../css/mvp.css"> -->

<!-- Add the login form -->
<form method="POST" action="">
    <input type="text" name="name" placeholder="name">
    <input type="text" name="phone" placeholder="phone">
    <input type="submit" value="Log In">
</form>

<!-- Show login info -->
<div>
    <?php
    if (isset($_SESSION['loginMessage'])) {
        echo $_SESSION['loginMessage'];
        // delete the login message
        // unset($_SESSION['loginMessage']);
    }
    ?>
</div>

<div id="queryResult" style="height: 100px;">
    <?php echo $loginMessage; ?>
</div>


<!-- Add the query form -->
<form method="POST" action="">
    <input type="text" name="query" placeholder="Enter your query">
    <input type="submit" value="Submit">
</form>

<!-- show query info -->
<div style="height: 50px; overflow-y: auto;">
    <?php echo $queryMessage; ?>
</div>