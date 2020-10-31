<?php
session_start();

function my_encrypt($data, $key) {
    $encryption_key = base64_decode($key);
    $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
    $encrypted = openssl_encrypt($data, 'aes-256-cbc', $encryption_key, 0, $iv);
    return base64_encode($encrypted . '::' . $iv);
}


function my_decrypt($data, $key) {
    $encryption_key = base64_decode($key);
    list($encrypted_data, $iv) = explode('::', base64_decode($data), 2);
    return openssl_decrypt($encrypted_data, 'aes-256-cbc', $encryption_key, 0, $iv);
}


$pwd = $_POST['query_pwd'];

$email = $_POST['query_emailid'];

$conn = new mysqli('localhost','sruteeshP','32175690Pq','logindata');

$sql = 'SELECT * FROM logininfo';

$result = $conn->query($sql);

$count = 0;

while ($row = $result->fetch_assoc()){
  if (my_decrypt($row['EmailId'],$row['Crypt']) == $email && my_decrypt($row['Password'],$row['Crypt']) == $pwd){
    $count = $count + 1;
    $crypt = $row['Crypt'];
    $userkey = $row['UserKey'];
    break;
  }
}
if ($count > 0){
  echo json_encode(array('success' => 1));
  /*echo "Kumar";*/
  $_SESSION['pwdentered'] = "Yes";
  $_SESSION['userkey'] = my_decrypt($userkey,$crypt);
}
else{
  echo json_encode(array('success' => 0));
  /*echo "Sruteesh";*/
}
?>
