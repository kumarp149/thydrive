<?php

function randstring($length){
  $string = '';
  $char = 'A1@a4B#bC2cD#dE=5eF3f@GgH#hI7i4Jj+K@k5_Ll#M17m+NO+n6oP=7Q=8p7q@9Rr#Ss2Tt6UuV@5vWwX@0YxyZz';
  for ($i = 0; $i < $length; ++$i){
    $string .= $char[rand(0,strlen($char)-1)];
  }
  return $string;
}

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
$fname = "Sruteesh";
$lname = "Paramata";
$email = "sruteeshkumarp@gmail.com";
$password = "1491625Pq";
$crypt = randstring(40);
$key = "180";
$fname_crypted = my_encrypt($fname,$crypt);
$lname_crypted = my_encrypt($lname,$crypt);
$email_crypted = my_encrypt($email,$crypt);
$password_crypted = my_encrypt($password,$crypt);
$conn = new mysqli('localhost','sruteeshP','32175690Pq','logindata');
$sql = "INSERT INTO `logininfo`(`FirstName`, `LastName`, `EmailId`, `Password`, `Crypt`) VALUES ('$fname_crypted','$lname_crypted','$email_crypted','$password_crypted','$crypt','$key')";
if ($conn->query($sql) == TRUE){
  echo "Data succesfully added";
}
else{
  echo "Error adding data".$conn->error;
}
$conn->close();
?>
