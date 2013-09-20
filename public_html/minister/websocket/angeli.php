#!/php -q
<?php
include "angeli.class.php";
class ChatBot extends WebSocket{
  function process($user,$msg){
    $this->say("< ".$msg);
    $all=true;

    switch($msg){
//      case "hello" : $this->send($user->socket,"hello human",$all);                       break;
//      case "hi"    : $this->send($user->socket,"zup human",$all);                         break;
//      case "name"  : $this->send($user->socket,"my name is Multivac, silly I know",$all); break;
//      case "age"   : $this->send($user->socket,"I am older than time itself",$all);       break;
      case "date"  : $this->send($user->socket,"today is ".date("Y.m.d"),$all);           break;
      case "time"  : $this->send($user->socket,"server time is ".date("H:i:s"),$all);     break;
      case "thanks": $this->send($user->socket,"you're welcome",$all);                    break;
      case "bye"   : $this->send($user->socket,"bye",$all);                               break;
      default      : $this->send($user->socket,$msg,$all);                                break;
//      default      : $this->send($user->socket,$msg." not understood",$all);              break;
    }
  }
}

$master = new ChatBot("xit-ws-003",8000);
?>
