<?php
/*
 * This is the client making request SOAP file
 *
 * @author fredtma
 * @version 1.2
 * @see /kroll/test.php
 */
error_reporting(E_ALL & ~E_NOTICE);
ini_set('display_errors', '1');
require_once  'PHP-RSA/RSA.php';
require_once  'PHP-RSA/Math/BCMath.php';
require_once  'PHP-RSA/Math/GMP.php';
include("../../kroll/nusoap/lib/nusoap.php");
session_start();
$client  = new nusoap_client('http://41.66.140.126/dns/live/Dns.ThirdParty.Access.Service/Main.asmx?WSDL', 'wsdl');
$client->debug_flag = true;
$client->soap_defencoding = 'utf-8';
//$client->HTTPContentType = 'application/soap+xml';
//$headers['Content-Type'] = 'application/soap+xml';

$result           = $client->call('GetPublicKey');
$_SESSION['token']= $result['GetPublicKeyResult'];
//$resp       = gmp_powm('message', $_SESSION['token'], 'key');var_dump($resp);
#==============================================================================#
$sysUserId  = 11038;#10248;
$pass       = 11038;"AllAccess";
$sessionId  = session_id();"N";
$pubKey  = $_SESSION['token']?$_SESSION['token']:'';
var_dump($pubKey);
$xml     = new SimpleXMLElement($pubKey);
$RSA     = new RSA();
$RSA->public_key=(string)$xml->Modulus.(string)$xml->Exponent;
$RSA->modulus=(string)$xml->Modulus;
$password=$RSA->encrypt($pass);
echo 'password='.var_dump($password).'---';
var_dump((string)$xml->Modulus.(string)$xml->Exponent);
$pubKey=(string)$xml->Modulus.(string)$xml->Exponent;
#==============================================================================#
$namespaces = false;
echo $inputData  = <<<IYONA
<dns.secure.comms.token.request>
<sysuser.id>$sysUserId</sysuser.id>
<password>$password</password>
<session.id>$sessionId</session.id>
<public.key><![CDATA[$pubKey]]></public.key>
</dns.secure.comms.token.request>
IYONA;
$params     = array('inputData'=>$inputData);

$result     = $client->call('GetCommunicationsToken', $params, $namespaces, '', '',null,'document','literal');
//$result     = $client->call('GetCommunicationsToken', array("parameters"=>$params));

if ($client->fault)
{ //soap_fault
   print "<h2>Soap Fault: </h2><pre>({$client->faultcode}){$client->faultstring}</pre>";
}
elseif ($client->getError())
{
   print "<h2>Soap Error: </h2><pre>" . $client->getError() . "</pre>";
}
else
{
   $_SESSION['token'] = $result['GetPublicKeyResult'];
   print "<h2>Result: </h2><pre>" . var_export($result, true) . "</pre>";
}
$str1 = str_replace("><",">\n<",$client->request);
$str2 = str_replace("><",">\n<",$client->response);
print '<h2>Details:</h2><hr />' .
        '<h3>Request</h3><pre>' .htmlspecialchars($str1, ENT_QUOTES).'</pre>'.
        '<h3>Response</h3><pre>'.htmlspecialchars($str2, ENT_QUOTES).'</pre>'.
        '<h3>Debug</h3><pre>' .
        htmlspecialchars($client->debug_str, ENT_QUOTES) . '</pre>';

echo '>>> ' . $result;
?>
