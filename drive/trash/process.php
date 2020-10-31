<?php

$folder = $_POST['dir'];
$name = $_POST['content'];
unlink($name);
echo json_encode(array('success' => 1));

?>
