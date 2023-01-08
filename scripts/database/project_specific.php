<?php
// Copyright 2022 lars.
// Use of this source code is governed by the WTFPL
// license that can be found in the LICENSE file.


$root = $_SERVER["DOCUMENT_ROOT"]."/lrs/programming_survey/";
require $root."scripts/database/database.php";
require $root."scripts/database/create_table_commands.php";


function prepare_tables($db, $reset = false) {
    global $create_table_commands;

    // If reset is set to true, all tables have to be dropped.
    // Since we won't need any foreign key checks, which would
    // stop the drop process if the tables aren't dropped in the right
    // order, those checks are temporarily disabled
    if ($reset) {
        $db->execute("SET FOREIGN_KEY_CHECKS = 0;");
    }

    // Iterate through the table names and
    // the according creation commands
    foreach ($create_table_commands as $table_name => $cmd) {
        
        // Delete table if specified so
        if ($reset)
            $db->delete_table($table_name);

        // Create the table new
        $db->execute($cmd);

    }

    // Turn foreign key checks back on
    if ($reset) {
        $db->execute("SET FOREIGN_KEY_CHECKS = 1;");
    }
}

function add_user($db, $username, $age) {

    // Double check that the username is unique
    if ($db->is_in_table("users", "username", $username)) {
        add_message("[Shouldn't get called]User ".$username." is already in the database");
        return;
    }

    // Strings must be enclosed in double quotes
    $quoted_name = '"'.$username.'"';

    // Instert the credentials
    $db->insert("users", "username, age", $quoted_name.", ".$age);

    return true;
}

?>
