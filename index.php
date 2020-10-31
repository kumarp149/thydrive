<?php

session_start();
if (isset($_SESSION['emailid']) && isset($_SESSION['pwdentered'])){
/*?>
  <script type="text/javascript">      
    window.location.href = "http://mathlearn.icu/drive";
  </script>
<?php*/
  header('Location: http://mathlearn.icu/drive/files/0');
  die();
}

unset($_SESSION['code']);
unset($_SESSION['email']);
unset($_SESSION['pwdentered']);
unset($_SESSION['emailid']);

function randstring($length){                      //Used to generate sessionid
  $char = 'acegikmoqsuwyBDFHJLNPRTVXZ';
  for ($i = 0; $i < $length; ++$i){
    $string .= $char[rand(0,26)];
  }
  return $string;
}


if (! isset($_SESSION['id'])){                    //if sessionid is not set, generate it
  $_SESSION['id'] = randstring(20);
  $id = $_SESSION['id'];
}
if ($_GET['id'] != $_SESSION['id']){
  header('Location: http://mathlearn.icu?email&service=login&domain=mathlearn.icu&redirect_to_page=password&id='.$_SESSION['id'].'');
  exit();
}
if ($_GET['redirect_to_page'] != "password"){
  header('Location: http://mathlearn.icu?email&service=login&domain=mathlearn.icu&redirect_to_page=password&id='.$_SESSION['id'].'');
  exit();
}
if ($_GET['service'] != "login"){
  header('Location: http://mathlearn.icu?email&service=login&domain=mathlearn.icu&redirect_to_page=password&id='.$_SESSION['id'].'');
  exit();
}
if ($_GET['domain'] != "mathlearn.icu"){
  header('Location: http://mathlearn.icu?email&service=login&domain=mathlearn.icu&redirect_to_page=password&id='.$_SESSION['id'].'');
  exit();
}


function clean_text($string)                          //removes trailing spaces
{
 $string = trim($string);
 $string = stripslashes($string);
 $string = htmlspecialchars($string);
 $string = strtolower($string);
 return $string;
}

function my_encrypt($data, $key) {                    //Encrypting a string with a key
    $encryption_key = base64_decode($key);
    $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
    $encrypted = openssl_encrypt($data, 'aes-256-cbc', $encryption_key, 0, $iv);
    return base64_encode($encrypted . '::' . $iv);
}

function my_decrypt($data, $key) {            //Decrypting the encrypted string with the encryption key
    $encryption_key = base64_decode($key);
    list($encrypted_data, $iv) = explode('::', base64_decode($data), 2);
    return openssl_decrypt($encrypted_data, 'aes-256-cbc', $encryption_key, 0, $iv);
}


if (isset($_POST['submit'])){
  $count = 0;
  $email = clean_text($_POST['email']);
  $conn = new mysqli('localhost','sruteeshP','32175690Pq','logindata');
  $sql = "SELECT EmailId, Password, Crypt FROM logininfo";
  $result = $conn->query($sql);
  if ($result->num_rows > 0){
    while ($row = $result->fetch_assoc()){
      if (my_decrypt($row['EmailId'],$row['Crypt']) == $email){
        $conn->close();
        $count = $count + 1;
        session_start();
        $_SESSION['email'] = $email;
        break;
        die();
      }
    }
  }
  if ($count > 0){
    header('Location: http://mathlearn.icu/password1.php');
    exit();
  }
  if ($count == 0){
    session_start();
    $_SESSION['noemail'] = "No account found";
    header('Location: http://mathlearn.icu?email&service=login&domain=mathlearn.icu&redirect_to_page=password&id='.$_SESSION['id'].'');
    die();
  }
}

if (array_key_exists('createaccount', $_POST)){
  session_start();
  $_SESSION['creating'] = "Yes";
  header('Location: create-account.php?details&service=signup&redirect_to_page=email_confirmation&id='.$_SESSION['id']);
  exit();
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
  #container-primary{
  }
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
  #email-form{
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
    <div class="container mt-3" id="container-secondary"><h3>Welcome</h3><br> Please Enter your <strong><label for="email">Email</label></strong> to continue</br>
    </div>
    <div class="container pt-2" id="container-tertiary">
      <form method="post" id="email-form" autocomplete="off">
          <input type="text" class="form-control mx-auto" id="email" placeholder="Email" name="email" spellcheck="false"></input>
        <div class="container" id="email-error-container"><?php
        session_start();
        if (isset($_SESSION['noemail'])){
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
