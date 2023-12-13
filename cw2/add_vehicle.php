<?php include_once "inc/config.php"; ?>
<?php include_once "inc/header.php"; ?>
<?php include_once "inc/functions.php"; ?>

<?php
$info = $infoError = "";

if (isset($_SESSION['username'])) {

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["type"]) && isset($_POST["colour"]) && isset($_POST["regNum"]) && isset($_POST["owner"])) {

        if (empty($_POST["owner"])) {
            $infoError = "<p>Please enter owner info.</p>";
        } else {
            $info = filter_input(INPUT_POST, "owner", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            // $info = clean_input($_POST['owner']);
            $people = queryPeople($db, $_POST["owner"]);
            if (empty($people)) {
                $infoError = "<p>Owner not found.</p>";
            } else {
                echo "<p>Found " . count($people) . " results.</p>";
                for ($i = 0; $i < count($people); $i++) {
                    echo "<p>Found " . $people[$i]["People_name"] . " results.</p>";
                }
                $infoError =  "<p>Owner found: " . $people[0]["People_name"] . "</p>";
            }
        }

        // if (empty($_POST["type"]) || empty($_POST["colour"]) || empty($_POST["regNum"])) {
        //     $infoError = "<p>Please enter all vehicle info.</p>";
        // } else {
        //     $info = filter_input(INPUT_POST, "type", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        //     // $info = clean_input($_POST['type']);

        //     $infoError =  "<p>New vehicle added:<br>Type: " . $_POST["type"] . "<br>Colour: " . $_POST["colour"] . "<br>regNum: " . $_POST["regNum"] . "<br>owner: " . $_POST["owner"] . "</p>";
        //     // add vehicle
        //     // echo $infoError;
        //     addVehicle($db, $_POST["type"], $_POST["colour"], $_POST["regNum"], $_POST["owner"]);
        // }
    } else {
        $infoError = "<p>Please enter all vehicle info.</p>";
    }
} else {
    pleaseLogin();
}
?>

<!-- form to add vehicle -->
<h2>Add New Vehicle</h2>

<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" name="add_vehicle">
    <div class="form-group">
        <label for="Owner">Owner <span style="color: red;">*</span></label>

        <!-- <div autocomplete="off" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>"> -->
        <div class="autocomplete">
            <input id="myInput" type="text" name="ownerName" placeholder="owner" style="display:inline;width:70%">
            <button type="button" onclick="openNewOwnerForm()" style="padding:2px;margin:0rem 1rem;">New Owner</button>
        </div>
        <!-- <input type="submit" style="padding:2px"> -->
        <!-- </div> -->


        <!-- <div class="textwithbutton">
            <input type="text" id="owner" name="owner" onkeyup="showMatches(this.value)" class="form-control">
            <button type="button" onclick="openNewOwnerForm()" style="padding:2px;margin:0rem 2rem;">New Owner</button>
            <div id="ownerMatches" class="autocomplete"></div>
        </div> -->

        <!-- <button type="button" onclick="openNewOwnerForm()" style="padding:0">New Owner</button> -->

        <!-- <dialog id="newOwnerModal" class="modal">
            <div class="modal-content">
                <span class="close">&times;</span>
                <form id="newOwnerForm">
                </form>
            </div>
        </dialog> -->
        <br>
        <br>
        <label for="type">Vehicle type </label>
        <input type="text" class="form-control <?php echo $infoError ? 'is-invalid' : null; ?>" id="type" name="type">
        <label for="colour">Vehicle colour </label>
        <input type="text" class="form-control <?php echo $infoError ? 'is-invalid' : null; ?>" id="colour" name="colour">
        <label for="regNum">Vehicle ID </label>
        <input type="text" class="form-control <?php echo $infoError ? 'is-invalid' : null; ?>" id="regNum" name="regNum">

    </div>
    <button type="submit" class="btn btn-primary">Add</button>
    <div class="invalid-feedback"><?php echo $infoError; ?></div>
</form>


<?php include "inc/footer.php"; ?>