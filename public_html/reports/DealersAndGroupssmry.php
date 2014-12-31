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
$DealersAndGroups = NULL;

//
// Table class for DealersAndGroups
//
class crDealersAndGroups {
	var $TableVar = 'DealersAndGroups';
	var $TableName = 'DealersAndGroups';
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
	var $Dealers27_Chart;
	var $catalog;
	var $DateModified;
	var $Deals_made;
	var $Status;
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
	function crDealersAndGroups() {
		global $ReportLanguage;

		// catalog
		$this->catalog = new crField('DealersAndGroups', 'DealersAndGroups', 'x_catalog', 'catalog', 'dealer.catalog', 202, EWRPT_DATATYPE_STRING, -1);
		$this->fields['catalog'] =& $this->catalog;
		$this->catalog->DateFilter = "";
		$this->catalog->SqlSelect = "";
		$this->catalog->SqlOrderBy = "";

		// DateModified
		$this->DateModified = new crField('DealersAndGroups', 'DealersAndGroups', 'x_DateModified', 'DateModified', 'trans.DateModified', 135, EWRPT_DATATYPE_DATE, 7);
		$this->DateModified->FldDefaultErrMsg = str_replace("%s", "-", $ReportLanguage->Phrase("IncorrectDateDMY"));
		$this->fields['DateModified'] =& $this->DateModified;
		$this->DateModified->DateFilter = "Month";
		$this->DateModified->SqlSelect = "";
		$this->DateModified->SqlOrderBy = "";
		ewrpt_RegisterFilter($this->DateModified, "@@LastMonth", $ReportLanguage->Phrase("LastMonth"), "ewrpt_IsLastMonth");
		ewrpt_RegisterFilter($this->DateModified, "@@ThisMonth", $ReportLanguage->Phrase("ThisMonth"), "ewrpt_IsThisMonth");
		ewrpt_RegisterFilter($this->DateModified, "@@NextMonth", $ReportLanguage->Phrase("NextMonth"), "ewrpt_IsNextMonth");

		// Deals made
		$this->Deals_made = new crField('DealersAndGroups', 'DealersAndGroups', 'x_Deals_made', 'Deals made', 'Count(DISTINCT trans.Id)', 20, EWRPT_DATATYPE_NUMBER, -1);
		$this->Deals_made->FldDefaultErrMsg = $ReportLanguage->Phrase("IncorrectInteger");
		$this->fields['Deals_made'] =& $this->Deals_made;
		$this->Deals_made->DateFilter = "";
		$this->Deals_made->SqlSelect = "";
		$this->Deals_made->SqlOrderBy = "";

		// Status
		$this->Status = new crField('DealersAndGroups', 'DealersAndGroups', 'x_Status', 'Status', 'trans.Status', 200, EWRPT_DATATYPE_STRING, -1);
		$this->fields['Status'] =& $this->Status;
		$this->Status->DateFilter = "";
		$this->Status->SqlSelect = "";
		$this->Status->SqlOrderBy = "";

		// Dealers' Chart
		$this->Dealers27_Chart = new crChart('DealersAndGroups', 'DealersAndGroups', 'Dealers27_Chart', 'Dealers\' Chart', 'catalog', 'Deals made', '', 1, 'SUM', 1024, 800);
		$this->Dealers27_Chart->SqlSelect = "SELECT `catalog`, '', SUM(`Deals made`) FROM ";
		$this->Dealers27_Chart->SqlGroupBy = "`catalog`";
		$this->Dealers27_Chart->SqlOrderBy = "";
		$this->Dealers27_Chart->SeriesDateType = "";
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
		return "roadCover_dealers dealer Left Join road_Transactions trans On trans.Intermediary = dealer.code Left Join road_Agreements agree On agree.transaction = trans.Id";
	}

	function SqlSelect() { // Select
		return "SELECT dealer.catalog, trans.DateModified, Count(Distinct trans.Id) As `Deals made`, trans.Status FROM " . $this->SqlFrom();
	}

	function SqlWhere() { // Where
		return "";
	}

	function SqlGroupBy() { // Group By
		return "dealer.catalog";
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
$DealersAndGroups_summary = new crDealersAndGroups_summary();
$Page =& $DealersAndGroups_summary;

// Page init
$DealersAndGroups_summary->Page_Init();

// Page main
$DealersAndGroups_summary->Page_Main();
?>
<?php include_once "phprptinc/header.php"; ?>
<?php if ($DealersAndGroups->Export == "" || $DealersAndGroups->Export == "print" || $DealersAndGroups->Export == "email") { ?>
<script type="text/javascript">

// Create page object
var DealersAndGroups_summary = new ewrpt_Page("DealersAndGroups_summary");

// page properties
DealersAndGroups_summary.PageID = "summary"; // page ID
DealersAndGroups_summary.FormID = "fDealersAndGroupssummaryfilter"; // form ID
var EWRPT_PAGE_ID = DealersAndGroups_summary.PageID;

// extend page with Chart_Rendering function
DealersAndGroups_summary.Chart_Rendering =  
 function(chart, chartid) { // DO NOT CHANGE THIS LINE!

 	//alert(chartid);
 }

// extend page with Chart_Rendered function
DealersAndGroups_summary.Chart_Rendered =  
 function(chart, chartid) { // DO NOT CHANGE THIS LINE!

 	//alert(chartid);
 }
</script>
<?php } ?>
<?php if ($DealersAndGroups->Export == "") { ?>
<script type="text/javascript">

// extend page with ValidateForm function
DealersAndGroups_summary.ValidateForm = function(fobj) {
	if (!this.ValidateRequired)
		return true; // ignore validation

	// Call Form Custom Validate event
	if (!this.Form_CustomValidate(fobj)) return false;
	return true;
}

// extend page with Form_CustomValidate function
DealersAndGroups_summary.Form_CustomValidate =  
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }
<?php if (EWRPT_CLIENT_VALIDATE) { ?>
DealersAndGroups_summary.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
DealersAndGroups_summary.ValidateRequired = false; // no JavaScript validation
<?php } ?>
</script>
<script language="JavaScript" type="text/javascript">
<!--

// Write your client script here, no need to add script tags.
//-->

</script>
<?php } ?>
<?php if ($DealersAndGroups->Export == "" || $DealersAndGroups->Export == "print" || $DealersAndGroups->Export == "email") { ?>
<script src="<?php echo EWRPT_FUSIONCHARTS_FREE_JSCLASS_FILE; ?>" type="text/javascript"></script>
<?php } ?>
<?php if ($DealersAndGroups->Export == "") { ?>
<div id="ewrpt_PopupFilter"><div class="bd"></div></div>
<script src="phprptjs/ewrptpop.js" type="text/javascript"></script>
<script type="text/javascript">

// popup fields
</script>
<?php } ?>
<?php if ($DealersAndGroups->Export == "" || $DealersAndGroups->Export == "print" || $DealersAndGroups->Export == "email") { ?>
<!-- Table Container (Begin) -->
<table id="ewContainer" cellspacing="0" cellpadding="0" border="0">
<!-- Top Container (Begin) -->
<tr><td colspan="3"><div id="ewTop" class="phpreportmaker">
<!-- top slot -->
<a name="top"></a>
<?php } ?>
<p class="phpreportmaker ewTitle"><?php echo $DealersAndGroups->TableCaption() ?>
&nbsp;&nbsp;<?php $DealersAndGroups_summary->ExportOptions->Render("body"); ?></p>
<?php $DealersAndGroups_summary->ShowPageHeader(); ?>
<?php $DealersAndGroups_summary->ShowMessage(); ?>
<br /><br />
<?php if ($DealersAndGroups->Export == "" || $DealersAndGroups->Export == "print" || $DealersAndGroups->Export == "email") { ?>
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
<?php if ($DealersAndGroups->Export == "") { ?>
<?php
if ($DealersAndGroups->FilterPanelOption == 2 || ($DealersAndGroups->FilterPanelOption == 3 && $DealersAndGroups_summary->FilterApplied) || $DealersAndGroups_summary->Filter == "0=101") {
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
<form name="fDealersAndGroupssummaryfilter" id="fDealersAndGroupssummaryfilter" action="<?php echo ewrpt_CurrentPage() ?>" class="ewForm" onsubmit="return DealersAndGroups_summary.ValidateForm(this);">
<table class="ewRptExtFilter">
	<tr id="r_DateModified">
		<td><span class="phpreportmaker"><?php echo $DealersAndGroups->DateModified->FldCaption() ?></span></td>
		<td></td>
		<td colspan="4"><span class="ewRptSearchOpr">
		<select name="sv_DateModified" id="sv_DateModified"<?php echo ($DealersAndGroups_summary->ClearExtFilter == 'DealersAndGroups_DateModified') ? " class=\"ewInputCleared\"" : "" ?>>
		<option value="<?php echo EWRPT_ALL_VALUE; ?>"<?php if (ewrpt_MatchedFilterValue($DealersAndGroups->DateModified->DropDownValue, EWRPT_ALL_VALUE)) echo " selected=\"selected\""; ?>><?php echo $ReportLanguage->Phrase("PleaseSelect"); ?></option>
<?php

// Popup filter
$cntf = is_array($DealersAndGroups->DateModified->AdvancedFilters) ? count($DealersAndGroups->DateModified->AdvancedFilters) : 0;
$cntd = is_array($DealersAndGroups->DateModified->DropDownList) ? count($DealersAndGroups->DateModified->DropDownList) : 0;
$totcnt = $cntf + $cntd;
$wrkcnt = 0;
	if ($cntf > 0) {
		foreach ($DealersAndGroups->DateModified->AdvancedFilters as $filter) {
			if ($filter->Enabled) {
?>
		<option value="<?php echo $filter->ID ?>"<?php if (ewrpt_MatchedFilterValue($DealersAndGroups->DateModified->DropDownValue, $filter->ID)) echo " selected=\"selected\"" ?>><?php echo $filter->Name ?></option>
<?php
				$wrkcnt += 1;
			}
		}
	}
	for ($i = 0; $i < $cntd; $i++) {
?>
		<option value="<?php echo $DealersAndGroups->DateModified->DropDownList[$i] ?>"<?php if (ewrpt_MatchedFilterValue($DealersAndGroups->DateModified->DropDownValue, $DealersAndGroups->DateModified->DropDownList[$i])) echo " selected=\"selected\"" ?>><?php echo ewrpt_DropDownDisplayValue($DealersAndGroups->DateModified->DropDownList[$i], $DealersAndGroups->DateModified->DateFilter, 7) ?></option>
<?php
		$wrkcnt += 1;
	}
?>
		</select>
		</span></td>
	</tr>
	<tr id="r_Status">
		<td><span class="phpreportmaker"><?php echo $DealersAndGroups->Status->FldCaption() ?></span></td>
		<td></td>
		<td colspan="4"><span class="ewRptSearchOpr">
		<select name="sv_Status" id="sv_Status"<?php echo ($DealersAndGroups_summary->ClearExtFilter == 'DealersAndGroups_Status') ? " class=\"ewInputCleared\"" : "" ?>>
		<option value="<?php echo EWRPT_ALL_VALUE; ?>"<?php if (ewrpt_MatchedFilterValue($DealersAndGroups->Status->DropDownValue, EWRPT_ALL_VALUE)) echo " selected=\"selected\""; ?>><?php echo $ReportLanguage->Phrase("PleaseSelect"); ?></option>
<?php

// Popup filter
$cntf = is_array($DealersAndGroups->Status->AdvancedFilters) ? count($DealersAndGroups->Status->AdvancedFilters) : 0;
$cntd = is_array($DealersAndGroups->Status->DropDownList) ? count($DealersAndGroups->Status->DropDownList) : 0;
$totcnt = $cntf + $cntd;
$wrkcnt = 0;
	if ($cntf > 0) {
		foreach ($DealersAndGroups->Status->AdvancedFilters as $filter) {
			if ($filter->Enabled) {
?>
		<option value="<?php echo $filter->ID ?>"<?php if (ewrpt_MatchedFilterValue($DealersAndGroups->Status->DropDownValue, $filter->ID)) echo " selected=\"selected\"" ?>><?php echo $filter->Name ?></option>
<?php
				$wrkcnt += 1;
			}
		}
	}
	for ($i = 0; $i < $cntd; $i++) {
?>
		<option value="<?php echo $DealersAndGroups->Status->DropDownList[$i] ?>"<?php if (ewrpt_MatchedFilterValue($DealersAndGroups->Status->DropDownValue, $DealersAndGroups->Status->DropDownList[$i])) echo " selected=\"selected\"" ?>><?php echo ewrpt_DropDownDisplayValue($DealersAndGroups->Status->DropDownList[$i], "", 0) ?></option>
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
<?php if ($DealersAndGroups->ShowCurrentFilter) { ?>
<div id="ewrptFilterList">
<?php $DealersAndGroups_summary->ShowFilterList() ?>
</div>
<br />
<?php } ?>
<table class="ewGrid" cellspacing="0"><tr>
	<td class="ewGridContent">
<!-- Report Grid (Begin) -->
<div class="ewGridMiddlePanel">
<table class="<?php echo $DealersAndGroups_summary->ReportTableClass ?>" cellspacing="0">
<?php

// Set the last group to display if not export all
if ($DealersAndGroups->ExportAll && $DealersAndGroups->Export <> "") {
	$DealersAndGroups_summary->StopGrp = $DealersAndGroups_summary->TotalGrps;
} else {
	$DealersAndGroups_summary->StopGrp = $DealersAndGroups_summary->StartGrp + $DealersAndGroups_summary->DisplayGrps - 1;
}

// Stop group <= total number of groups
if (intval($DealersAndGroups_summary->StopGrp) > intval($DealersAndGroups_summary->TotalGrps))
	$DealersAndGroups_summary->StopGrp = $DealersAndGroups_summary->TotalGrps;
$DealersAndGroups_summary->RecCount = 0;

// Get first row
if ($DealersAndGroups_summary->TotalGrps > 0) {
	$DealersAndGroups_summary->GetRow(1);
	$DealersAndGroups_summary->GrpCount = 1;
}
while (($rs && !$rs->EOF && $DealersAndGroups_summary->GrpCount <= $DealersAndGroups_summary->DisplayGrps) || $DealersAndGroups_summary->ShowFirstHeader) {

	// Show header
	if ($DealersAndGroups_summary->ShowFirstHeader) {
?>
	<thead>
	<tr>
<td class="ewTableHeader">
<?php if ($DealersAndGroups->Export <> "") { ?>
<?php echo $DealersAndGroups->catalog->FldCaption() ?>
<?php } else { ?>
	<table cellspacing="0" class="ewTableHeaderBtn"><tr>
<?php if ($DealersAndGroups->SortUrl($DealersAndGroups->catalog) == "") { ?>
		<td style="vertical-align: bottom;"><?php echo $DealersAndGroups->catalog->FldCaption() ?></td>
<?php } else { ?>
		<td class="ewPointer" onmousedown="ewrpt_Sort(event,'<?php echo $DealersAndGroups->SortUrl($DealersAndGroups->catalog) ?>',0);"><?php echo $DealersAndGroups->catalog->FldCaption() ?></td><td style="width: 10px;">
		<?php if ($DealersAndGroups->catalog->getSort() == "ASC") { ?><img src="phprptimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($DealersAndGroups->catalog->getSort() == "DESC") { ?><img src="phprptimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td>
<?php } ?>
	</tr></table>
<?php } ?>
</td>
<td class="ewTableHeader">
<?php if ($DealersAndGroups->Export <> "") { ?>
<?php echo $DealersAndGroups->Deals_made->FldCaption() ?>
<?php } else { ?>
	<table cellspacing="0" class="ewTableHeaderBtn"><tr>
<?php if ($DealersAndGroups->SortUrl($DealersAndGroups->Deals_made) == "") { ?>
		<td style="vertical-align: bottom;"><?php echo $DealersAndGroups->Deals_made->FldCaption() ?></td>
<?php } else { ?>
		<td class="ewPointer" onmousedown="ewrpt_Sort(event,'<?php echo $DealersAndGroups->SortUrl($DealersAndGroups->Deals_made) ?>',0);"><?php echo $DealersAndGroups->Deals_made->FldCaption() ?></td><td style="width: 10px;">
		<?php if ($DealersAndGroups->Deals_made->getSort() == "ASC") { ?><img src="phprptimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($DealersAndGroups->Deals_made->getSort() == "DESC") { ?><img src="phprptimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td>
<?php } ?>
	</tr></table>
<?php } ?>
</td>
	</tr>
	</thead>
	<tbody>
<?php
		$DealersAndGroups_summary->ShowFirstHeader = FALSE;
	}
	$DealersAndGroups_summary->RecCount++;

		// Render detail row
		$DealersAndGroups->ResetCSS();
		$DealersAndGroups->RowType = EWRPT_ROWTYPE_DETAIL;
		$DealersAndGroups_summary->RenderRow();
?>
	<tr<?php echo $DealersAndGroups->RowAttributes(); ?>>
		<td<?php echo $DealersAndGroups->catalog->CellAttributes() ?>>
<span<?php echo $DealersAndGroups->catalog->ViewAttributes(); ?>><?php echo $DealersAndGroups->catalog->ListViewValue(); ?></span></td>
		<td<?php echo $DealersAndGroups->Deals_made->CellAttributes() ?>>
<span<?php echo $DealersAndGroups->Deals_made->ViewAttributes(); ?>><?php echo $DealersAndGroups->Deals_made->ListViewValue(); ?></span></td>
	</tr>
<?php

		// Accumulate page summary
		$DealersAndGroups_summary->AccumulateSummary();

		// Get next record
		$DealersAndGroups_summary->GetRow(2);
	$DealersAndGroups_summary->GrpCount++;
} // End while
?>
	</tbody>
	<tfoot>
<?php
if ($DealersAndGroups_summary->TotalGrps > 0) {
	$DealersAndGroups->ResetCSS();
	$DealersAndGroups->RowType = EWRPT_ROWTYPE_TOTAL;
	$DealersAndGroups->RowTotalType = EWRPT_ROWTOTAL_GRAND;
	$DealersAndGroups->RowTotalSubType = EWRPT_ROWTOTAL_FOOTER;
	$DealersAndGroups->RowAttrs["class"] = "ewRptGrandSummary";
	$DealersAndGroups_summary->RenderRow();
?>
	<!-- tr><td colspan="2"><span class="phpreportmaker">&nbsp;<br /></span></td></tr -->
	<tr<?php echo $DealersAndGroups->RowAttributes(); ?>><td colspan="2"><?php echo $ReportLanguage->Phrase("RptGrandTotal") ?> (<?php echo ewrpt_FormatNumber($DealersAndGroups_summary->TotCount,0,-2,-2,-2); ?><?php echo $ReportLanguage->Phrase("RptDtlRec") ?>)</td></tr>
<?php } ?>
	</tfoot>
</table>
</div>
<?php if ($DealersAndGroups->Export == "") { ?>
<div class="ewGridLowerPanel">
<form action="<?php echo ewrpt_CurrentPage() ?>" name="ewpagerform" id="ewpagerform" class="ewForm">
<table border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td style="white-space: nowrap;">
<?php if (!isset($Pager)) $Pager = new crPrevNextPager($DealersAndGroups_summary->StartGrp, $DealersAndGroups_summary->DisplayGrps, $DealersAndGroups_summary->TotalGrps) ?>
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
	<?php if ($DealersAndGroups_summary->Filter == "0=101") { ?>
	<span class="phpreportmaker"><?php echo $ReportLanguage->Phrase("EnterSearchCriteria") ?></span>
	<?php } else { ?>
	<span class="phpreportmaker"><?php echo $ReportLanguage->Phrase("NoRecord") ?></span>
	<?php } ?>
<?php } ?>
		</td>
<?php if ($DealersAndGroups_summary->TotalGrps > 0) { ?>
		<td style="white-space: nowrap;">&nbsp;&nbsp;&nbsp;&nbsp;</td>
		<td align="right" style="vertical-align: top; white-space: nowrap;"><span class="phpreportmaker"><?php echo $ReportLanguage->Phrase("GroupsPerPage"); ?>&nbsp;
<select name="<?php echo EWRPT_TABLE_GROUP_PER_PAGE; ?>" onchange="this.form.submit();">
<option value="1"<?php if ($DealersAndGroups_summary->DisplayGrps == 1) echo " selected=\"selected\"" ?>>1</option>
<option value="2"<?php if ($DealersAndGroups_summary->DisplayGrps == 2) echo " selected=\"selected\"" ?>>2</option>
<option value="3"<?php if ($DealersAndGroups_summary->DisplayGrps == 3) echo " selected=\"selected\"" ?>>3</option>
<option value="4"<?php if ($DealersAndGroups_summary->DisplayGrps == 4) echo " selected=\"selected\"" ?>>4</option>
<option value="5"<?php if ($DealersAndGroups_summary->DisplayGrps == 5) echo " selected=\"selected\"" ?>>5</option>
<option value="10"<?php if ($DealersAndGroups_summary->DisplayGrps == 10) echo " selected=\"selected\"" ?>>10</option>
<option value="20"<?php if ($DealersAndGroups_summary->DisplayGrps == 20) echo " selected=\"selected\"" ?>>20</option>
<option value="50"<?php if ($DealersAndGroups_summary->DisplayGrps == 50) echo " selected=\"selected\"" ?>>50</option>
<option value="ALL"<?php if ($DealersAndGroups->getGroupPerPage() == -1) echo " selected=\"selected\"" ?>><?php echo $ReportLanguage->Phrase("AllRecords") ?></option>
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
<?php if ($DealersAndGroups->Export == "" || $DealersAndGroups->Export == "print" || $DealersAndGroups->Export == "email") { ?>
	</div><br /></td>
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
<a name="cht_Dealers27_Chart"></a>
<div id="div_DealersAndGroups_Dealers27_Chart"></div>
<?php

// Initialize chart data
$DealersAndGroups->Dealers27_Chart->ID = "DealersAndGroups_Dealers27_Chart"; // Chart ID
$DealersAndGroups->Dealers27_Chart->SetChartParam("type", "1", FALSE); // Chart type
$DealersAndGroups->Dealers27_Chart->SetChartParam("seriestype", "0", FALSE); // Chart series type
$DealersAndGroups->Dealers27_Chart->SetChartParam("bgcolor", "FCFCFC", TRUE); // Background color
$DealersAndGroups->Dealers27_Chart->SetChartParam("caption", $DealersAndGroups->Dealers27_Chart->ChartCaption(), TRUE); // Chart caption
$DealersAndGroups->Dealers27_Chart->SetChartParam("xaxisname", $DealersAndGroups->Dealers27_Chart->ChartXAxisName(), TRUE); // X axis name
$DealersAndGroups->Dealers27_Chart->SetChartParam("yaxisname", $DealersAndGroups->Dealers27_Chart->ChartYAxisName(), TRUE); // Y axis name
$DealersAndGroups->Dealers27_Chart->SetChartParam("shownames", "1", TRUE); // Show names
$DealersAndGroups->Dealers27_Chart->SetChartParam("showvalues", "1", TRUE); // Show values
$DealersAndGroups->Dealers27_Chart->SetChartParam("showhovercap", "0", TRUE); // Show hover
$DealersAndGroups->Dealers27_Chart->SetChartParam("alpha", "50", FALSE); // Chart alpha
$DealersAndGroups->Dealers27_Chart->SetChartParam("colorpalette", "#FF0000|#FF0080|#FF00FF|#8000FF|#FF8000|#FF3D3D|#7AFFFF|#0000FF|#FFFF00|#FF7A7A|#3DFFFF|#0080FF|#80FF00|#00FF00|#00FF80|#00FFFF", FALSE); // Chart color palette
?>
<?php
$DealersAndGroups->Dealers27_Chart->SetChartParam("showCanvasBg", "1", TRUE); // showCanvasBg
$DealersAndGroups->Dealers27_Chart->SetChartParam("showCanvasBase", "1", TRUE); // showCanvasBase
$DealersAndGroups->Dealers27_Chart->SetChartParam("showLimits", "1", TRUE); // showLimits
$DealersAndGroups->Dealers27_Chart->SetChartParam("animation", "1", TRUE); // animation
$DealersAndGroups->Dealers27_Chart->SetChartParam("rotateNames", "0", TRUE); // rotateNames
$DealersAndGroups->Dealers27_Chart->SetChartParam("yAxisMinValue", "0", TRUE); // yAxisMinValue
$DealersAndGroups->Dealers27_Chart->SetChartParam("yAxisMaxValue", "0", TRUE); // yAxisMaxValue
$DealersAndGroups->Dealers27_Chart->SetChartParam("PYAxisMinValue", "0", TRUE); // PYAxisMinValue
$DealersAndGroups->Dealers27_Chart->SetChartParam("PYAxisMaxValue", "0", TRUE); // PYAxisMaxValue
$DealersAndGroups->Dealers27_Chart->SetChartParam("SYAxisMinValue", "0", TRUE); // SYAxisMinValue
$DealersAndGroups->Dealers27_Chart->SetChartParam("SYAxisMaxValue", "0", TRUE); // SYAxisMaxValue
$DealersAndGroups->Dealers27_Chart->SetChartParam("showColumnShadow", "1", TRUE); // showColumnShadow
$DealersAndGroups->Dealers27_Chart->SetChartParam("showPercentageValues", "1", TRUE); // showPercentageValues
$DealersAndGroups->Dealers27_Chart->SetChartParam("showPercentageInLabel", "1", TRUE); // showPercentageInLabel
$DealersAndGroups->Dealers27_Chart->SetChartParam("showBarShadow", "0", TRUE); // showBarShadow
$DealersAndGroups->Dealers27_Chart->SetChartParam("showAnchors", "1", TRUE); // showAnchors
$DealersAndGroups->Dealers27_Chart->SetChartParam("showAreaBorder", "1", TRUE); // showAreaBorder
$DealersAndGroups->Dealers27_Chart->SetChartParam("isSliced", "1", TRUE); // isSliced
$DealersAndGroups->Dealers27_Chart->SetChartParam("showAsBars", "0", TRUE); // showAsBars
$DealersAndGroups->Dealers27_Chart->SetChartParam("showShadow", "0", TRUE); // showShadow
$DealersAndGroups->Dealers27_Chart->SetChartParam("formatNumber", "0", TRUE); // formatNumber
$DealersAndGroups->Dealers27_Chart->SetChartParam("formatNumberScale", "0", TRUE); // formatNumberScale
$DealersAndGroups->Dealers27_Chart->SetChartParam("decimalSeparator", ".", TRUE); // decimalSeparator
$DealersAndGroups->Dealers27_Chart->SetChartParam("thousandSeparator", ",", TRUE); // thousandSeparator
$DealersAndGroups->Dealers27_Chart->SetChartParam("decimalPrecision", "2", TRUE); // decimalPrecision
$DealersAndGroups->Dealers27_Chart->SetChartParam("divLineDecimalPrecision", "2", TRUE); // divLineDecimalPrecision
$DealersAndGroups->Dealers27_Chart->SetChartParam("limitsDecimalPrecision", "2", TRUE); // limitsDecimalPrecision
$DealersAndGroups->Dealers27_Chart->SetChartParam("zeroPlaneShowBorder", "1", TRUE); // zeroPlaneShowBorder
$DealersAndGroups->Dealers27_Chart->SetChartParam("showDivLineValue", "1", TRUE); // showDivLineValue
$DealersAndGroups->Dealers27_Chart->SetChartParam("showAlternateHGridColor", "0", TRUE); // showAlternateHGridColor
$DealersAndGroups->Dealers27_Chart->SetChartParam("showAlternateVGridColor", "0", TRUE); // showAlternateVGridColor
$DealersAndGroups->Dealers27_Chart->SetChartParam("hoverCapSepChar", ":", TRUE); // hoverCapSepChar

// Define trend lines
?>
<?php
$SqlSelect = $DealersAndGroups->SqlSelect();
$SqlChartSelect = $DealersAndGroups->Dealers27_Chart->SqlSelect;
if (EWRPT_IS_MSSQL) // skip SqlOrderBy for MSSQL
	$sSqlChartBase = "(" . ewrpt_BuildReportSql($SqlSelect, $DealersAndGroups->SqlWhere(), $DealersAndGroups->SqlGroupBy(), $DealersAndGroups->SqlHaving(), "", $DealersAndGroups_summary->Filter, "") . ") EW_TMP_TABLE";
else
	$sSqlChartBase = "(" . ewrpt_BuildReportSql($SqlSelect, $DealersAndGroups->SqlWhere(), $DealersAndGroups->SqlGroupBy(), $DealersAndGroups->SqlHaving(), $DealersAndGroups->SqlOrderBy(), $DealersAndGroups_summary->Filter, "") . ") EW_TMP_TABLE";

// Load chart data from sql directly
$sSql = $SqlChartSelect . $sSqlChartBase;
$sSql = ewrpt_BuildReportSql($sSql, "", $DealersAndGroups->Dealers27_Chart->SqlGroupBy, "", $DealersAndGroups->Dealers27_Chart->SqlOrderBy, "", "");
if (EWRPT_DEBUG_ENABLED) echo "(Chart SQL): " . $sSql . "<br>";
ewrpt_LoadChartData($sSql, $DealersAndGroups->Dealers27_Chart);
ewrpt_SortChartData($DealersAndGroups->Dealers27_Chart->Data, 0, "");

// Call Chart_Rendering event
$DealersAndGroups->Chart_Rendering($DealersAndGroups->Dealers27_Chart);
$chartxml = $DealersAndGroups->Dealers27_Chart->ChartXml();

// Call Chart_Rendered event
$DealersAndGroups->Chart_Rendered($DealersAndGroups->Dealers27_Chart, $chartxml);
echo $DealersAndGroups->Dealers27_Chart->ShowChartFCF($chartxml);
?>
<a href="#top"><?php echo $ReportLanguage->Phrase("Top") ?></a>
<br /><br />
	</div><br /></td></tr>
<!-- Bottom Container (End) -->
</table>
<!-- Table Container (End) -->
<?php } ?>
<?php $DealersAndGroups_summary->ShowPageFooter(); ?>
<?php if (EWRPT_DEBUG_ENABLED) echo ewrpt_DebugMsg(); ?>
<?php

// Close recordsets
if ($rsgrp) $rsgrp->Close();
if ($rs) $rs->Close();
?>
<?php if ($DealersAndGroups->Export == "") { ?>
<script language="JavaScript" type="text/javascript">
<!--

// Write your table-specific startup script here
// document.write("page loaded");
//-->

</script>
<?php } ?>
<?php include_once "phprptinc/footer.php"; ?>
<?php
$DealersAndGroups_summary->Page_Terminate();
?>
<?php

//
// Page class
//
class crDealersAndGroups_summary {

	// Page ID
	var $PageID = 'summary';

	// Table name
	var $TableName = 'DealersAndGroups';

	// Page object name
	var $PageObjName = 'DealersAndGroups_summary';

	// Page name
	function PageName() {
		return ewrpt_CurrentPage();
	}

	// Page URL
	function PageUrl() {
		$PageUrl = ewrpt_CurrentPage() . "?";
		global $DealersAndGroups;
		if ($DealersAndGroups->UseTokenInUrl) $PageUrl .= "t=" . $DealersAndGroups->TableVar . "&"; // Add page token
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
		global $DealersAndGroups;
		if ($DealersAndGroups->UseTokenInUrl) {
			if (ewrpt_IsHttpPost())
				return ($DealersAndGroups->TableVar == @$_POST("t"));
			if (@$_GET["t"] <> "")
				return ($DealersAndGroups->TableVar == @$_GET["t"]);
		} else {
			return TRUE;
		}
	}

	//
	// Page class constructor
	//
	function crDealersAndGroups_summary() {
		global $conn, $ReportLanguage;

		// Language object
		$ReportLanguage = new crLanguage();

		// Table object (DealersAndGroups)
		$GLOBALS["DealersAndGroups"] = new crDealersAndGroups();
		$GLOBALS["Table"] =& $GLOBALS["DealersAndGroups"];

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
			define("EWRPT_TABLE_NAME", 'DealersAndGroups', TRUE);

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
		global $DealersAndGroups;

		// Security
		$Security = new crAdvancedSecurity();
		if (!$Security->IsLoggedIn()) $Security->AutoLogin(); // Auto login
		if (!$Security->IsLoggedIn()) {
			$Security->SaveLastUrl();
			$this->Page_Terminate("rlogin.php");
		}

		// Get export parameters
		if (@$_GET["export"] <> "") {
			$DealersAndGroups->Export = $_GET["export"];
		}
		$gsExport = $DealersAndGroups->Export; // Get export parameter, used in header
		$gsExportFile = $DealersAndGroups->TableVar; // Get export file, used in header
		if ($DealersAndGroups->Export == "excel") {
			header('Content-Type: application/vnd.ms-excel;charset=utf-8');
			header('Content-Disposition: attachment; filename=' . $gsExportFile .'.xls');
		}
		if ($DealersAndGroups->Export == "word") {
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
		global $ReportLanguage, $DealersAndGroups;

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
		$item->Body = "<a name=\"emf_DealersAndGroups\" id=\"emf_DealersAndGroups\" href=\"javascript:void(0);\" onclick=\"ewrpt_EmailDialogShow({lnk:'emf_DealersAndGroups',hdr:ewLanguage.Phrase('ExportToEmail')});\">" . $ReportLanguage->Phrase("ExportToEmail") . "</a>";
		$item->Visible = FALSE;

		// Reset filter
		$item =& $this->ExportOptions->Add("resetfilter");
		$item->Body = "<a href=\"" . ewrpt_CurrentPage() . "?cmd=reset\">" . $ReportLanguage->Phrase("ResetAllFilter") . "</a>";
		$item->Visible = TRUE;
		$this->SetupExportOptionsExt();

		// Hide options for export
		if ($DealersAndGroups->Export <> "")
			$this->ExportOptions->HideAllOptions();

		// Set up table class
		if ($DealersAndGroups->Export == "word" || $DealersAndGroups->Export == "excel" || $DealersAndGroups->Export == "pdf")
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
		global $DealersAndGroups;

		// Page Unload event
		$this->Page_Unload();

		// Global Page Unloaded event (in userfn*.php)
		Page_Unloaded();

		// Export to Email (use ob_file_contents for PHP)
		if ($DealersAndGroups->Export == "email") {
			$sContent = ob_get_contents();
			$this->ExportEmail($sContent);
			ob_end_clean();

			 // Close connection
			$conn->Close();
			header("Location: " . ewrpt_CurrentPage());
			exit();
		}

		// Export to PDF (use ob_file_contents for PHP)
		if ($DealersAndGroups->Export == "pdf") {
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
		global $DealersAndGroups;
		global $rs;
		global $rsgrp;
		global $gsFormError;

		// Aggregate variables
		// 1st dimension = no of groups (level 0 used for grand total)
		// 2nd dimension = no of fields

		$nDtls = 3;
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
		$this->Col = array(FALSE, FALSE, FALSE);

		// Set up groups per page dynamically
		$this->SetUpDisplayGrps();

		// Load default filter values
		$this->LoadDefaultFilters();

		// Load custom filters
		$DealersAndGroups->Filters_Load();

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
		$sSql = ewrpt_BuildReportSql($DealersAndGroups->SqlSelect(), $DealersAndGroups->SqlWhere(), $DealersAndGroups->SqlGroupBy(), $DealersAndGroups->SqlHaving(), $DealersAndGroups->SqlOrderBy(), $this->Filter, $this->Sort);
		$this->TotalGrps = $this->GetCnt($sSql);
		if ($this->DisplayGrps <= 0) // Display all groups
			$this->DisplayGrps = $this->TotalGrps;
		$this->StartGrp = 1;

		// Show header
		$this->ShowFirstHeader = ($this->TotalGrps > 0);

		//$this->ShowFirstHeader = TRUE; // Uncomment to always show header
		// Set up start position if not export all

		if ($DealersAndGroups->ExportAll && $DealersAndGroups->Export <> "")
		    $this->DisplayGrps = $this->TotalGrps;
		else
			$this->SetUpStartGroup(); 

		// Hide all options if export
		if ($DealersAndGroups->Export <> "") {
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
		global $DealersAndGroups;
		if (!$rs)
			return;
		if ($opt == 1) { // Get first row

	//		$rs->MoveFirst(); // NOTE: no need to move position
		} else { // Get next row
			$rs->MoveNext();
		}
		if (!$rs->EOF) {
			$DealersAndGroups->catalog->setDbValue($rs->fields('catalog'));
			$DealersAndGroups->DateModified->setDbValue($rs->fields('DateModified'));
			$DealersAndGroups->Deals_made->setDbValue($rs->fields('Deals made'));
			$DealersAndGroups->Status->setDbValue($rs->fields('Status'));
			$this->Val[1] = $DealersAndGroups->catalog->CurrentValue;
			$this->Val[2] = $DealersAndGroups->Deals_made->CurrentValue;
		} else {
			$DealersAndGroups->catalog->setDbValue("");
			$DealersAndGroups->DateModified->setDbValue("");
			$DealersAndGroups->Deals_made->setDbValue("");
			$DealersAndGroups->Status->setDbValue("");
		}
	}

	//  Set up starting group
	function SetUpStartGroup() {
		global $DealersAndGroups;

		// Exit if no groups
		if ($this->DisplayGrps == 0)
			return;

		// Check for a 'start' parameter
		if (@$_GET[EWRPT_TABLE_START_GROUP] != "") {
			$this->StartGrp = $_GET[EWRPT_TABLE_START_GROUP];
			$DealersAndGroups->setStartGroup($this->StartGrp);
		} elseif (@$_GET["pageno"] != "") {
			$nPageNo = $_GET["pageno"];
			if (is_numeric($nPageNo)) {
				$this->StartGrp = ($nPageNo-1)*$this->DisplayGrps+1;
				if ($this->StartGrp <= 0) {
					$this->StartGrp = 1;
				} elseif ($this->StartGrp >= intval(($this->TotalGrps-1)/$this->DisplayGrps)*$this->DisplayGrps+1) {
					$this->StartGrp = intval(($this->TotalGrps-1)/$this->DisplayGrps)*$this->DisplayGrps+1;
				}
				$DealersAndGroups->setStartGroup($this->StartGrp);
			} else {
				$this->StartGrp = $DealersAndGroups->getStartGroup();
			}
		} else {
			$this->StartGrp = $DealersAndGroups->getStartGroup();
		}

		// Check if correct start group counter
		if (!is_numeric($this->StartGrp) || $this->StartGrp == "") { // Avoid invalid start group counter
			$this->StartGrp = 1; // Reset start group counter
			$DealersAndGroups->setStartGroup($this->StartGrp);
		} elseif (intval($this->StartGrp) > intval($this->TotalGrps)) { // Avoid starting group > total groups
			$this->StartGrp = intval(($this->TotalGrps-1)/$this->DisplayGrps) * $this->DisplayGrps + 1; // Point to last page first group
			$DealersAndGroups->setStartGroup($this->StartGrp);
		} elseif (($this->StartGrp-1) % $this->DisplayGrps <> 0) {
			$this->StartGrp = intval(($this->StartGrp-1)/$this->DisplayGrps) * $this->DisplayGrps + 1; // Point to page boundary
			$DealersAndGroups->setStartGroup($this->StartGrp);
		}
	}

	// Set up popup
	function SetupPopup() {
		global $conn, $ReportLanguage;
		global $DealersAndGroups;

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
		global $DealersAndGroups;
		$this->StartGrp = 1;
		$DealersAndGroups->setStartGroup($this->StartGrp);
	}

	// Set up number of groups displayed per page
	function SetUpDisplayGrps() {
		global $DealersAndGroups;
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
			$DealersAndGroups->setGroupPerPage($this->DisplayGrps); // Save to session

			// Reset start position (reset command)
			$this->StartGrp = 1;
			$DealersAndGroups->setStartGroup($this->StartGrp);
		} else {
			if ($DealersAndGroups->getGroupPerPage() <> "") {
				$this->DisplayGrps = $DealersAndGroups->getGroupPerPage(); // Restore from session
			} else {
				$this->DisplayGrps = 50; // Load default
			}
		}
	}

	function RenderRow() {
		global $conn, $rs, $Security;
		global $DealersAndGroups;
		if ($DealersAndGroups->RowTotalType == EWRPT_ROWTOTAL_GRAND) { // Grand total

			// Get total count from sql directly
			$sSql = ewrpt_BuildReportSql($DealersAndGroups->SqlSelectCount(), $DealersAndGroups->SqlWhere(), $DealersAndGroups->SqlGroupBy(), $DealersAndGroups->SqlHaving(), "", $this->Filter, "");
			$rstot = $conn->Execute($sSql);
			if ($rstot) {
				$this->TotCount = ($rstot->RecordCount()>1) ? $rstot->RecordCount() : $rstot->fields[0];
				$rstot->Close();
			} else {
				$this->TotCount = 0;
			}
		}

		// Call Row_Rendering event
		$DealersAndGroups->Row_Rendering();

		//
		// Render view codes
		//

		if ($DealersAndGroups->RowType == EWRPT_ROWTYPE_TOTAL) { // Summary row
		} else {

			// catalog
			$DealersAndGroups->catalog->ViewValue = $DealersAndGroups->catalog->CurrentValue;
			$DealersAndGroups->catalog->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";

			// Deals made
			$DealersAndGroups->Deals_made->ViewValue = $DealersAndGroups->Deals_made->CurrentValue;
			$DealersAndGroups->Deals_made->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";

			// catalog
			$DealersAndGroups->catalog->HrefValue = "";

			// Deals made
			$DealersAndGroups->Deals_made->HrefValue = "";
		}

		// Call Cell_Rendered event
		if ($DealersAndGroups->RowType == EWRPT_ROWTYPE_TOTAL) { // Summary row
		} else {

			// catalog
			$CurrentValue = $DealersAndGroups->catalog->CurrentValue;
			$ViewValue =& $DealersAndGroups->catalog->ViewValue;
			$ViewAttrs =& $DealersAndGroups->catalog->ViewAttrs;
			$CellAttrs =& $DealersAndGroups->catalog->CellAttrs;
			$HrefValue =& $DealersAndGroups->catalog->HrefValue;
			$DealersAndGroups->Cell_Rendered($DealersAndGroups->catalog, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue);

			// Deals made
			$CurrentValue = $DealersAndGroups->Deals_made->CurrentValue;
			$ViewValue =& $DealersAndGroups->Deals_made->ViewValue;
			$ViewAttrs =& $DealersAndGroups->Deals_made->ViewAttrs;
			$CellAttrs =& $DealersAndGroups->Deals_made->CellAttrs;
			$HrefValue =& $DealersAndGroups->Deals_made->HrefValue;
			$DealersAndGroups->Cell_Rendered($DealersAndGroups->Deals_made, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue);
		}

		// Call Row_Rendered event
		$DealersAndGroups->Row_Rendered();
	}

	function SetupExportOptionsExt() {
		global $ReportLanguage, $DealersAndGroups;
		$item =& $this->ExportOptions->GetItem("pdf");
		$item->Visible = FALSE;
	}

	// Get extended filter values
	function GetExtendedFilterValues() {
		global $DealersAndGroups;

		// Field DateModified
		$sSelect = "SELECT DISTINCT trans.DateModified FROM " . $DealersAndGroups->SqlFrom();
		$sOrderBy = "trans.DateModified ASC";
		$wrkSql = ewrpt_BuildReportSql($sSelect, $DealersAndGroups->SqlWhere(), "", "", $sOrderBy, $this->UserIDFilter, "");
		$DealersAndGroups->DateModified->DropDownList = ewrpt_GetDistinctValues($DealersAndGroups->DateModified->DateFilter, $wrkSql);

		// Field Status
		$sSelect = "SELECT DISTINCT trans.Status FROM " . $DealersAndGroups->SqlFrom();
		$sOrderBy = "trans.Status ASC";
		$wrkSql = ewrpt_BuildReportSql($sSelect, $DealersAndGroups->SqlWhere(), "", "", $sOrderBy, $this->UserIDFilter, "");
		$DealersAndGroups->Status->DropDownList = ewrpt_GetDistinctValues("", $wrkSql);
	}

	// Return extended filter
	function GetExtendedFilter() {
		global $DealersAndGroups;
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
			// Field DateModified

			$this->SetSessionDropDownValue($DealersAndGroups->DateModified->DropDownValue, 'DateModified');

			// Field Status
			$this->SetSessionDropDownValue($DealersAndGroups->Status->DropDownValue, 'Status');
			$bSetupFilter = TRUE;
		} else {

			// Field DateModified
			if ($this->GetDropDownValue($DealersAndGroups->DateModified->DropDownValue, 'DateModified')) {
				$bSetupFilter = TRUE;
				$bRestoreSession = FALSE;
			} elseif ($DealersAndGroups->DateModified->DropDownValue <> EWRPT_INIT_VALUE && !isset($_SESSION['sv_DealersAndGroups->DateModified'])) {
				$bSetupFilter = TRUE;
			}

			// Field Status
			if ($this->GetDropDownValue($DealersAndGroups->Status->DropDownValue, 'Status')) {
				$bSetupFilter = TRUE;
				$bRestoreSession = FALSE;
			} elseif ($DealersAndGroups->Status->DropDownValue <> EWRPT_INIT_VALUE && !isset($_SESSION['sv_DealersAndGroups->Status'])) {
				$bSetupFilter = TRUE;
			}
			if (!$this->ValidateForm()) {
				$this->setMessage($gsFormError);
				return $sFilter;
			}
		}

		// Restore session
		if ($bRestoreSession) {

			// Field DateModified
			$this->GetSessionDropDownValue($DealersAndGroups->DateModified);

			// Field Status
			$this->GetSessionDropDownValue($DealersAndGroups->Status);
		}

		// Call page filter validated event
		$DealersAndGroups->Page_FilterValidated();

		// Build SQL
		// Field DateModified

		ewrpt_BuildDropDownFilter($DealersAndGroups->DateModified, $sFilter, $DealersAndGroups->DateModified->DateFilter);

		// Field Status
		ewrpt_BuildDropDownFilter($DealersAndGroups->Status, $sFilter, "");

		// Save parms to session
		// Field DateModified

		$this->SetSessionDropDownValue($DealersAndGroups->DateModified->DropDownValue, 'DateModified');

		// Field Status
		$this->SetSessionDropDownValue($DealersAndGroups->Status->DropDownValue, 'Status');

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
		$this->GetSessionValue($fld->DropDownValue, 'sv_DealersAndGroups_' . $parm);
	}

	// Get filter values from session
	function GetSessionFilterValues(&$fld) {
		$parm = substr($fld->FldVar, 2);
		$this->GetSessionValue($fld->SearchValue, 'sv1_DealersAndGroups_' . $parm);
		$this->GetSessionValue($fld->SearchOperator, 'so1_DealersAndGroups_' . $parm);
		$this->GetSessionValue($fld->SearchCondition, 'sc_DealersAndGroups_' . $parm);
		$this->GetSessionValue($fld->SearchValue2, 'sv2_DealersAndGroups_' . $parm);
		$this->GetSessionValue($fld->SearchOperator2, 'so2_DealersAndGroups_' . $parm);
	}

	// Get value from session
	function GetSessionValue(&$sv, $sn) {
		if (isset($_SESSION[$sn]))
			$sv = $_SESSION[$sn];
	}

	// Set dropdown value to session
	function SetSessionDropDownValue($sv, $parm) {
		$_SESSION['sv_DealersAndGroups_' . $parm] = $sv;
	}

	// Set filter values to session
	function SetSessionFilterValues($sv1, $so1, $sc, $sv2, $so2, $parm) {
		$_SESSION['sv1_DealersAndGroups_' . $parm] = $sv1;
		$_SESSION['so1_DealersAndGroups_' . $parm] = $so1;
		$_SESSION['sc_DealersAndGroups_' . $parm] = $sc;
		$_SESSION['sv2_DealersAndGroups_' . $parm] = $sv2;
		$_SESSION['so2_DealersAndGroups_' . $parm] = $so2;
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
		global $ReportLanguage, $gsFormError, $DealersAndGroups;

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
		$_SESSION["sel_DealersAndGroups_$parm"] = "";
		$_SESSION["rf_DealersAndGroups_$parm"] = "";
		$_SESSION["rt_DealersAndGroups_$parm"] = "";
	}

	// Load selection from session
	function LoadSelectionFromSession($parm) {
		global $DealersAndGroups;
		$fld =& $DealersAndGroups->fields($parm);
		$fld->SelectionList = @$_SESSION["sel_DealersAndGroups_$parm"];
		$fld->RangeFrom = @$_SESSION["rf_DealersAndGroups_$parm"];
		$fld->RangeTo = @$_SESSION["rt_DealersAndGroups_$parm"];
	}

	// Load default value for filters
	function LoadDefaultFilters() {
		global $DealersAndGroups;

		/**
		* Set up default values for non Text filters
		*/

		// Field DateModified
		$DealersAndGroups->DateModified->DefaultDropDownValue = EWRPT_INIT_VALUE;
		$DealersAndGroups->DateModified->DropDownValue = $DealersAndGroups->DateModified->DefaultDropDownValue;

		// Field Status
		$DealersAndGroups->Status->DefaultDropDownValue = EWRPT_INIT_VALUE;
		$DealersAndGroups->Status->DropDownValue = $DealersAndGroups->Status->DefaultDropDownValue;

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
		global $DealersAndGroups;

		// Check DateModified extended filter
		if ($this->NonTextFilterApplied($DealersAndGroups->DateModified))
			return TRUE;

		// Check Status extended filter
		if ($this->NonTextFilterApplied($DealersAndGroups->Status))
			return TRUE;
		return FALSE;
	}

	// Show list of filters
	function ShowFilterList() {
		global $DealersAndGroups;
		global $ReportLanguage;

		// Initialize
		$sFilterList = "";

		// Field DateModified
		$sExtWrk = "";
		$sWrk = "";
		ewrpt_BuildDropDownFilter($DealersAndGroups->DateModified, $sExtWrk, $DealersAndGroups->DateModified->DateFilter);
		if ($sExtWrk <> "" || $sWrk <> "")
			$sFilterList .= $DealersAndGroups->DateModified->FldCaption() . "<br />";
		if ($sExtWrk <> "")
			$sFilterList .= "&nbsp;&nbsp;$sExtWrk<br />";
		if ($sWrk <> "")
			$sFilterList .= "&nbsp;&nbsp;$sWrk<br />";

		// Field Status
		$sExtWrk = "";
		$sWrk = "";
		ewrpt_BuildDropDownFilter($DealersAndGroups->Status, $sExtWrk, "");
		if ($sExtWrk <> "" || $sWrk <> "")
			$sFilterList .= $DealersAndGroups->Status->FldCaption() . "<br />";
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
		global $DealersAndGroups;
		$sWrk = "";
		return $sWrk;
	}

	//-------------------------------------------------------------------------------
	// Function GetSort
	// - Return Sort parameters based on Sort Links clicked
	// - Variables setup: Session[EWRPT_TABLE_SESSION_ORDER_BY], Session["sort_Table_Field"]
	function GetSort() {
		global $DealersAndGroups;

		// Check for a resetsort command
		if (strlen(@$_GET["cmd"]) > 0) {
			$sCmd = @$_GET["cmd"];
			if ($sCmd == "resetsort") {
				$DealersAndGroups->setOrderBy("");
				$DealersAndGroups->setStartGroup(1);
				$DealersAndGroups->catalog->setSort("");
				$DealersAndGroups->Deals_made->setSort("");
			}

		// Check for an Order parameter
		} elseif (@$_GET["order"] <> "") {
			$DealersAndGroups->CurrentOrder = ewrpt_StripSlashes(@$_GET["order"]);
			$DealersAndGroups->CurrentOrderType = @$_GET["ordertype"];
			$sSortSql = $DealersAndGroups->SortSql();
			$DealersAndGroups->setOrderBy($sSortSql);
			$DealersAndGroups->setStartGroup(1);
		}
		return $DealersAndGroups->getOrderBy();
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
