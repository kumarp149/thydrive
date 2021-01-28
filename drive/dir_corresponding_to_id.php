<?php
$dir_location = '/var/www/gcsfuse/';
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
  $dir_doc = $conn->fetch_doc("thydrive","folders",['id' => $_GET['id']]);
  $arr = (array) $dir_doc;
  if (sizeof($arr) == 0)
  {

  }
  else
  {
    $folder_arr = explode("/",$arr['url']);
    $url_now = $folder_arr[0].$folder_arr[1];                   //name of folder corresponding to a user
    for ($i = 2; $i < sizeof($folder_arr); ++$i)
    {
      $url_now = $url_now."/".$folder_arr[$i];
      $temp_doc = $conn->fetch_doc("thydrive","folders",['url' => $url_now]);
      $temp_arr = (array) $temp_doc;
      if (isset($_SESSION['emailid']))
      {
        if (in_array($_SESSION['emailid'],$temp_arr['users']) == 1)
        {
          $access = 1;
          $final_url = $url_now;
          break;
        }
      }
      else
      {
        if ($temp_arr['public'] == 1)
        {
          $access = 1;
          $final_url = $url_now;
          break;
        }
      }
    }
    if ($access == 0)
    {

    }
    else
    {
      $date = 'M-d-y';
      $files = [];
      $dirs = [];
      $files_list = $bucket->objects([
        'prefix' => $url_now,
        'delimiter' => '/'
      ]);
      foreach ($files_list as $f)
      {
        $temp_files = [];
        $obj = $bucket->object($f->name());
        $info = $obj->info();
        //echo $info['name']."<br>";
        if ($info['name'] == $dir) continue;
        $pos = strrpos($info['id'],"/");
        $id = substr($info['id'],$pos+1,16);
        $url = "file/".$id;
        $temp_files['name'] = str_replace($dir,"",$f->name());  //name given
        $temp_files['url'] = $url;                              //url given
        $date = substr($info['updated'],0,10);
        $dt = new DateTime($date);
        $temp_files['date'] = $dt->format('m-d-Y');             //date given
        $temp_files['size'] = $info['size'];                    //size given
        array_push($files,$temp_files);
      }
      $dirs_list = $files_list->prefixes();
      foreach ($dirs_list as $d)
      {
        $temp_dirs = [];
        $obj = $bucket->object($d);
        $info = $obj->info();
        $temp_dirs['name'] = str_replace($dir,"",$info['name']); //name given
        $temp_dirs['name'] = substr($temp_dirs['name'],0,strlen($temp_dirs['name'])-1);
        $id = substr($info['id'],strlen($info['id'])-16,16);
        $temp_dirs['url'] = "folder/".$id;      //url given
        $date = substr($info['updated'],0,10);
        $dt = new DateTime($date);
        $temp_dirs['date'] = $dt->format('m-d-Y');             //date given
        array_push($dirs,$temp_dirs);
      }
    }
  }
}

?>


<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <!--<meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">-->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Drive</title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.12.0/css/all.css">
    <link rel="stylesheet" href="view-source:https://assets.gitlab-static.net/assets/application-7403f60a856c785734d794f3f673e3d370cd97cd2fe308e29ca85f3e2ea2c653.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/10.6.1/sweetalert2.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/10.6.1/sweetalert2.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://s3.ap-south-1.amazonaws.com/cdn.sruteesh.icu/css/sementic/semantic.min.css">
    <link rel="stylesheet" href="https://s3.ap-south-1.amazonaws.com/cdn.sruteesh.icu/css/bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/material-design-icons/3.0.1/iconfont/material-icons.min.css">
    <!--<link href="https://storage.googleapis.com/sruteesh-static-pages/index_main.css" rel='stylesheet'>-->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Spectral+SC:wght@600&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Patua+One&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Rufina:wght@700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Vollkorn&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Serif:wght@300&family=Zilla+Slab:wght@300&display=swap" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.3/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.js"></script>
    <!--<link rel="stylesheet" href="https://unpkg.com/purecss@2.0.3/build/pure-min.css" integrity="sha384-4ZPLezkTZTsojWFhpdFembdzFudphhoOzIunR1wH6g1WQDzCAiPvDyitaK67mp0+" crossorigin="anonymous">-->
    <!--<script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/3.1.2/components/aes-min.js"></script>-->
    <!--<script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/4.0.0/crypto-js.min.js"></script>-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/3.1.9-1/crypto-js.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/3.1.2/rollups/aes.js"></script>
    <style type="text/css">
    .cont 
    {
  display: block;
  position: relative;
  padding-left: 35px;
  margin-bottom: 12px;
  cursor: pointer;
  font-size: 17px;
  -webkit-user-select: none;
  -moz-user-select: none;
  -ms-user-select: none;
  user-select: none;
 }
 .cont-add 
    {
  display: block;
  position: relative;
  /*padding-left: 35px;*/
  margin-left: -9px;
  margin-bottom: 12px;
  cursor: pointer;
  font-size: 17px;
  -webkit-user-select: none;
  -moz-user-select: none;
  -ms-user-select: none;
  user-select: none;
 }
.swal_validation
{
  font-family: 'Rufina', serif;
}
.swal2-input::selection
{
  background : #2196F3;
  color: white;
}
.swal2-input::-moz-selection
{
  background: #2196F3;
  color: white;
}
.delete-swal
{
  font-family: 'Patua One', cursive;
}
.arrow
{
  border: solid black;
  border-width: 0 3px 3px 0;
  display: inline-block;
  padding: 3px;
  position: relative;
  top: -3px;
  margin-left: 6px;
}
.copyright,.addfiles-swal
{
  -webkit-touch-callout: none;
  -webkit-user-select: none;
  -khtml-user-select: none;
  -moz-user-select: none;
  -ms-user-select: none;
  user-select: none;
  font-weight: bold;
}
.down
{
  transform: rotate(45deg);
  -webkit-transform: rotate(45deg);
}
.date
{
  display: none;
}
.up
{
  transform: rotate(-135deg);
  -webkit-transform: rotate(-135deg);
}
/* Hide the browser's default checkbox */
.cont input {
  position: absolute;
  opacity: 0;
  cursor: pointer;
  height: 0;
  width: 0;
}

/* Create a custom checkbox */
.checkmark {
  position: absolute;
  top: 0;
  left: 0;
  height: 25px;
  width: 25px;
  background-color: #eee;
}
.swal-checkmark {
  position: absolute;
  top: 0;
  left: 0;
  height: 22px;
  width: 22px;
  background-color: #eee;
}

/* On mouse-over, add a grey background color */
.cont:hover input ~ .checkmark {
  background-color: #ccc;
}
.cont:hover input ~ .swal-checkmark {
  background-color: #ccc;
}

/* When the checkbox is checked, add a blue background */
.cont input:checked ~ .checkmark {
  background-color: #2196F3;
}
.cont input:checked ~ .swal-checkmark {
  background-color: #2196F3;
}

/* Create the checkmark/indicator (hidden when not checked) */
.checkmark:after {
  content: "";
  position: absolute;
  display: none;
}

.swal-checkmark:after {
  content: "";
  position: absolute;
  display: none;
}

/* Show the checkmark when checked */
.cont input:checked ~ .checkmark:after {
  display: block;
}
.cont input:checked ~ .swal-checkmark:after {
  display: block;
}

/* Style the checkmark/indicator */
.cont .checkmark:after {
  left: 11px;
  top: 7px;
  width: 5px;
  height: 10px;
  border: solid white;
  border-width: 0 3px 3px 0;
  -webkit-transform: rotate(45deg);
  -ms-transform: rotate(45deg);
  transform: rotate(45deg);
}
.cont .swal-checkmark:after {
  left: 9px;
  top: 5px;
  width: 5px;
  height: 10px;
  border: solid white;
  border-width: 0 3px 3px 0;
  -webkit-transform: rotate(45deg);
  -ms-transform: rotate(45deg);
  transform: rotate(45deg);
}
    a { cursor : pointer; }
    #idx { border: 3px solid #fff; margin-left: 2%; margin-right: 2%; font-size: 20px; min-width: 50px;}
    #idx td.center { text-align: center; }
    #idx td { border-bottom: 1px solid #f0f0f0; }
    #idx img { margin-bottom: -2px; }
    #idx table { color: #606060; width: 100%; margin-top:3px; }
    #idx span.link { color: #0066DF; cursor: pointer; }
    #idx .rounded { padding: 10px 7px 10px 10px; border-radius:6px; }
    #idx .gray { background-color:#fafafa;border-bottom: 1px solid #e5e5e5; }
    #idx p { padding: 0px; margin: 0px;line-height:1.4em;}
    #idx p.left { float:left;width:60%;padding:3px;color:#606060;}
    #idx p.right {float:right;width:35%;text-align:right;color:#707070;padding:3px;}
    #idx strong { font-family: 'Vollkorn', serif;; font-size: 1.2em; font-weight: bold; color: #202020; padding-bottom: 3px; margin: 0px; }
    #idx a:link    { color: #0066CC; }
    #idx a:visited { color: #0066CC; }
    /*#idx a:hover   { text-decoration: none; }*/
    #idx a:active  { color: #0066CC; }
    #idx td { cursor: pointer;}
    .filenamespan
    {
      white-space: nowrap;
      overflow: hidden !important;
      text-overflow: ellipsis;
    }
    .delete-icon
    {
      position: relative;
      top: 4px;
      color: blue;
      cursor: pointer;
      padding-right: 22px;
      left: -4.5px;
    }
    .options-dropdown
    {
      cursor: pointer;
    }
    .delete
    {
      display : none;
    }
    .rename
    {
      display : none;
    }
    .filecheck
    {
      cursor: pointer;
    }
    .fileoptionsdiv
    {
      margin-left: 39px;
      font-size: 18px;
      color: #0066CC;
    }

    .delete-buttons-div
    {
      margin-top: 10%;
    }
    .navigation
    {
      margin-top: 100px;
      font-size: 18px;
    }
    .file-icon-class
    {
      height: 24.8px;
      position: relative;
      top: -3.5px;
    }
    .hide1
    {
      display: none;
    }
    .hide-download
    {
      position: relative;
      top: -8.5px;
    }
    .actions-dropdown
    {
        font-family: 'Vollkorn', serif;
    }
    @media only screen and (max-width: 571px)
    {
      .hide-for-mobiles
      {
        display : none;
      }
    }
    @media only screen and (max-width: 479px)
    {
      .hide-download
      {
        display: none;
      }
    }
    @media only screen and (max-width: 900px)
    {
        .hide1
        {
            display: none;
        }
        @media only screen and (max-width: 600px)
        {
            .hide2
            {
                display: none;
            }
        }
    }
    @media only screen and (max-width: 977px)
    {
        .hidedate
        {
            display: none;
        }
        @media only screen and (max-width: 834px)
        {
            .hidetype
            {
                display: none;
            }
        }
    }
    .no-items
    {
      font-family: 'IBM Plex Serif', serif;
      font-size: 35px;
      font-weight: bolder;
      color: black;
    }
    .addfiles-swal
    {
      cursor: pointer;
      -webkit-box-shadow:none;
      -moz-box-shadow:none;
      box-shadow:none;
      background-color:#4d90fe;
      background-image:-webkit-linear-gradient(top,#4d90fe,#4787ed);
      background-image:-moz-linear-gradient(top,#4d90fe,#4787ed);
      background-image:-ms-linear-gradient(top,#4d90fe,#4787ed);
      background-image:-o-linear-gradient(top,#4d90fe,#4787ed);
      background-image:linear-gradient(top,#4d90fe,#4787ed);
      border:1px solid #3079ed;
      color:#fff;
      outline:none;
      filter:alpha(opacity=50);
      opacity:1;
      border-radius: 0.13em;
      height: 60px;
      text-align: center;
      padding-left: 5px;
      padding-right: 5px;
      padding-top: 4px;
      padding-bottom: 4px;
    }
    .addfiles-swal:focus 
    {
      -webkit-box-shadow:inset 0 0 0 1px #fff;
      -moz-box-shadow:inset 0 0 0 1px #fff;
      box-shadow:inset 0 0 0 1px #fff;
      border:1px solid #fff;
      border:rgba(0,0,0,0) solid 1px;
      outline:1px solid #4d90fe;
      outline:rgba(0,0,0,0) 0
    }
    .addfiles-swal:active 
    {
 -webkit-box-shadow:inset 0 1px 2px rgba(0,0,0,0.3);
 -moz-box-shadow:inset 0 1px 2px rgba(0,0,0,0.3);
 box-shadow:inset 0 1px 2px rgba(0,0,0,0.3);
 background:#357ae8;
 border:1px solid #2f5bb7;
 border-top:1px solid #2f5bb7
}
    </style>
    <script type="text/javascript">
    console.log("Script degug: Working");
    var time_taken_for_php = "<?php echo $end; ?>";
    console.log("Time taken: "+time_taken_for_php);
    var _c1='#fefefe'; var _c2='#fafafa'; var _ppg=100000000000000; var _cpg=1; var _files=[]; var _dirs=[]; var _tpg=null; var _tsize=0; var _sort='date'; var _sdir={'type':0,'name':0,'size':0,'date':1}; var idx=null; var tbl=null;
    function _obj(s){return document.getElementById(s);}  //returns a dom element
    function _ge(n){n=n.substr(n.lastIndexOf('.')+1);return n.toLowerCase();}   //identifies the file type
    function _nf(n,p){if(p>=0){var t=Math.pow(10,p);return Math.round(n*t)/t;}}  //
    function _s(v,u){if(!u)u='B';if(v>1024&&u=='B')return _s(v/1024,'KB');if(v>1024&&u=='KB')return _s(v/1024,'MB');if(v>1024&&u=='MB')return _s(v/1024,'GB');return _nf(v,1)+'&nbsp;'+u;}
    function _f(name,size,date,url,rdate){_files[_files.length]={'dir':0,'name':name,'size':size,'date':date,'type':_ge(name),'url':url,'rdate':rdate,'icon':'index.php?icon='+_ge(name)};_tsize+=size; console.log(url);}
    function _d(name,date,url){_dirs[_dirs.length]={'dir':1,'name':name,'date':date,'url':url,'icon':'index.php?icon=dir'}; console.log(url);}
    function _np(){_cpg++;_tbl();}
    function _pp(){_cpg--;_tbl();}
    function _sa(l,r){return(l['size']==r['size'])?0:(l['size']>r['size']?1:-1);} //sorting based on size
    function _sb(l,r){return(l['type']==r['type'])?0:(l['type']>r['type']?1:-1);} //sorting based on type
    function _sc(l,r){return(l['rdate']==r['rdate'])?0:(l['rdate']>r['rdate']?1:-1);}  //sorting based on date
    function _sd(l,r){var a=l['name'].toLowerCase();var b=r['name'].toLowerCase();return(a==b)?0:(a>b?1:-1);} //sorting based on name
    function _srt(c){switch(c){case'type':_sort='type';_files.sort(_sb);if(_sdir['type'])_files.reverse();break;case'name':_sort='name';_files.sort(_sd);if(_sdir['name'])_files.reverse();break;case'size':_sort='size';_files.sort(_sa);if(_sdir['size'])_files.reverse();break;case'date':_sort='date';_files.sort(_sc);if(_sdir['date'])_files.reverse();break;}_sdir[c]=!_sdir[c];_obj('sort_type').style.fontStyle=(c=='type'?'italic':'normal');_obj('sort_name').style.fontStyle=(c=='name'?'italic':'normal');_obj('sort_size').style.fontStyle=(c=='size'?'italic':'normal');_obj('sort_date').style.fontStyle=(c=='date'?'italic':'normal');_tbl();return false;}

    function _head()
    {
        if(!idx)return;
        console.log("_head() is executed");
        _tpg=Math.ceil((_files.length+_dirs.length)/_ppg);
        idx.innerHTML='<div class="rounded gray" style="padding:5px 10px 5px 7px;color:#202020">' +
            '<div class="row pb-2 float-left"><label class="cont" style="margin-left: 8.5px; margin-top: 5.5px;"><span><input type="checkbox" class="controlling" /><span class="checkmark"></span></span></label><span><div class="ui dropdown simple" style="margin-left: 15px;"><div style="" class="text ml-1 actions-dropdown"><strong>Actions</strong></div><i class="dropdown icon" style="margin-left: 5px;"></i><div class="menu"><div class="item action-file"><i class="upload icon"></i><strong><label for="fileupload" style="cursor: pointer;">File Upload</label></strong></div><div class="item action-folder"><i class="folder icon"></i><strong>New Folder</strong></div><div class="item action-delete"><i class="trash alternate icon"></i><strong>Delete</strong></div><div class="item action-move"><i class="folder open icon"></i><strong>Move</strong></div><div class="item action-rename"><i class="pen square icon"></i><strong>Rename</strong></div></div></div><?=$dir!=''?'&nbsp; (<a href="'.$up_url.'">Back</a>)':''?></span></div>' +
            '<div class="float-right hide-for-mobiles" style="">' +
                'Sort: <span class="link hidename" onmousedown="return _srt(\'name\');" id="sort_name">Name</span>  <span class="link hidetype" onmousedown="return _srt(\'type\');" id="sort_type">Type</span> <span class="link hidesize" onmousedown="return _srt(\'size\');" id="sort_size">Size</span> <span class="link hidedate" onmousedown="return _srt(\'date\');" id="sort_date">Date</span>' +
            '</div>' +
            '<div style="clear:both;"></div>' +
        '</div><div id="idx_tbl"></div>';
        tbl=_obj('idx_tbl');
    }
    function _tbl()
    {
        if (_files.length + _dirs.length == 0)
        {
          idx.innerHTML = "<span class='no-items' style='text-align: ml-5;'>You haven't uploaded any files. <label for='fileupload' style='cursor: pointer;'>Upload</label> to get started</span></br>";
          idx.innerHTML += "<span class='no-items' style='text-align: ml-5;'>OR</span></br>";
          idx.innerHTML += "<span class='no-items' style='text-align: ml-5;'>Create a New Folder</span></br>";
          $("#idx").css("text-align","center");
          return;
        }
        console.log('Debug tbl: Length = '+ _files.length + _dirs.length);
        //_tpg = 1;
        var _cnt=_dirs.concat(_files);if(!tbl)return;if(_cpg>_tpg){_cpg=_tpg;return;}else if(_cpg<1){_cpg=1;return;}var a=(_cpg-1)*_ppg;var b=_cpg*_ppg;var j=0;var html='';
        if(_tpg>1)html+='<p style="padding:5px 5px 0px 7px;color:#202020;text-align:right;"><span class="link" onmousedown="_pp();return false;">Previous</span> ('+_cpg+'/'+_tpg+') <span class="link" onmousedown="_np();return false;">Next</span></p>';
        html+='<table class="main-table" cellspacing="0" cellpadding="5" border="0">';
        if (_dirs.length != 0)
        {
        for(var i=a;i<b&&i<(_dirs.length);++i)
        {
            var x = document.getElementById("content").getBoundingClientRect().width;
            var f=_cnt[i];var rc=j++&1?_c1:_c2;
            var dir_name_length = f['name'].length;
            if (dir_name_length > 12)
            {
              var last__dir_dot = f['name'].lastIndexOf(".");
            }
            html+='<tr class="datarow" style="background-color:'+rc+'"><td class="firsttd"><label class="cont"><span><label>&nbsp;&nbsp;&nbsp;<img class="file-icon-class" src="'+f['icon']+'" alt="" /></label><input type="checkbox" class="dircheck"><span class="checkmark"></span>&nbsp;&nbsp<a data-type="directory" class="navigation" href="'+f['url']+'"><span class="filenamespan">'+f['name']+'</span></a></label></span></td><td class="hide-download"><a></a></td><td class="center hide2" style="width:50px;">'+(f['dir']?'':_s(f['size']))+'</td><td class="center hide1" style="width:70px;">'+f['date']+'</td></tr>';
            c = _dirs.length;
        }
      }
        else
        {
          c = 0;
        }
        for(var i=c;i<b&&i<(_files.length+_dirs.length);++i)
        {
            var f=_cnt[i];var rc=j++&1?_c1:_c2;
            var file_name_length = f['name'].length;
            html+='<tr class="datarow" style="background-color:'+rc+'"><td class="firsttd"><label class="cont"><span><label>&nbsp;&nbsp;&nbsp;<img class="file-icon-class" src="'+f['icon']+'" alt="" /></label><input type="checkbox" class="filecheck"><span class="checkmark"></span>&nbsp;&nbsp<a data-type="file" class="navigation" href="'+f['url']+'"><span class="filenamespan">'+f['name']+'</span></a></label></span></td><td class="hide-download"><a href="'+f['url']+'" download>Download</a></td><td class="center hide2" style="width:50px;">'+(f['dir']?'':_s(f['size']))+'</td><td class="center hide1 date" style="width:70px;">'+f['date']+'</td></tr>';
        }
        tbl.innerHTML=html+'</table>';
        $(document).ready(function(){
          console.log("No.of unchecked boxes: "+$(".filecheck:not(:checked)").length+$(".dircheck:not(:checked)").length)
          $(".action-delete,.action-rename,.action-move").hide();
          $(".controlling").click(function(){
            $(".filecheck,.dircheck").prop('checked', $(this).prop('checked'));
            if (_files.length + _dirs.length == 1 && $(this).prop('checked') == true)
            {
              $(".action-rename,.action-move,.action-delete").show();
            }
            if (_files.length + _dirs.length > 1 && $(this).prop('checked') == true)
            {
              $('.action-rename').hide();
              $(".action-move,.action-delete").show();
            }
            /*if ($(this).prop('checked') == true)
            {
              $(".action-move,.action-delete").show();
            }*/
            if ($(this).prop('checked') == false)
            {
              $(".action-move,.action-delete").hide();
            }
          })
          $(".dircheck,.filecheck").click(function(){
            if ($(this).prop('checked') == false)
            {
              $(".controlling").prop('checked',$(this).prop('checked'));
            }
            else if ($(this).prop('checked') == true && $(".filecheck:not(:checked)").length+$(".dircheck:not(:checked)").length == 0)
            {
              $(".controlling").prop('checked',true);
            }
            if ($(this).prop('checked') == true && $(".filecheck:checked").length + $(".dircheck:checked").length == 1)
            {
              $(".action-rename").show();
              $(".action-delete").show();
              $(".action-move").show();
            }
            if ($(this).prop('checked') == true && $(".filecheck:checked").length + $(".dircheck:checked").length > 1)
            {
              $(".action-delete").show();
              $(".action-move").show();
              $(".action-rename").hide();
            }
            if ($(this).prop('checked') == false && $(".filecheck:checked").length + $(".dircheck:checked").length == 0)
            {
              $(".action-delete").hide();
              $(".action-move").hide();
              $(".action-rename").hide();
            }
            if ($(this).prop('checked') == false && $(".filecheck:checked").length + $(".dircheck:checked").length == 1)
            {
              $(".action-delete").show();
              $(".action-move").show();
              $(".action-rename").show();
            }
          })
        })
    }

    
    <?php
    foreach ($dirs as $j_dir)
    {
      print sprintf("_d('%s','%s','%s');\n",($j_dir['name']),$j_dir['date'],($j_dir['url']));
      //print sprintf("_f('%s','%s','%s','%s',%d);\n",($f['name']),$f['size'],date($date,$f['date']),($f['url']),$f['date']);
    }
    foreach ($files as $j_file)
    {
      print sprintf("_f('%s','%s','%s','%s',%d);\n",($j_file['name']),$j_file['size'],$j_file['date'],($j_file['url']),$j_file['date']);
    }
    ?>

    window.onload=function()
    {
        idx=_obj('idx'); _head(); _srt('name');
    };
    </script>
</head>

<body id="page-top">
    <div id="wrapper">
        <nav class="navbar navbar-dark align-items-start sidebar sidebar-dark accordion bg-gradient-primary p-0">
            <div class="container-fluid d-flex flex-column p-0"><a class="navbar-brand d-flex justify-content-center align-items-center sidebar-brand m-0" href="#">
                    <div class="sidebar-brand-icon rotate-n-15"><i class="material-icons">insert_drive_file</i></div>
                    <div class="sidebar-brand-text mx-3"><span>THYDRIVE</span></div>
                </a>
                <hr class="sidebar-divider my-0">
                <ul class="nav navbar-nav text-light" id="accordionSidebar">
                    <input class="fileupload" style="display:none" onchange="upload_function()" multiple name="fileupload" id="fileupload" type="file" />
                    <li class="nav-item upload" id="upload" role="presentation"><label for="fileupload"><a class="nav-link active upload"><i class="fas fa-upload"></i><span>Upload</span></a></li></file>
                    <li class="nav-item createfolder" role="presentation"><a class="nav-link active createfolder" href=""><i class="far fa-folder"></i><span>Create Folder</span></a></li>
                    <li class="nav-item payments" role="presentation"><a class="nav-link active payments" href=""><i class="fas fa-folder"></i><span>Shared to You</span></a></li>
                    <li class="nav-item payments" role="presentation"><a class="nav-link active payments" href=""><i class="fas fa-money-check"></i><span>Payments</span></a></li>
                    <li class="nav-item" role="presentation"></li>
                </ul>
                <div class="text-center d-none d-md-inline"><button class="btn rounded-circle border-0" id="sidebarToggle" type="button"></button></div>
            </div>
        </nav>
        <div class="d-flex flex-column" id="content-wrapper">
            <div id="content">
                <nav class="navbar navbar-light navbar-expand bg-white shadow mb-4 topbar static-top">
                    <div class="container-fluid"><button class="btn btn-link d-md-none rounded-circle mr-3" id="sidebarToggleTop" type="button"><i class="fas fa-bars"></i></button>
                        <form class="form-inline d-none d-sm-inline-block mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                            <div class="input-group"><input class="bg-light form-control border-0 small" type="text" placeholder="Search for ..." style="margin-left: 10%;">
                                <div class="input-group-append"><button class="btn btn-primary py-0" type="button"><i class="fas fa-search"></i></button></div>
                            </div>
                        </form>
                        <ul class="nav navbar-nav flex-nowrap ml-auto">
                            <li class="nav-item dropdown d-sm-none no-arrow"><a class="dropdown-toggle nav-link" data-toggle="dropdown" aria-expanded="false" href="#"><i class="fas fa-search"></i></a>
                                <div class="dropdown-menu dropdown-menu-right p-3 animated--grow-in" aria-labelledby="searchDropdown">
                                    <form class="form-inline mr-auto navbar-search w-100">
                                        <div class="input-group"><input class="bg-light form-control border-0 small" type="text" placeholder="Search for ...">
                                            <div class="input-group-append"><button class="btn btn-primary py-0" type="button"><i class="fas fa-search"></i></button></div>
                                        </div>
                                    </form>
                                </div>
                            </li>
                            <div class="d-none d-sm-block topbar-divider"></div>
                            <li class="nav-item dropdown no-arrow">
                                <div class="nav-item dropdown no-arrow"><a class="dropdown-toggle nav-link" data-toggle="dropdown" aria-expanded="false" href="#"><span class="d-none d-lg-inline mr-2 text-gray-600 small">Valerie Luna</span><img class="border rounded-circle img-profile" src="assets/img/avatars/avatar1.jpeg"></a>
                                    <div class="dropdown-menu shadow dropdown-menu-right animated--grow-in"><a class="dropdown-item" href="#"><i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>&nbsp;Account</a><a class="dropdown-item" href="#"><i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>&nbsp;Settings</a><a class="dropdown-item" href="#"><i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>&nbsp;Activity log</a>
                                        <div class="dropdown-divider"></div><a class="dropdown-item" href="#"><i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>&nbsp;Logout</a>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </nav>
                <div id="idx"></div>
                <div>
                </div>
            </div>
            <footer class="bg-white sticky-footer">
                <div class="container my-auto">
                    <div class="text-center my-auto copyright"><span>Copyright © THYDRIVE 2021</span></div>
                </div>
            </footer>
        </div><a class="border rounded d-inline scroll-to-top" href="#page-top"><i class="fas fa-angle-up"></i></a>
    </div>
    <script>
      function upload_function()
      {
        files = document.getElementById("fileupload").files;
        temp_files = Array.prototype.slice.call(files);
        modifyshow();
        //show += "<label class='cont'><input type='checkbox' class='swal-checbox'><span class='swal-checkmark'></span></label>"
        Swal.fire({
          title: "Upload",
          html : show,
          confirmButtonText: 'Upload',
          showCancelButton: true,
          width: '600px',
          allowOutsideClick: false,
          onOpen: function(){
            if (temp_files.length > 5)
            {
              $(".swal2-confirm").attr("title","Maximum of 5 files can be uploaded at a time");
              $(".swal2-confirm").prop("disabled",true);
            }
            else
            {
              var footer = "";
            }
          },
          preConfirm: () => {
            var form_data = new FormData();
            var fr_data = new FormData();
            enc_file = new File(["Hello there"],"hello.txt");
            for (i = 0; i < temp_files.length; ++i)
            {
              var reader = new FileReader();
              reader.onload = function(e)
              {
                var encrypted = CryptoJS.AES.encrypt(e.target.result, "32175690P");
                console.log(encrypted+"");
                //console.log("Name: "+e.name);
                enc_file = new File([encrypted+""],"test.txt",{type: "text/plain", lastModified: new Date()});
                form_data.append("file"+i,enc_file);
                //console.log(enc_file);
              }
              console.log(enc_file);
              form_data.append("file"+i,enc_file);
              reader.readAsDataURL(temp_files[i]);
              file_data = temp_files[i];
              fr_data.append("file"+i,file_data);
            }
            console.log(fr_data);
            $.ajax({
              url : 'upload.php',
              dataType: 'text',
              cache: false,
              contentType: false,
              processData: false,
              data: form_data,
              type: 'post',
              success: function(result)
              {
                console.log(result);
              }
            })
          }
        })
      }
      function modifyshow()
      {
        //console.log(files[0]);
        if (temp_files.length == 0)
        {
          show = "<span style='overflow: scroll;'><span><strong>Add some files to upload</strong></span></br></br></br>";
          show += "<span><label class='cont-add' style='text-align: left; width: 55%; white-space: nowrap; display: inline-block;'><input type='file' multiple style='display: none;' onchange='add_files_to_upload()' class='addfiles' name='addfiles' id='addfiles' /><label for='addfiles'><span class='addfiles-swal'>Add files</span></label></label></span></br></br>";
          show += "</span></br>";
          $(".swal2-html-container").html(show);
          $(".swal2-confirm").prop("disabled",true);
          $(".swal2-confirm").attr("title","No files selected to upload");
          //console.log("Zero element array");
          return;
        }
        show = "<span style='overflow: scroll;'><span><strong>Select the files you wanted to encrypt</strong></span></br></br></br>";
        for (i = 0; i < temp_files.length; ++i)
        {
          if ((temp_files[i].name).length > 17 && $(window).width() >= 700)
          {
            temp = (temp_files[i].name).substr(0,16);
            temp += "...";
          }
          else if (temp_files[i].name.length > 7 && $(window).width() < 420)
          {
            temp = (temp_files[i].name).substr(0,7);
            temp += "...";
            console.log(temp);
          }
          else
          {
            temp = temp_files[i].name;
          }
          show += "<span><label class='cont' style='text-align: left; width: 55%; white-space: nowrap; display: inline-block;'><input type='checkbox' class='swal-checkbox'><span class='swal-checkmark'></span><span class=''>"+temp+"</span>&nbsp;&nbsp;</label><span data-number="+i+" class='fa fa-close text-nowrap removefile' onclick='crossclick(this)' style='font-size: 20px; white-space: nowrap; display: inline-block; cursor: pointer;' data-name="+temp_files[i].name+"></span></span></br></br>"
        }
          if (temp_files.length > 5)
          {
            $(".swal2-confirm").attr("title","Maximum of 5 files can be uploaded at a time");
            $(".swal2-confirm").prop("disabled",true);
          }
          else if (temp_files.length <= 5)
          {
            $(".swal2-confirm").prop("disabled",false);
          }
          show += "<span><label class='cont-add' style='text-align: left; width: 55%; white-space: nowrap; display: inline-block;'><input type='file' multiple style='display: none;' onchange='add_files_to_upload()' class='addfiles' name='addfiles' id='addfiles' /><label for='addfiles'><span class='addfiles-swal'>Add files</span></label></label></span></br></br>";
          show += "</span></br>";
        //show += "<span><label class='cont' style='text-align: left; width: 55%;'><span style=''><span class='addfiles-swal'>Add more</span></span></label></span></br>"
        $(".swal2-html-container").html(show);
        //console.log("Width: "+$(window).width());
      }
      function add_files_to_upload()
      {
        //console.log("Function to add, executed");
        extra_files = document.getElementById("addfiles").files;
        //console.log(extra_files);
        extra_files_array = Array.prototype.slice.call(extra_files);
        //console.log(extra_files_array);
        //console.log("Extra files: ");
        //console.log(extra_files);
        temp_files = temp_files.concat(extra_files_array);
        modifyshow();
        var encryptedAES = CryptoJS.AES.encrypt("Message", "My Secret Passphrase");
        var decryptedBytes = CryptoJS.AES.decrypt(encryptedAES, "My Secret Passphrase");
        var plaintext = decryptedBytes.toString(CryptoJS.enc.Utf8);
        console.log(encryptedAES+" "+decryptedBytes+" "+plaintext);
      }

      function crossclick(x)
      {
        var index = $(x).attr("data-number");
        //console.log(index);
        temp_files.splice(index,1);
        modifyshow();
        //console.log(temp_files);
      }
    </script>
    <script>
    </script>
    <script src="https://storage.googleapis.com/instant-static-files/js/theme.js"></script>
</body>

</html>