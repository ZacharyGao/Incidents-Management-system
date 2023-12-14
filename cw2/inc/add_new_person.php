<?php
// add_new_person.php
require_once "config.php";
require_once "functions.php";

echo $_SERVER["REQUEST_METHOD"];
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $personName = (empty($_POST['personName'])) ? NULL : $_POST['personName'];
    $licenceNum = (empty($_POST['licenceNum'])) ? NULL : $_POST['licenceNum'];
    $personDOB = (empty($_POST['personDOB'])) ? NULL : $_POST['personDOB'];
    $penaltyPoints = (empty($_POST['penaltyPoints'])) ? NULL : $_POST['penaltyPoints'];
    $address = (empty($_POST['address'])) ? NULL : $_POST['address'];

    if (empty($personName) || empty($licenceNum)) {
        echo "Please enter all required info.";
        exit;
    }

    if (findPersonIDByLicence($db, $licenceNum)) {
        echo "Person already exists.";
        exit;
    }

    // add person to database
    addPerson($db, $personName, $licenceNum, $address, $personDOB, $penaltyPoints,);

    // response success message
    echo "New person added successfully to database.";
    return true;
}
