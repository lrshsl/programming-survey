<?php

// Copyright 2023 lrshsl.
// Use of this source code is governed by the WTFPL
// license that can be found in the LICENSE file.


// Database is required
require "../create.php";


$core_tests = [
    
    // Test that checks the connect/disconnect functionality
    function($db) {

        // Make sure it is connected
        if (!isset($db) || $db == null)
            return "Failed: Could not get an instance/singleton";

        if (!isset($db->connection) || $db->connection == null)
            return "Failed: Could not connect";

        // Disconnect, but keep the instance
        $db->disconnect();

        // Make sure it is disconnected
        if ($db->running == true
            || $db->connection != null)
            return "Failed: Database is still active after deconnecting";
        
        // Connect again
        $db->connection = $db->get_new_connection(Database::TESTING_SERVER, Database::TESTING_DATABASE,
            Database::TESTING_USERNAME, Database::TESTING_PASSWORD);
        
        if (!isset($db->connection) || $db->connection == null)
            return "Failed: Couldn't reconnect";

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
        if (!$is_empty) {
            
            // Write a message
            $msg = "Failed: Resetted the database but it is not empty<br>Found: ";
        
            // Add the entries found
            foreach ($all_entries as $entry) {
                $msg .= $entry." ";
            }
        
            // Return the message
            return $msg;
        }
        
        // If it didn't return until here it must be a success
        return "Success";
    },

    // Test that checks the 'prepare_tables' function

    // Test that checks the insert and select functions
    function($db) {
        $inserted_users = [
            "lrshsl" => 99,
            "some" => 1,
            "none" => 15,
            "anon" => 80,
            "anonymous" => 06,
        ];
        $not_inserted_usernames = [
            "lrshpl",
            "filipp",
            "qresnt",
            "nonon",
            "anonymuus",
        ];
        $not_inserted_ages = [
            12, 34, 32, 98, 89, 70, 50, 04,
        ];

        // First reset the database
        prepare_tables($db, true);
        
        // Database should now be empty if test#2(1 based system) worked
        // So insert all users in the array '$inserted_users'
        foreach ($inserted_users as $name => $age) {
            add_user($db, $name, $age);
        }

        // Now check if they are in there
        foreach ($inserted_users as $name => $age) {
            if (!$db->is_in_table("users", "username", $name)
                || !$db->is_in_table("users", "age", $age)) {
                    return "Failed: ".$name.", ".$age."years was not found after insertion of these values";
                }
        }

        // Check some random other names which aren't in the database
        foreach ($not_inserted_usernames as $name) {
            if ($db->is_in_table("users", "username", $name)) {
                return "Failed: ".$name." was found but not inserted";
            }
        }

        // Same with ages
        foreach ($not_inserted_ages as $age) {
            if ($db->is_in_table("users", "age", $age)) {
                return "Failed: ".$age." was found but not inserted";
            }
        }

        // If that all didn't fail, it's a success!
        return "Success";
    }
]


?>