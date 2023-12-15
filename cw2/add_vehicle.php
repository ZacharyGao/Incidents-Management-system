<?php include_once "inc/config.php"; ?>
<?php include_once "inc/header.php"; ?>
<?php include_once "inc/functions.php"; ?>

<?php
$info = $infoError = "";

if (isset($_SESSION['username'])) {

    if (isset($_SESSION['addedPersonName'])) {
        
        $addNewPersonInfo = "<p>New person <strong>" . $_SESSION['addedPersonName'] . "</strong> added successfully to database.</p>";
    
    }else{
        $addNewPersonInfo = "";
    }

    if (
        $_SERVER["REQUEST_METHOD"] == "POST"
        && isset($_POST["type"]) && isset($_POST["colour"]) && isset($_POST["regNum"]) && isset($_POST["owner"])
    ) {

        if (empty($_POST["owner"])) {
            $infoError = "<p>Please enter owner info.</p>";
            // echo $infoError;
        } else {

            $info = filter_input(INPUT_POST, "owner", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $people = queryPeople($db, $_POST["owner"]);

            if (empty($people)) {
                $infoError = "<p>Owner not found. Please add this person first</p>";
                // echo $infoError;
            } else if (count($people) > 1) {
                // echo "<p>Found " . count($people) . " owner results.</p>";

                for ($i = 0; $i < count($people); $i++) {
                    // echo "<p>Name: " . $people[$i]["People_name"] . ".<br> License: " . $people[$i]["People_licence"] . ".</p>";
                }

                $infoError =  "<p>More than 1 person found. Please check.</p>";
                // echo $infoError;
            } else {
                // echo "<p>Found this person. Adding vehicle.</p>";
                for ($i = 0; $i < count($people); $i++) {
                    // echo "<p>Name: " . $people[$i]["People_name"] . ".<br> License: " . $people[$i]["People_licence"] . ".</p>";
                }
                $infoError =  "<p>Owner found: " . $people[0]["People_name"] . "</p>";
                // echo $infoError;


                // add vehicle
                if (empty($_POST["type"]) || empty($_POST["colour"]) || empty($_POST["regNum"])) {
                    $infoError = "<p>Please enter all vehicle info.</p>";
                } else {

                    $info = filter_input(INPUT_POST, "type", FILTER_SANITIZE_FULL_SPECIAL_CHARS);

                    $infoError =  "<p>New vehicle added:<br>Type: " . $_POST["type"] . "<br>Colour: " . $_POST["colour"] . "<br>regNum: " . $_POST["regNum"] . "<br>owner: " . $_POST["owner"] . "</p>";

                    // echo $infoError;
                    // add vehicle
                    addVehicle($db, $_POST["type"], $_POST["colour"], $_POST["regNum"], $_POST["owner"]);
                    addAuditLog($db, $_SESSION['username'], "CREATE", "added new <strong>Vehicle</strong> with plate number: '<strong>".$_POST["regNum"]."'</strong>");
                }
            }
        }
    } else {
        $infoError = "<p>Please enter all required info.</p>";
    }
} else {
    pleaseLogin();
}
?>

<!-- form to add vehicle -->
<h2>Add New Vehicle</h2>

<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" name="add_vehicle">
    <div class="form-group">
        <label for="ownerAutocomplete">Owner <span style="color: red;">*</span></label>

        <div class="autocomplete">
            <input id="ownerAutocomplete" type="text" name="owner" placeholder="person" style="display:inline;width:70%">
            <button id="newOwnerButton" type="button" onclick="openNewOwnerForm()" style="padding:2px;margin:0rem 1rem;">New Person</button>
        </div>
        <div class="feedback-container" id="addNewPersonInfo" name="addNewPersonInfo"><?php echo $addNewPersonInfo; ?></div>

        <br>
        <label for="type">Vehicle type <span style="color:red;">*</span></label>
        <input type="text" class="form-control <?php echo $infoError ? 'is-invalid' : null; ?>" id="type" name="type">
        <label for="colour">Vehicle colour <span style="color:red;">*</span></label>
        <input type="text" class="form-control <?php echo $infoError ? 'is-invalid' : null; ?>" id="colour" name="colour">
        <label for="regNum">Vehicle licence <span style="color:red;">*</span></label>
        <input type="text" class="form-control <?php echo $infoError ? 'is-invalid' : null; ?>" id="regNum" name="regNum">

        <button type="submit" class="btn btn-primary">Add</button>
    </div>
    <div class="invalid-feedback"><?php echo $infoError; ?></div>
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

<?php include "inc/footer.php"; ?>