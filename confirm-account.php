<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

use Google\Cloud\Storage\StorageClient;

include(__DIR__.'\important\php\req_functions.php');

require __DIR__.'\vendor\autoload.php';

if (valid_session($sql_server,$sql_username,$sql_password) == 1)
{
  header('Location: '.$domain.'/drive');
  die();
}

if (! isset($_SESSION['code']))
{   
  header('Location: create-account.php');
  die();
}

if (! isset($_SESSION['code_error_times']))
{
  $_SESSION['code_error_times'] = 0;
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
    $_SESSION['code'] = "Code Expired";
    $_SESSION['created'] = 0;
  }
  else if (isset($_SESSION['code']) && $_SESSION['code'] == $_POST['code'])
  {
    $_SESSION['created'] = 1;
    $fname = $_SESSION['firstname'];
    $lname = $_SESSION['lastname'];
    $email = $_SESSION['emailid'];
    $pwd256 = hash("sha256",$_SESSION['pwdentered']);
    $pwd512 = hash("sha512",$_SESSION['pwdentered']);
    $_SESSION['gen_key'] = hash("sha256",randstring(10));
    $conn = new mysqli($sql_server,$sql_username,$sql_password,"logindata");
    $result = $conn->query("SELECT id FROM `logininfo` WHERE id = (SELECT MAX(id) FROM `logininfo`)");
    $row = $result->fetch_assoc();
    $lastid = $row['id'];
    $newid = time().otp_gen(15-strlen(time())).$lastid;
    $result = $conn->query("INSERT INTO logininfo (fname, lname, email, password256, password512, userid) VALUES ('{$fname},{$lname},{$email},{$pwd256},{$pwd512},{$newid}')");
    header('Location: encryption.php');
    die();
  }
  else if (isset($_SESSION['code']) && $_SESSION['code'] != $_POST['code'] && $_SESSION['code'] != "Code Expired")
  {
    $_SESSION['code_error_times'] = $_SESSION['code_error_times'] + 1;
  }
  else if (isset($_SESSION['code']) && $_SESSION['code'] != $_POST['code'] && $_SESSION['code'] == "Code Expired")
  {
    $show = "Code Expired";
  }
  if ($_SESSION['code_error_times'] > 7)
  {
    $manytimes = "Too many incorrect attempts";
  }
  else if ($_SESSION['code_error_times'] <= 7 && $_SESSION['code'] != "Code Expired")
  {
    $wrongcode = "Invalid Code";
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
        </div>
        <div class="container" id="button-container">
          <input type="submit" class="btn btn-info" value="Confirm" name="cnfaccount" id="cnfaccount"></input>
        </div>
      </form>
    </div>
  </div>
  <script>
    var temp1 
    = 
    "<?php
    if (isset($show))
    {
      echo $show;
    }
    else
    {
      echo "";
    }
    ?>";
    var temp2 
    = 
    "<?php
    if (isset($manytimes))
    {
      echo $manytimes;
    }
    else
    {
      echo "";
    }
    ?>";
    var temp3
    = 
    "<?php
    if (isset($wrongcode))
    {
      echo $wrongcode;
    }
    else
    {
      echo "";
    }
    ?>";
    $(document).ready(function(){
      if (temp3 == "Invalid Code")
      {
        document.getElementById("code-error-container").innerHTML = "Code you Entered is not valid";
      }
      if (temp1 == "Code Expired")
      {
        $("#button-container").hide();
        $("#cnfaccount").prop('disabled', true);
        document.getElementById("code-error-container").innerHTML = "Code has expired";
        setTimeout(function(){
          window.location.href = "https://mathlearn.icu/create-account.php";
        },1000);
      }
      else if (temp2 == "Too many incorrect attempts")
      {
        $("#button-container").hide();
        $("#cnfaccount").prop('disabled', true);
        document.getElementById("code-error-container").innerHTML = "Too many incorrect attempts";
        setTimeout(function(){
          window.location.href = "https://mathlearn.icu/create-account.php";
        },1000);
      }
      $("#code").focus();
      setTimeout(function(){
        $("#code-error-container").empty();
      },1500);
    })
  </script>
