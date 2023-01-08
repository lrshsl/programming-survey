<?php

// Copyright 2023 lrshsl.
// Use of this source code is governed by the WTFPL
// license that can be found in the LICENSE file.


// Database is required
require "../create.php";


$core_tests = [
    
    // Test that checks the connection 
    function($db) {
        if (!isset($db) || $db == null)
            return "Failed: Could not get an instance/singleton";

        if (!isset($db->connection) || $db->testing_instance == null)
            return "Failed: Could not connect";
        
        if (!isset($db->running) || $db->testing_instance == false)
            return "Failed: Database isn't running";
        
        return "Success";
    },

    // Test that checks reset functionality
    function($db) {

        // First reset the database
        prepare_tables($db, true);

        // Collect all entries in one array
        $all_entries = [];

        // Run 'SELECT *' on all tables
        foreach ($table_names as $table) {

            // Append the result to the array '$all_entries'
            array_push($all_entries, $db->get_elements($table));
        }

        // Database is only empty when there are no entries
        $is_empty = count($all_entries) == 0;

        // Return if it isn't empty
        if (!$is_empty)

            // Write a message
            $msg = "Failed: Resetted the database but it is not empty<br>Found: ";

            // Add the entries found
            foreach ($all_entries as $entry)
                $msg .= $entry." ";
            
            // Return the message
            return $msg;
        
        // If it didn't return until here it must be a success
        return "Success";
    },

    // Test that checks the 'prepare_tables' function

    // Test that checks the insert and select functions
    function($db) {

        // First reset the database
        prepare_tables($db, true);
    }
]


?>