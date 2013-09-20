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
define("SITE_ROOT","/wwwroot/roadcover/");
define("SITE_PUBLIC",SITE_ROOT."/public_html/");
define("SITE_MINISTER",SITE_ROOT."/minister/");
define("SITE_URL","http://197.96.139.19/");
include(SITE_MINISTER.'adodb5/adodb.inc.php');
$db = ADONewConnection('mysql');
$db->PConnect("localhost","xpandit", "Success2013", "roadcover");
sanitize($_GET);
sanitize($_POST);
session_start();
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
 * used to display message, this will echo the message on the web page
 *
 * <p>The function verify if it is an array or a normal type variable and displays accordinly</p>
 * <p>If the variable <var>$__adm</var> is set only the administrator with the specified id will view the message</p>
 * <p>The function can brusquely stop the script by setting <var>$__stop</var></p>
 *
 * @author fredtma
 * @version 1.2
 * @param mixed $__var is the variable to be displayed
 * @param bool $__adm is the variable set to display admin message
 * @param bool $__stop is the variable that will end an execution
 * @param bool $__write will write onto the disk
 * @param bool $__write will append the written file data
 * @return string|array in an echo statment
 */
function iyona ($__var, $__adm=false, $__stop=false, $__write=false, $__append=false)
{
   if (!$__write)
   {
      if ($__adm) $__adm = !iyona_adm($__adm);
      if (!$__adm)
      {
         echo "<pre>\n";
         if (is_array($__var)) {var_dump($__var);reset($__var);}
         else var_dump ($__var);
         if ($__stop) exit;
         echo "</pre>\n";
      }
   }//end if
   else
   {
      $filename = SITE_ROOT.'/tmp/temp_log.html';
      if (is_writable($filename))
      {
         $__var = '<pre>'.date('Y/m/d H:i:s').' :: '.$_GET['p'].' :: --'.print_r($__var,true).'</pre>';
         if ($__append) file_put_contents($filename, $__var,FILE_APPEND);
         else if (!$__append) file_put_contents($filename, $__var);
      } else if (iyona_adm()) { echo "File is not writen";} //end if
   }//end if
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
#==============================================================================#
?>
