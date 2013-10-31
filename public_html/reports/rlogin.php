<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start();
?>
<?php include_once "phprptinc/ewrcfg5.php"; ?>
<?php include_once "phprptinc/ewmysql.php"; ?>
<?php include_once "phprptinc/ewrfn5.php"; ?>
<?php include_once "phprptinc/ewrusrfn.php"; ?>
<?php ewrpt_Header(FALSE) ?>
<?php

// Create page object
$rptlogin = new crrptlogin();
$Page =& $rptlogin;

// Page init
$rptlogin->Page_Init();

// Page main
$rptlogin->Page_Main();
?>
<?php include_once "phprptinc/header.php"; ?>
<script language="JavaScript" type="text/javascript">
<!--

// Write your client script here, no need to add script tags.
//-->

</script>
<script type="text/javascript" src="phprptjs/ewrpt.js"></script>
<script type="text/javascript">
<!--
var rptlogin = new ewrpt_Page("rptlogin");

// extend page with ValidateForm function
rptlogin.ValidateForm = function(fobj)
{
	if (!this.ValidateRequired)
		return true; // ignore validation
	if (!ewrpt_HasValue(fobj.username))
		return ewrpt_OnError(fobj.username, ewLanguage.Phrase("EnterUid"));
	if (!ewrpt_HasValue(fobj.password))
		return ewrpt_OnError(fobj.password, ewLanguage.Phrase("EnterPwd"));

	// Call Form Custom Validate event
	if (!this.Form_CustomValidate(fobj)) return false;
	return true;
}

// extend page with Form_CustomValidate function
rptlogin.Form_CustomValidate =  
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// requires js validation
<?php if (EWRPT_CLIENT_VALIDATE) { ?>
rptlogin.ValidateRequired = true;
<?php } else { ?>
rptlogin.ValidateRequired = false;
<?php } ?>

//-->
</script>
<p class="phpreportmaker ewTitle"><?php echo $ReportLanguage->Phrase("LoginPage") ?></p>
<?php $rptlogin->ShowMessage(); ?>
<form action="rlogin.php" method="post" onsubmit="return rptlogin.ValidateForm(this);">
<table border="0" cellspacing="0" cellpadding="4">
	<tr>
		<td><span class="phpreportmaker"><?php echo $ReportLanguage->Phrase("Username") ?></span></td>
		<td><span class="phpreportmaker"><input type="text" name="username" size="20" value="<?php echo $rptlogin->Username ?>"></span></td>
	</tr>
	<tr>
		<td><span class="phpreportmaker"><?php echo $ReportLanguage->Phrase("Password") ?></span></td>
		<td><span class="phpreportmaker"><input type="password" name="password" size="20"></span></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td><span class="phpreportmaker">
		<label><input type="radio" name="rememberme" id="rememberme" value="a"<?php if ($rptlogin->LoginType == "a") { ?> checked="checked"<?php } ?>><?php echo $ReportLanguage->Phrase("AutoLogin") ?></label><br>
		<label><input type="radio" name="rememberme" id="rememberme" value="u"<?php if ($rptlogin->LoginType == "u") { ?>  checked="checked"<?php } ?>><?php echo $ReportLanguage->Phrase("SaveUserName") ?></label><br>
		</span></td>
	</tr>
	<tr>
		<td colspan="2" align="center"><span class="phpreportmaker"><input type="submit" name="submit" value="<?php echo $ReportLanguage->Phrase("Login") ?>"></span></td>
	</tr>
</table>
</form>
<br>
<script language="JavaScript" type="text/javascript">
<!--

// Write your startup script here
// document.write("page loaded");
//-->

</script>
<?php include_once "phprptinc/footer.php"; ?>
<?php
$rptlogin->Page_Terminate();
?>
<?php

//
// Page class
//
class crrptlogin {

	// Page ID
	var $PageID = 'rptlogin';

	// Page object name
	var $PageObjName = 'rptlogin';

	// Page name
	function PageName() {
		return ewrpt_CurrentPage();
	}

	// Page URL
	function PageUrl() {
		$PageUrl = ewrpt_CurrentPage() . "?";
		return $PageUrl;
	}

	// Message
	function getMessage() {
		return @$_SESSION[EWRPT_SESSION_MESSAGE];
	}

	function setMessage($v) {
		if (@$_SESSION[EWRPT_SESSION_MESSAGE] <> "") { // Append
			$_SESSION[EWRPT_SESSION_MESSAGE] .= "<br>" . $v;
		} else {
			$_SESSION[EWRPT_SESSION_MESSAGE] = $v;
		}
	}

	// Show message
	function ShowMessage() {
		$sMessage = $this->getMessage();
		$this->Message_Showing($sMessage);
		if ($sMessage <> "") { // Message in Session, display
			echo "<p><span class=\"ewMessage\">" . $sMessage . "</span></p>";
			$_SESSION[EWRPT_SESSION_MESSAGE] = ""; // Clear message in Session
		}
	}

	// Validate page request
	function IsPageRequest() {
		return TRUE;
	}

	//
	// Page class constructor
	//
	function crrptlogin() {
		global $conn, $ReportLanguage;

		// Language object
		$ReportLanguage = new crLanguage();

		// Page ID
		if (!defined("EWRPT_PAGE_ID"))
			define("EWRPT_PAGE_ID", 'rptlogin', TRUE);

		// Start timer
		$GLOBALS["gsTimer"] = new crTimer();

		// Open connection
		$conn = ewrpt_Connect();
	}

	// 
	//  Page_Init
	//
	function Page_Init() {
		global $gsExport, $gsExportFile, $ReportLanguage, $Security;

		// Security
		$Security = new crAdvancedSecurity();

		// Global Page Loading event (in userfn*.php)
		Page_Loading();

		// Page Load event
		$this->Page_Load();
	}

	//
	// Page_Terminate
	//
	function Page_Terminate($url = "") {
		global $conn;
		global $ReportLanguage;

		// Page Unload event
		$this->Page_Unload();

		// Global Page Unloaded event (in userfn*.php)
		Page_Unloaded();

		 // Close connection
		$conn->Close();

		// Go to URL if specified
		if ($url <> "") {
			if (!EWRPT_DEBUG_ENABLED && ob_get_length())
				ob_end_clean();
			header("Location: " . $url);
		}
		exit();
	}

	// Initialize common variables
	var $Username;
	var $LoginType;

	//
	// Page main
	//
	function Page_Main() {
		global $ReportLanguage;
		global $Security;
		$bValidPwd = FALSE;
		$this->Username = "";
		$sPassword = "";
		if (!$Security->IsLoggedIn()) $Security->AutoLogin(); // Auto login
		$sLastUrl = $Security->LastUrl();
		if ($sLastUrl == "")
			$sLastUrl = "index.php";
		if (@$_POST["submit"] <> "") {
			$bValidPwd = FALSE;

			// Setup variables
			$this->Username = ewrpt_StripSlashes(@$_POST["username"]);
			$sPassword = ewrpt_StripSlashes(@$_POST["password"]);
			$this->LoginType = strtolower(@$_POST["rememberme"]);
			$bValidate = $this->ValidateForm($this->Username, $sPassword);
			if (!$bValidate)
				$this->setMessage($gsFormError);
			if ($bValidate) {
				if ($Security->ValidateUser($this->Username, $sPassword, FALSE)) {

					// Write cookies
					if ($this->LoginType == "a") {
						setcookie(EWRPT_PROJECT_VAR . '[AutoLogin]', "autologin", EWRPT_COOKIE_EXPIRY_TIME);
						setcookie(EWRPT_PROJECT_VAR . '[Username]', TEAencrypt($this->Username, EWRPT_RANDOM_KEY), EWRPT_COOKIE_EXPIRY_TIME);
						setcookie(EWRPT_PROJECT_VAR . '[Password]', TEAencrypt($sPassword, EWRPT_RANDOM_KEY), EWRPT_COOKIE_EXPIRY_TIME);
						setcookie(EWRPT_PROJECT_VAR . '[Checksum]', crc32(md5(EWRPT_RANDOM_KEY)), EWRPT_COOKIE_EXPIRY_TIME);
					} elseif ($this->LoginType == "u") {
						setcookie(EWRPT_PROJECT_VAR . '[AutoLogin]', "rememberusername", EWRPT_COOKIE_EXPIRY_TIME);
						setcookie(EWRPT_PROJECT_VAR . '[Username]', TEAencrypt($this->Username, EWRPT_RANDOM_KEY), EWRPT_COOKIE_EXPIRY_TIME);
						setcookie(EWRPT_PROJECT_VAR . '[Checksum]', crc32(md5(EWRPT_RANDOM_KEY)), EWRPT_COOKIE_EXPIRY_TIME);
					} else {
						setcookie(EWRPT_PROJECT_VAR . '[AutoLogin]', "", EWRPT_COOKIE_EXPIRY_TIME);
					}
					$_SESSION[EWRPT_SESSION_STATUS] = "login";
					$this->Page_Terminate($sLastUrl); // Return to last accessed page
				} else {
					$this->setMessage($ReportLanguage->Phrase("InvalidUidPwd"));
				}
			}
		} else {
			if ($Security->IsLoggedIn()) {
				if ($this->getMessage() == "")
					$this->Page_Terminate($sLastUrl); // Return to last accessed page
			}

			// Restore settings
			if (@$_COOKIE[EWRPT_PROJECT_VAR]['Checksum'] == strval(crc32(md5(EWRPT_RANDOM_KEY))))
				$this->Username = TEAdecrypt(@$_COOKIE[EWRPT_PROJECT_VAR]['Username'], EWRPT_RANDOM_KEY);
			if (@$_COOKIE[EWRPT_PROJECT_VAR]['AutoLogin'] == "autologin") {
				$this->LoginType = "a";
			} elseif (@$_COOKIE[EWRPT_PROJECT_VAR]['AutoLogin'] == "rememberusername") {
				$this->LoginType = "u";
			} else {
				$this->LoginType = "";
			}
		}
	}

	//
	// Validate form
	//
	function ValidateForm($usr, $pwd) {
		global $ReportLanguage, $gsFormError;

		// Initialize form error message
		$gsFormError = "";

		// Check if validation required
		if (!EWRPT_SERVER_VALIDATE)
			return TRUE;
		if (trim($usr) == "") {
			$gsFormError .= ($gsFormError <> "") ? "<br>" : "";
			$gsFormError .= $ReportLanguage->Phrase("EnterUid");
		}
		if (trim($pwd) == "") {
			$gsFormError .= ($gsFormError <> "") ? "<br>" : "";
			$gsFormError .= $ReportLanguage->Phrase("EnterPwd");
		}

		// Return validate result
		$ValidateForm = ($gsFormError == "");

		// Call Form Custom Validate event
		$sFormCustomError = "";
		$ValidateForm = $ValidateForm && $this->Form_CustomValidate($sFormCustomError);
		if ($sFormCustomError <> "") {
			$gsFormError .= ($gsFormError <> "") ? "<br>" : "";
			$gsFormError .= $sFormCustomError;
		}
		return $ValidateForm;
	}

	// Page Load event
	function Page_Load() {

		//echo "Page Load";
	}

	// Page Unload event
	function Page_Unload() {

		//echo "Page Unload";
	}

	// Message Showing event
	function Message_Showing(&$msg) {

		// Example:
		//$msg = "your new message";

	}

	// Form Custom Validate event
	function Form_CustomValidate(&$CustomError) {

		// Return error message in CustomError
		return TRUE;
	}
}
?>
