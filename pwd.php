<?php
session_start();

include(__DIR__.'\important\php\req_functions.php');

$pwd = $_POST['query_pwd'];

$email = $_POST['query_emailid'];

$conn = new mysqli($sql_server,$sql_username,$sql_password,'logindata');

$sql = 'SELECT email, password256, password512, crypt, userid FROM logininfo';

$result = $conn->query($sql);

$count = 0;

while ($row = $result->fetch_assoc())
{
  if ($email == $row['email'] && hash("sha256",$pwd) == $row['password256'] && hash("sha512",$pwd) == $row['password512'])
  {
    $count = 1;
    $_SESSION['pwdentered'] = $pwd;
    $_SESSION['key'] = my_decrypt($row['crypt'],$email);
    $_SESSION['uid'] = my_decrypt($row['userid'],$email);
    break;
  }
}
if ($count == 1)
{
  echo json_encode(array('success' => 1));
  unset($_SESSION['code']);
}
else
{
  echo json_encode(array('success' => 0));
}
?>
