<?php
// fine.php
include_once 'inc/config.php';
include_once 'inc/functions.php';
include_once 'inc/header.php';


if (isset($_SESSION['username'])) {
    echo "Your role is <strong>" . $_SESSION['role'] . "</strong>.<br>";

    $infoForLog = "";

    if ($_SESSION['role'] == 'Administrator') {

        if (($_SERVER["REQUEST_METHOD"] == "POST") && isset($_POST["logInfo"])) {

            if (empty($_POST["logInfo"])) {
                $infoForLog = "<p>Please enter log info.</p>";
            } else {
                $logInfo = clean_input($_POST['logInfo']);
                $log = queryAuditLog($db, $logInfo);
            }

            if (isset($_POST['showAllLogs'])) {
                $log = queryAuditLog($db, "");
            } else if (isset($_POST['logInfo'])) {
                $log = queryAuditLog($db, $_POST['logInfo']);
            }
            else {
                $infoForLog = "<p>Please enter log info.</p>";
            }
        } else {
            $infoForLog = "<p>Please enter log info.</p>";
        }

?>

        <h2>Search For User Operation Log</h2>

        <form action="" method="post" name="query_audit_log">
            <div class="form-group">

                <label for="logInfo">Audit Log:</label>

                <input type="text" class="form-control" id="logInfo" name="logInfo" placeholder="Enter log username or time or info" onkeyup='filterTable("logInfo", "Log", ["username", "operation_time", "operation_type", "details"])'>

                <div class="invalid-feedback"><?php echo $infoForLog; ?></div>

            </div>
            <button type="submit" class="btn btn-primary">Search</button>
            <button type="submit" class="btn btn-primary" name="showAllLogs">Show all logs</button>
        </form>


        <table class="table table-striped" id="searchLogsTable">
            <?php if (empty($log)) : ?>
                <p>No results found.</p>
            <?php else : ?>
                <p>Found <?php echo count($log); ?> results.</p>
                <thead>
                    <tr>
                        <th>username</th>
                        <th>operation_time</th>
                        <th>operation_type</th>
                        <th>details</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($log as $logInfo) { ?>
                        <tr>
                            <td><?php echo $logInfo["username"]; ?></td>
                            <td><?php echo $logInfo["operation_time"]; ?></td>
                            <td><?php echo $logInfo["operation_type"]; ?></td>
                            <td><?php echo $logInfo["details"]; ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            <?php endif; ?>
        </table>



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