<?php

// Copyright 2023 lrshsl.
// Use of this source code is governed by the WTFPL
// license that can be found in the LICENSE file.


// Create the database if it doesn't yet exist
require "database/create.php";

function start_survey() {
    // If user is not logged in
    if (!isset($_SESSION["username"])) {
        
        // Redirect to login page
        header("Location: ../templates/login_form.php");
        exit();
    }
    
    $db = Database::get_instance();

    // Fetch the question text
    $questions = $db->get_elements("questions", "text");

    // Fetch the options
    $options = $db->get_elements("answer_options", "text");

    header("Location: ../index.html");
    generate_questions($questions, $options);
}

function generate_questions($questions, $options) {

    // Get a reference to the form element
    echo "<script>";
    echo "const main_div = document.querySelector('#main_survey');";
    echo "const form = main_div.querySelector('form');";

    // Loop through the questions array
    for ($i = 0; $i < count($questions); $i++) {

        // Create a new h2 element for the question
        echo "const title = document.createElement('h2')";
        echo "title.text = ".$questions[$i].";";

        // Append the h2 element to the form
        echo "form.appendChild(title);";

        // Loop through the options
        for ($j = 0; $j < count($options); $j++) {
            echo "const option = ".$options[$i][$j].";
            const i = ".$i.";
            const j = ".$j.";
        
            // Create a new div element
            const div = document.createElement('div');

            // Create a new input element for the option
            const input = document.createElement('input');
            input.type = 'radio';
            input.name = `question${i + 1}`;
            input.value = option;
            input.id = `q${i + 1}_${j}`;

            // Create a new label element for the option
            const label = document.createElement('label');
            label.htmlFor = input.id;
            label.textContent = option;

            // Append the input and label elements to the div element
            div.appendChild(input);
            div.appendChild(label);

            // Append the div element to the form
            form.appendChild(div);";
        }
    }
    echo "</script>";
}

?>

<script type="text/javascript">
    document.getElementById("start_survey_btn").addEventListener("click",
        function() {
            // Send an AJAX request to the server
            const xhr = new XMLHttpRequest();
            xhr.open('GET', '/start_survey.php');
            xhr.send();
        })
    console.log("rsiten");
</script>
