// Copyright 2023 lrshsl.
// Use of this source code is governed by the WTFPL
// license that can be found in the LICENSE file.


<?php

// Include test files (some can be missing)
include "core_tests.php";
include "expensive_tests.php";


// Collect tests into one array
$all_tests = [];

// Include core tests if set
if (isset($core_tests))
    array_push($all_tests, ...$core_tests);

// Include expensive tests if set
if (isset($expensive_tests))
    array_push($all_tests, ...$expensive_tests);


// Execute
execute_tests($all_tests);


// Function that executes given tests one by one
// and displays the results on the webpage
function execute_tests($tests) {

    // Keep impatient users patient
    echo "Tests are runninp<br>Please be patient<br><br>";

    // Get a singleton of the database class
    $db = Database::get_testing_instance();

    // Execute tests one by one
    for ($i=0; $i<count($tests); $i++) {
        
        // Echo first part of message
        echo "Test ".$i." running: ";

        // Run the test on the database
        $result = $tests[$i]($db);
        
        // Echo the second part of the message
        echo $result."!<br>";

    }
    
    // Tell the user the testing is finished
    echo "<br>Finished. All tests have been executed";
}


?>