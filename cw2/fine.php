<?php
// fine.php
include_once 'inc/config.php';
include_once 'inc/functions.php';
include_once 'inc/header.php';


if (isset($_SESSION['username'])) {
    echo "<p>Login as <strong>" . $_SESSION['username'] . "</strong> successful. You can now execute queries.</p>";
    echo "Your role is <strong>" . $_SESSION['role'] . "</strong>.";

    if ($_SESSION['role'] == 'Administrator') {

?>
        <p><a href="search_fine.php">Fine</a></p>
        <p><a href="search_audit.php">Audit</a></p>
        <p><a href="add_police.php">Add Police User</a></p>
        <p><a href="logout.php">Logout</a></p>
    <?php
    } else {
        echo "You are not an administrator.";
    }
    ?>
    <p><a href="change_pw.php">Change Password</a></p>
    <p><a href="logout.php">Logout</a></p>
<?php
} else {
    pleaseLogin();
}




$success = $infoError = "";

// add new report
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['person'], $_POST['date'], $_POST['time'], $_POST['personLicence'], $_POST['regNum'], $_POST['statement'], $_POST['offence'])) {
    $person = clean_input($_POST['person']);
    $personID = findPersonIDByLicence($db, $person);

    $date = clean_input($_POST['date']);
    $time = clean_input($_POST['time']);
    $personLicence = clean_input($_POST['personLicence']);
    $regNum = clean_input($_POST['regNum']);
    $vehicleID = findVehicleIDByLicence($db, $regNum);

    $statement = clean_input($_POST['statement']);
    $offenceID = clean_input($_POST['offence']);


    $stmt = $db->prepare("SELECT * FROM Incident WHERE Vehicle_ID = ? AND People_ID = ? AND Incident_Date = ? AND Incident_Report = ? AND Offence_ID = ?");
    $stmt->bind_param("sssss", $vehicleID, $personID, $date, $statement, $offenceID);
    $stmt->execute();
    $result = $stmt->get_result();
    $report = $result->fetch_assoc();

    if ($result->num_rows == 0) {

        $insert_stmt = $db->prepare("INSERT INTO Incident (Vehicle_ID, People_ID, Incident_Date, Incident_Report, Offence_ID) VALUES (?, ?, ?, ?, ?)");
        $insert_stmt->bind_param("sssss", $vehicleID, $personID, $date, $statement, $offenceID);
        $insert_stmt->execute();
        $success = "Report successfully added.";
        echo $success;
    } else {
        $infoError = "Report already exists.";
        echo $infoError;
    }
}




require_once "inc/footer.php";
?>