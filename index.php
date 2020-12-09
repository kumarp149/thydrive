<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

include('req_functions.php');

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
  header('Location: '.$domain.'/drive/files/0');
  die();
}

foreach ($_SESSION as $key => $val)
{
  if ($key != 'noemail' && $key != 'id')
  {
    unset($_SESSION[$key]);
  }
}


if (! isset($_SESSION['id']))
{                   
  $_SESSION['id'] = randstring(20);
  $id = $_SESSION['id'];
}
if ($_GET['id'] != $_SESSION['id'])
{
  header('Location: '.$domain.'?email&service=login&domain=mathlearn.icu&redirect_to_page=password&id='.$_SESSION['id'].'');
  exit();
}
if ($_GET['redirect_to_page'] != "password")
{
  header('Location: '.$domain.'?email&service=login&domain=mathlearn.icu&redirect_to_page=password&id='.$_SESSION['id'].'');
  exit();
}
if ($_GET['service'] != "login")
{
  header('Location: '.$domain.'?email&service=login&domain=mathlearn.icu&redirect_to_page=password&id='.$_SESSION['id'].'');
  exit();
}
if ($_GET['domain'] != "mathlearn.icu")
{
  header('Location: '.$domain.'?email&service=login&domain=mathlearn.icu&redirect_to_page=password&id='.$_SESSION['id'].'');
  exit();
}


if (isset($_POST['submit'])){
  $count = 0;
  $email = clean_mail($_POST['email']);
  $conn = new mysqli($sql_server,$sql_username,$sql_password,'logindata');
  $sql = "SELECT EmailId, Password, Crypt FROM logininfo";
  $result = $conn->query($sql);
    while ($row = $result->fetch_assoc())
    {
      if (my_decrypt($row['EmailId'],$row['Crypt']) == $email)
      {
        $count = 1;
        $_SESSION['emailid'] = $email;
        break;
      }
    }
  if ($count == 1)
  {
    $conn->close();
    unset($_SESSION['code']);
    header('Location: '.$domain.'/password.php');
    die();
  }
  if ($count == 0)
  {
    $_SESSION['noemail'] = "No account found";
    header('Location: '.$domain.'?email&service=login&domain=mathlearn.icu&redirect_to_page=password&id='.$_SESSION['id'].'');
    die();
  }
}

if (array_key_exists('createaccount', $_POST))
{
  header('Location: create-account.php?details&service=signup&redirect_to_page=email_confirmation&id='.$_SESSION['id']);
  die();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Login : Email</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="Mathlearn Email page">
  <meta name="keywords" content="Mathlearn, Email">
  <meta name="author" content="Sruteesh Kumar Paramata">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
  <script data-ad-client="ca-pub-4991407935211785" async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
  <style>
  #container-secondary{
    text-align: center;
  }
  #container-tertiary{
    text-align: center;
    margin-top: 30px;
  }
  #email{
    width: 50%;
    min-width: 300px;
    font-size: 16.5px;
    padding-top: 1px;
    padding-bottom: 1px;
  }
  #email-error-container{
    font-size: 19px;
    color: rgb(232, 17, 35);
    font-weight: bold;
  }
  #button-container1{
    text-align: center;
    margin-top: 80px;
  }
  #button-container2{
    text-align: center;
  }
  #submit-button{
    width: 90px;
  }
  </style>
</head>
<body>
  <div class="container mt-5 pt-2 pb-4" id="container-primary">
    <div class="container mt-3" id="container-secondary"><h3>Welcome</h3><br> Please Enter your <strong><label for="email">Email</label></strong> to <strong>LOGIN</strong></br>
    </div>
    <div class="container pt-2" id="container-tertiary">
      <form method="post" id="email-form" autocomplete="off">
          <input type="text" class="form-control mx-auto" id="email" placeholder="Email" name="email" spellcheck="false"></input>
        <div class="container" id="email-error-container"><?php
        if (isset($_SESSION['noemail']))
        {
          echo $_SESSION['noemail'];
          unset($_SESSION['noemail']);
        } ?>
        </div>
        <div class="container" id="button-container1">
           <input type="submit" class="btn btn-info" disabled value="Next" id="submit-button" name="submit"></input>
        </div>
        <div class="container mt-2" id="button-container1">
           <input type="submit" class="btn btn-info" value="No Account?" id="createaccountbutton" name="createaccount"></input>
       </div>
     </form>
   </div>
  </div>
  <script>
    $(document).ready(function(){
      setTimeout(function(){
        $("#email-error-container").empty();
      },1500);
      $('#submit-button').attr('disabled','disabled');
      $("#email").focus();
      var mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
      $("#email").on('input', function(){
        if (document.getElementById("email").value.trim().match(mailformat)){
          document.getElementById("submit-button").disabled = false;
        }
        else{
          document.getElementById("submit-button").disabled = true;
        }
      })
    })
  </script>
</body>
</html>
