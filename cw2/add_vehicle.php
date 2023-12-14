<?php include_once "inc/config.php"; ?>
<?php include_once "inc/header.php"; ?>
<?php include_once "inc/functions.php"; ?>

<?php
$info = $infoError = "";

if (isset($_SESSION['username'])) {

    if (
        $_SERVER["REQUEST_METHOD"] == "POST"
        && isset($_POST["type"]) && isset($_POST["colour"]) && isset($_POST["regNum"]) && isset($_POST["owner"])
    ) {

        if (empty($_POST["owner"])) {
            $infoError = "<p>Please enter owner info.</p>";
            echo $infoError;
        } else {

            $info = filter_input(INPUT_POST, "owner", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $people = queryPeople($db, $_POST["owner"]);

            if (empty($people)) {
                $infoError = "<p>Owner not found.</p>";
            } else {
                echo "<p>Found " . count($people) . " results.</p>";
                for ($i = 0; $i < count($people); $i++) {
                    echo "<p>Name: " . $people[$i]["People_name"] . ".<br> License: " . $people[$i]["People_licence"] . ".</p>";
                }
                $infoError =  "<p>Owner found: " . $people[0]["People_name"] . "</p>";
            }
        }

        if (empty($_POST["type"]) || empty($_POST["colour"]) || empty($_POST["regNum"])) {
            $infoError = "<p>Please enter all vehicle info.</p>";
        } else {

            $info = filter_input(INPUT_POST, "type", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            // $info = clean_input($_POST['type']);

            $infoError =  "<p>New vehicle added:<br>Type: " . $_POST["type"] . "<br>Colour: " . $_POST["colour"] . "<br>regNum: " . $_POST["regNum"] . "<br>owner: " . $_POST["owner"] . "</p>";

            // echo $infoError;
            // add vehicle
            addVehicle($db, $_POST["type"], $_POST["colour"], $_POST["regNum"], $_POST["owner"]);
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


        <div class="form-popup" id="newPerson">
            <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" class="form-container" id="newPersonForm">
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

                <button id="newPersonInfo" type="submit" class="btn">Confirm</button>
                <button id="closeNewOwnerButton" type="button" class="btn cancel" onclick="closeNewOwnerForm()">Cancel</button>
            </form>
        </div>

        <!-- <dialog id="newOwnerModal" class="modal">
            <div class="modal-content">
                <span class="close">&times;</span>
                <form id="newOwnerForm">
                </form>
            </div>
        </dialog> -->


        <!-- Trigger/Open The Modal -->
        <!-- <button id="openMdlBtn">Open Modal</button> -->
        <!-- <div id="myModal" class="modal">
            <div class="modal-content">
                <span class="close">&times;</span>
                <p>Some text in the Modal..</p>
            </div>
        </div> -->

        <br>
        <br>
        <label for="type">Vehicle type </label>
        <input type="text" class="form-control <?php echo $infoError ? 'is-invalid' : null; ?>" id="type" name="type">
        <label for="colour">Vehicle colour </label>
        <input type="text" class="form-control <?php echo $infoError ? 'is-invalid' : null; ?>" id="colour" name="colour">
        <label for="regNum">Vehicle licence </label>
        <input type="text" class="form-control <?php echo $infoError ? 'is-invalid' : null; ?>" id="regNum" name="regNum">

        <button type="submit" class="btn btn-primary">Add</button>
    </div>
    <div class="invalid-feedback"><?php echo $infoError; ?></div>
</form>


<?php include "inc/footer.php"; ?>