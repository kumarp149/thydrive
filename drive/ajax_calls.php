<?php
function recurseRmdir($dir) 
{
    $files = array_diff(scandir($dir), array('.','..'));
    foreach ($files as $file) 
    {
      (is_dir("$dir/$file")) ? recurseRmdir("$dir/$file") : unlink("$dir/$file");
    }
    return rmdir($dir);
  }
clearstatcache();
if ($_GET['action'] == "rename" && $_GET['type'] == "file")
{
    if ($_GET['initial_name'] == $_GET['final_name'])
    {
        //echo json_encode(array('success => 0'));    //0 mean that there is no change in the file name
        echo "0";
    }
    else if ($_GET['initial_name'] != $_GET['final_name'])
    {
        $str = strtolower($_GET['final_name']);
        if (strpos($str,"thydrive") !== false)
        {
            echo "THYDRIVE";
            die();
        }
        else if (strpos($str,'\\') !== false || strpos($str,'/') !== false || strpos($str,'*') !== false || strpos($str,'?') !== false || strpos($str,'|') !== false || strpos($str,'<') !== false || strpos($str,'>') !== false || strpos($str,':') !== false || strpos($str,'"') !== false)
        {
            echo "INVALID";
            die();
        }
        else if (strlen($_GET['final_name']) >= 20)
        {
            echo "LARGE";
            die();
        }
        else if (file_exists($_GET['final_name']) == 1)
        {
            echo "EXISTS";
            die();
        }
        else if (file_exists($_GET['final_name']) == 0)
        {
            rename($_GET['initial_name'],$_GET['final_name']);
            echo "1";
        }
    }
}
else if ($_GET['action'] == "rename" && $_GET['type'] == "dir")
{
    if ($_GET['initial_name'] == $_GET['final_name'])
    {
        echo "0";
    }
    else if ($_GET['initial_name'] != $_GET['final_name'])
    {
        $str = strtolower($_GET['final_name']);
        if (strpos($str,"thydrive") !== false)
        {
            echo "THYDRIVE";
            die();
        }
        else if (strpos($str,'\\') !== false || strpos($str,'/') !== false || strpos($str,'*') !== false || strpos($str,'?') !== false || strpos($str,'|') !== false || strpos($str,'<') !== false || strpos($str,'>') !== false || strpos($str,':') !== false || strpos($str,'"') !== false)
        {
            echo "INVALID";
            die();
        }
        else if (strlen($_GET['final_name']) >= 19)
        {
            echo "LARGE";
            die();
        }
        else if (file_exists($_GET['final_name']) == 1)
        {
            echo "EXISTS";
            die();
        }
        else if (file_exists($_GET['final_name']) == 0)
        {
            rename($_GET['initial_name'],$_GET['final_name']);
            echo "1";
            die();
        }
    }
}
else if ($_GET['action'] == "delete")
{
    foreach ($_GET['files_arr'] as $file)
    {
        if (is_file($file))
        {
            unlink($file);
        }
    }
    foreach ($_GET['dirs_arr'] as $dir)
    {
        if (is_dir($dir))
        {
            recurseRmdir($dir);
        }
    }
    echo "1";
}

?>