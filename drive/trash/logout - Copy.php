<?php
session_start();
unset($_SESSION['emailid']);
if (! isset($_SESSION['emailid'])){
    echo json_encode(array('success' => 1));
}
?>