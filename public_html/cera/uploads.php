<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
ini_set('post_max_size', '45M');
ini_set('upload_max_filesize', '45M');
include '../minister/inc/muneris.php';
?>
<!DOCTYPE html>
<html>
   <head>
      <title>Dealer Net</title>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <link href='../css/bootstrap.min.css' rel='stylesheet' media='screen'>
      <script src='../js/bootstrap.min.js'></script>
      <style type="text/css">
         body {padding-top: 40px;padding-bottom: 40px;background-color: #fff;}
         .form-signin { max-width: 30em;padding: 2em;margin: 0 auto;background-color: #f5f5f5;border: 1px solid #e5e5e5;-webkit-border-radius: 5px;-moz-border-radius: 5px;border-radius: 5px;-webkit-box-shadow: 0 1px 2px rgba(0,0,0,.05);-moz-box-shadow: 0 1px 2px rgba(0,0,0,.05);box-shadow: 0 1px 2px rgba(0,0,0,.05);}
         .form-signin .form-signin-heading,.form-signin .checkbox {margin-bottom: 10px;}
         .form-signin textarea{font-size: 16px;height: auto;margin-bottom: 15px;padding: 7px 9px;}
         .form-signin input{height: auto;margin-bottom: 15px;}
         .form-signin .size1 {width:22em;}.form-signin .size2 {width:7em;}
         .form-signin textarea {height:20em; width:30em; font-size:1em;}
      </style>
   </head>
   <body>
      <div class="container the_search">
         <form class="form-signin form-horizontal" method="POST" style="" enctype="multipart/form-data" >
            <h2 class="form-signin-heading">RoadCover Uploader</h2><input type="hidden" name="love" value="you">
            <fieldset>
               <legend>Upload CSV File</legend>
               <div class="control-group">
                  <label class="control-label" for="filename">File</label>
                  <div class="controls">
                     <input type="file" multiple id="filename" name="filename[]" />
                  </div>
               </div>
            </fieldset>
            <button name="upload" class="btn btn-large btn-primary"  type="submit" value="submited">xxx  Upload   xxx</button>
         </form>
      </div>
   </body>
</html>
<?php

if($_FILES['filename']):
   foreach($_FILES['filename']['tmp_name'] as $key => $tmp_name):

      if(is_uploaded_file($tmp_name) &&$_FILES['filename']['type'][$key]==="application/vnd.ms-excel"):
         $cnt     = 0;
         $err     = 0;
         $msg     = "";
         $count   = 0;
         $handle  = fopen($tmp_name,"r");
         if(feof($handle)===true) rewind($handle);


         if($handle !==false):
            iyona(feof($handle));
            $echo = "<table class='table table-hover table-bordered table-condensed'>";
            while( feof($handle) === false):
               $fields = fgetcsv($handle,0,';');
               if($cnt===0): $cnt++;$count=count($fields);
                  $echo .= "<thead><tr><th>".implode("</th><th nowrap>",$fields)."</th><tr></thead><tbody>".PHP_EOL;
               else:
                  if(!is_array($fields)) continue;
                  $fields  = array_map('clean_up', $fields);
                  $echo   .= "<tr><td>".implode("</td><td nowrap>",$fields)."</td><tr>".PHP_EOL;
                  $sql     = "REPLACE INTO customer_absa VALUES (".implode(",",$fields).")";
                  $rs      = $db->Execute($sql);
                  if(!$rs): $msg .= "Failed on {$fields[1]}::".$db->ErrorMsg()." [<strong>$sql</strong>]<br/>".PHP_EOL; $err++;
                  else: $cnt++;
                  endif;
               endif;
               if($cnt > 80000) break;
            endwhile;
            $echo .= "</tbody></table>";
            iyona(feof($handle));
            fclose($handle);
         endif;
         $echo = (0)?$echo:null;
         echo "Counted $count fields in <i>`{$_FILES['filename']['name'][$key]}`</i> and a total of ".($cnt-1)." record added and $err error found.<br/> $msg<br/>$echo";
      else: iyona($_FILES['filename']['type'][$key]);
      endif;
   endforeach;
endif;


function clean_up($value){
   global $db;
   if(strstr($value,"/")&&strlen($value)>=8&&strlen($value)<=10&&strtotime($value)):
      preg_match_all("/\//", $value, $matches);
      if(count($matches[0])!==2) {return $db->qstr($value);}
//      iyona([$value,$matches]);
      $tmp = DateTime::createFromFormat("d/m/Y", $value)->format("Y-m-d");
      if(stristr($tmp,"0000") || stristr($tmp,"1970") || false) echo "$value && $tmp<br/>";
      return $db->qstr($tmp);
   endif;
   return $db->qstr($value);
}
?>