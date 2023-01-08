<?php

// Copyright 2023 lrshsl.
// Use of this source code is governed by the WTFPL
// license that can be found in the LICENSE file.


// Database is required
require "../create.php";


// Collection of tests
$core_tests = [

    // Some basic tests
    function($db) {

        // Count the errors
        $num_errors = 0;

        // If connecting failed, return
        if ($db->connection == null)
            return "Failed: Could not connect";

        // First reset the database
        prepare_tables($db, true);

        // Collect 'SELECT *' from each table
        $all_entries = [];
        foreach ($table_names as $table) {
            array_push($all_entries, $db->get_elements($table));
        }

        // Return if there is an entry
        if (count($all_entries) != 0)
            return "Failed: Resetting the database didn't clear it<br>Found: ".$all_entries;
    },

    function($db) {
        return "Success";
    }
]


?>