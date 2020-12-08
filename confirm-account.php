<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

use Google\Cloud\Storage\StorageClient;

include('req_functions.php');

require 'vendor/autoload.php';

session_start();
if (! isset($_SESSION['code_error_times']))
{
  $_SESSION['code_error_times'] = 0;
}
function valid_session()
{
  if (isset($_SESSION['emailid']) && isset($_SESSION['pwdentered']))
  {
    $server = 'localhost';
    $username = 'sruteeshP';
    $password = '32175690Pq';
    $ses_email = $_SESSION['emailid'];
    $ses_pwd = $_SESSION['pwdentered'];
    $conn = new mysqli($server,$username,$password,"logindata");
    $sql = "SELECT Emailid, Password, Crypt FROM logininfo";
    $result = $conn->query($sql);
    while ($row = $result->fetch_assoc())
    {
        if (my_decrypt($row['Emailid'],$row['Crypt']) == $ses_email && my_decrypt($row['Password'],$row['Crypt']) == $ses_pwd)
        {
            return 1;
        }
    }
    return 0;
  }
  else
  {
    return 0;
  }
}

if (valid_session() == 1)
{
  header('Location: http://mathlearn.icu/drive/files/0');
  die();
}

if (! isset($_SESSION['code']))
{   
  header('Location: create-account.php');
  exit();
}
if (! isset($_GET['id']))
{
  header("Location: confirm-account.php?verification&domain=mathlearn.icu&id=".$_SESSION['id']);
  die();
}
if (! isset($_GET['domain']))
{
  header("Location: confirm-account.php?verification&domain=mathlearn.icu&id=".$_SESSION['id']);
  die();
}

if (isset($_POST['cnfaccount']))
{
  if (time()-$_SESSION['create_time'] > 900)
  {
    $_SESSION['expired'] = "Code expired, redirecting to signup page";
    unset($_SESSION['code']);
  }
  if (isset($_SESSION['code']) && $_SESSION['code'] == $_POST['code'])
  {
    $_SESSION['create_success'] = "Yes";
    $fname = $_SESSION['fname_crypted'];
    $lname = $_SESSION['lname_crypted'];
    $email = $_SESSION['email_crypted'];
    $password = $_SESSION['password_crypted'];
    $crypt = $_SESSION['crypt'];
    $user = hash("sha256",$crypt);
    $userkey = substr(hash("sha256",$user),0,32);
    $folder = substr(hash("sha256",randid(10)),0,10);
    while (file_exists('drive/'.$folder))
    {
      $folder = substr(hash("sha256",randid(10)),0,10);
    }
    mkdir('drive/'.$folder); 

    $conn = new mysqli($sql_server,$sql_username,$sql_password,"logindata");
    $sql = "INSERT INTO `logininfo` (FirstName, LastName, EmailId, Password, Crypt, UserKey, foldername)
    VALUES ('$fname', '$lname', '$email', '$password', '$crypt', '$userkey', '$folder')";

    $array_insert = 
    [
      'firstname' => $fname,
      'lastname' => $lname,
      'email' => $email,
      'password' => $password,
      'crypt' => $crypt,
      'userkey' => $userkey,
      'folder' => $folder,
      'files' => [],
      'api_keys' => []
    ];
    $mongo_conn = new mongo($mongo_url);
    $mongo_conn->insert_doc("thydrive","user_details",$array_insert);

    if ($conn->query($sql) === TRUE)
    {
      /*$storage = new StorageClient(
      [
        'keyFile' => json_decode(file_get_contents('key.json'), true)
      ]);
      $bucket = $storage->createBucket("thydrive");*/
      header('Location: http://mathlearn.icu/encryption.php?encryption&id='.$_SESSION['id']);
      die();
    }
    else
    {
      echo "Error";
      die();
    }
  }
  else if (isset($_SESSION['code']) && $_SESSION['code'] != $_POST['code'] && $_SESSION['code_error_times'] < 5)
  {
    $_SESSION['code_error'] = "Incorrect Code";
    $_SESSION['code_error_times'] = $_SESSION['code_error_times'] + 1;
    $_SESSION['show'] = "Incorrect Code";
    header("Location: confirm-account.php?verification&domain=mathlearn.icu&id=".$_SESSION['id']);
    die();
  }

  else if (isset($_SESSION['code']) && $_SESSION['code'] != $_POST['code'] && $_SESSION['code_error_times'] >= 5)
  {
    unset($_SESSION['code']);
    $_SESSION['show'] = "Too many incorrect attempts";
    $_SESSION['store'] = $_SESSION['show'];
  }
  else if (! isset($_SESSION['code']))
  {
    $_SESSION['show'] = "Code expired";
    $_SESSION['store'] = $_SESSION['show'];
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
        <div class="container" id="code-error-container">
          <?php
            echo $_SESSION['show'];
            unset($_SESSION['show']);
          ?>
        </div>
        <div class="container" id="button-container">
          <input type="submit" class="btn btn-info" value="Confirm" name="cnfaccount" id="cnfaccount"></input>
        </div>
      </form>
    </div>
  </div>
  <script>
    var temp = "<?php echo $_SESSION['store']; ?>";
    $(document).ready(function(){
      console.log(temp);
      if (temp == "Too many incorrect attempts" || temp == "Code expired")
      {
        $("#button-container").hide();
        $("#cnfaccount").prop('disabled', true);
        setTimeout(function(){
          window.location.href = "http://mathlearn.icu";
        },1000);
      }
      $("#code").focus();
      setTimeout(function(){
        $("#code-error-container").empty();
      },1500);
    })
  </script>
