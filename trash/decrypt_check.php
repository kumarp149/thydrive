<?php

function my_encrypt($data, $key) {          //Encryption algorithm
    $encryption_key = base64_decode($key);
    $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
    $encrypted = openssl_encrypt($data, 'aes-256-cbc', $encryption_key, 0, $iv);
    return base64_encode($encrypted . '::' . $iv);
  }
  
function my_decrypt($data, $key) {        //Decryption algorithm
    $encryption_key = base64_decode($key);
    list($encrypted_data, $iv) = explode('::', base64_decode($data), 2);
    return openssl_decrypt($encrypted_data, 'aes-256-cbc', $encryption_key, 0, $iv);
  }

$string1 = my_decrypt("c0RKQmNpL2QxamZNcnM1TVZCKzNoUT09Ojq1yqHMKU+kPo70VbIDA9GE","76zzk1Tf-&pyh8a5rT#18C+c++8r0y6P+6@SUB#G");
$string2 = my_decrypt("dU5QSE1BWmEzOExzdTNPS2VwdzNPUT09OjpODtjjXZALeCKG9M3A8aIh","76zzk1Tf-&pyh8a5rT#18C+c++8r0y6P+6@SUB#G");
$string3 = my_decrypt("dnBmSTY0em11N2tsamUxVWJtazQ4TTFaalhiV1ozSnZEMERESkIzSmd1cz06OjFRPxeTed0nJhWYaVEcgkM=","76zzk1Tf-&pyh8a5rT#18C+c++8r0y6P+6@SUB#G");
$string4 = my_decrypt("SzNBZFBBS1JlNXIxMDkrZ1VCSjM0UT09OjrvGZEZEoIZTYa+wGQiqD/1","76zzk1Tf-&pyh8a5rT#18C+c++8r0y6P+6@SUB#G");
$string5 = my_decrypt("ZHFhY0x0bmY1cjE2S0dYMkNJeGVhdz09Ojppw8nllIYTHXpPOV8H+Owz","76zzk1Tf-&pyh8a5rT#18C+c++8r0y6P+6@SUB#G");

echo $string1."\n";
echo $string2."\n";
echo $string3."\n";
echo $string4."\n";
echo $string5."\n";
?>