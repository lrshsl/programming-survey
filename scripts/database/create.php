<?php
// Copyright 2022 lrshsl.
// Use of this source code is governed by the WTFPL
// license that can be found in the LICENSE file.

$root = $_SERVER["DOCUMENT_ROOT"];
include $root."/scripts/database/project_specific.php";

$CSV_FILE_PATH = "questions.csv";


// If there is already a connection running, nothing has to be done
if (Database::$running)
    exit();


// Else get a database instance
$db = Database::get_instance();

// Make sure the instance could successfully connect to its database
if ($db->connection == null) {
    echo "[create.php] Fatal error: Could not connect to the database<br>";
    exit();
}

prepare_tables($db);

?>
