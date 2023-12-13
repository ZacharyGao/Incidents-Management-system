<?php
require_once "inc/config.php";
require_once "inc/functions.php";
require_once "inc/header.php";
?>

<?php
// user info and login status display and valid operations
if (isset($_SESSION['username'])) {
    echo "<p>Login as <strong>" . $_SESSION['username'] . "</strong> successful. You can now execute queries.</p>";
    echo "Your role is <strong>" . $_SESSION['role'] . "</strong>.";

?>

    <ul>
        <li><a href="index.php">CW2</a></li>
        <li><a href="dashboard.php">Dashboard</a></li>
        <li><a href="search_people.php">People</a></li>
        <li><a href="search_vehicle.php">Vehicle</a></li>
        <li><a href="add_vehicle.php">AddVehicle</a></li>
        <li><a href="report.php">Report</a></li>

        <?php
        if (isset($_SESSION['role']) && $_SESSION['role'] == 'Administrator') {
        ?>
            <li><a href="search_fine.php">Fine</a></li>
            <li><a href="search_audit.php">Audit</a></li>
            <li><a href="add_police.php">Add Police User</a></li>
        <?php } else {
        } ?>

        <?php if (isset($_SESSION['username'])) { ?>
            <li style="float:bottom"><a href="logout.php" class="split">Logout</a></li>
        <?php } else { ?>
            <li style="float:right"><a href="login.php" class="split">Login</a></li>
        <?php } ?>
    </ul>



    <?php
    if ($_SESSION['role'] == 'Administrator') {
    ?>
        <p><a href="search_fine.php">Fine</a></p>
        <p><a href="search_audit.php">Audit</a></p>
        <p><a href="add_police.php">Add Police User</a></p>
        <p><a href="logout.php">Logout</a></p>
    <?php
    }
    ?>
    <p><a href="change_pw.php">Change Password</a></p>
    <p><a href="logout.php">Logout</a></p>
<?php
} else {
    pleaseLogin();
}

require_once "inc/footer.php";
