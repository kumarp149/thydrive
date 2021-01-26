<?php
$file_location = '/var/www/gcsfuse/';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

use Google\Cloud\Storage\StorageClient;

include('../important/php/req_functions.php');

require '../vendor/autoload.php';

$conn = new mongo($mongo_url);

if (!isset($_GET['id']) || strlen($_GET['id']) != 16)
{

}
else
{
  $file_doc = $conn->fetch_doc("thydrive","files",['id' => $_GET['id']]);
  $arr = (array) $file_doc;
  if (sizeof($arr) == 0)
  {

  }
  else
  {
    if ($arr['public'] == 1)
    {
      $file = pathinfo($file_location.$arr['location']); 
      smartReadFile($file_location.$arr['location'],$file['basename'],mime_content_type($file_location.$arr['location']));
      die();
    }
    else if ($arr['public'] == 0)
    {
      if (valid_session($sql_server,$sql_username,$sql_password) == 0)
      {
        if (in_array($_SESSION['emailid'],$arr['values']) == 1)
        {
          $file = pathinfo($file_location.$arr['location']); 
          smartReadFile($file_location.$arr['location'],$file['basename'],mime_content_type($file_location.$arr['location']));
          die();
        }
        else
        {
          header('../index.php');
          die();
        }
      }
      else
      {

      }
    }
  }
}



?>