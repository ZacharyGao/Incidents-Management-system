<?php
include_once("inc/config.php");
include_once("inc/functions.php");

$info = filter_input(INPUT_POST, "info", FILTER_SANITIZE_FULL_SPECIAL_CHARS);

if (!empty($info)) {
    $people = queryPeople($db, $info);
    // generate table

    if (!empty($people)) {
        echo "<p>Found " . count($people) . " results.</p>";

        // generate table header
        echo "
        <table class='table table-striped'>
        <thead>
        <tr>
            <th>People_ID</th>
            <th>People_name</th>
            <th>People_address</th>
            <th>People_license</th>
        </tr>
        </thead>
        <tbody>";
        // generate table rows
        foreach ($people as $person) {
            echo "<tr><td>{$person['People_ID']}</td>";
            echo "<td>{$person['People_name']}</td>";
            echo "<td>{$person['People_address']}</td>";
            echo "<td>{$person['People_licence']}</td></tr>";
        }
        echo "</tbody></table>";
    } else {
        echo "<p>No results found.</p>";
        echo "<p>Do you want to add this person to the database? </p>";
        echo "<a href='add_person.php'>Add Person</a>";
    }
} else {
    echo "<p>Please enter a name or licence number.</p>";
}
