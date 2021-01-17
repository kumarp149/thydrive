<?php
print_r($_FILES);
$result = "";

foreach ($_FILES as $file)
{
    if ($file['error'] > 0)
    {
        continue;
        $result .= " A file cannot be uploaded";
    }
    move_uploaded_file($file['tmp_name'],'temp_files/'.$file['name']);
}

?>