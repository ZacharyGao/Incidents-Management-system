<?php include_once("inc/config.php"); ?>
<?php include "inc/header.php"; ?>



<?php
$info = $infoError = "";

if (isset($_SESSION['username'])) {

    if (isset($_POST["info"])) {
        if (empty($_POST["info"])) {
            $infoError = "<p>Please enter vehicle registration number.</p>";
        } else {
            $info = filter_input(INPUT_POST, "info", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $infoError =  "<p>You searched for: " . $_POST["info"] . "</p>";
            // search vehicle
            $vehicle = queryVehicle($db, $_POST["info"]);
        }
    }
} else {
    pleaseLogin();
}
?>

<!-- form to search vehicle -->
<form action="search_vehicle.php" method="post" name="query_vehicle">
    <div class="form-group">
        <label for="name">Search Vehicle:</label>
        <input type="text" class="form-control <?php echo $infoError ? 'is-invalid' : null; ?>" id="regNum" name="info" placeholder="Enter vehicle registration number">
        <div class="invalid-feedback"><?php echo $infoError; ?></div>
    </div>
    <button type="submit" class="btn btn-primary">Search</button>
</form>

<!-- table to show vehicle info -->
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h2>Query Results:</h2>
            <?php if (empty($vehicle)) : ?>
                <p>No results found.</p>
            <?php else : ?>
                <p>Found <?php echo count($vehicle); ?> results.</p>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Vehicle_ID</th>
                            <th>Vehicle_type</th>
                            <th>Vehicle_colour</th>
                            <th>Vehicle_licence</th>
                            <th>Owner_name</th>
                            <th>Owner_licence</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($vehicle as $vehicleInfo) { ?>
                            <tr>
                                <td><?php echo $vehicleInfo["Vehicle_ID"]; ?></td>
                                <td><?php echo $vehicleInfo["Vehicle_type"]; ?></td>
                                <td><?php echo $vehicleInfo["Vehicle_colour"]; ?></td>
                                <td><?php echo $vehicleInfo["Vehicle_licence"]; ?></td>
                                <td><?php echo $vehicleInfo["People_name"]; ?></td>
                                <td><?php echo $vehicleInfo["People_licence"]; ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
    </div>
</div>



<?php include "inc/footer.php"; ?>