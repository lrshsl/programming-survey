// Copyright 2023 lrshsl.
// Use of this source code is governed by the WTFPL
// license that can be found in the LICENSE file.


<?php

$root = $_SERVER["DOCUMENT_ROOT"];
require $root."/scripts/survey.php";

// Start the survey if username is valid
start_survey();

?>