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
$dealers_transaction = NULL;

//
// Table class for dealers_transaction
//
class crdealers_transaction {
	var $TableVar = 'dealers_transaction';
	var $TableName = 'dealers_transaction';
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
	var $Dealers_deal_sold;
	var $code;
	var $name;
	var $account;
	var $vat_registration;
	var $fsb_number;
	var $Deals_made;
	var $Sold;
	var $StartDate;
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
	function crdealers_transaction() {
		global $ReportLanguage;

		// code
		$this->code = new crField('dealers_transaction', 'dealers_transaction', 'x_code', 'code', 'dealer.code', 200, EWRPT_DATATYPE_STRING, -1);
		$this->fields['code'] =& $this->code;
		$this->code->DateFilter = "";
		$this->code->SqlSelect = "";
		$this->code->SqlOrderBy = "";

		// name
		$this->name = new crField('dealers_transaction', 'dealers_transaction', 'x_name', 'name', 'dealer.name', 200, EWRPT_DATATYPE_STRING, -1);
		$this->fields['name'] =& $this->name;
		$this->name->DateFilter = "";
		$this->name->SqlSelect = "";
		$this->name->SqlOrderBy = "";

		// account
		$this->account = new crField('dealers_transaction', 'dealers_transaction', 'x_account', 'account', 'dealer.account', 200, EWRPT_DATATYPE_STRING, -1);
		$this->fields['account'] =& $this->account;
		$this->account->DateFilter = "";
		$this->account->SqlSelect = "";
		$this->account->SqlOrderBy = "";

		// vat_registration
		$this->vat_registration = new crField('dealers_transaction', 'dealers_transaction', 'x_vat_registration', 'vat_registration', 'dealer.vat_registration', 200, EWRPT_DATATYPE_STRING, -1);
		$this->fields['vat_registration'] =& $this->vat_registration;
		$this->vat_registration->DateFilter = "";
		$this->vat_registration->SqlSelect = "";
		$this->vat_registration->SqlOrderBy = "";

		// fsb_number
		$this->fsb_number = new crField('dealers_transaction', 'dealers_transaction', 'x_fsb_number', 'fsb_number', 'dealer.fsb_number', 200, EWRPT_DATATYPE_STRING, -1);
		$this->fields['fsb_number'] =& $this->fsb_number;
		$this->fsb_number->DateFilter = "";
		$this->fsb_number->SqlSelect = "";
		$this->fsb_number->SqlOrderBy = "";

		// Deals made
		$this->Deals_made = new crField('dealers_transaction', 'dealers_transaction', 'x_Deals_made', 'Deals made', 'Count(DISTINCT trans.Id)', 20, EWRPT_DATATYPE_NUMBER, -1);
		$this->Deals_made->FldDefaultErrMsg = $ReportLanguage->Phrase("IncorrectInteger");
		$this->fields['Deals_made'] =& $this->Deals_made;
		$this->Deals_made->DateFilter = "";
		$this->Deals_made->SqlSelect = "";
		$this->Deals_made->SqlOrderBy = "";

		// Sold
		$this->Sold = new crField('dealers_transaction', 'dealers_transaction', 'x_Sold', 'Sold', 'Count(quot.Id)', 20, EWRPT_DATATYPE_NUMBER, -1);
		$this->Sold->FldDefaultErrMsg = $ReportLanguage->Phrase("IncorrectInteger");
		$this->fields['Sold'] =& $this->Sold;
		$this->Sold->DateFilter = "";
		$this->Sold->SqlSelect = "";
		$this->Sold->SqlOrderBy = "";

		// StartDate
		$this->StartDate = new crField('dealers_transaction', 'dealers_transaction', 'x_StartDate', 'StartDate', 'agree.StartDate', 135, EWRPT_DATATYPE_DATE, 7);
		$this->StartDate->FldDefaultErrMsg = str_replace("%s", "-", $ReportLanguage->Phrase("IncorrectDateYMD"));
		$this->fields['StartDate'] =& $this->StartDate;
		$this->StartDate->DateFilter = "Month";
		$this->StartDate->SqlSelect = "";
		$this->StartDate->SqlOrderBy = "";
		ewrpt_RegisterFilter($this->StartDate, "@@LastMonth", $ReportLanguage->Phrase("LastMonth"), "ewrpt_IsLastMonth");
		ewrpt_RegisterFilter($this->StartDate, "@@ThisMonth", $ReportLanguage->Phrase("ThisMonth"), "ewrpt_IsThisMonth");
		ewrpt_RegisterFilter($this->StartDate, "@@NextMonth", $ReportLanguage->Phrase("NextMonth"), "ewrpt_IsNextMonth");

		// Dealers deal sold
		$this->Dealers_deal_sold = new crChart('dealers_transaction', 'dealers_transaction', 'Dealers_deal_sold', 'Dealers deal sold', 'name', 'Deals made', '', 9, 'SUM', 1200, 800);
		$this->Dealers_deal_sold->SqlSelect = "SELECT `name`, '', SUM(`Deals made`), SUM(`Sold`) FROM ";
		$this->Dealers_deal_sold->SqlGroupBy = "`name`";
		$this->Dealers_deal_sold->SqlOrderBy = "";
		$this->Dealers_deal_sold->SeriesDateType = "";
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
		return "roadCover_dealers dealer Left Join road_Transactions trans On trans.Intermediary = dealer.code Left Join road_Agreements agree On agree.`transaction` = trans.Id Left Join road_QuoteTransactions quot On quot.transaction = trans.Id";
	}

	function SqlSelect() { // Select
		return "SELECT dealer.code, dealer.name, dealer.account, dealer.vat_registration, dealer.fsb_number, agree.StartDate, Count(Distinct trans.Id) As `Deals made`, Count(quot.Id) As Sold FROM " . $this->SqlFrom();
	}

	function SqlWhere() { // Where
		return "";
	}

	function SqlGroupBy() { // Group By
		return "dealer.name";
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
$dealers_transaction_summary = new crdealers_transaction_summary();
$Page =& $dealers_transaction_summary;

// Page init
$dealers_transaction_summary->Page_Init();

// Page main
$dealers_transaction_summary->Page_Main();
?>
<?php include_once "phprptinc/header.php"; ?>
<?php if ($dealers_transaction->Export == "" || $dealers_transaction->Export == "print" || $dealers_transaction->Export == "email") { ?>
<script type="text/javascript">

// Create page object
var dealers_transaction_summary = new ewrpt_Page("dealers_transaction_summary");

// page properties
dealers_transaction_summary.PageID = "summary"; // page ID
dealers_transaction_summary.FormID = "fdealers_transactionsummaryfilter"; // form ID
var EWRPT_PAGE_ID = dealers_transaction_summary.PageID;

// extend page with Chart_Rendering function
dealers_transaction_summary.Chart_Rendering =  
 function(chart, chartid) { // DO NOT CHANGE THIS LINE!

 	//alert(chartid);
 }

// extend page with Chart_Rendered function
dealers_transaction_summary.Chart_Rendered =  
 function(chart, chartid) { // DO NOT CHANGE THIS LINE!

 	//alert(chartid);
 }
</script>
<?php } ?>
<?php if ($dealers_transaction->Export == "") { ?>
<script type="text/javascript">

// extend page with ValidateForm function
dealers_transaction_summary.ValidateForm = function(fobj) {
	if (!this.ValidateRequired)
		return true; // ignore validation

	// Call Form Custom Validate event
	if (!this.Form_CustomValidate(fobj)) return false;
	return true;
}

// extend page with Form_CustomValidate function
dealers_transaction_summary.Form_CustomValidate =  
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }
<?php if (EWRPT_CLIENT_VALIDATE) { ?>
dealers_transaction_summary.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
dealers_transaction_summary.ValidateRequired = false; // no JavaScript validation
<?php } ?>
</script>
<script language="JavaScript" type="text/javascript">
<!--

// Write your client script here, no need to add script tags.
//-->

</script>
<?php } ?>
<?php if ($dealers_transaction->Export == "" || $dealers_transaction->Export == "print" || $dealers_transaction->Export == "email") { ?>
<script src="<?php echo EWRPT_FUSIONCHARTS_FREE_JSCLASS_FILE; ?>" type="text/javascript"></script>
<?php } ?>
<?php if ($dealers_transaction->Export == "") { ?>
<div id="ewrpt_PopupFilter"><div class="bd"></div></div>
<script src="phprptjs/ewrptpop.js" type="text/javascript"></script>
<script type="text/javascript">

// popup fields
</script>
<?php } ?>
<?php if ($dealers_transaction->Export == "" || $dealers_transaction->Export == "print" || $dealers_transaction->Export == "email") { ?>
<!-- Table Container (Begin) -->
<table id="ewContainer" cellspacing="0" cellpadding="0" border="0">
<!-- Top Container (Begin) -->
<tr><td colspan="3"><div id="ewTop" class="phpreportmaker">
<!-- top slot -->
<a name="top"></a>
<?php } ?>
<p class="phpreportmaker ewTitle"><?php echo $dealers_transaction->TableCaption() ?>
&nbsp;&nbsp;<?php $dealers_transaction_summary->ExportOptions->Render("body"); ?></p>
<?php $dealers_transaction_summary->ShowPageHeader(); ?>
<?php $dealers_transaction_summary->ShowMessage(); ?>
<br><br>
<?php if ($dealers_transaction->Export == "" || $dealers_transaction->Export == "print" || $dealers_transaction->Export == "email") { ?>
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
<?php if ($dealers_transaction->Export == "") { ?>
<?php
if ($dealers_transaction->FilterPanelOption == 2 || ($dealers_transaction->FilterPanelOption == 3 && $dealers_transaction_summary->FilterApplied) || $dealers_transaction_summary->Filter == "0=101") {
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
<form name="fdealers_transactionsummaryfilter" id="fdealers_transactionsummaryfilter" action="<?php echo ewrpt_CurrentPage() ?>" class="ewForm" onsubmit="return dealers_transaction_summary.ValidateForm(this);">
<table class="ewRptExtFilter">
	<tr id="r_StartDate">
		<td><span class="phpreportmaker"><?php echo $dealers_transaction->StartDate->FldCaption() ?></span></td>
		<td></td>
		<td colspan="4"><span class="ewRptSearchOpr">
		<select name="sv_StartDate" id="sv_StartDate"<?php echo ($dealers_transaction_summary->ClearExtFilter == 'dealers_transaction_StartDate') ? " class=\"ewInputCleared\"" : "" ?> onchange="this.form.submit();">
		<option value="<?php echo EWRPT_ALL_VALUE; ?>"<?php if (ewrpt_MatchedFilterValue($dealers_transaction->StartDate->DropDownValue, EWRPT_ALL_VALUE)) echo " selected=\"selected\""; ?>><?php echo $ReportLanguage->Phrase("PleaseSelect"); ?></option>
<?php

// Popup filter
$cntf = is_array($dealers_transaction->StartDate->AdvancedFilters) ? count($dealers_transaction->StartDate->AdvancedFilters) : 0;
$cntd = is_array($dealers_transaction->StartDate->DropDownList) ? count($dealers_transaction->StartDate->DropDownList) : 0;
$totcnt = $cntf + $cntd;
$wrkcnt = 0;
	if ($cntf > 0) {
		foreach ($dealers_transaction->StartDate->AdvancedFilters as $filter) {
			if ($filter->Enabled) {
?>
		<option value="<?php echo $filter->ID ?>"<?php if (ewrpt_MatchedFilterValue($dealers_transaction->StartDate->DropDownValue, $filter->ID)) echo " selected=\"selected\"" ?>><?php echo $filter->Name ?></option>
<?php
				$wrkcnt += 1;
			}
		}
	}
	for ($i = 0; $i < $cntd; $i++) {
?>
		<option value="<?php echo $dealers_transaction->StartDate->DropDownList[$i] ?>"<?php if (ewrpt_MatchedFilterValue($dealers_transaction->StartDate->DropDownValue, $dealers_transaction->StartDate->DropDownList[$i])) echo " selected=\"selected\"" ?>><?php echo ewrpt_DropDownDisplayValue($dealers_transaction->StartDate->DropDownList[$i], $dealers_transaction->StartDate->DateFilter, 7) ?></option>
<?php
		$wrkcnt += 1;
	}
?>
		</select>
		</span></td>
	</tr>
</table>
</form>
<!-- Search form (end) -->
</div>
<br>
<?php } ?>
<?php if ($dealers_transaction->ShowCurrentFilter) { ?>
<div id="ewrptFilterList">
<?php $dealers_transaction_summary->ShowFilterList() ?>
</div>
<br>
<?php } ?>
<table class="ewGrid" cellspacing="0"><tr>
	<td class="ewGridContent">
<!-- Report Grid (Begin) -->
<div class="ewGridMiddlePanel">
<table class="<?php echo $dealers_transaction_summary->ReportTableClass ?>" cellspacing="0">
<?php

// Set the last group to display if not export all
if ($dealers_transaction->ExportAll && $dealers_transaction->Export <> "") {
	$dealers_transaction_summary->StopGrp = $dealers_transaction_summary->TotalGrps;
} else {
	$dealers_transaction_summary->StopGrp = $dealers_transaction_summary->StartGrp + $dealers_transaction_summary->DisplayGrps - 1;
}

// Stop group <= total number of groups
if (intval($dealers_transaction_summary->StopGrp) > intval($dealers_transaction_summary->TotalGrps))
	$dealers_transaction_summary->StopGrp = $dealers_transaction_summary->TotalGrps;
$dealers_transaction_summary->RecCount = 0;

// Get first row
if ($dealers_transaction_summary->TotalGrps > 0) {
	$dealers_transaction_summary->GetRow(1);
	$dealers_transaction_summary->GrpCount = 1;
}
while (($rs && !$rs->EOF && $dealers_transaction_summary->GrpCount <= $dealers_transaction_summary->DisplayGrps) || $dealers_transaction_summary->ShowFirstHeader) {

	// Show header
	if ($dealers_transaction_summary->ShowFirstHeader) {
?>
	<thead>
	<tr>
<td class="ewTableHeader">
<?php if ($dealers_transaction->Export <> "") { ?>
<?php echo $dealers_transaction->code->FldCaption() ?>
<?php } else { ?>
	<table cellspacing="0" class="ewTableHeaderBtn"><tr>
<?php if ($dealers_transaction->SortUrl($dealers_transaction->code) == "") { ?>
		<td style="vertical-align: bottom;"><?php echo $dealers_transaction->code->FldCaption() ?></td>
<?php } else { ?>
		<td class="ewPointer" onmousedown="ewrpt_Sort(event,'<?php echo $dealers_transaction->SortUrl($dealers_transaction->code) ?>',0);"><?php echo $dealers_transaction->code->FldCaption() ?></td><td style="width: 10px;">
		<?php if ($dealers_transaction->code->getSort() == "ASC") { ?><img src="phprptimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($dealers_transaction->code->getSort() == "DESC") { ?><img src="phprptimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td>
<?php } ?>
	</tr></table>
<?php } ?>
</td>
<td class="ewTableHeader">
<?php if ($dealers_transaction->Export <> "") { ?>
<?php echo $dealers_transaction->name->FldCaption() ?>
<?php } else { ?>
	<table cellspacing="0" class="ewTableHeaderBtn" style="white-space: nowrap;"><tr>
<?php if ($dealers_transaction->SortUrl($dealers_transaction->name) == "") { ?>
		<td style="vertical-align: bottom;"><?php echo $dealers_transaction->name->FldCaption() ?></td>
<?php } else { ?>
		<td class="ewPointer" onmousedown="ewrpt_Sort(event,'<?php echo $dealers_transaction->SortUrl($dealers_transaction->name) ?>',0);"><?php echo $dealers_transaction->name->FldCaption() ?></td><td style="width: 10px;">
		<?php if ($dealers_transaction->name->getSort() == "ASC") { ?><img src="phprptimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($dealers_transaction->name->getSort() == "DESC") { ?><img src="phprptimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td>
<?php } ?>
	</tr></table>
<?php } ?>
</td>
<td class="ewTableHeader">
<?php if ($dealers_transaction->Export <> "") { ?>
<?php echo $dealers_transaction->account->FldCaption() ?>
<?php } else { ?>
	<table cellspacing="0" class="ewTableHeaderBtn" style="white-space: nowrap;"><tr>
<?php if ($dealers_transaction->SortUrl($dealers_transaction->account) == "") { ?>
		<td style="vertical-align: bottom;"><?php echo $dealers_transaction->account->FldCaption() ?></td>
<?php } else { ?>
		<td class="ewPointer" onmousedown="ewrpt_Sort(event,'<?php echo $dealers_transaction->SortUrl($dealers_transaction->account) ?>',0);"><?php echo $dealers_transaction->account->FldCaption() ?></td><td style="width: 10px;">
		<?php if ($dealers_transaction->account->getSort() == "ASC") { ?><img src="phprptimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($dealers_transaction->account->getSort() == "DESC") { ?><img src="phprptimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td>
<?php } ?>
	</tr></table>
<?php } ?>
</td>
<td class="ewTableHeader">
<?php if ($dealers_transaction->Export <> "") { ?>
<?php echo $dealers_transaction->vat_registration->FldCaption() ?>
<?php } else { ?>
	<table cellspacing="0" class="ewTableHeaderBtn"><tr>
<?php if ($dealers_transaction->SortUrl($dealers_transaction->vat_registration) == "") { ?>
		<td style="vertical-align: bottom;"><?php echo $dealers_transaction->vat_registration->FldCaption() ?></td>
<?php } else { ?>
		<td class="ewPointer" onmousedown="ewrpt_Sort(event,'<?php echo $dealers_transaction->SortUrl($dealers_transaction->vat_registration) ?>',0);"><?php echo $dealers_transaction->vat_registration->FldCaption() ?></td><td style="width: 10px;">
		<?php if ($dealers_transaction->vat_registration->getSort() == "ASC") { ?><img src="phprptimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($dealers_transaction->vat_registration->getSort() == "DESC") { ?><img src="phprptimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td>
<?php } ?>
	</tr></table>
<?php } ?>
</td>
<td class="ewTableHeader">
<?php if ($dealers_transaction->Export <> "") { ?>
<?php echo $dealers_transaction->fsb_number->FldCaption() ?>
<?php } else { ?>
	<table cellspacing="0" class="ewTableHeaderBtn"><tr>
<?php if ($dealers_transaction->SortUrl($dealers_transaction->fsb_number) == "") { ?>
		<td style="vertical-align: bottom;"><?php echo $dealers_transaction->fsb_number->FldCaption() ?></td>
<?php } else { ?>
		<td class="ewPointer" onmousedown="ewrpt_Sort(event,'<?php echo $dealers_transaction->SortUrl($dealers_transaction->fsb_number) ?>',0);"><?php echo $dealers_transaction->fsb_number->FldCaption() ?></td><td style="width: 10px;">
		<?php if ($dealers_transaction->fsb_number->getSort() == "ASC") { ?><img src="phprptimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($dealers_transaction->fsb_number->getSort() == "DESC") { ?><img src="phprptimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td>
<?php } ?>
	</tr></table>
<?php } ?>
</td>
<td class="ewTableHeader">
<?php if ($dealers_transaction->Export <> "") { ?>
<?php echo $dealers_transaction->Deals_made->FldCaption() ?>
<?php } else { ?>
	<table cellspacing="0" class="ewTableHeaderBtn"><tr>
<?php if ($dealers_transaction->SortUrl($dealers_transaction->Deals_made) == "") { ?>
		<td style="vertical-align: bottom;"><?php echo $dealers_transaction->Deals_made->FldCaption() ?></td>
<?php } else { ?>
		<td class="ewPointer" onmousedown="ewrpt_Sort(event,'<?php echo $dealers_transaction->SortUrl($dealers_transaction->Deals_made) ?>',0);"><?php echo $dealers_transaction->Deals_made->FldCaption() ?></td><td style="width: 10px;">
		<?php if ($dealers_transaction->Deals_made->getSort() == "ASC") { ?><img src="phprptimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($dealers_transaction->Deals_made->getSort() == "DESC") { ?><img src="phprptimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td>
<?php } ?>
	</tr></table>
<?php } ?>
</td>
<td class="ewTableHeader">
<?php if ($dealers_transaction->Export <> "") { ?>
<?php echo $dealers_transaction->Sold->FldCaption() ?>
<?php } else { ?>
	<table cellspacing="0" class="ewTableHeaderBtn"><tr>
<?php if ($dealers_transaction->SortUrl($dealers_transaction->Sold) == "") { ?>
		<td style="vertical-align: bottom;"><?php echo $dealers_transaction->Sold->FldCaption() ?></td>
<?php } else { ?>
		<td class="ewPointer" onmousedown="ewrpt_Sort(event,'<?php echo $dealers_transaction->SortUrl($dealers_transaction->Sold) ?>',0);"><?php echo $dealers_transaction->Sold->FldCaption() ?></td><td style="width: 10px;">
		<?php if ($dealers_transaction->Sold->getSort() == "ASC") { ?><img src="phprptimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($dealers_transaction->Sold->getSort() == "DESC") { ?><img src="phprptimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td>
<?php } ?>
	</tr></table>
<?php } ?>
</td>
	</tr>
	</thead>
	<tbody>
<?php
		$dealers_transaction_summary->ShowFirstHeader = FALSE;
	}
	$dealers_transaction_summary->RecCount++;

		// Render detail row
		$dealers_transaction->ResetCSS();
		$dealers_transaction->RowType = EWRPT_ROWTYPE_DETAIL;
		$dealers_transaction_summary->RenderRow();
?>
	<tr<?php echo $dealers_transaction->RowAttributes(); ?>>
		<td<?php echo $dealers_transaction->code->CellAttributes() ?>>
<span<?php echo $dealers_transaction->code->ViewAttributes(); ?>><?php echo $dealers_transaction->code->ListViewValue(); ?></span></td>
		<td<?php echo $dealers_transaction->name->CellAttributes() ?>>
<span<?php echo $dealers_transaction->name->ViewAttributes(); ?>><?php echo $dealers_transaction->name->ListViewValue(); ?></span></td>
		<td<?php echo $dealers_transaction->account->CellAttributes() ?>>
<span<?php echo $dealers_transaction->account->ViewAttributes(); ?>><?php echo $dealers_transaction->account->ListViewValue(); ?></span></td>
		<td<?php echo $dealers_transaction->vat_registration->CellAttributes() ?>>
<span<?php echo $dealers_transaction->vat_registration->ViewAttributes(); ?>><?php echo $dealers_transaction->vat_registration->ListViewValue(); ?></span></td>
		<td<?php echo $dealers_transaction->fsb_number->CellAttributes() ?>>
<span<?php echo $dealers_transaction->fsb_number->ViewAttributes(); ?>><?php echo $dealers_transaction->fsb_number->ListViewValue(); ?></span></td>
		<td<?php echo $dealers_transaction->Deals_made->CellAttributes() ?>>
<span<?php echo $dealers_transaction->Deals_made->ViewAttributes(); ?>><?php echo $dealers_transaction->Deals_made->ListViewValue(); ?></span></td>
		<td<?php echo $dealers_transaction->Sold->CellAttributes() ?>>
<span<?php echo $dealers_transaction->Sold->ViewAttributes(); ?>><?php echo $dealers_transaction->Sold->ListViewValue(); ?></span></td>
	</tr>
<?php

		// Accumulate page summary
		$dealers_transaction_summary->AccumulateSummary();

		// Get next record
		$dealers_transaction_summary->GetRow(2);
	$dealers_transaction_summary->GrpCount++;
} // End while
?>
	</tbody>
	<tfoot>
<?php
if ($dealers_transaction_summary->TotalGrps > 0) {
	$dealers_transaction->ResetCSS();
	$dealers_transaction->RowType = EWRPT_ROWTYPE_TOTAL;
	$dealers_transaction->RowTotalType = EWRPT_ROWTOTAL_GRAND;
	$dealers_transaction->RowTotalSubType = EWRPT_ROWTOTAL_FOOTER;
	$dealers_transaction->RowAttrs["class"] = "ewRptGrandSummary";
	$dealers_transaction_summary->RenderRow();
?>
	<!-- tr><td colspan="7"><span class="phpreportmaker">&nbsp;<br></span></td></tr -->
	<tr<?php echo $dealers_transaction->RowAttributes(); ?>><td colspan="7"><?php echo $ReportLanguage->Phrase("RptGrandTotal") ?> (<?php echo ewrpt_FormatNumber($dealers_transaction_summary->TotCount,0,-2,-2,-2); ?><?php echo $ReportLanguage->Phrase("RptDtlRec") ?>)</td></tr>
<?php } ?>
	</tfoot>
</table>
</div>
<?php if ($dealers_transaction->Export == "") { ?>
<div class="ewGridLowerPanel">
<form action="<?php echo ewrpt_CurrentPage() ?>" name="ewpagerform" id="ewpagerform" class="ewForm">
<table border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td style="white-space: nowrap;">
<?php if (!isset($Pager)) $Pager = new crPrevNextPager($dealers_transaction_summary->StartGrp, $dealers_transaction_summary->DisplayGrps, $dealers_transaction_summary->TotalGrps) ?>
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
	<?php if ($dealers_transaction_summary->Filter == "0=101") { ?>
	<span class="phpreportmaker"><?php echo $ReportLanguage->Phrase("EnterSearchCriteria") ?></span>
	<?php } else { ?>
	<span class="phpreportmaker"><?php echo $ReportLanguage->Phrase("NoRecord") ?></span>
	<?php } ?>
<?php } ?>
		</td>
<?php if ($dealers_transaction_summary->TotalGrps > 0) { ?>
		<td style="white-space: nowrap;">&nbsp;&nbsp;&nbsp;&nbsp;</td>
		<td align="right" style="vertical-align: top; white-space: nowrap;"><span class="phpreportmaker"><?php echo $ReportLanguage->Phrase("GroupsPerPage"); ?>&nbsp;
<select name="<?php echo EWRPT_TABLE_GROUP_PER_PAGE; ?>" onchange="this.form.submit();">
<option value="1"<?php if ($dealers_transaction_summary->DisplayGrps == 1) echo " selected=\"selected\"" ?>>1</option>
<option value="2"<?php if ($dealers_transaction_summary->DisplayGrps == 2) echo " selected=\"selected\"" ?>>2</option>
<option value="3"<?php if ($dealers_transaction_summary->DisplayGrps == 3) echo " selected=\"selected\"" ?>>3</option>
<option value="4"<?php if ($dealers_transaction_summary->DisplayGrps == 4) echo " selected=\"selected\"" ?>>4</option>
<option value="5"<?php if ($dealers_transaction_summary->DisplayGrps == 5) echo " selected=\"selected\"" ?>>5</option>
<option value="10"<?php if ($dealers_transaction_summary->DisplayGrps == 10) echo " selected=\"selected\"" ?>>10</option>
<option value="20"<?php if ($dealers_transaction_summary->DisplayGrps == 20) echo " selected=\"selected\"" ?>>20</option>
<option value="50"<?php if ($dealers_transaction_summary->DisplayGrps == 50) echo " selected=\"selected\"" ?>>50</option>
<option value="ALL"<?php if ($dealers_transaction->getGroupPerPage() == -1) echo " selected=\"selected\"" ?>><?php echo $ReportLanguage->Phrase("AllRecords") ?></option>
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
<?php if ($dealers_transaction->Export == "" || $dealers_transaction->Export == "print" || $dealers_transaction->Export == "email") { ?>
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
<a name="cht_Dealers_deal_sold"></a>
<div id="div_dealers_transaction_Dealers_deal_sold"></div>
<?php

// Initialize chart data
$dealers_transaction->Dealers_deal_sold->ID = "dealers_transaction_Dealers_deal_sold"; // Chart ID
$dealers_transaction->Dealers_deal_sold->SetChartParam("type", "9", FALSE); // Chart type
$dealers_transaction->Dealers_deal_sold->SetChartParam("seriestype", "1", FALSE); // Chart series type
$dealers_transaction->Dealers_deal_sold->SetChartParam("bgcolor", "FCFCFC", TRUE); // Background color
$dealers_transaction->Dealers_deal_sold->SetChartParam("caption", $dealers_transaction->Dealers_deal_sold->ChartCaption(), TRUE); // Chart caption
$dealers_transaction->Dealers_deal_sold->SetChartParam("xaxisname", $dealers_transaction->Dealers_deal_sold->ChartXAxisName(), TRUE); // X axis name
$dealers_transaction->Dealers_deal_sold->SetChartParam("yaxisname", $dealers_transaction->Dealers_deal_sold->ChartYAxisName(), TRUE); // Y axis name
$dealers_transaction->Dealers_deal_sold->SetChartParam("shownames", "1", TRUE); // Show names
$dealers_transaction->Dealers_deal_sold->SetChartParam("showvalues", "1", TRUE); // Show values
$dealers_transaction->Dealers_deal_sold->SetChartParam("showhovercap", "0", TRUE); // Show hover
$dealers_transaction->Dealers_deal_sold->SetChartParam("alpha", "50", FALSE); // Chart alpha
$dealers_transaction->Dealers_deal_sold->SetChartParam("colorpalette", "#FF0000|#FFFF00|#FF0080|#FF00FF|#8000FF|#FF8000|#FF3D3D|#7AFFFF|#0000FF|#FF7A7A|#3DFFFF|#0080FF|#80FF00|#00FF00|#00FF80|#00FFFF", FALSE); // Chart color palette
?>
<?php
$dealers_transaction->Dealers_deal_sold->SetChartParam("showCanvasBg", "1", TRUE); // showCanvasBg
$dealers_transaction->Dealers_deal_sold->SetChartParam("showCanvasBase", "1", TRUE); // showCanvasBase
$dealers_transaction->Dealers_deal_sold->SetChartParam("showLimits", "1", TRUE); // showLimits
$dealers_transaction->Dealers_deal_sold->SetChartParam("animation", "1", TRUE); // animation
$dealers_transaction->Dealers_deal_sold->SetChartParam("rotateNames", "1", TRUE); // rotateNames
$dealers_transaction->Dealers_deal_sold->SetChartParam("yAxisMinValue", "0", TRUE); // yAxisMinValue
$dealers_transaction->Dealers_deal_sold->SetChartParam("yAxisMaxValue", "0", TRUE); // yAxisMaxValue
$dealers_transaction->Dealers_deal_sold->SetChartParam("PYAxisMinValue", "0", TRUE); // PYAxisMinValue
$dealers_transaction->Dealers_deal_sold->SetChartParam("PYAxisMaxValue", "0", TRUE); // PYAxisMaxValue
$dealers_transaction->Dealers_deal_sold->SetChartParam("SYAxisMinValue", "0", TRUE); // SYAxisMinValue
$dealers_transaction->Dealers_deal_sold->SetChartParam("SYAxisMaxValue", "0", TRUE); // SYAxisMaxValue
$dealers_transaction->Dealers_deal_sold->SetChartParam("showColumnShadow", "0", TRUE); // showColumnShadow
$dealers_transaction->Dealers_deal_sold->SetChartParam("showPercentageValues", "1", TRUE); // showPercentageValues
$dealers_transaction->Dealers_deal_sold->SetChartParam("showPercentageInLabel", "1", TRUE); // showPercentageInLabel
$dealers_transaction->Dealers_deal_sold->SetChartParam("showBarShadow", "0", TRUE); // showBarShadow
$dealers_transaction->Dealers_deal_sold->SetChartParam("showAnchors", "1", TRUE); // showAnchors
$dealers_transaction->Dealers_deal_sold->SetChartParam("showAreaBorder", "1", TRUE); // showAreaBorder
$dealers_transaction->Dealers_deal_sold->SetChartParam("isSliced", "1", TRUE); // isSliced
$dealers_transaction->Dealers_deal_sold->SetChartParam("showAsBars", "0", TRUE); // showAsBars
$dealers_transaction->Dealers_deal_sold->SetChartParam("showShadow", "0", TRUE); // showShadow
$dealers_transaction->Dealers_deal_sold->SetChartParam("formatNumber", "0", TRUE); // formatNumber
$dealers_transaction->Dealers_deal_sold->SetChartParam("formatNumberScale", "0", TRUE); // formatNumberScale
$dealers_transaction->Dealers_deal_sold->SetChartParam("decimalSeparator", ".", TRUE); // decimalSeparator
$dealers_transaction->Dealers_deal_sold->SetChartParam("thousandSeparator", ",", TRUE); // thousandSeparator
$dealers_transaction->Dealers_deal_sold->SetChartParam("decimalPrecision", "2", TRUE); // decimalPrecision
$dealers_transaction->Dealers_deal_sold->SetChartParam("divLineDecimalPrecision", "2", TRUE); // divLineDecimalPrecision
$dealers_transaction->Dealers_deal_sold->SetChartParam("limitsDecimalPrecision", "2", TRUE); // limitsDecimalPrecision
$dealers_transaction->Dealers_deal_sold->SetChartParam("zeroPlaneShowBorder", "1", TRUE); // zeroPlaneShowBorder
$dealers_transaction->Dealers_deal_sold->SetChartParam("showDivLineValue", "1", TRUE); // showDivLineValue
$dealers_transaction->Dealers_deal_sold->SetChartParam("showAlternateHGridColor", "0", TRUE); // showAlternateHGridColor
$dealers_transaction->Dealers_deal_sold->SetChartParam("showAlternateVGridColor", "0", TRUE); // showAlternateVGridColor
$dealers_transaction->Dealers_deal_sold->SetChartParam("hoverCapSepChar", ":", TRUE); // hoverCapSepChar

// Define trend lines
?>
<?php
$SqlSelect = $dealers_transaction->SqlSelect();
$SqlChartSelect = $dealers_transaction->Dealers_deal_sold->SqlSelect;
if (EWRPT_IS_MSSQL) // skip SqlOrderBy for MSSQL
	$sSqlChartBase = "(" . ewrpt_BuildReportSql($SqlSelect, $dealers_transaction->SqlWhere(), $dealers_transaction->SqlGroupBy(), $dealers_transaction->SqlHaving(), "", $dealers_transaction_summary->Filter, "") . ") EW_TMP_TABLE";
else
	$sSqlChartBase = "(" . ewrpt_BuildReportSql($SqlSelect, $dealers_transaction->SqlWhere(), $dealers_transaction->SqlGroupBy(), $dealers_transaction->SqlHaving(), $dealers_transaction->SqlOrderBy(), $dealers_transaction_summary->Filter, "") . ") EW_TMP_TABLE";
$dealers_transaction->Dealers_deal_sold->Series[] = $dealers_transaction->Deals_made->FldCaption();
$dealers_transaction->Dealers_deal_sold->Series[] = $dealers_transaction->Sold->FldCaption();

// Load chart data from sql directly
$sSql = $SqlChartSelect . $sSqlChartBase;
$sSql = ewrpt_BuildReportSql($sSql, "", $dealers_transaction->Dealers_deal_sold->SqlGroupBy, "", $dealers_transaction->Dealers_deal_sold->SqlOrderBy, "", "");
if (EWRPT_DEBUG_ENABLED) echo "(Chart SQL): " . $sSql . "<br>";
ewrpt_LoadChartData($sSql, $dealers_transaction->Dealers_deal_sold);
ewrpt_SortChartData($dealers_transaction->Dealers_deal_sold->Data, 0, "");

// Call Chart_Rendering event
$dealers_transaction->Chart_Rendering($dealers_transaction->Dealers_deal_sold);
$chartxml = $dealers_transaction->Dealers_deal_sold->ChartXml();

// Call Chart_Rendered event
$dealers_transaction->Chart_Rendered($dealers_transaction->Dealers_deal_sold, $chartxml);
echo $dealers_transaction->Dealers_deal_sold->ShowChartFCF($chartxml);
?>
<a href="#top"><?php echo $ReportLanguage->Phrase("Top") ?></a>
<br><br>
	</div><br></td></tr>
<!-- Bottom Container (End) -->
</table>
<!-- Table Container (End) -->
<?php } ?>
<?php $dealers_transaction_summary->ShowPageFooter(); ?>
<?php if (EWRPT_DEBUG_ENABLED) echo ewrpt_DebugMsg(); ?>
<?php

// Close recordsets
if ($rsgrp) $rsgrp->Close();
if ($rs) $rs->Close();
?>
<?php if ($dealers_transaction->Export == "") { ?>
<script language="JavaScript" type="text/javascript">
<!--

// Write your table-specific startup script here
// document.write("page loaded");
//-->

</script>
<?php } ?>
<?php include_once "phprptinc/footer.php"; ?>
<?php
$dealers_transaction_summary->Page_Terminate();
?>
<?php

//
// Page class
//
class crdealers_transaction_summary {

	// Page ID
	var $PageID = 'summary';

	// Table name
	var $TableName = 'dealers_transaction';

	// Page object name
	var $PageObjName = 'dealers_transaction_summary';

	// Page name
	function PageName() {
		return ewrpt_CurrentPage();
	}

	// Page URL
	function PageUrl() {
		$PageUrl = ewrpt_CurrentPage() . "?";
		global $dealers_transaction;
		if ($dealers_transaction->UseTokenInUrl) $PageUrl .= "t=" . $dealers_transaction->TableVar . "&"; // Add page token
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
		global $dealers_transaction;
		if ($dealers_transaction->UseTokenInUrl) {
			if (ewrpt_IsHttpPost())
				return ($dealers_transaction->TableVar == @$_POST("t"));
			if (@$_GET["t"] <> "")
				return ($dealers_transaction->TableVar == @$_GET["t"]);
		} else {
			return TRUE;
		}
	}

	//
	// Page class constructor
	//
	function crdealers_transaction_summary() {
		global $conn, $ReportLanguage;

		// Language object
		$ReportLanguage = new crLanguage();

		// Table object (dealers_transaction)
		$GLOBALS["dealers_transaction"] = new crdealers_transaction();
		$GLOBALS["Table"] =& $GLOBALS["dealers_transaction"];

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
			define("EWRPT_TABLE_NAME", 'dealers_transaction', TRUE);

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
		global $dealers_transaction;

		// Security
		$Security = new crAdvancedSecurity();
		if (!$Security->IsLoggedIn()) $Security->AutoLogin(); // Auto login
		if (!$Security->IsLoggedIn()) {
			$Security->SaveLastUrl();
			$this->Page_Terminate("rlogin.php");
		}

		// Get export parameters
		if (@$_GET["export"] <> "") {
			$dealers_transaction->Export = $_GET["export"];
		}
		$gsExport = $dealers_transaction->Export; // Get export parameter, used in header
		$gsExportFile = $dealers_transaction->TableVar; // Get export file, used in header
		if ($dealers_transaction->Export == "excel") {
			header('Content-Type: application/vnd.ms-excel;charset=utf-8');
			header('Content-Disposition: attachment; filename=' . $gsExportFile .'.xls');
		}
		if ($dealers_transaction->Export == "word") {
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
		global $ReportLanguage, $dealers_transaction;

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
		$item->Body = "<a name=\"emf_dealers_transaction\" id=\"emf_dealers_transaction\" href=\"javascript:void(0);\" onclick=\"ewrpt_EmailDialogShow({lnk:'emf_dealers_transaction',hdr:ewLanguage.Phrase('ExportToEmail')});\">" . $ReportLanguage->Phrase("ExportToEmail") . "</a>";
		$item->Visible = FALSE;

		// Reset filter
		$item =& $this->ExportOptions->Add("resetfilter");
		$item->Body = "<a href=\"" . ewrpt_CurrentPage() . "?cmd=reset\">" . $ReportLanguage->Phrase("ResetAllFilter") . "</a>";
		$item->Visible = TRUE;
		$this->SetupExportOptionsExt();

		// Hide options for export
		if ($dealers_transaction->Export <> "")
			$this->ExportOptions->HideAllOptions();

		// Set up table class
		if ($dealers_transaction->Export == "word" || $dealers_transaction->Export == "excel" || $dealers_transaction->Export == "pdf")
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
		global $dealers_transaction;

		// Page Unload event
		$this->Page_Unload();

		// Global Page Unloaded event (in userfn*.php)
		Page_Unloaded();

		// Export to Email (use ob_file_contents for PHP)
		if ($dealers_transaction->Export == "email") {
			$sContent = ob_get_contents();
			$this->ExportEmail($sContent);
			ob_end_clean();

			 // Close connection
			$conn->Close();
			header("Location: " . ewrpt_CurrentPage());
			exit();
		}

		// Export to PDF (use ob_file_contents for PHP)
		if ($dealers_transaction->Export == "pdf") {
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
		global $dealers_transaction;
		global $rs;
		global $rsgrp;
		global $gsFormError;

		// Aggregate variables
		// 1st dimension = no of groups (level 0 used for grand total)
		// 2nd dimension = no of fields

		$nDtls = 8;
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
		$this->Col = array(FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE);

		// Set up groups per page dynamically
		$this->SetUpDisplayGrps();

		// Load default filter values
		$this->LoadDefaultFilters();

		// Load custom filters
		$dealers_transaction->Filters_Load();

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
		$sSql = ewrpt_BuildReportSql($dealers_transaction->SqlSelect(), $dealers_transaction->SqlWhere(), $dealers_transaction->SqlGroupBy(), $dealers_transaction->SqlHaving(), $dealers_transaction->SqlOrderBy(), $this->Filter, $this->Sort);
		$this->TotalGrps = $this->GetCnt($sSql);
		if ($this->DisplayGrps <= 0) // Display all groups
			$this->DisplayGrps = $this->TotalGrps;
		$this->StartGrp = 1;

		// Show header
		$this->ShowFirstHeader = ($this->TotalGrps > 0);

		//$this->ShowFirstHeader = TRUE; // Uncomment to always show header
		// Set up start position if not export all

		if ($dealers_transaction->ExportAll && $dealers_transaction->Export <> "")
		    $this->DisplayGrps = $this->TotalGrps;
		else
			$this->SetUpStartGroup(); 

		// Hide all options if export
		if ($dealers_transaction->Export <> "") {
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
		global $dealers_transaction;
		if (!$rs)
			return;
		if ($opt == 1) { // Get first row

	//		$rs->MoveFirst(); // NOTE: no need to move position
		} else { // Get next row
			$rs->MoveNext();
		}
		if (!$rs->EOF) {
			$dealers_transaction->code->setDbValue($rs->fields('code'));
			$dealers_transaction->name->setDbValue($rs->fields('name'));
			$dealers_transaction->account->setDbValue($rs->fields('account'));
			$dealers_transaction->vat_registration->setDbValue($rs->fields('vat_registration'));
			$dealers_transaction->fsb_number->setDbValue($rs->fields('fsb_number'));
			$dealers_transaction->Deals_made->setDbValue($rs->fields('Deals made'));
			$dealers_transaction->Sold->setDbValue($rs->fields('Sold'));
			$dealers_transaction->StartDate->setDbValue($rs->fields('StartDate'));
			$this->Val[1] = $dealers_transaction->code->CurrentValue;
			$this->Val[2] = $dealers_transaction->name->CurrentValue;
			$this->Val[3] = $dealers_transaction->account->CurrentValue;
			$this->Val[4] = $dealers_transaction->vat_registration->CurrentValue;
			$this->Val[5] = $dealers_transaction->fsb_number->CurrentValue;
			$this->Val[6] = $dealers_transaction->Deals_made->CurrentValue;
			$this->Val[7] = $dealers_transaction->Sold->CurrentValue;
		} else {
			$dealers_transaction->code->setDbValue("");
			$dealers_transaction->name->setDbValue("");
			$dealers_transaction->account->setDbValue("");
			$dealers_transaction->vat_registration->setDbValue("");
			$dealers_transaction->fsb_number->setDbValue("");
			$dealers_transaction->Deals_made->setDbValue("");
			$dealers_transaction->Sold->setDbValue("");
			$dealers_transaction->StartDate->setDbValue("");
		}
	}

	//  Set up starting group
	function SetUpStartGroup() {
		global $dealers_transaction;

		// Exit if no groups
		if ($this->DisplayGrps == 0)
			return;

		// Check for a 'start' parameter
		if (@$_GET[EWRPT_TABLE_START_GROUP] != "") {
			$this->StartGrp = $_GET[EWRPT_TABLE_START_GROUP];
			$dealers_transaction->setStartGroup($this->StartGrp);
		} elseif (@$_GET["pageno"] != "") {
			$nPageNo = $_GET["pageno"];
			if (is_numeric($nPageNo)) {
				$this->StartGrp = ($nPageNo-1)*$this->DisplayGrps+1;
				if ($this->StartGrp <= 0) {
					$this->StartGrp = 1;
				} elseif ($this->StartGrp >= intval(($this->TotalGrps-1)/$this->DisplayGrps)*$this->DisplayGrps+1) {
					$this->StartGrp = intval(($this->TotalGrps-1)/$this->DisplayGrps)*$this->DisplayGrps+1;
				}
				$dealers_transaction->setStartGroup($this->StartGrp);
			} else {
				$this->StartGrp = $dealers_transaction->getStartGroup();
			}
		} else {
			$this->StartGrp = $dealers_transaction->getStartGroup();
		}

		// Check if correct start group counter
		if (!is_numeric($this->StartGrp) || $this->StartGrp == "") { // Avoid invalid start group counter
			$this->StartGrp = 1; // Reset start group counter
			$dealers_transaction->setStartGroup($this->StartGrp);
		} elseif (intval($this->StartGrp) > intval($this->TotalGrps)) { // Avoid starting group > total groups
			$this->StartGrp = intval(($this->TotalGrps-1)/$this->DisplayGrps) * $this->DisplayGrps + 1; // Point to last page first group
			$dealers_transaction->setStartGroup($this->StartGrp);
		} elseif (($this->StartGrp-1) % $this->DisplayGrps <> 0) {
			$this->StartGrp = intval(($this->StartGrp-1)/$this->DisplayGrps) * $this->DisplayGrps + 1; // Point to page boundary
			$dealers_transaction->setStartGroup($this->StartGrp);
		}
	}

	// Set up popup
	function SetupPopup() {
		global $conn, $ReportLanguage;
		global $dealers_transaction;

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
		global $dealers_transaction;
		$this->StartGrp = 1;
		$dealers_transaction->setStartGroup($this->StartGrp);
	}

	// Set up number of groups displayed per page
	function SetUpDisplayGrps() {
		global $dealers_transaction;
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
			$dealers_transaction->setGroupPerPage($this->DisplayGrps); // Save to session

			// Reset start position (reset command)
			$this->StartGrp = 1;
			$dealers_transaction->setStartGroup($this->StartGrp);
		} else {
			if ($dealers_transaction->getGroupPerPage() <> "") {
				$this->DisplayGrps = $dealers_transaction->getGroupPerPage(); // Restore from session
			} else {
				$this->DisplayGrps = 50; // Load default
			}
		}
	}

	function RenderRow() {
		global $conn, $rs, $Security;
		global $dealers_transaction;
		if ($dealers_transaction->RowTotalType == EWRPT_ROWTOTAL_GRAND) { // Grand total

			// Get total count from sql directly
			$sSql = ewrpt_BuildReportSql($dealers_transaction->SqlSelectCount(), $dealers_transaction->SqlWhere(), $dealers_transaction->SqlGroupBy(), $dealers_transaction->SqlHaving(), "", $this->Filter, "");
			$rstot = $conn->Execute($sSql);
			if ($rstot) {
				$this->TotCount = ($rstot->RecordCount()>1) ? $rstot->RecordCount() : $rstot->fields[0];
				$rstot->Close();
			} else {
				$this->TotCount = 0;
			}
		}

		// Call Row_Rendering event
		$dealers_transaction->Row_Rendering();

		//
		// Render view codes
		//

		if ($dealers_transaction->RowType == EWRPT_ROWTYPE_TOTAL) { // Summary row
		} else {

			// code
			$dealers_transaction->code->ViewValue = $dealers_transaction->code->CurrentValue;
			$dealers_transaction->code->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";

			// name
			$dealers_transaction->name->ViewValue = $dealers_transaction->name->CurrentValue;
			$dealers_transaction->name->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";
			$dealers_transaction->name->CellAttrs["style"] = "white-space: nowrap;";

			// account
			$dealers_transaction->account->ViewValue = $dealers_transaction->account->CurrentValue;
			$dealers_transaction->account->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";
			$dealers_transaction->account->CellAttrs["style"] = "white-space: nowrap;";

			// vat_registration
			$dealers_transaction->vat_registration->ViewValue = $dealers_transaction->vat_registration->CurrentValue;
			$dealers_transaction->vat_registration->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";

			// fsb_number
			$dealers_transaction->fsb_number->ViewValue = $dealers_transaction->fsb_number->CurrentValue;
			$dealers_transaction->fsb_number->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";

			// Deals made
			$dealers_transaction->Deals_made->ViewValue = $dealers_transaction->Deals_made->CurrentValue;
			$dealers_transaction->Deals_made->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";

			// Sold
			$dealers_transaction->Sold->ViewValue = $dealers_transaction->Sold->CurrentValue;
			$dealers_transaction->Sold->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";

			// code
			$dealers_transaction->code->HrefValue = "";

			// name
			$dealers_transaction->name->HrefValue = "";

			// account
			$dealers_transaction->account->HrefValue = "";

			// vat_registration
			$dealers_transaction->vat_registration->HrefValue = "";

			// fsb_number
			$dealers_transaction->fsb_number->HrefValue = "";

			// Deals made
			$dealers_transaction->Deals_made->HrefValue = "";

			// Sold
			$dealers_transaction->Sold->HrefValue = "";
		}

		// Call Cell_Rendered event
		if ($dealers_transaction->RowType == EWRPT_ROWTYPE_TOTAL) { // Summary row
		} else {

			// code
			$CurrentValue = $dealers_transaction->code->CurrentValue;
			$ViewValue =& $dealers_transaction->code->ViewValue;
			$ViewAttrs =& $dealers_transaction->code->ViewAttrs;
			$CellAttrs =& $dealers_transaction->code->CellAttrs;
			$HrefValue =& $dealers_transaction->code->HrefValue;
			$dealers_transaction->Cell_Rendered($dealers_transaction->code, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue);

			// name
			$CurrentValue = $dealers_transaction->name->CurrentValue;
			$ViewValue =& $dealers_transaction->name->ViewValue;
			$ViewAttrs =& $dealers_transaction->name->ViewAttrs;
			$CellAttrs =& $dealers_transaction->name->CellAttrs;
			$HrefValue =& $dealers_transaction->name->HrefValue;
			$dealers_transaction->Cell_Rendered($dealers_transaction->name, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue);

			// account
			$CurrentValue = $dealers_transaction->account->CurrentValue;
			$ViewValue =& $dealers_transaction->account->ViewValue;
			$ViewAttrs =& $dealers_transaction->account->ViewAttrs;
			$CellAttrs =& $dealers_transaction->account->CellAttrs;
			$HrefValue =& $dealers_transaction->account->HrefValue;
			$dealers_transaction->Cell_Rendered($dealers_transaction->account, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue);

			// vat_registration
			$CurrentValue = $dealers_transaction->vat_registration->CurrentValue;
			$ViewValue =& $dealers_transaction->vat_registration->ViewValue;
			$ViewAttrs =& $dealers_transaction->vat_registration->ViewAttrs;
			$CellAttrs =& $dealers_transaction->vat_registration->CellAttrs;
			$HrefValue =& $dealers_transaction->vat_registration->HrefValue;
			$dealers_transaction->Cell_Rendered($dealers_transaction->vat_registration, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue);

			// fsb_number
			$CurrentValue = $dealers_transaction->fsb_number->CurrentValue;
			$ViewValue =& $dealers_transaction->fsb_number->ViewValue;
			$ViewAttrs =& $dealers_transaction->fsb_number->ViewAttrs;
			$CellAttrs =& $dealers_transaction->fsb_number->CellAttrs;
			$HrefValue =& $dealers_transaction->fsb_number->HrefValue;
			$dealers_transaction->Cell_Rendered($dealers_transaction->fsb_number, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue);

			// Deals made
			$CurrentValue = $dealers_transaction->Deals_made->CurrentValue;
			$ViewValue =& $dealers_transaction->Deals_made->ViewValue;
			$ViewAttrs =& $dealers_transaction->Deals_made->ViewAttrs;
			$CellAttrs =& $dealers_transaction->Deals_made->CellAttrs;
			$HrefValue =& $dealers_transaction->Deals_made->HrefValue;
			$dealers_transaction->Cell_Rendered($dealers_transaction->Deals_made, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue);

			// Sold
			$CurrentValue = $dealers_transaction->Sold->CurrentValue;
			$ViewValue =& $dealers_transaction->Sold->ViewValue;
			$ViewAttrs =& $dealers_transaction->Sold->ViewAttrs;
			$CellAttrs =& $dealers_transaction->Sold->CellAttrs;
			$HrefValue =& $dealers_transaction->Sold->HrefValue;
			$dealers_transaction->Cell_Rendered($dealers_transaction->Sold, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue);
		}

		// Call Row_Rendered event
		$dealers_transaction->Row_Rendered();
	}

	function SetupExportOptionsExt() {
		global $ReportLanguage, $dealers_transaction;
	}

	// Get extended filter values
	function GetExtendedFilterValues() {
		global $dealers_transaction;

		// Field StartDate
		$sSelect = "SELECT DISTINCT agree.StartDate FROM " . $dealers_transaction->SqlFrom();
		$sOrderBy = "agree.StartDate ASC";
		$wrkSql = ewrpt_BuildReportSql($sSelect, $dealers_transaction->SqlWhere(), "", "", $sOrderBy, $this->UserIDFilter, "");
		$dealers_transaction->StartDate->DropDownList = ewrpt_GetDistinctValues($dealers_transaction->StartDate->DateFilter, $wrkSql);
	}

	// Return extended filter
	function GetExtendedFilter() {
		global $dealers_transaction;
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
			// Field StartDate

			$this->SetSessionDropDownValue($dealers_transaction->StartDate->DropDownValue, 'StartDate');
			$bSetupFilter = TRUE;
		} else {

			// Field StartDate
			if ($this->GetDropDownValue($dealers_transaction->StartDate->DropDownValue, 'StartDate')) {
				$bSetupFilter = TRUE;
				$bRestoreSession = FALSE;
			} elseif ($dealers_transaction->StartDate->DropDownValue <> EWRPT_INIT_VALUE && !isset($_SESSION['sv_dealers_transaction->StartDate'])) {
				$bSetupFilter = TRUE;
			}
			if (!$this->ValidateForm()) {
				$this->setMessage($gsFormError);
				return $sFilter;
			}
		}

		// Restore session
		if ($bRestoreSession) {

			// Field StartDate
			$this->GetSessionDropDownValue($dealers_transaction->StartDate);
		}

		// Call page filter validated event
		$dealers_transaction->Page_FilterValidated();

		// Build SQL
		// Field StartDate

		ewrpt_BuildDropDownFilter($dealers_transaction->StartDate, $sFilter, $dealers_transaction->StartDate->DateFilter);

		// Save parms to session
		// Field StartDate

		$this->SetSessionDropDownValue($dealers_transaction->StartDate->DropDownValue, 'StartDate');

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
		$this->GetSessionValue($fld->DropDownValue, 'sv_dealers_transaction_' . $parm);
	}

	// Get filter values from session
	function GetSessionFilterValues(&$fld) {
		$parm = substr($fld->FldVar, 2);
		$this->GetSessionValue($fld->SearchValue, 'sv1_dealers_transaction_' . $parm);
		$this->GetSessionValue($fld->SearchOperator, 'so1_dealers_transaction_' . $parm);
		$this->GetSessionValue($fld->SearchCondition, 'sc_dealers_transaction_' . $parm);
		$this->GetSessionValue($fld->SearchValue2, 'sv2_dealers_transaction_' . $parm);
		$this->GetSessionValue($fld->SearchOperator2, 'so2_dealers_transaction_' . $parm);
	}

	// Get value from session
	function GetSessionValue(&$sv, $sn) {
		if (isset($_SESSION[$sn]))
			$sv = $_SESSION[$sn];
	}

	// Set dropdown value to session
	function SetSessionDropDownValue($sv, $parm) {
		$_SESSION['sv_dealers_transaction_' . $parm] = $sv;
	}

	// Set filter values to session
	function SetSessionFilterValues($sv1, $so1, $sc, $sv2, $so2, $parm) {
		$_SESSION['sv1_dealers_transaction_' . $parm] = $sv1;
		$_SESSION['so1_dealers_transaction_' . $parm] = $so1;
		$_SESSION['sc_dealers_transaction_' . $parm] = $sc;
		$_SESSION['sv2_dealers_transaction_' . $parm] = $sv2;
		$_SESSION['so2_dealers_transaction_' . $parm] = $so2;
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
		global $ReportLanguage, $gsFormError, $dealers_transaction;

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
		$_SESSION["sel_dealers_transaction_$parm"] = "";
		$_SESSION["rf_dealers_transaction_$parm"] = "";
		$_SESSION["rt_dealers_transaction_$parm"] = "";
	}

	// Load selection from session
	function LoadSelectionFromSession($parm) {
		global $dealers_transaction;
		$fld =& $dealers_transaction->fields($parm);
		$fld->SelectionList = @$_SESSION["sel_dealers_transaction_$parm"];
		$fld->RangeFrom = @$_SESSION["rf_dealers_transaction_$parm"];
		$fld->RangeTo = @$_SESSION["rt_dealers_transaction_$parm"];
	}

	// Load default value for filters
	function LoadDefaultFilters() {
		global $dealers_transaction;

		/**
		* Set up default values for non Text filters
		*/

		// Field StartDate
		$dealers_transaction->StartDate->DefaultDropDownValue = EWRPT_INIT_VALUE;
		$dealers_transaction->StartDate->DropDownValue = $dealers_transaction->StartDate->DefaultDropDownValue;

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
		global $dealers_transaction;

		// Check StartDate extended filter
		if ($this->NonTextFilterApplied($dealers_transaction->StartDate))
			return TRUE;
		return FALSE;
	}

	// Show list of filters
	function ShowFilterList() {
		global $dealers_transaction;
		global $ReportLanguage;

		// Initialize
		$sFilterList = "";

		// Field StartDate
		$sExtWrk = "";
		$sWrk = "";
		ewrpt_BuildDropDownFilter($dealers_transaction->StartDate, $sExtWrk, $dealers_transaction->StartDate->DateFilter);
		if ($sExtWrk <> "" || $sWrk <> "")
			$sFilterList .= $dealers_transaction->StartDate->FldCaption() . "<br>";
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
		global $dealers_transaction;
		$sWrk = "";
		return $sWrk;
	}

	//-------------------------------------------------------------------------------
	// Function GetSort
	// - Return Sort parameters based on Sort Links clicked
	// - Variables setup: Session[EWRPT_TABLE_SESSION_ORDER_BY], Session["sort_Table_Field"]
	function GetSort() {
		global $dealers_transaction;

		// Check for a resetsort command
		if (strlen(@$_GET["cmd"]) > 0) {
			$sCmd = @$_GET["cmd"];
			if ($sCmd == "resetsort") {
				$dealers_transaction->setOrderBy("");
				$dealers_transaction->setStartGroup(1);
				$dealers_transaction->code->setSort("");
				$dealers_transaction->name->setSort("");
				$dealers_transaction->account->setSort("");
				$dealers_transaction->vat_registration->setSort("");
				$dealers_transaction->fsb_number->setSort("");
				$dealers_transaction->Deals_made->setSort("");
				$dealers_transaction->Sold->setSort("");
			}

		// Check for an Order parameter
		} elseif (@$_GET["order"] <> "") {
			$dealers_transaction->CurrentOrder = ewrpt_StripSlashes(@$_GET["order"]);
			$dealers_transaction->CurrentOrderType = @$_GET["ordertype"];
			$sSortSql = $dealers_transaction->SortSql();
			$dealers_transaction->setOrderBy($sSortSql);
			$dealers_transaction->setStartGroup(1);
		}
		return $dealers_transaction->getOrderBy();
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
