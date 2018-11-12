<?php
function test_input($data) {
    $data = preg_replace('/\\.[^.\\s]{3,4}$/', '', $data);
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>