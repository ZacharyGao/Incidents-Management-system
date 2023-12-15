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
                    $infoForFines = "<p>Please fill in all fields.</p>";
                } else {
                    addFine($db, $amount, $points, $incidentID);
                    addAuditLog($db, $_SESSION['username'], "CREATE", "Added new Fine: <strong>" . $amount . "</strong> with points: " . $points . " and incident ID: ".$incidentID."");
                    $infoForFines = "<p>Fine successfully added</p>.";
                }
            } else {
                $infoForFines = "<p>Please fill in all fields.</p>";
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


require_once "inc/footer.php";
?>