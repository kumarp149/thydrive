<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include(__DIR__.'\important\php\req_functions.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require __DIR__.'\vendor\autoload.php';

if (isset($_SESSION['code_error_times']))
{
  unset($_SESSION['code_error_times']);
}

if (isset($_SESSION['code']) && $_SESSION['code'] == "Code Expired")
{
  unset($_SESSION['code']);
}
if (valid_session($sql_server, $sql_username, $sql_password) == 1)
{
  header('Location: '.$domain.'/drive');
  die();
}

if (isset($_SESSION['id']))
{

}
else
{
  $_SESSION['id'] = randid(20);
}
if ($_GET['service'] != 'signup')
{
  header('Location: create-account.php?details&service=signup&redirect_to_page=email_confirmation&id='.$_SESSION['id']);
  exit();
}
if ($_GET['redirect_to_page'] != 'email_confirmation')
{
  header('Location: create-account.php?details&service=signup&redirect_to_page=email_confirmation&id='.$_SESSION['id']);
  exit();
}
if ($_GET['id'] != $_SESSION['id'])
{
  header('Location: create-account.php?details&service=signup&redirect_to_page=email_confirmation&id='.$_SESSION['id']);
}


if (isset($_POST['submit']))
{
  $email = clean_mail($_POST['email']);
  $count = 0;
  $conn = new mysqli($sql_server,$sql_username,$sql_password,"logindata");
  $sql = "SELECT email FROM logininfo";
  $result = $conn->query($sql);
  while ($row = $result->fetch_assoc())
  {
    if ($email == $row['email'])
    {
      $count = 1;
      $_SESSION['firstname'] = $_POST['firstname'];
      $_SESSION['lastname'] = $_POST['lastname'];
      $_SESSION['createerror'] = 'Yes';
      header('create-account.php');
      die();
    }
  }
  if ($count == 0)
  {
    $_SESSION['firstname'] = clean_text($_POST['firstname']);
    $_SESSION['lastname'] = clean_text($_POST['lastname']);
    $_SESSION['emailid'] = clean_mail($_POST['email']);
    $_SESSION['pwdentered'] = $_POST['password'];
    //$_SESSION['gen_key'] = hash("sha256",randstring(10));
    $_SESSION['create_time'] = time();
    $_SESSION['code'] = otp_gen(8);
    $mail = new PHPMailer(true);
    $mail->SMTPDebug = 0;      
    $mail->isSMTP();                                            
    $mail->Host       = $smtp_server;       
    $mail->SMTPAuth   = true;                         
    $mail->Username   = $smtp_username;             
    $mail->Password   = $smtp_password;                               
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;      
    $mail->Port       = 465;
    $mail->setFrom('admin@thydrive.icu', 'Sruteesh');
    $mail->addAddress($email, clean_text($_POST['firstname']));
    $mail->isHTML(true);
    $mail->Subject = 'Verify your account';
    $mail->Body    = '<span style="font-size:17px;font-family:Helvetica">Hey '.$_SESSION['firstname'].',</span><br><br><span style="font-size:17.5px;font-family:Helvetica">Thank you for registering for THYDRIVE. Please Confirm your account to continue</span><br><br><span style="font-size:17.5px;font-family:Helvetica">Enter the following code (valid for 15 minutes) when asked</span><br><br><div style="text-align:center"><span><b><h1>'.$_SESSION['code'].'</h1><br><span style="font-family:Helvetica">**By Entering this code, you agree to our <a>terms and conditions</a></span></b></span></div><br><br><span style="font-size:17px;font-family:Helvetica">Alternatively, click the following button to activate your account</span><br><br><div style="text-align:center"><a href="http://buttons.cm" style="background-color:rgb(26, 115, 232);border:1px solid rgb(26, 115, 232);border-radius:3px;color:#ffffff;display:inline-block;font-family:sans-serif;font-size:16px;line-height:44px;text-align:center;text-decoration:none;width:140px;">Activate</a><br><br><span style="font-family:Helvetica"><b>**By clicking you agree to our <a>terms and comditions</b></span></div>';
    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
    $mail->send();
    header("Location: confirm-account.php?verification&domain=mathlearn.icu&id=".$_SESSION['id']);
    die();
  }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Create account</title>
  <meta charset="utf-8">
  <meta name="description" content="Mathlearn SignUp page">
  <meta name="keywords" content="Mathlearn, SignUp">
  <meta name="author" content="Sruteesh Kumar Paramata">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/10.6.1/sweetalert2.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/10.6.1/sweetalert2.css">
  <style>
    body{
      min-width: 100%;
    }
    .heading-text{
      font-size: 20px;
    }
    #password,#cnfpassword{
      font-size: 13.5px;
    }
    #bigdiv{
      text-align: center;
    }
    #firstname{
      width: 30%;
    }
    #lastname{
      width: 30%;
    }
    #formdiv{
      width: 35%;
      min-width: 320px;
    }
    #formdiv1{
      width: 35%;
      min-width: 320px;
    }
    #formdiv2{
      width: 40%;
      min-width: 320px;
    }
    #info{
      cursor: pointer;
      position: relative;
      top: 7px;
    }
    #visible{
      cursor: pointer;
      position: relative;
      top: 7px;
      left: 20px;
    }
    .second{
      margin-left: 5%;
    }
    .secondpwd{
      margin-left: 5%;
    }
    #signin{
      margin-left: 7%;
      text-align: center;
    }
    #signup{
      margin-right: 7%;
      text-align: center;
    }
    @media screen and (max-width: 500px){
      .secondpwd{
        margin-left: -17%;
      }
    }
  #container {
  position: absolute;
  top: 50%;
  margin-top: -200px;
  left: 0;
  width: 100%;
  z-index: 2;
  display: none;
}

#content {
  width: 40%px;
  margin-left: auto;
  margin-right: auto;
  height: 395px;
  border: 1px solid #000000;
  text-align: center;
}
  </style>
</head>
<body>
  <?php
  if (isset($_SESSION['createerror']))
  {
    $firstname = $_SESSION['firstname'];
    $lastname = $_SESSION['lastname'];
  }
  else
  {
    $firstname = '';
    $lastname = '';
  }
  ?>
  <div class="container mt-3 pt-5" id="bigdiv">
    <div class="heading-text">Create your account</div>
    <button id="restrict" style="background-color:rgb(26, 115, 232);border:1px solid rgb(26, 115, 232);border-radius:3px;color:#ffffff;display:inline-block;font-family:sans-serif;font-size:16px;line-height:44px;text-align:center;text-decoration:none;width:140px;" class="mt-3">Restrictions</button><br>
    <form method="post" id="signupform" class="pt-5" autocomplete="off">
      <div class="row mx-auto" id="formdiv">
        <input type="text" class="form-control col" spellcheck="false" autocomplete="off" id="firstname" placeholder="First Name" name="firstname" value = "<?php
        if (isset($firstname))
        {
          echo $firstname;
          unset($_SESSION['firstname']);
        }?>"><input type="text" spellcheck="false" class="form-control col second" id="lastname" autocomplete="off" placeholder="Last Name" name="lastname" value = "<?php
        if (isset($lastname))
        {
          echo $lastname;
          unset($_SESSION['lastname']);
        }?>">
      </div>
      <div class="row mx-auto pt-1" id="formdiv">
        <div class="col" id="fnamediv"></div><div class="col" id="lnamediv"></div>
      </div>
      <div class="row mx-auto pt-4" id="formdiv">
        <input type="text" class="form-control mx-auto col" spellcheck="false" id="email" autocomplete="off" placeholder="Email" name="email"></input>
      </div>
      <div class="row mx-auto pt-1" id="formdiv">
        <div class="mx-auto col text-danger" id="emaildiv"><?php
        if (isset($_SESSION['createerror']))
        {
          echo "<strong>**Account already exists with this Email</strong>";
          unset($_SESSION['createerror']);
        }?></div>
      </div>
      <div class="row mx-auto pt-4" id="formdiv">
        <input type="text" class="form-control mx-auto col" id="cnfemail" spellcheck="false" autocomplete="off" readonly placeholder="Re-enter Email" name="cnfemail"></input>
      </div>
      <div class="row mx-auto pt-1" id="formdiv">
        <div class="mx-auto col" id="cnfemaildiv"></div><div class="mx-auto col"></div>
      </div>
      <div class="row mx-auto pt-4" id="formdiv2">
        <input type="password" class="form-control col" autocomplete="off" spellcheck="false" id="password" placeholder="Password" name="password" /><div class="input-group-addon"><abbr id="abbrv" title="Capital letter, Small letter, Digit, Symbol & Atleast 9 charecters with no trailing spaces"><i style="font-size:20px" id="info" class="fa" id="last">&#xf05a;</i></abbr></div>&emsp;&emsp;&emsp;&emsp;<input type="password" spellcheck="false" class="form-control col secondpwd" id="cnfpassword" readonly autocomplete="off" placeholder="Confirm" name="cnfpassword"><div class="input-group-addon"><span aria-hidden="true" id="visible" style="font-size:20px" class="fa">&#xf06e;</span></div>
      </div>
      <div class="row mx-auto pt-1" id="formdiv">
        <div class="mx-auto col" id="pwddiv"></div><div class="mx-auto col" id="cnfpwddiv"></div>
      </div>
      <div class="row mx-auto pt-4" id="formdiv1">
        <input type="button" class="btn btn-info col" autocomplete="off" id="signin" name="signin" value="Sign In Instead"><input type="submit" class="btn btn-info col second" id="signup" name="submit" value="Sign Up">
      </div>
    </form>
  </div>
  <div id="container">
  <div id="content">
    <h1>Centered div</h1>
  </div>
  </div>
      <script>
       function password_strong(str){
         var countnum = 0;
         var i;
         for (i = 0; i < str.length-2 ; ++i){
           if (str.substring(i,i+3) == "123" || str.substring(i,i+3) == "234" || str.substring(i,i+3) == "345" || str.substring(i,i+3) == "456" || str.substring(i,i+3) == "567" || str.substring(i,i+3) == "678" || str.substring(i,i+3) == "789"){
             countnum = countnum + 1;
           }
         }
         for (i = 0; i < str.length-1 ; ++i){
           if (str.substring(i,i+2) == "12" || str.substring(i,i+2) == "23" || str.substring(i,i+2) == "34" || str.substring(i,i+2) == "45" || str.substring(i,i+2) == "56" || str.substring(i,i+2) == "67" || str.substring(i,i+2) == "78" || str.substring(i,i+2) == "89"){
             countnum = countnum+1;
           }
         }
         if (countnum >= 1){
           return 0;
         }
         else{
           return 1;
         }
       }
       function password_strong2(str){
         var count = 0;
         var i,j;
         for (i = 0; i <= str.length-3 ; ++i){
           for (j = 0; j <= str.length-3 ; ++j){
             if (i+3 <= j){
                if (str.substring(i,i+3) == str.substring(j,j+3)){
                  count++;
                 }
               }
             }
           }
           if (count == 1 && str.length <=11){
             return 0;
           }
           if (count == 2 && str.length <=15){
             return 0;
           }
           if (count == 3 && str.length <=19){
             return 0;
           }
           if (str.length <= 6*count){
             return 0;
           }
           return 1;
         }
       $(document).ready(function(){
         $("#firstname").focus();
         document.getElementById("signup").disabled = true;
         setTimeout(function (){
           $("#emaildiv").empty();
         },2000);
         $("#firstname").blur(function(){
           if (document.getElementById("firstname").value == ''){
             document.getElementById("fnamediv").className = "col text-danger";
             document.getElementById("fnamediv").innerHTML = "<strong>**This is required</strong>";
             setTimeout(function () {
               $("#fnamediv").empty();
             }, 1000);
           }
         })
         $("#lastname").blur(function(){
           if (document.getElementById("lastname").value == ''){
             document.getElementById("lnamediv").className = "col text-danger";
             document.getElementById("lnamediv").innerHTML = "<strong>**This is required</strong>";
             setTimeout(function(){
               $("#lnamediv").empty();
             }, 1000);
           }
         })
         $("#email").blur(function(){
           var mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
           if (document.getElementById("email").value.trim().match(mailformat)){
           }
           else{
             document.getElementById("emaildiv").className = "col text-danger";
             document.getElementById("emaildiv").innerHTML = "<strong>**Please enter valid Email Id</strong>"
             setTimeout(function(){
               $("#emaildiv").empty();
             }, 1000);
           }
         })
         $("#email").on('input',function(){
           var mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
           if (document.getElementById("email").value.trim().match(mailformat)){
             $("#cnfemail").attr("readonly",false);
           }
           else{
             document.getElementById("cnfemail").value = "";
             $("#cnfemail").attr("readonly",true);
           }
         })
         $("#cnfemail").on('input',function(){
           if (document.getElementById("cnfemail").value.trim() != document.getElementById("email").value.trim()){
             document.getElementById("cnfemaildiv").className = "col text-danger";
             document.getElementById("cnfemaildiv").innerHTML = "<strong>**Didnot match</strong>";
           }
           else{
             document.getElementById("cnfemaildiv").className = "col text-success";
             document.getElementById("cnfemaildiv").innerHTML = "<strong>**Email matched</strong>";
             setTimeout(function(){
               $("#cnfemaildiv").empty();
             }, 1000);
           }
         })
         $("#password").on('input',function(){
           var str = document.getElementById("password").value.trim();
           if (str.match(/[a-z]/g) && str.match(/[A-Z]/g) && str.match(/[0-9]/g) && str.match(/[^a-zA-Z\d]/g) && str.length >= 9){
             $("#cnfpassword").attr("readonly",false);
             if (password_strong(str) == 1 && password_strong2(str) == 1){
               document.getElementById("abbrv").className = "text-success";
               $("#abbrv").attr("title","Quite strong password");
             }
             else if (password_strong(str) == 1 && password_strong2(str) == 0){
               document.getElementById("abbrv").className = "text-warning";
               $("#abbrv").attr("title","Avoid too many repetitions in charecters");
             }
             else if (password_strong(str) == 0 && password_strong2(str) == 0){
               document.getElementById("abbrv").className = "text-warning";
               $("#abbrv").attr("title","Avoid patterns and repetitions in charecters");
             }
             else{
               document.getElementById("abbrv").className = "text-warning";
               $("#abbrv").attr("title","Avoid patterns in digits");
             }
           }
           else if (str.length == 0){
             document.getElementById("abbrv").className = "";
             $("#abbrv").attr("title","Captial letter, Small letter, Digit, Symbol & atleast 9 charecters with no trailing spaces");
             $("#cnfpassword").attr("readonly",true);
           }
           else {
             $("#cnfpassword").attr("readonly",true);
             document.getElementById("cnfpassword").value = "";
             document.getElementById("abbrv").className = "text-danger";
             $("#abbrv").attr("title","Password is too weak");
           }
         })
         $("#cnfpassword").on('input',function(){
            if (document.getElementById("cnfpassword").value!= document.getElementById("password").value){
              document.getElementById("cnfpwddiv").className = "col text-danger";
              document.getElementById("cnfpwddiv").innerHTML = "<strong>**Not matched</strong>";
            }
            else{
              document.getElementById("cnfpwddiv").className = "col text-success";
              document.getElementById("cnfpwddiv").innerHTML = "<strong>**Password matched";
              setTimeout(function(){
                $("#cnfpwddiv").empty();
              }, 1000);
            }
         })
         $("#visible").click(function(){
           if (document.getElementById("password").type == "password"){
             document.getElementById("password").type = "text";
             document.getElementById("cnfpassword").type = "text";
             document.getElementById("visible").innerHTML = "&#xf070;";
           }
           else {
             document.getElementById("password").type = "password";
             document.getElementById("cnfpassword").type = "password";
             document.getElementById("visible").innerHTML = "&#xf06e;";
           }
         })
         $("#firstname").on('input',function(){
           var fname = document.getElementById("firstname");
           var lname = document.getElementById("lastname");
           var mail = document.getElementById("email");
           var cnfmail = document.getElementById("cnfemail");
           var pwd = document.getElementById("password");
           var cnfpwd = document.getElementById("cnfpassword");
           var mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
           if (fname.value.trim().length >= 1 && lname.value.trim().length >= 1 && mail.value.trim() == cnfmail.value.trim() && pwd.value.trim() == cnfpwd.value.trim() && mail.value.trim().match(mailformat) && pwd.value.trim().length >= 3){
             document.getElementById("signup").disabled = false;
           }
           else{
             document.getElementById("signup").disabled = true;
           }
         })
         $("#lastname").on('input',function(){
           var fname = document.getElementById("firstname");
           var lname = document.getElementById("lastname");
           var mail = document.getElementById("email");
           var cnfmail = document.getElementById("cnfemail");
           var pwd = document.getElementById("password");
           var cnfpwd = document.getElementById("cnfpassword");
           var mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
           if (fname.value.trim().length >= 1 && lname.value.trim().length >= 1 && mail.value.trim() == cnfmail.value.trim() && pwd.value.trim() == cnfpwd.value.trim() && mail.value.trim().match(mailformat) && pwd.value.trim().length >= 3){
             document.getElementById("signup").disabled = false;
           }
           else{
             document.getElementById("signup").disabled = true;
           }
         })
         $("#cnfemail").on('input',function(){
           var fname = document.getElementById("firstname");
           var lname = document.getElementById("lastname");
           var mail = document.getElementById("email");
           var cnfmail = document.getElementById("cnfemail");
           var pwd = document.getElementById("password");
           var cnfpwd = document.getElementById("cnfpassword");
           var mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
           if (fname.value.trim().length >= 1 && lname.value.trim().length >= 1 && mail.value.trim() == cnfmail.value.trim() && pwd.value.trim() == cnfpwd.value.trim() && mail.value.trim().match(mailformat) && pwd.value.trim().length >= 3){
             document.getElementById("signup").disabled = false;
           }
           else{
             document.getElementById("signup").disabled = true;
           }
         })
         $("#cnfpassword").on('input',function(){
           var fname = document.getElementById("firstname");
           var lname = document.getElementById("lastname");
           var mail = document.getElementById("email");
           var cnfmail = document.getElementById("cnfemail");
           var pwd = document.getElementById("password");
           var cnfpwd = document.getElementById("cnfpassword");
           var mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
           if (fname.value.trim().length >= 1 && lname.value.trim().length >= 1 && mail.value.trim() == cnfmail.value.trim() && pwd.value.trim() == cnfpwd.value.trim() && mail.value.trim().match(mailformat) && pwd.value.trim().length >= 3){
             document.getElementById("signup").disabled = false;
           }
           else{
             document.getElementById("signup").disabled = true;
           }
         })
         $("#email").on('input',function(){
           var fname = document.getElementById("firstname");
           var lname = document.getElementById("lastname");
           var mail = document.getElementById("email");
           var cnfmail = document.getElementById("cnfemail");
           var pwd = document.getElementById("password");
           var cnfpwd = document.getElementById("cnfpassword");
           var mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
           if (fname.value.trim().length >= 1 && lname.value.trim().length >= 1 && mail.value.trim() == cnfmail.value.trim() && pwd.value.trim() == cnfpwd.value.trim() && mail.value.trim().match(mailformat) && pwd.value.trim().length >= 3){
             document.getElementById("signup").disabled = false;
           }
           else{
             document.getElementById("signup").disabled = true;
           }
         })
         $("#password").on('input',function(){
           var fname = document.getElementById("firstname");
           var lname = document.getElementById("lastname");
           var mail = document.getElementById("email");
           var cnfmail = document.getElementById("cnfemail");
           var pwd = document.getElementById("password");
           var cnfpwd = document.getElementById("cnfpassword");
           var mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
           if (fname.value.trim().length >= 1 && lname.value.trim().length >= 1 && mail.value.trim() == cnfmail.value.trim() && pwd.value.trim() == cnfpwd.value.trim() && mail.value.trim().match(mailformat) && pwd.value.trim().length >= 3){
             document.getElementById("signup").disabled = false;
           }
           else{
             document.getElementById("signup").disabled = true;
           }
         })
       })
      </script>
      <script>
       $(document).ready(function(){
         $("#restrict").click(function(){
           Swal.fire({
             //icon: 'info',
             title: '<strong>Restrictions</strong>',
             html: '<span>Password must have</span></br><span>Atleast 9 charecters</span></br><span style="margin-left: -10px;">Atleast 1 digit</span>'
           })
         })
         $("#container").click(function(){
          $("#bigdiv").css("opacity","1");
          $("#container").css("display","none");
         })
       })
      </script>
</body>
</html>
