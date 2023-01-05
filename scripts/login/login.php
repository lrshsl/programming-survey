<?php

//  Copyright 2022 lars.
//  Use of this source code is governed by the WTFPL
//  license that can be found in the LICENSE file.


// Start the session
session_start();

// Import basic functionality
require "../../defaults/basic.php";

// Create the database if it doesn't yet exist
require "database/create.php";


handle_login_submission();


function handle_login_submission() {
    $username = $_POST["username"];
    $age = $_POST["age"];

    check($username, $age);

    // Make sure there is not already a user with that username in the database
    $db = Database::get_instance();
    if ($db->is_in_table("users", "username", $username)) {

        // If it is, redirect back to the login form..
        header("Location: ../../templates/login_form.html");

        // .. and show a message on the screen
        add_message("please use another username");

        exit();
    }

    if (add_user($db, $username, $age)) {
        add_message("logged_in");
        echo "<script>console.log('logged in now')</script>";
        $_SESSION["username"] = $username;
    } else {
        add_message("could not log in");
    }
    header("Location: ../../index.html");
}

function check($username, $age) {

    // Check if any field is missing
    if (!isset($username) || $age == null || $age == 0)
        $msg = "please fill in every field<br>";

    // Make sure $username has the correct length
    if (strlen($username) < 1 || strlen($username) > 20)
        $msg = "username must be between 1 and 20 characters<br>";

    // Make sure $age is realistic
    if ($age <= 0 || $age > 150)
        $msg = "Age must be in a realistic range<br>";


    // If anything above happened
    if (isset($msg)) {
        
        // Print the error message
        add_message($msg);
        
        // Redirect to the login page
        header("Location: ../../templates/login_form.html");

        // Stop this script
        exit();
    }
}

?>