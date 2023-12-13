<?php include_once("inc/config.php"); ?>
<?php include_once "inc/header.php"; ?>

<?php
$info = $infoError = "";

if (isset($_SESSION['username'])) {

    // form validation
    if (isset($_POST["info"])) {
        if (empty($_POST["info"])) {
            $infoError = "<p>Please enter name or licence info.</p>";
        } else {
            $info = filter_input(INPUT_POST, "info", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $infoError =  "<p>You searched for: " . $_POST["info"] . "</p>";
            // search people
            $people = queryPeople($db, $_POST["info"]);
        }
    }
    $people = [];
    if (isset($_POST["showAllPeople"])) {
        $people = queryPeople($db, "");
    }
} else {
    pleaseLogin();
}
?>


<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" name="query_people">
    <div class="form-group">
        <label for="name">Search People:</label>
        <input type="text" class="form-control <?php echo $infoError ? 'is-invalid' : null; ?>" id="name" name="info" placeholder="Enter name or licence" onkeyup='filterTable("name", "searchPeople", ["People_name", "People_license"])'>
        <div class="invalid-feedback"><?php echo $infoError; ?></div>
    </div>
    <button type="submit" class="btn btn-primary">Search</button>
    <button type="submit" class="btn btn-primary" name="showAllPeople">Show all people</button>
</form>

<form method="post" style="border:none; box-shadow:none;margin:0;padding:0;">
    <button type="submit" class="btn btn-primary" name="showAllPeople" style="padding:1%">Show all people</button>
</form>


<!-- table to show people info -->
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <!-- <h2>Query Results:</h2> -->
            <?php if (empty($people)) : ?>
                <!-- <p>Please enter people's name or licences</p> -->
            <?php else : ?>
                <p>Found <?php echo count($people); ?> results.</p>
                <table class="table table-striped" id="searchPeople">
                    <thead>
                        <tr>
                            <th>People_ID</th>
                            <th>People_name</th>
                            <th>People_address</th>
                            <th>People_license</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($people as $person) { ?>
                            <tr>
                                <td><?php echo $person["People_ID"]; ?></td>
                                <td><?php echo $person["People_name"]; ?></td>
                                <td><?php echo $person["People_address"]; ?></td>
                                <td><?php echo $person["People_licence"]; ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
    </div>
</div>



<?php include "inc/footer.php"; ?>