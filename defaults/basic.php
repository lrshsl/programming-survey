<?php
// Copyright 2023 lrshsl.
// Use of this source code is governed by the WTFPL
// license that can be found in the LICENSE file.
?>

<!-- <script>
    function add_message(message) {
        const main = document.querySelector("main");
        const msg = document.createElement("p");
        msg.text = message;

        main.addChild(msg);
    }
</script> -->
<?php

// Show messages by default on all pages which import this file
show_messages();

function show_messages() {
    if (isset($_SESSION["messages"])) {
        echo $_SESSION["messages"];
        unset($_SESSION["messages"]);
    }
    // echo '<script>
    //     document.getElementById('.$msg_id.').style.display = "block"; // show the message
    //     setTimeout(function() {
    //         document.getElementById('.$msg_id.').style.display = "none"; // hide it again
    //     }, 1000); // delay hiding the message by 1 second
    // </script>';
}

function add_message($message) {
    if (isset($_SESSION["message"])) {
        $_SESSION["messages"] .= $message."<br>";
    } else {
        $_SESSION["messages"] = $message."<br>";
    }
}


?>