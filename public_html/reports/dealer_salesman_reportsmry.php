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
$dealer_salesman_report = NULL;

//
// Table class for dealer_salesman_report
//
class crdealer_salesman_report {
	var $TableVar = 'dealer_salesman_report';
	var $TableName = 'dealer_salesman_report';
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
	var $Chart_Report;
	var $deal_number;
	var $Dealer;
	var $date_start;
	var $status;
	var $Code;
	var $salesman;
	var $customer;
	var $idno;
	var $quot_collection;
	var $quot_period;
	var $total_premium;
	var $commission;
	var $report_invoice2Etotal_premium_2D_report_invoice2Ecommission;
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
	function crdealer_salesman_report() {
		global $ReportLanguage;

		// deal_number
		$this->deal_number = new crField('dealer_salesman_report', 'dealer_salesman_report', 'x_deal_number', 'deal_number', 'report_invoice.deal_number', 3, EWRPT_DATATYPE_NUMBER, -1);
		$this->deal_number->FldDefaultErrMsg = $ReportLanguage->Phrase("IncorrectInteger");
		$this->fields['deal_number'] =& $this->deal_number;
		$this->deal_number->DateFilter = "";
		$this->deal_number->SqlSelect = "";
		$this->deal_number->SqlOrderBy = "";

		// Dealer
		$this->Dealer = new crField('dealer_salesman_report', 'dealer_salesman_report', 'x_Dealer', 'Dealer', 'report_invoice.dealer', 200, EWRPT_DATATYPE_STRING, -1);
		$this->fields['Dealer'] =& $this->Dealer;
		$this->Dealer->DateFilter = "";
		$this->Dealer->SqlSelect = "";
		$this->Dealer->SqlOrderBy = "";

		// date_start
		$this->date_start = new crField('dealer_salesman_report', 'dealer_salesman_report', 'x_date_start', 'date_start', 'report_invoice.date_start', 135, EWRPT_DATATYPE_DATE, 7);
		$this->date_start->FldDefaultErrMsg = str_replace("%s", "-", $ReportLanguage->Phrase("IncorrectDateYMD"));
		$this->fields['date_start'] =& $this->date_start;
		$this->date_start->DateFilter = "Month";
		$this->date_start->SqlSelect = "";
		$this->date_start->SqlOrderBy = "";
		ewrpt_RegisterFilter($this->date_start, "@@LastMonth", $ReportLanguage->Phrase("LastMonth"), "ewrpt_IsLastMonth");
		ewrpt_RegisterFilter($this->date_start, "@@ThisMonth", $ReportLanguage->Phrase("ThisMonth"), "ewrpt_IsThisMonth");
		ewrpt_RegisterFilter($this->date_start, "@@NextMonth", $ReportLanguage->Phrase("NextMonth"), "ewrpt_IsNextMonth");

		// status
		$this->status = new crField('dealer_salesman_report', 'dealer_salesman_report', 'x_status', 'status', 'report_invoice.status', 200, EWRPT_DATATYPE_STRING, -1);
		$this->fields['status'] =& $this->status;
		$this->status->DateFilter = "";
		$this->status->SqlSelect = "";
		$this->status->SqlOrderBy = "";

		// Code
		$this->Code = new crField('dealer_salesman_report', 'dealer_salesman_report', 'x_Code', 'Code', 'report_invoice.dealer_id', 3, EWRPT_DATATYPE_NUMBER, -1);
		$this->Code->FldDefaultErrMsg = $ReportLanguage->Phrase("IncorrectInteger");
		$this->fields['Code'] =& $this->Code;
		$this->Code->DateFilter = "";
		$this->Code->SqlSelect = "";
		$this->Code->SqlOrderBy = "";

		// salesman
		$this->salesman = new crField('dealer_salesman_report', 'dealer_salesman_report', 'x_salesman', 'salesman', 'report_invoice.salesman', 200, EWRPT_DATATYPE_STRING, -1);
		$this->fields['salesman'] =& $this->salesman;
		$this->salesman->DateFilter = "";
		$this->salesman->SqlSelect = "";
		$this->salesman->SqlOrderBy = "";

		// customer
		$this->customer = new crField('dealer_salesman_report', 'dealer_salesman_report', 'x_customer', 'customer', 'report_invoice.customer', 200, EWRPT_DATATYPE_STRING, -1);
		$this->fields['customer'] =& $this->customer;
		$this->customer->DateFilter = "";
		$this->customer->SqlSelect = "";
		$this->customer->SqlOrderBy = "";

		// idno
		$this->idno = new crField('dealer_salesman_report', 'dealer_salesman_report', 'x_idno', 'idno', 'report_invoice.idno', 200, EWRPT_DATATYPE_STRING, -1);
		$this->fields['idno'] =& $this->idno;
		$this->idno->DateFilter = "";
		$this->idno->SqlSelect = "";
		$this->idno->SqlOrderBy = "";

		// quot_collection
		$this->quot_collection = new crField('dealer_salesman_report', 'dealer_salesman_report', 'x_quot_collection', 'quot_collection', 'report_invoice.quot_collection', 200, EWRPT_DATATYPE_STRING, -1);
		$this->fields['quot_collection'] =& $this->quot_collection;
		$this->quot_collection->DateFilter = "";
		$this->quot_collection->SqlSelect = "";
		$this->quot_collection->SqlOrderBy = "";

		// quot_period
		$this->quot_period = new crField('dealer_salesman_report', 'dealer_salesman_report', 'x_quot_period', 'quot_period', 'report_invoice.quot_period', 200, EWRPT_DATATYPE_STRING, -1);
		$this->fields['quot_period'] =& $this->quot_period;
		$this->quot_period->DateFilter = "";
		$this->quot_period->SqlSelect = "";
		$this->quot_period->SqlOrderBy = "";

		// total_premium
		$this->total_premium = new crField('dealer_salesman_report', 'dealer_salesman_report', 'x_total_premium', 'total_premium', 'report_invoice.total_premium', 5, EWRPT_DATATYPE_NUMBER, -1);
		$this->total_premium->FldDefaultErrMsg = $ReportLanguage->Phrase("IncorrectFloat");
		$this->fields['total_premium'] =& $this->total_premium;
		$this->total_premium->DateFilter = "";
		$this->total_premium->SqlSelect = "";
		$this->total_premium->SqlOrderBy = "";

		// commission
		$this->commission = new crField('dealer_salesman_report', 'dealer_salesman_report', 'x_commission', 'commission', 'report_invoice.commission', 5, EWRPT_DATATYPE_NUMBER, -1);
		$this->commission->FldDefaultErrMsg = $ReportLanguage->Phrase("IncorrectFloat");
		$this->fields['commission'] =& $this->commission;
		$this->commission->DateFilter = "";
		$this->commission->SqlSelect = "";
		$this->commission->SqlOrderBy = "";

		// report_invoice.total_premium - report_invoice.commission
		$this->report_invoice2Etotal_premium_2D_report_invoice2Ecommission = new crField('dealer_salesman_report', 'dealer_salesman_report', 'x_report_invoice2Etotal_premium_2D_report_invoice2Ecommission', 'report_invoice.total_premium - report_invoice.commission', '`report_invoice.total_premium - report_invoice.commission`', 5, EWRPT_DATATYPE_NUMBER, -1);
		$this->report_invoice2Etotal_premium_2D_report_invoice2Ecommission->FldDefaultErrMsg = $ReportLanguage->Phrase("IncorrectFloat");
		$this->fields['report_invoice2Etotal_premium_2D_report_invoice2Ecommission'] =& $this->report_invoice2Etotal_premium_2D_report_invoice2Ecommission;
		$this->report_invoice2Etotal_premium_2D_report_invoice2Ecommission->DateFilter = "";
		$this->report_invoice2Etotal_premium_2D_report_invoice2Ecommission->SqlSelect = "";
		$this->report_invoice2Etotal_premium_2D_report_invoice2Ecommission->SqlOrderBy = "";

		// Chart Report
		$this->Chart_Report = new crChart('dealer_salesman_report', 'dealer_salesman_report', 'Chart_Report', 'Chart Report', 'Dealer', 'total_premium', '', 9, 'SUM', 1200, 800);
		$this->Chart_Report->SqlSelect = "SELECT `Dealer`, '', SUM(`total_premium`), SUM(`commission`), SUM(`report_invoice.total_premium - report_invoice.commission`) FROM ";
		$this->Chart_Report->SqlGroupBy = "`Dealer`";
		$this->Chart_Report->SqlOrderBy = "";
		$this->Chart_Report->SeriesDateType = "";
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
		return "report_invoice";
	}

	function SqlSelect() { // Select
		return "SELECT report_invoice.deal_number, report_invoice.dealer As Dealer, report_invoice.dealer_id As Code, report_invoice.salesman, report_invoice.customer, report_invoice.idno, report_invoice.status, report_invoice.quot_period, report_invoice.quot_collection, report_invoice.total_premium, report_invoice.commission, report_invoice.total_premium - report_invoice.commission, report_invoice.date_start FROM " . $this->SqlFrom();
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
$dealer_salesman_report_summary = new crdealer_salesman_report_summary();
$Page =& $dealer_salesman_report_summary;

// Page init
$dealer_salesman_report_summary->Page_Init();

// Page main
$dealer_salesman_report_summary->Page_Main();
?>
<?php include_once "phprptinc/header.php"; ?>
<?php if ($dealer_salesman_report->Export == "" || $dealer_salesman_report->Export == "print" || $dealer_salesman_report->Export == "email") { ?>
<script type="text/javascript">

// Create page object
var dealer_salesman_report_summary = new ewrpt_Page("dealer_salesman_report_summary");

// page properties
dealer_salesman_report_summary.PageID = "summary"; // page ID
dealer_salesman_report_summary.FormID = "fdealer_salesman_reportsummaryfilter"; // form ID
var EWRPT_PAGE_ID = dealer_salesman_report_summary.PageID;

// extend page with Chart_Rendering function
dealer_salesman_report_summary.Chart_Rendering =  
 function(chart, chartid) { // DO NOT CHANGE THIS LINE!

 	//alert(chartid);
 }

// extend page with Chart_Rendered function
dealer_salesman_report_summary.Chart_Rendered =  
 function(chart, chartid) { // DO NOT CHANGE THIS LINE!

 	//alert(chartid);
 }
</script>
<?php } ?>
<?php if ($dealer_salesman_report->Export == "") { ?>
<script type="text/javascript">

// extend page with ValidateForm function
dealer_salesman_report_summary.ValidateForm = function(fobj) {
	if (!this.ValidateRequired)
		return true; // ignore validation

	// Call Form Custom Validate event
	if (!this.Form_CustomValidate(fobj)) return false;
	return true;
}

// extend page with Form_CustomValidate function
dealer_salesman_report_summary.Form_CustomValidate =  
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }
<?php if (EWRPT_CLIENT_VALIDATE) { ?>
dealer_salesman_report_summary.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
dealer_salesman_report_summary.ValidateRequired = false; // no JavaScript validation
<?php } ?>
</script>
<script language="JavaScript" type="text/javascript">
<!--

// Write your client script here, no need to add script tags.
//-->

</script>
<?php } ?>
<?php if ($dealer_salesman_report->Export == "" || $dealer_salesman_report->Export == "print" || $dealer_salesman_report->Export == "email") { ?>
<script src="<?php echo EWRPT_FUSIONCHARTS_FREE_JSCLASS_FILE; ?>" type="text/javascript"></script>
<?php } ?>
<?php if ($dealer_salesman_report->Export == "") { ?>
<div id="ewrpt_PopupFilter"><div class="bd"></div></div>
<script src="phprptjs/ewrptpop.js" type="text/javascript"></script>
<script type="text/javascript">

// popup fields
</script>
<?php } ?>
<?php if ($dealer_salesman_report->Export == "" || $dealer_salesman_report->Export == "print" || $dealer_salesman_report->Export == "email") { ?>
<!-- Table Container (Begin) -->
<table id="ewContainer" cellspacing="0" cellpadding="0" border="0">
<!-- Top Container (Begin) -->
<tr><td colspan="3"><div id="ewTop" class="phpreportmaker">
<!-- top slot -->
<a name="top"></a>
<?php } ?>
<p class="phpreportmaker ewTitle"><?php echo $dealer_salesman_report->TableCaption() ?>
&nbsp;&nbsp;<?php $dealer_salesman_report_summary->ExportOptions->Render("body"); ?></p>
<?php $dealer_salesman_report_summary->ShowPageHeader(); ?>
<?php $dealer_salesman_report_summary->ShowMessage(); ?>
<br><br>
<?php if ($dealer_salesman_report->Export == "" || $dealer_salesman_report->Export == "print" || $dealer_salesman_report->Export == "email") { ?>
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
<?php if ($dealer_salesman_report->Export == "") { ?>
<?php
if ($dealer_salesman_report->FilterPanelOption == 2 || ($dealer_salesman_report->FilterPanelOption == 3 && $dealer_salesman_report_summary->FilterApplied) || $dealer_salesman_report_summary->Filter == "0=101") {
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
<form name="fdealer_salesman_reportsummaryfilter" id="fdealer_salesman_reportsummaryfilter" action="<?php echo ewrpt_CurrentPage() ?>" class="ewForm" onsubmit="return dealer_salesman_report_summary.ValidateForm(this);">
<table class="ewRptExtFilter">
	<tr id="r_Dealer">
		<td><span class="phpreportmaker"><?php echo $dealer_salesman_report->Dealer->FldCaption() ?></span></td>
		<td></td>
		<td colspan="4"><span class="ewRptSearchOpr">
		<select name="sv_Dealer" id="sv_Dealer"<?php echo ($dealer_salesman_report_summary->ClearExtFilter == 'dealer_salesman_report_Dealer') ? " class=\"ewInputCleared\"" : "" ?>>
		<option value="<?php echo EWRPT_ALL_VALUE; ?>"<?php if (ewrpt_MatchedFilterValue($dealer_salesman_report->Dealer->DropDownValue, EWRPT_ALL_VALUE)) echo " selected=\"selected\""; ?>><?php echo $ReportLanguage->Phrase("PleaseSelect"); ?></option>
<?php

// Popup filter
$cntf = is_array($dealer_salesman_report->Dealer->AdvancedFilters) ? count($dealer_salesman_report->Dealer->AdvancedFilters) : 0;
$cntd = is_array($dealer_salesman_report->Dealer->DropDownList) ? count($dealer_salesman_report->Dealer->DropDownList) : 0;
$totcnt = $cntf + $cntd;
$wrkcnt = 0;
	if ($cntf > 0) {
		foreach ($dealer_salesman_report->Dealer->AdvancedFilters as $filter) {
			if ($filter->Enabled) {
?>
		<option value="<?php echo $filter->ID ?>"<?php if (ewrpt_MatchedFilterValue($dealer_salesman_report->Dealer->DropDownValue, $filter->ID)) echo " selected=\"selected\"" ?>><?php echo $filter->Name ?></option>
<?php
				$wrkcnt += 1;
			}
		}
	}
	for ($i = 0; $i < $cntd; $i++) {
?>
		<option value="<?php echo $dealer_salesman_report->Dealer->DropDownList[$i] ?>"<?php if (ewrpt_MatchedFilterValue($dealer_salesman_report->Dealer->DropDownValue, $dealer_salesman_report->Dealer->DropDownList[$i])) echo " selected=\"selected\"" ?>><?php echo ewrpt_DropDownDisplayValue($dealer_salesman_report->Dealer->DropDownList[$i], "", 0) ?></option>
<?php
		$wrkcnt += 1;
	}
?>
		</select>
		</span></td>
	</tr>
	<tr id="r_date_start">
		<td><span class="phpreportmaker"><?php echo $dealer_salesman_report->date_start->FldCaption() ?></span></td>
		<td></td>
		<td colspan="4"><span class="ewRptSearchOpr">
		<select name="sv_date_start" id="sv_date_start"<?php echo ($dealer_salesman_report_summary->ClearExtFilter == 'dealer_salesman_report_date_start') ? " class=\"ewInputCleared\"" : "" ?>>
		<option value="<?php echo EWRPT_ALL_VALUE; ?>"<?php if (ewrpt_MatchedFilterValue($dealer_salesman_report->date_start->DropDownValue, EWRPT_ALL_VALUE)) echo " selected=\"selected\""; ?>><?php echo $ReportLanguage->Phrase("PleaseSelect"); ?></option>
<?php

// Popup filter
$cntf = is_array($dealer_salesman_report->date_start->AdvancedFilters) ? count($dealer_salesman_report->date_start->AdvancedFilters) : 0;
$cntd = is_array($dealer_salesman_report->date_start->DropDownList) ? count($dealer_salesman_report->date_start->DropDownList) : 0;
$totcnt = $cntf + $cntd;
$wrkcnt = 0;
	if ($cntf > 0) {
		foreach ($dealer_salesman_report->date_start->AdvancedFilters as $filter) {
			if ($filter->Enabled) {
?>
		<option value="<?php echo $filter->ID ?>"<?php if (ewrpt_MatchedFilterValue($dealer_salesman_report->date_start->DropDownValue, $filter->ID)) echo " selected=\"selected\"" ?>><?php echo $filter->Name ?></option>
<?php
				$wrkcnt += 1;
			}
		}
	}
	for ($i = 0; $i < $cntd; $i++) {
?>
		<option value="<?php echo $dealer_salesman_report->date_start->DropDownList[$i] ?>"<?php if (ewrpt_MatchedFilterValue($dealer_salesman_report->date_start->DropDownValue, $dealer_salesman_report->date_start->DropDownList[$i])) echo " selected=\"selected\"" ?>><?php echo ewrpt_DropDownDisplayValue($dealer_salesman_report->date_start->DropDownList[$i], $dealer_salesman_report->date_start->DateFilter, 7) ?></option>
<?php
		$wrkcnt += 1;
	}
?>
		</select>
		</span></td>
	</tr>
	<tr id="r_status">
		<td><span class="phpreportmaker"><?php echo $dealer_salesman_report->status->FldCaption() ?></span></td>
		<td></td>
		<td colspan="4"><span class="ewRptSearchOpr">
		<select name="sv_status" id="sv_status"<?php echo ($dealer_salesman_report_summary->ClearExtFilter == 'dealer_salesman_report_status') ? " class=\"ewInputCleared\"" : "" ?>>
		<option value="<?php echo EWRPT_ALL_VALUE; ?>"<?php if (ewrpt_MatchedFilterValue($dealer_salesman_report->status->DropDownValue, EWRPT_ALL_VALUE)) echo " selected=\"selected\""; ?>><?php echo $ReportLanguage->Phrase("PleaseSelect"); ?></option>
<?php

// Popup filter
$cntf = is_array($dealer_salesman_report->status->AdvancedFilters) ? count($dealer_salesman_report->status->AdvancedFilters) : 0;
$cntd = is_array($dealer_salesman_report->status->DropDownList) ? count($dealer_salesman_report->status->DropDownList) : 0;
$totcnt = $cntf + $cntd;
$wrkcnt = 0;
	if ($cntf > 0) {
		foreach ($dealer_salesman_report->status->AdvancedFilters as $filter) {
			if ($filter->Enabled) {
?>
		<option value="<?php echo $filter->ID ?>"<?php if (ewrpt_MatchedFilterValue($dealer_salesman_report->status->DropDownValue, $filter->ID)) echo " selected=\"selected\"" ?>><?php echo $filter->Name ?></option>
<?php
				$wrkcnt += 1;
			}
		}
	}
	for ($i = 0; $i < $cntd; $i++) {
?>
		<option value="<?php echo $dealer_salesman_report->status->DropDownList[$i] ?>"<?php if (ewrpt_MatchedFilterValue($dealer_salesman_report->status->DropDownValue, $dealer_salesman_report->status->DropDownList[$i])) echo " selected=\"selected\"" ?>><?php echo ewrpt_DropDownDisplayValue($dealer_salesman_report->status->DropDownList[$i], "", 0) ?></option>
<?php
		$wrkcnt += 1;
	}
?>
		</select>
		</span></td>
	</tr>
	<tr id="r_salesman">
		<td><span class="phpreportmaker"><?php echo $dealer_salesman_report->salesman->FldCaption() ?></span></td>
		<td></td>
		<td colspan="4"><span class="ewRptSearchOpr">
		<select name="sv_salesman" id="sv_salesman"<?php echo ($dealer_salesman_report_summary->ClearExtFilter == 'dealer_salesman_report_salesman') ? " class=\"ewInputCleared\"" : "" ?>>
		<option value="<?php echo EWRPT_ALL_VALUE; ?>"<?php if (ewrpt_MatchedFilterValue($dealer_salesman_report->salesman->DropDownValue, EWRPT_ALL_VALUE)) echo " selected=\"selected\""; ?>><?php echo $ReportLanguage->Phrase("PleaseSelect"); ?></option>
<?php

// Popup filter
$cntf = is_array($dealer_salesman_report->salesman->AdvancedFilters) ? count($dealer_salesman_report->salesman->AdvancedFilters) : 0;
$cntd = is_array($dealer_salesman_report->salesman->DropDownList) ? count($dealer_salesman_report->salesman->DropDownList) : 0;
$totcnt = $cntf + $cntd;
$wrkcnt = 0;
	if ($cntf > 0) {
		foreach ($dealer_salesman_report->salesman->AdvancedFilters as $filter) {
			if ($filter->Enabled) {
?>
		<option value="<?php echo $filter->ID ?>"<?php if (ewrpt_MatchedFilterValue($dealer_salesman_report->salesman->DropDownValue, $filter->ID)) echo " selected=\"selected\"" ?>><?php echo $filter->Name ?></option>
<?php
				$wrkcnt += 1;
			}
		}
	}
	for ($i = 0; $i < $cntd; $i++) {
?>
		<option value="<?php echo $dealer_salesman_report->salesman->DropDownList[$i] ?>"<?php if (ewrpt_MatchedFilterValue($dealer_salesman_report->salesman->DropDownValue, $dealer_salesman_report->salesman->DropDownList[$i])) echo " selected=\"selected\"" ?>><?php echo ewrpt_DropDownDisplayValue($dealer_salesman_report->salesman->DropDownList[$i], "", 0) ?></option>
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
<?php if ($dealer_salesman_report->ShowCurrentFilter) { ?>
<div id="ewrptFilterList">
<?php $dealer_salesman_report_summary->ShowFilterList() ?>
</div>
<br>
<?php } ?>
<table class="ewGrid" cellspacing="0"><tr>
	<td class="ewGridContent">
<!-- Report Grid (Begin) -->
<div class="ewGridMiddlePanel">
<table class="<?php echo $dealer_salesman_report_summary->ReportTableClass ?>" cellspacing="0">
<?php

// Set the last group to display if not export all
if ($dealer_salesman_report->ExportAll && $dealer_salesman_report->Export <> "") {
	$dealer_salesman_report_summary->StopGrp = $dealer_salesman_report_summary->TotalGrps;
} else {
	$dealer_salesman_report_summary->StopGrp = $dealer_salesman_report_summary->StartGrp + $dealer_salesman_report_summary->DisplayGrps - 1;
}

// Stop group <= total number of groups
if (intval($dealer_salesman_report_summary->StopGrp) > intval($dealer_salesman_report_summary->TotalGrps))
	$dealer_salesman_report_summary->StopGrp = $dealer_salesman_report_summary->TotalGrps;
$dealer_salesman_report_summary->RecCount = 0;

// Get first row
if ($dealer_salesman_report_summary->TotalGrps > 0) {
	$dealer_salesman_report_summary->GetRow(1);
	$dealer_salesman_report_summary->GrpCount = 1;
}
while (($rs && !$rs->EOF && $dealer_salesman_report_summary->GrpCount <= $dealer_salesman_report_summary->DisplayGrps) || $dealer_salesman_report_summary->ShowFirstHeader) {

	// Show header
	if ($dealer_salesman_report_summary->ShowFirstHeader) {
?>
	<thead>
	<tr>
<td class="ewTableHeader">
<?php if ($dealer_salesman_report->Export <> "") { ?>
<?php echo $dealer_salesman_report->deal_number->FldCaption() ?>
<?php } else { ?>
	<table cellspacing="0" class="ewTableHeaderBtn"><tr>
<?php if ($dealer_salesman_report->SortUrl($dealer_salesman_report->deal_number) == "") { ?>
		<td style="vertical-align: bottom;"><?php echo $dealer_salesman_report->deal_number->FldCaption() ?></td>
<?php } else { ?>
		<td class="ewPointer" onmousedown="ewrpt_Sort(event,'<?php echo $dealer_salesman_report->SortUrl($dealer_salesman_report->deal_number) ?>',0);"><?php echo $dealer_salesman_report->deal_number->FldCaption() ?></td><td style="width: 10px;">
		<?php if ($dealer_salesman_report->deal_number->getSort() == "ASC") { ?><img src="phprptimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($dealer_salesman_report->deal_number->getSort() == "DESC") { ?><img src="phprptimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td>
<?php } ?>
	</tr></table>
<?php } ?>
</td>
<td class="ewTableHeader">
<?php if ($dealer_salesman_report->Export <> "") { ?>
<?php echo $dealer_salesman_report->Dealer->FldCaption() ?>
<?php } else { ?>
	<table cellspacing="0" class="ewTableHeaderBtn" style="white-space: nowrap;"><tr>
<?php if ($dealer_salesman_report->SortUrl($dealer_salesman_report->Dealer) == "") { ?>
		<td style="vertical-align: bottom;"><?php echo $dealer_salesman_report->Dealer->FldCaption() ?></td>
<?php } else { ?>
		<td class="ewPointer" onmousedown="ewrpt_Sort(event,'<?php echo $dealer_salesman_report->SortUrl($dealer_salesman_report->Dealer) ?>',0);"><?php echo $dealer_salesman_report->Dealer->FldCaption() ?></td><td style="width: 10px;">
		<?php if ($dealer_salesman_report->Dealer->getSort() == "ASC") { ?><img src="phprptimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($dealer_salesman_report->Dealer->getSort() == "DESC") { ?><img src="phprptimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td>
<?php } ?>
	</tr></table>
<?php } ?>
</td>
<td class="ewTableHeader">
<?php if ($dealer_salesman_report->Export <> "") { ?>
<?php echo $dealer_salesman_report->date_start->FldCaption() ?>
<?php } else { ?>
	<table cellspacing="0" class="ewTableHeaderBtn" style="white-space: nowrap;"><tr>
<?php if ($dealer_salesman_report->SortUrl($dealer_salesman_report->date_start) == "") { ?>
		<td style="vertical-align: bottom;"><?php echo $dealer_salesman_report->date_start->FldCaption() ?></td>
<?php } else { ?>
		<td class="ewPointer" onmousedown="ewrpt_Sort(event,'<?php echo $dealer_salesman_report->SortUrl($dealer_salesman_report->date_start) ?>',0);"><?php echo $dealer_salesman_report->date_start->FldCaption() ?></td><td style="width: 10px;">
		<?php if ($dealer_salesman_report->date_start->getSort() == "ASC") { ?><img src="phprptimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($dealer_salesman_report->date_start->getSort() == "DESC") { ?><img src="phprptimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td>
<?php } ?>
	</tr></table>
<?php } ?>
</td>
<td class="ewTableHeader">
<?php if ($dealer_salesman_report->Export <> "") { ?>
<?php echo $dealer_salesman_report->status->FldCaption() ?>
<?php } else { ?>
	<table cellspacing="0" class="ewTableHeaderBtn" style="white-space: nowrap;"><tr>
<?php if ($dealer_salesman_report->SortUrl($dealer_salesman_report->status) == "") { ?>
		<td style="vertical-align: bottom;"><?php echo $dealer_salesman_report->status->FldCaption() ?></td>
<?php } else { ?>
		<td class="ewPointer" onmousedown="ewrpt_Sort(event,'<?php echo $dealer_salesman_report->SortUrl($dealer_salesman_report->status) ?>',0);"><?php echo $dealer_salesman_report->status->FldCaption() ?></td><td style="width: 10px;">
		<?php if ($dealer_salesman_report->status->getSort() == "ASC") { ?><img src="phprptimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($dealer_salesman_report->status->getSort() == "DESC") { ?><img src="phprptimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td>
<?php } ?>
	</tr></table>
<?php } ?>
</td>
<td class="ewTableHeader">
<?php if ($dealer_salesman_report->Export <> "") { ?>
<?php echo $dealer_salesman_report->salesman->FldCaption() ?>
<?php } else { ?>
	<table cellspacing="0" class="ewTableHeaderBtn"><tr>
<?php if ($dealer_salesman_report->SortUrl($dealer_salesman_report->salesman) == "") { ?>
		<td style="vertical-align: bottom;"><?php echo $dealer_salesman_report->salesman->FldCaption() ?></td>
<?php } else { ?>
		<td class="ewPointer" onmousedown="ewrpt_Sort(event,'<?php echo $dealer_salesman_report->SortUrl($dealer_salesman_report->salesman) ?>',0);"><?php echo $dealer_salesman_report->salesman->FldCaption() ?></td><td style="width: 10px;">
		<?php if ($dealer_salesman_report->salesman->getSort() == "ASC") { ?><img src="phprptimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($dealer_salesman_report->salesman->getSort() == "DESC") { ?><img src="phprptimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td>
<?php } ?>
	</tr></table>
<?php } ?>
</td>
<td class="ewTableHeader">
<?php if ($dealer_salesman_report->Export <> "") { ?>
<?php echo $dealer_salesman_report->customer->FldCaption() ?>
<?php } else { ?>
	<table cellspacing="0" class="ewTableHeaderBtn"><tr>
<?php if ($dealer_salesman_report->SortUrl($dealer_salesman_report->customer) == "") { ?>
		<td style="vertical-align: bottom;"><?php echo $dealer_salesman_report->customer->FldCaption() ?></td>
<?php } else { ?>
		<td class="ewPointer" onmousedown="ewrpt_Sort(event,'<?php echo $dealer_salesman_report->SortUrl($dealer_salesman_report->customer) ?>',0);"><?php echo $dealer_salesman_report->customer->FldCaption() ?></td><td style="width: 10px;">
		<?php if ($dealer_salesman_report->customer->getSort() == "ASC") { ?><img src="phprptimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($dealer_salesman_report->customer->getSort() == "DESC") { ?><img src="phprptimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td>
<?php } ?>
	</tr></table>
<?php } ?>
</td>
<td class="ewTableHeader">
<?php if ($dealer_salesman_report->Export <> "") { ?>
<?php echo $dealer_salesman_report->idno->FldCaption() ?>
<?php } else { ?>
	<table cellspacing="0" class="ewTableHeaderBtn"><tr>
<?php if ($dealer_salesman_report->SortUrl($dealer_salesman_report->idno) == "") { ?>
		<td style="vertical-align: bottom;"><?php echo $dealer_salesman_report->idno->FldCaption() ?></td>
<?php } else { ?>
		<td class="ewPointer" onmousedown="ewrpt_Sort(event,'<?php echo $dealer_salesman_report->SortUrl($dealer_salesman_report->idno) ?>',0);"><?php echo $dealer_salesman_report->idno->FldCaption() ?></td><td style="width: 10px;">
		<?php if ($dealer_salesman_report->idno->getSort() == "ASC") { ?><img src="phprptimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($dealer_salesman_report->idno->getSort() == "DESC") { ?><img src="phprptimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td>
<?php } ?>
	</tr></table>
<?php } ?>
</td>
<td class="ewTableHeader">
<?php if ($dealer_salesman_report->Export <> "") { ?>
<?php echo $dealer_salesman_report->quot_collection->FldCaption() ?>
<?php } else { ?>
	<table cellspacing="0" class="ewTableHeaderBtn"><tr>
<?php if ($dealer_salesman_report->SortUrl($dealer_salesman_report->quot_collection) == "") { ?>
		<td style="vertical-align: bottom;"><?php echo $dealer_salesman_report->quot_collection->FldCaption() ?></td>
<?php } else { ?>
		<td class="ewPointer" onmousedown="ewrpt_Sort(event,'<?php echo $dealer_salesman_report->SortUrl($dealer_salesman_report->quot_collection) ?>',0);"><?php echo $dealer_salesman_report->quot_collection->FldCaption() ?></td><td style="width: 10px;">
		<?php if ($dealer_salesman_report->quot_collection->getSort() == "ASC") { ?><img src="phprptimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($dealer_salesman_report->quot_collection->getSort() == "DESC") { ?><img src="phprptimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td>
<?php } ?>
	</tr></table>
<?php } ?>
</td>
<td class="ewTableHeader">
<?php if ($dealer_salesman_report->Export <> "") { ?>
<?php echo $dealer_salesman_report->quot_period->FldCaption() ?>
<?php } else { ?>
	<table cellspacing="0" class="ewTableHeaderBtn"><tr>
<?php if ($dealer_salesman_report->SortUrl($dealer_salesman_report->quot_period) == "") { ?>
		<td style="vertical-align: bottom;"><?php echo $dealer_salesman_report->quot_period->FldCaption() ?></td>
<?php } else { ?>
		<td class="ewPointer" onmousedown="ewrpt_Sort(event,'<?php echo $dealer_salesman_report->SortUrl($dealer_salesman_report->quot_period) ?>',0);"><?php echo $dealer_salesman_report->quot_period->FldCaption() ?></td><td style="width: 10px;">
		<?php if ($dealer_salesman_report->quot_period->getSort() == "ASC") { ?><img src="phprptimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($dealer_salesman_report->quot_period->getSort() == "DESC") { ?><img src="phprptimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td>
<?php } ?>
	</tr></table>
<?php } ?>
</td>
<td class="ewTableHeader">
<?php if ($dealer_salesman_report->Export <> "") { ?>
<?php echo $dealer_salesman_report->total_premium->FldCaption() ?>
<?php } else { ?>
	<table cellspacing="0" class="ewTableHeaderBtn"><tr>
<?php if ($dealer_salesman_report->SortUrl($dealer_salesman_report->total_premium) == "") { ?>
		<td style="vertical-align: bottom;"><?php echo $dealer_salesman_report->total_premium->FldCaption() ?></td>
<?php } else { ?>
		<td class="ewPointer" onmousedown="ewrpt_Sort(event,'<?php echo $dealer_salesman_report->SortUrl($dealer_salesman_report->total_premium) ?>',0);"><?php echo $dealer_salesman_report->total_premium->FldCaption() ?></td><td style="width: 10px;">
		<?php if ($dealer_salesman_report->total_premium->getSort() == "ASC") { ?><img src="phprptimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($dealer_salesman_report->total_premium->getSort() == "DESC") { ?><img src="phprptimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td>
<?php } ?>
	</tr></table>
<?php } ?>
</td>
<td class="ewTableHeader">
<?php if ($dealer_salesman_report->Export <> "") { ?>
<?php echo $dealer_salesman_report->commission->FldCaption() ?>
<?php } else { ?>
	<table cellspacing="0" class="ewTableHeaderBtn"><tr>
<?php if ($dealer_salesman_report->SortUrl($dealer_salesman_report->commission) == "") { ?>
		<td style="vertical-align: bottom;"><?php echo $dealer_salesman_report->commission->FldCaption() ?></td>
<?php } else { ?>
		<td class="ewPointer" onmousedown="ewrpt_Sort(event,'<?php echo $dealer_salesman_report->SortUrl($dealer_salesman_report->commission) ?>',0);"><?php echo $dealer_salesman_report->commission->FldCaption() ?></td><td style="width: 10px;">
		<?php if ($dealer_salesman_report->commission->getSort() == "ASC") { ?><img src="phprptimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($dealer_salesman_report->commission->getSort() == "DESC") { ?><img src="phprptimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td>
<?php } ?>
	</tr></table>
<?php } ?>
</td>
<td class="ewTableHeader">
<?php if ($dealer_salesman_report->Export <> "") { ?>
<?php echo $dealer_salesman_report->report_invoice2Etotal_premium_2D_report_invoice2Ecommission->FldCaption() ?>
<?php } else { ?>
	<table cellspacing="0" class="ewTableHeaderBtn"><tr>
<?php if ($dealer_salesman_report->SortUrl($dealer_salesman_report->report_invoice2Etotal_premium_2D_report_invoice2Ecommission) == "") { ?>
		<td style="vertical-align: bottom;"><?php echo $dealer_salesman_report->report_invoice2Etotal_premium_2D_report_invoice2Ecommission->FldCaption() ?></td>
<?php } else { ?>
		<td class="ewPointer" onmousedown="ewrpt_Sort(event,'<?php echo $dealer_salesman_report->SortUrl($dealer_salesman_report->report_invoice2Etotal_premium_2D_report_invoice2Ecommission) ?>',0);"><?php echo $dealer_salesman_report->report_invoice2Etotal_premium_2D_report_invoice2Ecommission->FldCaption() ?></td><td style="width: 10px;">
		<?php if ($dealer_salesman_report->report_invoice2Etotal_premium_2D_report_invoice2Ecommission->getSort() == "ASC") { ?><img src="phprptimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($dealer_salesman_report->report_invoice2Etotal_premium_2D_report_invoice2Ecommission->getSort() == "DESC") { ?><img src="phprptimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td>
<?php } ?>
	</tr></table>
<?php } ?>
</td>
	</tr>
	</thead>
	<tbody>
<?php
		$dealer_salesman_report_summary->ShowFirstHeader = FALSE;
	}
	$dealer_salesman_report_summary->RecCount++;

		// Render detail row
		$dealer_salesman_report->ResetCSS();
		$dealer_salesman_report->RowType = EWRPT_ROWTYPE_DETAIL;
		$dealer_salesman_report_summary->RenderRow();
?>
	<tr<?php echo $dealer_salesman_report->RowAttributes(); ?>>
		<td<?php echo $dealer_salesman_report->deal_number->CellAttributes() ?>>
<span<?php echo $dealer_salesman_report->deal_number->ViewAttributes(); ?>><?php echo $dealer_salesman_report->deal_number->ListViewValue(); ?></span></td>
		<td<?php echo $dealer_salesman_report->Dealer->CellAttributes() ?>>
<span<?php echo $dealer_salesman_report->Dealer->ViewAttributes(); ?>><?php echo $dealer_salesman_report->Dealer->ListViewValue(); ?></span></td>
		<td<?php echo $dealer_salesman_report->date_start->CellAttributes() ?>>
<span<?php echo $dealer_salesman_report->date_start->ViewAttributes(); ?>><?php echo $dealer_salesman_report->date_start->ListViewValue(); ?></span></td>
		<td<?php echo $dealer_salesman_report->status->CellAttributes() ?>>
<span<?php echo $dealer_salesman_report->status->ViewAttributes(); ?>><?php echo $dealer_salesman_report->status->ListViewValue(); ?></span></td>
		<td<?php echo $dealer_salesman_report->salesman->CellAttributes() ?>>
<span<?php echo $dealer_salesman_report->salesman->ViewAttributes(); ?>><?php echo $dealer_salesman_report->salesman->ListViewValue(); ?></span></td>
		<td<?php echo $dealer_salesman_report->customer->CellAttributes() ?>>
<span<?php echo $dealer_salesman_report->customer->ViewAttributes(); ?>><?php echo $dealer_salesman_report->customer->ListViewValue(); ?></span></td>
		<td<?php echo $dealer_salesman_report->idno->CellAttributes() ?>>
<span<?php echo $dealer_salesman_report->idno->ViewAttributes(); ?>><?php echo $dealer_salesman_report->idno->ListViewValue(); ?></span></td>
		<td<?php echo $dealer_salesman_report->quot_collection->CellAttributes() ?>>
<span<?php echo $dealer_salesman_report->quot_collection->ViewAttributes(); ?>><?php echo $dealer_salesman_report->quot_collection->ListViewValue(); ?></span></td>
		<td<?php echo $dealer_salesman_report->quot_period->CellAttributes() ?>>
<span<?php echo $dealer_salesman_report->quot_period->ViewAttributes(); ?>><?php echo $dealer_salesman_report->quot_period->ListViewValue(); ?></span></td>
		<td<?php echo $dealer_salesman_report->total_premium->CellAttributes() ?>>
<span<?php echo $dealer_salesman_report->total_premium->ViewAttributes(); ?>><?php echo $dealer_salesman_report->total_premium->ListViewValue(); ?></span></td>
		<td<?php echo $dealer_salesman_report->commission->CellAttributes() ?>>
<span<?php echo $dealer_salesman_report->commission->ViewAttributes(); ?>><?php echo $dealer_salesman_report->commission->ListViewValue(); ?></span></td>
		<td<?php echo $dealer_salesman_report->report_invoice2Etotal_premium_2D_report_invoice2Ecommission->CellAttributes() ?>>
<span<?php echo $dealer_salesman_report->report_invoice2Etotal_premium_2D_report_invoice2Ecommission->ViewAttributes(); ?>><?php echo $dealer_salesman_report->report_invoice2Etotal_premium_2D_report_invoice2Ecommission->ListViewValue(); ?></span></td>
	</tr>
<?php

		// Accumulate page summary
		$dealer_salesman_report_summary->AccumulateSummary();

		// Get next record
		$dealer_salesman_report_summary->GetRow(2);
	$dealer_salesman_report_summary->GrpCount++;
} // End while
?>
	</tbody>
	<tfoot>
<?php
if ($dealer_salesman_report_summary->TotalGrps > 0) {
	$dealer_salesman_report->ResetCSS();
	$dealer_salesman_report->RowType = EWRPT_ROWTYPE_TOTAL;
	$dealer_salesman_report->RowTotalType = EWRPT_ROWTOTAL_GRAND;
	$dealer_salesman_report->RowTotalSubType = EWRPT_ROWTOTAL_FOOTER;
	$dealer_salesman_report->RowAttrs["class"] = "ewRptGrandSummary";
	$dealer_salesman_report_summary->RenderRow();
?>
	<!-- tr><td colspan="12"><span class="phpreportmaker">&nbsp;<br></span></td></tr -->
	<tr<?php echo $dealer_salesman_report->RowAttributes(); ?>><td colspan="12"><?php echo $ReportLanguage->Phrase("RptGrandTotal") ?> (<?php echo ewrpt_FormatNumber($dealer_salesman_report_summary->TotCount,0,-2,-2,-2); ?><?php echo $ReportLanguage->Phrase("RptDtlRec") ?>)</td></tr>
<?php } ?>
	</tfoot>
</table>
</div>
<?php if ($dealer_salesman_report->Export == "") { ?>
<div class="ewGridLowerPanel">
<form action="<?php echo ewrpt_CurrentPage() ?>" name="ewpagerform" id="ewpagerform" class="ewForm">
<table border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td style="white-space: nowrap;">
<?php if (!isset($Pager)) $Pager = new crPrevNextPager($dealer_salesman_report_summary->StartGrp, $dealer_salesman_report_summary->DisplayGrps, $dealer_salesman_report_summary->TotalGrps) ?>
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
	<?php if ($dealer_salesman_report_summary->Filter == "0=101") { ?>
	<span class="phpreportmaker"><?php echo $ReportLanguage->Phrase("EnterSearchCriteria") ?></span>
	<?php } else { ?>
	<span class="phpreportmaker"><?php echo $ReportLanguage->Phrase("NoRecord") ?></span>
	<?php } ?>
<?php } ?>
		</td>
<?php if ($dealer_salesman_report_summary->TotalGrps > 0) { ?>
		<td style="white-space: nowrap;">&nbsp;&nbsp;&nbsp;&nbsp;</td>
		<td align="right" style="vertical-align: top; white-space: nowrap;"><span class="phpreportmaker"><?php echo $ReportLanguage->Phrase("GroupsPerPage"); ?>&nbsp;
<select name="<?php echo EWRPT_TABLE_GROUP_PER_PAGE; ?>" onchange="this.form.submit();">
<option value="1"<?php if ($dealer_salesman_report_summary->DisplayGrps == 1) echo " selected=\"selected\"" ?>>1</option>
<option value="2"<?php if ($dealer_salesman_report_summary->DisplayGrps == 2) echo " selected=\"selected\"" ?>>2</option>
<option value="3"<?php if ($dealer_salesman_report_summary->DisplayGrps == 3) echo " selected=\"selected\"" ?>>3</option>
<option value="4"<?php if ($dealer_salesman_report_summary->DisplayGrps == 4) echo " selected=\"selected\"" ?>>4</option>
<option value="5"<?php if ($dealer_salesman_report_summary->DisplayGrps == 5) echo " selected=\"selected\"" ?>>5</option>
<option value="10"<?php if ($dealer_salesman_report_summary->DisplayGrps == 10) echo " selected=\"selected\"" ?>>10</option>
<option value="20"<?php if ($dealer_salesman_report_summary->DisplayGrps == 20) echo " selected=\"selected\"" ?>>20</option>
<option value="50"<?php if ($dealer_salesman_report_summary->DisplayGrps == 50) echo " selected=\"selected\"" ?>>50</option>
<option value="ALL"<?php if ($dealer_salesman_report->getGroupPerPage() == -1) echo " selected=\"selected\"" ?>><?php echo $ReportLanguage->Phrase("AllRecords") ?></option>
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
<?php if ($dealer_salesman_report->Export == "" || $dealer_salesman_report->Export == "print" || $dealer_salesman_report->Export == "email") { ?>
	</div><br></td>
	<!-- Center Container - Report (End) -->
	<!-- Right Container (Begin) -->
	<td style="vertical-align: top;"><div id="ewRight" class="phpreportmaker">
	<!-- Right slot -->
	</div></td>
	<!-- Right Container (End) -->
</tr>
<!-- Bottom Container (Begin) -->
<tr><td colspan="3" class="ewPadding"><div id="ewBottom" class="phpreportmaker">
	<!-- Bottom slot -->
<a name="cht_Chart_Report"></a>
<div id="div_dealer_salesman_report_Chart_Report"></div>
<?php

// Initialize chart data
$dealer_salesman_report->Chart_Report->ID = "dealer_salesman_report_Chart_Report"; // Chart ID
$dealer_salesman_report->Chart_Report->SetChartParam("type", "9", FALSE); // Chart type
$dealer_salesman_report->Chart_Report->SetChartParam("seriestype", "1", FALSE); // Chart series type
$dealer_salesman_report->Chart_Report->SetChartParam("bgcolor", "FCFCFC", TRUE); // Background color
$dealer_salesman_report->Chart_Report->SetChartParam("caption", $dealer_salesman_report->Chart_Report->ChartCaption(), TRUE); // Chart caption
$dealer_salesman_report->Chart_Report->SetChartParam("xaxisname", $dealer_salesman_report->Chart_Report->ChartXAxisName(), TRUE); // X axis name
$dealer_salesman_report->Chart_Report->SetChartParam("yaxisname", $dealer_salesman_report->Chart_Report->ChartYAxisName(), TRUE); // Y axis name
$dealer_salesman_report->Chart_Report->SetChartParam("shownames", "1", TRUE); // Show names
$dealer_salesman_report->Chart_Report->SetChartParam("showvalues", "1", TRUE); // Show values
$dealer_salesman_report->Chart_Report->SetChartParam("showhovercap", "0", TRUE); // Show hover
$dealer_salesman_report->Chart_Report->SetChartParam("alpha", "50", FALSE); // Chart alpha
$dealer_salesman_report->Chart_Report->SetChartParam("colorpalette", "#FF0000|#0000FF|#80FF00|#FF0080|#FF00FF|#8000FF|#FF8000|#FF3D3D|#7AFFFF|#FFFF00|#FF7A7A|#3DFFFF|#0080FF|#00FF00|#00FF80|#00FFFF", FALSE); // Chart color palette
?>
<?php
$dealer_salesman_report->Chart_Report->SetChartParam("showCanvasBg", "1", TRUE); // showCanvasBg
$dealer_salesman_report->Chart_Report->SetChartParam("showCanvasBase", "1", TRUE); // showCanvasBase
$dealer_salesman_report->Chart_Report->SetChartParam("showLimits", "1", TRUE); // showLimits
$dealer_salesman_report->Chart_Report->SetChartParam("animation", "1", TRUE); // animation
$dealer_salesman_report->Chart_Report->SetChartParam("rotateNames", "1", TRUE); // rotateNames
$dealer_salesman_report->Chart_Report->SetChartParam("yAxisMinValue", "0", TRUE); // yAxisMinValue
$dealer_salesman_report->Chart_Report->SetChartParam("yAxisMaxValue", "0", TRUE); // yAxisMaxValue
$dealer_salesman_report->Chart_Report->SetChartParam("PYAxisMinValue", "0", TRUE); // PYAxisMinValue
$dealer_salesman_report->Chart_Report->SetChartParam("PYAxisMaxValue", "0", TRUE); // PYAxisMaxValue
$dealer_salesman_report->Chart_Report->SetChartParam("SYAxisMinValue", "0", TRUE); // SYAxisMinValue
$dealer_salesman_report->Chart_Report->SetChartParam("SYAxisMaxValue", "0", TRUE); // SYAxisMaxValue
$dealer_salesman_report->Chart_Report->SetChartParam("showColumnShadow", "0", TRUE); // showColumnShadow
$dealer_salesman_report->Chart_Report->SetChartParam("showPercentageValues", "1", TRUE); // showPercentageValues
$dealer_salesman_report->Chart_Report->SetChartParam("showPercentageInLabel", "1", TRUE); // showPercentageInLabel
$dealer_salesman_report->Chart_Report->SetChartParam("showBarShadow", "0", TRUE); // showBarShadow
$dealer_salesman_report->Chart_Report->SetChartParam("showAnchors", "1", TRUE); // showAnchors
$dealer_salesman_report->Chart_Report->SetChartParam("showAreaBorder", "1", TRUE); // showAreaBorder
$dealer_salesman_report->Chart_Report->SetChartParam("isSliced", "1", TRUE); // isSliced
$dealer_salesman_report->Chart_Report->SetChartParam("showAsBars", "0", TRUE); // showAsBars
$dealer_salesman_report->Chart_Report->SetChartParam("showShadow", "0", TRUE); // showShadow
$dealer_salesman_report->Chart_Report->SetChartParam("formatNumber", "0", TRUE); // formatNumber
$dealer_salesman_report->Chart_Report->SetChartParam("formatNumberScale", "0", TRUE); // formatNumberScale
$dealer_salesman_report->Chart_Report->SetChartParam("decimalSeparator", ".", TRUE); // decimalSeparator
$dealer_salesman_report->Chart_Report->SetChartParam("thousandSeparator", ",", TRUE); // thousandSeparator
$dealer_salesman_report->Chart_Report->SetChartParam("decimalPrecision", "2", TRUE); // decimalPrecision
$dealer_salesman_report->Chart_Report->SetChartParam("divLineDecimalPrecision", "2", TRUE); // divLineDecimalPrecision
$dealer_salesman_report->Chart_Report->SetChartParam("limitsDecimalPrecision", "2", TRUE); // limitsDecimalPrecision
$dealer_salesman_report->Chart_Report->SetChartParam("zeroPlaneShowBorder", "1", TRUE); // zeroPlaneShowBorder
$dealer_salesman_report->Chart_Report->SetChartParam("showDivLineValue", "1", TRUE); // showDivLineValue
$dealer_salesman_report->Chart_Report->SetChartParam("showAlternateHGridColor", "0", TRUE); // showAlternateHGridColor
$dealer_salesman_report->Chart_Report->SetChartParam("showAlternateVGridColor", "0", TRUE); // showAlternateVGridColor
$dealer_salesman_report->Chart_Report->SetChartParam("hoverCapSepChar", ":", TRUE); // hoverCapSepChar

// Define trend lines
?>
<?php
$SqlSelect = $dealer_salesman_report->SqlSelect();
$SqlChartSelect = $dealer_salesman_report->Chart_Report->SqlSelect;
if (EWRPT_IS_MSSQL) // skip SqlOrderBy for MSSQL
	$sSqlChartBase = "(" . ewrpt_BuildReportSql($SqlSelect, $dealer_salesman_report->SqlWhere(), $dealer_salesman_report->SqlGroupBy(), $dealer_salesman_report->SqlHaving(), "", $dealer_salesman_report_summary->Filter, "") . ") EW_TMP_TABLE";
else
	$sSqlChartBase = "(" . ewrpt_BuildReportSql($SqlSelect, $dealer_salesman_report->SqlWhere(), $dealer_salesman_report->SqlGroupBy(), $dealer_salesman_report->SqlHaving(), $dealer_salesman_report->SqlOrderBy(), $dealer_salesman_report_summary->Filter, "") . ") EW_TMP_TABLE";
$dealer_salesman_report->Chart_Report->Series[] = $dealer_salesman_report->total_premium->FldCaption();
$dealer_salesman_report->Chart_Report->Series[] = $dealer_salesman_report->commission->FldCaption();
$dealer_salesman_report->Chart_Report->Series[] = $dealer_salesman_report->report_invoice2Etotal_premium_2D_report_invoice2Ecommission->FldCaption();

// Load chart data from sql directly
$sSql = $SqlChartSelect . $sSqlChartBase;
$sSql = ewrpt_BuildReportSql($sSql, "", $dealer_salesman_report->Chart_Report->SqlGroupBy, "", $dealer_salesman_report->Chart_Report->SqlOrderBy, "", "");
if (EWRPT_DEBUG_ENABLED) echo "(Chart SQL): " . $sSql . "<br>";
ewrpt_LoadChartData($sSql, $dealer_salesman_report->Chart_Report);
ewrpt_SortChartData($dealer_salesman_report->Chart_Report->Data, 0, "");

// Call Chart_Rendering event
$dealer_salesman_report->Chart_Rendering($dealer_salesman_report->Chart_Report);
$chartxml = $dealer_salesman_report->Chart_Report->ChartXml();

// Call Chart_Rendered event
$dealer_salesman_report->Chart_Rendered($dealer_salesman_report->Chart_Report, $chartxml);
echo $dealer_salesman_report->Chart_Report->ShowChartFCF($chartxml);
?>
<a href="#top"><?php echo $ReportLanguage->Phrase("Top") ?></a>
<br><br>
	</div><br></td></tr>
<!-- Bottom Container (End) -->
</table>
<!-- Table Container (End) -->
<?php } ?>
<?php $dealer_salesman_report_summary->ShowPageFooter(); ?>
<?php if (EWRPT_DEBUG_ENABLED) echo ewrpt_DebugMsg(); ?>
<?php

// Close recordsets
if ($rsgrp) $rsgrp->Close();
if ($rs) $rs->Close();
?>
<?php if ($dealer_salesman_report->Export == "") { ?>
<script language="JavaScript" type="text/javascript">
<!--

// Write your table-specific startup script here
// document.write("page loaded");
//-->

</script>
<?php } ?>
<?php include_once "phprptinc/footer.php"; ?>
<?php
$dealer_salesman_report_summary->Page_Terminate();
?>
<?php

//
// Page class
//
class crdealer_salesman_report_summary {

	// Page ID
	var $PageID = 'summary';

	// Table name
	var $TableName = 'dealer_salesman_report';

	// Page object name
	var $PageObjName = 'dealer_salesman_report_summary';

	// Page name
	function PageName() {
		return ewrpt_CurrentPage();
	}

	// Page URL
	function PageUrl() {
		$PageUrl = ewrpt_CurrentPage() . "?";
		global $dealer_salesman_report;
		if ($dealer_salesman_report->UseTokenInUrl) $PageUrl .= "t=" . $dealer_salesman_report->TableVar . "&"; // Add page token
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
		global $dealer_salesman_report;
		if ($dealer_salesman_report->UseTokenInUrl) {
			if (ewrpt_IsHttpPost())
				return ($dealer_salesman_report->TableVar == @$_POST("t"));
			if (@$_GET["t"] <> "")
				return ($dealer_salesman_report->TableVar == @$_GET["t"]);
		} else {
			return TRUE;
		}
	}

	//
	// Page class constructor
	//
	function crdealer_salesman_report_summary() {
		global $conn, $ReportLanguage;

		// Language object
		$ReportLanguage = new crLanguage();

		// Table object (dealer_salesman_report)
		$GLOBALS["dealer_salesman_report"] = new crdealer_salesman_report();
		$GLOBALS["Table"] =& $GLOBALS["dealer_salesman_report"];

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
			define("EWRPT_TABLE_NAME", 'dealer_salesman_report', TRUE);

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
		global $dealer_salesman_report;

		// Security
		$Security = new crAdvancedSecurity();
		if (!$Security->IsLoggedIn()) $Security->AutoLogin(); // Auto login
		if (!$Security->IsLoggedIn()) {
			$Security->SaveLastUrl();
			$this->Page_Terminate("rlogin.php");
		}

		// Get export parameters
		if (@$_GET["export"] <> "") {
			$dealer_salesman_report->Export = $_GET["export"];
		}
		$gsExport = $dealer_salesman_report->Export; // Get export parameter, used in header
		$gsExportFile = $dealer_salesman_report->TableVar; // Get export file, used in header
		if ($dealer_salesman_report->Export == "excel") {
			header('Content-Type: application/vnd.ms-excel;charset=utf-8');
			header('Content-Disposition: attachment; filename=' . $gsExportFile .'.xls');
		}
		if ($dealer_salesman_report->Export == "word") {
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
		global $ReportLanguage, $dealer_salesman_report;

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
		$item->Body = "<a name=\"emf_dealer_salesman_report\" id=\"emf_dealer_salesman_report\" href=\"javascript:void(0);\" onclick=\"ewrpt_EmailDialogShow({lnk:'emf_dealer_salesman_report',hdr:ewLanguage.Phrase('ExportToEmail')});\">" . $ReportLanguage->Phrase("ExportToEmail") . "</a>";
		$item->Visible = FALSE;

		// Reset filter
		$item =& $this->ExportOptions->Add("resetfilter");
		$item->Body = "<a href=\"" . ewrpt_CurrentPage() . "?cmd=reset\">" . $ReportLanguage->Phrase("ResetAllFilter") . "</a>";
		$item->Visible = TRUE;
		$this->SetupExportOptionsExt();

		// Hide options for export
		if ($dealer_salesman_report->Export <> "")
			$this->ExportOptions->HideAllOptions();

		// Set up table class
		if ($dealer_salesman_report->Export == "word" || $dealer_salesman_report->Export == "excel" || $dealer_salesman_report->Export == "pdf")
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
		global $dealer_salesman_report;

		// Page Unload event
		$this->Page_Unload();

		// Global Page Unloaded event (in userfn*.php)
		Page_Unloaded();

		// Export to Email (use ob_file_contents for PHP)
		if ($dealer_salesman_report->Export == "email") {
			$sContent = ob_get_contents();
			$this->ExportEmail($sContent);
			ob_end_clean();

			 // Close connection
			$conn->Close();
			header("Location: " . ewrpt_CurrentPage());
			exit();
		}

		// Export to PDF (use ob_file_contents for PHP)
		if ($dealer_salesman_report->Export == "pdf") {
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
		global $dealer_salesman_report;
		global $rs;
		global $rsgrp;
		global $gsFormError;

		// Aggregate variables
		// 1st dimension = no of groups (level 0 used for grand total)
		// 2nd dimension = no of fields

		$nDtls = 13;
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
		$this->Col = array(FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE);

		// Set up groups per page dynamically
		$this->SetUpDisplayGrps();

		// Load default filter values
		$this->LoadDefaultFilters();

		// Load custom filters
		$dealer_salesman_report->Filters_Load();

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
		$sSql = ewrpt_BuildReportSql($dealer_salesman_report->SqlSelect(), $dealer_salesman_report->SqlWhere(), $dealer_salesman_report->SqlGroupBy(), $dealer_salesman_report->SqlHaving(), $dealer_salesman_report->SqlOrderBy(), $this->Filter, $this->Sort);
		$this->TotalGrps = $this->GetCnt($sSql);
		if ($this->DisplayGrps <= 0) // Display all groups
			$this->DisplayGrps = $this->TotalGrps;
		$this->StartGrp = 1;

		// Show header
		$this->ShowFirstHeader = ($this->TotalGrps > 0);

		//$this->ShowFirstHeader = TRUE; // Uncomment to always show header
		// Set up start position if not export all

		if ($dealer_salesman_report->ExportAll && $dealer_salesman_report->Export <> "")
		    $this->DisplayGrps = $this->TotalGrps;
		else
			$this->SetUpStartGroup(); 

		// Hide all options if export
		if ($dealer_salesman_report->Export <> "") {
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
		global $dealer_salesman_report;
		if (!$rs)
			return;
		if ($opt == 1) { // Get first row

	//		$rs->MoveFirst(); // NOTE: no need to move position
		} else { // Get next row
			$rs->MoveNext();
		}
		if (!$rs->EOF) {
			$dealer_salesman_report->deal_number->setDbValue($rs->fields('deal_number'));
			$dealer_salesman_report->Dealer->setDbValue($rs->fields('Dealer'));
			$dealer_salesman_report->date_start->setDbValue($rs->fields('date_start'));
			$dealer_salesman_report->status->setDbValue($rs->fields('status'));
			$dealer_salesman_report->Code->setDbValue($rs->fields('Code'));
			$dealer_salesman_report->salesman->setDbValue($rs->fields('salesman'));
			$dealer_salesman_report->customer->setDbValue($rs->fields('customer'));
			$dealer_salesman_report->idno->setDbValue($rs->fields('idno'));
			$dealer_salesman_report->quot_collection->setDbValue($rs->fields('quot_collection'));
			$dealer_salesman_report->quot_period->setDbValue($rs->fields('quot_period'));
			$dealer_salesman_report->total_premium->setDbValue($rs->fields('total_premium'));
			$dealer_salesman_report->commission->setDbValue($rs->fields('commission'));
			$dealer_salesman_report->report_invoice2Etotal_premium_2D_report_invoice2Ecommission->setDbValue($rs->fields('report_invoice.total_premium - report_invoice.commission'));
			$this->Val[1] = $dealer_salesman_report->deal_number->CurrentValue;
			$this->Val[2] = $dealer_salesman_report->Dealer->CurrentValue;
			$this->Val[3] = $dealer_salesman_report->date_start->CurrentValue;
			$this->Val[4] = $dealer_salesman_report->status->CurrentValue;
			$this->Val[5] = $dealer_salesman_report->salesman->CurrentValue;
			$this->Val[6] = $dealer_salesman_report->customer->CurrentValue;
			$this->Val[7] = $dealer_salesman_report->idno->CurrentValue;
			$this->Val[8] = $dealer_salesman_report->quot_collection->CurrentValue;
			$this->Val[9] = $dealer_salesman_report->quot_period->CurrentValue;
			$this->Val[10] = $dealer_salesman_report->total_premium->CurrentValue;
			$this->Val[11] = $dealer_salesman_report->commission->CurrentValue;
			$this->Val[12] = $dealer_salesman_report->report_invoice2Etotal_premium_2D_report_invoice2Ecommission->CurrentValue;
		} else {
			$dealer_salesman_report->deal_number->setDbValue("");
			$dealer_salesman_report->Dealer->setDbValue("");
			$dealer_salesman_report->date_start->setDbValue("");
			$dealer_salesman_report->status->setDbValue("");
			$dealer_salesman_report->Code->setDbValue("");
			$dealer_salesman_report->salesman->setDbValue("");
			$dealer_salesman_report->customer->setDbValue("");
			$dealer_salesman_report->idno->setDbValue("");
			$dealer_salesman_report->quot_collection->setDbValue("");
			$dealer_salesman_report->quot_period->setDbValue("");
			$dealer_salesman_report->total_premium->setDbValue("");
			$dealer_salesman_report->commission->setDbValue("");
			$dealer_salesman_report->report_invoice2Etotal_premium_2D_report_invoice2Ecommission->setDbValue("");
		}
	}

	//  Set up starting group
	function SetUpStartGroup() {
		global $dealer_salesman_report;

		// Exit if no groups
		if ($this->DisplayGrps == 0)
			return;

		// Check for a 'start' parameter
		if (@$_GET[EWRPT_TABLE_START_GROUP] != "") {
			$this->StartGrp = $_GET[EWRPT_TABLE_START_GROUP];
			$dealer_salesman_report->setStartGroup($this->StartGrp);
		} elseif (@$_GET["pageno"] != "") {
			$nPageNo = $_GET["pageno"];
			if (is_numeric($nPageNo)) {
				$this->StartGrp = ($nPageNo-1)*$this->DisplayGrps+1;
				if ($this->StartGrp <= 0) {
					$this->StartGrp = 1;
				} elseif ($this->StartGrp >= intval(($this->TotalGrps-1)/$this->DisplayGrps)*$this->DisplayGrps+1) {
					$this->StartGrp = intval(($this->TotalGrps-1)/$this->DisplayGrps)*$this->DisplayGrps+1;
				}
				$dealer_salesman_report->setStartGroup($this->StartGrp);
			} else {
				$this->StartGrp = $dealer_salesman_report->getStartGroup();
			}
		} else {
			$this->StartGrp = $dealer_salesman_report->getStartGroup();
		}

		// Check if correct start group counter
		if (!is_numeric($this->StartGrp) || $this->StartGrp == "") { // Avoid invalid start group counter
			$this->StartGrp = 1; // Reset start group counter
			$dealer_salesman_report->setStartGroup($this->StartGrp);
		} elseif (intval($this->StartGrp) > intval($this->TotalGrps)) { // Avoid starting group > total groups
			$this->StartGrp = intval(($this->TotalGrps-1)/$this->DisplayGrps) * $this->DisplayGrps + 1; // Point to last page first group
			$dealer_salesman_report->setStartGroup($this->StartGrp);
		} elseif (($this->StartGrp-1) % $this->DisplayGrps <> 0) {
			$this->StartGrp = intval(($this->StartGrp-1)/$this->DisplayGrps) * $this->DisplayGrps + 1; // Point to page boundary
			$dealer_salesman_report->setStartGroup($this->StartGrp);
		}
	}

	// Set up popup
	function SetupPopup() {
		global $conn, $ReportLanguage;
		global $dealer_salesman_report;

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
		global $dealer_salesman_report;
		$this->StartGrp = 1;
		$dealer_salesman_report->setStartGroup($this->StartGrp);
	}

	// Set up number of groups displayed per page
	function SetUpDisplayGrps() {
		global $dealer_salesman_report;
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
			$dealer_salesman_report->setGroupPerPage($this->DisplayGrps); // Save to session

			// Reset start position (reset command)
			$this->StartGrp = 1;
			$dealer_salesman_report->setStartGroup($this->StartGrp);
		} else {
			if ($dealer_salesman_report->getGroupPerPage() <> "") {
				$this->DisplayGrps = $dealer_salesman_report->getGroupPerPage(); // Restore from session
			} else {
				$this->DisplayGrps = 50; // Load default
			}
		}
	}

	function RenderRow() {
		global $conn, $rs, $Security;
		global $dealer_salesman_report;
		if ($dealer_salesman_report->RowTotalType == EWRPT_ROWTOTAL_GRAND) { // Grand total

			// Get total count from sql directly
			$sSql = ewrpt_BuildReportSql($dealer_salesman_report->SqlSelectCount(), $dealer_salesman_report->SqlWhere(), $dealer_salesman_report->SqlGroupBy(), $dealer_salesman_report->SqlHaving(), "", $this->Filter, "");
			$rstot = $conn->Execute($sSql);
			if ($rstot) {
				$this->TotCount = ($rstot->RecordCount()>1) ? $rstot->RecordCount() : $rstot->fields[0];
				$rstot->Close();
			} else {
				$this->TotCount = 0;
			}
		}

		// Call Row_Rendering event
		$dealer_salesman_report->Row_Rendering();

		//
		// Render view codes
		//

		if ($dealer_salesman_report->RowType == EWRPT_ROWTYPE_TOTAL) { // Summary row
		} else {

			// deal_number
			$dealer_salesman_report->deal_number->ViewValue = $dealer_salesman_report->deal_number->CurrentValue;
			$dealer_salesman_report->deal_number->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";

			// Dealer
			$dealer_salesman_report->Dealer->ViewValue = $dealer_salesman_report->Dealer->CurrentValue;
			$dealer_salesman_report->Dealer->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";
			$dealer_salesman_report->Dealer->CellAttrs["style"] = "white-space: nowrap;";

			// date_start
			$dealer_salesman_report->date_start->ViewValue = $dealer_salesman_report->date_start->CurrentValue;
			$dealer_salesman_report->date_start->ViewValue = ewrpt_FormatDateTime($dealer_salesman_report->date_start->ViewValue, 7);
			$dealer_salesman_report->date_start->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";
			$dealer_salesman_report->date_start->CellAttrs["style"] = "white-space: nowrap;";

			// status
			$dealer_salesman_report->status->ViewValue = $dealer_salesman_report->status->CurrentValue;
			$dealer_salesman_report->status->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";
			$dealer_salesman_report->status->CellAttrs["style"] = "white-space: nowrap;";

			// salesman
			$dealer_salesman_report->salesman->ViewValue = $dealer_salesman_report->salesman->CurrentValue;
			$dealer_salesman_report->salesman->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";

			// customer
			$dealer_salesman_report->customer->ViewValue = $dealer_salesman_report->customer->CurrentValue;
			$dealer_salesman_report->customer->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";

			// idno
			$dealer_salesman_report->idno->ViewValue = $dealer_salesman_report->idno->CurrentValue;
			$dealer_salesman_report->idno->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";

			// quot_collection
			$dealer_salesman_report->quot_collection->ViewValue = $dealer_salesman_report->quot_collection->CurrentValue;
			$dealer_salesman_report->quot_collection->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";

			// quot_period
			$dealer_salesman_report->quot_period->ViewValue = $dealer_salesman_report->quot_period->CurrentValue;
			$dealer_salesman_report->quot_period->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";

			// total_premium
			$dealer_salesman_report->total_premium->ViewValue = $dealer_salesman_report->total_premium->CurrentValue;
			$dealer_salesman_report->total_premium->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";

			// commission
			$dealer_salesman_report->commission->ViewValue = $dealer_salesman_report->commission->CurrentValue;
			$dealer_salesman_report->commission->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";

			// report_invoice.total_premium - report_invoice.commission
			$dealer_salesman_report->report_invoice2Etotal_premium_2D_report_invoice2Ecommission->ViewValue = $dealer_salesman_report->report_invoice2Etotal_premium_2D_report_invoice2Ecommission->CurrentValue;
			$dealer_salesman_report->report_invoice2Etotal_premium_2D_report_invoice2Ecommission->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";

			// deal_number
			$dealer_salesman_report->deal_number->HrefValue = "";

			// Dealer
			$dealer_salesman_report->Dealer->HrefValue = "";

			// date_start
			$dealer_salesman_report->date_start->HrefValue = "";

			// status
			$dealer_salesman_report->status->HrefValue = "";

			// salesman
			$dealer_salesman_report->salesman->HrefValue = "";

			// customer
			$dealer_salesman_report->customer->HrefValue = "";

			// idno
			$dealer_salesman_report->idno->HrefValue = "";

			// quot_collection
			$dealer_salesman_report->quot_collection->HrefValue = "";

			// quot_period
			$dealer_salesman_report->quot_period->HrefValue = "";

			// total_premium
			$dealer_salesman_report->total_premium->HrefValue = "";

			// commission
			$dealer_salesman_report->commission->HrefValue = "";

			// report_invoice.total_premium - report_invoice.commission
			$dealer_salesman_report->report_invoice2Etotal_premium_2D_report_invoice2Ecommission->HrefValue = "";
		}

		// Call Cell_Rendered event
		if ($dealer_salesman_report->RowType == EWRPT_ROWTYPE_TOTAL) { // Summary row
		} else {

			// deal_number
			$CurrentValue = $dealer_salesman_report->deal_number->CurrentValue;
			$ViewValue =& $dealer_salesman_report->deal_number->ViewValue;
			$ViewAttrs =& $dealer_salesman_report->deal_number->ViewAttrs;
			$CellAttrs =& $dealer_salesman_report->deal_number->CellAttrs;
			$HrefValue =& $dealer_salesman_report->deal_number->HrefValue;
			$dealer_salesman_report->Cell_Rendered($dealer_salesman_report->deal_number, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue);

			// Dealer
			$CurrentValue = $dealer_salesman_report->Dealer->CurrentValue;
			$ViewValue =& $dealer_salesman_report->Dealer->ViewValue;
			$ViewAttrs =& $dealer_salesman_report->Dealer->ViewAttrs;
			$CellAttrs =& $dealer_salesman_report->Dealer->CellAttrs;
			$HrefValue =& $dealer_salesman_report->Dealer->HrefValue;
			$dealer_salesman_report->Cell_Rendered($dealer_salesman_report->Dealer, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue);

			// date_start
			$CurrentValue = $dealer_salesman_report->date_start->CurrentValue;
			$ViewValue =& $dealer_salesman_report->date_start->ViewValue;
			$ViewAttrs =& $dealer_salesman_report->date_start->ViewAttrs;
			$CellAttrs =& $dealer_salesman_report->date_start->CellAttrs;
			$HrefValue =& $dealer_salesman_report->date_start->HrefValue;
			$dealer_salesman_report->Cell_Rendered($dealer_salesman_report->date_start, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue);

			// status
			$CurrentValue = $dealer_salesman_report->status->CurrentValue;
			$ViewValue =& $dealer_salesman_report->status->ViewValue;
			$ViewAttrs =& $dealer_salesman_report->status->ViewAttrs;
			$CellAttrs =& $dealer_salesman_report->status->CellAttrs;
			$HrefValue =& $dealer_salesman_report->status->HrefValue;
			$dealer_salesman_report->Cell_Rendered($dealer_salesman_report->status, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue);

			// salesman
			$CurrentValue = $dealer_salesman_report->salesman->CurrentValue;
			$ViewValue =& $dealer_salesman_report->salesman->ViewValue;
			$ViewAttrs =& $dealer_salesman_report->salesman->ViewAttrs;
			$CellAttrs =& $dealer_salesman_report->salesman->CellAttrs;
			$HrefValue =& $dealer_salesman_report->salesman->HrefValue;
			$dealer_salesman_report->Cell_Rendered($dealer_salesman_report->salesman, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue);

			// customer
			$CurrentValue = $dealer_salesman_report->customer->CurrentValue;
			$ViewValue =& $dealer_salesman_report->customer->ViewValue;
			$ViewAttrs =& $dealer_salesman_report->customer->ViewAttrs;
			$CellAttrs =& $dealer_salesman_report->customer->CellAttrs;
			$HrefValue =& $dealer_salesman_report->customer->HrefValue;
			$dealer_salesman_report->Cell_Rendered($dealer_salesman_report->customer, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue);

			// idno
			$CurrentValue = $dealer_salesman_report->idno->CurrentValue;
			$ViewValue =& $dealer_salesman_report->idno->ViewValue;
			$ViewAttrs =& $dealer_salesman_report->idno->ViewAttrs;
			$CellAttrs =& $dealer_salesman_report->idno->CellAttrs;
			$HrefValue =& $dealer_salesman_report->idno->HrefValue;
			$dealer_salesman_report->Cell_Rendered($dealer_salesman_report->idno, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue);

			// quot_collection
			$CurrentValue = $dealer_salesman_report->quot_collection->CurrentValue;
			$ViewValue =& $dealer_salesman_report->quot_collection->ViewValue;
			$ViewAttrs =& $dealer_salesman_report->quot_collection->ViewAttrs;
			$CellAttrs =& $dealer_salesman_report->quot_collection->CellAttrs;
			$HrefValue =& $dealer_salesman_report->quot_collection->HrefValue;
			$dealer_salesman_report->Cell_Rendered($dealer_salesman_report->quot_collection, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue);

			// quot_period
			$CurrentValue = $dealer_salesman_report->quot_period->CurrentValue;
			$ViewValue =& $dealer_salesman_report->quot_period->ViewValue;
			$ViewAttrs =& $dealer_salesman_report->quot_period->ViewAttrs;
			$CellAttrs =& $dealer_salesman_report->quot_period->CellAttrs;
			$HrefValue =& $dealer_salesman_report->quot_period->HrefValue;
			$dealer_salesman_report->Cell_Rendered($dealer_salesman_report->quot_period, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue);

			// total_premium
			$CurrentValue = $dealer_salesman_report->total_premium->CurrentValue;
			$ViewValue =& $dealer_salesman_report->total_premium->ViewValue;
			$ViewAttrs =& $dealer_salesman_report->total_premium->ViewAttrs;
			$CellAttrs =& $dealer_salesman_report->total_premium->CellAttrs;
			$HrefValue =& $dealer_salesman_report->total_premium->HrefValue;
			$dealer_salesman_report->Cell_Rendered($dealer_salesman_report->total_premium, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue);

			// commission
			$CurrentValue = $dealer_salesman_report->commission->CurrentValue;
			$ViewValue =& $dealer_salesman_report->commission->ViewValue;
			$ViewAttrs =& $dealer_salesman_report->commission->ViewAttrs;
			$CellAttrs =& $dealer_salesman_report->commission->CellAttrs;
			$HrefValue =& $dealer_salesman_report->commission->HrefValue;
			$dealer_salesman_report->Cell_Rendered($dealer_salesman_report->commission, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue);

			// report_invoice.total_premium - report_invoice.commission
			$CurrentValue = $dealer_salesman_report->report_invoice2Etotal_premium_2D_report_invoice2Ecommission->CurrentValue;
			$ViewValue =& $dealer_salesman_report->report_invoice2Etotal_premium_2D_report_invoice2Ecommission->ViewValue;
			$ViewAttrs =& $dealer_salesman_report->report_invoice2Etotal_premium_2D_report_invoice2Ecommission->ViewAttrs;
			$CellAttrs =& $dealer_salesman_report->report_invoice2Etotal_premium_2D_report_invoice2Ecommission->CellAttrs;
			$HrefValue =& $dealer_salesman_report->report_invoice2Etotal_premium_2D_report_invoice2Ecommission->HrefValue;
			$dealer_salesman_report->Cell_Rendered($dealer_salesman_report->report_invoice2Etotal_premium_2D_report_invoice2Ecommission, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue);
		}

		// Call Row_Rendered event
		$dealer_salesman_report->Row_Rendered();
	}

	function SetupExportOptionsExt() {
		global $ReportLanguage, $dealer_salesman_report;
	}

	// Get extended filter values
	function GetExtendedFilterValues() {
		global $dealer_salesman_report;

		// Field Dealer
		$sSelect = "SELECT DISTINCT report_invoice.dealer FROM " . $dealer_salesman_report->SqlFrom();
		$sOrderBy = "report_invoice.dealer ASC";
		$wrkSql = ewrpt_BuildReportSql($sSelect, $dealer_salesman_report->SqlWhere(), "", "", $sOrderBy, $this->UserIDFilter, "");
		$dealer_salesman_report->Dealer->DropDownList = ewrpt_GetDistinctValues("", $wrkSql);

		// Field date_start
		$sSelect = "SELECT DISTINCT report_invoice.date_start FROM " . $dealer_salesman_report->SqlFrom();
		$sOrderBy = "report_invoice.date_start ASC";
		$wrkSql = ewrpt_BuildReportSql($sSelect, $dealer_salesman_report->SqlWhere(), "", "", $sOrderBy, $this->UserIDFilter, "");
		$dealer_salesman_report->date_start->DropDownList = ewrpt_GetDistinctValues($dealer_salesman_report->date_start->DateFilter, $wrkSql);

		// Field status
		$sSelect = "SELECT DISTINCT report_invoice.status FROM " . $dealer_salesman_report->SqlFrom();
		$sOrderBy = "report_invoice.status ASC";
		$wrkSql = ewrpt_BuildReportSql($sSelect, $dealer_salesman_report->SqlWhere(), "", "", $sOrderBy, $this->UserIDFilter, "");
		$dealer_salesman_report->status->DropDownList = ewrpt_GetDistinctValues("", $wrkSql);

		// Field salesman
		$sSelect = "SELECT DISTINCT report_invoice.salesman FROM " . $dealer_salesman_report->SqlFrom();
		$sOrderBy = "report_invoice.salesman ASC";
		$wrkSql = ewrpt_BuildReportSql($sSelect, $dealer_salesman_report->SqlWhere(), "", "", $sOrderBy, $this->UserIDFilter, "");
		$dealer_salesman_report->salesman->DropDownList = ewrpt_GetDistinctValues("", $wrkSql);
	}

	// Return extended filter
	function GetExtendedFilter() {
		global $dealer_salesman_report;
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
			// Field Dealer

			$this->SetSessionDropDownValue($dealer_salesman_report->Dealer->DropDownValue, 'Dealer');

			// Field date_start
			$this->SetSessionDropDownValue($dealer_salesman_report->date_start->DropDownValue, 'date_start');

			// Field status
			$this->SetSessionDropDownValue($dealer_salesman_report->status->DropDownValue, 'status');

			// Field salesman
			$this->SetSessionDropDownValue($dealer_salesman_report->salesman->DropDownValue, 'salesman');
			$bSetupFilter = TRUE;
		} else {

			// Field Dealer
			if ($this->GetDropDownValue($dealer_salesman_report->Dealer->DropDownValue, 'Dealer')) {
				$bSetupFilter = TRUE;
				$bRestoreSession = FALSE;
			} elseif ($dealer_salesman_report->Dealer->DropDownValue <> EWRPT_INIT_VALUE && !isset($_SESSION['sv_dealer_salesman_report->Dealer'])) {
				$bSetupFilter = TRUE;
			}

			// Field date_start
			if ($this->GetDropDownValue($dealer_salesman_report->date_start->DropDownValue, 'date_start')) {
				$bSetupFilter = TRUE;
				$bRestoreSession = FALSE;
			} elseif ($dealer_salesman_report->date_start->DropDownValue <> EWRPT_INIT_VALUE && !isset($_SESSION['sv_dealer_salesman_report->date_start'])) {
				$bSetupFilter = TRUE;
			}

			// Field status
			if ($this->GetDropDownValue($dealer_salesman_report->status->DropDownValue, 'status')) {
				$bSetupFilter = TRUE;
				$bRestoreSession = FALSE;
			} elseif ($dealer_salesman_report->status->DropDownValue <> EWRPT_INIT_VALUE && !isset($_SESSION['sv_dealer_salesman_report->status'])) {
				$bSetupFilter = TRUE;
			}

			// Field salesman
			if ($this->GetDropDownValue($dealer_salesman_report->salesman->DropDownValue, 'salesman')) {
				$bSetupFilter = TRUE;
				$bRestoreSession = FALSE;
			} elseif ($dealer_salesman_report->salesman->DropDownValue <> EWRPT_INIT_VALUE && !isset($_SESSION['sv_dealer_salesman_report->salesman'])) {
				$bSetupFilter = TRUE;
			}
			if (!$this->ValidateForm()) {
				$this->setMessage($gsFormError);
				return $sFilter;
			}
		}

		// Restore session
		if ($bRestoreSession) {

			// Field Dealer
			$this->GetSessionDropDownValue($dealer_salesman_report->Dealer);

			// Field date_start
			$this->GetSessionDropDownValue($dealer_salesman_report->date_start);

			// Field status
			$this->GetSessionDropDownValue($dealer_salesman_report->status);

			// Field salesman
			$this->GetSessionDropDownValue($dealer_salesman_report->salesman);
		}

		// Call page filter validated event
		$dealer_salesman_report->Page_FilterValidated();

		// Build SQL
		// Field Dealer

		ewrpt_BuildDropDownFilter($dealer_salesman_report->Dealer, $sFilter, "");

		// Field date_start
		ewrpt_BuildDropDownFilter($dealer_salesman_report->date_start, $sFilter, $dealer_salesman_report->date_start->DateFilter);

		// Field status
		ewrpt_BuildDropDownFilter($dealer_salesman_report->status, $sFilter, "");

		// Field salesman
		ewrpt_BuildDropDownFilter($dealer_salesman_report->salesman, $sFilter, "");

		// Save parms to session
		// Field Dealer

		$this->SetSessionDropDownValue($dealer_salesman_report->Dealer->DropDownValue, 'Dealer');

		// Field date_start
		$this->SetSessionDropDownValue($dealer_salesman_report->date_start->DropDownValue, 'date_start');

		// Field status
		$this->SetSessionDropDownValue($dealer_salesman_report->status->DropDownValue, 'status');

		// Field salesman
		$this->SetSessionDropDownValue($dealer_salesman_report->salesman->DropDownValue, 'salesman');

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
		$this->GetSessionValue($fld->DropDownValue, 'sv_dealer_salesman_report_' . $parm);
	}

	// Get filter values from session
	function GetSessionFilterValues(&$fld) {
		$parm = substr($fld->FldVar, 2);
		$this->GetSessionValue($fld->SearchValue, 'sv1_dealer_salesman_report_' . $parm);
		$this->GetSessionValue($fld->SearchOperator, 'so1_dealer_salesman_report_' . $parm);
		$this->GetSessionValue($fld->SearchCondition, 'sc_dealer_salesman_report_' . $parm);
		$this->GetSessionValue($fld->SearchValue2, 'sv2_dealer_salesman_report_' . $parm);
		$this->GetSessionValue($fld->SearchOperator2, 'so2_dealer_salesman_report_' . $parm);
	}

	// Get value from session
	function GetSessionValue(&$sv, $sn) {
		if (isset($_SESSION[$sn]))
			$sv = $_SESSION[$sn];
	}

	// Set dropdown value to session
	function SetSessionDropDownValue($sv, $parm) {
		$_SESSION['sv_dealer_salesman_report_' . $parm] = $sv;
	}

	// Set filter values to session
	function SetSessionFilterValues($sv1, $so1, $sc, $sv2, $so2, $parm) {
		$_SESSION['sv1_dealer_salesman_report_' . $parm] = $sv1;
		$_SESSION['so1_dealer_salesman_report_' . $parm] = $so1;
		$_SESSION['sc_dealer_salesman_report_' . $parm] = $sc;
		$_SESSION['sv2_dealer_salesman_report_' . $parm] = $sv2;
		$_SESSION['so2_dealer_salesman_report_' . $parm] = $so2;
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
		global $ReportLanguage, $gsFormError, $dealer_salesman_report;

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
		$_SESSION["sel_dealer_salesman_report_$parm"] = "";
		$_SESSION["rf_dealer_salesman_report_$parm"] = "";
		$_SESSION["rt_dealer_salesman_report_$parm"] = "";
	}

	// Load selection from session
	function LoadSelectionFromSession($parm) {
		global $dealer_salesman_report;
		$fld =& $dealer_salesman_report->fields($parm);
		$fld->SelectionList = @$_SESSION["sel_dealer_salesman_report_$parm"];
		$fld->RangeFrom = @$_SESSION["rf_dealer_salesman_report_$parm"];
		$fld->RangeTo = @$_SESSION["rt_dealer_salesman_report_$parm"];
	}

	// Load default value for filters
	function LoadDefaultFilters() {
		global $dealer_salesman_report;

		/**
		* Set up default values for non Text filters
		*/

		// Field Dealer
		$dealer_salesman_report->Dealer->DefaultDropDownValue = EWRPT_INIT_VALUE;
		$dealer_salesman_report->Dealer->DropDownValue = $dealer_salesman_report->Dealer->DefaultDropDownValue;

		// Field date_start
		$dealer_salesman_report->date_start->DefaultDropDownValue = EWRPT_INIT_VALUE;
		$dealer_salesman_report->date_start->DropDownValue = $dealer_salesman_report->date_start->DefaultDropDownValue;

		// Field status
		$dealer_salesman_report->status->DefaultDropDownValue = EWRPT_INIT_VALUE;
		$dealer_salesman_report->status->DropDownValue = $dealer_salesman_report->status->DefaultDropDownValue;

		// Field salesman
		$dealer_salesman_report->salesman->DefaultDropDownValue = EWRPT_INIT_VALUE;
		$dealer_salesman_report->salesman->DropDownValue = $dealer_salesman_report->salesman->DefaultDropDownValue;

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
		global $dealer_salesman_report;

		// Check Dealer extended filter
		if ($this->NonTextFilterApplied($dealer_salesman_report->Dealer))
			return TRUE;

		// Check date_start extended filter
		if ($this->NonTextFilterApplied($dealer_salesman_report->date_start))
			return TRUE;

		// Check status extended filter
		if ($this->NonTextFilterApplied($dealer_salesman_report->status))
			return TRUE;

		// Check salesman extended filter
		if ($this->NonTextFilterApplied($dealer_salesman_report->salesman))
			return TRUE;
		return FALSE;
	}

	// Show list of filters
	function ShowFilterList() {
		global $dealer_salesman_report;
		global $ReportLanguage;

		// Initialize
		$sFilterList = "";

		// Field Dealer
		$sExtWrk = "";
		$sWrk = "";
		ewrpt_BuildDropDownFilter($dealer_salesman_report->Dealer, $sExtWrk, "");
		if ($sExtWrk <> "" || $sWrk <> "")
			$sFilterList .= $dealer_salesman_report->Dealer->FldCaption() . "<br>";
		if ($sExtWrk <> "")
			$sFilterList .= "&nbsp;&nbsp;$sExtWrk<br>";
		if ($sWrk <> "")
			$sFilterList .= "&nbsp;&nbsp;$sWrk<br>";

		// Field date_start
		$sExtWrk = "";
		$sWrk = "";
		ewrpt_BuildDropDownFilter($dealer_salesman_report->date_start, $sExtWrk, $dealer_salesman_report->date_start->DateFilter);
		if ($sExtWrk <> "" || $sWrk <> "")
			$sFilterList .= $dealer_salesman_report->date_start->FldCaption() . "<br>";
		if ($sExtWrk <> "")
			$sFilterList .= "&nbsp;&nbsp;$sExtWrk<br>";
		if ($sWrk <> "")
			$sFilterList .= "&nbsp;&nbsp;$sWrk<br>";

		// Field status
		$sExtWrk = "";
		$sWrk = "";
		ewrpt_BuildDropDownFilter($dealer_salesman_report->status, $sExtWrk, "");
		if ($sExtWrk <> "" || $sWrk <> "")
			$sFilterList .= $dealer_salesman_report->status->FldCaption() . "<br>";
		if ($sExtWrk <> "")
			$sFilterList .= "&nbsp;&nbsp;$sExtWrk<br>";
		if ($sWrk <> "")
			$sFilterList .= "&nbsp;&nbsp;$sWrk<br>";

		// Field salesman
		$sExtWrk = "";
		$sWrk = "";
		ewrpt_BuildDropDownFilter($dealer_salesman_report->salesman, $sExtWrk, "");
		if ($sExtWrk <> "" || $sWrk <> "")
			$sFilterList .= $dealer_salesman_report->salesman->FldCaption() . "<br>";
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
		global $dealer_salesman_report;
		$sWrk = "";
		return $sWrk;
	}

	//-------------------------------------------------------------------------------
	// Function GetSort
	// - Return Sort parameters based on Sort Links clicked
	// - Variables setup: Session[EWRPT_TABLE_SESSION_ORDER_BY], Session["sort_Table_Field"]
	function GetSort() {
		global $dealer_salesman_report;

		// Check for a resetsort command
		if (strlen(@$_GET["cmd"]) > 0) {
			$sCmd = @$_GET["cmd"];
			if ($sCmd == "resetsort") {
				$dealer_salesman_report->setOrderBy("");
				$dealer_salesman_report->setStartGroup(1);
				$dealer_salesman_report->deal_number->setSort("");
				$dealer_salesman_report->Dealer->setSort("");
				$dealer_salesman_report->date_start->setSort("");
				$dealer_salesman_report->status->setSort("");
				$dealer_salesman_report->salesman->setSort("");
				$dealer_salesman_report->customer->setSort("");
				$dealer_salesman_report->idno->setSort("");
				$dealer_salesman_report->quot_collection->setSort("");
				$dealer_salesman_report->quot_period->setSort("");
				$dealer_salesman_report->total_premium->setSort("");
				$dealer_salesman_report->commission->setSort("");
				$dealer_salesman_report->report_invoice2Etotal_premium_2D_report_invoice2Ecommission->setSort("");
			}

		// Check for an Order parameter
		} elseif (@$_GET["order"] <> "") {
			$dealer_salesman_report->CurrentOrder = ewrpt_StripSlashes(@$_GET["order"]);
			$dealer_salesman_report->CurrentOrderType = @$_GET["ordertype"];
			$sSortSql = $dealer_salesman_report->SortSql();
			$dealer_salesman_report->setOrderBy($sSortSql);
			$dealer_salesman_report->setStartGroup(1);
		}
		return $dealer_salesman_report->getOrderBy();
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
