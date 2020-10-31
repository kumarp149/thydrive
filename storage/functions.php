<?php
use Google\Cloud\Storage\StorageClient;
require 'C:\MAMP\htdocs\thydrive\vendor\autoload.php';

function create_bucket($bucketName, $options = [])
{
    $storage = new StorageClient([
        'keyFile' => json_decode(file_get_contents('key.json'), true)
    ]);
    $bucket = $storage->createBucket($bucketName, $options);
}


function upload_object($bucketName, $objectName, $source)
{
    $storage = new StorageClient([
        'keyFile' => json_decode(file_get_contents('key.json'), true)
    ]);
    $file = fopen($source, 'r');
    $bucket = $storage->bucket($bucketName);
    $object = $bucket->upload($file, [
        'name' => $objectName
    ]);
}
function create_folder($bucketName, $folderName)
{
    upload_object($bucketName, $folderName."/Welcome.pdf",'Welcome.pdf');
}
function delete_bucket($bucketName)
{
    $storage = new StorageClient();
    $bucket = $storage->bucket($bucketName);
    $bucket->delete();
}
?>