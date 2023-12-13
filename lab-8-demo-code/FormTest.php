<!DOCTYPE html>
<html>

<head>
    <title>Form Test</title>
</head>

<body>
    <!-- <h1>Form Test</h1>
    <form action="FormTest.php" method="post">
        <label for="name">Name:</label>
        <input type="text" name="name" id="name" placeholder="your name here" />
        <br />
        <label for="email">Email:</label>
        <input type="text" name="email" id="email" value="  " />
    </form> -->
    <hr />
    <h2>another Form:</h2>
    <h1>Form Test</h1>
    <form method="post">
        Enter your name here:
        <!-- <br/> -->
        <input type="text" name="yourname">
        <input type="submit" value="Say Hello">
    </form>
    <!-- <hr /> -->
    <?php
    if ($_POST['yourname'] == '') {
        // $_POST['yourname'] = 'no';
        echo "<b>No name submitted.</b>";
        // echo "Hello<strong>" . $_POST['yourname'] . "</strong>!";

    } else if (isset($_POST['yourname']))
        echo "Hello <strong>" . $_POST['yourname'] . "</strong>!";
    // else echo "No name submitted";
    ?>

    <?php
    // MySQL database information
    $servername = "mariadb";
    $username = "root";
    $password = "rootpwd";
    $dbname = "PeopleWithPHP";

    $conn = mysqli_connect(
        $servername,
        $username,
        $password,
        $dbname
    );
    // other code here!
    echo "<br>";
    if (mysqli_connect_errno()) {
        echo "Failed to connect to MySQL:" . mysqli_connect_error();
        die();
    } else
        echo "MySQL connection OK<br/><br/>";

    // construct the SELECT query
    $sql = "SELECT * FROM People ORDER BY Name;";
    // send query to database
    $result = mysqli_query($conn, $sql);

    echo mysqli_num_rows($result) . " rows<br/>";

    echo "<ul>";
    while ($row = mysqli_fetch_assoc($result)) {
        // echo $row["name"];
        // echo " (phone: " . $row["phone"] . ") ";
        // echo "<br/>";
        echo "<li>" . $row["name"] . "</li>";
        echo "phone: " . $row["phone"] . "<br/>";
        echo "address: " . $row["address"] . "<br/>";
        echo "<br/>";
    }
    echo "</ul>";

    mysqli_close($conn);
    ?>
</body>




</html>