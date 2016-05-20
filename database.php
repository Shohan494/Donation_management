<?php

$conn = oci_connect('hr', 'shohanhr', 'localhost/xe');

if (!$conn) {
    $e = oci_error();
    trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
}else {
    echo "connected to database !";
}

?>
