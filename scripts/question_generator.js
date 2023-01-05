// Copyright 2022 lrshsl.
// Use of this source code is governed by the WTFPL
// license that can be found in the LICENSE file.


// An array of objects representing the questions and options
const QUESTION_FILE_PATH = "./database/questions.csv";
const _questions = [
    {
        question: "What is the capital of France?",
        options: ["Paris", "London", "Berlin", "Rome"],
        answer: "Paris"
    },
    {
        question: "What is the capital of Italy?",
        options: ["Paris", "London", "Berlin", "Rome"],
        answer: "Rome"
    }
];

function start_quiz() {
    // Show the quiz form and hide the main content
    const logged_in = localStorage.getItem("logged_in");

    // Check if #main_survey is hidden
    const main_survey = document.getElementById("main_survey");
    const is_hidden = main_survey.offsetParent === null;
    if (!logged_in) {
        console.log("pls login");
    } else if (is_hidden) {
        localStorage.setItem("quiz_started", "true");
        generate_questions();
        console.log("started");
        document.getElementById("main_survey").style.display = "block";
    } else {
        console.log("Is already shown:");
    }
}


function generate_questions() {
    const questions = read_questions_from_file(QUESTION_FILE_PATH);

    // Get a reference to the form element
    const main_div = document.querySelector("#main_survey");
    const form = main_div.querySelector("form");

    // Loop through the questions array
    for (const question of questions) {

        // Create a new h2 element for the question
        const h2 = document.createElement("h2");
        h2.textContent = question.question;

        // Append the h2 element to the form
        form.appendChild(h2);

        // Loop through the options array
        for (const option of question.options) {
            // Create a new div element
            const div = document.createElement("div");

            // Create a new input element for the option
            const input = document.createElement("input");
            input.type = "radio";
            input.name = `question${questions.indexOf(question) + 1}`;
            input.value = option;
            input.id = `q${questions.indexOf(question) + 1}${question.options.indexOf(option)}`;

            // Create a new label element for the option
            const label = document.createElement("label");
            label.htmlFor = input.id;
            label.textContent = option;

            // Append the input and label elements to the div element
            div.appendChild(input);
            div.appendChild(label);

            // Append the div element to the form
            form.appendChild(div);
        }
    }
}

function read_questions_from_file(path) {
    
}