<?php

// Copyright 2023 lrshsl.
// Use of this source code is governed by the WTFPL
// license that can be found in the LICENSE file.

// First start the session
session_start();

?>

<html lang="en">
<head>
    <link rel="import" href="../../defaults/head_content.html">
    <title>Programming Survey</title>
</head>
<body>
    <form action="submit_survey.php" method="post">
    </form>
</body>
</html>

<?php
    // Create the database if it doesn't yet exist
    $root = $_SERVER["DOCUMENT_ROOT"]."/lrs/programming_survey/";
    require $root."scripts/database/create.php";
    
    // Include the error tools if possible
    include $root."defaults/errors.php";

    // Display the survey
    start_survey();
    echo "DEND";

    function start_survey() {
        // If user is not logged in
        if (!isset($_SESSION["username"])) {

            // Send a message to the user
            add_message("Please log in first");
            
            // Then redirect to login page
            header("Location: ../templates/login_form.php");
            exit();
        }
        
        // Else get the database singleton
        $db = Database::get_instance();

        // Fetch the question ids
        $question_ids = $db->get_elements("questions", "question_id");

        // Fetch the question texts
        $question_texts = $db->get_elements("questions", "text");

        // Prepare an array for the options
        $options = [];

        // Fetch the options for each id into the array
        foreach ($question_ids as $id) {
            $local_options = $db->get_elements_where("answer_options", 'question_id = "'.$id.'"');
            array_push($options, $local_options);
        }

        for ($i = 0; $i < count($question_texts); $i += 1) {
            echo ($question_texts[$i]);
            echo ($options[$i]);
        }

        header("Location: ../index.html");
        generate_questions($question_texts, $options);
    }

    function generate_questions($questions, $options) {

        // Get a reference to the form element
        echo "<script>";
        echo "const main_div = document.querySelector('#main_survey');";
        echo "const form = main_div.querySelector('form');";
    
        // Loop through the $questions array with an index (later used for the naming of the elements)
        for ($i = 0; $i < count($questions); $i++) {
            // Create a new h2 element for the question
            echo "const title = document.createElement('h2');";
            echo "title.textContent = '".$questions[$i]."';";
    
            // Append the h2 element to the form
            echo "form.appendChild(title);";
    
            // Loop through the options
            for ($j = 0; $j < count($options[$i]); $j++) {
                echo "const option = '".$options[$i][$j]."';";
                echo "const i = ".$i.";";
                echo "const j = ".$j.";";
    
                // Create a new div element
                echo "const div = document.createElement('div');";
    
                // Create a new input element for the option
                echo "const input = document.createElement('input');";
                echo "input.type = 'radio';";
                echo "input.name = 'question".($i + 1)."';";
                echo "input.value = option;";
                echo "input.id = 'q".($i + 1)."_".$j."';";
    
                // Create a new label element for the option
                echo "const label = document.createElement('label');";
                echo "label.htmlFor = input.id;";
                echo "label.textContent = option;";
    
                // Append the input and label elements to the div element
                echo "div.appendChild(input);";
                echo "div.appendChild(label);";
    
                // Append the div element to the form
                echo "form.appendChild(div);";
            }
        }
        echo "</script>";
    }

    // function generate_questions($questions, $options) {

    //     // Get a reference to the form element
    //     echo "<script>";
    //     echo "const main_div = document.querySelector('#main_survey');";
    //     echo "const form = main_div.querySelector('form');";

    //     // Loop through the questions array
    //     for ($i = 0; $i < count($questions); $i++) {

    //         // Create a new h2 element for the question
    //         echo "const title = document.createElement('h2');";
    //         echo "title.text = ".$questions[$i].";";

    //         // Append the h2 element to the form
    //         echo "form.appendChild(title);";

    //         // Loop through the options
    //         for ($j = 0; $j < count($options); $j++) {
    //             echo "const option = ".$options[$i][$j].";
    //             const i = ".$i.";
    //             const j = ".$j.";
            
    //             // Create a new div element
    //             const div = document.createElement('div');

    //             // Create a new input element for the option
    //             const input = document.createElement('input');
    //             input.type = 'radio';
    //             input.name = 'question${i + 1}';
    //             input.value = option;
    //             input.id = 'q${i + 1}_${j}';

    //             // Create a new label element for the option
    //             const label = document.createElement('label');
    //             label.htmlFor = input.id;
    //             label.textContent = option;

    //             // Append the input and label elements to the div element
    //             div.appendChild(input);
    //             div.appendChild(label);

    //             // Append the div element to the form
    //             form.appendChild(div);";
    //         }
    //     }
    //     echo "</script>";
    // }

?>
