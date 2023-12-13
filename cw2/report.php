<?php
require_once "inc/config.php";
require_once "inc/functions.php";
require_once "inc/header.php";

$infoError = "";
?>

<h2>Add New Report</h2>

<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" name="add_vehicle">
    <div class="form-group">


        <label for="person">Person <span style="color: red;">*</span></label>
        <div class="autocomplete">
            <input id="myInput" type="text" name="person" placeholder="Person" style="display:inline;width:70%">
            <button type="button" onclick="openNewOwnerForm()" style="padding:2px;margin:0rem 1rem;">Add New Person</button>
        </div>

        <label for="date">Date <span style="color:red;">*</span></label>
        <input type="text" class="form-control <?php echo $infoError ? 'is-invalid' : null; ?>" id="date" name="date">

        <label for="time">Time <span style="color:red;">*</span></label>
        <input type="text" class="form-control <?php echo $infoError ? 'is-invalid' : null; ?>" id="time" name="time">

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


<?php include "inc/footer.php"; ?>