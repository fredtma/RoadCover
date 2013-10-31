<?php
/*
 * numeris function and setup for the system
 * @author fredtma
 * @version 2.67
 * @category functions
 */
#==============================================================================#
#ROADCOVER SYSTEM CONFIGURATION
#==============================================================================#
error_reporting(E_ERROR | E_WARNING | E_PARSE);
ini_set('display_errors', '1');
if(substr_count($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip')) ob_start("ob_gzhandler"); else ob_start();
define("SITE_NAME","roadCover/");
$host=($_SERVER['SERVER_NAME']==='localhost')?"localhost":"197.96.139.19";
$local=($_SERVER['SERVER_NAME']==='localhost')?true:false;
$dir=str_replace("public_html\minister\inc", "", __DIR__);
$dir=str_replace("public_html/minister/inc", "", $dir);
define("SITE_ROOT",$dir);
define("SITE_LOCAL",$local);
define("SITE_PUBLIC",SITE_ROOT."public_html/");
define("SITE_CERA",SITE_PUBLIC."cera/");
define("SITE_MINISTER",SITE_ROOT."minister/");
define("SITE_PUB_MINISTER",SITE_PUBLIC."minister/");
define("SITE_URL","http://$host/");
define("SITE_DWLD",SITE_PUB_MINISTER."downloads/");
define("SITE_LIBRARY",SITE_PUB_MINISTER."bibliotheca/");
define("INCLUDE_MAIL",SITE_LIBRARY."PHPMailer_5.2.4/class.phpmailer.php");
define("EMAIL_SUPPORT","info@xpandit.co.za");
define("EMAIL_ADMIN","tshimanga@gmail.com");
include(SITE_MINISTER.'adodb5/adodb.inc.php');
$db = ADONewConnection('mysql');
if(SITE_LOCAL)$db->PConnect("localhost","root", "", "roadcover");
else$db->PConnect("localhost","xpandit", "Success2013", "roadcover");
sanitize($_GET);
sanitize($_POST);
session_start();
if($_POST['cimica'])$_GET['iyona']=$_POST['cimico'];
#==============================================================================#
#FUNCTIONS
#==============================================================================#
/**
 * sanitize is function used to protect against script injection
 *
 * It will verify all the variable sent to the function
 * @author fredtma
 * @version 0.5
 * @param array $__theValue is the variable taken in to clean <var>$__theValue</var>
 * @see get_rich_custom_fields()
 * @uses get_rich_custom_fields()
 * @return void
 */
function sanitize(&$__theValue)
{
   if (!empty($__theValue))
   {
      foreach ($__theValue as $name => &$data)
      {
         if (!is_array($data))
         { // If it's not an array, clean it
            #echo ("<i>$name</i>=<STRONG>".$data."</STRONG>: is being sanatized to ");
            $data = strip_tags($data,'<p><br><b><strong><ul><li><ol><i><em><u><div><span><img><table><tr><td><hr><h1><h2><h3><h4><h5><h6>');#removed for now
            $data = htmlentities($data, ENT_QUOTES,'UTF-8');
            $data = str_replace(array('&nbsp;','&amp;','&lt;','&gt;'),array('','&','<','>'), $data);
         }else{
            sanitize($data);
         }
      }//end foreach
      reset($__theValue);
   }
}//end function sanitize
#==============================================================================#
/**
 * use to get the sites page, using either the physical file or the one in the db
 * @author fredtma
 * @version 5.2
 * @category page, content page
 * @return bool
 * @todo add the db pages, php includes, variable variation
 */
function cera()
{
    $cera   = $header = $_GET['cera'];
    $module = $_GET['module'];
    $file   = '';
    if($module && file_exists(SITE_CERA.$cera.".php")) include(SITE_CERA.$cera.".php");
    else if(file_exists(SITE_CERA.$cera.".html")) $content=file_get_contents(SITE_CERA.$cera.".html");
    else $content = "<ul class='breadcrumb'><li>Page Under Construction</li></ul>";

    return [$header,$content];
}//end function
#==============================================================================#
/**
 * used to display message, this will echo the message on the web page
 *
 * <p>The function verify if it is an array or a normal type variable and displays accordinly</p>
 * <p>If the variable <var>$__adm</var> is set only the administrator with the specified id will view the message</p>
 * <p>The function can brusquely stop the script by setting <var>$__stop</var></p>
 *
 * @author fredtma
 * @version 1.2
 * @param mixed <var>$__var</var> is the variable to be displayed
 * @param bool <var>$__adm</var> is the variable set to display admin message
 * @param bool <var>$__stop</var> is the variable that will end an execution
 * @param bool <var>$__many</var> option to include more than one value
 * @return string|array in an echo statment
 */
function iyona($__var, $__adm=false, $__stop=false)
{
   if ($__adm) $__adm = !iyona_adm($__adm);
   if (!$__adm)
   {
      echo "<pre>\n";
      var_dump ($__var);
      if ($__stop) exit;
      echo "</pre>\n";
   }
}//end function
function loggin(){
   $num=func_num_args();
   for($x=0;$x<$num;$x++){var_dump(func_get_arg($x));}
}
#==============================================================================#
/**
 * write on the system log the value of variables
 * @author fredtma
 * @version 5.9
 * @category debug, log
 * @param mixed <var>$__var</var> contains single or an array of variable to be checked
 * @param bool <var>$__append</var> option to append to the file or not
 * @param bool <var>$__many</var> option to include more than one value
 * @see iyona()
 * @return void
 */
function iyona_log($__var,$__append=true,$__many=false)
{
   $filename = SITE_DWLD.'logs/temp_log.html';
   if (is_writable($filename))
   {
      if (!$__many)$__var = '<pre>'.date('Y/m/d H:i:s')." ::\r\n".print_r($__var,true).'</pre>';
      else foreach($__var as $var) $__var .= '<pre>'.date('Y/m/d H:i:s')." ::\r\n".print_r($var,true).'</pre>';
      if ($__append) {
         $old_content=file_get_contents($filename);file_put_contents($filename, $__var.PHP_EOL.$old_content);
      }
      else if (!$__append) file_put_contents($filename, $__var);
   }//endif
}//end function
#==============================================================================#

/**
 * verify if the adminstrator with the user if <var>$_SESSION['access']->adm_login[id]<var> is true
 * @author fredtma
 * @version 1.1
 * @see iyona()
 * @return bool return true for the administrator set
 */
function iyona_adm ($user_id='')
{
   if (is_array($user_id)) {
      foreach($user_id as $val) {
         if ($_SESSION['access'][id]==$val) return true;
      }
      return false;
   }
   if ($_GET['iyona']=='testing' || $_GET['iyona']=='test') $_SESSION['test_mode']=true;
   if ($_GET['iyona']=='off') unset($_SESSION['test_mode']);
   if ($_SESSION['access'][id]==113) return true;
   else if ($_SESSION['access'][id]==113 || $_SESSION['test_mode']) return true;
   return false;
}
#==============================================================================#
/**
 * shows the error message of the database.
 *
 * <p>This is only displayed to the adminstrator.</p>
 * <p>if <var>$__table</var> is invalid the message is displayed and return false</p>
 * @gloabl object $db use to access all the db function
 * @author fredtma
 * @version 0.3
 * @param object $__table is the object used to see if it is valid
 * @param string $__sql is the variable taken in to clean <var>$__theValue</var>
 * @see iyona_adm(), iyona()
 * @return bool return true when there is no error to display
 * @uses iyona_adm()
 */
function iyona_message ($__table, $__sql='',$__display=false) {
   global $db;

   if (!$__table)
   {
      if (iyona_adm()) iyona("::".$db->ErrorMsg()."<p>$__sql</p>",1);
      return false;
   }
   else
   {
      if($__display) iyona($__sql,1);
      return true;
   }
}
/**
 * used to measure script execution time
 *  *
 * @author fredtma
 * @version 0.9 *  *
 * @return real the time measured in seconds on the server
 */
#==============================================================================#
/**
 * sends a message to the adm
 * @author fredtma
 * @version 2.3
 * @category iyona, mail, message
 * @param string <var>$_msg</var> the message to be sent
 * @return bool <var>$result</var> if the message was sent or not
 */
function iyona_mail($_msg, $_sbj="Admin Message")
{
   if (iyona_adm())
   {
      if (!class_exists('Email')) include_once("/wwwroot/jonti2/www/inc/Email.php");
      $from    = array('iyona','noreply@jonti.co.za');
      $to      = array('Frederick','ftshimanga@xpandit.co.za');
      $mail    = new Email();
      $result  = $mail->Send($to, $_sbj, $_msg, $from);
   }//end if
   return $result;
}//end function
#==============================================================================#
/**
 * used to record the history of registered candidate only.
 * This is per candidate browsing session and will update changes on the date_departed
 * according to the page changed or logout.
 * @author fredtma
 * @version 0.2
 * @category history, candidate
 * @gloabl object $db
 * @see Mobile_Detect.php
 * @return void
 * @uses Mobile_Detect.php
 */
function record_history()
{
   global $db;
   $user_id = ($_SESSION['access']->usr_login['id'])?$_SESSION['access']->usr_login['id']:$_SESSION['access']->adm_login['id'];

   if ($user_id && ($_SESSION['sess_history'] != session_id() ) )/*instead of searching the db compare session and time*/
   {
      $mobile                   = new Mobile_Detect();
      $_SESSION['sess_history'] = session_id();
      $mobile_user              = $db->qstr($mobile->isMobile());
      $browser                  = $db->qstr(getBrowser());
      $OS                       = $db->qstr(getOS());
      $ip_address               = $db->qstr($_SERVER['REMOTE_ADDR']);
      $user_agent               = ($_SERVER['HTTP_USER_AGENT'])?$_SERVER['HTTP_USER_AGENT']:$_SERVER['HTTP_X_DEVICE_USER_AGENT'];
      $sql                      = <<<IYONA
      insert into candidate_history (`candidate`,`session_id`,`date_access`,`date_departed`,`mobile_user`,`browser`,`OS`,`ip_address`,`user_agent`)
      values ($user_id, {$db->qstr($_SESSION['sess_history'])}, now(), now(), $mobile_user, $browser, $OS, $ip_address, {$db->qstr($user_agent)} );
IYONA;
      $rs = $db->Execute($sql);iyona_message($rs, $sql);
      $_SESSION['history_id'] = $db->Insert_ID();
   } else if ($user_id && $_SESSION['history_id']) {//end if
      $sql= "update candidate_history set date_departed=now(), page_count=page_count+1 where id={$_SESSION['history_id']}";
      $rs = $db->Execute($sql);
      iyona_message($rs, $sql);
   }

}//end function
#==============================================================================#
/**
 * use to record the speed at which a page is loaded
 * @author fredtma
 * @version 1.7
 * @category record, speed, page
 * @param real $_speed the speed at which the page was loaded
 * @gloabl object $db
 * @see record_candidate()
 * @return void
 */
function record_speed($_speed)
{
   global $db;

   $is_admin   = (stristr($_SERVER[SCRIPT_NAME],"/admin/"))?1:0;
   $_GET['p']  = (empty($_GET['p']) && !empty($_GET['sup-page']))?$_GET['sup-page']:$_GET['p'];
   $p          = $_GET['p']?$_GET['p']:(($is_admin)?'dashboard2':'view_vacancies');
   if ($p && $_speed)
   {
      $sql  = "select speed, total from page_speed where page={$db->qstr($p)}";
      $rs   = $db->Execute($sql); iyona_message($rs, $sql);
      if ($rs->_numOfRows > 0)
      {
         extract($rs->fields);
         $speed   = (($speed*$total)+$_speed)/++$total;
         $sql     = "update page_speed set speed='$speed', total=$total, is_admin=$is_admin where page={$db->qstr($p)}";
         $rs_upd  = $db->Execute($sql); iyona_message($rs_upd, $sql);
      } else {
         $speed   = $_speed;
         $sql     = "INSERT INTO page_speed set speed='$speed', page={$db->qstr($p)}, is_admin=$is_admin";
         $rs_ins  = $db->Execute($sql); iyona_message($rs_ins, $sql);
      }//end if of $rs

      if (round($_speed)>10)
      {
         $user       = $_SESSION['access']->adm_login['id']?$_SESSION['access']->adm_login['id']:$_SESSION['access']->usr_login['id'];
         $client     = $_SESSION['access']->adm_login['client']?$_SESSION['access']->adm_login['client']:$_SESSION['access']->usr_login['client'];
         $url        = $_SERVER['QUERY_STRING'];
         $browser    = $db->qstr(getBrowser());
         $OS         = $db->qstr(getOS());
         $ip_address = $db->qstr($_SERVER['REMOTE_ADDR']);
         $user_agent = ($_SERVER['HTTP_USER_AGENT'])?$_SERVER['HTTP_USER_AGENT']:$_SERVER['HTTP_X_DEVICE_USER_AGENT'];
         $sql = <<<IYONA
         INSERT INTO page_slow (user, client, page, url, speed, browser, OS, user_agent, ip_address)
         VALUES ($user, $client, {$db->qstr($p)}, {$db->qstr($url)}, $_speed, $browser, $OS, {$db->qstr($user_agent)}, $ip_address)
IYONA;
         $rs_ins  = $db->Execute($sql); iyona_message($rs_ins, $sql);
      }
   }//endif if there is a page
   $speed = number_format($speed, 3);
   return "Page <strong>loaded</strong> in $_speed seconds. <br/> The average <strong>speed</strong> is $speed";
}//end function
#==============================================================================#
/**
 * used to detect the OS used
 * @author fredtma
 * @version 1.5
 * @category detection
 * @return string <var>$os_platform</var> the name of the OS
 */
function getOS()
{
   $user_agent    = $_SERVER['HTTP_USER_AGENT'];
   $os_platform   = "Unknown OS Platform";
   $os_array      = array(
       'Windows 8'                  => 'windows nt 6.2',
       'Windows 7'                  => 'windows nt 6.1',
       'Windows Vista'              => 'windows nt 6.0',
       'Windows Server 2003/XP x64' => 'windows nt 5.2',
       'Windows XP'                 => 'windows nt 5.1',
       'Windows XP'                 => 'windows xp',
       'Windows 2000'               => 'windows nt 5.0',
       'Windows ME'                 => 'windows me',
       'Windows 98'                 => 'win98',
       'Windows 95'                 => 'win95',
       'Windows 3.11'               => 'win16',
       'Mac OS X'                   => 'macintosh|mac os x',
       'Mac OS 9'                   => 'mac_powerpc',
       'Linux'                      => 'linux',
       'Ubuntu'                     => 'ubuntu',
       'iPhone'                     => 'iphone',
       'iPod'                       => 'ipod',
       'iPad'                       => 'ipad',
       'Android'                    => 'android',
       'BlackBerry'                 => 'blackberry',
       'Mobile'                     => 'webos',
       'AndroidOS'                  => 'Android',
       'BlackBerryOS'               => 'blackberry|rim tablet os',
       'PalmOS'                     => 'PalmOS|avantgo|blazer|elaine|hiptop|palm|plucker|xiino',
       'SymbianOS'                  => 'Symbian|SymbOS|Series60|Series40|SYB-[0-9]+|\bS60\b',
       // @reference: http://en.wikipedia.org/wiki/Windows_Mobile
       'WindowsMobileOS'            => 'Windows CE.*(PPC|Smartphone|Mobile|[0-9]{3}x[0-9]{3})|Window Mobile|Windows Phone [0-9.]+|WCE;',
       // @reference: http://en.wikipedia.org/wiki/Windows_Phone
       // http://wifeng.cn/?r=blog&a=view&id=106
       // http://nicksnettravels.builttoroam.com/post/2011/01/10/Bogus-Windows-Phone-7-User-Agent-String.aspx
       'WindowsPhoneOS'             => 'Windows Phone OS|XBLWP7|ZuneWP7',
       'iOS'                        => 'iphone|ipod|ipad',
       // http://en.wikipedia.org/wiki/MeeGo
       // @todo: research MeeGo in UAs
       'MeeGoOS'                    => 'MeeGo',
       // http://en.wikipedia.org/wiki/Maemo
       // @todo: research Maemo in UAs
       'MaemoOS'                    => 'Maemo',
       'JavaOS'                     => 'J2ME/MIDP|Java/',
       'webOS'                      => 'webOS|hpwOS',
       'badaOS'                     => '\bBada\b',
       'BREWOS'                     => 'BREW'
   );

   foreach ($os_array as $os => $regex)
   {
      $regex = str_replace('/', '\/', $regex);
      if (preg_match('/'.$regex.'/is', $user_agent))
      {
         return $os_platform = $os;
      }
   }
   return $os_platform;
}
#==============================================================================#
/**
 * used to detect the browser used
 * @author fredtma
 * @version 1.5
 * @category detection
 * @return string <var>$broser</var> the name of the browser
 */
function getBrowser()
{
   $user_agent    = $_SERVER['HTTP_USER_AGENT'];
   $browser       = "Unknown Browser";
   $browser_array = array(
       '/msie/i'      => 'Internet Explorer',
       '/msie 10/i'   => 'Internet Explorer 10',
       '/msie 9/i'    => 'Internet Explorer 9',
       '/msie 8/i'    => 'Internet Explorer 8',
       '/msie 7/i'    => 'Internet Explorer 7',
       '/firefox/i'   => 'Firefox',
       '/safari/i'    => 'Safari',
       '/chrome/i'    => 'Chrome',
       '/opera/i'     => 'Opera',
       '/netscape/i'  => 'Netscape',
       '/maxthon/i'   => 'Maxthon',
       '/konqueror/i' => 'Konqueror',
       '/mobile/i'    => 'Handheld Browser'
   );

   foreach ($browser_array as $regex => $value)
   {
      if (preg_match($regex, $user_agent))
      {
         $browser = $value;
      }
   }
   return $browser;
}
#===============================================================================#
function encrypt_string($sData, $sKey='$20EgoSumViaEtVeritasEtLux00'){
   $sResult = '';
   $expireTime = time() + 600;

   $vars = array('a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z');
   //an 8 digit password
   $code = "";
   $code = strtoupper($vars[rand(0,25)]);
   $code .= $vars[rand(0,25)];
   $code .= rand(0,9);
   for ($i=0;$i<=4;$i++) {
      $char = rand(0,1) ? strtoupper($vars[rand(0,25)]) : $vars[rand(0,25)];
      $num = rand(0,9);
      $code .= rand(0,1) ? $char : $num;
   }

   $sData ="{$expireTime}_{$sData}_{$code}";
   for($i=0;$i<strlen($sData);$i++){
      $sChar    = substr($sData, $i, 1);
      $sKeyChar = substr($sKey, ($i % strlen($sKey)) - 1, 1);
      $sChar    = chr(ord($sChar) + ord($sKeyChar));
      $sResult .= $sChar;
   }
   return encode_base64($sResult);
}
#===============================================================================#
function decrypt_string($sData, $sKey='$20EgoSumViaEtVeritasEtLux00'){
    $sResult = '';
    $sData   = decode_base64($sData);

    for($i=0;$i<strlen($sData);$i++){
        $sChar    = substr($sData, $i, 1);
        $sKeyChar = substr($sKey, ($i % strlen($sKey)) - 1, 1);
        $sChar    = chr(ord($sChar) - ord($sKeyChar));
        $sResult .= $sChar;
    }

    $time   = substr($sResult,0,strpos($sResult, '_'));
    $code   = substr($sResult,  strrpos($sResult, '_')+1);
    $sResult= substr($sResult,strpos($sResult, '_')+1);
    $sResult= substr($sResult,0,strlen($sResult)-strlen($code)-1);
    $exppire= time()-$time;

    return ($exppire>600)?false:$sResult;
}
#===============================================================================#
function encode_base64($sData){
    $sBase64 = base64_encode($sData);
    return strtr($sBase64, '+/', '-_');
}
#===============================================================================#
function decode_base64($sData){
    $sBase64 = strtr($sData, '-_', '+/');
    return base64_decode($sBase64);
}
#==============================================================================#
/**
 * encrypt an email from it been seen by bots
 *
 * every letters will be converted in ordinal character, note that the on click mailto: will not work
 * @author fredtma
 * @version 0.7
 * @category mail
 * @param string $__email the original email <var>$__email</var>
 * @return string
 * @uses str_split
 */
function email_encryptor($_email,$_full=false,$_name='')
{
   $arr_mail = str_split($_email);
   foreach($arr_mail as $letter)
   {
      if ($letter=='@') $mail .= "<!--please remove this-->&#".ord($letter).";<!--please remove this-->";
      else $mail .= '&#'.ord($letter).';';
   }
   $name = ($_name)?$_name:$mail;
   if ($_full) echo "<a href='mailto:$mail'>$name</a>";
   else return $mail;
}
#==============================================================================#
/**
 * used to format message that will be sent via email
 * @author fredtma
 * @version 0.1
 * @category email, message
 * @param string $message is the variable will be included in the mail <var>$message</var>
 * @see NotificationEngine.php
 * @return string
 */
function mail_message($_to,$_subject,$_message)
{
   $img_src    = "<img src='".SITE_PUBLIC."/img/logo128.png' alt='Road Cover System' border='0' align='left'/>";
   $message = <<<IYONA
<table border="0" align="center" cellpadding="0" cellspacing="0" width='920'>
   <tr><td>$img_src</td></tr>
      <tr>
         <td align="left" valign="top">
            <table  align="center" width='100%' cellpadding="0" border="0" cellspacing="10" style="font-size:10px;border:5px solid #ececec;color:#666666; font-family: calibri;">
               <tr border="1">
                  <td align="left" valign="top" border="1">
                     <pre style="font-size:14px; color:#666666; font-family: calibri,Verdana, Geneva, sans-serif;" >$_message</pre>
                  </td>
               </tr>
            </table>
         </td>
      </tr>
</table>
IYONA;
   if($_to){
      include(INCLUDE_MAIL);
      include("../bibliotheca/PHPMailer_5.2.4/class.smtp.php");
      $mail = new PHPMailer();
      if(false){
         $mail->IsSMTP();
         $mail->Host       = "197.96.139.19";
         $mail->SMTPDebug  = 2;
         $mail->SMTPAuth   = true;
         $mail->SMTPSecure = "tls";
         $mail->Host       = "smtp.gmail.com";
         $mail->Port       = 587;
         $mail->Username   = EMAIL_SUPPORT;
         $mail->Password   = "saouiplgnkknvafp";
      }
      $mail->SetFrom(EMAIL_SUPPORT, "roadCover Support");
      $mail->AddReplyTo(EMAIL_SUPPORT, "roadCover Support");
      $mail->AddAddress($_to);
      $mail->MsgHTML($message);
      $mail->Subject =$_subject;
      $mail->AltBofy =$_message;
      if(!$mail->send()){ $msg="Mailer Error: ".$mail->ErrorInfo; $status=false;}
      else {$msg="Message sent"; $status=true;}
   }
   return [$msg,$status,$message];
}
#==============================================================================#
function make_csv($csv_head, $csv_value, $file, $lev = 0)
{
   $filename = SITE_DOWNLOAD_CSV_PATH . $file;
   $content  = '"' . implode("\",\"", $csv_head) . "\"\n";
   file_put_contents($filename, $content);

   if ($lev == 0)
   {
      $content .= '"' . implode("\",\"", $csv_value) . "\"\n";
      file_put_contents($filename, $content, FILE_APPEND);
   }
   else if ($lev == 1)
   {
      foreach ($csv_value as $csv_row)
      {
         $content2 = '"' . implode("\",\"", $csv_row) . "\"\n";
         $content .= $content2;
         file_put_contents($filename, $content2, FILE_APPEND);
      }//endfor
   }
   header('Content-type: application/vnd.ms-excel');
   header("Content-Disposition: attachement; filename=$file");
   echo $content;
   exit;
}
//endfunc
#==============================================================================#
function array_to_XML($data, $indent_size = 2 , $header = '<?xml version="1.0" encoding="utf-8"?>') {
   $xml = _array_to_XML($data, $indent_size, $indent_size);
   return $header . "\n" . $xml;
}
#==============================================================================#
function _array_to_XML($data, $indent_size, $orig_indent) {
   $indent = '';
   for($x=0; $x <= $indent_size; $x++) {
      $indent .= ' ';
   }
   if (!is_array($data)) {
      return FALSE;
   }
   foreach ($data as $key => $val) {
      if (is_array($val)) {
         $responce = '';
         $responce .= _array_to_XML($val, $indent_size + $orig_indent, $orig_indent);
         $xml .= ($responce ? $indent . '<' . $key . '>' . "\n" . $responce . $indent . '</' . $key . '>' . "\n" : '');
      }
      else {
         $xml .= $indent . '<' . $key . '>' . $val . '</' . $key . '>' . "\n";
      }
   }
   return $xml;
}
#==============================================================================#

?>
