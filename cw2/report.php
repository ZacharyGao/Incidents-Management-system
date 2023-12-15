<?php
require_once "inc/config.php";
require_once "inc/functions.php";
require_once "inc/header.php";


if (isset($_SESSION['username'])) {


    $infoForAddReport = $infoError = "";

    if (isset($_SESSION['addedPersonName'])) {

        $addNewPersonInfo = "<p>New person <strong>" . $_SESSION['addedPersonName'] . "</strong> added successfully to database.</p>";
    } else {
        $addNewPersonInfo = "";
    }

    // add new report
    if (
        $_SERVER["REQUEST_METHOD"] == "POST"
        && isset($_POST['person']) && isset($_POST['date']) && isset($_POST['time']) && isset($_POST['regNum']) && isset($_POST['statement']) && isset($_POST['offence'])
    ) {

        $person = clean_input($_POST['person']);
        $personID = findPersonIDByLicence($db, $person);
        if (empty($personID)) {
            $infoForAddReport = "<p>Please add this person first.<br></p>";
            echo $infoForAddReport;
        } else {

            $regNum = clean_input($_POST['regNum']);
            $vehicleID = findVehicleIDByLicence($db, $regNum);

            if (empty($vehicleID)) {
                $infoForAddReport =  "<p>Please add this vehicle first. <a href='add_vehicle.php'>Add Vehicle</a><br></p>";
                echo $infoForAddReport;
            } else {
                $date = clean_input($_POST['date']);
                $time = clean_input($_POST['time']);
                $statement = clean_input($_POST['statement']);
                $offenceID = clean_input($_POST['offence']);

                if (empty($date) || empty($time) || empty($statement) || empty($offenceID)) {
                    $infoForAddReport = "<p>Please fill in all fields.</p>";
                } else {
                    addIncident($db, $vehicleID, $personID, $date, $statement, $offenceID);
                    addAuditLog($db, $_SESSION['username'], "CREATE", "Added new Incident: <strong>" . $statement . "</strong> with offence ID: " . $offenceID . "");
                    $infoForAddReport = "<p>Report successfully added.</p>";
                }
            }
        }
    } else {
        $infoForAddReport = "<p>Please fill in all fields.</p>";
    }

    // search report
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['report'])) {
        $report = clean_input($_POST['report']);
        $incident = queryIncident($db, $report);
        
        addAuditLog($db, $_SESSION['username'], "RETRIEVE", "Searched for Incident: <strong>" . $report . "</strong>");
    }
} else {
    pleaseLogin();
}
?>

<h2>Add New Report</h2>

<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" name="add_vehicle">
    <div class="form-group">

        <label for="ownerAutocomplete">Person <span style="color: red;">*</span></label>
        <div class="autocomplete">
            <input id="ownerAutocomplete" type="text" name="person" placeholder="Person" style="display:inline;width:70%">
            <button type="button" onclick="openNewOwnerForm()" style="padding:2px;margin:0rem 1rem;">Add New Person</button>
            <div class="feedback-container" id="addNewPersonInfo" name="addNewPersonInfo"><?php echo $addNewPersonInfo; ?></div>
        </div>

        <label for="date">Date <span style="color:red;">*</span></label>
        <input type="date" class="form-control <?php echo $infoForAddReport ? 'is-invalid' : null; ?>" id="date" name="date">

        <label for="time">Time <span style="color:red;">*</span></label>
        <input type="time" class="form-control <?php echo $infoForAddReport ? 'is-invalid' : null; ?>" id="time" name="time">

        <label for="regNum">Vehicle Plate Number <span style="color:red;">*</span></label>
        <input type="text" class="form-control <?php echo $infoForAddReport ? 'is-invalid' : null; ?>" id="regNum" name="regNum">

        <br>
        <label for="statement">statement <span style="color: red;">*</span></label>
        <textarea type="textarea" class="form-control> <?php echo $infoForAddReport ? 'is-invalid' : null; ?>" id="statement" name="statement">
        </textarea>

        <label for="offence">Offence Type <span style="color:red;">*</span></label>
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
    <div class="invalid-feedback"><?php echo $infoForAddReport; ?></div>
</form>


<div class="modal" id="newPerson">
    <span onclick="document.getElementById('modalForAddPersonID').style.display='none'" class="close" title="Close Modal">&times;</span>

    <form action="" method="post" class="modal-content" id="newPersonForm" name="newPersonForm">
        <div class="container">

            <h3>New Person</h3>

            <label for="personName"><b>personName </b><span style="color:red;">*</span></label>
            <input type="text" placeholder="Enter personName" id="personName">

            <label for="licenceNum"><b>licenceNum </b><span style="color:red;">*</span></label>
            <input type="text" placeholder="Enter licenceNum" id="licenceNum">

            <label for="personDOB"><b>Date of Birth</b></label>
            <input type="text" id="personDOB">

            <label for="penaltyPoints"><b>penaltyPoints</b></label>
            <input type="text" id="penaltyPoints">

            <label for="address"><b>address</b></label>
            <input type="text" id="address">

            <button id="newPersonInfo" type="submit" name="submit" class="btn">Confirm</button>
            <button id="closeNewOwnerButton" type="button" class="btn cancel" onclick="closeNewOwnerForm()">Cancel</button>
        </div>

    </form>
</div>




<br>
<br>
<br>
<h2>Search Report</h2>
<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" name="query_report">
    <div class="form-group">
        <label for="report">Search Report:</label>
        <input type="text" class="form-control <?php echo $infoError ? 'is-invalid' : null; ?>" id="report" name="report" placeholder="Enter date or report statement">
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