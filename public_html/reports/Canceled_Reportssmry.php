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
$Canceled_Reports = NULL;

//
// Table class for Canceled Reports
//
class crCanceled_Reports {
	var $TableVar = 'Canceled_Reports';
	var $TableName = 'Canceled Reports';
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
	var $Product_Name;
	var $agree_status;
	var $trans_status;
	var $quote_status;
	var $status;
	var $date_start;
	var $date_modified;
	var $dealer;
	var $salesman;
	var $customer;
	var $idno;
	var $quote_ID;
	var $Agree_ID;
	var $Trans_ID;
	var $total_premium;
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
	function crCanceled_Reports() {
		global $ReportLanguage;

		// Product Name
		$this->Product_Name = new crField('Canceled_Reports', 'Canceled Reports', 'x_Product_Name', 'Product Name', '`Product Name`', 200, EWRPT_DATATYPE_STRING, -1);
		$this->fields['Product_Name'] =& $this->Product_Name;
		$this->Product_Name->DateFilter = "";
		$this->Product_Name->SqlSelect = "";
		$this->Product_Name->SqlOrderBy = "";

		// agree_status
		$this->agree_status = new crField('Canceled_Reports', 'Canceled Reports', 'x_agree_status', 'agree_status', '`agree_status`', 200, EWRPT_DATATYPE_STRING, -1);
		$this->fields['agree_status'] =& $this->agree_status;
		$this->agree_status->DateFilter = "";
		$this->agree_status->SqlSelect = "";
		$this->agree_status->SqlOrderBy = "";

		// trans_status
		$this->trans_status = new crField('Canceled_Reports', 'Canceled Reports', 'x_trans_status', 'trans_status', 'a.trans_status', 200, EWRPT_DATATYPE_STRING, -1);
		$this->fields['trans_status'] =& $this->trans_status;
		$this->trans_status->DateFilter = "";
		$this->trans_status->SqlSelect = "";
		$this->trans_status->SqlOrderBy = "";

		// quote_status
		$this->quote_status = new crField('Canceled_Reports', 'Canceled Reports', 'x_quote_status', 'quote_status', '`quote_status`', 200, EWRPT_DATATYPE_STRING, -1);
		$this->fields['quote_status'] =& $this->quote_status;
		$this->quote_status->DateFilter = "";
		$this->quote_status->SqlSelect = "";
		$this->quote_status->SqlOrderBy = "";

		// status
		$this->status = new crField('Canceled_Reports', 'Canceled Reports', 'x_status', 'status', 'If(qt.Status != \'\', qt.Status, If(a.trans_status != \'\', a.trans_status, a.status))', 200, EWRPT_DATATYPE_STRING, -1);
		$this->fields['status'] =& $this->status;
		$this->status->DateFilter = "";
		$this->status->SqlSelect = "";
		$this->status->SqlOrderBy = "";

		// date_start
		$this->date_start = new crField('Canceled_Reports', 'Canceled Reports', 'x_date_start', 'date_start', 'a.date_start', 135, EWRPT_DATATYPE_DATE, 7);
		$this->date_start->FldDefaultErrMsg = str_replace("%s", "-", $ReportLanguage->Phrase("IncorrectDateYMD"));
		$this->fields['date_start'] =& $this->date_start;
		$this->date_start->DateFilter = "Month";
		$this->date_start->SqlSelect = "";
		$this->date_start->SqlOrderBy = "";
		ewrpt_RegisterFilter($this->date_start, "@@LastMonth", $ReportLanguage->Phrase("LastMonth"), "ewrpt_IsLastMonth");
		ewrpt_RegisterFilter($this->date_start, "@@ThisMonth", $ReportLanguage->Phrase("ThisMonth"), "ewrpt_IsThisMonth");
		ewrpt_RegisterFilter($this->date_start, "@@NextMonth", $ReportLanguage->Phrase("NextMonth"), "ewrpt_IsNextMonth");

		// date_modified
		$this->date_modified = new crField('Canceled_Reports', 'Canceled Reports', 'x_date_modified', 'date_modified', 'a.date_modified', 135, EWRPT_DATATYPE_DATE, 7);
		$this->date_modified->FldDefaultErrMsg = str_replace("%s", "-", $ReportLanguage->Phrase("IncorrectDateDMY"));
		$this->fields['date_modified'] =& $this->date_modified;
		$this->date_modified->DateFilter = "";
		$this->date_modified->SqlSelect = "";
		$this->date_modified->SqlOrderBy = "";

		// dealer
		$this->dealer = new crField('Canceled_Reports', 'Canceled Reports', 'x_dealer', 'dealer', 'a.dealer', 200, EWRPT_DATATYPE_STRING, -1);
		$this->fields['dealer'] =& $this->dealer;
		$this->dealer->DateFilter = "";
		$this->dealer->SqlSelect = "";
		$this->dealer->SqlOrderBy = "";

		// salesman
		$this->salesman = new crField('Canceled_Reports', 'Canceled Reports', 'x_salesman', 'salesman', 'a.salesman', 200, EWRPT_DATATYPE_STRING, -1);
		$this->fields['salesman'] =& $this->salesman;
		$this->salesman->DateFilter = "";
		$this->salesman->SqlSelect = "";
		$this->salesman->SqlOrderBy = "";

		// customer
		$this->customer = new crField('Canceled_Reports', 'Canceled Reports', 'x_customer', 'customer', 'a.customer', 200, EWRPT_DATATYPE_STRING, -1);
		$this->fields['customer'] =& $this->customer;
		$this->customer->DateFilter = "";
		$this->customer->SqlSelect = "";
		$this->customer->SqlOrderBy = "";

		// idno
		$this->idno = new crField('Canceled_Reports', 'Canceled Reports', 'x_idno', 'idno', 'a.idno', 200, EWRPT_DATATYPE_STRING, -1);
		$this->fields['idno'] =& $this->idno;
		$this->idno->DateFilter = "";
		$this->idno->SqlSelect = "";
		$this->idno->SqlOrderBy = "";

		// quote ID
		$this->quote_ID = new crField('Canceled_Reports', 'Canceled Reports', 'x_quote_ID', 'quote ID', '`quote ID`', 3, EWRPT_DATATYPE_NUMBER, -1);
		$this->quote_ID->FldDefaultErrMsg = $ReportLanguage->Phrase("IncorrectInteger");
		$this->fields['quote_ID'] =& $this->quote_ID;
		$this->quote_ID->DateFilter = "";
		$this->quote_ID->SqlSelect = "";
		$this->quote_ID->SqlOrderBy = "";

		// Agree ID
		$this->Agree_ID = new crField('Canceled_Reports', 'Canceled Reports', 'x_Agree_ID', 'Agree ID', '`Agree ID`', 3, EWRPT_DATATYPE_NUMBER, -1);
		$this->Agree_ID->FldDefaultErrMsg = $ReportLanguage->Phrase("IncorrectInteger");
		$this->fields['Agree_ID'] =& $this->Agree_ID;
		$this->Agree_ID->DateFilter = "";
		$this->Agree_ID->SqlSelect = "";
		$this->Agree_ID->SqlOrderBy = "";

		// Trans ID
		$this->Trans_ID = new crField('Canceled_Reports', 'Canceled Reports', 'x_Trans_ID', 'Trans ID', '`Trans ID`', 3, EWRPT_DATATYPE_NUMBER, -1);
		$this->Trans_ID->FldDefaultErrMsg = $ReportLanguage->Phrase("IncorrectInteger");
		$this->fields['Trans_ID'] =& $this->Trans_ID;
		$this->Trans_ID->DateFilter = "";
		$this->Trans_ID->SqlSelect = "";
		$this->Trans_ID->SqlOrderBy = "";

		// total_premium
		$this->total_premium = new crField('Canceled_Reports', 'Canceled Reports', 'x_total_premium', 'total_premium', 'a.total_premium', 5, EWRPT_DATATYPE_NUMBER, -1);
		$this->total_premium->FldDefaultErrMsg = $ReportLanguage->Phrase("IncorrectFloat");
		$this->fields['total_premium'] =& $this->total_premium;
		$this->total_premium->DateFilter = "";
		$this->total_premium->SqlSelect = "";
		$this->total_premium->SqlOrderBy = "";
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
		return "report_invoice a Left Join (Select Max(qq.Id) As top, qq.transaction From road_QuoteTransactions qq Group By qq.transaction) maxQuot On maxQuot.transaction = a.trans_id Left Join road_QuoteTransactions qt On qt.Id = maxQuot.top Inner Join road_Quote_Agreement qa On qa.Id = qt.Agreement";
	}

	function SqlSelect() { // Select
		return "SELECT qa.Name \"Product Name\", a.status As \"agree_status\", a.trans_status, qt.Status As \"quote_status\", If(qt.Status != '', qt.Status, If(a.trans_status != '', a.trans_status, a.status)) As status, a.date_start, a.date_modified, a.dealer, a.salesman, a.customer, a.idno, qt.Id \"quote ID\", qa.Id \"Agree ID\", a.trans_id \"Trans ID\", a.total_premium FROM " . $this->SqlFrom();
	}

	function SqlWhere() { // Where
		return "a.status != 'Active' And a.trans_status != 'Active'";
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
$Canceled_Reports_summary = new crCanceled_Reports_summary();
$Page =& $Canceled_Reports_summary;

// Page init
$Canceled_Reports_summary->Page_Init();

// Page main
$Canceled_Reports_summary->Page_Main();
?>
<?php include_once "phprptinc/header.php"; ?>
<?php if ($Canceled_Reports->Export == "" || $Canceled_Reports->Export == "print" || $Canceled_Reports->Export == "email") { ?>
<script type="text/javascript">

// Create page object
var Canceled_Reports_summary = new ewrpt_Page("Canceled_Reports_summary");

// page properties
Canceled_Reports_summary.PageID = "summary"; // page ID
Canceled_Reports_summary.FormID = "fCanceled_Reportssummaryfilter"; // form ID
var EWRPT_PAGE_ID = Canceled_Reports_summary.PageID;

// extend page with Chart_Rendering function
Canceled_Reports_summary.Chart_Rendering =  
 function(chart, chartid) { // DO NOT CHANGE THIS LINE!

 	//alert(chartid);
 }

// extend page with Chart_Rendered function
Canceled_Reports_summary.Chart_Rendered =  
 function(chart, chartid) { // DO NOT CHANGE THIS LINE!

 	//alert(chartid);
 }
</script>
<?php } ?>
<?php if ($Canceled_Reports->Export == "") { ?>
<script type="text/javascript">

// extend page with ValidateForm function
Canceled_Reports_summary.ValidateForm = function(fobj) {
	if (!this.ValidateRequired)
		return true; // ignore validation

	// Call Form Custom Validate event
	if (!this.Form_CustomValidate(fobj)) return false;
	return true;
}

// extend page with Form_CustomValidate function
Canceled_Reports_summary.Form_CustomValidate =  
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }
<?php if (EWRPT_CLIENT_VALIDATE) { ?>
Canceled_Reports_summary.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
Canceled_Reports_summary.ValidateRequired = false; // no JavaScript validation
<?php } ?>
</script>
<script language="JavaScript" type="text/javascript">
<!--

// Write your client script here, no need to add script tags.
//-->

</script>
<?php } ?>
<?php if ($Canceled_Reports->Export == "" || $Canceled_Reports->Export == "print" || $Canceled_Reports->Export == "email") { ?>
<script src="<?php echo EWRPT_FUSIONCHARTS_FREE_JSCLASS_FILE; ?>" type="text/javascript"></script>
<?php } ?>
<?php if ($Canceled_Reports->Export == "") { ?>
<div id="ewrpt_PopupFilter"><div class="bd"></div></div>
<script src="phprptjs/ewrptpop.js" type="text/javascript"></script>
<script type="text/javascript">

// popup fields
</script>
<?php } ?>
<?php if ($Canceled_Reports->Export == "" || $Canceled_Reports->Export == "print" || $Canceled_Reports->Export == "email") { ?>
<!-- Table Container (Begin) -->
<table id="ewContainer" cellspacing="0" cellpadding="0" border="0">
<!-- Top Container (Begin) -->
<tr><td colspan="3"><div id="ewTop" class="phpreportmaker">
<!-- top slot -->
<a name="top"></a>
<?php } ?>
<p class="phpreportmaker ewTitle"><?php echo $Canceled_Reports->TableCaption() ?>
&nbsp;&nbsp;<?php $Canceled_Reports_summary->ExportOptions->Render("body"); ?></p>
<?php $Canceled_Reports_summary->ShowPageHeader(); ?>
<?php $Canceled_Reports_summary->ShowMessage(); ?>
<br /><br />
<?php if ($Canceled_Reports->Export == "" || $Canceled_Reports->Export == "print" || $Canceled_Reports->Export == "email") { ?>
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
<?php if ($Canceled_Reports->Export == "") { ?>
<?php
if ($Canceled_Reports->FilterPanelOption == 2 || ($Canceled_Reports->FilterPanelOption == 3 && $Canceled_Reports_summary->FilterApplied) || $Canceled_Reports_summary->Filter == "0=101") {
	$sButtonImage = "phprptimages/collapse.gif";
	$sDivDisplay = "";
} else {
	$sButtonImage = "phprptimages/expand.gif";
	$sDivDisplay = " style=\"display: none;\"";
}
?>
<a href="javascript:ewrpt_ToggleFilterPanel();" style="text-decoration: none;"><img id="ewrptToggleFilterImg" src="<?php echo $sButtonImage ?>" alt="" width="9" height="9" border="0"></a><span class="phpreportmaker">&nbsp;<?php echo $ReportLanguage->Phrase("Filters") ?></span><br /><br />
<div id="ewrptExtFilterPanel"<?php echo $sDivDisplay ?>>
<!-- Search form (begin) -->
<form name="fCanceled_Reportssummaryfilter" id="fCanceled_Reportssummaryfilter" action="<?php echo ewrpt_CurrentPage() ?>" class="ewForm" onsubmit="return Canceled_Reports_summary.ValidateForm(this);">
<table class="ewRptExtFilter">
	<tr id="r_date_start">
		<td><span class="phpreportmaker"><?php echo $Canceled_Reports->date_start->FldCaption() ?></span></td>
		<td></td>
		<td colspan="4"><span class="ewRptSearchOpr">
		<select name="sv_date_start" id="sv_date_start"<?php echo ($Canceled_Reports_summary->ClearExtFilter == 'Canceled_Reports_date_start') ? " class=\"ewInputCleared\"" : "" ?>>
		<option value="<?php echo EWRPT_ALL_VALUE; ?>"<?php if (ewrpt_MatchedFilterValue($Canceled_Reports->date_start->DropDownValue, EWRPT_ALL_VALUE)) echo " selected=\"selected\""; ?>><?php echo $ReportLanguage->Phrase("PleaseSelect"); ?></option>
<?php

// Popup filter
$cntf = is_array($Canceled_Reports->date_start->AdvancedFilters) ? count($Canceled_Reports->date_start->AdvancedFilters) : 0;
$cntd = is_array($Canceled_Reports->date_start->DropDownList) ? count($Canceled_Reports->date_start->DropDownList) : 0;
$totcnt = $cntf + $cntd;
$wrkcnt = 0;
	if ($cntf > 0) {
		foreach ($Canceled_Reports->date_start->AdvancedFilters as $filter) {
			if ($filter->Enabled) {
?>
		<option value="<?php echo $filter->ID ?>"<?php if (ewrpt_MatchedFilterValue($Canceled_Reports->date_start->DropDownValue, $filter->ID)) echo " selected=\"selected\"" ?>><?php echo $filter->Name ?></option>
<?php
				$wrkcnt += 1;
			}
		}
	}
	for ($i = 0; $i < $cntd; $i++) {
?>
		<option value="<?php echo $Canceled_Reports->date_start->DropDownList[$i] ?>"<?php if (ewrpt_MatchedFilterValue($Canceled_Reports->date_start->DropDownValue, $Canceled_Reports->date_start->DropDownList[$i])) echo " selected=\"selected\"" ?>><?php echo ewrpt_DropDownDisplayValue($Canceled_Reports->date_start->DropDownList[$i], $Canceled_Reports->date_start->DateFilter, 7) ?></option>
<?php
		$wrkcnt += 1;
	}
?>
		</select>
		</span></td>
	</tr>
	<tr id="r_dealer">
		<td><span class="phpreportmaker"><?php echo $Canceled_Reports->dealer->FldCaption() ?></span></td>
		<td></td>
		<td colspan="4"><span class="ewRptSearchOpr">
		<select name="sv_dealer" id="sv_dealer"<?php echo ($Canceled_Reports_summary->ClearExtFilter == 'Canceled_Reports_dealer') ? " class=\"ewInputCleared\"" : "" ?>>
		<option value="<?php echo EWRPT_ALL_VALUE; ?>"<?php if (ewrpt_MatchedFilterValue($Canceled_Reports->dealer->DropDownValue, EWRPT_ALL_VALUE)) echo " selected=\"selected\""; ?>><?php echo $ReportLanguage->Phrase("PleaseSelect"); ?></option>
<?php

// Popup filter
$cntf = is_array($Canceled_Reports->dealer->AdvancedFilters) ? count($Canceled_Reports->dealer->AdvancedFilters) : 0;
$cntd = is_array($Canceled_Reports->dealer->DropDownList) ? count($Canceled_Reports->dealer->DropDownList) : 0;
$totcnt = $cntf + $cntd;
$wrkcnt = 0;
	if ($cntf > 0) {
		foreach ($Canceled_Reports->dealer->AdvancedFilters as $filter) {
			if ($filter->Enabled) {
?>
		<option value="<?php echo $filter->ID ?>"<?php if (ewrpt_MatchedFilterValue($Canceled_Reports->dealer->DropDownValue, $filter->ID)) echo " selected=\"selected\"" ?>><?php echo $filter->Name ?></option>
<?php
				$wrkcnt += 1;
			}
		}
	}
	for ($i = 0; $i < $cntd; $i++) {
?>
		<option value="<?php echo $Canceled_Reports->dealer->DropDownList[$i] ?>"<?php if (ewrpt_MatchedFilterValue($Canceled_Reports->dealer->DropDownValue, $Canceled_Reports->dealer->DropDownList[$i])) echo " selected=\"selected\"" ?>><?php echo ewrpt_DropDownDisplayValue($Canceled_Reports->dealer->DropDownList[$i], "", 0) ?></option>
<?php
		$wrkcnt += 1;
	}
?>
		</select>
		</span></td>
	</tr>
	<tr id="r_salesman">
		<td><span class="phpreportmaker"><?php echo $Canceled_Reports->salesman->FldCaption() ?></span></td>
		<td></td>
		<td colspan="4"><span class="ewRptSearchOpr">
		<select name="sv_salesman" id="sv_salesman"<?php echo ($Canceled_Reports_summary->ClearExtFilter == 'Canceled_Reports_salesman') ? " class=\"ewInputCleared\"" : "" ?>>
		<option value="<?php echo EWRPT_ALL_VALUE; ?>"<?php if (ewrpt_MatchedFilterValue($Canceled_Reports->salesman->DropDownValue, EWRPT_ALL_VALUE)) echo " selected=\"selected\""; ?>><?php echo $ReportLanguage->Phrase("PleaseSelect"); ?></option>
<?php

// Popup filter
$cntf = is_array($Canceled_Reports->salesman->AdvancedFilters) ? count($Canceled_Reports->salesman->AdvancedFilters) : 0;
$cntd = is_array($Canceled_Reports->salesman->DropDownList) ? count($Canceled_Reports->salesman->DropDownList) : 0;
$totcnt = $cntf + $cntd;
$wrkcnt = 0;
	if ($cntf > 0) {
		foreach ($Canceled_Reports->salesman->AdvancedFilters as $filter) {
			if ($filter->Enabled) {
?>
		<option value="<?php echo $filter->ID ?>"<?php if (ewrpt_MatchedFilterValue($Canceled_Reports->salesman->DropDownValue, $filter->ID)) echo " selected=\"selected\"" ?>><?php echo $filter->Name ?></option>
<?php
				$wrkcnt += 1;
			}
		}
	}
	for ($i = 0; $i < $cntd; $i++) {
?>
		<option value="<?php echo $Canceled_Reports->salesman->DropDownList[$i] ?>"<?php if (ewrpt_MatchedFilterValue($Canceled_Reports->salesman->DropDownValue, $Canceled_Reports->salesman->DropDownList[$i])) echo " selected=\"selected\"" ?>><?php echo ewrpt_DropDownDisplayValue($Canceled_Reports->salesman->DropDownList[$i], "", 0) ?></option>
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
<br />
<?php } ?>
<?php if ($Canceled_Reports->ShowCurrentFilter) { ?>
<div id="ewrptFilterList">
<?php $Canceled_Reports_summary->ShowFilterList() ?>
</div>
<br />
<?php } ?>
<table class="ewGrid" cellspacing="0"><tr>
	<td class="ewGridContent">
<!-- Report Grid (Begin) -->
<div class="ewGridMiddlePanel">
<table class="<?php echo $Canceled_Reports_summary->ReportTableClass ?>" cellspacing="0">
<?php

// Set the last group to display if not export all
if ($Canceled_Reports->ExportAll && $Canceled_Reports->Export <> "") {
	$Canceled_Reports_summary->StopGrp = $Canceled_Reports_summary->TotalGrps;
} else {
	$Canceled_Reports_summary->StopGrp = $Canceled_Reports_summary->StartGrp + $Canceled_Reports_summary->DisplayGrps - 1;
}

// Stop group <= total number of groups
if (intval($Canceled_Reports_summary->StopGrp) > intval($Canceled_Reports_summary->TotalGrps))
	$Canceled_Reports_summary->StopGrp = $Canceled_Reports_summary->TotalGrps;
$Canceled_Reports_summary->RecCount = 0;

// Get first row
if ($Canceled_Reports_summary->TotalGrps > 0) {
	$Canceled_Reports_summary->GetRow(1);
	$Canceled_Reports_summary->GrpCount = 1;
}
while (($rs && !$rs->EOF && $Canceled_Reports_summary->GrpCount <= $Canceled_Reports_summary->DisplayGrps) || $Canceled_Reports_summary->ShowFirstHeader) {

	// Show header
	if ($Canceled_Reports_summary->ShowFirstHeader) {
?>
	<thead>
	<tr>
<td class="ewTableHeader">
<?php if ($Canceled_Reports->Export <> "") { ?>
<?php echo $Canceled_Reports->Product_Name->FldCaption() ?>
<?php } else { ?>
	<table cellspacing="0" class="ewTableHeaderBtn"><tr>
<?php if ($Canceled_Reports->SortUrl($Canceled_Reports->Product_Name) == "") { ?>
		<td style="vertical-align: bottom;"><?php echo $Canceled_Reports->Product_Name->FldCaption() ?></td>
<?php } else { ?>
		<td class="ewPointer" onmousedown="ewrpt_Sort(event,'<?php echo $Canceled_Reports->SortUrl($Canceled_Reports->Product_Name) ?>',0);"><?php echo $Canceled_Reports->Product_Name->FldCaption() ?></td><td style="width: 10px;">
		<?php if ($Canceled_Reports->Product_Name->getSort() == "ASC") { ?><img src="phprptimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($Canceled_Reports->Product_Name->getSort() == "DESC") { ?><img src="phprptimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td>
<?php } ?>
	</tr></table>
<?php } ?>
</td>
<td class="ewTableHeader">
<?php if ($Canceled_Reports->Export <> "") { ?>
<?php echo $Canceled_Reports->status->FldCaption() ?>
<?php } else { ?>
	<table cellspacing="0" class="ewTableHeaderBtn"><tr>
<?php if ($Canceled_Reports->SortUrl($Canceled_Reports->status) == "") { ?>
		<td style="vertical-align: bottom;"><?php echo $Canceled_Reports->status->FldCaption() ?></td>
<?php } else { ?>
		<td class="ewPointer" onmousedown="ewrpt_Sort(event,'<?php echo $Canceled_Reports->SortUrl($Canceled_Reports->status) ?>',0);"><?php echo $Canceled_Reports->status->FldCaption() ?></td><td style="width: 10px;">
		<?php if ($Canceled_Reports->status->getSort() == "ASC") { ?><img src="phprptimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($Canceled_Reports->status->getSort() == "DESC") { ?><img src="phprptimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td>
<?php } ?>
	</tr></table>
<?php } ?>
</td>
<td class="ewTableHeader">
<?php if ($Canceled_Reports->Export <> "") { ?>
<?php echo $Canceled_Reports->date_start->FldCaption() ?>
<?php } else { ?>
	<table cellspacing="0" class="ewTableHeaderBtn"><tr>
<?php if ($Canceled_Reports->SortUrl($Canceled_Reports->date_start) == "") { ?>
		<td style="vertical-align: bottom;"><?php echo $Canceled_Reports->date_start->FldCaption() ?></td>
<?php } else { ?>
		<td class="ewPointer" onmousedown="ewrpt_Sort(event,'<?php echo $Canceled_Reports->SortUrl($Canceled_Reports->date_start) ?>',0);"><?php echo $Canceled_Reports->date_start->FldCaption() ?></td><td style="width: 10px;">
		<?php if ($Canceled_Reports->date_start->getSort() == "ASC") { ?><img src="phprptimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($Canceled_Reports->date_start->getSort() == "DESC") { ?><img src="phprptimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td>
<?php } ?>
	</tr></table>
<?php } ?>
</td>
<td class="ewTableHeader">
<?php if ($Canceled_Reports->Export <> "") { ?>
<?php echo $Canceled_Reports->date_modified->FldCaption() ?>
<?php } else { ?>
	<table cellspacing="0" class="ewTableHeaderBtn"><tr>
<?php if ($Canceled_Reports->SortUrl($Canceled_Reports->date_modified) == "") { ?>
		<td style="vertical-align: bottom;"><?php echo $Canceled_Reports->date_modified->FldCaption() ?></td>
<?php } else { ?>
		<td class="ewPointer" onmousedown="ewrpt_Sort(event,'<?php echo $Canceled_Reports->SortUrl($Canceled_Reports->date_modified) ?>',0);"><?php echo $Canceled_Reports->date_modified->FldCaption() ?></td><td style="width: 10px;">
		<?php if ($Canceled_Reports->date_modified->getSort() == "ASC") { ?><img src="phprptimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($Canceled_Reports->date_modified->getSort() == "DESC") { ?><img src="phprptimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td>
<?php } ?>
	</tr></table>
<?php } ?>
</td>
<td class="ewTableHeader">
<?php if ($Canceled_Reports->Export <> "") { ?>
<?php echo $Canceled_Reports->dealer->FldCaption() ?>
<?php } else { ?>
	<table cellspacing="0" class="ewTableHeaderBtn"><tr>
<?php if ($Canceled_Reports->SortUrl($Canceled_Reports->dealer) == "") { ?>
		<td style="vertical-align: bottom;"><?php echo $Canceled_Reports->dealer->FldCaption() ?></td>
<?php } else { ?>
		<td class="ewPointer" onmousedown="ewrpt_Sort(event,'<?php echo $Canceled_Reports->SortUrl($Canceled_Reports->dealer) ?>',0);"><?php echo $Canceled_Reports->dealer->FldCaption() ?></td><td style="width: 10px;">
		<?php if ($Canceled_Reports->dealer->getSort() == "ASC") { ?><img src="phprptimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($Canceled_Reports->dealer->getSort() == "DESC") { ?><img src="phprptimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td>
<?php } ?>
	</tr></table>
<?php } ?>
</td>
<td class="ewTableHeader">
<?php if ($Canceled_Reports->Export <> "") { ?>
<?php echo $Canceled_Reports->salesman->FldCaption() ?>
<?php } else { ?>
	<table cellspacing="0" class="ewTableHeaderBtn"><tr>
<?php if ($Canceled_Reports->SortUrl($Canceled_Reports->salesman) == "") { ?>
		<td style="vertical-align: bottom;"><?php echo $Canceled_Reports->salesman->FldCaption() ?></td>
<?php } else { ?>
		<td class="ewPointer" onmousedown="ewrpt_Sort(event,'<?php echo $Canceled_Reports->SortUrl($Canceled_Reports->salesman) ?>',0);"><?php echo $Canceled_Reports->salesman->FldCaption() ?></td><td style="width: 10px;">
		<?php if ($Canceled_Reports->salesman->getSort() == "ASC") { ?><img src="phprptimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($Canceled_Reports->salesman->getSort() == "DESC") { ?><img src="phprptimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td>
<?php } ?>
	</tr></table>
<?php } ?>
</td>
<td class="ewTableHeader">
<?php if ($Canceled_Reports->Export <> "") { ?>
<?php echo $Canceled_Reports->customer->FldCaption() ?>
<?php } else { ?>
	<table cellspacing="0" class="ewTableHeaderBtn"><tr>
<?php if ($Canceled_Reports->SortUrl($Canceled_Reports->customer) == "") { ?>
		<td style="vertical-align: bottom;"><?php echo $Canceled_Reports->customer->FldCaption() ?></td>
<?php } else { ?>
		<td class="ewPointer" onmousedown="ewrpt_Sort(event,'<?php echo $Canceled_Reports->SortUrl($Canceled_Reports->customer) ?>',0);"><?php echo $Canceled_Reports->customer->FldCaption() ?></td><td style="width: 10px;">
		<?php if ($Canceled_Reports->customer->getSort() == "ASC") { ?><img src="phprptimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($Canceled_Reports->customer->getSort() == "DESC") { ?><img src="phprptimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td>
<?php } ?>
	</tr></table>
<?php } ?>
</td>
<td class="ewTableHeader">
<?php if ($Canceled_Reports->Export <> "") { ?>
<?php echo $Canceled_Reports->idno->FldCaption() ?>
<?php } else { ?>
	<table cellspacing="0" class="ewTableHeaderBtn"><tr>
<?php if ($Canceled_Reports->SortUrl($Canceled_Reports->idno) == "") { ?>
		<td style="vertical-align: bottom;"><?php echo $Canceled_Reports->idno->FldCaption() ?></td>
<?php } else { ?>
		<td class="ewPointer" onmousedown="ewrpt_Sort(event,'<?php echo $Canceled_Reports->SortUrl($Canceled_Reports->idno) ?>',0);"><?php echo $Canceled_Reports->idno->FldCaption() ?></td><td style="width: 10px;">
		<?php if ($Canceled_Reports->idno->getSort() == "ASC") { ?><img src="phprptimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($Canceled_Reports->idno->getSort() == "DESC") { ?><img src="phprptimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td>
<?php } ?>
	</tr></table>
<?php } ?>
</td>
<td class="ewTableHeader">
<?php if ($Canceled_Reports->Export <> "") { ?>
<?php echo $Canceled_Reports->total_premium->FldCaption() ?>
<?php } else { ?>
	<table cellspacing="0" class="ewTableHeaderBtn"><tr>
<?php if ($Canceled_Reports->SortUrl($Canceled_Reports->total_premium) == "") { ?>
		<td style="vertical-align: bottom;"><?php echo $Canceled_Reports->total_premium->FldCaption() ?></td>
<?php } else { ?>
		<td class="ewPointer" onmousedown="ewrpt_Sort(event,'<?php echo $Canceled_Reports->SortUrl($Canceled_Reports->total_premium) ?>',0);"><?php echo $Canceled_Reports->total_premium->FldCaption() ?></td><td style="width: 10px;">
		<?php if ($Canceled_Reports->total_premium->getSort() == "ASC") { ?><img src="phprptimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($Canceled_Reports->total_premium->getSort() == "DESC") { ?><img src="phprptimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td>
<?php } ?>
	</tr></table>
<?php } ?>
</td>
	</tr>
	</thead>
	<tbody>
<?php
		$Canceled_Reports_summary->ShowFirstHeader = FALSE;
	}
	$Canceled_Reports_summary->RecCount++;

		// Render detail row
		$Canceled_Reports->ResetCSS();
		$Canceled_Reports->RowType = EWRPT_ROWTYPE_DETAIL;
		$Canceled_Reports_summary->RenderRow();
?>
	<tr<?php echo $Canceled_Reports->RowAttributes(); ?>>
		<td<?php echo $Canceled_Reports->Product_Name->CellAttributes() ?>>
<span<?php echo $Canceled_Reports->Product_Name->ViewAttributes(); ?>><?php echo $Canceled_Reports->Product_Name->ListViewValue(); ?></span></td>
		<td<?php echo $Canceled_Reports->status->CellAttributes() ?>>
<span<?php echo $Canceled_Reports->status->ViewAttributes(); ?>><?php echo $Canceled_Reports->status->ListViewValue(); ?></span></td>
		<td<?php echo $Canceled_Reports->date_start->CellAttributes() ?>>
<span<?php echo $Canceled_Reports->date_start->ViewAttributes(); ?>><?php echo $Canceled_Reports->date_start->ListViewValue(); ?></span></td>
		<td<?php echo $Canceled_Reports->date_modified->CellAttributes() ?>>
<span<?php echo $Canceled_Reports->date_modified->ViewAttributes(); ?>><?php echo $Canceled_Reports->date_modified->ListViewValue(); ?></span></td>
		<td<?php echo $Canceled_Reports->dealer->CellAttributes() ?>>
<span<?php echo $Canceled_Reports->dealer->ViewAttributes(); ?>><?php echo $Canceled_Reports->dealer->ListViewValue(); ?></span></td>
		<td<?php echo $Canceled_Reports->salesman->CellAttributes() ?>>
<span<?php echo $Canceled_Reports->salesman->ViewAttributes(); ?>><?php echo $Canceled_Reports->salesman->ListViewValue(); ?></span></td>
		<td<?php echo $Canceled_Reports->customer->CellAttributes() ?>>
<span<?php echo $Canceled_Reports->customer->ViewAttributes(); ?>><?php echo $Canceled_Reports->customer->ListViewValue(); ?></span></td>
		<td<?php echo $Canceled_Reports->idno->CellAttributes() ?>>
<span<?php echo $Canceled_Reports->idno->ViewAttributes(); ?>><?php echo $Canceled_Reports->idno->ListViewValue(); ?></span></td>
		<td<?php echo $Canceled_Reports->total_premium->CellAttributes() ?>>
<span<?php echo $Canceled_Reports->total_premium->ViewAttributes(); ?>><?php echo $Canceled_Reports->total_premium->ListViewValue(); ?></span></td>
	</tr>
<?php

		// Accumulate page summary
		$Canceled_Reports_summary->AccumulateSummary();

		// Get next record
		$Canceled_Reports_summary->GetRow(2);
	$Canceled_Reports_summary->GrpCount++;
} // End while
?>
	</tbody>
	<tfoot>
<?php
if ($Canceled_Reports_summary->TotalGrps > 0) {
	$Canceled_Reports->ResetCSS();
	$Canceled_Reports->RowType = EWRPT_ROWTYPE_TOTAL;
	$Canceled_Reports->RowTotalType = EWRPT_ROWTOTAL_GRAND;
	$Canceled_Reports->RowTotalSubType = EWRPT_ROWTOTAL_FOOTER;
	$Canceled_Reports->RowAttrs["class"] = "ewRptGrandSummary";
	$Canceled_Reports_summary->RenderRow();
?>
	<!-- tr><td colspan="9"><span class="phpreportmaker">&nbsp;<br /></span></td></tr -->
	<tr<?php echo $Canceled_Reports->RowAttributes(); ?>><td colspan="9"><?php echo $ReportLanguage->Phrase("RptGrandTotal") ?> (<?php echo ewrpt_FormatNumber($Canceled_Reports_summary->TotCount,0,-2,-2,-2); ?><?php echo $ReportLanguage->Phrase("RptDtlRec") ?>)</td></tr>
<?php } ?>
	</tfoot>
</table>
</div>
<?php if ($Canceled_Reports->Export == "") { ?>
<div class="ewGridLowerPanel">
<form action="<?php echo ewrpt_CurrentPage() ?>" name="ewpagerform" id="ewpagerform" class="ewForm">
<table border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td style="white-space: nowrap;">
<?php if (!isset($Pager)) $Pager = new crPrevNextPager($Canceled_Reports_summary->StartGrp, $Canceled_Reports_summary->DisplayGrps, $Canceled_Reports_summary->TotalGrps) ?>
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
	<?php if ($Canceled_Reports_summary->Filter == "0=101") { ?>
	<span class="phpreportmaker"><?php echo $ReportLanguage->Phrase("EnterSearchCriteria") ?></span>
	<?php } else { ?>
	<span class="phpreportmaker"><?php echo $ReportLanguage->Phrase("NoRecord") ?></span>
	<?php } ?>
<?php } ?>
		</td>
<?php if ($Canceled_Reports_summary->TotalGrps > 0) { ?>
		<td style="white-space: nowrap;">&nbsp;&nbsp;&nbsp;&nbsp;</td>
		<td align="right" style="vertical-align: top; white-space: nowrap;"><span class="phpreportmaker"><?php echo $ReportLanguage->Phrase("GroupsPerPage"); ?>&nbsp;
<select name="<?php echo EWRPT_TABLE_GROUP_PER_PAGE; ?>" onchange="this.form.submit();">
<option value="1"<?php if ($Canceled_Reports_summary->DisplayGrps == 1) echo " selected=\"selected\"" ?>>1</option>
<option value="2"<?php if ($Canceled_Reports_summary->DisplayGrps == 2) echo " selected=\"selected\"" ?>>2</option>
<option value="3"<?php if ($Canceled_Reports_summary->DisplayGrps == 3) echo " selected=\"selected\"" ?>>3</option>
<option value="4"<?php if ($Canceled_Reports_summary->DisplayGrps == 4) echo " selected=\"selected\"" ?>>4</option>
<option value="5"<?php if ($Canceled_Reports_summary->DisplayGrps == 5) echo " selected=\"selected\"" ?>>5</option>
<option value="10"<?php if ($Canceled_Reports_summary->DisplayGrps == 10) echo " selected=\"selected\"" ?>>10</option>
<option value="20"<?php if ($Canceled_Reports_summary->DisplayGrps == 20) echo " selected=\"selected\"" ?>>20</option>
<option value="50"<?php if ($Canceled_Reports_summary->DisplayGrps == 50) echo " selected=\"selected\"" ?>>50</option>
<option value="ALL"<?php if ($Canceled_Reports->getGroupPerPage() == -1) echo " selected=\"selected\"" ?>><?php echo $ReportLanguage->Phrase("AllRecords") ?></option>
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
<?php if ($Canceled_Reports->Export == "" || $Canceled_Reports->Export == "print" || $Canceled_Reports->Export == "email") { ?>
	</div><br /></td>
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
	</div><br /></td></tr>
<!-- Bottom Container (End) -->
</table>
<!-- Table Container (End) -->
<?php } ?>
<?php $Canceled_Reports_summary->ShowPageFooter(); ?>
<?php if (EWRPT_DEBUG_ENABLED) echo ewrpt_DebugMsg(); ?>
<?php

// Close recordsets
if ($rsgrp) $rsgrp->Close();
if ($rs) $rs->Close();
?>
<?php if ($Canceled_Reports->Export == "") { ?>
<script language="JavaScript" type="text/javascript">
<!--

// Write your table-specific startup script here
// document.write("page loaded");
//-->

</script>
<?php } ?>
<?php include_once "phprptinc/footer.php"; ?>
<?php
$Canceled_Reports_summary->Page_Terminate();
?>
<?php

//
// Page class
//
class crCanceled_Reports_summary {

	// Page ID
	var $PageID = 'summary';

	// Table name
	var $TableName = 'Canceled Reports';

	// Page object name
	var $PageObjName = 'Canceled_Reports_summary';

	// Page name
	function PageName() {
		return ewrpt_CurrentPage();
	}

	// Page URL
	function PageUrl() {
		$PageUrl = ewrpt_CurrentPage() . "?";
		global $Canceled_Reports;
		if ($Canceled_Reports->UseTokenInUrl) $PageUrl .= "t=" . $Canceled_Reports->TableVar . "&"; // Add page token
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
			$_SESSION[EWRPT_SESSION_MESSAGE] .= "<br />" . $v;
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
		global $Canceled_Reports;
		if ($Canceled_Reports->UseTokenInUrl) {
			if (ewrpt_IsHttpPost())
				return ($Canceled_Reports->TableVar == @$_POST("t"));
			if (@$_GET["t"] <> "")
				return ($Canceled_Reports->TableVar == @$_GET["t"]);
		} else {
			return TRUE;
		}
	}

	//
	// Page class constructor
	//
	function crCanceled_Reports_summary() {
		global $conn, $ReportLanguage;

		// Language object
		$ReportLanguage = new crLanguage();

		// Table object (Canceled_Reports)
		$GLOBALS["Canceled_Reports"] = new crCanceled_Reports();
		$GLOBALS["Table"] =& $GLOBALS["Canceled_Reports"];

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
			define("EWRPT_TABLE_NAME", 'Canceled Reports', TRUE);

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
		global $Canceled_Reports;

		// Security
		$Security = new crAdvancedSecurity();
		if (!$Security->IsLoggedIn()) $Security->AutoLogin(); // Auto login
		if (!$Security->IsLoggedIn()) {
			$Security->SaveLastUrl();
			$this->Page_Terminate("rlogin.php");
		}

		// Get export parameters
		if (@$_GET["export"] <> "") {
			$Canceled_Reports->Export = $_GET["export"];
		}
		$gsExport = $Canceled_Reports->Export; // Get export parameter, used in header
		$gsExportFile = $Canceled_Reports->TableVar; // Get export file, used in header
		if ($Canceled_Reports->Export == "excel") {
			header('Content-Type: application/vnd.ms-excel;charset=utf-8');
			header('Content-Disposition: attachment; filename=' . $gsExportFile .'.xls');
		}
		if ($Canceled_Reports->Export == "word") {
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
		global $ReportLanguage, $Canceled_Reports;

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
		$item->Body = "<a name=\"emf_Canceled_Reports\" id=\"emf_Canceled_Reports\" href=\"javascript:void(0);\" onclick=\"ewrpt_EmailDialogShow({lnk:'emf_Canceled_Reports',hdr:ewLanguage.Phrase('ExportToEmail')});\">" . $ReportLanguage->Phrase("ExportToEmail") . "</a>";
		$item->Visible = FALSE;

		// Reset filter
		$item =& $this->ExportOptions->Add("resetfilter");
		$item->Body = "<a href=\"" . ewrpt_CurrentPage() . "?cmd=reset\">" . $ReportLanguage->Phrase("ResetAllFilter") . "</a>";
		$item->Visible = TRUE;
		$this->SetupExportOptionsExt();

		// Hide options for export
		if ($Canceled_Reports->Export <> "")
			$this->ExportOptions->HideAllOptions();

		// Set up table class
		if ($Canceled_Reports->Export == "word" || $Canceled_Reports->Export == "excel" || $Canceled_Reports->Export == "pdf")
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
		global $Canceled_Reports;

		// Page Unload event
		$this->Page_Unload();

		// Global Page Unloaded event (in userfn*.php)
		Page_Unloaded();

		// Export to Email (use ob_file_contents for PHP)
		if ($Canceled_Reports->Export == "email") {
			$sContent = ob_get_contents();
			$this->ExportEmail($sContent);
			ob_end_clean();

			 // Close connection
			$conn->Close();
			header("Location: " . ewrpt_CurrentPage());
			exit();
		}

		// Export to PDF (use ob_file_contents for PHP)
		if ($Canceled_Reports->Export == "pdf") {
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
		global $Canceled_Reports;
		global $rs;
		global $rsgrp;
		global $gsFormError;

		// Aggregate variables
		// 1st dimension = no of groups (level 0 used for grand total)
		// 2nd dimension = no of fields

		$nDtls = 10;
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
		$this->Col = array(FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE);

		// Set up groups per page dynamically
		$this->SetUpDisplayGrps();

		// Load default filter values
		$this->LoadDefaultFilters();

		// Load custom filters
		$Canceled_Reports->Filters_Load();

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
		$this->ExportOptions->GetItem("resetfilter")->Visible = $this->FilterApplied;

		// Get sort
		$this->Sort = $this->GetSort();

		// Get total count
		$sSql = ewrpt_BuildReportSql($Canceled_Reports->SqlSelect(), $Canceled_Reports->SqlWhere(), $Canceled_Reports->SqlGroupBy(), $Canceled_Reports->SqlHaving(), $Canceled_Reports->SqlOrderBy(), $this->Filter, $this->Sort);
		$this->TotalGrps = $this->GetCnt($sSql);
		if ($this->DisplayGrps <= 0) // Display all groups
			$this->DisplayGrps = $this->TotalGrps;
		$this->StartGrp = 1;

		// Show header
		$this->ShowFirstHeader = ($this->TotalGrps > 0);

		//$this->ShowFirstHeader = TRUE; // Uncomment to always show header
		// Set up start position if not export all

		if ($Canceled_Reports->ExportAll && $Canceled_Reports->Export <> "")
		    $this->DisplayGrps = $this->TotalGrps;
		else
			$this->SetUpStartGroup(); 

		// Hide all options if export
		if ($Canceled_Reports->Export <> "") {
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
		global $Canceled_Reports;
		if (!$rs)
			return;
		if ($opt == 1) { // Get first row

	//		$rs->MoveFirst(); // NOTE: no need to move position
		} else { // Get next row
			$rs->MoveNext();
		}
		if (!$rs->EOF) {
			$Canceled_Reports->Product_Name->setDbValue($rs->fields('Product Name'));
			$Canceled_Reports->agree_status->setDbValue($rs->fields('agree_status'));
			$Canceled_Reports->trans_status->setDbValue($rs->fields('trans_status'));
			$Canceled_Reports->quote_status->setDbValue($rs->fields('quote_status'));
			$Canceled_Reports->status->setDbValue($rs->fields('status'));
			$Canceled_Reports->date_start->setDbValue($rs->fields('date_start'));
			$Canceled_Reports->date_modified->setDbValue($rs->fields('date_modified'));
			$Canceled_Reports->dealer->setDbValue($rs->fields('dealer'));
			$Canceled_Reports->salesman->setDbValue($rs->fields('salesman'));
			$Canceled_Reports->customer->setDbValue($rs->fields('customer'));
			$Canceled_Reports->idno->setDbValue($rs->fields('idno'));
			$Canceled_Reports->quote_ID->setDbValue($rs->fields('quote ID'));
			$Canceled_Reports->Agree_ID->setDbValue($rs->fields('Agree ID'));
			$Canceled_Reports->Trans_ID->setDbValue($rs->fields('Trans ID'));
			$Canceled_Reports->total_premium->setDbValue($rs->fields('total_premium'));
			$this->Val[1] = $Canceled_Reports->Product_Name->CurrentValue;
			$this->Val[2] = $Canceled_Reports->status->CurrentValue;
			$this->Val[3] = $Canceled_Reports->date_start->CurrentValue;
			$this->Val[4] = $Canceled_Reports->date_modified->CurrentValue;
			$this->Val[5] = $Canceled_Reports->dealer->CurrentValue;
			$this->Val[6] = $Canceled_Reports->salesman->CurrentValue;
			$this->Val[7] = $Canceled_Reports->customer->CurrentValue;
			$this->Val[8] = $Canceled_Reports->idno->CurrentValue;
			$this->Val[9] = $Canceled_Reports->total_premium->CurrentValue;
		} else {
			$Canceled_Reports->Product_Name->setDbValue("");
			$Canceled_Reports->agree_status->setDbValue("");
			$Canceled_Reports->trans_status->setDbValue("");
			$Canceled_Reports->quote_status->setDbValue("");
			$Canceled_Reports->status->setDbValue("");
			$Canceled_Reports->date_start->setDbValue("");
			$Canceled_Reports->date_modified->setDbValue("");
			$Canceled_Reports->dealer->setDbValue("");
			$Canceled_Reports->salesman->setDbValue("");
			$Canceled_Reports->customer->setDbValue("");
			$Canceled_Reports->idno->setDbValue("");
			$Canceled_Reports->quote_ID->setDbValue("");
			$Canceled_Reports->Agree_ID->setDbValue("");
			$Canceled_Reports->Trans_ID->setDbValue("");
			$Canceled_Reports->total_premium->setDbValue("");
		}
	}

	//  Set up starting group
	function SetUpStartGroup() {
		global $Canceled_Reports;

		// Exit if no groups
		if ($this->DisplayGrps == 0)
			return;

		// Check for a 'start' parameter
		if (@$_GET[EWRPT_TABLE_START_GROUP] != "") {
			$this->StartGrp = $_GET[EWRPT_TABLE_START_GROUP];
			$Canceled_Reports->setStartGroup($this->StartGrp);
		} elseif (@$_GET["pageno"] != "") {
			$nPageNo = $_GET["pageno"];
			if (is_numeric($nPageNo)) {
				$this->StartGrp = ($nPageNo-1)*$this->DisplayGrps+1;
				if ($this->StartGrp <= 0) {
					$this->StartGrp = 1;
				} elseif ($this->StartGrp >= intval(($this->TotalGrps-1)/$this->DisplayGrps)*$this->DisplayGrps+1) {
					$this->StartGrp = intval(($this->TotalGrps-1)/$this->DisplayGrps)*$this->DisplayGrps+1;
				}
				$Canceled_Reports->setStartGroup($this->StartGrp);
			} else {
				$this->StartGrp = $Canceled_Reports->getStartGroup();
			}
		} else {
			$this->StartGrp = $Canceled_Reports->getStartGroup();
		}

		// Check if correct start group counter
		if (!is_numeric($this->StartGrp) || $this->StartGrp == "") { // Avoid invalid start group counter
			$this->StartGrp = 1; // Reset start group counter
			$Canceled_Reports->setStartGroup($this->StartGrp);
		} elseif (intval($this->StartGrp) > intval($this->TotalGrps)) { // Avoid starting group > total groups
			$this->StartGrp = intval(($this->TotalGrps-1)/$this->DisplayGrps) * $this->DisplayGrps + 1; // Point to last page first group
			$Canceled_Reports->setStartGroup($this->StartGrp);
		} elseif (($this->StartGrp-1) % $this->DisplayGrps <> 0) {
			$this->StartGrp = intval(($this->StartGrp-1)/$this->DisplayGrps) * $this->DisplayGrps + 1; // Point to page boundary
			$Canceled_Reports->setStartGroup($this->StartGrp);
		}
	}

	// Set up popup
	function SetupPopup() {
		global $conn, $ReportLanguage;
		global $Canceled_Reports;

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
		global $Canceled_Reports;
		$this->StartGrp = 1;
		$Canceled_Reports->setStartGroup($this->StartGrp);
	}

	// Set up number of groups displayed per page
	function SetUpDisplayGrps() {
		global $Canceled_Reports;
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
			$Canceled_Reports->setGroupPerPage($this->DisplayGrps); // Save to session

			// Reset start position (reset command)
			$this->StartGrp = 1;
			$Canceled_Reports->setStartGroup($this->StartGrp);
		} else {
			if ($Canceled_Reports->getGroupPerPage() <> "") {
				$this->DisplayGrps = $Canceled_Reports->getGroupPerPage(); // Restore from session
			} else {
				$this->DisplayGrps = 50; // Load default
			}
		}
	}

	function RenderRow() {
		global $conn, $rs, $Security;
		global $Canceled_Reports;
		if ($Canceled_Reports->RowTotalType == EWRPT_ROWTOTAL_GRAND) { // Grand total

			// Get total count from sql directly
			$sSql = ewrpt_BuildReportSql($Canceled_Reports->SqlSelectCount(), $Canceled_Reports->SqlWhere(), $Canceled_Reports->SqlGroupBy(), $Canceled_Reports->SqlHaving(), "", $this->Filter, "");
			$rstot = $conn->Execute($sSql);
			if ($rstot) {
				$this->TotCount = ($rstot->RecordCount()>1) ? $rstot->RecordCount() : $rstot->fields[0];
				$rstot->Close();
			} else {
				$this->TotCount = 0;
			}
		}

		// Call Row_Rendering event
		$Canceled_Reports->Row_Rendering();

		//
		// Render view codes
		//

		if ($Canceled_Reports->RowType == EWRPT_ROWTYPE_TOTAL) { // Summary row
		} else {

			// Product Name
			$Canceled_Reports->Product_Name->ViewValue = $Canceled_Reports->Product_Name->CurrentValue;
			$Canceled_Reports->Product_Name->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";

			// status
			$Canceled_Reports->status->ViewValue = $Canceled_Reports->status->CurrentValue;
			$Canceled_Reports->status->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";

			// date_start
			$Canceled_Reports->date_start->ViewValue = $Canceled_Reports->date_start->CurrentValue;
			$Canceled_Reports->date_start->ViewValue = ewrpt_FormatDateTime($Canceled_Reports->date_start->ViewValue, 7);
			$Canceled_Reports->date_start->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";

			// date_modified
			$Canceled_Reports->date_modified->ViewValue = $Canceled_Reports->date_modified->CurrentValue;
			$Canceled_Reports->date_modified->ViewValue = ewrpt_FormatDateTime($Canceled_Reports->date_modified->ViewValue, 7);
			$Canceled_Reports->date_modified->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";

			// dealer
			$Canceled_Reports->dealer->ViewValue = $Canceled_Reports->dealer->CurrentValue;
			$Canceled_Reports->dealer->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";

			// salesman
			$Canceled_Reports->salesman->ViewValue = $Canceled_Reports->salesman->CurrentValue;
			$Canceled_Reports->salesman->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";

			// customer
			$Canceled_Reports->customer->ViewValue = $Canceled_Reports->customer->CurrentValue;
			$Canceled_Reports->customer->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";

			// idno
			$Canceled_Reports->idno->ViewValue = $Canceled_Reports->idno->CurrentValue;
			$Canceled_Reports->idno->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";

			// total_premium
			$Canceled_Reports->total_premium->ViewValue = $Canceled_Reports->total_premium->CurrentValue;
			$Canceled_Reports->total_premium->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";

			// Product Name
			$Canceled_Reports->Product_Name->HrefValue = "";

			// status
			$Canceled_Reports->status->HrefValue = "";

			// date_start
			$Canceled_Reports->date_start->HrefValue = "";

			// date_modified
			$Canceled_Reports->date_modified->HrefValue = "";

			// dealer
			$Canceled_Reports->dealer->HrefValue = "";

			// salesman
			$Canceled_Reports->salesman->HrefValue = "";

			// customer
			$Canceled_Reports->customer->HrefValue = "";

			// idno
			$Canceled_Reports->idno->HrefValue = "";

			// total_premium
			$Canceled_Reports->total_premium->HrefValue = "";
		}

		// Call Cell_Rendered event
		if ($Canceled_Reports->RowType == EWRPT_ROWTYPE_TOTAL) { // Summary row
		} else {

			// Product Name
			$CurrentValue = $Canceled_Reports->Product_Name->CurrentValue;
			$ViewValue =& $Canceled_Reports->Product_Name->ViewValue;
			$ViewAttrs =& $Canceled_Reports->Product_Name->ViewAttrs;
			$CellAttrs =& $Canceled_Reports->Product_Name->CellAttrs;
			$HrefValue =& $Canceled_Reports->Product_Name->HrefValue;
			$Canceled_Reports->Cell_Rendered($Canceled_Reports->Product_Name, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue);

			// status
			$CurrentValue = $Canceled_Reports->status->CurrentValue;
			$ViewValue =& $Canceled_Reports->status->ViewValue;
			$ViewAttrs =& $Canceled_Reports->status->ViewAttrs;
			$CellAttrs =& $Canceled_Reports->status->CellAttrs;
			$HrefValue =& $Canceled_Reports->status->HrefValue;
			$Canceled_Reports->Cell_Rendered($Canceled_Reports->status, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue);

			// date_start
			$CurrentValue = $Canceled_Reports->date_start->CurrentValue;
			$ViewValue =& $Canceled_Reports->date_start->ViewValue;
			$ViewAttrs =& $Canceled_Reports->date_start->ViewAttrs;
			$CellAttrs =& $Canceled_Reports->date_start->CellAttrs;
			$HrefValue =& $Canceled_Reports->date_start->HrefValue;
			$Canceled_Reports->Cell_Rendered($Canceled_Reports->date_start, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue);

			// date_modified
			$CurrentValue = $Canceled_Reports->date_modified->CurrentValue;
			$ViewValue =& $Canceled_Reports->date_modified->ViewValue;
			$ViewAttrs =& $Canceled_Reports->date_modified->ViewAttrs;
			$CellAttrs =& $Canceled_Reports->date_modified->CellAttrs;
			$HrefValue =& $Canceled_Reports->date_modified->HrefValue;
			$Canceled_Reports->Cell_Rendered($Canceled_Reports->date_modified, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue);

			// dealer
			$CurrentValue = $Canceled_Reports->dealer->CurrentValue;
			$ViewValue =& $Canceled_Reports->dealer->ViewValue;
			$ViewAttrs =& $Canceled_Reports->dealer->ViewAttrs;
			$CellAttrs =& $Canceled_Reports->dealer->CellAttrs;
			$HrefValue =& $Canceled_Reports->dealer->HrefValue;
			$Canceled_Reports->Cell_Rendered($Canceled_Reports->dealer, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue);

			// salesman
			$CurrentValue = $Canceled_Reports->salesman->CurrentValue;
			$ViewValue =& $Canceled_Reports->salesman->ViewValue;
			$ViewAttrs =& $Canceled_Reports->salesman->ViewAttrs;
			$CellAttrs =& $Canceled_Reports->salesman->CellAttrs;
			$HrefValue =& $Canceled_Reports->salesman->HrefValue;
			$Canceled_Reports->Cell_Rendered($Canceled_Reports->salesman, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue);

			// customer
			$CurrentValue = $Canceled_Reports->customer->CurrentValue;
			$ViewValue =& $Canceled_Reports->customer->ViewValue;
			$ViewAttrs =& $Canceled_Reports->customer->ViewAttrs;
			$CellAttrs =& $Canceled_Reports->customer->CellAttrs;
			$HrefValue =& $Canceled_Reports->customer->HrefValue;
			$Canceled_Reports->Cell_Rendered($Canceled_Reports->customer, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue);

			// idno
			$CurrentValue = $Canceled_Reports->idno->CurrentValue;
			$ViewValue =& $Canceled_Reports->idno->ViewValue;
			$ViewAttrs =& $Canceled_Reports->idno->ViewAttrs;
			$CellAttrs =& $Canceled_Reports->idno->CellAttrs;
			$HrefValue =& $Canceled_Reports->idno->HrefValue;
			$Canceled_Reports->Cell_Rendered($Canceled_Reports->idno, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue);

			// total_premium
			$CurrentValue = $Canceled_Reports->total_premium->CurrentValue;
			$ViewValue =& $Canceled_Reports->total_premium->ViewValue;
			$ViewAttrs =& $Canceled_Reports->total_premium->ViewAttrs;
			$CellAttrs =& $Canceled_Reports->total_premium->CellAttrs;
			$HrefValue =& $Canceled_Reports->total_premium->HrefValue;
			$Canceled_Reports->Cell_Rendered($Canceled_Reports->total_premium, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue);
		}

		// Call Row_Rendered event
		$Canceled_Reports->Row_Rendered();
	}

	function SetupExportOptionsExt() {
		global $ReportLanguage, $Canceled_Reports;
		$item =& $this->ExportOptions->GetItem("pdf");
		$item->Visible = FALSE;
	}

	// Get extended filter values
	function GetExtendedFilterValues() {
		global $Canceled_Reports;

		// Field date_start
		$sSelect = "SELECT DISTINCT a.date_start FROM " . $Canceled_Reports->SqlFrom();
		$sOrderBy = "a.date_start ASC";
		$wrkSql = ewrpt_BuildReportSql($sSelect, $Canceled_Reports->SqlWhere(), "", "", $sOrderBy, $this->UserIDFilter, "");
		$Canceled_Reports->date_start->DropDownList = ewrpt_GetDistinctValues($Canceled_Reports->date_start->DateFilter, $wrkSql);

		// Field dealer
		$sSelect = "SELECT DISTINCT a.dealer FROM " . $Canceled_Reports->SqlFrom();
		$sOrderBy = "a.dealer ASC";
		$wrkSql = ewrpt_BuildReportSql($sSelect, $Canceled_Reports->SqlWhere(), "", "", $sOrderBy, $this->UserIDFilter, "");
		$Canceled_Reports->dealer->DropDownList = ewrpt_GetDistinctValues("", $wrkSql);

		// Field salesman
		$sSelect = "SELECT DISTINCT a.salesman FROM " . $Canceled_Reports->SqlFrom();
		$sOrderBy = "a.salesman ASC";
		$wrkSql = ewrpt_BuildReportSql($sSelect, $Canceled_Reports->SqlWhere(), "", "", $sOrderBy, $this->UserIDFilter, "");
		$Canceled_Reports->salesman->DropDownList = ewrpt_GetDistinctValues("", $wrkSql);
	}

	// Return extended filter
	function GetExtendedFilter() {
		global $Canceled_Reports;
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
			// Field date_start

			$this->SetSessionDropDownValue($Canceled_Reports->date_start->DropDownValue, 'date_start');

			// Field dealer
			$this->SetSessionDropDownValue($Canceled_Reports->dealer->DropDownValue, 'dealer');

			// Field salesman
			$this->SetSessionDropDownValue($Canceled_Reports->salesman->DropDownValue, 'salesman');
			$bSetupFilter = TRUE;
		} else {

			// Field date_start
			if ($this->GetDropDownValue($Canceled_Reports->date_start->DropDownValue, 'date_start')) {
				$bSetupFilter = TRUE;
				$bRestoreSession = FALSE;
			} elseif ($Canceled_Reports->date_start->DropDownValue <> EWRPT_INIT_VALUE && !isset($_SESSION['sv_Canceled_Reports->date_start'])) {
				$bSetupFilter = TRUE;
			}

			// Field dealer
			if ($this->GetDropDownValue($Canceled_Reports->dealer->DropDownValue, 'dealer')) {
				$bSetupFilter = TRUE;
				$bRestoreSession = FALSE;
			} elseif ($Canceled_Reports->dealer->DropDownValue <> EWRPT_INIT_VALUE && !isset($_SESSION['sv_Canceled_Reports->dealer'])) {
				$bSetupFilter = TRUE;
			}

			// Field salesman
			if ($this->GetDropDownValue($Canceled_Reports->salesman->DropDownValue, 'salesman')) {
				$bSetupFilter = TRUE;
				$bRestoreSession = FALSE;
			} elseif ($Canceled_Reports->salesman->DropDownValue <> EWRPT_INIT_VALUE && !isset($_SESSION['sv_Canceled_Reports->salesman'])) {
				$bSetupFilter = TRUE;
			}
			if (!$this->ValidateForm()) {
				$this->setMessage($gsFormError);
				return $sFilter;
			}
		}

		// Restore session
		if ($bRestoreSession) {

			// Field date_start
			$this->GetSessionDropDownValue($Canceled_Reports->date_start);

			// Field dealer
			$this->GetSessionDropDownValue($Canceled_Reports->dealer);

			// Field salesman
			$this->GetSessionDropDownValue($Canceled_Reports->salesman);
		}

		// Call page filter validated event
		$Canceled_Reports->Page_FilterValidated();

		// Build SQL
		// Field date_start

		ewrpt_BuildDropDownFilter($Canceled_Reports->date_start, $sFilter, $Canceled_Reports->date_start->DateFilter);

		// Field dealer
		ewrpt_BuildDropDownFilter($Canceled_Reports->dealer, $sFilter, "");

		// Field salesman
		ewrpt_BuildDropDownFilter($Canceled_Reports->salesman, $sFilter, "");

		// Save parms to session
		// Field date_start

		$this->SetSessionDropDownValue($Canceled_Reports->date_start->DropDownValue, 'date_start');

		// Field dealer
		$this->SetSessionDropDownValue($Canceled_Reports->dealer->DropDownValue, 'dealer');

		// Field salesman
		$this->SetSessionDropDownValue($Canceled_Reports->salesman->DropDownValue, 'salesman');

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
		$this->GetSessionValue($fld->DropDownValue, 'sv_Canceled_Reports_' . $parm);
	}

	// Get filter values from session
	function GetSessionFilterValues(&$fld) {
		$parm = substr($fld->FldVar, 2);
		$this->GetSessionValue($fld->SearchValue, 'sv1_Canceled_Reports_' . $parm);
		$this->GetSessionValue($fld->SearchOperator, 'so1_Canceled_Reports_' . $parm);
		$this->GetSessionValue($fld->SearchCondition, 'sc_Canceled_Reports_' . $parm);
		$this->GetSessionValue($fld->SearchValue2, 'sv2_Canceled_Reports_' . $parm);
		$this->GetSessionValue($fld->SearchOperator2, 'so2_Canceled_Reports_' . $parm);
	}

	// Get value from session
	function GetSessionValue(&$sv, $sn) {
		if (isset($_SESSION[$sn]))
			$sv = $_SESSION[$sn];
	}

	// Set dropdown value to session
	function SetSessionDropDownValue($sv, $parm) {
		$_SESSION['sv_Canceled_Reports_' . $parm] = $sv;
	}

	// Set filter values to session
	function SetSessionFilterValues($sv1, $so1, $sc, $sv2, $so2, $parm) {
		$_SESSION['sv1_Canceled_Reports_' . $parm] = $sv1;
		$_SESSION['so1_Canceled_Reports_' . $parm] = $so1;
		$_SESSION['sc_Canceled_Reports_' . $parm] = $sc;
		$_SESSION['sv2_Canceled_Reports_' . $parm] = $sv2;
		$_SESSION['so2_Canceled_Reports_' . $parm] = $so2;
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
		global $ReportLanguage, $gsFormError, $Canceled_Reports;

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
			$gsFormError .= ($gsFormError <> "") ? "<br />" : "";
			$gsFormError .= $sFormCustomError;
		}
		return $ValidateForm;
	}

	// Clear selection stored in session
	function ClearSessionSelection($parm) {
		$_SESSION["sel_Canceled_Reports_$parm"] = "";
		$_SESSION["rf_Canceled_Reports_$parm"] = "";
		$_SESSION["rt_Canceled_Reports_$parm"] = "";
	}

	// Load selection from session
	function LoadSelectionFromSession($parm) {
		global $Canceled_Reports;
		$fld =& $Canceled_Reports->fields($parm);
		$fld->SelectionList = @$_SESSION["sel_Canceled_Reports_$parm"];
		$fld->RangeFrom = @$_SESSION["rf_Canceled_Reports_$parm"];
		$fld->RangeTo = @$_SESSION["rt_Canceled_Reports_$parm"];
	}

	// Load default value for filters
	function LoadDefaultFilters() {
		global $Canceled_Reports;

		/**
		* Set up default values for non Text filters
		*/

		// Field date_start
		$Canceled_Reports->date_start->DefaultDropDownValue = EWRPT_INIT_VALUE;
		$Canceled_Reports->date_start->DropDownValue = $Canceled_Reports->date_start->DefaultDropDownValue;

		// Field dealer
		$Canceled_Reports->dealer->DefaultDropDownValue = EWRPT_INIT_VALUE;
		$Canceled_Reports->dealer->DropDownValue = $Canceled_Reports->dealer->DefaultDropDownValue;

		// Field salesman
		$Canceled_Reports->salesman->DefaultDropDownValue = EWRPT_INIT_VALUE;
		$Canceled_Reports->salesman->DropDownValue = $Canceled_Reports->salesman->DefaultDropDownValue;

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
		global $Canceled_Reports;

		// Check date_start extended filter
		if ($this->NonTextFilterApplied($Canceled_Reports->date_start))
			return TRUE;

		// Check dealer extended filter
		if ($this->NonTextFilterApplied($Canceled_Reports->dealer))
			return TRUE;

		// Check salesman extended filter
		if ($this->NonTextFilterApplied($Canceled_Reports->salesman))
			return TRUE;
		return FALSE;
	}

	// Show list of filters
	function ShowFilterList() {
		global $Canceled_Reports;
		global $ReportLanguage;

		// Initialize
		$sFilterList = "";

		// Field date_start
		$sExtWrk = "";
		$sWrk = "";
		ewrpt_BuildDropDownFilter($Canceled_Reports->date_start, $sExtWrk, $Canceled_Reports->date_start->DateFilter);
		if ($sExtWrk <> "" || $sWrk <> "")
			$sFilterList .= $Canceled_Reports->date_start->FldCaption() . "<br />";
		if ($sExtWrk <> "")
			$sFilterList .= "&nbsp;&nbsp;$sExtWrk<br />";
		if ($sWrk <> "")
			$sFilterList .= "&nbsp;&nbsp;$sWrk<br />";

		// Field dealer
		$sExtWrk = "";
		$sWrk = "";
		ewrpt_BuildDropDownFilter($Canceled_Reports->dealer, $sExtWrk, "");
		if ($sExtWrk <> "" || $sWrk <> "")
			$sFilterList .= $Canceled_Reports->dealer->FldCaption() . "<br />";
		if ($sExtWrk <> "")
			$sFilterList .= "&nbsp;&nbsp;$sExtWrk<br />";
		if ($sWrk <> "")
			$sFilterList .= "&nbsp;&nbsp;$sWrk<br />";

		// Field salesman
		$sExtWrk = "";
		$sWrk = "";
		ewrpt_BuildDropDownFilter($Canceled_Reports->salesman, $sExtWrk, "");
		if ($sExtWrk <> "" || $sWrk <> "")
			$sFilterList .= $Canceled_Reports->salesman->FldCaption() . "<br />";
		if ($sExtWrk <> "")
			$sFilterList .= "&nbsp;&nbsp;$sExtWrk<br />";
		if ($sWrk <> "")
			$sFilterList .= "&nbsp;&nbsp;$sWrk<br />";

		// Show Filters
		if ($sFilterList <> "")
			echo $ReportLanguage->Phrase("CurrentFilters") . "<br />$sFilterList";
	}

	// Return poup filter
	function GetPopupFilter() {
		global $Canceled_Reports;
		$sWrk = "";
		return $sWrk;
	}

	//-------------------------------------------------------------------------------
	// Function GetSort
	// - Return Sort parameters based on Sort Links clicked
	// - Variables setup: Session[EWRPT_TABLE_SESSION_ORDER_BY], Session["sort_Table_Field"]
	function GetSort() {
		global $Canceled_Reports;

		// Check for a resetsort command
		if (strlen(@$_GET["cmd"]) > 0) {
			$sCmd = @$_GET["cmd"];
			if ($sCmd == "resetsort") {
				$Canceled_Reports->setOrderBy("");
				$Canceled_Reports->setStartGroup(1);
				$Canceled_Reports->Product_Name->setSort("");
				$Canceled_Reports->status->setSort("");
				$Canceled_Reports->date_start->setSort("");
				$Canceled_Reports->date_modified->setSort("");
				$Canceled_Reports->dealer->setSort("");
				$Canceled_Reports->salesman->setSort("");
				$Canceled_Reports->customer->setSort("");
				$Canceled_Reports->idno->setSort("");
				$Canceled_Reports->total_premium->setSort("");
			}

		// Check for an Order parameter
		} elseif (@$_GET["order"] <> "") {
			$Canceled_Reports->CurrentOrder = ewrpt_StripSlashes(@$_GET["order"]);
			$Canceled_Reports->CurrentOrderType = @$_GET["ordertype"];
			$sSortSql = $Canceled_Reports->SortSql();
			$Canceled_Reports->setOrderBy($sSortSql);
			$Canceled_Reports->setStartGroup(1);
		}

		// Set up default sort
		if ($Canceled_Reports->getOrderBy() == "") {
			$Canceled_Reports->setOrderBy("a.date_start DESC");
			$Canceled_Reports->date_start->setSort("DESC");
		}
		return $Canceled_Reports->getOrderBy();
	}

	// Export PDF
	function ExportPDF($html) {
		global $gsExportFile;
		include_once "dompdf060b2/dompdf_config.inc.php";
		@ini_set("memory_limit", EWRPT_PDF_MEMORY_LIMIT);
		set_time_limit(EWRPT_PDF_TIME_LIMIT);
		$dompdf = new DOMPDF();
		$dompdf->load_html($html);
		$dompdf->set_paper("a4", "portrait");
		$dompdf->render();
		ob_end_clean();
		ewrpt_DeleteTmpImages();
		$dompdf->stream($gsExportFile . ".pdf", array("Attachment" => 1)); // 0 to open in browser, 1 to download

//		exit();
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
