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
  $access = 0;
  $file_doc = $conn->fetch_doc("thydrive","files",['id' => $_GET['id']]);
  $arr = (array) $file_doc;
  if (sizeof($arr) == 0)
  {

  }
  else
  {
    $folder_arr = explode("/",$arr['url']);
    $url_now = $folder_arr[0]."/".$folder_arr[1];
    for ($i = 2; $i < sizeof($folder_arr); ++$i)
    {
      if ($i == sizeof($folder_arr)-1)
      {
        $url_now = $url_now."/".$folder_arr[$i];
        $temp_doc = $conn->fetch_doc("thydrive","files",['url' => $url_now]);
        $temp_arr = (array) $temp_doc;
        if (isset($_SESSION['emailid']) && $temp_arr['public'] == 0)
        {
          if (in_array($_SESSION['emailid'],$temp_arr['users']))
          {
            $access = 1;
            $final_url = $url_now;
            break;
          }
        }
        else if ($temp_arr['public'] == 1)
        {
          $access = 1;
          $final_url = $url_now;
          break;
        }
      }
      $url_now = $url_now."/".$folder_arr[$i];
      $temp_doc = $conn->fetch_doc("thydrive","folders",['url' => $url_now]);
      $temp_arr = (array) $temp_doc;
      if (isset($_SESSION['emailid']) && $temp_arr['public'] == 0)
      {
        if (in_array($_SESSION['emailid'],$temp_arr['users']))
        {
          $access = 1;
          $final_url = $url_now;
          break;
        }
      }
      else if ($temp_arr['public'] == 1)
      {
        $access = 1;
        $final_url = $url_now;
        break;
      }
    }
  }
}



?>