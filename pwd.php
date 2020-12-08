<?php
session_start();

include('req_functions.php');


$pwd = $_POST['query_pwd'];

$email = $_POST['query_emailid'];

$conn = new mysqli($sql_server,$sql_username,$sql_password,'logindata');

$sql = 'SELECT * FROM logininfo';

$result = $conn->query($sql);

$count = 0;

while ($row = $result->fetch_assoc())
{
  if (my_decrypt($row['EmailId'],$row['Crypt']) == $email && my_decrypt($row['Password'],$row['Crypt']) == $pwd)
  {
    $count = 1;
    $crypt = $row['Crypt'];
    $userkey = $row['UserKey'];
    break;
  }
}
if ($count == 1)
{
  echo json_encode(array('success' => 1));
  $_SESSION['pwdentered'] = $pwd;
  unset($_SESSION['code']);
  $_SESSION['userkey'] = my_decrypt($userkey,$crypt);
  setcookie("emailid",$_SESSION['emailid'],0,"/");
}
else
{
  echo json_encode(array('success' => 0));
}
?>
