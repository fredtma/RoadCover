<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start();
?>
<?php include_once "phprptinc/ewrcfg5.php"; ?>
<?php include_once "phprptinc/ewmysql.php"; ?>
<?php include_once "phprptinc/ewrfn5.php"; ?>
<?php include_once "phprptinc/ewrusrfn.php"; ?>
<?php

// Global variable for table object
$customersDeal = NULL;

//
// Table class for customersDeal
//
class crcustomersDeal {
	var $TableVar = 'customersDeal';
	var $TableName = 'customersDeal';
	var $TableType = 'CUSTOMVIEW';
	var $ShowCurrentFilter = EWRPT_SHOW_CURRENT_FILTER;
	var $FilterPanelOption = EWRPT_FILTER_PANEL_OPTION;
	var $CurrentOrder; // Current order
	var $CurrentOrderType; // Current order type

	// Table caption
	function TableCaption() {
		global $ReportLanguage;
		return $ReportLanguage->TablePhrase($this->TableVar, "TblCaption");
	}

	// Session Group Per Page
	function getGroupPerPage() {
		return @$_SESSION[EWRPT_PROJECT_VAR . "_" . $this->TableVar . "_grpperpage"];
	}

	function setGroupPerPage($v) {
		@$_SESSION[EWRPT_PROJECT_VAR . "_" . $this->TableVar . "_grpperpage"] = $v;
	}

	// Session Start Group
	function getStartGroup() {
		return @$_SESSION[EWRPT_PROJECT_VAR . "_" . $this->TableVar . "_start"];
	}

	function setStartGroup($v) {
		@$_SESSION[EWRPT_PROJECT_VAR . "_" . $this->TableVar . "_start"] = $v;
	}

	// Session Order By
	function getOrderBy() {
		return @$_SESSION[EWRPT_PROJECT_VAR . "_" . $this->TableVar . "_orderby"];
	}

	function setOrderBy($v) {
		@$_SESSION[EWRPT_PROJECT_VAR . "_" . $this->TableVar . "_orderby"] = $v;
	}

//	var $SelectLimit = TRUE;
	var $Id;
	var $Transaction_Status;
	var $Agrement_Status;
	var $DealType_cd;
	var $NotTakenUpReason_cd;
	var $DateCreated;
	var $name;
	var $code;
	var $Agent;
	var $Client;
	var $IdentificationNumber;
	var $Product_Name;
	var $Product_Cost;
	var $Vehicle;
	var $Vehicle_Cost;
	var $fields = array();
	var $Export; // Export
	var $ExportAll = TRUE;
	var $UseTokenInUrl = EWRPT_USE_TOKEN_IN_URL;
	var $RowType; // Row type
	var $RowTotalType; // Row total type
	var $RowTotalSubType; // Row total subtype
	var $RowGroupLevel; // Row group level
	var $RowAttrs = array(); // Row attributes

	// Reset CSS styles for table object
	function ResetCSS() {
    	$this->RowAttrs["style"] = "";
		$this->RowAttrs["class"] = "";
		foreach ($this->fields as $fld) {
			$fld->ResetCSS();
		}
	}

	//
	// Table class constructor
	//
	function crcustomersDeal() {
		global $ReportLanguage;

		// Id
		$this->Id = new crField('customersDeal', 'customersDeal', 'x_Id', 'Id', 't.Id', 3, EWRPT_DATATYPE_NUMBER, -1);
		$this->Id->FldDefaultErrMsg = $ReportLanguage->Phrase("IncorrectInteger");
		$this->fields['Id'] =& $this->Id;
		$this->Id->DateFilter = "";
		$this->Id->SqlSelect = "";
		$this->Id->SqlOrderBy = "";

		// Transaction Status
		$this->Transaction_Status = new crField('customersDeal', 'customersDeal', 'x_Transaction_Status', 'Transaction Status', '`Transaction Status`', 200, EWRPT_DATATYPE_STRING, -1);
		$this->fields['Transaction_Status'] =& $this->Transaction_Status;
		$this->Transaction_Status->DateFilter = "";
		$this->Transaction_Status->SqlSelect = "";
		$this->Transaction_Status->SqlOrderBy = "";

		// Agrement Status
		$this->Agrement_Status = new crField('customersDeal', 'customersDeal', 'x_Agrement_Status', 'Agrement Status', '`Agrement Status`', 200, EWRPT_DATATYPE_STRING, -1);
		$this->fields['Agrement_Status'] =& $this->Agrement_Status;
		$this->Agrement_Status->DateFilter = "";
		$this->Agrement_Status->SqlSelect = "";
		$this->Agrement_Status->SqlOrderBy = "";

		// DealType_cd
		$this->DealType_cd = new crField('customersDeal', 'customersDeal', 'x_DealType_cd', 'DealType_cd', 't.DealType_cd', 200, EWRPT_DATATYPE_STRING, -1);
		$this->fields['DealType_cd'] =& $this->DealType_cd;
		$this->DealType_cd->DateFilter = "";
		$this->DealType_cd->SqlSelect = "";
		$this->DealType_cd->SqlOrderBy = "";

		// NotTakenUpReason_cd
		$this->NotTakenUpReason_cd = new crField('customersDeal', 'customersDeal', 'x_NotTakenUpReason_cd', 'NotTakenUpReason_cd', 't.NotTakenUpReason_cd', 200, EWRPT_DATATYPE_STRING, -1);
		$this->fields['NotTakenUpReason_cd'] =& $this->NotTakenUpReason_cd;
		$this->NotTakenUpReason_cd->DateFilter = "";
		$this->NotTakenUpReason_cd->SqlSelect = "";
		$this->NotTakenUpReason_cd->SqlOrderBy = "";

		// DateCreated
		$this->DateCreated = new crField('customersDeal', 'customersDeal', 'x_DateCreated', 'DateCreated', 't.DateCreated', 135, EWRPT_DATATYPE_DATE, 7);
		$this->DateCreated->FldDefaultErrMsg = str_replace("%s", "-", $ReportLanguage->Phrase("IncorrectDateDMY"));
		$this->fields['DateCreated'] =& $this->DateCreated;
		$this->DateCreated->DateFilter = "";
		$this->DateCreated->SqlSelect = "";
		$this->DateCreated->SqlOrderBy = "";

		// name
		$this->name = new crField('customersDeal', 'customersDeal', 'x_name', 'name', 'd.name', 200, EWRPT_DATATYPE_STRING, -1);
		$this->fields['name'] =& $this->name;
		$this->name->DateFilter = "";
		$this->name->SqlSelect = "";
		$this->name->SqlOrderBy = "";

		// code
		$this->code = new crField('customersDeal', 'customersDeal', 'x_code', 'code', 'd.code', 200, EWRPT_DATATYPE_STRING, -1);
		$this->fields['code'] =& $this->code;
		$this->code->DateFilter = "";
		$this->code->SqlSelect = "";
		$this->code->SqlOrderBy = "";

		// Agent
		$this->Agent = new crField('customersDeal', 'customersDeal', 'x_Agent', 'Agent', '`Agent`', 200, EWRPT_DATATYPE_STRING, -1);
		$this->fields['Agent'] =& $this->Agent;
		$this->Agent->DateFilter = "";
		$this->Agent->SqlSelect = "";
		$this->Agent->SqlOrderBy = "";

		// Client
		$this->Client = new crField('customersDeal', 'customersDeal', 'x_Client', 'Client', '`Client`', 200, EWRPT_DATATYPE_STRING, -1);
		$this->fields['Client'] =& $this->Client;
		$this->Client->DateFilter = "";
		$this->Client->SqlSelect = "";
		$this->Client->SqlOrderBy = "";

		// IdentificationNumber
		$this->IdentificationNumber = new crField('customersDeal', 'customersDeal', 'x_IdentificationNumber', 'IdentificationNumber', 'c.IdentificationNumber', 200, EWRPT_DATATYPE_STRING, -1);
		$this->fields['IdentificationNumber'] =& $this->IdentificationNumber;
		$this->IdentificationNumber->DateFilter = "";
		$this->IdentificationNumber->SqlSelect = "";
		$this->IdentificationNumber->SqlOrderBy = "";

		// Product Name
		$this->Product_Name = new crField('customersDeal', 'customersDeal', 'x_Product_Name', 'Product Name', '`Product Name`', 200, EWRPT_DATATYPE_STRING, -1);
		$this->fields['Product_Name'] =& $this->Product_Name;
		$this->Product_Name->DateFilter = "";
		$this->Product_Name->SqlSelect = "";
		$this->Product_Name->SqlOrderBy = "";

		// Product Cost
		$this->Product_Cost = new crField('customersDeal', 'customersDeal', 'x_Product_Cost', 'Product Cost', '`Product Cost`', 200, EWRPT_DATATYPE_STRING, -1);
		$this->fields['Product_Cost'] =& $this->Product_Cost;
		$this->Product_Cost->DateFilter = "";
		$this->Product_Cost->SqlSelect = "";
		$this->Product_Cost->SqlOrderBy = "";

		// Vehicle
		$this->Vehicle = new crField('customersDeal', 'customersDeal', 'x_Vehicle', 'Vehicle', 'v.Description', 200, EWRPT_DATATYPE_STRING, -1);
		$this->fields['Vehicle'] =& $this->Vehicle;
		$this->Vehicle->DateFilter = "";
		$this->Vehicle->SqlSelect = "";
		$this->Vehicle->SqlOrderBy = "";

		// Vehicle Cost
		$this->Vehicle_Cost = new crField('customersDeal', 'customersDeal', 'x_Vehicle_Cost', 'Vehicle Cost', '`Vehicle Cost`', 200, EWRPT_DATATYPE_STRING, -1);
		$this->fields['Vehicle_Cost'] =& $this->Vehicle_Cost;
		$this->Vehicle_Cost->DateFilter = "";
		$this->Vehicle_Cost->SqlSelect = "";
		$this->Vehicle_Cost->SqlOrderBy = "";
	}

	// Single column sort
	function UpdateSort(&$ofld) {
		if ($this->CurrentOrder == $ofld->FldName) {
			$sLastSort = $ofld->getSort();
			if ($this->CurrentOrderType == "ASC" || $this->CurrentOrderType == "DESC") {
				$sThisSort = $this->CurrentOrderType;
			} else {
				$sThisSort = ($sLastSort == "ASC") ? "DESC" : "ASC";
			}
			$ofld->setSort($sThisSort);
		} else {
			if ($ofld->GroupingFieldId == 0) $ofld->setSort("");
		}
	}

	// Get Sort SQL
	function SortSql() {
		$sDtlSortSql = "";
		$argrps = array();
		foreach ($this->fields as $fld) {
			if ($fld->getSort() <> "") {
				if ($fld->GroupingFieldId > 0) {
					if ($fld->FldGroupSql <> "")
						$argrps[$fld->GroupingFieldId] = str_replace("%s", $fld->FldExpression, $fld->FldGroupSql) . " " . $fld->getSort();
					else
						$argrps[$fld->GroupingFieldId] = $fld->FldExpression . " " . $fld->getSort();
				} else {
					if ($sDtlSortSql <> "") $sDtlSortSql .= ", ";
					$sDtlSortSql .= $fld->FldExpression . " " . $fld->getSort();
				}
			}
		}
		$sSortSql = "";
		foreach ($argrps as $grp) {
			if ($sSortSql <> "") $sSortSql .= ", ";
			$sSortSql .= $grp;
		}
		if ($sDtlSortSql <> "") {
			if ($sSortSql <> "") $sSortSql .= ",";
			$sSortSql .= $sDtlSortSql;
		}
		return $sSortSql;
	}

	// Table level SQL
	function SqlFrom() { // From
		return "road_Transactions t Inner Join road_Holder c On c.Id = t.Holder Inner Join road_FandI a On a.Id = t.FandI Inner Join roadCover_dealers d On d.code = t.Intermediary Left Join road_TxItems v On v.holder = c.Id Left Join road_TxVehicleDetail vv On vv.Type = v.Id Inner Join road_QuoteTransactions q On q.transaction = t.Id Inner Join road_Quote_Agreement ag On ag.Id = q.Agreement";
	}

	function SqlSelect() { // Select
		return "SELECT t.Id, t.Status As \"Transaction Status\", ag.Status \"Agrement Status\", t.DealType_cd, t.NotTakenUpReason_cd, t.DateCreated, d.name, d.code, a.FullNames As \"Agent\", c.FullNames As \"Client\", c.IdentificationNumber, ag.Name As \"Product Name\", Format(q.TotalAmount, 2) As \"Product Cost\", v.Description As Vehicle, Format(vv.Amount, 2) As \"Vehicle Cost\" FROM " . $this->SqlFrom();
	}

	function SqlWhere() { // Where
		return "";
	}

	function SqlGroupBy() { // Group By
		return "";
	}

	function SqlHaving() { // Having
		return "";
	}

	function SqlOrderBy() { // Order By
		return "a.FullNames";
	}

	function SqlSelectAgg() {
		return "SELECT * FROM " . $this->SqlFrom();
	}

	function SqlAggPfx() {
		return "";
	}

	function SqlAggSfx() {
		return "";
	}

	function SqlSelectCount() {
		return "SELECT COUNT(*) FROM " . $this->SqlFrom();
	}

	// Sort URL
	function SortUrl(&$fld) {
		return "";
	}

	// Row attributes
	function RowAttributes() {
		$sAtt = "";
		foreach ($this->RowAttrs as $k => $v) {
			if (trim($v) <> "")
				$sAtt .= " " . $k . "=\"" . trim($v) . "\"";
		}
		return $sAtt;
	}

	// Field object by fldvar
	function &fields($fldvar) {
		return $this->fields[$fldvar];
	}

	// Table level events
	// Row Rendering event
	function Row_Rendering() {

		// Enter your code here	
	}

	// Cell Rendered event
	function Cell_Rendered(&$Field, $CurrentValue, &$ViewValue, &$ViewAttrs, &$CellAttrs, &$HrefValue) {

		//$ViewValue = "xxx";
		//$ViewAttrs["style"] = "xxx";

	}

	// Row Rendered event
	function Row_Rendered() {

		// To view properties of field class, use:
		//var_dump($this-><FieldName>); 

	}

	// Load Filters event
	function Filters_Load() {

		// Enter your code here	
		// Example: Register/Unregister Custom Extended Filter
		//ewrpt_RegisterFilter($this-><Field>, 'StartsWithA', 'Starts With A', 'GetStartsWithAFilter');
		//ewrpt_UnregisterFilter($this-><Field>, 'StartsWithA');

	}

	// Page Filter Validated event
	function Page_FilterValidated() {

		// Example:
		//global $MyTable;
		//$MyTable->MyField1->SearchValue = "your search criteria"; // Search value

	}

	// Chart Rendering event
	function Chart_Rendering(&$chart) {

		// var_dump($chart);
	}

	// Chart Rendered event
	function Chart_Rendered($chart, &$chartxml) {

		// Example:	
		//$doc = $chart->XmlDoc; // Get the DOMDocument object
		// Enter your code to manipulate the DOMDocument object here
		//$chartxml = $doc->saveXML(); // Output the XML

	}

	// Email Sending event
	function Email_Sending(&$Email, &$Args) {

		//var_dump($Email); var_dump($Args); exit();
		return TRUE;
	}
}
?>
<?php ewrpt_Header(FALSE) ?>
<?php

// Create page object
$customersDeal_rpt = new crcustomersDeal_rpt();
$Page =& $customersDeal_rpt;

// Page init
$customersDeal_rpt->Page_Init();

// Page main
$customersDeal_rpt->Page_Main();
?>
<?php include_once "phprptinc/header.php"; ?>
<?php if ($customersDeal->Export == "" || $customersDeal->Export == "print" || $customersDeal->Export == "email") { ?>
<script type="text/javascript">

// Create page object
var customersDeal_rpt = new ewrpt_Page("customersDeal_rpt");

// page properties
customersDeal_rpt.PageID = "rpt"; // page ID
customersDeal_rpt.FormID = "fcustomersDealrptfilter"; // form ID
var EWRPT_PAGE_ID = customersDeal_rpt.PageID;

// extend page with Chart_Rendering function
customersDeal_rpt.Chart_Rendering =  
 function(chart, chartid) { // DO NOT CHANGE THIS LINE!

 	//alert(chartid);
 }

// extend page with Chart_Rendered function
customersDeal_rpt.Chart_Rendered =  
 function(chart, chartid) { // DO NOT CHANGE THIS LINE!

 	//alert(chartid);
 }
</script>
<?php } ?>
<?php if ($customersDeal->Export == "") { ?>
<script language="JavaScript" type="text/javascript">
<!--

// Write your client script here, no need to add script tags.
//-->

</script>
<?php } ?>
<?php if ($customersDeal->Export == "" || $customersDeal->Export == "print" || $customersDeal->Export == "email") { ?>
<script src="<?php echo EWRPT_FUSIONCHARTS_FREE_JSCLASS_FILE; ?>" type="text/javascript"></script>
<?php } ?>
<?php if ($customersDeal->Export == "") { ?>
<div id="ewrpt_PopupFilter"><div class="bd"></div></div>
<script src="phprptjs/ewrptpop.js" type="text/javascript"></script>
<script type="text/javascript">

// popup fields
</script>
<?php } ?>
<?php if ($customersDeal->Export == "" || $customersDeal->Export == "print" || $customersDeal->Export == "email") { ?>
<!-- Table Container (Begin) -->
<table id="ewContainer" cellspacing="0" cellpadding="0" border="0">
<!-- Top Container (Begin) -->
<tr><td colspan="3"><div id="ewTop" class="phpreportmaker">
<!-- top slot -->
<a name="top"></a>
<?php } ?>
<p class="phpreportmaker ewTitle"><?php echo $customersDeal->TableCaption() ?>
&nbsp;&nbsp;<?php $customersDeal_rpt->ExportOptions->Render("body"); ?></p>
<?php $customersDeal_rpt->ShowPageHeader(); ?>
<?php $customersDeal_rpt->ShowMessage(); ?>
<br><br>
<?php if ($customersDeal->Export == "" || $customersDeal->Export == "print" || $customersDeal->Export == "email") { ?>
</div></td></tr>
<!-- Top Container (End) -->
<tr>
	<!-- Left Container (Begin) -->
	<td style="vertical-align: top;"><div id="ewLeft" class="phpreportmaker">
	<!-- Left slot -->
	</div></td>
	<!-- Left Container (End) -->
	<!-- Center Container - Report (Begin) -->
	<td style="vertical-align: top;" class="ewPadding"><div id="ewCenter" class="phpreportmaker">
	<!-- center slot -->
<?php } ?>
<!-- summary report starts -->
<div id="report_summary">
<table class="ewGrid" cellspacing="0"><tr>
	<td class="ewGridContent">
<!-- Report Grid (Begin) -->
<div class="ewGridMiddlePanel">
<table class="<?php echo $customersDeal_rpt->ReportTableClass ?>" cellspacing="0">
<?php

// Set the last group to display if not export all
if ($customersDeal->ExportAll && $customersDeal->Export <> "") {
	$customersDeal_rpt->StopGrp = $customersDeal_rpt->TotalGrps;
} else {
	$customersDeal_rpt->StopGrp = $customersDeal_rpt->StartGrp + $customersDeal_rpt->DisplayGrps - 1;
}

// Stop group <= total number of groups
if (intval($customersDeal_rpt->StopGrp) > intval($customersDeal_rpt->TotalGrps))
	$customersDeal_rpt->StopGrp = $customersDeal_rpt->TotalGrps;
$customersDeal_rpt->RecCount = 0;

// Get first row
if ($customersDeal_rpt->TotalGrps > 0) {
	$customersDeal_rpt->GetRow(1);
	$customersDeal_rpt->GrpCount = 1;
}
while (($rs && !$rs->EOF && $customersDeal_rpt->GrpCount <= $customersDeal_rpt->DisplayGrps) || $customersDeal_rpt->ShowFirstHeader) {

	// Show header
	if ($customersDeal_rpt->ShowFirstHeader) {
?>
	<thead>
	<tr>
<td class="ewTableHeader">
<?php if ($customersDeal->Export <> "") { ?>
<?php echo $customersDeal->Id->FldCaption() ?>
<?php } else { ?>
	<table cellspacing="0" class="ewTableHeaderBtn"><tr>
<?php if ($customersDeal->SortUrl($customersDeal->Id) == "") { ?>
		<td style="vertical-align: bottom;"><?php echo $customersDeal->Id->FldCaption() ?></td>
<?php } else { ?>
		<td class="ewPointer" onmousedown="ewrpt_Sort(event,'<?php echo $customersDeal->SortUrl($customersDeal->Id) ?>',0);"><?php echo $customersDeal->Id->FldCaption() ?></td><td style="width: 10px;">
		<?php if ($customersDeal->Id->getSort() == "ASC") { ?><img src="phprptimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($customersDeal->Id->getSort() == "DESC") { ?><img src="phprptimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td>
<?php } ?>
	</tr></table>
<?php } ?>
</td>
<td class="ewTableHeader">
<?php if ($customersDeal->Export <> "") { ?>
<?php echo $customersDeal->Transaction_Status->FldCaption() ?>
<?php } else { ?>
	<table cellspacing="0" class="ewTableHeaderBtn"><tr>
<?php if ($customersDeal->SortUrl($customersDeal->Transaction_Status) == "") { ?>
		<td style="vertical-align: bottom;"><?php echo $customersDeal->Transaction_Status->FldCaption() ?></td>
<?php } else { ?>
		<td class="ewPointer" onmousedown="ewrpt_Sort(event,'<?php echo $customersDeal->SortUrl($customersDeal->Transaction_Status) ?>',0);"><?php echo $customersDeal->Transaction_Status->FldCaption() ?></td><td style="width: 10px;">
		<?php if ($customersDeal->Transaction_Status->getSort() == "ASC") { ?><img src="phprptimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($customersDeal->Transaction_Status->getSort() == "DESC") { ?><img src="phprptimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td>
<?php } ?>
	</tr></table>
<?php } ?>
</td>
<td class="ewTableHeader">
<?php if ($customersDeal->Export <> "") { ?>
<?php echo $customersDeal->Agrement_Status->FldCaption() ?>
<?php } else { ?>
	<table cellspacing="0" class="ewTableHeaderBtn"><tr>
<?php if ($customersDeal->SortUrl($customersDeal->Agrement_Status) == "") { ?>
		<td style="vertical-align: bottom;"><?php echo $customersDeal->Agrement_Status->FldCaption() ?></td>
<?php } else { ?>
		<td class="ewPointer" onmousedown="ewrpt_Sort(event,'<?php echo $customersDeal->SortUrl($customersDeal->Agrement_Status) ?>',0);"><?php echo $customersDeal->Agrement_Status->FldCaption() ?></td><td style="width: 10px;">
		<?php if ($customersDeal->Agrement_Status->getSort() == "ASC") { ?><img src="phprptimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($customersDeal->Agrement_Status->getSort() == "DESC") { ?><img src="phprptimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td>
<?php } ?>
	</tr></table>
<?php } ?>
</td>
<td class="ewTableHeader">
<?php if ($customersDeal->Export <> "") { ?>
<?php echo $customersDeal->DealType_cd->FldCaption() ?>
<?php } else { ?>
	<table cellspacing="0" class="ewTableHeaderBtn"><tr>
<?php if ($customersDeal->SortUrl($customersDeal->DealType_cd) == "") { ?>
		<td style="vertical-align: bottom;"><?php echo $customersDeal->DealType_cd->FldCaption() ?></td>
<?php } else { ?>
		<td class="ewPointer" onmousedown="ewrpt_Sort(event,'<?php echo $customersDeal->SortUrl($customersDeal->DealType_cd) ?>',0);"><?php echo $customersDeal->DealType_cd->FldCaption() ?></td><td style="width: 10px;">
		<?php if ($customersDeal->DealType_cd->getSort() == "ASC") { ?><img src="phprptimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($customersDeal->DealType_cd->getSort() == "DESC") { ?><img src="phprptimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td>
<?php } ?>
	</tr></table>
<?php } ?>
</td>
<td class="ewTableHeader">
<?php if ($customersDeal->Export <> "") { ?>
<?php echo $customersDeal->NotTakenUpReason_cd->FldCaption() ?>
<?php } else { ?>
	<table cellspacing="0" class="ewTableHeaderBtn"><tr>
<?php if ($customersDeal->SortUrl($customersDeal->NotTakenUpReason_cd) == "") { ?>
		<td style="vertical-align: bottom;"><?php echo $customersDeal->NotTakenUpReason_cd->FldCaption() ?></td>
<?php } else { ?>
		<td class="ewPointer" onmousedown="ewrpt_Sort(event,'<?php echo $customersDeal->SortUrl($customersDeal->NotTakenUpReason_cd) ?>',0);"><?php echo $customersDeal->NotTakenUpReason_cd->FldCaption() ?></td><td style="width: 10px;">
		<?php if ($customersDeal->NotTakenUpReason_cd->getSort() == "ASC") { ?><img src="phprptimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($customersDeal->NotTakenUpReason_cd->getSort() == "DESC") { ?><img src="phprptimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td>
<?php } ?>
	</tr></table>
<?php } ?>
</td>
<td class="ewTableHeader">
<?php if ($customersDeal->Export <> "") { ?>
<?php echo $customersDeal->DateCreated->FldCaption() ?>
<?php } else { ?>
	<table cellspacing="0" class="ewTableHeaderBtn"><tr>
<?php if ($customersDeal->SortUrl($customersDeal->DateCreated) == "") { ?>
		<td style="vertical-align: bottom;"><?php echo $customersDeal->DateCreated->FldCaption() ?></td>
<?php } else { ?>
		<td class="ewPointer" onmousedown="ewrpt_Sort(event,'<?php echo $customersDeal->SortUrl($customersDeal->DateCreated) ?>',0);"><?php echo $customersDeal->DateCreated->FldCaption() ?></td><td style="width: 10px;">
		<?php if ($customersDeal->DateCreated->getSort() == "ASC") { ?><img src="phprptimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($customersDeal->DateCreated->getSort() == "DESC") { ?><img src="phprptimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td>
<?php } ?>
	</tr></table>
<?php } ?>
</td>
<td class="ewTableHeader">
<?php if ($customersDeal->Export <> "") { ?>
<?php echo $customersDeal->name->FldCaption() ?>
<?php } else { ?>
	<table cellspacing="0" class="ewTableHeaderBtn"><tr>
<?php if ($customersDeal->SortUrl($customersDeal->name) == "") { ?>
		<td style="vertical-align: bottom;"><?php echo $customersDeal->name->FldCaption() ?></td>
<?php } else { ?>
		<td class="ewPointer" onmousedown="ewrpt_Sort(event,'<?php echo $customersDeal->SortUrl($customersDeal->name) ?>',0);"><?php echo $customersDeal->name->FldCaption() ?></td><td style="width: 10px;">
		<?php if ($customersDeal->name->getSort() == "ASC") { ?><img src="phprptimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($customersDeal->name->getSort() == "DESC") { ?><img src="phprptimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td>
<?php } ?>
	</tr></table>
<?php } ?>
</td>
<td class="ewTableHeader">
<?php if ($customersDeal->Export <> "") { ?>
<?php echo $customersDeal->code->FldCaption() ?>
<?php } else { ?>
	<table cellspacing="0" class="ewTableHeaderBtn"><tr>
<?php if ($customersDeal->SortUrl($customersDeal->code) == "") { ?>
		<td style="vertical-align: bottom;"><?php echo $customersDeal->code->FldCaption() ?></td>
<?php } else { ?>
		<td class="ewPointer" onmousedown="ewrpt_Sort(event,'<?php echo $customersDeal->SortUrl($customersDeal->code) ?>',0);"><?php echo $customersDeal->code->FldCaption() ?></td><td style="width: 10px;">
		<?php if ($customersDeal->code->getSort() == "ASC") { ?><img src="phprptimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($customersDeal->code->getSort() == "DESC") { ?><img src="phprptimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td>
<?php } ?>
	</tr></table>
<?php } ?>
</td>
<td class="ewTableHeader">
<?php if ($customersDeal->Export <> "") { ?>
<?php echo $customersDeal->Agent->FldCaption() ?>
<?php } else { ?>
	<table cellspacing="0" class="ewTableHeaderBtn"><tr>
<?php if ($customersDeal->SortUrl($customersDeal->Agent) == "") { ?>
		<td style="vertical-align: bottom;"><?php echo $customersDeal->Agent->FldCaption() ?></td>
<?php } else { ?>
		<td class="ewPointer" onmousedown="ewrpt_Sort(event,'<?php echo $customersDeal->SortUrl($customersDeal->Agent) ?>',0);"><?php echo $customersDeal->Agent->FldCaption() ?></td><td style="width: 10px;">
		<?php if ($customersDeal->Agent->getSort() == "ASC") { ?><img src="phprptimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($customersDeal->Agent->getSort() == "DESC") { ?><img src="phprptimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td>
<?php } ?>
	</tr></table>
<?php } ?>
</td>
<td class="ewTableHeader">
<?php if ($customersDeal->Export <> "") { ?>
<?php echo $customersDeal->Client->FldCaption() ?>
<?php } else { ?>
	<table cellspacing="0" class="ewTableHeaderBtn"><tr>
<?php if ($customersDeal->SortUrl($customersDeal->Client) == "") { ?>
		<td style="vertical-align: bottom;"><?php echo $customersDeal->Client->FldCaption() ?></td>
<?php } else { ?>
		<td class="ewPointer" onmousedown="ewrpt_Sort(event,'<?php echo $customersDeal->SortUrl($customersDeal->Client) ?>',0);"><?php echo $customersDeal->Client->FldCaption() ?></td><td style="width: 10px;">
		<?php if ($customersDeal->Client->getSort() == "ASC") { ?><img src="phprptimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($customersDeal->Client->getSort() == "DESC") { ?><img src="phprptimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td>
<?php } ?>
	</tr></table>
<?php } ?>
</td>
<td class="ewTableHeader">
<?php if ($customersDeal->Export <> "") { ?>
<?php echo $customersDeal->IdentificationNumber->FldCaption() ?>
<?php } else { ?>
	<table cellspacing="0" class="ewTableHeaderBtn"><tr>
<?php if ($customersDeal->SortUrl($customersDeal->IdentificationNumber) == "") { ?>
		<td style="vertical-align: bottom;"><?php echo $customersDeal->IdentificationNumber->FldCaption() ?></td>
<?php } else { ?>
		<td class="ewPointer" onmousedown="ewrpt_Sort(event,'<?php echo $customersDeal->SortUrl($customersDeal->IdentificationNumber) ?>',0);"><?php echo $customersDeal->IdentificationNumber->FldCaption() ?></td><td style="width: 10px;">
		<?php if ($customersDeal->IdentificationNumber->getSort() == "ASC") { ?><img src="phprptimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($customersDeal->IdentificationNumber->getSort() == "DESC") { ?><img src="phprptimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td>
<?php } ?>
	</tr></table>
<?php } ?>
</td>
<td class="ewTableHeader">
<?php if ($customersDeal->Export <> "") { ?>
<?php echo $customersDeal->Product_Name->FldCaption() ?>
<?php } else { ?>
	<table cellspacing="0" class="ewTableHeaderBtn"><tr>
<?php if ($customersDeal->SortUrl($customersDeal->Product_Name) == "") { ?>
		<td style="vertical-align: bottom;"><?php echo $customersDeal->Product_Name->FldCaption() ?></td>
<?php } else { ?>
		<td class="ewPointer" onmousedown="ewrpt_Sort(event,'<?php echo $customersDeal->SortUrl($customersDeal->Product_Name) ?>',0);"><?php echo $customersDeal->Product_Name->FldCaption() ?></td><td style="width: 10px;">
		<?php if ($customersDeal->Product_Name->getSort() == "ASC") { ?><img src="phprptimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($customersDeal->Product_Name->getSort() == "DESC") { ?><img src="phprptimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td>
<?php } ?>
	</tr></table>
<?php } ?>
</td>
<td class="ewTableHeader">
<?php if ($customersDeal->Export <> "") { ?>
<?php echo $customersDeal->Product_Cost->FldCaption() ?>
<?php } else { ?>
	<table cellspacing="0" class="ewTableHeaderBtn"><tr>
<?php if ($customersDeal->SortUrl($customersDeal->Product_Cost) == "") { ?>
		<td style="vertical-align: bottom;"><?php echo $customersDeal->Product_Cost->FldCaption() ?></td>
<?php } else { ?>
		<td class="ewPointer" onmousedown="ewrpt_Sort(event,'<?php echo $customersDeal->SortUrl($customersDeal->Product_Cost) ?>',0);"><?php echo $customersDeal->Product_Cost->FldCaption() ?></td><td style="width: 10px;">
		<?php if ($customersDeal->Product_Cost->getSort() == "ASC") { ?><img src="phprptimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($customersDeal->Product_Cost->getSort() == "DESC") { ?><img src="phprptimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td>
<?php } ?>
	</tr></table>
<?php } ?>
</td>
<td class="ewTableHeader">
<?php if ($customersDeal->Export <> "") { ?>
<?php echo $customersDeal->Vehicle->FldCaption() ?>
<?php } else { ?>
	<table cellspacing="0" class="ewTableHeaderBtn"><tr>
<?php if ($customersDeal->SortUrl($customersDeal->Vehicle) == "") { ?>
		<td style="vertical-align: bottom;"><?php echo $customersDeal->Vehicle->FldCaption() ?></td>
<?php } else { ?>
		<td class="ewPointer" onmousedown="ewrpt_Sort(event,'<?php echo $customersDeal->SortUrl($customersDeal->Vehicle) ?>',0);"><?php echo $customersDeal->Vehicle->FldCaption() ?></td><td style="width: 10px;">
		<?php if ($customersDeal->Vehicle->getSort() == "ASC") { ?><img src="phprptimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($customersDeal->Vehicle->getSort() == "DESC") { ?><img src="phprptimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td>
<?php } ?>
	</tr></table>
<?php } ?>
</td>
<td class="ewTableHeader">
<?php if ($customersDeal->Export <> "") { ?>
<?php echo $customersDeal->Vehicle_Cost->FldCaption() ?>
<?php } else { ?>
	<table cellspacing="0" class="ewTableHeaderBtn"><tr>
<?php if ($customersDeal->SortUrl($customersDeal->Vehicle_Cost) == "") { ?>
		<td style="vertical-align: bottom;"><?php echo $customersDeal->Vehicle_Cost->FldCaption() ?></td>
<?php } else { ?>
		<td class="ewPointer" onmousedown="ewrpt_Sort(event,'<?php echo $customersDeal->SortUrl($customersDeal->Vehicle_Cost) ?>',0);"><?php echo $customersDeal->Vehicle_Cost->FldCaption() ?></td><td style="width: 10px;">
		<?php if ($customersDeal->Vehicle_Cost->getSort() == "ASC") { ?><img src="phprptimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($customersDeal->Vehicle_Cost->getSort() == "DESC") { ?><img src="phprptimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td>
<?php } ?>
	</tr></table>
<?php } ?>
</td>
	</tr>
	</thead>
	<tbody>
<?php
		$customersDeal_rpt->ShowFirstHeader = FALSE;
	}
	$customersDeal_rpt->RecCount++;

		// Render detail row
		$customersDeal->ResetCSS();
		$customersDeal->RowType = EWRPT_ROWTYPE_DETAIL;
		$customersDeal_rpt->RenderRow();
?>
	<tr<?php echo $customersDeal->RowAttributes(); ?>>
		<td<?php echo $customersDeal->Id->CellAttributes() ?>>
<span<?php echo $customersDeal->Id->ViewAttributes(); ?>><?php echo $customersDeal->Id->ListViewValue(); ?></span></td>
		<td<?php echo $customersDeal->Transaction_Status->CellAttributes() ?>>
<span<?php echo $customersDeal->Transaction_Status->ViewAttributes(); ?>><?php echo $customersDeal->Transaction_Status->ListViewValue(); ?></span></td>
		<td<?php echo $customersDeal->Agrement_Status->CellAttributes() ?>>
<span<?php echo $customersDeal->Agrement_Status->ViewAttributes(); ?>><?php echo $customersDeal->Agrement_Status->ListViewValue(); ?></span></td>
		<td<?php echo $customersDeal->DealType_cd->CellAttributes() ?>>
<span<?php echo $customersDeal->DealType_cd->ViewAttributes(); ?>><?php echo $customersDeal->DealType_cd->ListViewValue(); ?></span></td>
		<td<?php echo $customersDeal->NotTakenUpReason_cd->CellAttributes() ?>>
<span<?php echo $customersDeal->NotTakenUpReason_cd->ViewAttributes(); ?>><?php echo $customersDeal->NotTakenUpReason_cd->ListViewValue(); ?></span></td>
		<td<?php echo $customersDeal->DateCreated->CellAttributes() ?>>
<span<?php echo $customersDeal->DateCreated->ViewAttributes(); ?>><?php echo $customersDeal->DateCreated->ListViewValue(); ?></span></td>
		<td<?php echo $customersDeal->name->CellAttributes() ?>>
<span<?php echo $customersDeal->name->ViewAttributes(); ?>><?php echo $customersDeal->name->ListViewValue(); ?></span></td>
		<td<?php echo $customersDeal->code->CellAttributes() ?>>
<span<?php echo $customersDeal->code->ViewAttributes(); ?>><?php echo $customersDeal->code->ListViewValue(); ?></span></td>
		<td<?php echo $customersDeal->Agent->CellAttributes() ?>>
<span<?php echo $customersDeal->Agent->ViewAttributes(); ?>><?php echo $customersDeal->Agent->ListViewValue(); ?></span></td>
		<td<?php echo $customersDeal->Client->CellAttributes() ?>>
<span<?php echo $customersDeal->Client->ViewAttributes(); ?>><?php echo $customersDeal->Client->ListViewValue(); ?></span></td>
		<td<?php echo $customersDeal->IdentificationNumber->CellAttributes() ?>>
<span<?php echo $customersDeal->IdentificationNumber->ViewAttributes(); ?>><?php echo $customersDeal->IdentificationNumber->ListViewValue(); ?></span></td>
		<td<?php echo $customersDeal->Product_Name->CellAttributes() ?>>
<span<?php echo $customersDeal->Product_Name->ViewAttributes(); ?>><?php echo $customersDeal->Product_Name->ListViewValue(); ?></span></td>
		<td<?php echo $customersDeal->Product_Cost->CellAttributes() ?>>
<span<?php echo $customersDeal->Product_Cost->ViewAttributes(); ?>><?php echo $customersDeal->Product_Cost->ListViewValue(); ?></span></td>
		<td<?php echo $customersDeal->Vehicle->CellAttributes() ?>>
<span<?php echo $customersDeal->Vehicle->ViewAttributes(); ?>><?php echo $customersDeal->Vehicle->ListViewValue(); ?></span></td>
		<td<?php echo $customersDeal->Vehicle_Cost->CellAttributes() ?>>
<span<?php echo $customersDeal->Vehicle_Cost->ViewAttributes(); ?>><?php echo $customersDeal->Vehicle_Cost->ListViewValue(); ?></span></td>
	</tr>
<?php

		// Accumulate page summary
		$customersDeal_rpt->AccumulateSummary();

		// Get next record
		$customersDeal_rpt->GetRow(2);
	$customersDeal_rpt->GrpCount++;
} // End while
?>
	</tbody>
	<tfoot>
	</tfoot>
</table>
</div>
<?php if ($customersDeal->Export == "") { ?>
<div class="ewGridLowerPanel">
<form action="<?php echo ewrpt_CurrentPage() ?>" name="ewpagerform" id="ewpagerform" class="ewForm">
<table border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td style="white-space: nowrap;">
<?php if (!isset($Pager)) $Pager = new crPrevNextPager($customersDeal_rpt->StartGrp, $customersDeal_rpt->DisplayGrps, $customersDeal_rpt->TotalGrps) ?>
<?php if ($Pager->RecordCount > 0) { ?>
	<table border="0" cellspacing="0" cellpadding="0"><tr><td><span class="phpreportmaker"><?php echo $ReportLanguage->Phrase("Page") ?>&nbsp;</span></td>
<!--first page button-->
	<?php if ($Pager->FirstButton->Enabled) { ?>
	<td><a href="<?php echo ewrpt_CurrentPage() ?>?start=<?php echo $Pager->FirstButton->Start ?>"><img src="phprptimages/first.gif" alt="<?php echo $ReportLanguage->Phrase("PagerFirst") ?>" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="phprptimages/firstdisab.gif" alt="<?php echo $ReportLanguage->Phrase("PagerFirst") ?>" width="16" height="16" border="0"></td>
	<?php } ?>
<!--previous page button-->
	<?php if ($Pager->PrevButton->Enabled) { ?>
	<td><a href="<?php echo ewrpt_CurrentPage() ?>?start=<?php echo $Pager->PrevButton->Start ?>"><img src="phprptimages/prev.gif" alt="<?php echo $ReportLanguage->Phrase("PagerPrevious") ?>" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="phprptimages/prevdisab.gif" alt="<?php echo $ReportLanguage->Phrase("PagerPrevious") ?>" width="16" height="16" border="0"></td>
	<?php } ?>
<!--current page number-->
	<td><input type="text" name="pageno" id="pageno" value="<?php echo $Pager->CurrentPage ?>" size="4"></td>
<!--next page button-->
	<?php if ($Pager->NextButton->Enabled) { ?>
	<td><a href="<?php echo ewrpt_CurrentPage() ?>?start=<?php echo $Pager->NextButton->Start ?>"><img src="phprptimages/next.gif" alt="<?php echo $ReportLanguage->Phrase("PagerNext") ?>" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="phprptimages/nextdisab.gif" alt="<?php echo $ReportLanguage->Phrase("PagerNext") ?>" width="16" height="16" border="0"></td>
	<?php } ?>
<!--last page button-->
	<?php if ($Pager->LastButton->Enabled) { ?>
	<td><a href="<?php echo ewrpt_CurrentPage() ?>?start=<?php echo $Pager->LastButton->Start ?>"><img src="phprptimages/last.gif" alt="<?php echo $ReportLanguage->Phrase("PagerLast") ?>" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="phprptimages/lastdisab.gif" alt="<?php echo $ReportLanguage->Phrase("PagerLast") ?>" width="16" height="16" border="0"></td>
	<?php } ?>
	<td><span class="phpreportmaker">&nbsp;<?php echo $ReportLanguage->Phrase("of") ?> <?php echo $Pager->PageCount ?></span></td>
	</tr></table>
	</td>	
	<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
	<td>
	<span class="phpreportmaker"><?php echo $ReportLanguage->Phrase("Record") ?> <?php echo $Pager->FromIndex ?> <?php echo $ReportLanguage->Phrase("To") ?> <?php echo $Pager->ToIndex ?> <?php echo $ReportLanguage->Phrase("Of") ?> <?php echo $Pager->RecordCount ?></span>
<?php } else { ?>
	<?php if ($customersDeal_rpt->Filter == "0=101") { ?>
	<span class="phpreportmaker"><?php echo $ReportLanguage->Phrase("EnterSearchCriteria") ?></span>
	<?php } else { ?>
	<span class="phpreportmaker"><?php echo $ReportLanguage->Phrase("NoRecord") ?></span>
	<?php } ?>
<?php } ?>
		</td>
<?php if ($customersDeal_rpt->TotalGrps > 0) { ?>
		<td style="white-space: nowrap;">&nbsp;&nbsp;&nbsp;&nbsp;</td>
		<td align="right" style="vertical-align: top; white-space: nowrap;"><span class="phpreportmaker"><?php echo $ReportLanguage->Phrase("RecordsPerPage"); ?>&nbsp;
<select name="<?php echo EWRPT_TABLE_GROUP_PER_PAGE; ?>" onchange="this.form.submit();">
<option value="1"<?php if ($customersDeal_rpt->DisplayGrps == 1) echo " selected=\"selected\"" ?>>1</option>
<option value="2"<?php if ($customersDeal_rpt->DisplayGrps == 2) echo " selected=\"selected\"" ?>>2</option>
<option value="3"<?php if ($customersDeal_rpt->DisplayGrps == 3) echo " selected=\"selected\"" ?>>3</option>
<option value="4"<?php if ($customersDeal_rpt->DisplayGrps == 4) echo " selected=\"selected\"" ?>>4</option>
<option value="5"<?php if ($customersDeal_rpt->DisplayGrps == 5) echo " selected=\"selected\"" ?>>5</option>
<option value="10"<?php if ($customersDeal_rpt->DisplayGrps == 10) echo " selected=\"selected\"" ?>>10</option>
<option value="20"<?php if ($customersDeal_rpt->DisplayGrps == 20) echo " selected=\"selected\"" ?>>20</option>
<option value="50"<?php if ($customersDeal_rpt->DisplayGrps == 50) echo " selected=\"selected\"" ?>>50</option>
<option value="ALL"<?php if ($customersDeal->getGroupPerPage() == -1) echo " selected=\"selected\"" ?>><?php echo $ReportLanguage->Phrase("AllRecords") ?></option>
</select>
		</span></td>
<?php } ?>
	</tr>
</table>
</form>
</div>
<?php } ?>
</td></tr></table>
</div>
<!-- Summary Report Ends -->
<?php if ($customersDeal->Export == "" || $customersDeal->Export == "print" || $customersDeal->Export == "email") { ?>
	</div><br></td>
	<!-- Center Container - Report (End) -->
	<!-- Right Container (Begin) -->
	<td style="vertical-align: top;"><div id="ewRight" class="phpreportmaker">
	<!-- Right slot -->
	</div></td>
	<!-- Right Container (End) -->
</tr>
<!-- Bottom Container (Begin) -->
<tr><td colspan="3"><div id="ewBottom" class="phpreportmaker">
	<!-- Bottom slot -->
	</div><br></td></tr>
<!-- Bottom Container (End) -->
</table>
<!-- Table Container (End) -->
<?php } ?>
<?php $customersDeal_rpt->ShowPageFooter(); ?>
<?php if (EWRPT_DEBUG_ENABLED) echo ewrpt_DebugMsg(); ?>
<?php

// Close recordsets
if ($rsgrp) $rsgrp->Close();
if ($rs) $rs->Close();
?>
<?php if ($customersDeal->Export == "") { ?>
<script language="JavaScript" type="text/javascript">
<!--

// Write your table-specific startup script here
// document.write("page loaded");
//-->

</script>
<?php } ?>
<?php include_once "phprptinc/footer.php"; ?>
<?php
$customersDeal_rpt->Page_Terminate();
?>
<?php

//
// Page class
//
class crcustomersDeal_rpt {

	// Page ID
	var $PageID = 'rpt';

	// Table name
	var $TableName = 'customersDeal';

	// Page object name
	var $PageObjName = 'customersDeal_rpt';

	// Page name
	function PageName() {
		return ewrpt_CurrentPage();
	}

	// Page URL
	function PageUrl() {
		$PageUrl = ewrpt_CurrentPage() . "?";
		global $customersDeal;
		if ($customersDeal->UseTokenInUrl) $PageUrl .= "t=" . $customersDeal->TableVar . "&"; // Add page token
		return $PageUrl;
	}

	// Export URLs
	var $ExportPrintUrl;
	var $ExportExcelUrl;
	var $ExportWordUrl;
	var $ExportPdfUrl;
	var $ReportTableClass;

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
	var $PageHeader;
	var $PageFooter;

	// Show Page Header
	function ShowPageHeader() {
		$sHeader = $this->PageHeader;
		$this->Page_DataRendering($sHeader);
		if ($sHeader <> "") { // Header exists, display
			echo "<p><span class=\"phpreportmaker\">" . $sHeader . "</span></p>";
		}
	}

	// Show Page Footer
	function ShowPageFooter() {
		$sFooter = $this->PageFooter;
		$this->Page_DataRendered($sFooter);
		if ($sFooter <> "") { // Fotoer exists, display
			echo "<p><span class=\"phpreportmaker\">" . $sFooter . "</span></p>";
		}
	}

	// Validate page request
	function IsPageRequest() {
		global $customersDeal;
		if ($customersDeal->UseTokenInUrl) {
			if (ewrpt_IsHttpPost())
				return ($customersDeal->TableVar == @$_POST("t"));
			if (@$_GET["t"] <> "")
				return ($customersDeal->TableVar == @$_GET["t"]);
		} else {
			return TRUE;
		}
	}

	//
	// Page class constructor
	//
	function crcustomersDeal_rpt() {
		global $conn, $ReportLanguage;

		// Language object
		$ReportLanguage = new crLanguage();

		// Table object (customersDeal)
		$GLOBALS["customersDeal"] = new crcustomersDeal();
		$GLOBALS["Table"] =& $GLOBALS["customersDeal"];

		// Initialize URLs
		$this->ExportPrintUrl = $this->PageUrl() . "export=print";
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel";
		$this->ExportWordUrl = $this->PageUrl() . "export=word";
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf";

		// Page ID
		if (!defined("EWRPT_PAGE_ID"))
			define("EWRPT_PAGE_ID", 'rpt', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EWRPT_TABLE_NAME"))
			define("EWRPT_TABLE_NAME", 'customersDeal', TRUE);

		// Start timer
		$GLOBALS["gsTimer"] = new crTimer();

		// Open connection
		$conn = ewrpt_Connect();

		// Export options
		$this->ExportOptions = new crListOptions();
		$this->ExportOptions->Tag = "span";
		$this->ExportOptions->Separator = "&nbsp;&nbsp;";
	}

	// 
	//  Page_Init
	//
	function Page_Init() {
		global $gsExport, $gsExportFile, $ReportLanguage, $Security;
		global $customersDeal;

		// Security
		$Security = new crAdvancedSecurity();
		if (!$Security->IsLoggedIn()) $Security->AutoLogin(); // Auto login
		if (!$Security->IsLoggedIn()) {
			$Security->SaveLastUrl();
			$this->Page_Terminate("rlogin.php");
		}

		// Get export parameters
		if (@$_GET["export"] <> "") {
			$customersDeal->Export = $_GET["export"];
		}
		$gsExport = $customersDeal->Export; // Get export parameter, used in header
		$gsExportFile = $customersDeal->TableVar; // Get export file, used in header
		if ($customersDeal->Export == "excel") {
			header('Content-Type: application/vnd.ms-excel;charset=utf-8');
			header('Content-Disposition: attachment; filename=' . $gsExportFile .'.xls');
		}
		if ($customersDeal->Export == "word") {
			header('Content-Type: application/vnd.ms-word;charset=utf-8');
			header('Content-Disposition: attachment; filename=' . $gsExportFile .'.doc');
		}

		// Setup export options
		$this->SetupExportOptions();

		// Global Page Loading event (in userfn*.php)
		Page_Loading();

		// Page Load event
		$this->Page_Load();
	}

	// Set up export options
	function SetupExportOptions() {
		global $ReportLanguage, $customersDeal;

		// Printer friendly
		$item =& $this->ExportOptions->Add("print");
		$item->Body = "<a href=\"" . $this->ExportPrintUrl . "\">" . $ReportLanguage->Phrase("PrinterFriendly") . "</a>";
		$item->Visible = TRUE;

		// Export to Excel
		$item =& $this->ExportOptions->Add("excel");
		$item->Body = "<a href=\"" . $this->ExportExcelUrl . "\">" . $ReportLanguage->Phrase("ExportToExcel") . "</a>";
		$item->Visible = TRUE;

		// Export to Word
		$item =& $this->ExportOptions->Add("word");
		$item->Body = "<a href=\"" . $this->ExportWordUrl . "\">" . $ReportLanguage->Phrase("ExportToWord") . "</a>";
		$item->Visible = TRUE;

		// Export to Pdf
		$item =& $this->ExportOptions->Add("pdf");
		$item->Body = "<a href=\"" . $this->ExportPdfUrl . "\">" . $ReportLanguage->Phrase("ExportToPDF") . "</a>";
		$item->Visible = FALSE;

		// Uncomment codes below to show export to Pdf link
//		$item->Visible = FALSE;
		// Export to Email

		$item =& $this->ExportOptions->Add("email");
		$item->Body = "<a name=\"emf_customersDeal\" id=\"emf_customersDeal\" href=\"javascript:void(0);\" onclick=\"ewrpt_EmailDialogShow({lnk:'emf_customersDeal',hdr:ewLanguage.Phrase('ExportToEmail')});\">" . $ReportLanguage->Phrase("ExportToEmail") . "</a>";
		$item->Visible = FALSE;

		// Reset filter
		$item =& $this->ExportOptions->Add("resetfilter");
		$item->Body = "<a href=\"" . ewrpt_CurrentPage() . "?cmd=reset\">" . $ReportLanguage->Phrase("ResetAllFilter") . "</a>";
		$item->Visible = FALSE;
		$this->SetupExportOptionsExt();

		// Hide options for export
		if ($customersDeal->Export <> "")
			$this->ExportOptions->HideAllOptions();

		// Set up table class
		if ($customersDeal->Export == "word" || $customersDeal->Export == "excel" || $customersDeal->Export == "pdf")
			$this->ReportTableClass = "ewTable";
		else
			$this->ReportTableClass = "ewTable ewTableSeparate";
	}

	//
	// Page_Terminate
	//
	function Page_Terminate($url = "") {
		global $conn;
		global $ReportLanguage;
		global $customersDeal;

		// Page Unload event
		$this->Page_Unload();

		// Global Page Unloaded event (in userfn*.php)
		Page_Unloaded();

		// Export to Email (use ob_file_contents for PHP)
		if ($customersDeal->Export == "email") {
			$sContent = ob_get_contents();
			$this->ExportEmail($sContent);
			ob_end_clean();

			 // Close connection
			$conn->Close();
			header("Location: " . ewrpt_CurrentPage());
			exit();
		}

		// Export to PDF (use ob_file_contents for PHP)
		if ($customersDeal->Export == "pdf") {
			$sContent = ob_get_contents();
			$this->ExportPDF($sContent);
			ob_end_clean();

			 // Close connection
			$conn->Close();
		}

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
	var $ExportOptions; // Export options

	// Paging variables
	var $RecCount = 0; // Record count
	var $StartGrp = 0; // Start group
	var $StopGrp = 0; // Stop group
	var $TotalGrps = 0; // Total groups
	var $GrpCount = 0; // Group count
	var $DisplayGrps = 50; // Groups per page
	var $GrpRange = 10;
	var $Sort = "";
	var $Filter = "";
	var $UserIDFilter = "";

	// Clear field for ext filter
	var $ClearExtFilter = "";
	var $FilterApplied;
	var $ShowFirstHeader;
	var $Cnt, $Col, $Val, $Smry, $Mn, $Mx, $GrandSmry, $GrandMn, $GrandMx;
	var $TotCount;

	//
	// Page main
	//
	function Page_Main() {
		global $customersDeal;
		global $rs;
		global $rsgrp;
		global $gsFormError;

		// Aggregate variables
		// 1st dimension = no of groups (level 0 used for grand total)
		// 2nd dimension = no of fields

		$nDtls = 16;
		$nGrps = 1;
		$this->Val =& ewrpt_InitArray($nDtls, 0);
		$this->Cnt =& ewrpt_Init2DArray($nGrps, $nDtls, 0);
		$this->Smry =& ewrpt_Init2DArray($nGrps, $nDtls, 0);
		$this->Mn =& ewrpt_Init2DArray($nGrps, $nDtls, NULL);
		$this->Mx =& ewrpt_Init2DArray($nGrps, $nDtls, NULL);
		$this->GrandSmry =& ewrpt_InitArray($nDtls, 0);
		$this->GrandMn =& ewrpt_InitArray($nDtls, NULL);
		$this->GrandMx =& ewrpt_InitArray($nDtls, NULL);

		// Set up if accumulation required
		$this->Col = array(FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE);

		// Set up groups per page dynamically
		$this->SetUpDisplayGrps();

		// Load custom filters
		$customersDeal->Filters_Load();

		// Set up popup filter
		$this->SetupPopup();

		// Extended filter
		$sExtendedFilter = "";

		// Build popup filter
		$sPopupFilter = $this->GetPopupFilter();

		//ewrpt_SetDebugMsg("popup filter: " . $sPopupFilter);
		if ($sPopupFilter <> "") {
			if ($this->Filter <> "")
				$this->Filter = "($this->Filter) AND ($sPopupFilter)";
			else
				$this->Filter = $sPopupFilter;
		}

		// No filter
		$this->FilterApplied = FALSE;

		// Requires search criteria
		if ($this->Filter == $this->UserIDFilter || $gsFormError != "")
			$this->Filter = "0=101";
		$this->ExportOptions->GetItem("resetfilter")->Visible = $this->FilterApplied;

		// Get sort
		$this->Sort = $this->GetSort();

		// Get total count
		$sSql = ewrpt_BuildReportSql($customersDeal->SqlSelect(), $customersDeal->SqlWhere(), $customersDeal->SqlGroupBy(), $customersDeal->SqlHaving(), $customersDeal->SqlOrderBy(), $this->Filter, $this->Sort);
		$this->TotalGrps = $this->GetCnt($sSql);
		if ($this->DisplayGrps <= 0) // Display all groups
			$this->DisplayGrps = $this->TotalGrps;
		$this->StartGrp = 1;

		// Show header
		$this->ShowFirstHeader = ($this->TotalGrps > 0);

		//$this->ShowFirstHeader = TRUE; // Uncomment to always show header
		// Set up start position if not export all

		if ($customersDeal->ExportAll && $customersDeal->Export <> "")
		    $this->DisplayGrps = $this->TotalGrps;
		else
			$this->SetUpStartGroup(); 

		// Hide all options if export
		if ($customersDeal->Export <> "") {
			$this->ExportOptions->HideAllOptions();
		}

		// Get current page records
		$rs = $this->GetRs($sSql, $this->StartGrp, $this->DisplayGrps);
	}

	// Accummulate summary
	function AccumulateSummary() {
		$cntx = count($this->Smry);
		for ($ix = 0; $ix < $cntx; $ix++) {
			$cnty = count($this->Smry[$ix]);
			for ($iy = 1; $iy < $cnty; $iy++) {
				$this->Cnt[$ix][$iy]++;
				if ($this->Col[$iy]) {
					$valwrk = $this->Val[$iy];
					if (is_null($valwrk) || !is_numeric($valwrk)) {

						// skip
					} else {
						$this->Smry[$ix][$iy] += $valwrk;
						if (is_null($this->Mn[$ix][$iy])) {
							$this->Mn[$ix][$iy] = $valwrk;
							$this->Mx[$ix][$iy] = $valwrk;
						} else {
							if ($this->Mn[$ix][$iy] > $valwrk) $this->Mn[$ix][$iy] = $valwrk;
							if ($this->Mx[$ix][$iy] < $valwrk) $this->Mx[$ix][$iy] = $valwrk;
						}
					}
				}
			}
		}
		$cntx = count($this->Smry);
		for ($ix = 1; $ix < $cntx; $ix++) {
			$this->Cnt[$ix][0]++;
		}
	}

	// Reset level summary
	function ResetLevelSummary($lvl) {

		// Clear summary values
		$cntx = count($this->Smry);
		for ($ix = $lvl; $ix < $cntx; $ix++) {
			$cnty = count($this->Smry[$ix]);
			for ($iy = 1; $iy < $cnty; $iy++) {
				$this->Cnt[$ix][$iy] = 0;
				if ($this->Col[$iy]) {
					$this->Smry[$ix][$iy] = 0;
					$this->Mn[$ix][$iy] = NULL;
					$this->Mx[$ix][$iy] = NULL;
				}
			}
		}
		$cntx = count($this->Smry);
		for ($ix = $lvl; $ix < $cntx; $ix++) {
			$this->Cnt[$ix][0] = 0;
		}

		// Reset record count
		$this->RecCount = 0;
	}

	// Accummulate grand summary
	function AccumulateGrandSummary() {
		$this->Cnt[0][0]++;
		$cntgs = count($this->GrandSmry);
		for ($iy = 1; $iy < $cntgs; $iy++) {
			if ($this->Col[$iy]) {
				$valwrk = $this->Val[$iy];
				if (is_null($valwrk) || !is_numeric($valwrk)) {

					// skip
				} else {
					$this->GrandSmry[$iy] += $valwrk;
					if (is_null($this->GrandMn[$iy])) {
						$this->GrandMn[$iy] = $valwrk;
						$this->GrandMx[$iy] = $valwrk;
					} else {
						if ($this->GrandMn[$iy] > $valwrk) $this->GrandMn[$iy] = $valwrk;
						if ($this->GrandMx[$iy] < $valwrk) $this->GrandMx[$iy] = $valwrk;
					}
				}
			}
		}
	}

	// Get count
	function GetCnt($sql) {
		global $conn;
		$rscnt = $conn->Execute($sql);
		$cnt = ($rscnt) ? $rscnt->RecordCount() : 0;
		if ($rscnt) $rscnt->Close();
		return $cnt;
	}

	// Get rs
	function GetRs($sql, $start, $grps) {
		global $conn;
		$wrksql = $sql;
		if ($start > 0 && $grps > -1)
			$wrksql .= " LIMIT " . ($start-1) . ", " . ($grps);
		$rswrk = $conn->Execute($wrksql);
		return $rswrk;
	}

	// Get row values
	function GetRow($opt) {
		global $rs;
		global $customersDeal;
		if (!$rs)
			return;
		if ($opt == 1) { // Get first row

	//		$rs->MoveFirst(); // NOTE: no need to move position
		} else { // Get next row
			$rs->MoveNext();
		}
		if (!$rs->EOF) {
			$customersDeal->Id->setDbValue($rs->fields('Id'));
			$customersDeal->Transaction_Status->setDbValue($rs->fields('Transaction Status'));
			$customersDeal->Agrement_Status->setDbValue($rs->fields('Agrement Status'));
			$customersDeal->DealType_cd->setDbValue($rs->fields('DealType_cd'));
			$customersDeal->NotTakenUpReason_cd->setDbValue($rs->fields('NotTakenUpReason_cd'));
			$customersDeal->DateCreated->setDbValue($rs->fields('DateCreated'));
			$customersDeal->name->setDbValue($rs->fields('name'));
			$customersDeal->code->setDbValue($rs->fields('code'));
			$customersDeal->Agent->setDbValue($rs->fields('Agent'));
			$customersDeal->Client->setDbValue($rs->fields('Client'));
			$customersDeal->IdentificationNumber->setDbValue($rs->fields('IdentificationNumber'));
			$customersDeal->Product_Name->setDbValue($rs->fields('Product Name'));
			$customersDeal->Product_Cost->setDbValue($rs->fields('Product Cost'));
			$customersDeal->Vehicle->setDbValue($rs->fields('Vehicle'));
			$customersDeal->Vehicle_Cost->setDbValue($rs->fields('Vehicle Cost'));
			$this->Val[1] = $customersDeal->Id->CurrentValue;
			$this->Val[2] = $customersDeal->Transaction_Status->CurrentValue;
			$this->Val[3] = $customersDeal->Agrement_Status->CurrentValue;
			$this->Val[4] = $customersDeal->DealType_cd->CurrentValue;
			$this->Val[5] = $customersDeal->NotTakenUpReason_cd->CurrentValue;
			$this->Val[6] = $customersDeal->DateCreated->CurrentValue;
			$this->Val[7] = $customersDeal->name->CurrentValue;
			$this->Val[8] = $customersDeal->code->CurrentValue;
			$this->Val[9] = $customersDeal->Agent->CurrentValue;
			$this->Val[10] = $customersDeal->Client->CurrentValue;
			$this->Val[11] = $customersDeal->IdentificationNumber->CurrentValue;
			$this->Val[12] = $customersDeal->Product_Name->CurrentValue;
			$this->Val[13] = $customersDeal->Product_Cost->CurrentValue;
			$this->Val[14] = $customersDeal->Vehicle->CurrentValue;
			$this->Val[15] = $customersDeal->Vehicle_Cost->CurrentValue;
		} else {
			$customersDeal->Id->setDbValue("");
			$customersDeal->Transaction_Status->setDbValue("");
			$customersDeal->Agrement_Status->setDbValue("");
			$customersDeal->DealType_cd->setDbValue("");
			$customersDeal->NotTakenUpReason_cd->setDbValue("");
			$customersDeal->DateCreated->setDbValue("");
			$customersDeal->name->setDbValue("");
			$customersDeal->code->setDbValue("");
			$customersDeal->Agent->setDbValue("");
			$customersDeal->Client->setDbValue("");
			$customersDeal->IdentificationNumber->setDbValue("");
			$customersDeal->Product_Name->setDbValue("");
			$customersDeal->Product_Cost->setDbValue("");
			$customersDeal->Vehicle->setDbValue("");
			$customersDeal->Vehicle_Cost->setDbValue("");
		}
	}

	//  Set up starting group
	function SetUpStartGroup() {
		global $customersDeal;

		// Exit if no groups
		if ($this->DisplayGrps == 0)
			return;

		// Check for a 'start' parameter
		if (@$_GET[EWRPT_TABLE_START_GROUP] != "") {
			$this->StartGrp = $_GET[EWRPT_TABLE_START_GROUP];
			$customersDeal->setStartGroup($this->StartGrp);
		} elseif (@$_GET["pageno"] != "") {
			$nPageNo = $_GET["pageno"];
			if (is_numeric($nPageNo)) {
				$this->StartGrp = ($nPageNo-1)*$this->DisplayGrps+1;
				if ($this->StartGrp <= 0) {
					$this->StartGrp = 1;
				} elseif ($this->StartGrp >= intval(($this->TotalGrps-1)/$this->DisplayGrps)*$this->DisplayGrps+1) {
					$this->StartGrp = intval(($this->TotalGrps-1)/$this->DisplayGrps)*$this->DisplayGrps+1;
				}
				$customersDeal->setStartGroup($this->StartGrp);
			} else {
				$this->StartGrp = $customersDeal->getStartGroup();
			}
		} else {
			$this->StartGrp = $customersDeal->getStartGroup();
		}

		// Check if correct start group counter
		if (!is_numeric($this->StartGrp) || $this->StartGrp == "") { // Avoid invalid start group counter
			$this->StartGrp = 1; // Reset start group counter
			$customersDeal->setStartGroup($this->StartGrp);
		} elseif (intval($this->StartGrp) > intval($this->TotalGrps)) { // Avoid starting group > total groups
			$this->StartGrp = intval(($this->TotalGrps-1)/$this->DisplayGrps) * $this->DisplayGrps + 1; // Point to last page first group
			$customersDeal->setStartGroup($this->StartGrp);
		} elseif (($this->StartGrp-1) % $this->DisplayGrps <> 0) {
			$this->StartGrp = intval(($this->StartGrp-1)/$this->DisplayGrps) * $this->DisplayGrps + 1; // Point to page boundary
			$customersDeal->setStartGroup($this->StartGrp);
		}
	}

	// Set up popup
	function SetupPopup() {
		global $conn, $ReportLanguage;
		global $customersDeal;

		// Initialize popup
		// Process post back form

		if (ewrpt_IsHttpPost()) {
			$sName = @$_POST["popup"]; // Get popup form name
			if ($sName <> "") {
				$cntValues = (is_array(@$_POST["sel_$sName"])) ? count($_POST["sel_$sName"]) : 0;
				if ($cntValues > 0) {
					$arValues = ewrpt_StripSlashes($_POST["sel_$sName"]);
					if (trim($arValues[0]) == "") // Select all
						$arValues = EWRPT_INIT_VALUE;
					$_SESSION["sel_$sName"] = $arValues;
					$_SESSION["rf_$sName"] = ewrpt_StripSlashes(@$_POST["rf_$sName"]);
					$_SESSION["rt_$sName"] = ewrpt_StripSlashes(@$_POST["rt_$sName"]);
					$this->ResetPager();
				}
			}

		// Get 'reset' command
		} elseif (@$_GET["cmd"] <> "") {
			$sCmd = $_GET["cmd"];
			if (strtolower($sCmd) == "reset") {
				$this->ResetPager();
			}
		}

		// Load selection criteria to array
	}

	// Reset pager
	function ResetPager() {

		// Reset start position (reset command)
		global $customersDeal;
		$this->StartGrp = 1;
		$customersDeal->setStartGroup($this->StartGrp);
	}

	// Set up number of groups displayed per page
	function SetUpDisplayGrps() {
		global $customersDeal;
		$sWrk = @$_GET[EWRPT_TABLE_GROUP_PER_PAGE];
		if ($sWrk <> "") {
			if (is_numeric($sWrk)) {
				$this->DisplayGrps = intval($sWrk);
			} else {
				if (strtoupper($sWrk) == "ALL") { // display all groups
					$this->DisplayGrps = -1;
				} else {
					$this->DisplayGrps = 50; // Non-numeric, load default
				}
			}
			$customersDeal->setGroupPerPage($this->DisplayGrps); // Save to session

			// Reset start position (reset command)
			$this->StartGrp = 1;
			$customersDeal->setStartGroup($this->StartGrp);
		} else {
			if ($customersDeal->getGroupPerPage() <> "") {
				$this->DisplayGrps = $customersDeal->getGroupPerPage(); // Restore from session
			} else {
				$this->DisplayGrps = 50; // Load default
			}
		}
	}

	function RenderRow() {
		global $conn, $rs, $Security;
		global $customersDeal;
		if ($customersDeal->RowTotalType == EWRPT_ROWTOTAL_GRAND) { // Grand total

			// Get total count from sql directly
			$sSql = ewrpt_BuildReportSql($customersDeal->SqlSelectCount(), $customersDeal->SqlWhere(), $customersDeal->SqlGroupBy(), $customersDeal->SqlHaving(), "", $this->Filter, "");
			$rstot = $conn->Execute($sSql);
			if ($rstot) {
				$this->TotCount = ($rstot->RecordCount()>1) ? $rstot->RecordCount() : $rstot->fields[0];
				$rstot->Close();
			} else {
				$this->TotCount = 0;
			}
		}

		// Call Row_Rendering event
		$customersDeal->Row_Rendering();

		//
		// Render view codes
		//

		if ($customersDeal->RowType == EWRPT_ROWTYPE_TOTAL) { // Summary row
		} else {

			// Id
			$customersDeal->Id->ViewValue = $customersDeal->Id->CurrentValue;
			$customersDeal->Id->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";

			// Transaction Status
			$customersDeal->Transaction_Status->ViewValue = $customersDeal->Transaction_Status->CurrentValue;
			$customersDeal->Transaction_Status->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";

			// Agrement Status
			$customersDeal->Agrement_Status->ViewValue = $customersDeal->Agrement_Status->CurrentValue;
			$customersDeal->Agrement_Status->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";

			// DealType_cd
			$customersDeal->DealType_cd->ViewValue = $customersDeal->DealType_cd->CurrentValue;
			$customersDeal->DealType_cd->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";

			// NotTakenUpReason_cd
			$customersDeal->NotTakenUpReason_cd->ViewValue = $customersDeal->NotTakenUpReason_cd->CurrentValue;
			$customersDeal->NotTakenUpReason_cd->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";

			// DateCreated
			$customersDeal->DateCreated->ViewValue = $customersDeal->DateCreated->CurrentValue;
			$customersDeal->DateCreated->ViewValue = ewrpt_FormatDateTime($customersDeal->DateCreated->ViewValue, 7);
			$customersDeal->DateCreated->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";

			// name
			$customersDeal->name->ViewValue = $customersDeal->name->CurrentValue;
			$customersDeal->name->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";

			// code
			$customersDeal->code->ViewValue = $customersDeal->code->CurrentValue;
			$customersDeal->code->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";

			// Agent
			$customersDeal->Agent->ViewValue = $customersDeal->Agent->CurrentValue;
			$customersDeal->Agent->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";

			// Client
			$customersDeal->Client->ViewValue = $customersDeal->Client->CurrentValue;
			$customersDeal->Client->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";

			// IdentificationNumber
			$customersDeal->IdentificationNumber->ViewValue = $customersDeal->IdentificationNumber->CurrentValue;
			$customersDeal->IdentificationNumber->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";

			// Product Name
			$customersDeal->Product_Name->ViewValue = $customersDeal->Product_Name->CurrentValue;
			$customersDeal->Product_Name->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";

			// Product Cost
			$customersDeal->Product_Cost->ViewValue = $customersDeal->Product_Cost->CurrentValue;
			$customersDeal->Product_Cost->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";

			// Vehicle
			$customersDeal->Vehicle->ViewValue = $customersDeal->Vehicle->CurrentValue;
			$customersDeal->Vehicle->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";

			// Vehicle Cost
			$customersDeal->Vehicle_Cost->ViewValue = $customersDeal->Vehicle_Cost->CurrentValue;
			$customersDeal->Vehicle_Cost->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";

			// Id
			$customersDeal->Id->HrefValue = "";

			// Transaction Status
			$customersDeal->Transaction_Status->HrefValue = "";

			// Agrement Status
			$customersDeal->Agrement_Status->HrefValue = "";

			// DealType_cd
			$customersDeal->DealType_cd->HrefValue = "";

			// NotTakenUpReason_cd
			$customersDeal->NotTakenUpReason_cd->HrefValue = "";

			// DateCreated
			$customersDeal->DateCreated->HrefValue = "";

			// name
			$customersDeal->name->HrefValue = "";

			// code
			$customersDeal->code->HrefValue = "";

			// Agent
			$customersDeal->Agent->HrefValue = "";

			// Client
			$customersDeal->Client->HrefValue = "";

			// IdentificationNumber
			$customersDeal->IdentificationNumber->HrefValue = "";

			// Product Name
			$customersDeal->Product_Name->HrefValue = "";

			// Product Cost
			$customersDeal->Product_Cost->HrefValue = "";

			// Vehicle
			$customersDeal->Vehicle->HrefValue = "";

			// Vehicle Cost
			$customersDeal->Vehicle_Cost->HrefValue = "";
		}

		// Call Cell_Rendered event
		if ($customersDeal->RowType == EWRPT_ROWTYPE_TOTAL) { // Summary row
		} else {

			// Id
			$CurrentValue = $customersDeal->Id->CurrentValue;
			$ViewValue =& $customersDeal->Id->ViewValue;
			$ViewAttrs =& $customersDeal->Id->ViewAttrs;
			$CellAttrs =& $customersDeal->Id->CellAttrs;
			$HrefValue =& $customersDeal->Id->HrefValue;
			$customersDeal->Cell_Rendered($customersDeal->Id, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue);

			// Transaction Status
			$CurrentValue = $customersDeal->Transaction_Status->CurrentValue;
			$ViewValue =& $customersDeal->Transaction_Status->ViewValue;
			$ViewAttrs =& $customersDeal->Transaction_Status->ViewAttrs;
			$CellAttrs =& $customersDeal->Transaction_Status->CellAttrs;
			$HrefValue =& $customersDeal->Transaction_Status->HrefValue;
			$customersDeal->Cell_Rendered($customersDeal->Transaction_Status, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue);

			// Agrement Status
			$CurrentValue = $customersDeal->Agrement_Status->CurrentValue;
			$ViewValue =& $customersDeal->Agrement_Status->ViewValue;
			$ViewAttrs =& $customersDeal->Agrement_Status->ViewAttrs;
			$CellAttrs =& $customersDeal->Agrement_Status->CellAttrs;
			$HrefValue =& $customersDeal->Agrement_Status->HrefValue;
			$customersDeal->Cell_Rendered($customersDeal->Agrement_Status, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue);

			// DealType_cd
			$CurrentValue = $customersDeal->DealType_cd->CurrentValue;
			$ViewValue =& $customersDeal->DealType_cd->ViewValue;
			$ViewAttrs =& $customersDeal->DealType_cd->ViewAttrs;
			$CellAttrs =& $customersDeal->DealType_cd->CellAttrs;
			$HrefValue =& $customersDeal->DealType_cd->HrefValue;
			$customersDeal->Cell_Rendered($customersDeal->DealType_cd, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue);

			// NotTakenUpReason_cd
			$CurrentValue = $customersDeal->NotTakenUpReason_cd->CurrentValue;
			$ViewValue =& $customersDeal->NotTakenUpReason_cd->ViewValue;
			$ViewAttrs =& $customersDeal->NotTakenUpReason_cd->ViewAttrs;
			$CellAttrs =& $customersDeal->NotTakenUpReason_cd->CellAttrs;
			$HrefValue =& $customersDeal->NotTakenUpReason_cd->HrefValue;
			$customersDeal->Cell_Rendered($customersDeal->NotTakenUpReason_cd, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue);

			// DateCreated
			$CurrentValue = $customersDeal->DateCreated->CurrentValue;
			$ViewValue =& $customersDeal->DateCreated->ViewValue;
			$ViewAttrs =& $customersDeal->DateCreated->ViewAttrs;
			$CellAttrs =& $customersDeal->DateCreated->CellAttrs;
			$HrefValue =& $customersDeal->DateCreated->HrefValue;
			$customersDeal->Cell_Rendered($customersDeal->DateCreated, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue);

			// name
			$CurrentValue = $customersDeal->name->CurrentValue;
			$ViewValue =& $customersDeal->name->ViewValue;
			$ViewAttrs =& $customersDeal->name->ViewAttrs;
			$CellAttrs =& $customersDeal->name->CellAttrs;
			$HrefValue =& $customersDeal->name->HrefValue;
			$customersDeal->Cell_Rendered($customersDeal->name, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue);

			// code
			$CurrentValue = $customersDeal->code->CurrentValue;
			$ViewValue =& $customersDeal->code->ViewValue;
			$ViewAttrs =& $customersDeal->code->ViewAttrs;
			$CellAttrs =& $customersDeal->code->CellAttrs;
			$HrefValue =& $customersDeal->code->HrefValue;
			$customersDeal->Cell_Rendered($customersDeal->code, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue);

			// Agent
			$CurrentValue = $customersDeal->Agent->CurrentValue;
			$ViewValue =& $customersDeal->Agent->ViewValue;
			$ViewAttrs =& $customersDeal->Agent->ViewAttrs;
			$CellAttrs =& $customersDeal->Agent->CellAttrs;
			$HrefValue =& $customersDeal->Agent->HrefValue;
			$customersDeal->Cell_Rendered($customersDeal->Agent, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue);

			// Client
			$CurrentValue = $customersDeal->Client->CurrentValue;
			$ViewValue =& $customersDeal->Client->ViewValue;
			$ViewAttrs =& $customersDeal->Client->ViewAttrs;
			$CellAttrs =& $customersDeal->Client->CellAttrs;
			$HrefValue =& $customersDeal->Client->HrefValue;
			$customersDeal->Cell_Rendered($customersDeal->Client, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue);

			// IdentificationNumber
			$CurrentValue = $customersDeal->IdentificationNumber->CurrentValue;
			$ViewValue =& $customersDeal->IdentificationNumber->ViewValue;
			$ViewAttrs =& $customersDeal->IdentificationNumber->ViewAttrs;
			$CellAttrs =& $customersDeal->IdentificationNumber->CellAttrs;
			$HrefValue =& $customersDeal->IdentificationNumber->HrefValue;
			$customersDeal->Cell_Rendered($customersDeal->IdentificationNumber, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue);

			// Product Name
			$CurrentValue = $customersDeal->Product_Name->CurrentValue;
			$ViewValue =& $customersDeal->Product_Name->ViewValue;
			$ViewAttrs =& $customersDeal->Product_Name->ViewAttrs;
			$CellAttrs =& $customersDeal->Product_Name->CellAttrs;
			$HrefValue =& $customersDeal->Product_Name->HrefValue;
			$customersDeal->Cell_Rendered($customersDeal->Product_Name, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue);

			// Product Cost
			$CurrentValue = $customersDeal->Product_Cost->CurrentValue;
			$ViewValue =& $customersDeal->Product_Cost->ViewValue;
			$ViewAttrs =& $customersDeal->Product_Cost->ViewAttrs;
			$CellAttrs =& $customersDeal->Product_Cost->CellAttrs;
			$HrefValue =& $customersDeal->Product_Cost->HrefValue;
			$customersDeal->Cell_Rendered($customersDeal->Product_Cost, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue);

			// Vehicle
			$CurrentValue = $customersDeal->Vehicle->CurrentValue;
			$ViewValue =& $customersDeal->Vehicle->ViewValue;
			$ViewAttrs =& $customersDeal->Vehicle->ViewAttrs;
			$CellAttrs =& $customersDeal->Vehicle->CellAttrs;
			$HrefValue =& $customersDeal->Vehicle->HrefValue;
			$customersDeal->Cell_Rendered($customersDeal->Vehicle, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue);

			// Vehicle Cost
			$CurrentValue = $customersDeal->Vehicle_Cost->CurrentValue;
			$ViewValue =& $customersDeal->Vehicle_Cost->ViewValue;
			$ViewAttrs =& $customersDeal->Vehicle_Cost->ViewAttrs;
			$CellAttrs =& $customersDeal->Vehicle_Cost->CellAttrs;
			$HrefValue =& $customersDeal->Vehicle_Cost->HrefValue;
			$customersDeal->Cell_Rendered($customersDeal->Vehicle_Cost, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue);
		}

		// Call Row_Rendered event
		$customersDeal->Row_Rendered();
	}

	function SetupExportOptionsExt() {
		global $ReportLanguage, $customersDeal;
	}

	// Return poup filter
	function GetPopupFilter() {
		global $customersDeal;
		$sWrk = "";
		return $sWrk;
	}

	//-------------------------------------------------------------------------------
	// Function GetSort
	// - Return Sort parameters based on Sort Links clicked
	// - Variables setup: Session[EWRPT_TABLE_SESSION_ORDER_BY], Session["sort_Table_Field"]
	function GetSort() {
		global $customersDeal;

		// Check for a resetsort command
		if (strlen(@$_GET["cmd"]) > 0) {
			$sCmd = @$_GET["cmd"];
			if ($sCmd == "resetsort") {
				$customersDeal->setOrderBy("");
				$customersDeal->setStartGroup(1);
				$customersDeal->Id->setSort("");
				$customersDeal->Transaction_Status->setSort("");
				$customersDeal->Agrement_Status->setSort("");
				$customersDeal->DealType_cd->setSort("");
				$customersDeal->NotTakenUpReason_cd->setSort("");
				$customersDeal->DateCreated->setSort("");
				$customersDeal->name->setSort("");
				$customersDeal->code->setSort("");
				$customersDeal->Agent->setSort("");
				$customersDeal->Client->setSort("");
				$customersDeal->IdentificationNumber->setSort("");
				$customersDeal->Product_Name->setSort("");
				$customersDeal->Product_Cost->setSort("");
				$customersDeal->Vehicle->setSort("");
				$customersDeal->Vehicle_Cost->setSort("");
			}

		// Check for an Order parameter
		} elseif (@$_GET["order"] <> "") {
			$customersDeal->CurrentOrder = ewrpt_StripSlashes(@$_GET["order"]);
			$customersDeal->CurrentOrderType = @$_GET["ordertype"];
			$sSortSql = $customersDeal->SortSql();
			$customersDeal->setOrderBy($sSortSql);
			$customersDeal->setStartGroup(1);
		}
		return $customersDeal->getOrderBy();
	}

	// PDF Export
	function ExportPDF($html) {
		echo($html);
		ewrpt_DeleteTmpImages();
		exit();
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

	// Page Data Rendering event
	function Page_DataRendering(&$header) {

		// Example:
		//$header = "your header";

	}

	// Page Data Rendered event
	function Page_DataRendered(&$footer) {

		// Example:
		//$footer = "your footer";

	}

	// Form Custom Validate event
	function Form_CustomValidate(&$CustomError) {

		// Return error message in CustomError
		return TRUE;
	}
}
?>
