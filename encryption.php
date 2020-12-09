<?php

/*ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);*/

session_start();

include('req_functions.php');

function encryption_key()
{
  $str = randid(mt_rand(0,6));
  $key = substr(hash("sha256",$str),0,32);
  return $key;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Encryption</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
  <script src="https://code.jquery.com/jquery-latest.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <script data-ad-client="ca-pub-4991407935211785" async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
  <script>
    //window.addEventListener('keydown',function(e){if(e.keyIdentifier=='U+000A'||e.keyIdentifier=='Enter'||e.keyCode==13){if(e.target.nodeName=='INPUT'&&e.target.type=='text'){e.preventDefault();return false;}}},true);
  </script>
  <style>
    .text-align
    {
      text-align: center;
    }
    .title
    {
      margin-top: 80px;
    }
    .description
    {
      margin-top: 1.5%;
    }
    .form
    {
      text-align: center;
    }
    .option1,.option2
    {
      width: 190px;
      height: 50px;
      border: 2px solid;
      border-color: #DCDCDC;
      cursor: pointer;
      padding-top: 9px;
    }
    .option1:hover,.option2:hover
    {
      background-color: #F5F5F5;
    }
    .option1
    {
      margin-top: 30px;
    }
    input[type=radio]
    {
      cursor: pointer;
    }
    label
    {
      cursor: pointer;
    }
    .hidden_input
    {
      display: none;
    }
    .submit
    {
      width: 90px;
    }
    .keydiv
    {
      width: 22%;
      min-width: 320px;
      margin-top: 20px;
    }
    #key_enter
    {
      text-align: center;
    }
    #visible{
      cursor: pointer;
      position: relative;
      top: 7px;
      left: 20px;
    }
    i.keyrefresh
    {
      cursor: pointer;
      margin-top: 1px;
      margin-bottom: 3px;
    }
    label
    {
    -webkit-touch-callout: none;
    -webkit-user-select: none;
    -khtml-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
   }
   .keyrefresh
    {
    -webkit-touch-callout: none;
    -webkit-user-select: none;
    -khtml-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
   }
  </style>
</head>
<body>
  <div class="container text-align title">Choose your <strong>File Encryption</strong> settings</div>
  <div class="container text-align description">Note: <strong>This choice is permanent.<a href="https://google.com">Learn more</a></strong></div>
  <form method="post" class="form" id="form" autocomplete="off" action="encryption.php">
    <label for="opt1" class="container pl-4 option1">
      <input type="radio" id="opt1" class="opt1" name="setting" autocomplete="off">
      <label for="opt1" class="ml-1 label1">Let us manage</label>
    </label></br>
    <label class="container pl-4 mt-3 mb-0 option2">
      <input type="radio" id="opt2" class="opt2" name="setting" autocomplete="off" checked>
      <label for="opt2" class="ml-1 label2">Manage yourself</label>
    </label>
    <div class="container text-align keydiv mx-auto">
      <i style="font-size:24px" class="fa keyrefresh">&#xf021;</i>
      <input type="text" class="form-control key_enter mt-3" id="key_enter" name="key" autocomplete="off" readonly />
      <div class="text-danger error-div">
      </div>
    </div>
    <input type="number" name="firstcount" class="hidden_input" id="firstcount">
    <input type="number" name="secondcount" class="hidden_input" id="secondcount">
    <div class="container text-align submit mt-1">
      <input type="submit" value="Submit" name="submit" class="form-control mt-3 submit btn-info" id="submit">
    </div>
  </form>
  <script>
function SHA256(s)
{ 
 var chrsz   = 8;
 var hexcase = 0;
 function safe_add (x, y)
  {
   var lsw = (x & 0xFFFF) + (y & 0xFFFF);
   var msw = (x >> 16) + (y >> 16) + (lsw >> 16);
   return (msw << 16) | (lsw & 0xFFFF);
 }
 function S (X, n) { return ( X >>> n ) | (X << (32 - n)); }
 function R (X, n) { return ( X >>> n ); }
 function Ch(x, y, z) { return ((x & y) ^ ((~x) & z)); }
 function Maj(x, y, z) { return ((x & y) ^ (x & z) ^ (y & z)); }
 function Sigma0256(x) { return (S(x, 2) ^ S(x, 13) ^ S(x, 22)); }
 function Sigma1256(x) { return (S(x, 6) ^ S(x, 11) ^ S(x, 25)); }
 function Gamma0256(x) { return (S(x, 7) ^ S(x, 18) ^ R(x, 3)); }
 function Gamma1256(x) { return (S(x, 17) ^ S(x, 19) ^ R(x, 10)); }

 function core_sha256 (m, l) 
 {
   var K = new Array(0x428A2F98, 0x71374491, 0xB5C0FBCF, 0xE9B5DBA5, 0x3956C25B, 0x59F111F1, 0x923F82A4, 0xAB1C5ED5, 0xD807AA98, 0x12835B01, 0x243185BE, 0x550C7DC3, 0x72BE5D74, 0x80DEB1FE, 0x9BDC06A7, 0xC19BF174, 0xE49B69C1, 0xEFBE4786, 0xFC19DC6, 0x240CA1CC, 0x2DE92C6F, 0x4A7484AA, 0x5CB0A9DC, 0x76F988DA, 0x983E5152, 0xA831C66D, 0xB00327C8, 0xBF597FC7, 0xC6E00BF3, 0xD5A79147, 0x6CA6351, 0x14292967, 0x27B70A85, 0x2E1B2138, 0x4D2C6DFC, 0x53380D13, 0x650A7354, 0x766A0ABB, 0x81C2C92E, 0x92722C85, 0xA2BFE8A1, 0xA81A664B, 0xC24B8B70, 0xC76C51A3, 0xD192E819, 0xD6990624, 0xF40E3585, 0x106AA070, 0x19A4C116, 0x1E376C08, 0x2748774C, 0x34B0BCB5, 0x391C0CB3, 0x4ED8AA4A, 0x5B9CCA4F, 0x682E6FF3, 0x748F82EE, 0x78A5636F, 0x84C87814, 0x8CC70208, 0x90BEFFFA, 0xA4506CEB, 0xBEF9A3F7, 0xC67178F2);
   var HASH = new Array(0x6A09E667, 0xBB67AE85, 0x3C6EF372, 0xA54FF53A, 0x510E527F, 0x9B05688C, 0x1F83D9AB, 0x5BE0CD19);
   var W = new Array(64);
   var a, b, c, d, e, f, g, h, i, j;
   var T1, T2;

   m[l >> 5] |= 0x80 << (24 - l % 32);
   m[((l + 64 >> 9) << 4) + 15] = l;

   for ( var i = 0; i<m.length; i+=16 ) 
   {
     a = HASH[0];
     b = HASH[1];
     c = HASH[2];
     d = HASH[3];
     e = HASH[4];
     f = HASH[5];
     g = HASH[6];
     h = HASH[7];

     for ( var j = 0; j<64; j++) 
     {
       if (j < 16) W[j] = m[j + i];
       else W[j] = safe_add(safe_add(safe_add(Gamma1256(W[j - 2]), W[j - 7]), Gamma0256(W[j - 15])), W[j - 16]);
       T1 = safe_add(safe_add(safe_add(safe_add(h, Sigma1256(e)), Ch(e, f, g)), K[j]), W[j]);
       T2 = safe_add(Sigma0256(a), Maj(a, b, c));
       h = g;
       g = f;
       f = e;
       e = safe_add(d, T1);
       d = c;
       c = b;
       b = a;
       a = safe_add(T1, T2);
     }
     HASH[0] = safe_add(a, HASH[0]);
     HASH[1] = safe_add(b, HASH[1]);
     HASH[2] = safe_add(c, HASH[2]);
     HASH[3] = safe_add(d, HASH[3]);
     HASH[4] = safe_add(e, HASH[4]);
     HASH[5] = safe_add(f, HASH[5]);
     HASH[6] = safe_add(g, HASH[6]);
     HASH[7] = safe_add(h, HASH[7]);
   }
   return HASH;
 }
 function str2binb (str) 
 {
   var bin = Array();
   var mask = (1 << chrsz) - 1;
   for(var i = 0; i < str.length * chrsz; i += chrsz) {
     bin[i>>5] |= (str.charCodeAt(i / chrsz) & mask) << (24 - i%32);
   }
   return bin;
 }

 function Utf8Encode(string) 
 {
   string = string.replace(/\r\n/g,"\n");
   var utftext = "";
   for (var n = 0; n < string.length; n++) 
   {
     var c = string.charCodeAt(n);
     if (c < 128) 
     {
       utftext += String.fromCharCode(c);
     }
     else if((c > 127) && (c < 2048)) 
     {
       utftext += String.fromCharCode((c >> 6) | 192);
       utftext += String.fromCharCode((c & 63) | 128);
     }
     else 
     {
       utftext += String.fromCharCode((c >> 12) | 224);
       utftext += String.fromCharCode(((c >> 6) & 63) | 128);
       utftext += String.fromCharCode((c & 63) | 128);
     }
   }
   return utftext;
 }
 function binb2hex (binarray) 
 {
   var hex_tab = hexcase ? "0123456789ABCDEF" : "0123456789abcdef";
   var str = "";
   for(var i = 0; i < binarray.length * 4; i++) 
   {
     str += hex_tab.charAt((binarray[i>>2] >> ((3 - i%4)*8+4)) & 0xF) +
     hex_tab.charAt((binarray[i>>2] >> ((3 - i%4)*8  )) & 0xF);
   }
   return str;
 }
 s = Utf8Encode(s);
 return binb2hex(core_sha256(str2binb(s), s.length * chrsz));
}
  </script>
  <script>
    function makeid(length)
    {
      var result = '';
      var chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789@#()+-_{}?><~&^%';
      var charactersLength = chars.length;
      for (i = 0; i < length; ++i)
      {
        result += chars.charAt(Math.floor(Math.random() * charactersLength));
      }
      return result;
    }
  </script>
  <script>
    $(document).ready(function(){
      setTimeout(function(){
        $(".error-div").empty();
      },1500);
      $(".key_enter").focus();
      document.getElementById("firstcount").value = 0;
      document.getElementById("secondcount").value = 1;
      $(".opt1").on('click',function(){
        $(".keydiv").hide();
        document.getElementById("firstcount").value = 1;
        document.getElementById("secondcount").value = 0;
      })
      $(".opt2").on('click',function(){
        $(".keydiv").show();
        document.getElementById("secondcount").value = 1;
        document.getElementById("firstcount").value = 0;
      })
    })
    $(document).ready(function(){
      var x = "<?php echo encryption_key(); ?>";
      $("#key_enter").val(x);
      $(".keyrefresh").on('click',function(){
        var y = SHA256(makeid(5));
        $("#key_enter").val(y.substring(0,32));
      })
    })
  </script>
</body>
