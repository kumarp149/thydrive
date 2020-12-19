<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

include('important/php/req_functions.php');

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
  exit();
}

if (! isset($_SESSION['emailid']))
{
  header('Location: '.$domain);
  die();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Login : Password</title>
  <meta charset="utf-8">
  <meta name="description" content="Mathlearn Password page">
  <meta name="keywords" content="Mathlearn, Password">
  <meta name="author" content="Sruteesh Kumar Paramata">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
  <script src="https://code.jquery.com/jquery-latest.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
  <script data-ad-client="ca-pub-4991407935211785" async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
  <script>
    window.addEventListener('keydown',function(e){if(e.keyIdentifier=='U+000A'||e.keyIdentifier=='Enter'||e.keyCode==13){if(e.target.nodeName=='INPUT'&&e.target.type=='text'){e.preventDefault();return false;}}},true);
  </script>
  <style>
  #container-secondary{
    text-align: center;
  }
  #container-tertiary{
    text-align: center;
    margin-top: 30px;
  }
  #pwd{
    width: 40%;
    min-width: 300px;
    font-size: 18px;
    padding-top: 1px;
    padding-bottom: 1px;

  }
  #pwd-error-container{
    font-size: 19px;
    color: rgb(217, 48, 37);
    font-weight: bold;
  }
  #button-container{
    margin-top: 80px;
    width: 40%;
    min-width: 300px;
    margin-bottom: 25px;
  }
  #question-form{
    opacity: 0.3;
    margin-top: 8%;
  }
  </style>
</head>
<body>
  <div class="container mt-5 pt-2 pb-4" id="container-primary">
    <div class="container mt-3" id="container-secondary"><h3>Welcome</h3><br> Please Enter your <strong><label for="pwd">Password</label></strong> to <strong>LOGIN</strong></br>
    </div>
    <div class="container pt-2" id="container-tertiary">
      <form method="post" id="pwd-form" autocomplete="off">
        <input type="password" class="form-control mx-auto" id="pwd" placeholder="Password" name="pwd" spellcheck="false"></input>
        <div class="container" id="pwd-error-container">
        </div>
        <div class="container" id="button-container">
          <div class="row">
            <div class="mr-auto">
              <input type="submit" class="btn btn-info" id="forgotpwd" value="Forgot Password">
            </div>
            <div class="">
              <input type="button" class="btn btn-info" id="submit-button" value="Validate" disabled>
            </div>
          </div>
       </div>
      </form>

     </div>
    </div>
  <script>
   $(document).ready(function()
   {
     var count_load = 0;
     $("#pwd").focus();
     var x = document.getElementById("pwd");
     $("#pwd").on('input',function()
     {
       if (x.value == "")
       {
         document.getElementById("submit-button").disabled = true;
       }
       else
       {
         document.getElementById("submit-button").disabled = false;
       }
     })
     $("#submit-button").click(function()
     {
       count_load = count_load + 1;
       document.getElementById("pwd-error-container").innerHTML = "Authenticating ......";
       $("#pwd-error-container").css("color","black");
       var emailid = '<?php
       echo $_SESSION['emailid'];
       ?>';
       var pwd = document.getElementById("pwd").value;
       $.post('pwd.php',{query_emailid : emailid, query_pwd : pwd}, function(data,status){
         var jdata = JSON.parse(data);
         if (jdata.success == 1)
         {
           setTimeout(function()
           {
            document.getElementById("pwd-error-container").innerHTML = "Logging in....";
             var userkey = '<?php
             echo $_SESSION['userkey']; ?>';
             window.location.href = "https://sruteesh.herokuapp.com/drive/files/0";
           },1000)
         }
         else
         {
          setTimeout(function()
          {
            $("#pwd-error-container").css("color","#dc3545");
           document.getElementById("pwd-error-container").innerHTML = "Wrong password";
           document.getElementById("pwd").value = "";
           },500)
         }
         setTimeout(function()
         {
           $("#pwd-error-container").empty();
         },1500);
       })
     });
     $(document).keypress(function(event){
       if (event.which == '13'){
         event.preventDefault();
         $("#submit-button").click();
       }
     })
   })
  </script>

</body>
</html>
