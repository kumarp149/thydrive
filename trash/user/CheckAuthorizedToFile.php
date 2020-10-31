<?php

session_start();
$basepath = 'C:\MAMP\htdocs\thydrive\user';
$realBase = realpath($basepath);

$userpath = $basepath . $_GET['file'];
$realUserPath = realpath($userpath);

if ($realUserPath === false || strpos($realUserPath, $realBase) !== 0) {
//prevent directory traversal by exiting execution
exit();
} 

if(isset($_SESSION['emailid']))
{

$file = $_GET['file'];
$type = 'pdf';
header('Content-Type:'.$type);
header('Content-Length: ' . filesize($file));
readfile($file);
}
else
{
echo "Not Autorized please login.";
}
