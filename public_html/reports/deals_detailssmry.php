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
$deals_details = NULL;

//
// Table class for deals_details
//
class crdeals_details {
	var $TableVar = 'deals_details';
	var $TableName = 'deals_details';
	var $TableType = 'REPORT';
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
	var $deal_number;
	var $dealer;
	var $date_start;
	var $status;
	var $salesman;
	var $customer;
	var $idno;
	var $product_name;
	var $rep2Etotal_premium_2D_rep2Ecommission;
	var $Description;
	var $RegistrationNumber;
	var $Deposit;
	var $PrincipalDebt;
	var $FSPFees;
	var $ServiceAndDelivery;
	var $Vaps;
	var $HandlingFees;
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
	function crdeals_details() {
		global $ReportLanguage;

		// deal_number
		$this->deal_number = new crField('deals_details', 'deals_details', 'x_deal_number', 'deal_number', 'rep.deal_number', 3, EWRPT_DATATYPE_NUMBER, -1);
		$this->deal_number->FldDefaultErrMsg = $ReportLanguage->Phrase("IncorrectInteger");
		$this->fields['deal_number'] =& $this->deal_number;
		$this->deal_number->DateFilter = "";
		$this->deal_number->SqlSelect = "";
		$this->deal_number->SqlOrderBy = "";

		// dealer
		$this->dealer = new crField('deals_details', 'deals_details', 'x_dealer', 'dealer', 'rep.dealer', 200, EWRPT_DATATYPE_STRING, -1);
		$this->fields['dealer'] =& $this->dealer;
		$this->dealer->DateFilter = "";
		$this->dealer->SqlSelect = "";
		$this->dealer->SqlOrderBy = "";

		// date_start
		$this->date_start = new crField('deals_details', 'deals_details', 'x_date_start', 'date_start', 'rep.date_start', 135, EWRPT_DATATYPE_DATE, 7);
		$this->date_start->FldDefaultErrMsg = str_replace("%s", "-", $ReportLanguage->Phrase("IncorrectDateYMD"));
		$this->fields['date_start'] =& $this->date_start;
		$this->date_start->DateFilter = "Month";
		$this->date_start->SqlSelect = "";
		$this->date_start->SqlOrderBy = "";
		ewrpt_RegisterFilter($this->date_start, "@@LastMonth", $ReportLanguage->Phrase("LastMonth"), "ewrpt_IsLastMonth");
		ewrpt_RegisterFilter($this->date_start, "@@ThisMonth", $ReportLanguage->Phrase("ThisMonth"), "ewrpt_IsThisMonth");
		ewrpt_RegisterFilter($this->date_start, "@@NextMonth", $ReportLanguage->Phrase("NextMonth"), "ewrpt_IsNextMonth");

		// status
		$this->status = new crField('deals_details', 'deals_details', 'x_status', 'status', 'rep.status', 200, EWRPT_DATATYPE_STRING, -1);
		$this->fields['status'] =& $this->status;
		$this->status->DateFilter = "";
		$this->status->SqlSelect = "";
		$this->status->SqlOrderBy = "";

		// salesman
		$this->salesman = new crField('deals_details', 'deals_details', 'x_salesman', 'salesman', 'rep.salesman', 200, EWRPT_DATATYPE_STRING, -1);
		$this->fields['salesman'] =& $this->salesman;
		$this->salesman->DateFilter = "";
		$this->salesman->SqlSelect = "";
		$this->salesman->SqlOrderBy = "";

		// customer
		$this->customer = new crField('deals_details', 'deals_details', 'x_customer', 'customer', 'rep.customer', 200, EWRPT_DATATYPE_STRING, -1);
		$this->fields['customer'] =& $this->customer;
		$this->customer->DateFilter = "";
		$this->customer->SqlSelect = "";
		$this->customer->SqlOrderBy = "";

		// idno
		$this->idno = new crField('deals_details', 'deals_details', 'x_idno', 'idno', 'rep.idno', 200, EWRPT_DATATYPE_STRING, -1);
		$this->fields['idno'] =& $this->idno;
		$this->idno->DateFilter = "";
		$this->idno->SqlSelect = "";
		$this->idno->SqlOrderBy = "";

		// product_name
		$this->product_name = new crField('deals_details', 'deals_details', 'x_product_name', 'product_name', 'rep.product_name', 200, EWRPT_DATATYPE_STRING, -1);
		$this->fields['product_name'] =& $this->product_name;
		$this->product_name->DateFilter = "";
		$this->product_name->SqlSelect = "";
		$this->product_name->SqlOrderBy = "";

		// rep.total_premium - rep.commission
		$this->rep2Etotal_premium_2D_rep2Ecommission = new crField('deals_details', 'deals_details', 'x_rep2Etotal_premium_2D_rep2Ecommission', 'rep.total_premium - rep.commission', '`rep.total_premium - rep.commission`', 5, EWRPT_DATATYPE_NUMBER, -1);
		$this->rep2Etotal_premium_2D_rep2Ecommission->FldDefaultErrMsg = $ReportLanguage->Phrase("IncorrectFloat");
		$this->fields['rep2Etotal_premium_2D_rep2Ecommission'] =& $this->rep2Etotal_premium_2D_rep2Ecommission;
		$this->rep2Etotal_premium_2D_rep2Ecommission->DateFilter = "";
		$this->rep2Etotal_premium_2D_rep2Ecommission->SqlSelect = "";
		$this->rep2Etotal_premium_2D_rep2Ecommission->SqlOrderBy = "";

		// Description
		$this->Description = new crField('deals_details', 'deals_details', 'x_Description', 'Description', 'road_TxItems.Description', 200, EWRPT_DATATYPE_STRING, -1);
		$this->fields['Description'] =& $this->Description;
		$this->Description->DateFilter = "";
		$this->Description->SqlSelect = "";
		$this->Description->SqlOrderBy = "";

		// RegistrationNumber
		$this->RegistrationNumber = new crField('deals_details', 'deals_details', 'x_RegistrationNumber', 'RegistrationNumber', 'road_TxItems.RegistrationNumber', 200, EWRPT_DATATYPE_STRING, -1);
		$this->fields['RegistrationNumber'] =& $this->RegistrationNumber;
		$this->RegistrationNumber->DateFilter = "";
		$this->RegistrationNumber->SqlSelect = "";
		$this->RegistrationNumber->SqlOrderBy = "";

		// Deposit
		$this->Deposit = new crField('deals_details', 'deals_details', 'x_Deposit', 'Deposit', 'report_vehicle.Deposit', 4, EWRPT_DATATYPE_NUMBER, -1);
		$this->fields['Deposit'] =& $this->Deposit;
		$this->Deposit->DateFilter = "";
		$this->Deposit->SqlSelect = "";
		$this->Deposit->SqlOrderBy = "";

		// PrincipalDebt
		$this->PrincipalDebt = new crField('deals_details', 'deals_details', 'x_PrincipalDebt', 'PrincipalDebt', 'report_vehicle.PrincipalDebt', 4, EWRPT_DATATYPE_NUMBER, -1);
		$this->PrincipalDebt->FldDefaultErrMsg = $ReportLanguage->Phrase("IncorrectFloat");
		$this->fields['PrincipalDebt'] =& $this->PrincipalDebt;
		$this->PrincipalDebt->DateFilter = "";
		$this->PrincipalDebt->SqlSelect = "";
		$this->PrincipalDebt->SqlOrderBy = "";

		// FSPFees
		$this->FSPFees = new crField('deals_details', 'deals_details', 'x_FSPFees', 'FSPFees', 'report_vehicle.FSPFees', 4, EWRPT_DATATYPE_NUMBER, -1);
		$this->fields['FSPFees'] =& $this->FSPFees;
		$this->FSPFees->DateFilter = "";
		$this->FSPFees->SqlSelect = "";
		$this->FSPFees->SqlOrderBy = "";

		// ServiceAndDelivery
		$this->ServiceAndDelivery = new crField('deals_details', 'deals_details', 'x_ServiceAndDelivery', 'ServiceAndDelivery', 'report_vehicle.ServiceAndDelivery', 4, EWRPT_DATATYPE_NUMBER, -1);
		$this->fields['ServiceAndDelivery'] =& $this->ServiceAndDelivery;
		$this->ServiceAndDelivery->DateFilter = "";
		$this->ServiceAndDelivery->SqlSelect = "";
		$this->ServiceAndDelivery->SqlOrderBy = "";

		// Vaps
		$this->Vaps = new crField('deals_details', 'deals_details', 'x_Vaps', 'Vaps', 'report_vehicle.Vaps', 4, EWRPT_DATATYPE_NUMBER, -1);
		$this->fields['Vaps'] =& $this->Vaps;
		$this->Vaps->DateFilter = "";
		$this->Vaps->SqlSelect = "";
		$this->Vaps->SqlOrderBy = "";

		// HandlingFees
		$this->HandlingFees = new crField('deals_details', 'deals_details', 'x_HandlingFees', 'HandlingFees', 'report_vehicle.HandlingFees', 4, EWRPT_DATATYPE_NUMBER, -1);
		$this->HandlingFees->FldDefaultErrMsg = $ReportLanguage->Phrase("IncorrectFloat");
		$this->fields['HandlingFees'] =& $this->HandlingFees;
		$this->HandlingFees->DateFilter = "";
		$this->HandlingFees->SqlSelect = "";
		$this->HandlingFees->SqlOrderBy = "";
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
		return "report_invoice rep Inner Join report_vehicle On report_vehicle.trans_id = rep.trans_id Left Join road_TxItems On road_TxItems.holder = rep.customer_id";
	}

	function SqlSelect() { // Select
		return "SELECT rep.deal_number, rep.date_start, rep.status, rep.dealer, rep.salesman, rep.customer, rep.idno, rep.product_name, rep.total_premium - rep.commission, road_TxItems.Description, road_TxItems.RegistrationNumber, report_vehicle.Deposit, report_vehicle.PrincipalDebt, report_vehicle.FSPFees, report_vehicle.HandlingFees, report_vehicle.ServiceAndDelivery, report_vehicle.Vaps FROM " . $this->SqlFrom();
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
		return "";
	}

	// Table Level Group SQL
	function SqlFirstGroupField() {
		return "";
	}

	function SqlSelectGroup() {
		return "SELECT DISTINCT " . $this->SqlFirstGroupField() . " FROM " . $this->SqlFrom();
	}

	function SqlOrderByGroup() {
		return "";
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
$deals_details_summary = new crdeals_details_summary();
$Page =& $deals_details_summary;

// Page init
$deals_details_summary->Page_Init();

// Page main
$deals_details_summary->Page_Main();
?>
<?php include_once "phprptinc/header.php"; ?>
<?php if ($deals_details->Export == "" || $deals_details->Export == "print" || $deals_details->Export == "email") { ?>
<script type="text/javascript">

// Create page object
var deals_details_summary = new ewrpt_Page("deals_details_summary");

// page properties
deals_details_summary.PageID = "summary"; // page ID
deals_details_summary.FormID = "fdeals_detailssummaryfilter"; // form ID
var EWRPT_PAGE_ID = deals_details_summary.PageID;

// extend page with Chart_Rendering function
deals_details_summary.Chart_Rendering =  
 function(chart, chartid) { // DO NOT CHANGE THIS LINE!

 	//alert(chartid);
 }

// extend page with Chart_Rendered function
deals_details_summary.Chart_Rendered =  
 function(chart, chartid) { // DO NOT CHANGE THIS LINE!

 	//alert(chartid);
 }
</script>
<?php } ?>
<?php if ($deals_details->Export == "") { ?>
<script type="text/javascript">

// extend page with ValidateForm function
deals_details_summary.ValidateForm = function(fobj) {
	if (!this.ValidateRequired)
		return true; // ignore validation

	// Call Form Custom Validate event
	if (!this.Form_CustomValidate(fobj)) return false;
	return true;
}

// extend page with Form_CustomValidate function
deals_details_summary.Form_CustomValidate =  
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }
<?php if (EWRPT_CLIENT_VALIDATE) { ?>
deals_details_summary.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
deals_details_summary.ValidateRequired = false; // no JavaScript validation
<?php } ?>
</script>
<script language="JavaScript" type="text/javascript">
<!--

// Write your client script here, no need to add script tags.
//-->

</script>
<?php } ?>
<?php if ($deals_details->Export == "" || $deals_details->Export == "print" || $deals_details->Export == "email") { ?>
<script src="<?php echo EWRPT_FUSIONCHARTS_FREE_JSCLASS_FILE; ?>" type="text/javascript"></script>
<?php } ?>
<?php if ($deals_details->Export == "") { ?>
<div id="ewrpt_PopupFilter"><div class="bd"></div></div>
<script src="phprptjs/ewrptpop.js" type="text/javascript"></script>
<script type="text/javascript">

// popup fields
</script>
<?php } ?>
<?php if ($deals_details->Export == "" || $deals_details->Export == "print" || $deals_details->Export == "email") { ?>
<!-- Table Container (Begin) -->
<table id="ewContainer" cellspacing="0" cellpadding="0" border="0">
<!-- Top Container (Begin) -->
<tr><td colspan="3"><div id="ewTop" class="phpreportmaker">
<!-- top slot -->
<a name="top"></a>
<?php } ?>
<p class="phpreportmaker ewTitle"><?php echo $deals_details->TableCaption() ?>
&nbsp;&nbsp;<?php $deals_details_summary->ExportOptions->Render("body"); ?></p>
<?php $deals_details_summary->ShowPageHeader(); ?>
<?php $deals_details_summary->ShowMessage(); ?>
<br><br>
<?php if ($deals_details->Export == "" || $deals_details->Export == "print" || $deals_details->Export == "email") { ?>
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
<?php if ($deals_details->Export == "") { ?>
<?php
if ($deals_details->FilterPanelOption == 2 || ($deals_details->FilterPanelOption == 3 && $deals_details_summary->FilterApplied) || $deals_details_summary->Filter == "0=101") {
	$sButtonImage = "phprptimages/collapse.gif";
	$sDivDisplay = "";
} else {
	$sButtonImage = "phprptimages/expand.gif";
	$sDivDisplay = " style=\"display: none;\"";
}
?>
<a href="javascript:ewrpt_ToggleFilterPanel();" style="text-decoration: none;"><img id="ewrptToggleFilterImg" src="<?php echo $sButtonImage ?>" alt="" width="9" height="9" border="0"></a><span class="phpreportmaker">&nbsp;<?php echo $ReportLanguage->Phrase("Filters") ?></span><br><br>
<div id="ewrptExtFilterPanel"<?php echo $sDivDisplay ?>>
<!-- Search form (begin) -->
<form name="fdeals_detailssummaryfilter" id="fdeals_detailssummaryfilter" action="<?php echo ewrpt_CurrentPage() ?>" class="ewForm" onsubmit="return deals_details_summary.ValidateForm(this);">
<table class="ewRptExtFilter">
	<tr id="r_dealer">
		<td><span class="phpreportmaker"><?php echo $deals_details->dealer->FldCaption() ?></span></td>
		<td></td>
		<td colspan="4"><span class="ewRptSearchOpr">
		<select name="sv_dealer" id="sv_dealer"<?php echo ($deals_details_summary->ClearExtFilter == 'deals_details_dealer') ? " class=\"ewInputCleared\"" : "" ?>>
		<option value="<?php echo EWRPT_ALL_VALUE; ?>"<?php if (ewrpt_MatchedFilterValue($deals_details->dealer->DropDownValue, EWRPT_ALL_VALUE)) echo " selected=\"selected\""; ?>><?php echo $ReportLanguage->Phrase("PleaseSelect"); ?></option>
<?php

// Popup filter
$cntf = is_array($deals_details->dealer->AdvancedFilters) ? count($deals_details->dealer->AdvancedFilters) : 0;
$cntd = is_array($deals_details->dealer->DropDownList) ? count($deals_details->dealer->DropDownList) : 0;
$totcnt = $cntf + $cntd;
$wrkcnt = 0;
	if ($cntf > 0) {
		foreach ($deals_details->dealer->AdvancedFilters as $filter) {
			if ($filter->Enabled) {
?>
		<option value="<?php echo $filter->ID ?>"<?php if (ewrpt_MatchedFilterValue($deals_details->dealer->DropDownValue, $filter->ID)) echo " selected=\"selected\"" ?>><?php echo $filter->Name ?></option>
<?php
				$wrkcnt += 1;
			}
		}
	}
	for ($i = 0; $i < $cntd; $i++) {
?>
		<option value="<?php echo $deals_details->dealer->DropDownList[$i] ?>"<?php if (ewrpt_MatchedFilterValue($deals_details->dealer->DropDownValue, $deals_details->dealer->DropDownList[$i])) echo " selected=\"selected\"" ?>><?php echo ewrpt_DropDownDisplayValue($deals_details->dealer->DropDownList[$i], "", 0) ?></option>
<?php
		$wrkcnt += 1;
	}
?>
		</select>
		</span></td>
	</tr>
	<tr id="r_date_start">
		<td><span class="phpreportmaker"><?php echo $deals_details->date_start->FldCaption() ?></span></td>
		<td></td>
		<td colspan="4"><span class="ewRptSearchOpr">
		<select name="sv_date_start" id="sv_date_start"<?php echo ($deals_details_summary->ClearExtFilter == 'deals_details_date_start') ? " class=\"ewInputCleared\"" : "" ?>>
		<option value="<?php echo EWRPT_ALL_VALUE; ?>"<?php if (ewrpt_MatchedFilterValue($deals_details->date_start->DropDownValue, EWRPT_ALL_VALUE)) echo " selected=\"selected\""; ?>><?php echo $ReportLanguage->Phrase("PleaseSelect"); ?></option>
<?php

// Popup filter
$cntf = is_array($deals_details->date_start->AdvancedFilters) ? count($deals_details->date_start->AdvancedFilters) : 0;
$cntd = is_array($deals_details->date_start->DropDownList) ? count($deals_details->date_start->DropDownList) : 0;
$totcnt = $cntf + $cntd;
$wrkcnt = 0;
	if ($cntf > 0) {
		foreach ($deals_details->date_start->AdvancedFilters as $filter) {
			if ($filter->Enabled) {
?>
		<option value="<?php echo $filter->ID ?>"<?php if (ewrpt_MatchedFilterValue($deals_details->date_start->DropDownValue, $filter->ID)) echo " selected=\"selected\"" ?>><?php echo $filter->Name ?></option>
<?php
				$wrkcnt += 1;
			}
		}
	}
	for ($i = 0; $i < $cntd; $i++) {
?>
		<option value="<?php echo $deals_details->date_start->DropDownList[$i] ?>"<?php if (ewrpt_MatchedFilterValue($deals_details->date_start->DropDownValue, $deals_details->date_start->DropDownList[$i])) echo " selected=\"selected\"" ?>><?php echo ewrpt_DropDownDisplayValue($deals_details->date_start->DropDownList[$i], $deals_details->date_start->DateFilter, 7) ?></option>
<?php
		$wrkcnt += 1;
	}
?>
		</select>
		</span></td>
	</tr>
	<tr id="r_status">
		<td><span class="phpreportmaker"><?php echo $deals_details->status->FldCaption() ?></span></td>
		<td></td>
		<td colspan="4"><span class="ewRptSearchOpr">
		<select name="sv_status" id="sv_status"<?php echo ($deals_details_summary->ClearExtFilter == 'deals_details_status') ? " class=\"ewInputCleared\"" : "" ?>>
		<option value="<?php echo EWRPT_ALL_VALUE; ?>"<?php if (ewrpt_MatchedFilterValue($deals_details->status->DropDownValue, EWRPT_ALL_VALUE)) echo " selected=\"selected\""; ?>><?php echo $ReportLanguage->Phrase("PleaseSelect"); ?></option>
<?php

// Popup filter
$cntf = is_array($deals_details->status->AdvancedFilters) ? count($deals_details->status->AdvancedFilters) : 0;
$cntd = is_array($deals_details->status->DropDownList) ? count($deals_details->status->DropDownList) : 0;
$totcnt = $cntf + $cntd;
$wrkcnt = 0;
	if ($cntf > 0) {
		foreach ($deals_details->status->AdvancedFilters as $filter) {
			if ($filter->Enabled) {
?>
		<option value="<?php echo $filter->ID ?>"<?php if (ewrpt_MatchedFilterValue($deals_details->status->DropDownValue, $filter->ID)) echo " selected=\"selected\"" ?>><?php echo $filter->Name ?></option>
<?php
				$wrkcnt += 1;
			}
		}
	}
	for ($i = 0; $i < $cntd; $i++) {
?>
		<option value="<?php echo $deals_details->status->DropDownList[$i] ?>"<?php if (ewrpt_MatchedFilterValue($deals_details->status->DropDownValue, $deals_details->status->DropDownList[$i])) echo " selected=\"selected\"" ?>><?php echo ewrpt_DropDownDisplayValue($deals_details->status->DropDownList[$i], "", 0) ?></option>
<?php
		$wrkcnt += 1;
	}
?>
		</select>
		</span></td>
	</tr>
</table>
<table class="ewRptExtFilter">
	<tr>
		<td><span class="phpreportmaker">
			<input type="Submit" name="Submit" id="Submit" value="<?php echo $ReportLanguage->Phrase("Search") ?>">&nbsp;
			<input type="Reset" name="Reset" id="Reset" value="<?php echo $ReportLanguage->Phrase("Reset") ?>">&nbsp;
		</span></td>
	</tr>
</table>
</form>
<!-- Search form (end) -->
</div>
<br>
<?php } ?>
<?php if ($deals_details->ShowCurrentFilter) { ?>
<div id="ewrptFilterList">
<?php $deals_details_summary->ShowFilterList() ?>
</div>
<br>
<?php } ?>
<table class="ewGrid" cellspacing="0"><tr>
	<td class="ewGridContent">
<!-- Report Grid (Begin) -->
<div class="ewGridMiddlePanel">
<table class="<?php echo $deals_details_summary->ReportTableClass ?>" cellspacing="0">
<?php

// Set the last group to display if not export all
if ($deals_details->ExportAll && $deals_details->Export <> "") {
	$deals_details_summary->StopGrp = $deals_details_summary->TotalGrps;
} else {
	$deals_details_summary->StopGrp = $deals_details_summary->StartGrp + $deals_details_summary->DisplayGrps - 1;
}

// Stop group <= total number of groups
if (intval($deals_details_summary->StopGrp) > intval($deals_details_summary->TotalGrps))
	$deals_details_summary->StopGrp = $deals_details_summary->TotalGrps;
$deals_details_summary->RecCount = 0;

// Get first row
if ($deals_details_summary->TotalGrps > 0) {
	$deals_details_summary->GetRow(1);
	$deals_details_summary->GrpCount = 1;
}
while (($rs && !$rs->EOF && $deals_details_summary->GrpCount <= $deals_details_summary->DisplayGrps) || $deals_details_summary->ShowFirstHeader) {

	// Show header
	if ($deals_details_summary->ShowFirstHeader) {
?>
	<thead>
	<tr>
<td class="ewTableHeader">
<?php if ($deals_details->Export <> "") { ?>
<?php echo $deals_details->deal_number->FldCaption() ?>
<?php } else { ?>
	<table cellspacing="0" class="ewTableHeaderBtn" style="white-space: nowrap;"><tr>
<?php if ($deals_details->SortUrl($deals_details->deal_number) == "") { ?>
		<td style="vertical-align: bottom;"><?php echo $deals_details->deal_number->FldCaption() ?></td>
<?php } else { ?>
		<td class="ewPointer" onmousedown="ewrpt_Sort(event,'<?php echo $deals_details->SortUrl($deals_details->deal_number) ?>',0);"><?php echo $deals_details->deal_number->FldCaption() ?></td><td style="width: 10px;">
		<?php if ($deals_details->deal_number->getSort() == "ASC") { ?><img src="phprptimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($deals_details->deal_number->getSort() == "DESC") { ?><img src="phprptimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td>
<?php } ?>
	</tr></table>
<?php } ?>
</td>
<td class="ewTableHeader">
<?php if ($deals_details->Export <> "") { ?>
<?php echo $deals_details->dealer->FldCaption() ?>
<?php } else { ?>
	<table cellspacing="0" class="ewTableHeaderBtn" style="white-space: nowrap;"><tr>
<?php if ($deals_details->SortUrl($deals_details->dealer) == "") { ?>
		<td style="vertical-align: bottom;"><?php echo $deals_details->dealer->FldCaption() ?></td>
<?php } else { ?>
		<td class="ewPointer" onmousedown="ewrpt_Sort(event,'<?php echo $deals_details->SortUrl($deals_details->dealer) ?>',0);"><?php echo $deals_details->dealer->FldCaption() ?></td><td style="width: 10px;">
		<?php if ($deals_details->dealer->getSort() == "ASC") { ?><img src="phprptimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($deals_details->dealer->getSort() == "DESC") { ?><img src="phprptimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td>
<?php } ?>
	</tr></table>
<?php } ?>
</td>
<td class="ewTableHeader">
<?php if ($deals_details->Export <> "") { ?>
<?php echo $deals_details->date_start->FldCaption() ?>
<?php } else { ?>
	<table cellspacing="0" class="ewTableHeaderBtn" style="white-space: nowrap;"><tr>
<?php if ($deals_details->SortUrl($deals_details->date_start) == "") { ?>
		<td style="vertical-align: bottom;"><?php echo $deals_details->date_start->FldCaption() ?></td>
<?php } else { ?>
		<td class="ewPointer" onmousedown="ewrpt_Sort(event,'<?php echo $deals_details->SortUrl($deals_details->date_start) ?>',0);"><?php echo $deals_details->date_start->FldCaption() ?></td><td style="width: 10px;">
		<?php if ($deals_details->date_start->getSort() == "ASC") { ?><img src="phprptimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($deals_details->date_start->getSort() == "DESC") { ?><img src="phprptimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td>
<?php } ?>
	</tr></table>
<?php } ?>
</td>
<td class="ewTableHeader">
<?php if ($deals_details->Export <> "") { ?>
<?php echo $deals_details->status->FldCaption() ?>
<?php } else { ?>
	<table cellspacing="0" class="ewTableHeaderBtn"><tr>
<?php if ($deals_details->SortUrl($deals_details->status) == "") { ?>
		<td style="vertical-align: bottom;"><?php echo $deals_details->status->FldCaption() ?></td>
<?php } else { ?>
		<td class="ewPointer" onmousedown="ewrpt_Sort(event,'<?php echo $deals_details->SortUrl($deals_details->status) ?>',0);"><?php echo $deals_details->status->FldCaption() ?></td><td style="width: 10px;">
		<?php if ($deals_details->status->getSort() == "ASC") { ?><img src="phprptimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($deals_details->status->getSort() == "DESC") { ?><img src="phprptimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td>
<?php } ?>
	</tr></table>
<?php } ?>
</td>
<td class="ewTableHeader">
<?php if ($deals_details->Export <> "") { ?>
<?php echo $deals_details->salesman->FldCaption() ?>
<?php } else { ?>
	<table cellspacing="0" class="ewTableHeaderBtn" style="white-space: nowrap;"><tr>
<?php if ($deals_details->SortUrl($deals_details->salesman) == "") { ?>
		<td style="vertical-align: bottom;"><?php echo $deals_details->salesman->FldCaption() ?></td>
<?php } else { ?>
		<td class="ewPointer" onmousedown="ewrpt_Sort(event,'<?php echo $deals_details->SortUrl($deals_details->salesman) ?>',0);"><?php echo $deals_details->salesman->FldCaption() ?></td><td style="width: 10px;">
		<?php if ($deals_details->salesman->getSort() == "ASC") { ?><img src="phprptimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($deals_details->salesman->getSort() == "DESC") { ?><img src="phprptimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td>
<?php } ?>
	</tr></table>
<?php } ?>
</td>
<td class="ewTableHeader">
<?php if ($deals_details->Export <> "") { ?>
<?php echo $deals_details->customer->FldCaption() ?>
<?php } else { ?>
	<table cellspacing="0" class="ewTableHeaderBtn" style="white-space: nowrap;"><tr>
<?php if ($deals_details->SortUrl($deals_details->customer) == "") { ?>
		<td style="vertical-align: bottom;"><?php echo $deals_details->customer->FldCaption() ?></td>
<?php } else { ?>
		<td class="ewPointer" onmousedown="ewrpt_Sort(event,'<?php echo $deals_details->SortUrl($deals_details->customer) ?>',0);"><?php echo $deals_details->customer->FldCaption() ?></td><td style="width: 10px;">
		<?php if ($deals_details->customer->getSort() == "ASC") { ?><img src="phprptimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($deals_details->customer->getSort() == "DESC") { ?><img src="phprptimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td>
<?php } ?>
	</tr></table>
<?php } ?>
</td>
<td class="ewTableHeader">
<?php if ($deals_details->Export <> "") { ?>
<?php echo $deals_details->idno->FldCaption() ?>
<?php } else { ?>
	<table cellspacing="0" class="ewTableHeaderBtn" style="white-space: nowrap;"><tr>
<?php if ($deals_details->SortUrl($deals_details->idno) == "") { ?>
		<td style="vertical-align: bottom;"><?php echo $deals_details->idno->FldCaption() ?></td>
<?php } else { ?>
		<td class="ewPointer" onmousedown="ewrpt_Sort(event,'<?php echo $deals_details->SortUrl($deals_details->idno) ?>',0);"><?php echo $deals_details->idno->FldCaption() ?></td><td style="width: 10px;">
		<?php if ($deals_details->idno->getSort() == "ASC") { ?><img src="phprptimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($deals_details->idno->getSort() == "DESC") { ?><img src="phprptimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td>
<?php } ?>
	</tr></table>
<?php } ?>
</td>
<td class="ewTableHeader">
<?php if ($deals_details->Export <> "") { ?>
<?php echo $deals_details->product_name->FldCaption() ?>
<?php } else { ?>
	<table cellspacing="0" class="ewTableHeaderBtn" style="white-space: nowrap;"><tr>
<?php if ($deals_details->SortUrl($deals_details->product_name) == "") { ?>
		<td style="vertical-align: bottom;"><?php echo $deals_details->product_name->FldCaption() ?></td>
<?php } else { ?>
		<td class="ewPointer" onmousedown="ewrpt_Sort(event,'<?php echo $deals_details->SortUrl($deals_details->product_name) ?>',0);"><?php echo $deals_details->product_name->FldCaption() ?></td><td style="width: 10px;">
		<?php if ($deals_details->product_name->getSort() == "ASC") { ?><img src="phprptimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($deals_details->product_name->getSort() == "DESC") { ?><img src="phprptimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td>
<?php } ?>
	</tr></table>
<?php } ?>
</td>
<td class="ewTableHeader">
<?php if ($deals_details->Export <> "") { ?>
<?php echo $deals_details->rep2Etotal_premium_2D_rep2Ecommission->FldCaption() ?>
<?php } else { ?>
	<table cellspacing="0" class="ewTableHeaderBtn"><tr>
<?php if ($deals_details->SortUrl($deals_details->rep2Etotal_premium_2D_rep2Ecommission) == "") { ?>
		<td style="vertical-align: bottom;"><?php echo $deals_details->rep2Etotal_premium_2D_rep2Ecommission->FldCaption() ?></td>
<?php } else { ?>
		<td class="ewPointer" onmousedown="ewrpt_Sort(event,'<?php echo $deals_details->SortUrl($deals_details->rep2Etotal_premium_2D_rep2Ecommission) ?>',0);"><?php echo $deals_details->rep2Etotal_premium_2D_rep2Ecommission->FldCaption() ?></td><td style="width: 10px;">
		<?php if ($deals_details->rep2Etotal_premium_2D_rep2Ecommission->getSort() == "ASC") { ?><img src="phprptimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($deals_details->rep2Etotal_premium_2D_rep2Ecommission->getSort() == "DESC") { ?><img src="phprptimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td>
<?php } ?>
	</tr></table>
<?php } ?>
</td>
<td class="ewTableHeader">
<?php if ($deals_details->Export <> "") { ?>
<?php echo $deals_details->Description->FldCaption() ?>
<?php } else { ?>
	<table cellspacing="0" class="ewTableHeaderBtn" style="white-space: nowrap;"><tr>
<?php if ($deals_details->SortUrl($deals_details->Description) == "") { ?>
		<td style="vertical-align: bottom;"><?php echo $deals_details->Description->FldCaption() ?></td>
<?php } else { ?>
		<td class="ewPointer" onmousedown="ewrpt_Sort(event,'<?php echo $deals_details->SortUrl($deals_details->Description) ?>',0);"><?php echo $deals_details->Description->FldCaption() ?></td><td style="width: 10px;">
		<?php if ($deals_details->Description->getSort() == "ASC") { ?><img src="phprptimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($deals_details->Description->getSort() == "DESC") { ?><img src="phprptimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td>
<?php } ?>
	</tr></table>
<?php } ?>
</td>
<td class="ewTableHeader">
<?php if ($deals_details->Export <> "") { ?>
<?php echo $deals_details->RegistrationNumber->FldCaption() ?>
<?php } else { ?>
	<table cellspacing="0" class="ewTableHeaderBtn" style="white-space: nowrap;"><tr>
<?php if ($deals_details->SortUrl($deals_details->RegistrationNumber) == "") { ?>
		<td style="vertical-align: bottom;"><?php echo $deals_details->RegistrationNumber->FldCaption() ?></td>
<?php } else { ?>
		<td class="ewPointer" onmousedown="ewrpt_Sort(event,'<?php echo $deals_details->SortUrl($deals_details->RegistrationNumber) ?>',0);"><?php echo $deals_details->RegistrationNumber->FldCaption() ?></td><td style="width: 10px;">
		<?php if ($deals_details->RegistrationNumber->getSort() == "ASC") { ?><img src="phprptimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($deals_details->RegistrationNumber->getSort() == "DESC") { ?><img src="phprptimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td>
<?php } ?>
	</tr></table>
<?php } ?>
</td>
<td class="ewTableHeader">
<?php if ($deals_details->Export <> "") { ?>
<?php echo $deals_details->Deposit->FldCaption() ?>
<?php } else { ?>
	<table cellspacing="0" class="ewTableHeaderBtn" style="white-space: nowrap;"><tr>
<?php if ($deals_details->SortUrl($deals_details->Deposit) == "") { ?>
		<td style="vertical-align: bottom;"><?php echo $deals_details->Deposit->FldCaption() ?></td>
<?php } else { ?>
		<td class="ewPointer" onmousedown="ewrpt_Sort(event,'<?php echo $deals_details->SortUrl($deals_details->Deposit) ?>',0);"><?php echo $deals_details->Deposit->FldCaption() ?></td><td style="width: 10px;">
		<?php if ($deals_details->Deposit->getSort() == "ASC") { ?><img src="phprptimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($deals_details->Deposit->getSort() == "DESC") { ?><img src="phprptimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td>
<?php } ?>
	</tr></table>
<?php } ?>
</td>
<td class="ewTableHeader">
<?php if ($deals_details->Export <> "") { ?>
<?php echo $deals_details->PrincipalDebt->FldCaption() ?>
<?php } else { ?>
	<table cellspacing="0" class="ewTableHeaderBtn" style="white-space: nowrap;"><tr>
<?php if ($deals_details->SortUrl($deals_details->PrincipalDebt) == "") { ?>
		<td style="vertical-align: bottom;"><?php echo $deals_details->PrincipalDebt->FldCaption() ?></td>
<?php } else { ?>
		<td class="ewPointer" onmousedown="ewrpt_Sort(event,'<?php echo $deals_details->SortUrl($deals_details->PrincipalDebt) ?>',0);"><?php echo $deals_details->PrincipalDebt->FldCaption() ?></td><td style="width: 10px;">
		<?php if ($deals_details->PrincipalDebt->getSort() == "ASC") { ?><img src="phprptimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($deals_details->PrincipalDebt->getSort() == "DESC") { ?><img src="phprptimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td>
<?php } ?>
	</tr></table>
<?php } ?>
</td>
<td class="ewTableHeader">
<?php if ($deals_details->Export <> "") { ?>
<?php echo $deals_details->FSPFees->FldCaption() ?>
<?php } else { ?>
	<table cellspacing="0" class="ewTableHeaderBtn" style="white-space: nowrap;"><tr>
<?php if ($deals_details->SortUrl($deals_details->FSPFees) == "") { ?>
		<td style="vertical-align: bottom;"><?php echo $deals_details->FSPFees->FldCaption() ?></td>
<?php } else { ?>
		<td class="ewPointer" onmousedown="ewrpt_Sort(event,'<?php echo $deals_details->SortUrl($deals_details->FSPFees) ?>',0);"><?php echo $deals_details->FSPFees->FldCaption() ?></td><td style="width: 10px;">
		<?php if ($deals_details->FSPFees->getSort() == "ASC") { ?><img src="phprptimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($deals_details->FSPFees->getSort() == "DESC") { ?><img src="phprptimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td>
<?php } ?>
	</tr></table>
<?php } ?>
</td>
<td class="ewTableHeader">
<?php if ($deals_details->Export <> "") { ?>
<?php echo $deals_details->ServiceAndDelivery->FldCaption() ?>
<?php } else { ?>
	<table cellspacing="0" class="ewTableHeaderBtn" style="white-space: nowrap;"><tr>
<?php if ($deals_details->SortUrl($deals_details->ServiceAndDelivery) == "") { ?>
		<td style="vertical-align: bottom;"><?php echo $deals_details->ServiceAndDelivery->FldCaption() ?></td>
<?php } else { ?>
		<td class="ewPointer" onmousedown="ewrpt_Sort(event,'<?php echo $deals_details->SortUrl($deals_details->ServiceAndDelivery) ?>',0);"><?php echo $deals_details->ServiceAndDelivery->FldCaption() ?></td><td style="width: 10px;">
		<?php if ($deals_details->ServiceAndDelivery->getSort() == "ASC") { ?><img src="phprptimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($deals_details->ServiceAndDelivery->getSort() == "DESC") { ?><img src="phprptimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td>
<?php } ?>
	</tr></table>
<?php } ?>
</td>
<td class="ewTableHeader">
<?php if ($deals_details->Export <> "") { ?>
<?php echo $deals_details->Vaps->FldCaption() ?>
<?php } else { ?>
	<table cellspacing="0" class="ewTableHeaderBtn" style="white-space: nowrap;"><tr>
<?php if ($deals_details->SortUrl($deals_details->Vaps) == "") { ?>
		<td style="vertical-align: bottom;"><?php echo $deals_details->Vaps->FldCaption() ?></td>
<?php } else { ?>
		<td class="ewPointer" onmousedown="ewrpt_Sort(event,'<?php echo $deals_details->SortUrl($deals_details->Vaps) ?>',0);"><?php echo $deals_details->Vaps->FldCaption() ?></td><td style="width: 10px;">
		<?php if ($deals_details->Vaps->getSort() == "ASC") { ?><img src="phprptimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($deals_details->Vaps->getSort() == "DESC") { ?><img src="phprptimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td>
<?php } ?>
	</tr></table>
<?php } ?>
</td>
<td class="ewTableHeader">
<?php if ($deals_details->Export <> "") { ?>
<?php echo $deals_details->HandlingFees->FldCaption() ?>
<?php } else { ?>
	<table cellspacing="0" class="ewTableHeaderBtn" style="white-space: nowrap;"><tr>
<?php if ($deals_details->SortUrl($deals_details->HandlingFees) == "") { ?>
		<td style="vertical-align: bottom;"><?php echo $deals_details->HandlingFees->FldCaption() ?></td>
<?php } else { ?>
		<td class="ewPointer" onmousedown="ewrpt_Sort(event,'<?php echo $deals_details->SortUrl($deals_details->HandlingFees) ?>',0);"><?php echo $deals_details->HandlingFees->FldCaption() ?></td><td style="width: 10px;">
		<?php if ($deals_details->HandlingFees->getSort() == "ASC") { ?><img src="phprptimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($deals_details->HandlingFees->getSort() == "DESC") { ?><img src="phprptimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td>
<?php } ?>
	</tr></table>
<?php } ?>
</td>
	</tr>
	</thead>
	<tbody>
<?php
		$deals_details_summary->ShowFirstHeader = FALSE;
	}
	$deals_details_summary->RecCount++;

		// Render detail row
		$deals_details->ResetCSS();
		$deals_details->RowType = EWRPT_ROWTYPE_DETAIL;
		$deals_details_summary->RenderRow();
?>
	<tr<?php echo $deals_details->RowAttributes(); ?>>
		<td<?php echo $deals_details->deal_number->CellAttributes() ?>>
<span<?php echo $deals_details->deal_number->ViewAttributes(); ?>><?php echo $deals_details->deal_number->ListViewValue(); ?></span></td>
		<td<?php echo $deals_details->dealer->CellAttributes() ?>>
<span<?php echo $deals_details->dealer->ViewAttributes(); ?>><?php echo $deals_details->dealer->ListViewValue(); ?></span></td>
		<td<?php echo $deals_details->date_start->CellAttributes() ?>>
<span<?php echo $deals_details->date_start->ViewAttributes(); ?>><?php echo $deals_details->date_start->ListViewValue(); ?></span></td>
		<td<?php echo $deals_details->status->CellAttributes() ?>>
<span<?php echo $deals_details->status->ViewAttributes(); ?>><?php echo $deals_details->status->ListViewValue(); ?></span></td>
		<td<?php echo $deals_details->salesman->CellAttributes() ?>>
<span<?php echo $deals_details->salesman->ViewAttributes(); ?>><?php echo $deals_details->salesman->ListViewValue(); ?></span></td>
		<td<?php echo $deals_details->customer->CellAttributes() ?>>
<span<?php echo $deals_details->customer->ViewAttributes(); ?>><?php echo $deals_details->customer->ListViewValue(); ?></span></td>
		<td<?php echo $deals_details->idno->CellAttributes() ?>>
<span<?php echo $deals_details->idno->ViewAttributes(); ?>><?php echo $deals_details->idno->ListViewValue(); ?></span></td>
		<td<?php echo $deals_details->product_name->CellAttributes() ?>>
<span<?php echo $deals_details->product_name->ViewAttributes(); ?>><?php echo $deals_details->product_name->ListViewValue(); ?></span></td>
		<td<?php echo $deals_details->rep2Etotal_premium_2D_rep2Ecommission->CellAttributes() ?>>
<span<?php echo $deals_details->rep2Etotal_premium_2D_rep2Ecommission->ViewAttributes(); ?>><?php echo $deals_details->rep2Etotal_premium_2D_rep2Ecommission->ListViewValue(); ?></span></td>
		<td<?php echo $deals_details->Description->CellAttributes() ?>>
<span<?php echo $deals_details->Description->ViewAttributes(); ?>><?php echo $deals_details->Description->ListViewValue(); ?></span></td>
		<td<?php echo $deals_details->RegistrationNumber->CellAttributes() ?>>
<span<?php echo $deals_details->RegistrationNumber->ViewAttributes(); ?>><?php echo $deals_details->RegistrationNumber->ListViewValue(); ?></span></td>
		<td<?php echo $deals_details->Deposit->CellAttributes() ?>>
<span<?php echo $deals_details->Deposit->ViewAttributes(); ?>><?php echo $deals_details->Deposit->ListViewValue(); ?></span></td>
		<td<?php echo $deals_details->PrincipalDebt->CellAttributes() ?>>
<span<?php echo $deals_details->PrincipalDebt->ViewAttributes(); ?>><?php echo $deals_details->PrincipalDebt->ListViewValue(); ?></span></td>
		<td<?php echo $deals_details->FSPFees->CellAttributes() ?>>
<span<?php echo $deals_details->FSPFees->ViewAttributes(); ?>><?php echo $deals_details->FSPFees->ListViewValue(); ?></span></td>
		<td<?php echo $deals_details->ServiceAndDelivery->CellAttributes() ?>>
<span<?php echo $deals_details->ServiceAndDelivery->ViewAttributes(); ?>><?php echo $deals_details->ServiceAndDelivery->ListViewValue(); ?></span></td>
		<td<?php echo $deals_details->Vaps->CellAttributes() ?>>
<span<?php echo $deals_details->Vaps->ViewAttributes(); ?>><?php echo $deals_details->Vaps->ListViewValue(); ?></span></td>
		<td<?php echo $deals_details->HandlingFees->CellAttributes() ?>>
<span<?php echo $deals_details->HandlingFees->ViewAttributes(); ?>><?php echo $deals_details->HandlingFees->ListViewValue(); ?></span></td>
	</tr>
<?php

		// Accumulate page summary
		$deals_details_summary->AccumulateSummary();

		// Get next record
		$deals_details_summary->GetRow(2);
	$deals_details_summary->GrpCount++;
} // End while
?>
	</tbody>
	<tfoot>
<?php
if ($deals_details_summary->TotalGrps > 0) {
	$deals_details->ResetCSS();
	$deals_details->RowType = EWRPT_ROWTYPE_TOTAL;
	$deals_details->RowTotalType = EWRPT_ROWTOTAL_GRAND;
	$deals_details->RowTotalSubType = EWRPT_ROWTOTAL_FOOTER;
	$deals_details->RowAttrs["class"] = "ewRptGrandSummary";
	$deals_details_summary->RenderRow();
?>
	<!-- tr><td colspan="17"><span class="phpreportmaker">&nbsp;<br></span></td></tr -->
	<tr<?php echo $deals_details->RowAttributes(); ?>><td colspan="17"><?php echo $ReportLanguage->Phrase("RptGrandTotal") ?> (<?php echo ewrpt_FormatNumber($deals_details_summary->TotCount,0,-2,-2,-2); ?><?php echo $ReportLanguage->Phrase("RptDtlRec") ?>)</td></tr>
<?php } ?>
	</tfoot>
</table>
</div>
<?php if ($deals_details->Export == "") { ?>
<div class="ewGridLowerPanel">
<form action="<?php echo ewrpt_CurrentPage() ?>" name="ewpagerform" id="ewpagerform" class="ewForm">
<table border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td style="white-space: nowrap;">
<?php if (!isset($Pager)) $Pager = new crPrevNextPager($deals_details_summary->StartGrp, $deals_details_summary->DisplayGrps, $deals_details_summary->TotalGrps) ?>
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
	<?php if ($deals_details_summary->Filter == "0=101") { ?>
	<span class="phpreportmaker"><?php echo $ReportLanguage->Phrase("EnterSearchCriteria") ?></span>
	<?php } else { ?>
	<span class="phpreportmaker"><?php echo $ReportLanguage->Phrase("NoRecord") ?></span>
	<?php } ?>
<?php } ?>
		</td>
<?php if ($deals_details_summary->TotalGrps > 0) { ?>
		<td style="white-space: nowrap;">&nbsp;&nbsp;&nbsp;&nbsp;</td>
		<td align="right" style="vertical-align: top; white-space: nowrap;"><span class="phpreportmaker"><?php echo $ReportLanguage->Phrase("GroupsPerPage"); ?>&nbsp;
<select name="<?php echo EWRPT_TABLE_GROUP_PER_PAGE; ?>" onchange="this.form.submit();">
<option value="1"<?php if ($deals_details_summary->DisplayGrps == 1) echo " selected=\"selected\"" ?>>1</option>
<option value="2"<?php if ($deals_details_summary->DisplayGrps == 2) echo " selected=\"selected\"" ?>>2</option>
<option value="3"<?php if ($deals_details_summary->DisplayGrps == 3) echo " selected=\"selected\"" ?>>3</option>
<option value="4"<?php if ($deals_details_summary->DisplayGrps == 4) echo " selected=\"selected\"" ?>>4</option>
<option value="5"<?php if ($deals_details_summary->DisplayGrps == 5) echo " selected=\"selected\"" ?>>5</option>
<option value="10"<?php if ($deals_details_summary->DisplayGrps == 10) echo " selected=\"selected\"" ?>>10</option>
<option value="20"<?php if ($deals_details_summary->DisplayGrps == 20) echo " selected=\"selected\"" ?>>20</option>
<option value="50"<?php if ($deals_details_summary->DisplayGrps == 50) echo " selected=\"selected\"" ?>>50</option>
<option value="ALL"<?php if ($deals_details->getGroupPerPage() == -1) echo " selected=\"selected\"" ?>><?php echo $ReportLanguage->Phrase("AllRecords") ?></option>
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
<?php if ($deals_details->Export == "" || $deals_details->Export == "print" || $deals_details->Export == "email") { ?>
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
<?php $deals_details_summary->ShowPageFooter(); ?>
<?php if (EWRPT_DEBUG_ENABLED) echo ewrpt_DebugMsg(); ?>
<?php

// Close recordsets
if ($rsgrp) $rsgrp->Close();
if ($rs) $rs->Close();
?>
<?php if ($deals_details->Export == "") { ?>
<script language="JavaScript" type="text/javascript">
<!--

// Write your table-specific startup script here
// document.write("page loaded");
//-->

</script>
<?php } ?>
<?php include_once "phprptinc/footer.php"; ?>
<?php
$deals_details_summary->Page_Terminate();
?>
<?php

//
// Page class
//
class crdeals_details_summary {

	// Page ID
	var $PageID = 'summary';

	// Table name
	var $TableName = 'deals_details';

	// Page object name
	var $PageObjName = 'deals_details_summary';

	// Page name
	function PageName() {
		return ewrpt_CurrentPage();
	}

	// Page URL
	function PageUrl() {
		$PageUrl = ewrpt_CurrentPage() . "?";
		global $deals_details;
		if ($deals_details->UseTokenInUrl) $PageUrl .= "t=" . $deals_details->TableVar . "&"; // Add page token
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
		global $deals_details;
		if ($deals_details->UseTokenInUrl) {
			if (ewrpt_IsHttpPost())
				return ($deals_details->TableVar == @$_POST("t"));
			if (@$_GET["t"] <> "")
				return ($deals_details->TableVar == @$_GET["t"]);
		} else {
			return TRUE;
		}
	}

	//
	// Page class constructor
	//
	function crdeals_details_summary() {
		global $conn, $ReportLanguage;

		// Language object
		$ReportLanguage = new crLanguage();

		// Table object (deals_details)
		$GLOBALS["deals_details"] = new crdeals_details();
		$GLOBALS["Table"] =& $GLOBALS["deals_details"];

		// Initialize URLs
		$this->ExportPrintUrl = $this->PageUrl() . "export=print";
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel";
		$this->ExportWordUrl = $this->PageUrl() . "export=word";
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf";

		// Page ID
		if (!defined("EWRPT_PAGE_ID"))
			define("EWRPT_PAGE_ID", 'summary', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EWRPT_TABLE_NAME"))
			define("EWRPT_TABLE_NAME", 'deals_details', TRUE);

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
		global $deals_details;

		// Security
		$Security = new crAdvancedSecurity();
		if (!$Security->IsLoggedIn()) $Security->AutoLogin(); // Auto login
		if (!$Security->IsLoggedIn()) {
			$Security->SaveLastUrl();
			$this->Page_Terminate("rlogin.php");
		}

		// Get export parameters
		if (@$_GET["export"] <> "") {
			$deals_details->Export = $_GET["export"];
		}
		$gsExport = $deals_details->Export; // Get export parameter, used in header
		$gsExportFile = $deals_details->TableVar; // Get export file, used in header
		if ($deals_details->Export == "excel") {
			header('Content-Type: application/vnd.ms-excel;charset=utf-8');
			header('Content-Disposition: attachment; filename=' . $gsExportFile .'.xls');
		}
		if ($deals_details->Export == "word") {
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
		global $ReportLanguage, $deals_details;

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
		$item->Body = "<a name=\"emf_deals_details\" id=\"emf_deals_details\" href=\"javascript:void(0);\" onclick=\"ewrpt_EmailDialogShow({lnk:'emf_deals_details',hdr:ewLanguage.Phrase('ExportToEmail')});\">" . $ReportLanguage->Phrase("ExportToEmail") . "</a>";
		$item->Visible = FALSE;

		// Reset filter
		$item =& $this->ExportOptions->Add("resetfilter");
		$item->Body = "<a href=\"" . ewrpt_CurrentPage() . "?cmd=reset\">" . $ReportLanguage->Phrase("ResetAllFilter") . "</a>";
		$item->Visible = TRUE;
		$this->SetupExportOptionsExt();

		// Hide options for export
		if ($deals_details->Export <> "")
			$this->ExportOptions->HideAllOptions();

		// Set up table class
		if ($deals_details->Export == "word" || $deals_details->Export == "excel" || $deals_details->Export == "pdf")
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
		global $deals_details;

		// Page Unload event
		$this->Page_Unload();

		// Global Page Unloaded event (in userfn*.php)
		Page_Unloaded();

		// Export to Email (use ob_file_contents for PHP)
		if ($deals_details->Export == "email") {
			$sContent = ob_get_contents();
			$this->ExportEmail($sContent);
			ob_end_clean();

			 // Close connection
			$conn->Close();
			header("Location: " . ewrpt_CurrentPage());
			exit();
		}

		// Export to PDF (use ob_file_contents for PHP)
		if ($deals_details->Export == "pdf") {
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
		global $deals_details;
		global $rs;
		global $rsgrp;
		global $gsFormError;

		// Aggregate variables
		// 1st dimension = no of groups (level 0 used for grand total)
		// 2nd dimension = no of fields

		$nDtls = 18;
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
		$this->Col = array(FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE);

		// Set up groups per page dynamically
		$this->SetUpDisplayGrps();

		// Load default filter values
		$this->LoadDefaultFilters();

		// Load custom filters
		$deals_details->Filters_Load();

		// Set up popup filter
		$this->SetupPopup();

		// Extended filter
		$sExtendedFilter = "";

		// Get dropdown values
		$this->GetExtendedFilterValues();

		// Build extended filter
		$sExtendedFilter = $this->GetExtendedFilter();
		if ($sExtendedFilter <> "") {
			if ($this->Filter <> "")
  				$this->Filter = "($this->Filter) AND ($sExtendedFilter)";
			else
				$this->Filter = $sExtendedFilter;
		}

		// Build popup filter
		$sPopupFilter = $this->GetPopupFilter();

		//ewrpt_SetDebugMsg("popup filter: " . $sPopupFilter);
		if ($sPopupFilter <> "") {
			if ($this->Filter <> "")
				$this->Filter = "($this->Filter) AND ($sPopupFilter)";
			else
				$this->Filter = $sPopupFilter;
		}

		// Check if filter applied
		$this->FilterApplied = $this->CheckFilter();

		// Requires search criteria
		if ($this->Filter == $this->UserIDFilter || $gsFormError != "")
			$this->Filter = "0=101";
		$this->ExportOptions->GetItem("resetfilter")->Visible = $this->FilterApplied;

		// Get sort
		$this->Sort = $this->GetSort();

		// Get total count
		$sSql = ewrpt_BuildReportSql($deals_details->SqlSelect(), $deals_details->SqlWhere(), $deals_details->SqlGroupBy(), $deals_details->SqlHaving(), $deals_details->SqlOrderBy(), $this->Filter, $this->Sort);
		$this->TotalGrps = $this->GetCnt($sSql);
		if ($this->DisplayGrps <= 0) // Display all groups
			$this->DisplayGrps = $this->TotalGrps;
		$this->StartGrp = 1;

		// Show header
		$this->ShowFirstHeader = ($this->TotalGrps > 0);

		//$this->ShowFirstHeader = TRUE; // Uncomment to always show header
		// Set up start position if not export all

		if ($deals_details->ExportAll && $deals_details->Export <> "")
		    $this->DisplayGrps = $this->TotalGrps;
		else
			$this->SetUpStartGroup(); 

		// Hide all options if export
		if ($deals_details->Export <> "") {
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
		global $deals_details;
		if (!$rs)
			return;
		if ($opt == 1) { // Get first row

	//		$rs->MoveFirst(); // NOTE: no need to move position
		} else { // Get next row
			$rs->MoveNext();
		}
		if (!$rs->EOF) {
			$deals_details->deal_number->setDbValue($rs->fields('deal_number'));
			$deals_details->dealer->setDbValue($rs->fields('dealer'));
			$deals_details->date_start->setDbValue($rs->fields('date_start'));
			$deals_details->status->setDbValue($rs->fields('status'));
			$deals_details->salesman->setDbValue($rs->fields('salesman'));
			$deals_details->customer->setDbValue($rs->fields('customer'));
			$deals_details->idno->setDbValue($rs->fields('idno'));
			$deals_details->product_name->setDbValue($rs->fields('product_name'));
			$deals_details->rep2Etotal_premium_2D_rep2Ecommission->setDbValue($rs->fields('rep.total_premium - rep.commission'));
			$deals_details->Description->setDbValue($rs->fields('Description'));
			$deals_details->RegistrationNumber->setDbValue($rs->fields('RegistrationNumber'));
			$deals_details->Deposit->setDbValue($rs->fields('Deposit'));
			$deals_details->PrincipalDebt->setDbValue($rs->fields('PrincipalDebt'));
			$deals_details->FSPFees->setDbValue($rs->fields('FSPFees'));
			$deals_details->ServiceAndDelivery->setDbValue($rs->fields('ServiceAndDelivery'));
			$deals_details->Vaps->setDbValue($rs->fields('Vaps'));
			$deals_details->HandlingFees->setDbValue($rs->fields('HandlingFees'));
			$this->Val[1] = $deals_details->deal_number->CurrentValue;
			$this->Val[2] = $deals_details->dealer->CurrentValue;
			$this->Val[3] = $deals_details->date_start->CurrentValue;
			$this->Val[4] = $deals_details->status->CurrentValue;
			$this->Val[5] = $deals_details->salesman->CurrentValue;
			$this->Val[6] = $deals_details->customer->CurrentValue;
			$this->Val[7] = $deals_details->idno->CurrentValue;
			$this->Val[8] = $deals_details->product_name->CurrentValue;
			$this->Val[9] = $deals_details->rep2Etotal_premium_2D_rep2Ecommission->CurrentValue;
			$this->Val[10] = $deals_details->Description->CurrentValue;
			$this->Val[11] = $deals_details->RegistrationNumber->CurrentValue;
			$this->Val[12] = $deals_details->Deposit->CurrentValue;
			$this->Val[13] = $deals_details->PrincipalDebt->CurrentValue;
			$this->Val[14] = $deals_details->FSPFees->CurrentValue;
			$this->Val[15] = $deals_details->ServiceAndDelivery->CurrentValue;
			$this->Val[16] = $deals_details->Vaps->CurrentValue;
			$this->Val[17] = $deals_details->HandlingFees->CurrentValue;
		} else {
			$deals_details->deal_number->setDbValue("");
			$deals_details->dealer->setDbValue("");
			$deals_details->date_start->setDbValue("");
			$deals_details->status->setDbValue("");
			$deals_details->salesman->setDbValue("");
			$deals_details->customer->setDbValue("");
			$deals_details->idno->setDbValue("");
			$deals_details->product_name->setDbValue("");
			$deals_details->rep2Etotal_premium_2D_rep2Ecommission->setDbValue("");
			$deals_details->Description->setDbValue("");
			$deals_details->RegistrationNumber->setDbValue("");
			$deals_details->Deposit->setDbValue("");
			$deals_details->PrincipalDebt->setDbValue("");
			$deals_details->FSPFees->setDbValue("");
			$deals_details->ServiceAndDelivery->setDbValue("");
			$deals_details->Vaps->setDbValue("");
			$deals_details->HandlingFees->setDbValue("");
		}
	}

	//  Set up starting group
	function SetUpStartGroup() {
		global $deals_details;

		// Exit if no groups
		if ($this->DisplayGrps == 0)
			return;

		// Check for a 'start' parameter
		if (@$_GET[EWRPT_TABLE_START_GROUP] != "") {
			$this->StartGrp = $_GET[EWRPT_TABLE_START_GROUP];
			$deals_details->setStartGroup($this->StartGrp);
		} elseif (@$_GET["pageno"] != "") {
			$nPageNo = $_GET["pageno"];
			if (is_numeric($nPageNo)) {
				$this->StartGrp = ($nPageNo-1)*$this->DisplayGrps+1;
				if ($this->StartGrp <= 0) {
					$this->StartGrp = 1;
				} elseif ($this->StartGrp >= intval(($this->TotalGrps-1)/$this->DisplayGrps)*$this->DisplayGrps+1) {
					$this->StartGrp = intval(($this->TotalGrps-1)/$this->DisplayGrps)*$this->DisplayGrps+1;
				}
				$deals_details->setStartGroup($this->StartGrp);
			} else {
				$this->StartGrp = $deals_details->getStartGroup();
			}
		} else {
			$this->StartGrp = $deals_details->getStartGroup();
		}

		// Check if correct start group counter
		if (!is_numeric($this->StartGrp) || $this->StartGrp == "") { // Avoid invalid start group counter
			$this->StartGrp = 1; // Reset start group counter
			$deals_details->setStartGroup($this->StartGrp);
		} elseif (intval($this->StartGrp) > intval($this->TotalGrps)) { // Avoid starting group > total groups
			$this->StartGrp = intval(($this->TotalGrps-1)/$this->DisplayGrps) * $this->DisplayGrps + 1; // Point to last page first group
			$deals_details->setStartGroup($this->StartGrp);
		} elseif (($this->StartGrp-1) % $this->DisplayGrps <> 0) {
			$this->StartGrp = intval(($this->StartGrp-1)/$this->DisplayGrps) * $this->DisplayGrps + 1; // Point to page boundary
			$deals_details->setStartGroup($this->StartGrp);
		}
	}

	// Set up popup
	function SetupPopup() {
		global $conn, $ReportLanguage;
		global $deals_details;

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
					if (!ewrpt_MatchedArray($arValues, $_SESSION["sel_$sName"])) {
						if ($this->HasSessionFilterValues($sName))
							$this->ClearExtFilter = $sName; // Clear extended filter for this field
					}
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
		global $deals_details;
		$this->StartGrp = 1;
		$deals_details->setStartGroup($this->StartGrp);
	}

	// Set up number of groups displayed per page
	function SetUpDisplayGrps() {
		global $deals_details;
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
			$deals_details->setGroupPerPage($this->DisplayGrps); // Save to session

			// Reset start position (reset command)
			$this->StartGrp = 1;
			$deals_details->setStartGroup($this->StartGrp);
		} else {
			if ($deals_details->getGroupPerPage() <> "") {
				$this->DisplayGrps = $deals_details->getGroupPerPage(); // Restore from session
			} else {
				$this->DisplayGrps = 50; // Load default
			}
		}
	}

	function RenderRow() {
		global $conn, $rs, $Security;
		global $deals_details;
		if ($deals_details->RowTotalType == EWRPT_ROWTOTAL_GRAND) { // Grand total

			// Get total count from sql directly
			$sSql = ewrpt_BuildReportSql($deals_details->SqlSelectCount(), $deals_details->SqlWhere(), $deals_details->SqlGroupBy(), $deals_details->SqlHaving(), "", $this->Filter, "");
			$rstot = $conn->Execute($sSql);
			if ($rstot) {
				$this->TotCount = ($rstot->RecordCount()>1) ? $rstot->RecordCount() : $rstot->fields[0];
				$rstot->Close();
			} else {
				$this->TotCount = 0;
			}
		}

		// Call Row_Rendering event
		$deals_details->Row_Rendering();

		//
		// Render view codes
		//

		if ($deals_details->RowType == EWRPT_ROWTYPE_TOTAL) { // Summary row
		} else {

			// deal_number
			$deals_details->deal_number->ViewValue = $deals_details->deal_number->CurrentValue;
			$deals_details->deal_number->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";
			$deals_details->deal_number->CellAttrs["style"] = "white-space: nowrap;";

			// dealer
			$deals_details->dealer->ViewValue = $deals_details->dealer->CurrentValue;
			$deals_details->dealer->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";
			$deals_details->dealer->CellAttrs["style"] = "white-space: nowrap;";

			// date_start
			$deals_details->date_start->ViewValue = $deals_details->date_start->CurrentValue;
			$deals_details->date_start->ViewValue = ewrpt_FormatDateTime($deals_details->date_start->ViewValue, 7);
			$deals_details->date_start->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";
			$deals_details->date_start->CellAttrs["style"] = "white-space: nowrap;";

			// status
			$deals_details->status->ViewValue = $deals_details->status->CurrentValue;
			$deals_details->status->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";

			// salesman
			$deals_details->salesman->ViewValue = $deals_details->salesman->CurrentValue;
			$deals_details->salesman->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";
			$deals_details->salesman->CellAttrs["style"] = "white-space: nowrap;";

			// customer
			$deals_details->customer->ViewValue = $deals_details->customer->CurrentValue;
			$deals_details->customer->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";
			$deals_details->customer->CellAttrs["style"] = "white-space: nowrap;";

			// idno
			$deals_details->idno->ViewValue = $deals_details->idno->CurrentValue;
			$deals_details->idno->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";
			$deals_details->idno->CellAttrs["style"] = "white-space: nowrap;";

			// product_name
			$deals_details->product_name->ViewValue = $deals_details->product_name->CurrentValue;
			$deals_details->product_name->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";
			$deals_details->product_name->CellAttrs["style"] = "white-space: nowrap;";

			// rep.total_premium - rep.commission
			$deals_details->rep2Etotal_premium_2D_rep2Ecommission->ViewValue = $deals_details->rep2Etotal_premium_2D_rep2Ecommission->CurrentValue;
			$deals_details->rep2Etotal_premium_2D_rep2Ecommission->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";

			// Description
			$deals_details->Description->ViewValue = $deals_details->Description->CurrentValue;
			$deals_details->Description->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";
			$deals_details->Description->CellAttrs["style"] = "white-space: nowrap;";

			// RegistrationNumber
			$deals_details->RegistrationNumber->ViewValue = $deals_details->RegistrationNumber->CurrentValue;
			$deals_details->RegistrationNumber->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";
			$deals_details->RegistrationNumber->CellAttrs["style"] = "white-space: nowrap;";

			// Deposit
			$deals_details->Deposit->ViewValue = $deals_details->Deposit->CurrentValue;
			$deals_details->Deposit->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";
			$deals_details->Deposit->CellAttrs["style"] = "white-space: nowrap;";

			// PrincipalDebt
			$deals_details->PrincipalDebt->ViewValue = $deals_details->PrincipalDebt->CurrentValue;
			$deals_details->PrincipalDebt->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";
			$deals_details->PrincipalDebt->CellAttrs["style"] = "white-space: nowrap;";

			// FSPFees
			$deals_details->FSPFees->ViewValue = $deals_details->FSPFees->CurrentValue;
			$deals_details->FSPFees->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";
			$deals_details->FSPFees->CellAttrs["style"] = "white-space: nowrap;";

			// ServiceAndDelivery
			$deals_details->ServiceAndDelivery->ViewValue = $deals_details->ServiceAndDelivery->CurrentValue;
			$deals_details->ServiceAndDelivery->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";
			$deals_details->ServiceAndDelivery->CellAttrs["style"] = "white-space: nowrap;";

			// Vaps
			$deals_details->Vaps->ViewValue = $deals_details->Vaps->CurrentValue;
			$deals_details->Vaps->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";
			$deals_details->Vaps->CellAttrs["style"] = "white-space: nowrap;";

			// HandlingFees
			$deals_details->HandlingFees->ViewValue = $deals_details->HandlingFees->CurrentValue;
			$deals_details->HandlingFees->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";
			$deals_details->HandlingFees->CellAttrs["style"] = "white-space: nowrap;";

			// deal_number
			$deals_details->deal_number->HrefValue = "";

			// dealer
			$deals_details->dealer->HrefValue = "";

			// date_start
			$deals_details->date_start->HrefValue = "";

			// status
			$deals_details->status->HrefValue = "";

			// salesman
			$deals_details->salesman->HrefValue = "";

			// customer
			$deals_details->customer->HrefValue = "";

			// idno
			$deals_details->idno->HrefValue = "";

			// product_name
			$deals_details->product_name->HrefValue = "";

			// rep.total_premium - rep.commission
			$deals_details->rep2Etotal_premium_2D_rep2Ecommission->HrefValue = "";

			// Description
			$deals_details->Description->HrefValue = "";

			// RegistrationNumber
			$deals_details->RegistrationNumber->HrefValue = "";

			// Deposit
			$deals_details->Deposit->HrefValue = "";

			// PrincipalDebt
			$deals_details->PrincipalDebt->HrefValue = "";

			// FSPFees
			$deals_details->FSPFees->HrefValue = "";

			// ServiceAndDelivery
			$deals_details->ServiceAndDelivery->HrefValue = "";

			// Vaps
			$deals_details->Vaps->HrefValue = "";

			// HandlingFees
			$deals_details->HandlingFees->HrefValue = "";
		}

		// Call Cell_Rendered event
		if ($deals_details->RowType == EWRPT_ROWTYPE_TOTAL) { // Summary row
		} else {

			// deal_number
			$CurrentValue = $deals_details->deal_number->CurrentValue;
			$ViewValue =& $deals_details->deal_number->ViewValue;
			$ViewAttrs =& $deals_details->deal_number->ViewAttrs;
			$CellAttrs =& $deals_details->deal_number->CellAttrs;
			$HrefValue =& $deals_details->deal_number->HrefValue;
			$deals_details->Cell_Rendered($deals_details->deal_number, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue);

			// dealer
			$CurrentValue = $deals_details->dealer->CurrentValue;
			$ViewValue =& $deals_details->dealer->ViewValue;
			$ViewAttrs =& $deals_details->dealer->ViewAttrs;
			$CellAttrs =& $deals_details->dealer->CellAttrs;
			$HrefValue =& $deals_details->dealer->HrefValue;
			$deals_details->Cell_Rendered($deals_details->dealer, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue);

			// date_start
			$CurrentValue = $deals_details->date_start->CurrentValue;
			$ViewValue =& $deals_details->date_start->ViewValue;
			$ViewAttrs =& $deals_details->date_start->ViewAttrs;
			$CellAttrs =& $deals_details->date_start->CellAttrs;
			$HrefValue =& $deals_details->date_start->HrefValue;
			$deals_details->Cell_Rendered($deals_details->date_start, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue);

			// status
			$CurrentValue = $deals_details->status->CurrentValue;
			$ViewValue =& $deals_details->status->ViewValue;
			$ViewAttrs =& $deals_details->status->ViewAttrs;
			$CellAttrs =& $deals_details->status->CellAttrs;
			$HrefValue =& $deals_details->status->HrefValue;
			$deals_details->Cell_Rendered($deals_details->status, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue);

			// salesman
			$CurrentValue = $deals_details->salesman->CurrentValue;
			$ViewValue =& $deals_details->salesman->ViewValue;
			$ViewAttrs =& $deals_details->salesman->ViewAttrs;
			$CellAttrs =& $deals_details->salesman->CellAttrs;
			$HrefValue =& $deals_details->salesman->HrefValue;
			$deals_details->Cell_Rendered($deals_details->salesman, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue);

			// customer
			$CurrentValue = $deals_details->customer->CurrentValue;
			$ViewValue =& $deals_details->customer->ViewValue;
			$ViewAttrs =& $deals_details->customer->ViewAttrs;
			$CellAttrs =& $deals_details->customer->CellAttrs;
			$HrefValue =& $deals_details->customer->HrefValue;
			$deals_details->Cell_Rendered($deals_details->customer, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue);

			// idno
			$CurrentValue = $deals_details->idno->CurrentValue;
			$ViewValue =& $deals_details->idno->ViewValue;
			$ViewAttrs =& $deals_details->idno->ViewAttrs;
			$CellAttrs =& $deals_details->idno->CellAttrs;
			$HrefValue =& $deals_details->idno->HrefValue;
			$deals_details->Cell_Rendered($deals_details->idno, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue);

			// product_name
			$CurrentValue = $deals_details->product_name->CurrentValue;
			$ViewValue =& $deals_details->product_name->ViewValue;
			$ViewAttrs =& $deals_details->product_name->ViewAttrs;
			$CellAttrs =& $deals_details->product_name->CellAttrs;
			$HrefValue =& $deals_details->product_name->HrefValue;
			$deals_details->Cell_Rendered($deals_details->product_name, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue);

			// rep.total_premium - rep.commission
			$CurrentValue = $deals_details->rep2Etotal_premium_2D_rep2Ecommission->CurrentValue;
			$ViewValue =& $deals_details->rep2Etotal_premium_2D_rep2Ecommission->ViewValue;
			$ViewAttrs =& $deals_details->rep2Etotal_premium_2D_rep2Ecommission->ViewAttrs;
			$CellAttrs =& $deals_details->rep2Etotal_premium_2D_rep2Ecommission->CellAttrs;
			$HrefValue =& $deals_details->rep2Etotal_premium_2D_rep2Ecommission->HrefValue;
			$deals_details->Cell_Rendered($deals_details->rep2Etotal_premium_2D_rep2Ecommission, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue);

			// Description
			$CurrentValue = $deals_details->Description->CurrentValue;
			$ViewValue =& $deals_details->Description->ViewValue;
			$ViewAttrs =& $deals_details->Description->ViewAttrs;
			$CellAttrs =& $deals_details->Description->CellAttrs;
			$HrefValue =& $deals_details->Description->HrefValue;
			$deals_details->Cell_Rendered($deals_details->Description, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue);

			// RegistrationNumber
			$CurrentValue = $deals_details->RegistrationNumber->CurrentValue;
			$ViewValue =& $deals_details->RegistrationNumber->ViewValue;
			$ViewAttrs =& $deals_details->RegistrationNumber->ViewAttrs;
			$CellAttrs =& $deals_details->RegistrationNumber->CellAttrs;
			$HrefValue =& $deals_details->RegistrationNumber->HrefValue;
			$deals_details->Cell_Rendered($deals_details->RegistrationNumber, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue);

			// Deposit
			$CurrentValue = $deals_details->Deposit->CurrentValue;
			$ViewValue =& $deals_details->Deposit->ViewValue;
			$ViewAttrs =& $deals_details->Deposit->ViewAttrs;
			$CellAttrs =& $deals_details->Deposit->CellAttrs;
			$HrefValue =& $deals_details->Deposit->HrefValue;
			$deals_details->Cell_Rendered($deals_details->Deposit, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue);

			// PrincipalDebt
			$CurrentValue = $deals_details->PrincipalDebt->CurrentValue;
			$ViewValue =& $deals_details->PrincipalDebt->ViewValue;
			$ViewAttrs =& $deals_details->PrincipalDebt->ViewAttrs;
			$CellAttrs =& $deals_details->PrincipalDebt->CellAttrs;
			$HrefValue =& $deals_details->PrincipalDebt->HrefValue;
			$deals_details->Cell_Rendered($deals_details->PrincipalDebt, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue);

			// FSPFees
			$CurrentValue = $deals_details->FSPFees->CurrentValue;
			$ViewValue =& $deals_details->FSPFees->ViewValue;
			$ViewAttrs =& $deals_details->FSPFees->ViewAttrs;
			$CellAttrs =& $deals_details->FSPFees->CellAttrs;
			$HrefValue =& $deals_details->FSPFees->HrefValue;
			$deals_details->Cell_Rendered($deals_details->FSPFees, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue);

			// ServiceAndDelivery
			$CurrentValue = $deals_details->ServiceAndDelivery->CurrentValue;
			$ViewValue =& $deals_details->ServiceAndDelivery->ViewValue;
			$ViewAttrs =& $deals_details->ServiceAndDelivery->ViewAttrs;
			$CellAttrs =& $deals_details->ServiceAndDelivery->CellAttrs;
			$HrefValue =& $deals_details->ServiceAndDelivery->HrefValue;
			$deals_details->Cell_Rendered($deals_details->ServiceAndDelivery, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue);

			// Vaps
			$CurrentValue = $deals_details->Vaps->CurrentValue;
			$ViewValue =& $deals_details->Vaps->ViewValue;
			$ViewAttrs =& $deals_details->Vaps->ViewAttrs;
			$CellAttrs =& $deals_details->Vaps->CellAttrs;
			$HrefValue =& $deals_details->Vaps->HrefValue;
			$deals_details->Cell_Rendered($deals_details->Vaps, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue);

			// HandlingFees
			$CurrentValue = $deals_details->HandlingFees->CurrentValue;
			$ViewValue =& $deals_details->HandlingFees->ViewValue;
			$ViewAttrs =& $deals_details->HandlingFees->ViewAttrs;
			$CellAttrs =& $deals_details->HandlingFees->CellAttrs;
			$HrefValue =& $deals_details->HandlingFees->HrefValue;
			$deals_details->Cell_Rendered($deals_details->HandlingFees, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue);
		}

		// Call Row_Rendered event
		$deals_details->Row_Rendered();
	}

	function SetupExportOptionsExt() {
		global $ReportLanguage, $deals_details;
	}

	// Get extended filter values
	function GetExtendedFilterValues() {
		global $deals_details;

		// Field dealer
		$sSelect = "SELECT DISTINCT rep.dealer FROM " . $deals_details->SqlFrom();
		$sOrderBy = "rep.dealer ASC";
		$wrkSql = ewrpt_BuildReportSql($sSelect, $deals_details->SqlWhere(), "", "", $sOrderBy, $this->UserIDFilter, "");
		$deals_details->dealer->DropDownList = ewrpt_GetDistinctValues("", $wrkSql);

		// Field date_start
		$sSelect = "SELECT DISTINCT rep.date_start FROM " . $deals_details->SqlFrom();
		$sOrderBy = "rep.date_start ASC";
		$wrkSql = ewrpt_BuildReportSql($sSelect, $deals_details->SqlWhere(), "", "", $sOrderBy, $this->UserIDFilter, "");
		$deals_details->date_start->DropDownList = ewrpt_GetDistinctValues($deals_details->date_start->DateFilter, $wrkSql);

		// Field status
		$sSelect = "SELECT DISTINCT rep.status FROM " . $deals_details->SqlFrom();
		$sOrderBy = "rep.status ASC";
		$wrkSql = ewrpt_BuildReportSql($sSelect, $deals_details->SqlWhere(), "", "", $sOrderBy, $this->UserIDFilter, "");
		$deals_details->status->DropDownList = ewrpt_GetDistinctValues("", $wrkSql);
	}

	// Return extended filter
	function GetExtendedFilter() {
		global $deals_details;
		global $gsFormError;
		$sFilter = "";
		$bPostBack = ewrpt_IsHttpPost();
		$bRestoreSession = TRUE;
		$bSetupFilter = FALSE;

		// Reset extended filter if filter changed
		if ($bPostBack) {

		// Reset search command
		} elseif (@$_GET["cmd"] == "reset") {

			// Load default values
			// Field dealer

			$this->SetSessionDropDownValue($deals_details->dealer->DropDownValue, 'dealer');

			// Field date_start
			$this->SetSessionDropDownValue($deals_details->date_start->DropDownValue, 'date_start');

			// Field status
			$this->SetSessionDropDownValue($deals_details->status->DropDownValue, 'status');
			$bSetupFilter = TRUE;
		} else {

			// Field dealer
			if ($this->GetDropDownValue($deals_details->dealer->DropDownValue, 'dealer')) {
				$bSetupFilter = TRUE;
				$bRestoreSession = FALSE;
			} elseif ($deals_details->dealer->DropDownValue <> EWRPT_INIT_VALUE && !isset($_SESSION['sv_deals_details->dealer'])) {
				$bSetupFilter = TRUE;
			}

			// Field date_start
			if ($this->GetDropDownValue($deals_details->date_start->DropDownValue, 'date_start')) {
				$bSetupFilter = TRUE;
				$bRestoreSession = FALSE;
			} elseif ($deals_details->date_start->DropDownValue <> EWRPT_INIT_VALUE && !isset($_SESSION['sv_deals_details->date_start'])) {
				$bSetupFilter = TRUE;
			}

			// Field status
			if ($this->GetDropDownValue($deals_details->status->DropDownValue, 'status')) {
				$bSetupFilter = TRUE;
				$bRestoreSession = FALSE;
			} elseif ($deals_details->status->DropDownValue <> EWRPT_INIT_VALUE && !isset($_SESSION['sv_deals_details->status'])) {
				$bSetupFilter = TRUE;
			}
			if (!$this->ValidateForm()) {
				$this->setMessage($gsFormError);
				return $sFilter;
			}
		}

		// Restore session
		if ($bRestoreSession) {

			// Field dealer
			$this->GetSessionDropDownValue($deals_details->dealer);

			// Field date_start
			$this->GetSessionDropDownValue($deals_details->date_start);

			// Field status
			$this->GetSessionDropDownValue($deals_details->status);
		}

		// Call page filter validated event
		$deals_details->Page_FilterValidated();

		// Build SQL
		// Field dealer

		ewrpt_BuildDropDownFilter($deals_details->dealer, $sFilter, "");

		// Field date_start
		ewrpt_BuildDropDownFilter($deals_details->date_start, $sFilter, $deals_details->date_start->DateFilter);

		// Field status
		ewrpt_BuildDropDownFilter($deals_details->status, $sFilter, "");

		// Save parms to session
		// Field dealer

		$this->SetSessionDropDownValue($deals_details->dealer->DropDownValue, 'dealer');

		// Field date_start
		$this->SetSessionDropDownValue($deals_details->date_start->DropDownValue, 'date_start');

		// Field status
		$this->SetSessionDropDownValue($deals_details->status->DropDownValue, 'status');

		// Setup filter
		if ($bSetupFilter) {
		}
		return $sFilter;
	}

	// Get drop down value from querystring
	function GetDropDownValue(&$sv, $parm) {
		if (ewrpt_IsHttpPost())
			return FALSE; // Skip post back
		if (isset($_GET["sv_$parm"])) {
			$sv = ewrpt_StripSlashes($_GET["sv_$parm"]);
			return TRUE;
		}
		return FALSE;
	}

	// Get filter values from querystring
	function GetFilterValues(&$fld) {
		$parm = substr($fld->FldVar, 2);
		if (ewrpt_IsHttpPost())
			return; // Skip post back
		$got = FALSE;
		if (isset($_GET["sv1_$parm"])) {
			$fld->SearchValue = ewrpt_StripSlashes($_GET["sv1_$parm"]);
			$got = TRUE;
		}
		if (isset($_GET["so1_$parm"])) {
			$fld->SearchOperator = ewrpt_StripSlashes($_GET["so1_$parm"]);
			$got = TRUE;
		}
		if (isset($_GET["sc_$parm"])) {
			$fld->SearchCondition = ewrpt_StripSlashes($_GET["sc_$parm"]);
			$got = TRUE;
		}
		if (isset($_GET["sv2_$parm"])) {
			$fld->SearchValue2 = ewrpt_StripSlashes($_GET["sv2_$parm"]);
			$got = TRUE;
		}
		if (isset($_GET["so2_$parm"])) {
			$fld->SearchOperator2 = ewrpt_StripSlashes($_GET["so2_$parm"]);
			$got = TRUE;
		}
		return $got;
	}

	// Set default ext filter
	function SetDefaultExtFilter(&$fld, $so1, $sv1, $sc, $so2, $sv2) {
		$fld->DefaultSearchValue = $sv1; // Default ext filter value 1
		$fld->DefaultSearchValue2 = $sv2; // Default ext filter value 2 (if operator 2 is enabled)
		$fld->DefaultSearchOperator = $so1; // Default search operator 1
		$fld->DefaultSearchOperator2 = $so2; // Default search operator 2 (if operator 2 is enabled)
		$fld->DefaultSearchCondition = $sc; // Default search condition (if operator 2 is enabled)
	}

	// Apply default ext filter
	function ApplyDefaultExtFilter(&$fld) {
		$fld->SearchValue = $fld->DefaultSearchValue;
		$fld->SearchValue2 = $fld->DefaultSearchValue2;
		$fld->SearchOperator = $fld->DefaultSearchOperator;
		$fld->SearchOperator2 = $fld->DefaultSearchOperator2;
		$fld->SearchCondition = $fld->DefaultSearchCondition;
	}

	// Check if Text Filter applied
	function TextFilterApplied(&$fld) {
		return (strval($fld->SearchValue) <> strval($fld->DefaultSearchValue) ||
			strval($fld->SearchValue2) <> strval($fld->DefaultSearchValue2) ||
			(strval($fld->SearchValue) <> "" &&
				strval($fld->SearchOperator) <> strval($fld->DefaultSearchOperator)) ||
			(strval($fld->SearchValue2) <> "" &&
				strval($fld->SearchOperator2) <> strval($fld->DefaultSearchOperator2)) ||
			strval($fld->SearchCondition) <> strval($fld->DefaultSearchCondition));
	}

	// Check if Non-Text Filter applied
	function NonTextFilterApplied(&$fld) {
		if (is_array($fld->DefaultDropDownValue) && is_array($fld->DropDownValue)) {
			if (count($fld->DefaultDropDownValue) <> count($fld->DropDownValue))
				return TRUE;
			else
				return (count(array_diff($fld->DefaultDropDownValue, $fld->DropDownValue)) <> 0);
		}
		else {
			$v1 = strval($fld->DefaultDropDownValue);
			if ($v1 == EWRPT_INIT_VALUE)
				$v1 = "";
			$v2 = strval($fld->DropDownValue);
			if ($v2 == EWRPT_INIT_VALUE || $v2 == EWRPT_ALL_VALUE)
				$v2 = "";
			return ($v1 <> $v2);
		}
	}

	// Get dropdown value from session
	function GetSessionDropDownValue(&$fld) {
		$parm = substr($fld->FldVar, 2);
		$this->GetSessionValue($fld->DropDownValue, 'sv_deals_details_' . $parm);
	}

	// Get filter values from session
	function GetSessionFilterValues(&$fld) {
		$parm = substr($fld->FldVar, 2);
		$this->GetSessionValue($fld->SearchValue, 'sv1_deals_details_' . $parm);
		$this->GetSessionValue($fld->SearchOperator, 'so1_deals_details_' . $parm);
		$this->GetSessionValue($fld->SearchCondition, 'sc_deals_details_' . $parm);
		$this->GetSessionValue($fld->SearchValue2, 'sv2_deals_details_' . $parm);
		$this->GetSessionValue($fld->SearchOperator2, 'so2_deals_details_' . $parm);
	}

	// Get value from session
	function GetSessionValue(&$sv, $sn) {
		if (isset($_SESSION[$sn]))
			$sv = $_SESSION[$sn];
	}

	// Set dropdown value to session
	function SetSessionDropDownValue($sv, $parm) {
		$_SESSION['sv_deals_details_' . $parm] = $sv;
	}

	// Set filter values to session
	function SetSessionFilterValues($sv1, $so1, $sc, $sv2, $so2, $parm) {
		$_SESSION['sv1_deals_details_' . $parm] = $sv1;
		$_SESSION['so1_deals_details_' . $parm] = $so1;
		$_SESSION['sc_deals_details_' . $parm] = $sc;
		$_SESSION['sv2_deals_details_' . $parm] = $sv2;
		$_SESSION['so2_deals_details_' . $parm] = $so2;
	}

	// Check if has Session filter values
	function HasSessionFilterValues($parm) {
		return ((@$_SESSION['sv_' . $parm] <> "" && @$_SESSION['sv_' . $parm] <> EWRPT_INIT_VALUE) ||
			(@$_SESSION['sv1_' . $parm] <> "" && @$_SESSION['sv1_' . $parm] <> EWRPT_INIT_VALUE) ||
			(@$_SESSION['sv2_' . $parm] <> "" && @$_SESSION['sv2_' . $parm] <> EWRPT_INIT_VALUE));
	}

	// Dropdown filter exist
	function DropDownFilterExist(&$fld, $FldOpr) {
		$sWrk = "";
		ewrpt_BuildDropDownFilter($fld, $sWrk, $FldOpr);
		return ($sWrk <> "");
	}

	// Extended filter exist
	function ExtendedFilterExist(&$fld) {
		$sExtWrk = "";
		ewrpt_BuildExtendedFilter($fld, $sExtWrk);
		return ($sExtWrk <> "");
	}

	// Validate form
	function ValidateForm() {
		global $ReportLanguage, $gsFormError, $deals_details;

		// Initialize form error message
		$gsFormError = "";

		// Check if validation required
		if (!EWRPT_SERVER_VALIDATE)
			return ($gsFormError == "");

		// Return validate result
		$ValidateForm = ($gsFormError == "");

		// Call Form_CustomValidate event
		$sFormCustomError = "";
		$ValidateForm = $ValidateForm && $this->Form_CustomValidate($sFormCustomError);
		if ($sFormCustomError <> "") {
			$gsFormError .= ($gsFormError <> "") ? "<br>" : "";
			$gsFormError .= $sFormCustomError;
		}
		return $ValidateForm;
	}

	// Clear selection stored in session
	function ClearSessionSelection($parm) {
		$_SESSION["sel_deals_details_$parm"] = "";
		$_SESSION["rf_deals_details_$parm"] = "";
		$_SESSION["rt_deals_details_$parm"] = "";
	}

	// Load selection from session
	function LoadSelectionFromSession($parm) {
		global $deals_details;
		$fld =& $deals_details->fields($parm);
		$fld->SelectionList = @$_SESSION["sel_deals_details_$parm"];
		$fld->RangeFrom = @$_SESSION["rf_deals_details_$parm"];
		$fld->RangeTo = @$_SESSION["rt_deals_details_$parm"];
	}

	// Load default value for filters
	function LoadDefaultFilters() {
		global $deals_details;

		/**
		* Set up default values for non Text filters
		*/

		// Field dealer
		$deals_details->dealer->DefaultDropDownValue = EWRPT_INIT_VALUE;
		$deals_details->dealer->DropDownValue = $deals_details->dealer->DefaultDropDownValue;

		// Field date_start
		$deals_details->date_start->DefaultDropDownValue = EWRPT_INIT_VALUE;
		$deals_details->date_start->DropDownValue = $deals_details->date_start->DefaultDropDownValue;

		// Field status
		$deals_details->status->DefaultDropDownValue = EWRPT_INIT_VALUE;
		$deals_details->status->DropDownValue = $deals_details->status->DefaultDropDownValue;

		/**
		* Set up default values for extended filters
		* function SetDefaultExtFilter(&$fld, $so1, $sv1, $sc, $so2, $sv2)
		* Parameters:
		* $fld - Field object
		* $so1 - Default search operator 1
		* $sv1 - Default ext filter value 1
		* $sc - Default search condition (if operator 2 is enabled)
		* $so2 - Default search operator 2 (if operator 2 is enabled)
		* $sv2 - Default ext filter value 2 (if operator 2 is enabled)
		*/

		/**
		* Set up default values for popup filters
		*/
	}

	// Check if filter applied
	function CheckFilter() {
		global $deals_details;

		// Check dealer extended filter
		if ($this->NonTextFilterApplied($deals_details->dealer))
			return TRUE;

		// Check date_start extended filter
		if ($this->NonTextFilterApplied($deals_details->date_start))
			return TRUE;

		// Check status extended filter
		if ($this->NonTextFilterApplied($deals_details->status))
			return TRUE;
		return FALSE;
	}

	// Show list of filters
	function ShowFilterList() {
		global $deals_details;
		global $ReportLanguage;

		// Initialize
		$sFilterList = "";

		// Field dealer
		$sExtWrk = "";
		$sWrk = "";
		ewrpt_BuildDropDownFilter($deals_details->dealer, $sExtWrk, "");
		if ($sExtWrk <> "" || $sWrk <> "")
			$sFilterList .= $deals_details->dealer->FldCaption() . "<br>";
		if ($sExtWrk <> "")
			$sFilterList .= "&nbsp;&nbsp;$sExtWrk<br>";
		if ($sWrk <> "")
			$sFilterList .= "&nbsp;&nbsp;$sWrk<br>";

		// Field date_start
		$sExtWrk = "";
		$sWrk = "";
		ewrpt_BuildDropDownFilter($deals_details->date_start, $sExtWrk, $deals_details->date_start->DateFilter);
		if ($sExtWrk <> "" || $sWrk <> "")
			$sFilterList .= $deals_details->date_start->FldCaption() . "<br>";
		if ($sExtWrk <> "")
			$sFilterList .= "&nbsp;&nbsp;$sExtWrk<br>";
		if ($sWrk <> "")
			$sFilterList .= "&nbsp;&nbsp;$sWrk<br>";

		// Field status
		$sExtWrk = "";
		$sWrk = "";
		ewrpt_BuildDropDownFilter($deals_details->status, $sExtWrk, "");
		if ($sExtWrk <> "" || $sWrk <> "")
			$sFilterList .= $deals_details->status->FldCaption() . "<br>";
		if ($sExtWrk <> "")
			$sFilterList .= "&nbsp;&nbsp;$sExtWrk<br>";
		if ($sWrk <> "")
			$sFilterList .= "&nbsp;&nbsp;$sWrk<br>";

		// Show Filters
		if ($sFilterList <> "")
			echo $ReportLanguage->Phrase("CurrentFilters") . "<br>$sFilterList";
	}

	// Return poup filter
	function GetPopupFilter() {
		global $deals_details;
		$sWrk = "";
		return $sWrk;
	}

	//-------------------------------------------------------------------------------
	// Function GetSort
	// - Return Sort parameters based on Sort Links clicked
	// - Variables setup: Session[EWRPT_TABLE_SESSION_ORDER_BY], Session["sort_Table_Field"]
	function GetSort() {
		global $deals_details;

		// Check for a resetsort command
		if (strlen(@$_GET["cmd"]) > 0) {
			$sCmd = @$_GET["cmd"];
			if ($sCmd == "resetsort") {
				$deals_details->setOrderBy("");
				$deals_details->setStartGroup(1);
				$deals_details->deal_number->setSort("");
				$deals_details->dealer->setSort("");
				$deals_details->date_start->setSort("");
				$deals_details->status->setSort("");
				$deals_details->salesman->setSort("");
				$deals_details->customer->setSort("");
				$deals_details->idno->setSort("");
				$deals_details->product_name->setSort("");
				$deals_details->rep2Etotal_premium_2D_rep2Ecommission->setSort("");
				$deals_details->Description->setSort("");
				$deals_details->RegistrationNumber->setSort("");
				$deals_details->Deposit->setSort("");
				$deals_details->PrincipalDebt->setSort("");
				$deals_details->FSPFees->setSort("");
				$deals_details->ServiceAndDelivery->setSort("");
				$deals_details->Vaps->setSort("");
				$deals_details->HandlingFees->setSort("");
			}

		// Check for an Order parameter
		} elseif (@$_GET["order"] <> "") {
			$deals_details->CurrentOrder = ewrpt_StripSlashes(@$_GET["order"]);
			$deals_details->CurrentOrderType = @$_GET["ordertype"];
			$sSortSql = $deals_details->SortSql();
			$deals_details->setOrderBy($sSortSql);
			$deals_details->setStartGroup(1);
		}
		return $deals_details->getOrderBy();
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
