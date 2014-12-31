<!doctype html>
<html>
<head>
	<title>roadCover Report Management</title>
<?php if (@$gsExport == "" || @$gsExport == "print") { ?>
<meta charset="utf-8">
<?php } else { // Export to Word/Excel/Pdf/Email ?>
<?php if (EWRPT_ENCODING == "UTF-8") { ?>
<meta charset="utf-8">
<?php } ?>
<?php } ?>
<?php if (@$gsExport == "") { ?>
<?php } ?>
<?php if (@$gsExport == "") { ?>
<link rel="stylesheet" type="text/css" href="<?php echo ewrpt_YuiHost() ?>build/button/assets/skins/sam/button.css" />
<link rel="stylesheet" type="text/css" href="<?php echo ewrpt_YuiHost() ?>build/container/assets/skins/sam/container.css" />
<link rel="stylesheet" type="text/css" href="<?php echo ewrpt_YuiHost() ?>build/resize/assets/skins/sam/resize.css" />
<?php } ?>
<?php if (@$gsExport == "" || @$gsExport == "print") { ?>
<link rel="stylesheet" type="text/css" href="<?php echo EWRPT_PROJECT_STYLESHEET_FILENAME ?>" />
<?php } else { ?>
<style type="text/css">
<?php $cssfile = (@$gsExport == "pdf") ? (EWRPT_PDF_STYLESHEET_FILENAME == "" ? EWRPT_PROJECT_STYLESHEET_FILENAME : EWRPT_PDF_STYLESHEET_FILENAME) : EWRPT_PROJECT_STYLESHEET_FILENAME ?>
<?php echo file_get_contents($cssfile) ?>
</style>
<?php } ?>
<?php if (@$gsExport == "" || @$gsExport == "print" || @$gsExport == "email") { ?>
<script type="text/javascript" src="<?php echo ewrpt_YuiHost() ?>build/utilities/utilities.js"></script>
<?php } ?>
<?php if (@$gsExport == "") { ?>
<script type="text/javascript" src="<?php echo ewrpt_YuiHost() ?>build/button/button-min.js"></script>
<script type="text/javascript">
if (!window.Calendar) {
	document.write("<link rel=\"stylesheet\" type=\"text/css\" media=\"all\" href=\"jscalendar/calendar-win2k-1.css\" title=\"win2k-1\">");
	document.write("<" + "script type=\"text/javascript\" src=\"jscalendar/calendar.js\"><" + "/script>");
	document.write("<" + "script type=\"text/javascript\" src=\"jscalendar/lang/calendar-en.js\"><" + "/script>");
	document.write("<" + "script type=\"text/javascript\" src=\"jscalendar/calendar-setup.js\"><" + "/script>");
}
</script>
<script type="text/javascript">
<!--
var EWRPT_LANGUAGE_ID = "<?php echo $gsLanguage ?>";
var EWRPT_DATE_SEPARATOR = "-";
if (EWRPT_DATE_SEPARATOR == "") EWRPT_DATE_SEPARATOR = "/"; // Default date separator

//-->
</script>
<script type="text/javascript" src="<?php echo ewrpt_YuiHost() ?>build/container/container-min.js"></script>
<script type="text/javascript" src="<?php echo ewrpt_YuiHost() ?>build/resize/resize.js"></script>
<?php } ?>
<?php if (@$gsExport == "" || @$gsExport == "print" || @$gsExport == "email") { ?>
<script type="text/javascript" src="phprptjs/ewrpt.js"></script>
<?php } ?>
<?php if (@$gsExport == "") { ?>
<script type="text/javascript">
<!--
<?php echo $ReportLanguage->ToJSON() ?>

//-->
</script>
<script type="text/javascript">
var EWRPT_IMAGES_FOLDER = "phprptimages";
</script>
<?php } ?>
<meta name="generator" content="PHP Report Maker v5.1.0" />
</head>
<body class="yui-skin-sam">
<?php if (@$gsExport == "") { ?>
<div class="ewLayout">
	<!-- header (begin) --><!-- *** Note: Only licensed users are allowed to change the logo *** -->
	<div class="ewHeaderRow"><img src="phprptimages/logo.gif" alt="" border="0" /></div>
	<!-- header (end) -->
	<!-- content (begin) -->
	<!-- navigation -->
	<table cellspacing="0" class="ewContentTable">
		<tr>	
			<td class="ewMenuColumn">
<?php include_once "menu.php"; ?>
			<!-- left column (end) -->
			</td>
			<td class="ewContentColumn">
<?php } ?>
