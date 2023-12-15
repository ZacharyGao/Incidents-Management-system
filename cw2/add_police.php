<?php
// add_police.php
require_once "inc/config.php";
require_once "inc/functions.php";
require_once "inc/header.php";


if (isset($_SESSION['username'])) {
    echo "<p>Login as <strong>" . $_SESSION['username'] . "</strong> successful. You can now execute queries.</p>";
    echo "Your role is <strong>" . $_SESSION['role'] . "</strong>.<br><br>";

    if ($_SESSION['role'] == 'Administrator') {

        $error = '';
        $success = '';


        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['new_username'], $_POST['new_password'], $_POST['police_role'])) {

            $new_username = clean_input($_POST['new_username']);
            $new_password = clean_input($_POST['new_password']);
            $police_role = clean_input($_POST['police_role']);

            $stmt = $db->prepare("SELECT * FROM Police WHERE Police_username = ?");
            $stmt->bind_param("s", $new_username);
            $stmt->execute();
            $result = $stmt->get_result();
            $user = $result->fetch_assoc();

            if ($result->num_rows == 0) {

                $insert_stmt = $db->prepare("INSERT INTO Police (Police_username, Police_password, Police_role) VALUES (?, ?, ?)");
                $insert_stmt->bind_param("sss", $new_username, $new_password, $police_role);
                $insert_stmt->execute();
                $success = "User successfully added. New username is: " . $new_username . "." . " New password is: " . $new_password . ".";

                addAuditLog($db, $_SESSION['username'], "CREATE", "Added new Police User: <strong>" . $new_username . "</strong> with role: <strong>" . $police_role . "</strong>");
            } else {
                $error = "User already exists.";
            }
        }
?>

        <form action="" method="post" style="margin:2rem 0rem;">
            <label for="new_username">New Police Username:</label>
            <input type="text" name="new_username" id="new_username"><br>
            <label for="new_password">Password:</label>
            <input type="text" name="new_password" id="new_password"><br>
            <label for="police_role">Role:</label>
            <select name="police_role" id="police_role">
                <option value="Administrator">Administrator</option>
                <option value="Police">Police Officer</option>
            </select>
            <br>

            <input type="submit" value="Add">
        </form>

<?php
        if ($error) {
            echo '<p style="color: red;">' .  $error . '</p>';
        }
        if ($success) {
            echo '<p style="color: green;">' . $success . '</p>';
        }
    } else {
        echo "<p>You are not an administrator.</p>";

    }
} else {
    pleaseLogin();
}
?>




<?php require_once "inc/footer.php";
