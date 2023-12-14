<?php
// session_start();
include_once("inc/config.php");
include_once "inc/functions.php";


$info = "";
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["username"]) && isset($_POST["password"])) {
    $username = clean_input($_POST['username']);
    $password = clean_input($_POST['password']);

    if (empty($username) || empty($password)) {
        $info = "<p>Please enter your name and password.</p>";
    } else {
        login($db, $username, $password);
        $info =  $LoginError;
        // header("Location: search_people.php"); // redirect
    }
}
require_once "inc/header.php";
?>


<!-- login form -->
<form action="login.php" method="post" name="login">
    <div class="form-group">
        <label for="name">Login:</label>
        <input type="text" class="form-control <?php echo $info ? 'is-invalid' : null; ?>" id="name" name="username" placeholder="Enter your name">
    </div>
    <div class="form-group">
        <label for="password">Password:</label>
        <input type="text" class="form-control" id="password" name="password" placeholder="Enter your password">
    </div>
    <div class="invalid-feedback"><?php echo $info; ?></div>
    <button type="submit" class="btn btn-primary">Login</button>
</form>

<!-- login function -->
<?php
?>

<?php include "inc/footer.php"; ?>