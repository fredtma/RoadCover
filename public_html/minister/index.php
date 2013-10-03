<?php
include("inc/muneris.php");
$rs=$db->Execute("SELECT * FROM roadCover_users");
echo $_SERVER['HTTP_USER_AGENT'];
echo "<br/>";
echo $_SERVER['REMOTE_ADDR'];
echo "<br/>";
echo $_SERVER['REMOTE_HOST'];
echo "<br/>";
echo gethostbyaddr($_SERVER['REMOTE_ADDR']);
echo "<br/>";
echo php_uname('n');
echo "<br/>";
echo php_uname();
?>
<!DOCTYPE html>
<html>
   <head>
      <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
      <title></title>
   </head>
   <body>
      <?php
if ($rs->_numOfRows>0)
{
   while (!$rs->EOF) {
      extract($rs->fields);
#==============================================================================#
      echo "<p>$firstname, $lastname</p>";
#==============================================================================#
      $rs->MoveNext();
   }//end while of $rs
}//end if of $rs
      ?>
   </body>
</html>
