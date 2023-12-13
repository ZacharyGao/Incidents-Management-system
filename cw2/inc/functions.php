<?php

require_once("config.php"); // include database configuration file


// Function to establish a database connection
function connectToDatabase($servername, $username, $password, $database)
{
    mysqli_report(MYSQLI_REPORT_OFF); // handle mysqli error

    $conn = @new mysqli($servername, $username, $password, $database);

    global $connectDBMessage;
    if ($conn->connect_errno) {
        echo "Database: " . $database . "<br>Connected failed<br>";
        $connectDBMessage =  "Database: " . $database . "<br>Connected failed<br>";
        die("ERROR: Could not connect. <strong>" . $conn->connect_error . "</strong>");
    } else {
        // echo "Database: " . $database . "<br>Connected successfully<br>";
        $connectDBMessage = "Database: <strong>" . $database . "</strong> Connected successfully<br>You can log in now.<br>";
    }
    return $conn;
}

// other functions
function printArray($array)
{
    echo "<pre>";
    print_r($array);
    echo "</pre>";
}

function printArrayAsTable($array)
{
    echo "<h2>Query Results:</h2>";
    echo "<?php if (empty($array)) : ?>";
    echo "<p>No results found.</p>";
    echo "<?php else: ?>";
    echo "<p>Found <?php echo count($array); ?> results.</p>";

    echo "<table>";
    foreach ($array as $key => $value) {
        echo "<tr>";
        echo "<td>" . $key . "</td>";
        foreach ($value as $key => $value) {
            echo "<td>" . $value . "</td>";
        }
        echo "</tr>";
    }
    echo "</table>";
    echo "<?php endif; ?>";
    echo "<br>";
}

function printTable($array)
{
    echo '<div class="container">';
    echo '<div class="row">';
    echo '<div class="col-md-12">';
    echo '<h2>Query Results:</h2>';
    if (empty($array)) :
        echo '<p>No results found.111</p>';
    else :
        echo '<p>Found ' . count($array) . ' results.</p>';

        echo '<table class="table table-striped"><thead><tr>';
        echo '<th>Num</th>';
        foreach ($array[0] as $key => $value) {
            echo '<th>' . $key . '</th>';
        }
        echo '</tr></thead>';
        echo '<tbody>';
        foreach ($array as $key => $value) {
            echo "<tr>";
            echo "<td>" . $key . "</td>";
            foreach ($value as $key => $value) {
                echo "<td>" . $value . "</td>";
            }
            echo "</tr>";
        }
        echo "</tbody>";
        echo "</table>";
    endif;
    echo '</div>';
    echo '</div>';
    echo '</div>';
    echo "<br>";
}

function login($db, $username, $password)
{
    $stmt = $db->prepare("SELECT * FROM Police 
        WHERE Police_username = ? AND Police_password = ?");

    $username = clean_input($username);
    $password = clean_input($password);
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();

        // Set session variables
        // session_start();
        $_SESSION['loggedin'] = true;
        $_SESSION['username'] = $username;
        $_SESSION['role'] = $row['Police_role'];
        // session_start();
        header("Location: dashboard.php"); // redirect 

        exit;
    } else {
        global $LoginError;
        $LoginError = "<p>Invalid username or password.</p>";
        // echo "<p>Invalid username or password.</p>";
    }
}

function logout()
{
    // unset any session variables
    $_SESSION = [];

    // expire cookie
    if (!empty($_COOKIE[session_name()])) {
        setcookie(session_name(), "", time() - 42000);
    }

    // destroy session
    session_destroy();
}

function queryPeople($db, $name)
{
    $sql = "SELECT * FROM People WHERE People_name LIKE '%" . $name . "%' or People_licence LIKE '%" . $name . "%'";
    $result = mysqli_query($db, $sql);
    $people = mysqli_fetch_all($result, MYSQLI_ASSOC);
    return $people;
}

function queryVehicle($db, $info)
{

    $stmt = $db->prepare("SELECT Vehicle.*, People.* FROM Vehicle 
        LEFT JOIN Ownership ON Vehicle.Vehicle_ID = Ownership.Vehicle_ID 
        LEFT JOIN People ON Ownership.People_ID = People.People_ID 
        WHERE Vehicle.Vehicle_licence LIKE ?");

    $info = "%$info%";
    $stmt->bind_param("s", $info);
    $stmt->execute();
    $result = $stmt->get_result();

    $vehicle = mysqli_fetch_all($result, MYSQLI_ASSOC);
    return $vehicle;
}

function queryOffences($db, $info)
{
    $stmt = $db->prepare("SELECT * FROM Offence WHERE Offence_ID LIKE ? OR Offence_description LIKE ?");

    $info = "%$info%";
    $stmt->bind_param("ss", $info, $info);
    $stmt->execute();
    $result = $stmt->get_result();

    $offences = mysqli_fetch_all($result, MYSQLI_ASSOC);
    return $offences;
}

function queryIncidents($db, $info)
{
    $stmt = $db->prepare("SELECT * FROM Incident WHERE Incident_ID LIKE ? OR Incident_type LIKE ? OR Incident_date LIKE ? OR Incident_time LIKE ? OR Incident_location LIKE ? OR Incident_people_involved LIKE ? OR Incident_vehicle_involved LIKE ? OR Incident_description LIKE ? OR Incident_fine LIKE ? OR Incident_points LIKE ? OR Incident_status LIKE ?");

    $info = "%$info%";
    $stmt->bind_param("sssssssss
    s", $info, $info, $info, $info, $info, $info, $info, $info, $info, $info);
    $stmt->execute();
    $result = $stmt->get_result();

    $incidents = mysqli_fetch_all($result, MYSQLI_ASSOC);
    return $incidents;
}

function addVehicle($db, $vehicleType, $vehicleColour, $vehicleLicence, $peopleID)
{

    $vehicleType = clean_input($vehicleType);
    $vehicleColour = clean_input($vehicleColour);
    $vehicleLicence = clean_input($vehicleLicence);
    $peopleID = clean_input($peopleID); // supposing by peopleID

    $db->begin_transaction();

    try {
        $db->autocommit(FALSE); //turn on transactions

        $stmt = $db->prepare("INSERT INTO Vehicle (Vehicle_type, Vehicle_colour, Vehicle_licence) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $vehicleType, $vehicleColour, $vehicleLicence);
        $stmt->execute();
        $vehicleID = $db->insert_id; // get the last inserted ID
        echo "New vehicle added successfully. Vehicle ID is: " . $vehicleID . "<br>";

        $stmt = $db->prepare("INSERT INTO Ownership (Vehicle_ID, People_ID) VALUES (?, ?)");
        $stmt->bind_param("ss", $vehicleID, $peopleID);
        $stmt->execute();
        echo "New ownership added successfully. Vehicle ID is: " . $vehicleID . "<br>";



        // check if people exists
        $stmt = $db->prepare("SELECT * FROM People WHERE People_ID = ?");
        $stmt->bind_param("s", $peopleID);
        $stmt->execute();
        $result = $stmt->get_result();

        // add people if not exists
        if ($result->num_rows == 0) {
            // owner does not exist in database
            $stmt = $db->prepare("INSERT INTO People (People_ID) VALUES (?)");
            $stmt->bind_param("s", $peopleID);
            $stmt->execute();
            $peopleID = $db->insert_id; // get the last inserted ID
            echo "New people added successfully. People ID is: " . $peopleID . "<br>";
        } else {
            // owner exists in database
            $row = $result->fetch_assoc();
            $peopleID = $row['People_ID'];
            echo "People already exists in database. People ID is: " . $peopleID . "<br>";
        }

        // add vehicle to database
        $stmt = $db->prepare("INSERT INTO Vehicle (Vehicle_type, Vehicle_colour, Vehicle_licence) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $vehicleType, $vehicleColour, $vehicleLicence);
        $stmt->execute();
        echo "New vehicle added successfully. Vehicle ID is: " . $db->insert_id . "<br>";

        $ownerResult = queryVehicle($db, $vehicleLicence);

        // add ownership to database
        // $vehicleID = $ownerResult[0]["Vehicle_ID"];
        $peopleName = $ownerResult[0]["People_name"];
        echo "People name is: " . $peopleName . "<br>";

        // $peopleID = $ownerResult[0]["People_ID"];

        // $stmt = $db->prepare("INSERT INTO People (People_name) 
        //     VALUES (?)");
        // $stmt->bind_param("s", $peopleName);
        // $stmt->execute();
        // $result = $stmt->get_result();

        // $stmt = $db->prepare("INSERT INTO Ownership (Vehicle_ID, People_ID) 
        //     VALUES (?, ?)");
        // $stmt->bind_param("ss", $vehicleID, $peopleID);
        // $stmt->execute();
        // $result = $stmt->get_result();

        $db->commit();

        $db->autocommit(TRUE); // turn off transactions + commit queued queries

    } catch (mysqli_sql_exception $exception) {
        $db->rollback();
        throw $exception;
    }
}

function clean_input($input)
{
    $input = trim($input);
    $input = stripslashes($input);
    $input = htmlspecialchars($input);
    return $input;
}

// adapted from http://www.php.net/header
function redirect($destination)
{
    // handle URL
    if (preg_match("/^https?:\/\//", $destination)) {
        header("Location: " . $destination);
    }

    // handle absolute path
    else if (preg_match("/^\//", $destination)) {
        $protocol = (isset($_SERVER["HTTPS"])) ? "https" : "http";
        $host = $_SERVER["HTTP_HOST"];
        header("Location: $protocol://$host$destination");
    }

    // handle relative path
    else {
        // adapted from http://www.php.net/header
        $protocol = (isset($_SERVER["HTTPS"])) ? "https" : "http";
        $host = $_SERVER["HTTP_HOST"];
        $path = rtrim(dirname($_SERVER["PHP_SELF"]), "/\\");
        header("Location: $protocol://$host$path/$destination");
    }

    // exit immediately since we're redirecting anyway
    exit;
}

function pleaseLogin()
{
    if (!isset($_SESSION['username'])) {
        echo "<p>You are not logged in.</p>";
        echo "<p>Please login first.</p>";
        echo "<p><a href='login.php'>Login</a></p>";
        // redirect("login.php");
        require_once "inc/footer.php";
        exit;
    }
}

function findTitle($string)
{
    // chunk_split($string, "/");

    $title = "";
    $title = substr($string, 5, strpos($string, ".") - 5);
    if (strpos($title, "_")) {
        $title = str_replace("_", " ", $title);
        // 大写首字母
    }
    $title = ucwords($title);

    return $title;
}
