<!-- FILEPATH: /d:/UON/4039_DatabaseInterfaceSoftwareDsgn/github/dis_docker/html/lab-8-demo-code/add.php -->

<!DOCTYPE html>
<html>

<head>
    <title>Add Person</title>
</head>

<body>
    <!-- Add data form -->
    <h1>Add Person</h1>
    <form action="add.php" method="POST">
        <label for="name">Name:</label>
        <input type="text" name="name" id="name" required><br><br>

        <label for="phone">Phone:</label>
        <input type="number" name="phone" id="phone" required><br><br>

        <input type="submit" name="add" value="Add Person">
    </form>
    <!-- the query form -->
    <h1>Query</h1>
    <form method="POST">
        <input type="text" name="query" placeholder="Enter your SQL query">
        <input type="submit" value="Submit">
    </form>
    <!-- Update data form -->
    <h1>Update Person</h1>
    <form action="add.php" method="POST">
        <label for="id">ID:</label>
        <input type="number" name="id" id="id" required><br><br>

        <label for="new_name">New Name:</label>
        <input type="text" name="new_name" id="new_name" required><br><br>

        <label for="new_phone">New Phone:</label>
        <input type="number" name="new_phone" id="new_phone" required><br><br>

        <input type="submit" name="update" value="Update Person">
    </form>
    <!-- Delete data form -->
    <h1>Delete Person</h1>
    <form action="add.php" method="POST">
        <label for="id">ID:</label>
        <input type="number" name="id" id="id" required><br><br>

        <input type="submit" name="delete" value="Delete Person">
    </form>
</body>

</html>

<?php

// Database configuration
$servername = "mariadb";
$username = "root";
$password = "rootpwd";
$dbname = "PeopleWithPHP";

// Create a database connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the query form is submitted
    if (isset($_POST["query"])) {
        // Get the query from the form
        $query = $_POST["query"];

        // Execute the query
        $result = $conn->query($query);

        // Display the results
        if ($result->num_rows > 0) {
            echo "<h2>Query Results:</h2>";
            while ($row = $result->fetch_assoc()) {
                echo "ID:" . $row["id"] . ", Name: " . $row["name"] . ", Phone: " . $row["phone"] . "<br>";
            }
        } else {
            echo "No results found.";
        }
    } else if (isset($_POST['update'])) {
        $id = $_POST['id'];
        $new_name = $_POST['new_name'];
        $new_phone = $_POST['new_phone'];

        $sql = "UPDATE people SET name='$new_name', phone='$new_phone' WHERE id=$id";

        if ($conn->query($sql) === TRUE) {
            echo "Record updated successfully";
        } else {
            echo "Error updating record: " . $conn->error;
        }
    } else if (isset($_POST['add'])) {
        // Get the form data
        $name = $_POST["name"];
        $phone = $_POST["phone"];

        // Insert the data into the database
        $sql = "INSERT INTO people (name, phone) VALUES ('$name', '$phone')";
        if ($conn->query($sql) === TRUE) {
            echo "Person added successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else if (isset($_POST['delete'])) {
        $id = $_POST['id'];

        $sql = "DELETE FROM people WHERE id=$id";

        if ($conn->query($sql) === TRUE) {
            echo "Record deleted successfully";
        } else {
            echo "Error deleting record: " . $conn->error;
        }
    }
}

// Close the database connection
$conn->close();
?>