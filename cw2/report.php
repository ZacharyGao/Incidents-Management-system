<?php
require_once "inc/config.php";
require_once "inc/functions.php";
require_once "inc/header.php";

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


// search report
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['report'])) {
    $report = clean_input($_POST['report']);
    $incident = queryIncident($db, $report);
}

?>

<h2>Add New Report</h2>

<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" name="add_vehicle">
    <div class="form-group">


        <label for="ownerAutocomplete">Person <span style="color: red;">*</span></label>
        <div class="autocomplete">
            <input id="ownerAutocomplete" type="text" name="person" placeholder="Person" style="display:inline;width:70%">
            <button type="button" onclick="openNewOwnerForm()" style="padding:2px;margin:0rem 1rem;">Add New Person</button>
        </div>

        <label for="date">Date <span style="color:red;">*</span></label>
        <input type="date" class="form-control <?php echo $infoError ? 'is-invalid' : null; ?>" id="date" name="date">

        <label for="time">Time <span style="color:red;">*</span></label>
        <input type="time" class="form-control <?php echo $infoError ? 'is-invalid' : null; ?>" id="time" name="time">

        <label for="personLicence">Person Licence <span style="color:red;">*</span></label>
        <input type="text" class="form-control <?php echo $infoError ? 'is-invalid' : null; ?>" id="personLicence" name="personLicence">

        <label for="regNum">Vehicle Plate Number <span style="color:red;">*</span></label>
        <input type="text" class="form-control <?php echo $infoError ? 'is-invalid' : null; ?>" id="regNum" name="regNum">

        <br>
        <label for="statement">statement <span style="color: red;">*</span></label>
        <textarea type="textarea" class="form-control> <?php echo $infoError ? 'is-invalid' : null; ?>" id="statement" name="statement">
        </textarea>

        <label for="offence">Offence Type</label>
        <select name="offence" id="offence" style="width:50%">
            <?php
            $offences = queryOffences($db, "");
            foreach ($offences as $off) {
                echo "<option value='" . $off["Offence_ID"] . "'>" . $off["Offence_ID"] . ": " . $off["Offence_description"] . "</option>";
            }
            ?>
        </select>

    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
    <div class="invalid-feedback"><?php echo $infoError; ?></div>
</form>

<br>
<br>
<br>
<h2>Search Report</h2>
<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" name="query_report">
    <div class="form-group">
        <label for="report">Search Report:</label>
        <input type="text" class="form-control <?php echo $infoError ? 'is-invalid' : null; ?>" id="report" name="report" placeholder="search">
        <div class="invalid-feedback"><?php echo $infoError; ?></div>
    </div>
    <button type="submit" class="btn btn-primary">Search</button>
</form>





<table class="table table-striped" id="searchIncidentTable">
    <?php if (empty($incident)) : ?>
        <p>No results found.</p>
    <?php else : ?>
        <p>Found <?php echo count($incident); ?> results.</p>
        <thead>
            <tr>
                <th>Vehicle_licence</th>
                <th>People_name</th>
                <th>People_licence</th>
                <th>Incident_Date</th>
                <th>Incident_Report</th>
                <th>Offence_description</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($incident as $incidentInfo) { ?>
                <tr>
                    <td><?php echo $incidentInfo["Vehicle_licence"]; ?></td>
                    <td><?php echo $incidentInfo["People_name"]; ?></td>
                    <td><?php echo $incidentInfo["People_licence"]; ?></td>
                    <td><?php echo $incidentInfo["Incident_Date"]; ?></td>
                    <td><?php echo $incidentInfo["Incident_Report"]; ?></td>
                    <td><?php echo $incidentInfo["Offence_description"]; ?></td>
                </tr>
            <?php } ?>
        </tbody>
    <?php endif; ?>
</table>



<?php include "inc/footer.php"; ?>