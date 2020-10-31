<?php
use Google\Cloud\Storage\StorageClient;
require 'vendor/autoload.php';

function create_bucket($bucketName, $options = [])
{
    $storage = new StorageClient([
        'keyFile' => json_decode(file_get_contents('key.json'), true)
    ]);
    $bucket = $storage->createBucket($bucketName, $options);
}

function my_encrypt($data, $key) {          //Encryption algorithm
  $encryption_key = base64_decode($key);
  $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
  $encrypted = openssl_encrypt($data, 'aes-256-cbc', $encryption_key, 0, $iv);
  return base64_encode($encrypted . '::' . $iv);
}

function my_decrypt($data, $key) {        //Decryption algorithm
  $encryption_key = base64_decode($key);
  list($encrypted_data, $iv) = explode('::', base64_decode($data), 2);
  return openssl_decrypt($encrypted_data, 'aes-256-cbc', $encryption_key, 0, $iv);
}

function otp_gen($length){
  $num_code = "18230846765630778590";
  $otp = '';
  for ($i = 0; $i < $length; ++$i){
    $otp .= $num_code[mt_rand(0,strlen($num_code)-1)];
  }
  return $otp;
}
session_start();
if (! isset($_SESSION['code'])){               //Redirect user to signup page if the code is not set
  header('Location: create-account.php');
  exit();
}
if (isset($_POST['cnfaccount'])){
  if (time()-$_SESSION['create_time'] > 900){    //Redirect user to signup page if the code expired
    $_SESSION['expired'] = "Code expired, redirecting to signup page";
    $_SESSION['code'] = "Code expired";
  }
  if ($_SESSION['code'] == $_POST['code']){      //Send the user to encryption settings page if the code entered is valid 
    $_SESSION['create_success'] = "Yes";
    $fname = $_SESSION['fname'];
    $lname = $_SESSION['lname'];
    $email = $_SESSION['email_store'];
    $password = $_SESSION['password'];
    $crypt = $_SESSION['crypt'];
    $user = otp_gen(5)."".$_SESSION['create_time'];
    $userkey = my_encrypt($user,$crypt);
    $conn = new mysqli("localhost","sruteeshP","32175690Pq","logindata");
    if ($conn->connect_error)
    {
      die();
    }
    $sql = "INSERT INTO `logininfo` (FirstName, LastName, EmailId, Password, Crypt, UserKey)
    VALUES ('$fname', '$lname', '$email', '$password', '$crypt', '$userkey')";
    /*create_bucket('sruteesh-kumar-paramata-bucket');*/
    if ($conn->query($sql) === TRUE)
    {
      /*$file = fopen('C:\MAMP\htdocs\thydrive\drive\.htaccess','a+');
      fwrite($file,"RewriteRule ^files/".my_decrypt($fname,$crypt)."/?$ files.php?id=".$user);
      fclose($file);*/
      /*$bucketName = 'sruteesh-bucket-paramata-kumar';
      $arr = [];
      create_bucket($bucketName, $arr);*/
      $storage = new StorageClient([
        'keyFile' => json_decode(file_get_contents('key.json'), true)
      ]);
      $bucket = $storage->createBucket("sruteesh-kumar-paramata-bucket");
      header('Location: https://www.google.com');
      die();
    }
    else{
      echo "Error";
      die();
    }
  }
  else{                                          //Show the error that the user entered the invalid code
    $_SESSION['code_error'] = "Incorrect Code";  
    header('Location: confirm-account.php');
    die();
  }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Confirm Your Account</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
  <script src="https://code.jquery.com/jquery-latest.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
  <script data-ad-client="ca-pub-4991407935211785" async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
  <script>
    //window.addEventListener('keydown',function(e){if(e.keyIdentifier=='U+000A'||e.keyIdentifier=='Enter'||e.keyCode==13){if(e.target.nodeName=='INPUT'&&e.target.type=='text'){e.preventDefault();return false;}}},true);
  </script>
  <style>
  #container-secondary{
    text-align: center;
    margin-top: 8%;
  }
  #container-tertiary{
    text-align: center;
    margin-top: 30px;
  }
  #code{
    width: 40%;
    margin-top: 1%;
    min-width: 300px;
    padding-top: 1px;
    padding-bottom: 1px;
  }
  #code-error-container{
    margin-top: 1%;
    font-size: 20px;
    color: rgb(232, 17, 35);
    font-weight: 500;
    font-family: "Helvetica";
  }
  #button-container{
    margin-top: 60px;
    width: 40%;
    min-width: 300px;
    margin-bottom: 25px;
  }
  #question-form{
    opacity: 0.3;
    margin-top: 8%;
  }
  @media screen and (max-width: 480px) {
  #code-error-container{
    font-size : 15px;
  }
}
  </style>
</head>
<body>
  <div class="container mt-5 pt-2 pb-4" id="container-primary">
    <div class="container" id="container-secondary"><h3>Confirm your Account</h3><br> Please Enter the <strong><label for="code">Code</label></strong> sent to your Email</br>
    </div>
    <div class="container pt-2" id="container-tertiary">
      <form method="post" id="code-form" autocomplete="off">
        <input type="text" class="form-control mx-auto" id="code" placeholder="Code" name="code" spellcheck="false"></input>
        <div class="container" id="code-error-container"><?php
        session_start();
      if (isset($_SESSION['code_error']) && $_SESSION['code_error'] != "To be seen" && ! isset($_SESSION['expired']) /*&& ! isset($_SESSION['many_times'])*/){
        if (! isset($_SESSION['code_error_times'])){
          $_SESSION['code_error_times'] = 0;
        }
        else{
          $_SESSION['code_error_times'] = $_SESSION['code_error_times'] + 1;
        }
        if ($_SESSION['code_error_times'] > 2){
          $_SESSION['many_times'] = "Too many incorrect attempts";
        }
        if (! isset($_SESSION['many_times']))
        echo $_SESSION['code_error'];
        unset($_SESSION['code_error']);
        }
        if (isset($_SESSION['expired'])){
          echo $_SESSION['expired'];
          header( "refresh:1;url=create-account.php" );
          die();
        }
        if (isset($_SESSION['many_times'])){
          echo $_SESSION['many_times'];
          header("refresh:1.2;url=create-account.php");
          die();
        }?>
        </div>
        <div class="container" id="button-container">
          <input type="submit" class="btn btn-info" value="Confirm" name="cnfaccount"></input>
        </div>
      </form>
    </div>
  </div>
  <script>
    $(document).ready(function(){
      $("#code").focus();
      setTimeout(function(){
        $("#code-error-container").empty();
      },1500);
    })
  </script>
