<?php
clearstatcache();
if ($_GET['action'] == "rename")
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
            echo "Invalid";
        }
        else if (strlen($_GET['final_name']) >= 20)
        {
            echo "Large";
        }
        else if (file_exists($_GET['final_name']) == 1)
        {
            echo "Exists";
        }
        else if (file_exists($_GET['final_name']) == 0)
        {
            rename($_GET['initial_name'],$_GET['final_name']);
            echo "1";
        }
    }
}

?>