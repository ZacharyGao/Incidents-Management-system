<?php
require_once "inc/config.php";
require_once "inc/functions.php";
require_once "inc/header.php";


if (isset($_SESSION['username'])) {

    $error = '';
    $success = '';


    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['current_password'], $_POST['new_password'])) {
        $current_password = clean_input($_POST['current_password']);
        $new_password = clean_input($_POST['new_password']);

        $username = $_SESSION['username'];

        $stmt = $db->prepare("SELECT Police_password FROM Police WHERE Police_username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        if ($current_password == $user['Police_password']) {
            $update_stmt = $db->prepare("UPDATE Police SET Police_password = ? WHERE Police_username = ?");
            $update_stmt->bind_param("ss", $new_password, $username);
            $update_stmt->execute();
            $success = "Password successfully updated. Your new password is: " . $new_password . ".";
        } else {
            $error = "Current password is incorrect.";
        }
    }
} else {

    pleaseLogin();
}

?>


<form action="" method="post">
    Current Password: <input type="text" name="current_password"><br>
    New Password: <input type="text" name="new_password"><br>
    <input type="submit" value="Change Password">
</form>


<?php if ($error) : ?>
    <p style="color: red;"><?php echo $error; ?></p>
<?php endif; ?>
<?php if ($success) : ?>
    <p style="color: green;"><?php echo $success; ?></p>
<?php endif; ?>


<?php require_once "inc/footer.php";
