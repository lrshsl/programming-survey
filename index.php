<!--
 Copyright 2022 lars.
 Use of this source code is governed by the WTFPL
 license that can be found in the LICENSE file.
-->


<!DOCTYPE html>
<html lang="en">
<head>
    <?php
    // Start the session
    session_start();

    // Import some commands (and adds an event-listener)
    $root = $_SERVER["DOCUMENT_ROOT"];
    include $root."/scripts/quiz.php";
    ?>

    <!-- Import defaults -->
    <link rel="stylesheet" href="defaults/style.css">
    <link rel="import" href="defaults/head_content.html">
</head>

<body>
    <link rel="import" href="defaults/header.html">
    <main>
        <h1>Welcome to a Survey about PROGRAMMING</h1>
        <!-- <a href="templates/login_form.html">
            <button class="centered">Sign In</button>
        </a> -->
        <br> <br> <br> <br> <br> <br> <br>

        <button id="start_survey_btn">Start Survey</button>
        <form action="scripts/start_survey.php" method="post">
            <input type="submit" value="Log In">
        </form>

        <div id="main_survey" style="display: none;">
            <form action="scripts/login/login.php" method="post"></form>
            <button type="submit">Submit Answers</button>
        </div>

    </main>
    <link rel="import" href="defaults/footer.html">
</body>
</html>