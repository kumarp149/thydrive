<?php

$file = fopen('train.csv','r');
$file_new = fopen('submit.csv','w');
//fputcsv($file_new, array("animal_id_outcome","outcome_type"));
while (!feof($file))
{
    if ($arr = fgetcsv($file))
    {
        $len = sizeof($arr);
        $arr_put = array($arr[0],$arr[$len-1]);
        //fputcsv($file_new,$arr_put,",","^");
        fwrite($file_new, implode(",", $arr_put));
        fwrite($file_new,"\n");
    }
}

?>