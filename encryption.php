<?php
session_start();
function strong($string)
{
  if (base64_encode(base64_decode($string,true)) === $string)
  {
    return 1;
  }
  return 0;
}
if (isset($_POST['submit']))
{
  if ($_POST['firstcount'] == 1)
  {

  }
  elseif ($_POST['secondcount'] == 1 && $_POST['key'] == "")
  {
    $_SESSION['no_key_error'] = "Encryption Key cannot be empty";
    header('Location: encryption.php');
    die();
  }
  elseif ($_POST['secondcount'] == 1 && $_POST['key'] != "")
  {
    if (strong($_POST['key']) == 0)
    {
      $_SESSION['no_key_error'] = "Encryption Key must be base64 encoded";
      header('Location: encryption.php');
      die();
    }
  }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Encryption</title>
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
    .text-align
    {
      text-align: center;
    }
    .title
    {
      margin-top: 80px;
    }
    .description
    {
      margin-top: 1.5%;
    }
    .form
    {
      text-align: center;
    }
    .option1,.option2
    {
      width: 190px;
      height: 50px;
      border: 2px solid;
      border-color: #DCDCDC;
      cursor: pointer;
      padding-top: 9px;
    }
    .option1:hover,.option2:hover
    {
      background-color: #F5F5F5;
    }
    .option1
    {
      margin-top: 30px;
    }
    input[type=radio]
    {
      cursor: pointer;
    }
    label
    {
      cursor: pointer;
    }
    .hidden_input
    {
      display: none;
    }
    .submit
    {
      width: 90px;
    }
    .keydiv
    {
      width: 25%;
      min-width: 310px;
      margin-top: 20px;
    }
  </style>
</head>
<body>
  <div class="container text-align title">Choose your <strong>File Encryption</strong> settings</div>
  <div class="container text-align description">Note: <strong>This choice is permanent.<a href="https://google.com">Learn more</a></strong></div>
  <form method="post" class="form" id="form" autocomplete="off" action="encryption.php">
    <label for="opt1" class="container pl-4 option1">
      <input type="radio" id="opt1" class="opt1" name="setting" autocomplete="off">
      <label for="opt1" class="ml-1 label1">Let us manage</label>
    </label></br>
    <label class="container pl-4 mt-3 option2">
      <input type="radio" id="opt2" class="opt2" name="setting" autocomplete="off" checked>
      <label for="opt2" class="ml-1 label2">Manage yourself</label>
    </label>
    <div class="container text-align keydiv mx-auto">
      <label id="labelforkey" class="labelforkey" for="key_enter"><strong>Enter your custom Key</strong></label><br>
      <input type="text" placeholder="Enter" class="form-control key_enter mt-1" id="key_enter" name="key" autocomplete="off">
      <div class="text-danger error-div">
      <?php
      session_start();
      if (isset($_SESSION['no_key_error']))
      {
        echo $_SESSION['no_key_error'];
      }
      unset($_SESSION['no_key_error']);
      ?>
      </div>
    </div>
    <input type="number" name="firstcount" class="hidden_input" id="firstcount">
    <input type="number" name="secondcount" class="hidden_input" id="secondcount">
    <div class="container text-align submit mt-4">
      <input type="submit" value="Submit" name="submit" class="form-control mt-5 submit btn-info" id="submit">
    </div>
  </form>
  <script>
    $(document).ready(function(){
      setTimeout(function(){
        $(".error-div").empty();
      },1500);
      $(".key_enter").focus();
      document.getElementById("firstcount").value = 0;
      document.getElementById("secondcount").value = 1;
      $(".opt1").on('click',function(){
        $(".keydiv").hide();
        document.getElementById("firstcount").value = 1;
        document.getElementById("secondcount").value = 0;
      })
      $(".opt2").on('click',function(){
        $(".keydiv").show();
        document.getElementById("secondcount").value = 1;
        document.getElementById("firstcount").value = 0;
      })
    })
  </script>
</body>
