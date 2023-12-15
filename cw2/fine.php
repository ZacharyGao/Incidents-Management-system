<?php
// fine.php
include_once 'inc/config.php';
include_once 'inc/functions.php';
include_once 'inc/header.php';


if (isset($_SESSION['username'])) {
    echo "Your role is <strong>" . $_SESSION['role'] . "</strong>.<br>";

    if ($_SESSION['role'] == 'Administrator') {

        $infoForFines = "";

        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['amount'], $_POST['points'], $_POST['incidentID'])) {
                
                $amount = clean_input($_POST['amount']);
                $points = clean_input($_POST['points']);
                $incidentID = clean_input($_POST['incidentID']);
    
                if (empty($amount) || empty($points) || empty($incidentID)) {
                    $infoForFines = "Please fill in all fields.";
                } else {
                    addFine($db, $amount, $points, $incidentID);
                    $infoForFines = "Fine successfully added.";
                }
            } else {
                $infoForFines = "Please fill in all fields.";
            }
            
?>

        <h2>Add a fine with an incident</h2>

        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" name="add_fine">
            <div class="form-group">

                <label for="amount">Fine Amount <span style="color:red;">*</span></label>
                <input type="text" class="form-control" id="amount" name="amount">

                <label for="points">Fine Points <span style="color:red;">*</span></label>
                <input type="text" class="form-control" id="points" name="points">

                <br>

                <label for="incidentID">Select Incident <span style="color:red;">*</span></label>
                <select name="incidentID" id="incidentID" style="width:80%">
                    <?php
                    $incident = queryIncident($db, "");
                    foreach ($incident as $inc) {
                        echo "<option value='" . $inc["Incident_ID"] . "'>" . $inc["Incident_ID"] . ": " . $inc["Incident_Report"] . "</option>";
                    }
                    ?>
                </select>

            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
            <div class="invalid-feedback"><?php echo $infoForFines; ?></div>
        </form>


    <?php
    } else {
        echo "<p>You are not an administrator.</p>";
    }
    ?>

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