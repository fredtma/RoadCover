<?php
/*
 * part of an include to display the forgot password application
 *
 * @author fredtma
 * @version 3.9
 * @category include, application, backend
 * @gloabl object $db
 */
$legend  ="Enter your new password in the field below and submit the changes.";
$header  ="Forgot Password";
$viewForm=true;
if(!$_POST['password']){
   $mail    =decrypt_string($_GET['var1']);
   if(!$mail){
      $legend  ="Time expired.";
      $msg     ="The time limit to change the password has passed.<br/>You are required to request a password change again.";
      $viewForm=false;
   } else {
      $mail  = explode(",", $mail);
      $email = $mail[0];
      $user  = $mail[1];
      $time  = $mail[2];
   }
}else{
   $sql="UPDATE roadCover_users SET passowrd={$db->qstr($_POST['password'])} WHERE username={$db->qstr($_POST['user'])} AND email={$db->qstr($_POST['email'])}";
   if($db->Execute($sql)){
      $viewForm=false;
      $msg="Your password has been successfully change click on return to access the site and login with your new password";
   }else{
      $viewForm=true;
      $msg="There was an error while changing the password";
   }
}
ob_start();
?>
<form id="formContent" method="post">
   <fieldset>
      <legend><?=$legend?></legend>
      <?php if($viewForm):?>
      <input type="hidden" name="email" value="<?=$email?>">
      <input type="hidden" name="user" value="<?=$user?>">
      <div class="control-group">
         <label class="control-label" for="inputEmail">New Password</label>
         <div class="controls">
            <div class="input-prepend">
               <span class="add-on"><i class="icon-lock"></i></span>
               <input type="text" id="password" placeholder="password" autofocus required>
            </div>
         </div>
      </div>
      <div class="control-group">
         <label class="control-label" for="inputPassword">Re-Password</label>
         <div class="controls">
            <div class="input-prepend">
               <span class="add-on"><i class="icon-lock"></i></span>
               <input type="password" id="signum" placeholder="Re-Password" required>
            </div>
         </div>
      </div>
      <?php endif;?>
      <span id="messages" class="text-success"><?=$msg?></span>
   </fieldset>
</form>
<script>
   $("#formContent").submit(function(e){
//      e.preventDefault();
      var patterns=JSON.parse(localStorage.EXEMPLAR);
      var pwd=$("#password").val(),sig=$("#signum").val(),omega=true;
      if(pwd.search(patterns["password"][0])==-1||!pwd){var msg='The password '+patterns["password"][1]+'.';omega=false;}
      if(pwd!==sig){msg+=' Passwords do not match';omega=false;}
      if(!omega){$("#messages").removeClass("text-success").addClass("text-error").html(msg)}
      return false;
   });
</script>
<?php
$content=ob_get_contents();
ob_end_clean();
?>