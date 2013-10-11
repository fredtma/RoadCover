<?php
/*
 * Militia service page for sync
 * @author fredtma
 * @version 2.5
 * @category sync, db, CRUD
 * @gloabl object $db
 * @see service.php
 * @param string <var>$iyona</var> the encrypted table name
 * @param string <var>$Tau</var> the encrypted name of the transaction
 * @param array <var>$eternal</var> the fields and they value, containing option on the fields as well
 * @param mixed <var>$alpha</var> the value of the field
 * @param string <var>$delta</var> query option search, in a field[eternal] this is the where statement !@=!#
 * @param string <var>$beta</var> it will let you know wherther $alpha is encrypted or not. in a field[eternal] this is the encrypted function if included it can call a cetain function
 * @param string <var>$blossom</var> indicate that it is the pk
 * @example:{"eternal":{"blossom":{"alpha":"value","delta":"!@=!#"},"field1":"value","level":{"alpha":"level","delta":" and !@=!#"}},"Tau":"transaction","iyona":"table"}
 */
ini_set('memory_limit', '2056M');
ini_set('max_execution_time', 60*60*24);
header('Content-Type: application/json');
//header('Access-Control-Allow-Origin: *');
include('muneris.php');
#==============================================================================#
if($_GET&&iyona_adm())$_POST=array_merge($_GET,$_POST);
iyona_log("#==============================================================================#",true);
iyona_log($_POST);
$table         = $_POST['iyona'];
$pre           = 'roadCover_';
$transaction   = $_POST['Tau'];
$list_of_tables= array('users','groups','link_users_groups','permissions','link_permissions_groups','link_permissions_users','clients','contacts','address','dealers','salesmen','pages','features','invoices','version_control');
if (!in_array($table, $list_of_tables)) {echo '{"err":" This is an invalid request for '.$table.' "}';exit;}
$where         = 'WHERE ';

$db->StartTrans();
foreach($_POST['eternal'] as $key => $column)
{
   if (is_array($column))
   {
      $val = $column['alpha'];
      if ($column['delta']) $where .= opt_column($key,$column['delta']);
      $where = $key=='blossom'?str_replace('blossom', 'jesua', $where):$where;
   }//end chk if field sub value is an array
   else   {$val = $column; }//end else not an array
   $key      = $key=='blossom'?'jesua':$key;
   if($key==="jesua")$jesua=$val;
   if($key=='DEVICE'&&$table=="version_control")$val = md5($_SERVER['HTTP_USER_AGENT'].$val);//when the device is sent from a js script
   $fields  .= "`$key`, ";
   $answer  .= $db->qstr($val).', ';
   $set     .= ($key=='jesua')?"":"`$key`=".$db->qstr($val).', ';#ne pas modifier, l'identification jesua
}//foreach eternal fields

$fields  = rtrim($fields,', ');
$answer  = rtrim($answer,', ');
$set     = rtrim($set,', ');
$table   = $pre.$table;

if($_POST['consuetudinem']) run_consuetudinem($_POST['consuetudinem']);
switch($transaction)
{
   case 'oMegA' :
   {
      if($where)$sql = "DELETE FROM $table $where";
      $msg           = "Successfully sync&deleted";
      $trnsc         = 0;
      $more          = ',"section":"'.$_POST['section'].'"';/*used to remove the section deleted*/
      break;
   }
   case 'Alpha' :
   {
      $sql           = "INSERT INTO $table ($fields)VALUES($answer) ON DUPLICATE KEY UPDATE id=id+1";
//      $sql           = "REPLACE INTO $table ($fields) VALUES ($answer)";
      $trnsc         = 1;
      $msg           = "Successfully sync&added";
      break;
   }
   case 'deLta' :
   {
      if($where)$sql = "UPDATE $table SET $set $where";
      else $sql      = "REPLACE INTO $table ($fields) VALUES ($answer)";
      $msg           = "Successfully sync&updated";
      $trnsc         = 2;
      break;
   }
   default : $sql = "SELECT $fields FROM $table $where";break;
}//end switch of transaction
$rs      = $db->Execute($sql);
$err     = $db->ErrorMsg();
$the_id  = $db->Insert_ID();
$msg     = $err?$msg.":notice:".$err:$msg;

if (!$rs)
{
   echo '{"err":":: '.$sql.'<br/>'.$err.'","msg":"Could not '.$msg.'"}';
}//end if there is an sql error
else if ($rs)
{
   $sql  = trim(str_replace("\'",'',$sql));#str_replace("\t"," ",valueCheck($sql, 'input'));
   echo '{"msg":"'.$msg.'","iota":"'.$the_id.'","transaction":"'.$transaction.'","trnsc":"'.$trnsc.'","sql":"'.$sql.'"'.$more.'}';
}//end else succesfull db query
iyona_log($sql."\r\n<br/>$msg");
$db->CompleteTrans();
#===============================================================================#
if($_POST['procus']):
   $device  = md5($_SERVER['HTTP_USER_AGENT'].$_POST['moli']);
   $jesua   =($jesua)?$jesua:(($the_id)?$the_id:$column['delta']);#jesua,inserted ID||ID
   $version = "INSERT INTO {$pre}versioning(`user`,`trans`,`mensa`,`creation`,`jesua`,device,content)VALUES({$db->qstr($_POST['procus'])},'$transaction','$table',NOW(),{$db->qstr($jesua)},{$db->qstr($device)},{$db->qstr($_SERVER['HTTP_USER_AGENT'].'-'.$_POST['moli'])})";
   $rs=$db->Execute($version);
   iyona_log($version."\r\n<br/>".$db->ErrorMsg());
   $sql="INSERT INTO {$pre}version_control (ver,user,device,creation)VALUE({$db->Insert_ID()},{$db->qstr($_POST['procus'])},'$device',now())";
   $rs=$db->Execute($sql);
   iyona_log($sql."\r\n<br/>".$db->ErrorMsg());
endif;
#===============================================================================#
function opt_column($_name='', $_restrict="!@=!#", $_like=false) {
   global $db;
   if(!$_like) $_restrict = str_replace("!@","`$_name`", $_restrict);
   if      (!empty($_REQUEST[$_name]) && !is_array($_REQUEST[$_name]))           {$value = $_REQUEST[$_name];}
   else if (empty($value) && !is_array($_REQUEST['eternal'][$_name]))            {$value = $_REQUEST['eternal'][$_name];}
   else if (empty($value) && !is_array($_REQUEST['eternal'][$_name]['alpha']))   {$value = $_REQUEST['eternal'][$_name]['alpha'];}
   else if (empty($value))                                                       {$value = $_SESSION[$_name];}
   $value   = $db->qstr($value);
   $_restrict= str_replace("!#", $value, $_restrict);
   return $_restrict;
}//end function to have a where function
#===============================================================================#
/*
 * runs a consuetudinem/custom function
 */
function run_consuetudinem($_consuetudinem){
   global $pre,$db;
   switch($_consuetudinem){
      case "dealers-account":
         $sql="UPDATE {$pre}dealers SET account={$db->qstr($_POST['eternal']['account'])} WHERE code={$db->qstr($_POST['eternal']['dealer'])}";
         $rs=$db->Execute($sql);iyona_message($rs,$sql);
         $sql="UPDATE road_Intermediary SET account={$db->qstr($_POST['eternal']['account'])} WHERE Id={$db->qstr($_POST['eternal']['dealer'])}";
         $rs=$db->Execute($sql);iyona_message($rs,$sql);
         break;
   }
}
#===============================================================================#
?>
