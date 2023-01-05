<!--
 Copyright 2022 lars.
 Use of this source code is governed by the WTFPL
 license that can be found in the LICENSE file.
-->

<?php

// Redirect to index page if already logged in
if (isset($_SESSION["username"])) {
    header("Location: ../index.html");
    exit();
}

?>

<link rel="stylesheet" href="../defaults/style.css">
<link rel="stylesheet" href="../style/login.css">
<link rel="import" href="../defaults/header.html">

<body>
    <link rel="import" href=../defaults/header.html">
    <main>
        <h1>Sign In</h1>
        <form action="../scripts/login/login.php" method="post">
            <div class="input_container">
                <label class="input_label" for="username">Username:</label>
                <input type="text" name="username" id="username_input"><br><br>
            </div>
            <div class="input_container">
                <label class="input_label" for="age">Age:</label>
                <input type="text" name="age" id="age_input"><br><br>
            </div>
            <button type="submit">Log in</button>
        </form>
        <div>
            <div id="no_input_msg" class="message">This is a message</div>
        </div>
    </main>
    <link rel="import" href="../defaults/footer.html">
</body>