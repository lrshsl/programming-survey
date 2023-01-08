<?php
// Copyright 2022 lrshsl.
// Use of this source code is governed by the WTFPL
// license that can be found in the LICENSE file.

$root = $_SERVER["DOCUMENT_ROOT"]."/lrs/programming_survey/";
include $root."scripts/database/project_specific.php";


// If there is already a connection running, nothing has to be done
if (isset($db->instance) && $db->instance)
    exit();

// Get a database singleton of the class Database
$db = Database::get_instance();

// Make sure the instance could successfully connect to its database
if ($db->connection == null) {
    echo "[create.php] Fatal error: Could not connect to the database<br>";
    exit();
}

// Create the tables if they don't exist yet
prepare_tables($db);

?>
