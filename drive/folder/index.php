<?php

if (!isset($_GET['id']) || strlen($_GET['id']) != 16)
{
  header('Content-Type: text/html');
  $ch = curl_init();
  curl_setopt($ch,CURLOPT_SSL_VERIFYPEER, false);
  curl_setopt($ch, CURLOPT_URL, 'https://storage.googleapis.com/sruteesh-static-pages/404.html');
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  $result = curl_exec($ch);
  if (curl_errno($ch)) 
  {
    echo 'Error:' . curl_error($ch);
  }
  curl_close($ch);
  echo $result;
  die();
}

?>