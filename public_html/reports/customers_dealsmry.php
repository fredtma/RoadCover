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
$customers_deal = NULL;

//
// Table class for customers_deal
//
class crcustomers_deal {
	var $TableVar = 'customers_deal';
	var $TableName = 'customers_deal';
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
	var $salesman;
	var $customer;
	var $idno;
	var $status;
	var $date_start;
	var $NotTakenUpReason_cd;
	var $product_name;
	var $total_premium;
	var $commission;
	var $rep2Etotal_premium_2D_rep2Ecommission;
	var $Description;
	var $Format28car22EAmount2C_229;
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
	function crcustomers_deal() {
		global $ReportLanguage;

		// deal_number
		$this->deal_number = new crField('customers_deal', 'customers_deal', 'x_deal_number', 'deal_number', 'rep.deal_number', 3, EWRPT_DATATYPE_NUMBER, -1);
		$this->deal_number->FldDefaultErrMsg = $ReportLanguage->Phrase("IncorrectInteger");
		$this->fields['deal_number'] =& $this->deal_number;
		$this->deal_number->DateFilter = "";
		$this->deal_number->SqlSelect = "";
		$this->deal_number->SqlOrderBy = "";

		// dealer
		$this->dealer = new crField('customers_deal', 'customers_deal', 'x_dealer', 'dealer', 'rep.dealer', 200, EWRPT_DATATYPE_STRING, -1);
		$this->fields['dealer'] =& $this->dealer;
		$this->dealer->DateFilter = "";
		$this->dealer->SqlSelect = "";
		$this->dealer->SqlOrderBy = "";

		// salesman
		$this->salesman = new crField('customers_deal', 'customers_deal', 'x_salesman', 'salesman', 'rep.salesman', 200, EWRPT_DATATYPE_STRING, -1);
		$this->fields['salesman'] =& $this->salesman;
		$this->salesman->DateFilter = "";
		$this->salesman->SqlSelect = "";
		$this->salesman->SqlOrderBy = "";

		// customer
		$this->customer = new crField('customers_deal', 'customers_deal', 'x_customer', 'customer', 'rep.customer', 200, EWRPT_DATATYPE_STRING, -1);
		$this->fields['customer'] =& $this->customer;
		$this->customer->DateFilter = "";
		$this->customer->SqlSelect = "";
		$this->customer->SqlOrderBy = "";

		// idno
		$this->idno = new crField('customers_deal', 'customers_deal', 'x_idno', 'idno', 'rep.idno', 200, EWRPT_DATATYPE_STRING, -1);
		$this->fields['idno'] =& $this->idno;
		$this->idno->DateFilter = "";
		$this->idno->SqlSelect = "";
		$this->idno->SqlOrderBy = "";

		// status
		$this->status = new crField('customers_deal', 'customers_deal', 'x_status', 'status', 'rep.status', 200, EWRPT_DATATYPE_STRING, -1);
		$this->fields['status'] =& $this->status;
		$this->status->DateFilter = "";
		$this->status->SqlSelect = "";
		$this->status->SqlOrderBy = "";

		// date_start
		$this->date_start = new crField('customers_deal', 'customers_deal', 'x_date_start', 'date_start', 'rep.date_start', 135, EWRPT_DATATYPE_DATE, 7);
		$this->date_start->FldDefaultErrMsg = str_replace("%s", "-", $ReportLanguage->Phrase("IncorrectDateYMD"));
		$this->fields['date_start'] =& $this->date_start;
		$this->date_start->DateFilter = "Month";
		$this->date_start->SqlSelect = "";
		$this->date_start->SqlOrderBy = "";
		ewrpt_RegisterFilter($this->date_start, "@@LastMonth", $ReportLanguage->Phrase("LastMonth"), "ewrpt_IsLastMonth");
		ewrpt_RegisterFilter($this->date_start, "@@ThisMonth", $ReportLanguage->Phrase("ThisMonth"), "ewrpt_IsThisMonth");
		ewrpt_RegisterFilter($this->date_start, "@@NextMonth", $ReportLanguage->Phrase("NextMonth"), "ewrpt_IsNextMonth");

		// NotTakenUpReason_cd
		$this->NotTakenUpReason_cd = new crField('customers_deal', 'customers_deal', 'x_NotTakenUpReason_cd', 'NotTakenUpReason_cd', 'trans.NotTakenUpReason_cd', 200, EWRPT_DATATYPE_STRING, -1);
		$this->fields['NotTakenUpReason_cd'] =& $this->NotTakenUpReason_cd;
		$this->NotTakenUpReason_cd->DateFilter = "";
		$this->NotTakenUpReason_cd->SqlSelect = "";
		$this->NotTakenUpReason_cd->SqlOrderBy = "";

		// product_name
		$this->product_name = new crField('customers_deal', 'customers_deal', 'x_product_name', 'product_name', 'rep.product_name', 200, EWRPT_DATATYPE_STRING, -1);
		$this->fields['product_name'] =& $this->product_name;
		$this->product_name->DateFilter = "";
		$this->product_name->SqlSelect = "";
		$this->product_name->SqlOrderBy = "";

		// total_premium
		$this->total_premium = new crField('customers_deal', 'customers_deal', 'x_total_premium', 'total_premium', 'rep.total_premium', 5, EWRPT_DATATYPE_NUMBER, -1);
		$this->total_premium->FldDefaultErrMsg = $ReportLanguage->Phrase("IncorrectFloat");
		$this->fields['total_premium'] =& $this->total_premium;
		$this->total_premium->DateFilter = "";
		$this->total_premium->SqlSelect = "";
		$this->total_premium->SqlOrderBy = "";

		// commission
		$this->commission = new crField('customers_deal', 'customers_deal', 'x_commission', 'commission', 'rep.commission', 5, EWRPT_DATATYPE_NUMBER, -1);
		$this->commission->FldDefaultErrMsg = $ReportLanguage->Phrase("IncorrectFloat");
		$this->fields['commission'] =& $this->commission;
		$this->commission->DateFilter = "";
		$this->commission->SqlSelect = "";
		$this->commission->SqlOrderBy = "";

		// rep.total_premium - rep.commission
		$this->rep2Etotal_premium_2D_rep2Ecommission = new crField('customers_deal', 'customers_deal', 'x_rep2Etotal_premium_2D_rep2Ecommission', 'rep.total_premium - rep.commission', '`rep.total_premium - rep.commission`', 5, EWRPT_DATATYPE_NUMBER, -1);
		$this->rep2Etotal_premium_2D_rep2Ecommission->FldDefaultErrMsg = $ReportLanguage->Phrase("IncorrectFloat");
		$this->fields['rep2Etotal_premium_2D_rep2Ecommission'] =& $this->rep2Etotal_premium_2D_rep2Ecommission;
		$this->rep2Etotal_premium_2D_rep2Ecommission->DateFilter = "";
		$this->rep2Etotal_premium_2D_rep2Ecommission->SqlSelect = "";
		$this->rep2Etotal_premium_2D_rep2Ecommission->SqlOrderBy = "";

		// Description
		$this->Description = new crField('customers_deal', 'customers_deal', 'x_Description', 'Description', 'car.Description', 200, EWRPT_DATATYPE_STRING, -1);
		$this->fields['Description'] =& $this->Description;
		$this->Description->DateFilter = "";
		$this->Description->SqlSelect = "";
		$this->Description->SqlOrderBy = "";

		// Format(car2.Amount, 2)
		$this->Format28car22EAmount2C_229 = new crField('customers_deal', 'customers_deal', 'x_Format28car22EAmount2C_229', 'Format(car2.Amount, 2)', '`Format(car2.Amount, 2)`', 200, EWRPT_DATATYPE_STRING, -1);
		$this->fields['Format28car22EAmount2C_229'] =& $this->Format28car22EAmount2C_229;
		$this->Format28car22EAmount2C_229->DateFilter = "";
		$this->Format28car22EAmount2C_229->SqlSelect = "";
		$this->Format28car22EAmount2C_229->SqlOrderBy = "";
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
		return "report_invoice rep Inner Join road_Transactions trans On trans.Id = rep.trans_id Left Join road_TxItems car On car.holder = rep.customer_id Left Join road_TxVehicleDetail car2 On car2.Type = car.Id";
	}

	function SqlSelect() { // Select
		return "SELECT rep.deal_number, rep.status, trans.NotTakenUpReason_cd, rep.date_start, rep.dealer, rep.salesman, rep.customer, rep.idno, rep.product_name, rep.total_premium, rep.commission, rep.total_premium - rep.commission, car.Description, Format(car2.Amount, 2) FROM " . $this->SqlFrom();
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
$customers_deal_summary = new crcustomers_deal_summary();
$Page =& $customers_deal_summary;

// Page init
$customers_deal_summary->Page_Init();

// Page main
$customers_deal_summary->Page_Main();
?>
<?php include_once "phprptinc/header.php"; ?>
<?php if ($customers_deal->Export == "" || $customers_deal->Export == "print" || $customers_deal->Export == "email") { ?>
<script type="text/javascript">

// Create page object
var customers_deal_summary = new ewrpt_Page("customers_deal_summary");

// page properties
customers_deal_summary.PageID = "summary"; // page ID
customers_deal_summary.FormID = "fcustomers_dealsummaryfilter"; // form ID
var EWRPT_PAGE_ID = customers_deal_summary.PageID;

// extend page with Chart_Rendering function
customers_deal_summary.Chart_Rendering =  
 function(chart, chartid) { // DO NOT CHANGE THIS LINE!

 	//alert(chartid);
 }

// extend page with Chart_Rendered function
customers_deal_summary.Chart_Rendered =  
 function(chart, chartid) { // DO NOT CHANGE THIS LINE!

 	//alert(chartid);
 }
</script>
<?php } ?>
<?php if ($customers_deal->Export == "") { ?>
<script type="text/javascript">

// extend page with ValidateForm function
customers_deal_summary.ValidateForm = function(fobj) {
	if (!this.ValidateRequired)
		return true; // ignore validation
	var elm = fobj.sv1_deal_number;
	if (elm && !ewrpt_CheckInteger(elm.value)) {
		if (!ewrpt_OnError(elm, "<?php echo ewrpt_JsEncode2($customers_deal->deal_number->FldErrMsg()) ?>"))
			return false;
	}

	// Call Form Custom Validate event
	if (!this.Form_CustomValidate(fobj)) return false;
	return true;
}

// extend page with Form_CustomValidate function
customers_deal_summary.Form_CustomValidate =  
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }
<?php if (EWRPT_CLIENT_VALIDATE) { ?>
customers_deal_summary.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
customers_deal_summary.ValidateRequired = false; // no JavaScript validation
<?php } ?>
</script>
<script language="JavaScript" type="text/javascript">
<!--

// Write your client script here, no need to add script tags.
//-->

</script>
<?php } ?>
<?php if ($customers_deal->Export == "" || $customers_deal->Export == "print" || $customers_deal->Export == "email") { ?>
<script src="<?php echo EWRPT_FUSIONCHARTS_FREE_JSCLASS_FILE; ?>" type="text/javascript"></script>
<?php } ?>
<?php if ($customers_deal->Export == "") { ?>
<div id="ewrpt_PopupFilter"><div class="bd"></div></div>
<script src="phprptjs/ewrptpop.js" type="text/javascript"></script>
<script type="text/javascript">

// popup fields
</script>
<?php } ?>
<?php if ($customers_deal->Export == "" || $customers_deal->Export == "print" || $customers_deal->Export == "email") { ?>
<!-- Table Container (Begin) -->
<table id="ewContainer" cellspacing="0" cellpadding="0" border="0">
<!-- Top Container (Begin) -->
<tr><td colspan="3"><div id="ewTop" class="phpreportmaker">
<!-- top slot -->
<a name="top"></a>
<?php } ?>
<p class="phpreportmaker ewTitle"><?php echo $customers_deal->TableCaption() ?>
&nbsp;&nbsp;<?php $customers_deal_summary->ExportOptions->Render("body"); ?></p>
<?php $customers_deal_summary->ShowPageHeader(); ?>
<?php $customers_deal_summary->ShowMessage(); ?>
<br><br>
<?php if ($customers_deal->Export == "" || $customers_deal->Export == "print" || $customers_deal->Export == "email") { ?>
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
<?php if ($customers_deal->Export == "") { ?>
<?php
if ($customers_deal->FilterPanelOption == 2 || ($customers_deal->FilterPanelOption == 3 && $customers_deal_summary->FilterApplied) || $customers_deal_summary->Filter == "0=101") {
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
<form name="fcustomers_dealsummaryfilter" id="fcustomers_dealsummaryfilter" action="<?php echo ewrpt_CurrentPage() ?>" class="ewForm" onsubmit="return customers_deal_summary.ValidateForm(this);">
<table class="ewRptExtFilter">
	<tr id="r_deal_number">
		<td><span class="phpreportmaker"><?php echo $customers_deal->deal_number->FldCaption() ?></span></td>
		<td><span class="ewRptSearchOpr"><?php echo $ReportLanguage->Phrase("="); ?><input type="hidden" name="so1_deal_number" id="so1_deal_number" value="="></span></td>
		<td>
			<table cellspacing="0" class="ewItemTable"><tr>
				<td><span class="phpreportmaker">
<input type="text" name="sv1_deal_number" id="sv1_deal_number" size="30" value="<?php echo ewrpt_HtmlEncode($customers_deal->deal_number->SearchValue) ?>"<?php echo ($customers_deal_summary->ClearExtFilter == 'customers_deal_deal_number') ? " class=\"ewInputCleared\"" : "" ?>>
</span></td>
			</tr></table>			
		</td>
	</tr>
	<tr id="r_dealer">
		<td><span class="phpreportmaker"><?php echo $customers_deal->dealer->FldCaption() ?></span></td>
		<td></td>
		<td colspan="4"><span class="ewRptSearchOpr">
		<select name="sv_dealer" id="sv_dealer"<?php echo ($customers_deal_summary->ClearExtFilter == 'customers_deal_dealer') ? " class=\"ewInputCleared\"" : "" ?>>
		<option value="<?php echo EWRPT_ALL_VALUE; ?>"<?php if (ewrpt_MatchedFilterValue($customers_deal->dealer->DropDownValue, EWRPT_ALL_VALUE)) echo " selected=\"selected\""; ?>><?php echo $ReportLanguage->Phrase("PleaseSelect"); ?></option>
<?php

// Popup filter
$cntf = is_array($customers_deal->dealer->AdvancedFilters) ? count($customers_deal->dealer->AdvancedFilters) : 0;
$cntd = is_array($customers_deal->dealer->DropDownList) ? count($customers_deal->dealer->DropDownList) : 0;
$totcnt = $cntf + $cntd;
$wrkcnt = 0;
	if ($cntf > 0) {
		foreach ($customers_deal->dealer->AdvancedFilters as $filter) {
			if ($filter->Enabled) {
?>
		<option value="<?php echo $filter->ID ?>"<?php if (ewrpt_MatchedFilterValue($customers_deal->dealer->DropDownValue, $filter->ID)) echo " selected=\"selected\"" ?>><?php echo $filter->Name ?></option>
<?php
				$wrkcnt += 1;
			}
		}
	}
	for ($i = 0; $i < $cntd; $i++) {
?>
		<option value="<?php echo $customers_deal->dealer->DropDownList[$i] ?>"<?php if (ewrpt_MatchedFilterValue($customers_deal->dealer->DropDownValue, $customers_deal->dealer->DropDownList[$i])) echo " selected=\"selected\"" ?>><?php echo ewrpt_DropDownDisplayValue($customers_deal->dealer->DropDownList[$i], "", 0) ?></option>
<?php
		$wrkcnt += 1;
	}
?>
		</select>
		</span></td>
	</tr>
	<tr id="r_status">
		<td><span class="phpreportmaker"><?php echo $customers_deal->status->FldCaption() ?></span></td>
		<td></td>
		<td colspan="4"><span class="ewRptSearchOpr">
		<select name="sv_status" id="sv_status"<?php echo ($customers_deal_summary->ClearExtFilter == 'customers_deal_status') ? " class=\"ewInputCleared\"" : "" ?>>
		<option value="<?php echo EWRPT_ALL_VALUE; ?>"<?php if (ewrpt_MatchedFilterValue($customers_deal->status->DropDownValue, EWRPT_ALL_VALUE)) echo " selected=\"selected\""; ?>><?php echo $ReportLanguage->Phrase("PleaseSelect"); ?></option>
<?php

// Popup filter
$cntf = is_array($customers_deal->status->AdvancedFilters) ? count($customers_deal->status->AdvancedFilters) : 0;
$cntd = is_array($customers_deal->status->DropDownList) ? count($customers_deal->status->DropDownList) : 0;
$totcnt = $cntf + $cntd;
$wrkcnt = 0;
	if ($cntf > 0) {
		foreach ($customers_deal->status->AdvancedFilters as $filter) {
			if ($filter->Enabled) {
?>
		<option value="<?php echo $filter->ID ?>"<?php if (ewrpt_MatchedFilterValue($customers_deal->status->DropDownValue, $filter->ID)) echo " selected=\"selected\"" ?>><?php echo $filter->Name ?></option>
<?php
				$wrkcnt += 1;
			}
		}
	}
	for ($i = 0; $i < $cntd; $i++) {
?>
		<option value="<?php echo $customers_deal->status->DropDownList[$i] ?>"<?php if (ewrpt_MatchedFilterValue($customers_deal->status->DropDownValue, $customers_deal->status->DropDownList[$i])) echo " selected=\"selected\"" ?>><?php echo ewrpt_DropDownDisplayValue($customers_deal->status->DropDownList[$i], "", 0) ?></option>
<?php
		$wrkcnt += 1;
	}
?>
		</select>
		</span></td>
	</tr>
	<tr id="r_date_start">
		<td><span class="phpreportmaker"><?php echo $customers_deal->date_start->FldCaption() ?></span></td>
		<td></td>
		<td colspan="4"><span class="ewRptSearchOpr">
		<select name="sv_date_start" id="sv_date_start"<?php echo ($customers_deal_summary->ClearExtFilter == 'customers_deal_date_start') ? " class=\"ewInputCleared\"" : "" ?>>
		<option value="<?php echo EWRPT_ALL_VALUE; ?>"<?php if (ewrpt_MatchedFilterValue($customers_deal->date_start->DropDownValue, EWRPT_ALL_VALUE)) echo " selected=\"selected\""; ?>><?php echo $ReportLanguage->Phrase("PleaseSelect"); ?></option>
<?php

// Popup filter
$cntf = is_array($customers_deal->date_start->AdvancedFilters) ? count($customers_deal->date_start->AdvancedFilters) : 0;
$cntd = is_array($customers_deal->date_start->DropDownList) ? count($customers_deal->date_start->DropDownList) : 0;
$totcnt = $cntf + $cntd;
$wrkcnt = 0;
	if ($cntf > 0) {
		foreach ($customers_deal->date_start->AdvancedFilters as $filter) {
			if ($filter->Enabled) {
?>
		<option value="<?php echo $filter->ID ?>"<?php if (ewrpt_MatchedFilterValue($customers_deal->date_start->DropDownValue, $filter->ID)) echo " selected=\"selected\"" ?>><?php echo $filter->Name ?></option>
<?php
				$wrkcnt += 1;
			}
		}
	}
	for ($i = 0; $i < $cntd; $i++) {
?>
		<option value="<?php echo $customers_deal->date_start->DropDownList[$i] ?>"<?php if (ewrpt_MatchedFilterValue($customers_deal->date_start->DropDownValue, $customers_deal->date_start->DropDownList[$i])) echo " selected=\"selected\"" ?>><?php echo ewrpt_DropDownDisplayValue($customers_deal->date_start->DropDownList[$i], $customers_deal->date_start->DateFilter, 7) ?></option>
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
<?php if ($customers_deal->ShowCurrentFilter) { ?>
<div id="ewrptFilterList">
<?php $customers_deal_summary->ShowFilterList() ?>
</div>
<br>
<?php } ?>
<table class="ewGrid" cellspacing="0"><tr>
	<td class="ewGridContent">
<!-- Report Grid (Begin) -->
<div class="ewGridMiddlePanel">
<table class="<?php echo $customers_deal_summary->ReportTableClass ?>" cellspacing="0">
<?php

// Set the last group to display if not export all
if ($customers_deal->ExportAll && $customers_deal->Export <> "") {
	$customers_deal_summary->StopGrp = $customers_deal_summary->TotalGrps;
} else {
	$customers_deal_summary->StopGrp = $customers_deal_summary->StartGrp + $customers_deal_summary->DisplayGrps - 1;
}

// Stop group <= total number of groups
if (intval($customers_deal_summary->StopGrp) > intval($customers_deal_summary->TotalGrps))
	$customers_deal_summary->StopGrp = $customers_deal_summary->TotalGrps;
$customers_deal_summary->RecCount = 0;

// Get first row
if ($customers_deal_summary->TotalGrps > 0) {
	$customers_deal_summary->GetRow(1);
	$customers_deal_summary->GrpCount = 1;
}
while (($rs && !$rs->EOF && $customers_deal_summary->GrpCount <= $customers_deal_summary->DisplayGrps) || $customers_deal_summary->ShowFirstHeader) {

	// Show header
	if ($customers_deal_summary->ShowFirstHeader) {
?>
	<thead>
	<tr>
<td class="ewTableHeader">
<?php if ($customers_deal->Export <> "") { ?>
<?php echo $customers_deal->deal_number->FldCaption() ?>
<?php } else { ?>
	<table cellspacing="0" class="ewTableHeaderBtn" style="white-space: nowrap;"><tr>
<?php if ($customers_deal->SortUrl($customers_deal->deal_number) == "") { ?>
		<td style="vertical-align: bottom;"><?php echo $customers_deal->deal_number->FldCaption() ?></td>
<?php } else { ?>
		<td class="ewPointer" onmousedown="ewrpt_Sort(event,'<?php echo $customers_deal->SortUrl($customers_deal->deal_number) ?>',0);"><?php echo $customers_deal->deal_number->FldCaption() ?></td><td style="width: 10px;">
		<?php if ($customers_deal->deal_number->getSort() == "ASC") { ?><img src="phprptimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($customers_deal->deal_number->getSort() == "DESC") { ?><img src="phprptimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td>
<?php } ?>
	</tr></table>
<?php } ?>
</td>
<td class="ewTableHeader">
<?php if ($customers_deal->Export <> "") { ?>
<?php echo $customers_deal->salesman->FldCaption() ?>
<?php } else { ?>
	<table cellspacing="0" class="ewTableHeaderBtn" style="white-space: nowrap;"><tr>
<?php if ($customers_deal->SortUrl($customers_deal->salesman) == "") { ?>
		<td style="vertical-align: bottom;"><?php echo $customers_deal->salesman->FldCaption() ?></td>
<?php } else { ?>
		<td class="ewPointer" onmousedown="ewrpt_Sort(event,'<?php echo $customers_deal->SortUrl($customers_deal->salesman) ?>',0);"><?php echo $customers_deal->salesman->FldCaption() ?></td><td style="width: 10px;">
		<?php if ($customers_deal->salesman->getSort() == "ASC") { ?><img src="phprptimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($customers_deal->salesman->getSort() == "DESC") { ?><img src="phprptimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td>
<?php } ?>
	</tr></table>
<?php } ?>
</td>
<td class="ewTableHeader">
<?php if ($customers_deal->Export <> "") { ?>
<?php echo $customers_deal->customer->FldCaption() ?>
<?php } else { ?>
	<table cellspacing="0" class="ewTableHeaderBtn" style="white-space: nowrap;"><tr>
<?php if ($customers_deal->SortUrl($customers_deal->customer) == "") { ?>
		<td style="vertical-align: bottom;"><?php echo $customers_deal->customer->FldCaption() ?></td>
<?php } else { ?>
		<td class="ewPointer" onmousedown="ewrpt_Sort(event,'<?php echo $customers_deal->SortUrl($customers_deal->customer) ?>',0);"><?php echo $customers_deal->customer->FldCaption() ?></td><td style="width: 10px;">
		<?php if ($customers_deal->customer->getSort() == "ASC") { ?><img src="phprptimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($customers_deal->customer->getSort() == "DESC") { ?><img src="phprptimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td>
<?php } ?>
	</tr></table>
<?php } ?>
</td>
<td class="ewTableHeader">
<?php if ($customers_deal->Export <> "") { ?>
<?php echo $customers_deal->idno->FldCaption() ?>
<?php } else { ?>
	<table cellspacing="0" class="ewTableHeaderBtn" style="white-space: nowrap;"><tr>
<?php if ($customers_deal->SortUrl($customers_deal->idno) == "") { ?>
		<td style="vertical-align: bottom;"><?php echo $customers_deal->idno->FldCaption() ?></td>
<?php } else { ?>
		<td class="ewPointer" onmousedown="ewrpt_Sort(event,'<?php echo $customers_deal->SortUrl($customers_deal->idno) ?>',0);"><?php echo $customers_deal->idno->FldCaption() ?></td><td style="width: 10px;">
		<?php if ($customers_deal->idno->getSort() == "ASC") { ?><img src="phprptimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($customers_deal->idno->getSort() == "DESC") { ?><img src="phprptimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td>
<?php } ?>
	</tr></table>
<?php } ?>
</td>
<td class="ewTableHeader">
<?php if ($customers_deal->Export <> "") { ?>
<?php echo $customers_deal->status->FldCaption() ?>
<?php } else { ?>
	<table cellspacing="0" class="ewTableHeaderBtn"><tr>
<?php if ($customers_deal->SortUrl($customers_deal->status) == "") { ?>
		<td style="vertical-align: bottom;"><?php echo $customers_deal->status->FldCaption() ?></td>
<?php } else { ?>
		<td class="ewPointer" onmousedown="ewrpt_Sort(event,'<?php echo $customers_deal->SortUrl($customers_deal->status) ?>',0);"><?php echo $customers_deal->status->FldCaption() ?></td><td style="width: 10px;">
		<?php if ($customers_deal->status->getSort() == "ASC") { ?><img src="phprptimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($customers_deal->status->getSort() == "DESC") { ?><img src="phprptimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td>
<?php } ?>
	</tr></table>
<?php } ?>
</td>
<td class="ewTableHeader">
<?php if ($customers_deal->Export <> "") { ?>
<?php echo $customers_deal->date_start->FldCaption() ?>
<?php } else { ?>
	<table cellspacing="0" class="ewTableHeaderBtn" style="white-space: nowrap;"><tr>
<?php if ($customers_deal->SortUrl($customers_deal->date_start) == "") { ?>
		<td style="vertical-align: bottom;"><?php echo $customers_deal->date_start->FldCaption() ?></td>
<?php } else { ?>
		<td class="ewPointer" onmousedown="ewrpt_Sort(event,'<?php echo $customers_deal->SortUrl($customers_deal->date_start) ?>',0);"><?php echo $customers_deal->date_start->FldCaption() ?></td><td style="width: 10px;">
		<?php if ($customers_deal->date_start->getSort() == "ASC") { ?><img src="phprptimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($customers_deal->date_start->getSort() == "DESC") { ?><img src="phprptimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td>
<?php } ?>
	</tr></table>
<?php } ?>
</td>
<td class="ewTableHeader">
<?php if ($customers_deal->Export <> "") { ?>
<?php echo $customers_deal->NotTakenUpReason_cd->FldCaption() ?>
<?php } else { ?>
	<table cellspacing="0" class="ewTableHeaderBtn" style="white-space: nowrap;"><tr>
<?php if ($customers_deal->SortUrl($customers_deal->NotTakenUpReason_cd) == "") { ?>
		<td style="vertical-align: bottom;"><?php echo $customers_deal->NotTakenUpReason_cd->FldCaption() ?></td>
<?php } else { ?>
		<td class="ewPointer" onmousedown="ewrpt_Sort(event,'<?php echo $customers_deal->SortUrl($customers_deal->NotTakenUpReason_cd) ?>',0);"><?php echo $customers_deal->NotTakenUpReason_cd->FldCaption() ?></td><td style="width: 10px;">
		<?php if ($customers_deal->NotTakenUpReason_cd->getSort() == "ASC") { ?><img src="phprptimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($customers_deal->NotTakenUpReason_cd->getSort() == "DESC") { ?><img src="phprptimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td>
<?php } ?>
	</tr></table>
<?php } ?>
</td>
<td class="ewTableHeader">
<?php if ($customers_deal->Export <> "") { ?>
<?php echo $customers_deal->product_name->FldCaption() ?>
<?php } else { ?>
	<table cellspacing="0" class="ewTableHeaderBtn" style="white-space: nowrap;"><tr>
<?php if ($customers_deal->SortUrl($customers_deal->product_name) == "") { ?>
		<td style="vertical-align: bottom;"><?php echo $customers_deal->product_name->FldCaption() ?></td>
<?php } else { ?>
		<td class="ewPointer" onmousedown="ewrpt_Sort(event,'<?php echo $customers_deal->SortUrl($customers_deal->product_name) ?>',0);"><?php echo $customers_deal->product_name->FldCaption() ?></td><td style="width: 10px;">
		<?php if ($customers_deal->product_name->getSort() == "ASC") { ?><img src="phprptimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($customers_deal->product_name->getSort() == "DESC") { ?><img src="phprptimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td>
<?php } ?>
	</tr></table>
<?php } ?>
</td>
<td class="ewTableHeader">
<?php if ($customers_deal->Export <> "") { ?>
<?php echo $customers_deal->total_premium->FldCaption() ?>
<?php } else { ?>
	<table cellspacing="0" class="ewTableHeaderBtn"><tr>
<?php if ($customers_deal->SortUrl($customers_deal->total_premium) == "") { ?>
		<td style="vertical-align: bottom;"><?php echo $customers_deal->total_premium->FldCaption() ?></td>
<?php } else { ?>
		<td class="ewPointer" onmousedown="ewrpt_Sort(event,'<?php echo $customers_deal->SortUrl($customers_deal->total_premium) ?>',0);"><?php echo $customers_deal->total_premium->FldCaption() ?></td><td style="width: 10px;">
		<?php if ($customers_deal->total_premium->getSort() == "ASC") { ?><img src="phprptimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($customers_deal->total_premium->getSort() == "DESC") { ?><img src="phprptimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td>
<?php } ?>
	</tr></table>
<?php } ?>
</td>
<td class="ewTableHeader">
<?php if ($customers_deal->Export <> "") { ?>
<?php echo $customers_deal->commission->FldCaption() ?>
<?php } else { ?>
	<table cellspacing="0" class="ewTableHeaderBtn" style="white-space: nowrap;"><tr>
<?php if ($customers_deal->SortUrl($customers_deal->commission) == "") { ?>
		<td style="vertical-align: bottom;"><?php echo $customers_deal->commission->FldCaption() ?></td>
<?php } else { ?>
		<td class="ewPointer" onmousedown="ewrpt_Sort(event,'<?php echo $customers_deal->SortUrl($customers_deal->commission) ?>',0);"><?php echo $customers_deal->commission->FldCaption() ?></td><td style="width: 10px;">
		<?php if ($customers_deal->commission->getSort() == "ASC") { ?><img src="phprptimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($customers_deal->commission->getSort() == "DESC") { ?><img src="phprptimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td>
<?php } ?>
	</tr></table>
<?php } ?>
</td>
<td class="ewTableHeader">
<?php if ($customers_deal->Export <> "") { ?>
<?php echo $customers_deal->rep2Etotal_premium_2D_rep2Ecommission->FldCaption() ?>
<?php } else { ?>
	<table cellspacing="0" class="ewTableHeaderBtn"><tr>
<?php if ($customers_deal->SortUrl($customers_deal->rep2Etotal_premium_2D_rep2Ecommission) == "") { ?>
		<td style="vertical-align: bottom;"><?php echo $customers_deal->rep2Etotal_premium_2D_rep2Ecommission->FldCaption() ?></td>
<?php } else { ?>
		<td class="ewPointer" onmousedown="ewrpt_Sort(event,'<?php echo $customers_deal->SortUrl($customers_deal->rep2Etotal_premium_2D_rep2Ecommission) ?>',0);"><?php echo $customers_deal->rep2Etotal_premium_2D_rep2Ecommission->FldCaption() ?></td><td style="width: 10px;">
		<?php if ($customers_deal->rep2Etotal_premium_2D_rep2Ecommission->getSort() == "ASC") { ?><img src="phprptimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($customers_deal->rep2Etotal_premium_2D_rep2Ecommission->getSort() == "DESC") { ?><img src="phprptimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td>
<?php } ?>
	</tr></table>
<?php } ?>
</td>
<td class="ewTableHeader">
<?php if ($customers_deal->Export <> "") { ?>
<?php echo $customers_deal->Description->FldCaption() ?>
<?php } else { ?>
	<table cellspacing="0" class="ewTableHeaderBtn" style="white-space: nowrap;"><tr>
<?php if ($customers_deal->SortUrl($customers_deal->Description) == "") { ?>
		<td style="vertical-align: bottom;"><?php echo $customers_deal->Description->FldCaption() ?></td>
<?php } else { ?>
		<td class="ewPointer" onmousedown="ewrpt_Sort(event,'<?php echo $customers_deal->SortUrl($customers_deal->Description) ?>',0);"><?php echo $customers_deal->Description->FldCaption() ?></td><td style="width: 10px;">
		<?php if ($customers_deal->Description->getSort() == "ASC") { ?><img src="phprptimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($customers_deal->Description->getSort() == "DESC") { ?><img src="phprptimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td>
<?php } ?>
	</tr></table>
<?php } ?>
</td>
<td class="ewTableHeader">
<?php if ($customers_deal->Export <> "") { ?>
<?php echo $customers_deal->Format28car22EAmount2C_229->FldCaption() ?>
<?php } else { ?>
	<table cellspacing="0" class="ewTableHeaderBtn"><tr>
<?php if ($customers_deal->SortUrl($customers_deal->Format28car22EAmount2C_229) == "") { ?>
		<td style="vertical-align: bottom;"><?php echo $customers_deal->Format28car22EAmount2C_229->FldCaption() ?></td>
<?php } else { ?>
		<td class="ewPointer" onmousedown="ewrpt_Sort(event,'<?php echo $customers_deal->SortUrl($customers_deal->Format28car22EAmount2C_229) ?>',0);"><?php echo $customers_deal->Format28car22EAmount2C_229->FldCaption() ?></td><td style="width: 10px;">
		<?php if ($customers_deal->Format28car22EAmount2C_229->getSort() == "ASC") { ?><img src="phprptimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($customers_deal->Format28car22EAmount2C_229->getSort() == "DESC") { ?><img src="phprptimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td>
<?php } ?>
	</tr></table>
<?php } ?>
</td>
	</tr>
	</thead>
	<tbody>
<?php
		$customers_deal_summary->ShowFirstHeader = FALSE;
	}
	$customers_deal_summary->RecCount++;

		// Render detail row
		$customers_deal->ResetCSS();
		$customers_deal->RowType = EWRPT_ROWTYPE_DETAIL;
		$customers_deal_summary->RenderRow();
?>
	<tr<?php echo $customers_deal->RowAttributes(); ?>>
		<td<?php echo $customers_deal->deal_number->CellAttributes() ?>>
<span<?php echo $customers_deal->deal_number->ViewAttributes(); ?>><?php echo $customers_deal->deal_number->ListViewValue(); ?></span></td>
		<td<?php echo $customers_deal->salesman->CellAttributes() ?>>
<span<?php echo $customers_deal->salesman->ViewAttributes(); ?>><?php echo $customers_deal->salesman->ListViewValue(); ?></span></td>
		<td<?php echo $customers_deal->customer->CellAttributes() ?>>
<span<?php echo $customers_deal->customer->ViewAttributes(); ?>><?php echo $customers_deal->customer->ListViewValue(); ?></span></td>
		<td<?php echo $customers_deal->idno->CellAttributes() ?>>
<span<?php echo $customers_deal->idno->ViewAttributes(); ?>><?php echo $customers_deal->idno->ListViewValue(); ?></span></td>
		<td<?php echo $customers_deal->status->CellAttributes() ?>>
<span<?php echo $customers_deal->status->ViewAttributes(); ?>><?php echo $customers_deal->status->ListViewValue(); ?></span></td>
		<td<?php echo $customers_deal->date_start->CellAttributes() ?>>
<span<?php echo $customers_deal->date_start->ViewAttributes(); ?>><?php echo $customers_deal->date_start->ListViewValue(); ?></span></td>
		<td<?php echo $customers_deal->NotTakenUpReason_cd->CellAttributes() ?>>
<span<?php echo $customers_deal->NotTakenUpReason_cd->ViewAttributes(); ?>><?php echo $customers_deal->NotTakenUpReason_cd->ListViewValue(); ?></span></td>
		<td<?php echo $customers_deal->product_name->CellAttributes() ?>>
<span<?php echo $customers_deal->product_name->ViewAttributes(); ?>><?php echo $customers_deal->product_name->ListViewValue(); ?></span></td>
		<td<?php echo $customers_deal->total_premium->CellAttributes() ?>>
<span<?php echo $customers_deal->total_premium->ViewAttributes(); ?>><?php echo $customers_deal->total_premium->ListViewValue(); ?></span></td>
		<td<?php echo $customers_deal->commission->CellAttributes() ?>>
<span<?php echo $customers_deal->commission->ViewAttributes(); ?>><?php echo $customers_deal->commission->ListViewValue(); ?></span></td>
		<td<?php echo $customers_deal->rep2Etotal_premium_2D_rep2Ecommission->CellAttributes() ?>>
<span<?php echo $customers_deal->rep2Etotal_premium_2D_rep2Ecommission->ViewAttributes(); ?>><?php echo $customers_deal->rep2Etotal_premium_2D_rep2Ecommission->ListViewValue(); ?></span></td>
		<td<?php echo $customers_deal->Description->CellAttributes() ?>>
<span<?php echo $customers_deal->Description->ViewAttributes(); ?>><?php echo $customers_deal->Description->ListViewValue(); ?></span></td>
		<td<?php echo $customers_deal->Format28car22EAmount2C_229->CellAttributes() ?>>
<span<?php echo $customers_deal->Format28car22EAmount2C_229->ViewAttributes(); ?>><?php echo $customers_deal->Format28car22EAmount2C_229->ListViewValue(); ?></span></td>
	</tr>
<?php

		// Accumulate page summary
		$customers_deal_summary->AccumulateSummary();

		// Get next record
		$customers_deal_summary->GetRow(2);
	$customers_deal_summary->GrpCount++;
} // End while
?>
	</tbody>
	<tfoot>
<?php
if ($customers_deal_summary->TotalGrps > 0) {
	$customers_deal->ResetCSS();
	$customers_deal->RowType = EWRPT_ROWTYPE_TOTAL;
	$customers_deal->RowTotalType = EWRPT_ROWTOTAL_GRAND;
	$customers_deal->RowTotalSubType = EWRPT_ROWTOTAL_FOOTER;
	$customers_deal->RowAttrs["class"] = "ewRptGrandSummary";
	$customers_deal_summary->RenderRow();
?>
	<!-- tr><td colspan="13"><span class="phpreportmaker">&nbsp;<br></span></td></tr -->
	<tr<?php echo $customers_deal->RowAttributes(); ?>><td colspan="13"><?php echo $ReportLanguage->Phrase("RptGrandTotal") ?> (<?php echo ewrpt_FormatNumber($customers_deal_summary->TotCount,0,-2,-2,-2); ?><?php echo $ReportLanguage->Phrase("RptDtlRec") ?>)</td></tr>
<?php } ?>
	</tfoot>
</table>
</div>
<?php if ($customers_deal->Export == "") { ?>
<div class="ewGridLowerPanel">
<form action="<?php echo ewrpt_CurrentPage() ?>" name="ewpagerform" id="ewpagerform" class="ewForm">
<table border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td style="white-space: nowrap;">
<?php if (!isset($Pager)) $Pager = new crPrevNextPager($customers_deal_summary->StartGrp, $customers_deal_summary->DisplayGrps, $customers_deal_summary->TotalGrps) ?>
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
	<?php if ($customers_deal_summary->Filter == "0=101") { ?>
	<span class="phpreportmaker"><?php echo $ReportLanguage->Phrase("EnterSearchCriteria") ?></span>
	<?php } else { ?>
	<span class="phpreportmaker"><?php echo $ReportLanguage->Phrase("NoRecord") ?></span>
	<?php } ?>
<?php } ?>
		</td>
<?php if ($customers_deal_summary->TotalGrps > 0) { ?>
		<td style="white-space: nowrap;">&nbsp;&nbsp;&nbsp;&nbsp;</td>
		<td align="right" style="vertical-align: top; white-space: nowrap;"><span class="phpreportmaker"><?php echo $ReportLanguage->Phrase("GroupsPerPage"); ?>&nbsp;
<select name="<?php echo EWRPT_TABLE_GROUP_PER_PAGE; ?>" onchange="this.form.submit();">
<option value="1"<?php if ($customers_deal_summary->DisplayGrps == 1) echo " selected=\"selected\"" ?>>1</option>
<option value="2"<?php if ($customers_deal_summary->DisplayGrps == 2) echo " selected=\"selected\"" ?>>2</option>
<option value="3"<?php if ($customers_deal_summary->DisplayGrps == 3) echo " selected=\"selected\"" ?>>3</option>
<option value="4"<?php if ($customers_deal_summary->DisplayGrps == 4) echo " selected=\"selected\"" ?>>4</option>
<option value="5"<?php if ($customers_deal_summary->DisplayGrps == 5) echo " selected=\"selected\"" ?>>5</option>
<option value="10"<?php if ($customers_deal_summary->DisplayGrps == 10) echo " selected=\"selected\"" ?>>10</option>
<option value="20"<?php if ($customers_deal_summary->DisplayGrps == 20) echo " selected=\"selected\"" ?>>20</option>
<option value="50"<?php if ($customers_deal_summary->DisplayGrps == 50) echo " selected=\"selected\"" ?>>50</option>
<option value="ALL"<?php if ($customers_deal->getGroupPerPage() == -1) echo " selected=\"selected\"" ?>><?php echo $ReportLanguage->Phrase("AllRecords") ?></option>
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
<?php if ($customers_deal->Export == "" || $customers_deal->Export == "print" || $customers_deal->Export == "email") { ?>
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
<?php $customers_deal_summary->ShowPageFooter(); ?>
<?php if (EWRPT_DEBUG_ENABLED) echo ewrpt_DebugMsg(); ?>
<?php

// Close recordsets
if ($rsgrp) $rsgrp->Close();
if ($rs) $rs->Close();
?>
<?php if ($customers_deal->Export == "") { ?>
<script language="JavaScript" type="text/javascript">
<!--

// Write your table-specific startup script here
// document.write("page loaded");
//-->

</script>
<?php } ?>
<?php include_once "phprptinc/footer.php"; ?>
<?php
$customers_deal_summary->Page_Terminate();
?>
<?php

//
// Page class
//
class crcustomers_deal_summary {

	// Page ID
	var $PageID = 'summary';

	// Table name
	var $TableName = 'customers_deal';

	// Page object name
	var $PageObjName = 'customers_deal_summary';

	// Page name
	function PageName() {
		return ewrpt_CurrentPage();
	}

	// Page URL
	function PageUrl() {
		$PageUrl = ewrpt_CurrentPage() . "?";
		global $customers_deal;
		if ($customers_deal->UseTokenInUrl) $PageUrl .= "t=" . $customers_deal->TableVar . "&"; // Add page token
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
		global $customers_deal;
		if ($customers_deal->UseTokenInUrl) {
			if (ewrpt_IsHttpPost())
				return ($customers_deal->TableVar == @$_POST("t"));
			if (@$_GET["t"] <> "")
				return ($customers_deal->TableVar == @$_GET["t"]);
		} else {
			return TRUE;
		}
	}

	//
	// Page class constructor
	//
	function crcustomers_deal_summary() {
		global $conn, $ReportLanguage;

		// Language object
		$ReportLanguage = new crLanguage();

		// Table object (customers_deal)
		$GLOBALS["customers_deal"] = new crcustomers_deal();
		$GLOBALS["Table"] =& $GLOBALS["customers_deal"];

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
			define("EWRPT_TABLE_NAME", 'customers_deal', TRUE);

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
		global $customers_deal;

		// Security
		$Security = new crAdvancedSecurity();
		if (!$Security->IsLoggedIn()) $Security->AutoLogin(); // Auto login
		if (!$Security->IsLoggedIn()) {
			$Security->SaveLastUrl();
			$this->Page_Terminate("rlogin.php");
		}

		// Get export parameters
		if (@$_GET["export"] <> "") {
			$customers_deal->Export = $_GET["export"];
		}
		$gsExport = $customers_deal->Export; // Get export parameter, used in header
		$gsExportFile = $customers_deal->TableVar; // Get export file, used in header
		if ($customers_deal->Export == "excel") {
			header('Content-Type: application/vnd.ms-excel;charset=utf-8');
			header('Content-Disposition: attachment; filename=' . $gsExportFile .'.xls');
		}
		if ($customers_deal->Export == "word") {
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
		global $ReportLanguage, $customers_deal;

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
		$item->Body = "<a name=\"emf_customers_deal\" id=\"emf_customers_deal\" href=\"javascript:void(0);\" onclick=\"ewrpt_EmailDialogShow({lnk:'emf_customers_deal',hdr:ewLanguage.Phrase('ExportToEmail')});\">" . $ReportLanguage->Phrase("ExportToEmail") . "</a>";
		$item->Visible = FALSE;

		// Reset filter
		$item =& $this->ExportOptions->Add("resetfilter");
		$item->Body = "<a href=\"" . ewrpt_CurrentPage() . "?cmd=reset\">" . $ReportLanguage->Phrase("ResetAllFilter") . "</a>";
		$item->Visible = TRUE;
		$this->SetupExportOptionsExt();

		// Hide options for export
		if ($customers_deal->Export <> "")
			$this->ExportOptions->HideAllOptions();

		// Set up table class
		if ($customers_deal->Export == "word" || $customers_deal->Export == "excel" || $customers_deal->Export == "pdf")
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
		global $customers_deal;

		// Page Unload event
		$this->Page_Unload();

		// Global Page Unloaded event (in userfn*.php)
		Page_Unloaded();

		// Export to Email (use ob_file_contents for PHP)
		if ($customers_deal->Export == "email") {
			$sContent = ob_get_contents();
			$this->ExportEmail($sContent);
			ob_end_clean();

			 // Close connection
			$conn->Close();
			header("Location: " . ewrpt_CurrentPage());
			exit();
		}

		// Export to PDF (use ob_file_contents for PHP)
		if ($customers_deal->Export == "pdf") {
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
		global $customers_deal;
		global $rs;
		global $rsgrp;
		global $gsFormError;

		// Aggregate variables
		// 1st dimension = no of groups (level 0 used for grand total)
		// 2nd dimension = no of fields

		$nDtls = 14;
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
		$this->Col = array(FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE);

		// Set up groups per page dynamically
		$this->SetUpDisplayGrps();

		// Load default filter values
		$this->LoadDefaultFilters();

		// Load custom filters
		$customers_deal->Filters_Load();

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
		$sSql = ewrpt_BuildReportSql($customers_deal->SqlSelect(), $customers_deal->SqlWhere(), $customers_deal->SqlGroupBy(), $customers_deal->SqlHaving(), $customers_deal->SqlOrderBy(), $this->Filter, $this->Sort);
		$this->TotalGrps = $this->GetCnt($sSql);
		if ($this->DisplayGrps <= 0) // Display all groups
			$this->DisplayGrps = $this->TotalGrps;
		$this->StartGrp = 1;

		// Show header
		$this->ShowFirstHeader = ($this->TotalGrps > 0);

		//$this->ShowFirstHeader = TRUE; // Uncomment to always show header
		// Set up start position if not export all

		if ($customers_deal->ExportAll && $customers_deal->Export <> "")
		    $this->DisplayGrps = $this->TotalGrps;
		else
			$this->SetUpStartGroup(); 

		// Hide all options if export
		if ($customers_deal->Export <> "") {
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
		global $customers_deal;
		if (!$rs)
			return;
		if ($opt == 1) { // Get first row

	//		$rs->MoveFirst(); // NOTE: no need to move position
		} else { // Get next row
			$rs->MoveNext();
		}
		if (!$rs->EOF) {
			$customers_deal->deal_number->setDbValue($rs->fields('deal_number'));
			$customers_deal->dealer->setDbValue($rs->fields('dealer'));
			$customers_deal->salesman->setDbValue($rs->fields('salesman'));
			$customers_deal->customer->setDbValue($rs->fields('customer'));
			$customers_deal->idno->setDbValue($rs->fields('idno'));
			$customers_deal->status->setDbValue($rs->fields('status'));
			$customers_deal->date_start->setDbValue($rs->fields('date_start'));
			$customers_deal->NotTakenUpReason_cd->setDbValue($rs->fields('NotTakenUpReason_cd'));
			$customers_deal->product_name->setDbValue($rs->fields('product_name'));
			$customers_deal->total_premium->setDbValue($rs->fields('total_premium'));
			$customers_deal->commission->setDbValue($rs->fields('commission'));
			$customers_deal->rep2Etotal_premium_2D_rep2Ecommission->setDbValue($rs->fields('rep.total_premium - rep.commission'));
			$customers_deal->Description->setDbValue($rs->fields('Description'));
			$customers_deal->Format28car22EAmount2C_229->setDbValue($rs->fields('Format(car2.Amount, 2)'));
			$this->Val[1] = $customers_deal->deal_number->CurrentValue;
			$this->Val[2] = $customers_deal->salesman->CurrentValue;
			$this->Val[3] = $customers_deal->customer->CurrentValue;
			$this->Val[4] = $customers_deal->idno->CurrentValue;
			$this->Val[5] = $customers_deal->status->CurrentValue;
			$this->Val[6] = $customers_deal->date_start->CurrentValue;
			$this->Val[7] = $customers_deal->NotTakenUpReason_cd->CurrentValue;
			$this->Val[8] = $customers_deal->product_name->CurrentValue;
			$this->Val[9] = $customers_deal->total_premium->CurrentValue;
			$this->Val[10] = $customers_deal->commission->CurrentValue;
			$this->Val[11] = $customers_deal->rep2Etotal_premium_2D_rep2Ecommission->CurrentValue;
			$this->Val[12] = $customers_deal->Description->CurrentValue;
			$this->Val[13] = $customers_deal->Format28car22EAmount2C_229->CurrentValue;
		} else {
			$customers_deal->deal_number->setDbValue("");
			$customers_deal->dealer->setDbValue("");
			$customers_deal->salesman->setDbValue("");
			$customers_deal->customer->setDbValue("");
			$customers_deal->idno->setDbValue("");
			$customers_deal->status->setDbValue("");
			$customers_deal->date_start->setDbValue("");
			$customers_deal->NotTakenUpReason_cd->setDbValue("");
			$customers_deal->product_name->setDbValue("");
			$customers_deal->total_premium->setDbValue("");
			$customers_deal->commission->setDbValue("");
			$customers_deal->rep2Etotal_premium_2D_rep2Ecommission->setDbValue("");
			$customers_deal->Description->setDbValue("");
			$customers_deal->Format28car22EAmount2C_229->setDbValue("");
		}
	}

	//  Set up starting group
	function SetUpStartGroup() {
		global $customers_deal;

		// Exit if no groups
		if ($this->DisplayGrps == 0)
			return;

		// Check for a 'start' parameter
		if (@$_GET[EWRPT_TABLE_START_GROUP] != "") {
			$this->StartGrp = $_GET[EWRPT_TABLE_START_GROUP];
			$customers_deal->setStartGroup($this->StartGrp);
		} elseif (@$_GET["pageno"] != "") {
			$nPageNo = $_GET["pageno"];
			if (is_numeric($nPageNo)) {
				$this->StartGrp = ($nPageNo-1)*$this->DisplayGrps+1;
				if ($this->StartGrp <= 0) {
					$this->StartGrp = 1;
				} elseif ($this->StartGrp >= intval(($this->TotalGrps-1)/$this->DisplayGrps)*$this->DisplayGrps+1) {
					$this->StartGrp = intval(($this->TotalGrps-1)/$this->DisplayGrps)*$this->DisplayGrps+1;
				}
				$customers_deal->setStartGroup($this->StartGrp);
			} else {
				$this->StartGrp = $customers_deal->getStartGroup();
			}
		} else {
			$this->StartGrp = $customers_deal->getStartGroup();
		}

		// Check if correct start group counter
		if (!is_numeric($this->StartGrp) || $this->StartGrp == "") { // Avoid invalid start group counter
			$this->StartGrp = 1; // Reset start group counter
			$customers_deal->setStartGroup($this->StartGrp);
		} elseif (intval($this->StartGrp) > intval($this->TotalGrps)) { // Avoid starting group > total groups
			$this->StartGrp = intval(($this->TotalGrps-1)/$this->DisplayGrps) * $this->DisplayGrps + 1; // Point to last page first group
			$customers_deal->setStartGroup($this->StartGrp);
		} elseif (($this->StartGrp-1) % $this->DisplayGrps <> 0) {
			$this->StartGrp = intval(($this->StartGrp-1)/$this->DisplayGrps) * $this->DisplayGrps + 1; // Point to page boundary
			$customers_deal->setStartGroup($this->StartGrp);
		}
	}

	// Set up popup
	function SetupPopup() {
		global $conn, $ReportLanguage;
		global $customers_deal;

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
		global $customers_deal;
		$this->StartGrp = 1;
		$customers_deal->setStartGroup($this->StartGrp);
	}

	// Set up number of groups displayed per page
	function SetUpDisplayGrps() {
		global $customers_deal;
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
			$customers_deal->setGroupPerPage($this->DisplayGrps); // Save to session

			// Reset start position (reset command)
			$this->StartGrp = 1;
			$customers_deal->setStartGroup($this->StartGrp);
		} else {
			if ($customers_deal->getGroupPerPage() <> "") {
				$this->DisplayGrps = $customers_deal->getGroupPerPage(); // Restore from session
			} else {
				$this->DisplayGrps = 50; // Load default
			}
		}
	}

	function RenderRow() {
		global $conn, $rs, $Security;
		global $customers_deal;
		if ($customers_deal->RowTotalType == EWRPT_ROWTOTAL_GRAND) { // Grand total

			// Get total count from sql directly
			$sSql = ewrpt_BuildReportSql($customers_deal->SqlSelectCount(), $customers_deal->SqlWhere(), $customers_deal->SqlGroupBy(), $customers_deal->SqlHaving(), "", $this->Filter, "");
			$rstot = $conn->Execute($sSql);
			if ($rstot) {
				$this->TotCount = ($rstot->RecordCount()>1) ? $rstot->RecordCount() : $rstot->fields[0];
				$rstot->Close();
			} else {
				$this->TotCount = 0;
			}
		}

		// Call Row_Rendering event
		$customers_deal->Row_Rendering();

		//
		// Render view codes
		//

		if ($customers_deal->RowType == EWRPT_ROWTYPE_TOTAL) { // Summary row
		} else {

			// deal_number
			$customers_deal->deal_number->ViewValue = $customers_deal->deal_number->CurrentValue;
			$customers_deal->deal_number->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";
			$customers_deal->deal_number->CellAttrs["style"] = "white-space: nowrap;";

			// salesman
			$customers_deal->salesman->ViewValue = $customers_deal->salesman->CurrentValue;
			$customers_deal->salesman->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";
			$customers_deal->salesman->CellAttrs["style"] = "white-space: nowrap;";

			// customer
			$customers_deal->customer->ViewValue = $customers_deal->customer->CurrentValue;
			$customers_deal->customer->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";
			$customers_deal->customer->CellAttrs["style"] = "white-space: nowrap;";

			// idno
			$customers_deal->idno->ViewValue = $customers_deal->idno->CurrentValue;
			$customers_deal->idno->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";
			$customers_deal->idno->CellAttrs["style"] = "white-space: nowrap;";

			// status
			$customers_deal->status->ViewValue = $customers_deal->status->CurrentValue;
			$customers_deal->status->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";

			// date_start
			$customers_deal->date_start->ViewValue = $customers_deal->date_start->CurrentValue;
			$customers_deal->date_start->ViewValue = ewrpt_FormatDateTime($customers_deal->date_start->ViewValue, 7);
			$customers_deal->date_start->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";
			$customers_deal->date_start->CellAttrs["style"] = "white-space: nowrap;";

			// NotTakenUpReason_cd
			$customers_deal->NotTakenUpReason_cd->ViewValue = $customers_deal->NotTakenUpReason_cd->CurrentValue;
			$customers_deal->NotTakenUpReason_cd->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";
			$customers_deal->NotTakenUpReason_cd->CellAttrs["style"] = "white-space: nowrap;";

			// product_name
			$customers_deal->product_name->ViewValue = $customers_deal->product_name->CurrentValue;
			$customers_deal->product_name->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";
			$customers_deal->product_name->CellAttrs["style"] = "white-space: nowrap;";

			// total_premium
			$customers_deal->total_premium->ViewValue = $customers_deal->total_premium->CurrentValue;
			$customers_deal->total_premium->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";

			// commission
			$customers_deal->commission->ViewValue = $customers_deal->commission->CurrentValue;
			$customers_deal->commission->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";
			$customers_deal->commission->CellAttrs["style"] = "white-space: nowrap;";

			// rep.total_premium - rep.commission
			$customers_deal->rep2Etotal_premium_2D_rep2Ecommission->ViewValue = $customers_deal->rep2Etotal_premium_2D_rep2Ecommission->CurrentValue;
			$customers_deal->rep2Etotal_premium_2D_rep2Ecommission->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";

			// Description
			$customers_deal->Description->ViewValue = $customers_deal->Description->CurrentValue;
			$customers_deal->Description->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";
			$customers_deal->Description->CellAttrs["style"] = "white-space: nowrap;";

			// Format(car2.Amount, 2)
			$customers_deal->Format28car22EAmount2C_229->ViewValue = $customers_deal->Format28car22EAmount2C_229->CurrentValue;
			$customers_deal->Format28car22EAmount2C_229->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";

			// deal_number
			$customers_deal->deal_number->HrefValue = "";

			// salesman
			$customers_deal->salesman->HrefValue = "";

			// customer
			$customers_deal->customer->HrefValue = "";

			// idno
			$customers_deal->idno->HrefValue = "";

			// status
			$customers_deal->status->HrefValue = "";

			// date_start
			$customers_deal->date_start->HrefValue = "";

			// NotTakenUpReason_cd
			$customers_deal->NotTakenUpReason_cd->HrefValue = "";

			// product_name
			$customers_deal->product_name->HrefValue = "";

			// total_premium
			$customers_deal->total_premium->HrefValue = "";

			// commission
			$customers_deal->commission->HrefValue = "";

			// rep.total_premium - rep.commission
			$customers_deal->rep2Etotal_premium_2D_rep2Ecommission->HrefValue = "";

			// Description
			$customers_deal->Description->HrefValue = "";

			// Format(car2.Amount, 2)
			$customers_deal->Format28car22EAmount2C_229->HrefValue = "";
		}

		// Call Cell_Rendered event
		if ($customers_deal->RowType == EWRPT_ROWTYPE_TOTAL) { // Summary row
		} else {

			// deal_number
			$CurrentValue = $customers_deal->deal_number->CurrentValue;
			$ViewValue =& $customers_deal->deal_number->ViewValue;
			$ViewAttrs =& $customers_deal->deal_number->ViewAttrs;
			$CellAttrs =& $customers_deal->deal_number->CellAttrs;
			$HrefValue =& $customers_deal->deal_number->HrefValue;
			$customers_deal->Cell_Rendered($customers_deal->deal_number, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue);

			// salesman
			$CurrentValue = $customers_deal->salesman->CurrentValue;
			$ViewValue =& $customers_deal->salesman->ViewValue;
			$ViewAttrs =& $customers_deal->salesman->ViewAttrs;
			$CellAttrs =& $customers_deal->salesman->CellAttrs;
			$HrefValue =& $customers_deal->salesman->HrefValue;
			$customers_deal->Cell_Rendered($customers_deal->salesman, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue);

			// customer
			$CurrentValue = $customers_deal->customer->CurrentValue;
			$ViewValue =& $customers_deal->customer->ViewValue;
			$ViewAttrs =& $customers_deal->customer->ViewAttrs;
			$CellAttrs =& $customers_deal->customer->CellAttrs;
			$HrefValue =& $customers_deal->customer->HrefValue;
			$customers_deal->Cell_Rendered($customers_deal->customer, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue);

			// idno
			$CurrentValue = $customers_deal->idno->CurrentValue;
			$ViewValue =& $customers_deal->idno->ViewValue;
			$ViewAttrs =& $customers_deal->idno->ViewAttrs;
			$CellAttrs =& $customers_deal->idno->CellAttrs;
			$HrefValue =& $customers_deal->idno->HrefValue;
			$customers_deal->Cell_Rendered($customers_deal->idno, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue);

			// status
			$CurrentValue = $customers_deal->status->CurrentValue;
			$ViewValue =& $customers_deal->status->ViewValue;
			$ViewAttrs =& $customers_deal->status->ViewAttrs;
			$CellAttrs =& $customers_deal->status->CellAttrs;
			$HrefValue =& $customers_deal->status->HrefValue;
			$customers_deal->Cell_Rendered($customers_deal->status, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue);

			// date_start
			$CurrentValue = $customers_deal->date_start->CurrentValue;
			$ViewValue =& $customers_deal->date_start->ViewValue;
			$ViewAttrs =& $customers_deal->date_start->ViewAttrs;
			$CellAttrs =& $customers_deal->date_start->CellAttrs;
			$HrefValue =& $customers_deal->date_start->HrefValue;
			$customers_deal->Cell_Rendered($customers_deal->date_start, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue);

			// NotTakenUpReason_cd
			$CurrentValue = $customers_deal->NotTakenUpReason_cd->CurrentValue;
			$ViewValue =& $customers_deal->NotTakenUpReason_cd->ViewValue;
			$ViewAttrs =& $customers_deal->NotTakenUpReason_cd->ViewAttrs;
			$CellAttrs =& $customers_deal->NotTakenUpReason_cd->CellAttrs;
			$HrefValue =& $customers_deal->NotTakenUpReason_cd->HrefValue;
			$customers_deal->Cell_Rendered($customers_deal->NotTakenUpReason_cd, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue);

			// product_name
			$CurrentValue = $customers_deal->product_name->CurrentValue;
			$ViewValue =& $customers_deal->product_name->ViewValue;
			$ViewAttrs =& $customers_deal->product_name->ViewAttrs;
			$CellAttrs =& $customers_deal->product_name->CellAttrs;
			$HrefValue =& $customers_deal->product_name->HrefValue;
			$customers_deal->Cell_Rendered($customers_deal->product_name, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue);

			// total_premium
			$CurrentValue = $customers_deal->total_premium->CurrentValue;
			$ViewValue =& $customers_deal->total_premium->ViewValue;
			$ViewAttrs =& $customers_deal->total_premium->ViewAttrs;
			$CellAttrs =& $customers_deal->total_premium->CellAttrs;
			$HrefValue =& $customers_deal->total_premium->HrefValue;
			$customers_deal->Cell_Rendered($customers_deal->total_premium, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue);

			// commission
			$CurrentValue = $customers_deal->commission->CurrentValue;
			$ViewValue =& $customers_deal->commission->ViewValue;
			$ViewAttrs =& $customers_deal->commission->ViewAttrs;
			$CellAttrs =& $customers_deal->commission->CellAttrs;
			$HrefValue =& $customers_deal->commission->HrefValue;
			$customers_deal->Cell_Rendered($customers_deal->commission, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue);

			// rep.total_premium - rep.commission
			$CurrentValue = $customers_deal->rep2Etotal_premium_2D_rep2Ecommission->CurrentValue;
			$ViewValue =& $customers_deal->rep2Etotal_premium_2D_rep2Ecommission->ViewValue;
			$ViewAttrs =& $customers_deal->rep2Etotal_premium_2D_rep2Ecommission->ViewAttrs;
			$CellAttrs =& $customers_deal->rep2Etotal_premium_2D_rep2Ecommission->CellAttrs;
			$HrefValue =& $customers_deal->rep2Etotal_premium_2D_rep2Ecommission->HrefValue;
			$customers_deal->Cell_Rendered($customers_deal->rep2Etotal_premium_2D_rep2Ecommission, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue);

			// Description
			$CurrentValue = $customers_deal->Description->CurrentValue;
			$ViewValue =& $customers_deal->Description->ViewValue;
			$ViewAttrs =& $customers_deal->Description->ViewAttrs;
			$CellAttrs =& $customers_deal->Description->CellAttrs;
			$HrefValue =& $customers_deal->Description->HrefValue;
			$customers_deal->Cell_Rendered($customers_deal->Description, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue);

			// Format(car2.Amount, 2)
			$CurrentValue = $customers_deal->Format28car22EAmount2C_229->CurrentValue;
			$ViewValue =& $customers_deal->Format28car22EAmount2C_229->ViewValue;
			$ViewAttrs =& $customers_deal->Format28car22EAmount2C_229->ViewAttrs;
			$CellAttrs =& $customers_deal->Format28car22EAmount2C_229->CellAttrs;
			$HrefValue =& $customers_deal->Format28car22EAmount2C_229->HrefValue;
			$customers_deal->Cell_Rendered($customers_deal->Format28car22EAmount2C_229, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue);
		}

		// Call Row_Rendered event
		$customers_deal->Row_Rendered();
	}

	function SetupExportOptionsExt() {
		global $ReportLanguage, $customers_deal;
	}

	// Get extended filter values
	function GetExtendedFilterValues() {
		global $customers_deal;

		// Field dealer
		$sSelect = "SELECT DISTINCT rep.dealer FROM " . $customers_deal->SqlFrom();
		$sOrderBy = "rep.dealer ASC";
		$wrkSql = ewrpt_BuildReportSql($sSelect, $customers_deal->SqlWhere(), "", "", $sOrderBy, $this->UserIDFilter, "");
		$customers_deal->dealer->DropDownList = ewrpt_GetDistinctValues("", $wrkSql);

		// Field status
		$sSelect = "SELECT DISTINCT rep.status FROM " . $customers_deal->SqlFrom();
		$sOrderBy = "rep.status ASC";
		$wrkSql = ewrpt_BuildReportSql($sSelect, $customers_deal->SqlWhere(), "", "", $sOrderBy, $this->UserIDFilter, "");
		$customers_deal->status->DropDownList = ewrpt_GetDistinctValues("", $wrkSql);

		// Field date_start
		$sSelect = "SELECT DISTINCT rep.date_start FROM " . $customers_deal->SqlFrom();
		$sOrderBy = "rep.date_start ASC";
		$wrkSql = ewrpt_BuildReportSql($sSelect, $customers_deal->SqlWhere(), "", "", $sOrderBy, $this->UserIDFilter, "");
		$customers_deal->date_start->DropDownList = ewrpt_GetDistinctValues($customers_deal->date_start->DateFilter, $wrkSql);
	}

	// Return extended filter
	function GetExtendedFilter() {
		global $customers_deal;
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
			// Field deal_number

			$this->SetSessionFilterValues($customers_deal->deal_number->SearchValue, $customers_deal->deal_number->SearchOperator, $customers_deal->deal_number->SearchCondition, $customers_deal->deal_number->SearchValue2, $customers_deal->deal_number->SearchOperator2, 'deal_number');

			// Field dealer
			$this->SetSessionDropDownValue($customers_deal->dealer->DropDownValue, 'dealer');

			// Field status
			$this->SetSessionDropDownValue($customers_deal->status->DropDownValue, 'status');

			// Field date_start
			$this->SetSessionDropDownValue($customers_deal->date_start->DropDownValue, 'date_start');
			$bSetupFilter = TRUE;
		} else {

			// Field deal_number
			if ($this->GetFilterValues($customers_deal->deal_number)) {
				$bSetupFilter = TRUE;
				$bRestoreSession = FALSE;
			}

			// Field dealer
			if ($this->GetDropDownValue($customers_deal->dealer->DropDownValue, 'dealer')) {
				$bSetupFilter = TRUE;
				$bRestoreSession = FALSE;
			} elseif ($customers_deal->dealer->DropDownValue <> EWRPT_INIT_VALUE && !isset($_SESSION['sv_customers_deal->dealer'])) {
				$bSetupFilter = TRUE;
			}

			// Field status
			if ($this->GetDropDownValue($customers_deal->status->DropDownValue, 'status')) {
				$bSetupFilter = TRUE;
				$bRestoreSession = FALSE;
			} elseif ($customers_deal->status->DropDownValue <> EWRPT_INIT_VALUE && !isset($_SESSION['sv_customers_deal->status'])) {
				$bSetupFilter = TRUE;
			}

			// Field date_start
			if ($this->GetDropDownValue($customers_deal->date_start->DropDownValue, 'date_start')) {
				$bSetupFilter = TRUE;
				$bRestoreSession = FALSE;
			} elseif ($customers_deal->date_start->DropDownValue <> EWRPT_INIT_VALUE && !isset($_SESSION['sv_customers_deal->date_start'])) {
				$bSetupFilter = TRUE;
			}
			if (!$this->ValidateForm()) {
				$this->setMessage($gsFormError);
				return $sFilter;
			}
		}

		// Restore session
		if ($bRestoreSession) {

			// Field deal_number
			$this->GetSessionFilterValues($customers_deal->deal_number);

			// Field dealer
			$this->GetSessionDropDownValue($customers_deal->dealer);

			// Field status
			$this->GetSessionDropDownValue($customers_deal->status);

			// Field date_start
			$this->GetSessionDropDownValue($customers_deal->date_start);
		}

		// Call page filter validated event
		$customers_deal->Page_FilterValidated();

		// Build SQL
		// Field deal_number

		ewrpt_BuildExtendedFilter($customers_deal->deal_number, $sFilter);

		// Field dealer
		ewrpt_BuildDropDownFilter($customers_deal->dealer, $sFilter, "");

		// Field status
		ewrpt_BuildDropDownFilter($customers_deal->status, $sFilter, "");

		// Field date_start
		ewrpt_BuildDropDownFilter($customers_deal->date_start, $sFilter, $customers_deal->date_start->DateFilter);

		// Save parms to session
		// Field deal_number

		$this->SetSessionFilterValues($customers_deal->deal_number->SearchValue, $customers_deal->deal_number->SearchOperator, $customers_deal->deal_number->SearchCondition, $customers_deal->deal_number->SearchValue2, $customers_deal->deal_number->SearchOperator2, 'deal_number');

		// Field dealer
		$this->SetSessionDropDownValue($customers_deal->dealer->DropDownValue, 'dealer');

		// Field status
		$this->SetSessionDropDownValue($customers_deal->status->DropDownValue, 'status');

		// Field date_start
		$this->SetSessionDropDownValue($customers_deal->date_start->DropDownValue, 'date_start');

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
		$this->GetSessionValue($fld->DropDownValue, 'sv_customers_deal_' . $parm);
	}

	// Get filter values from session
	function GetSessionFilterValues(&$fld) {
		$parm = substr($fld->FldVar, 2);
		$this->GetSessionValue($fld->SearchValue, 'sv1_customers_deal_' . $parm);
		$this->GetSessionValue($fld->SearchOperator, 'so1_customers_deal_' . $parm);
		$this->GetSessionValue($fld->SearchCondition, 'sc_customers_deal_' . $parm);
		$this->GetSessionValue($fld->SearchValue2, 'sv2_customers_deal_' . $parm);
		$this->GetSessionValue($fld->SearchOperator2, 'so2_customers_deal_' . $parm);
	}

	// Get value from session
	function GetSessionValue(&$sv, $sn) {
		if (isset($_SESSION[$sn]))
			$sv = $_SESSION[$sn];
	}

	// Set dropdown value to session
	function SetSessionDropDownValue($sv, $parm) {
		$_SESSION['sv_customers_deal_' . $parm] = $sv;
	}

	// Set filter values to session
	function SetSessionFilterValues($sv1, $so1, $sc, $sv2, $so2, $parm) {
		$_SESSION['sv1_customers_deal_' . $parm] = $sv1;
		$_SESSION['so1_customers_deal_' . $parm] = $so1;
		$_SESSION['sc_customers_deal_' . $parm] = $sc;
		$_SESSION['sv2_customers_deal_' . $parm] = $sv2;
		$_SESSION['so2_customers_deal_' . $parm] = $so2;
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
		global $ReportLanguage, $gsFormError, $customers_deal;

		// Initialize form error message
		$gsFormError = "";

		// Check if validation required
		if (!EWRPT_SERVER_VALIDATE)
			return ($gsFormError == "");
		if (!ewrpt_CheckInteger($customers_deal->deal_number->SearchValue)) {
			if ($gsFormError <> "") $gsFormError .= "<br>";
			$gsFormError .= $customers_deal->deal_number->FldErrMsg();
		}

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
		$_SESSION["sel_customers_deal_$parm"] = "";
		$_SESSION["rf_customers_deal_$parm"] = "";
		$_SESSION["rt_customers_deal_$parm"] = "";
	}

	// Load selection from session
	function LoadSelectionFromSession($parm) {
		global $customers_deal;
		$fld =& $customers_deal->fields($parm);
		$fld->SelectionList = @$_SESSION["sel_customers_deal_$parm"];
		$fld->RangeFrom = @$_SESSION["rf_customers_deal_$parm"];
		$fld->RangeTo = @$_SESSION["rt_customers_deal_$parm"];
	}

	// Load default value for filters
	function LoadDefaultFilters() {
		global $customers_deal;

		/**
		* Set up default values for non Text filters
		*/

		// Field dealer
		$customers_deal->dealer->DefaultDropDownValue = EWRPT_INIT_VALUE;
		$customers_deal->dealer->DropDownValue = $customers_deal->dealer->DefaultDropDownValue;

		// Field status
		$customers_deal->status->DefaultDropDownValue = EWRPT_INIT_VALUE;
		$customers_deal->status->DropDownValue = $customers_deal->status->DefaultDropDownValue;

		// Field date_start
		$customers_deal->date_start->DefaultDropDownValue = EWRPT_INIT_VALUE;
		$customers_deal->date_start->DropDownValue = $customers_deal->date_start->DefaultDropDownValue;

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

		// Field deal_number
		$this->SetDefaultExtFilter($customers_deal->deal_number, "=", NULL, 'AND', "=", NULL);
		$this->ApplyDefaultExtFilter($customers_deal->deal_number);

		/**
		* Set up default values for popup filters
		*/
	}

	// Check if filter applied
	function CheckFilter() {
		global $customers_deal;

		// Check deal_number text filter
		if ($this->TextFilterApplied($customers_deal->deal_number))
			return TRUE;

		// Check dealer extended filter
		if ($this->NonTextFilterApplied($customers_deal->dealer))
			return TRUE;

		// Check status extended filter
		if ($this->NonTextFilterApplied($customers_deal->status))
			return TRUE;

		// Check date_start extended filter
		if ($this->NonTextFilterApplied($customers_deal->date_start))
			return TRUE;
		return FALSE;
	}

	// Show list of filters
	function ShowFilterList() {
		global $customers_deal;
		global $ReportLanguage;

		// Initialize
		$sFilterList = "";

		// Field deal_number
		$sExtWrk = "";
		$sWrk = "";
		ewrpt_BuildExtendedFilter($customers_deal->deal_number, $sExtWrk);
		if ($sExtWrk <> "" || $sWrk <> "")
			$sFilterList .= $customers_deal->deal_number->FldCaption() . "<br>";
		if ($sExtWrk <> "")
			$sFilterList .= "&nbsp;&nbsp;$sExtWrk<br>";
		if ($sWrk <> "")
			$sFilterList .= "&nbsp;&nbsp;$sWrk<br>";

		// Field dealer
		$sExtWrk = "";
		$sWrk = "";
		ewrpt_BuildDropDownFilter($customers_deal->dealer, $sExtWrk, "");
		if ($sExtWrk <> "" || $sWrk <> "")
			$sFilterList .= $customers_deal->dealer->FldCaption() . "<br>";
		if ($sExtWrk <> "")
			$sFilterList .= "&nbsp;&nbsp;$sExtWrk<br>";
		if ($sWrk <> "")
			$sFilterList .= "&nbsp;&nbsp;$sWrk<br>";

		// Field status
		$sExtWrk = "";
		$sWrk = "";
		ewrpt_BuildDropDownFilter($customers_deal->status, $sExtWrk, "");
		if ($sExtWrk <> "" || $sWrk <> "")
			$sFilterList .= $customers_deal->status->FldCaption() . "<br>";
		if ($sExtWrk <> "")
			$sFilterList .= "&nbsp;&nbsp;$sExtWrk<br>";
		if ($sWrk <> "")
			$sFilterList .= "&nbsp;&nbsp;$sWrk<br>";

		// Field date_start
		$sExtWrk = "";
		$sWrk = "";
		ewrpt_BuildDropDownFilter($customers_deal->date_start, $sExtWrk, $customers_deal->date_start->DateFilter);
		if ($sExtWrk <> "" || $sWrk <> "")
			$sFilterList .= $customers_deal->date_start->FldCaption() . "<br>";
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
		global $customers_deal;
		$sWrk = "";
		return $sWrk;
	}

	//-------------------------------------------------------------------------------
	// Function GetSort
	// - Return Sort parameters based on Sort Links clicked
	// - Variables setup: Session[EWRPT_TABLE_SESSION_ORDER_BY], Session["sort_Table_Field"]
	function GetSort() {
		global $customers_deal;

		// Check for a resetsort command
		if (strlen(@$_GET["cmd"]) > 0) {
			$sCmd = @$_GET["cmd"];
			if ($sCmd == "resetsort") {
				$customers_deal->setOrderBy("");
				$customers_deal->setStartGroup(1);
				$customers_deal->deal_number->setSort("");
				$customers_deal->salesman->setSort("");
				$customers_deal->customer->setSort("");
				$customers_deal->idno->setSort("");
				$customers_deal->status->setSort("");
				$customers_deal->date_start->setSort("");
				$customers_deal->NotTakenUpReason_cd->setSort("");
				$customers_deal->product_name->setSort("");
				$customers_deal->total_premium->setSort("");
				$customers_deal->commission->setSort("");
				$customers_deal->rep2Etotal_premium_2D_rep2Ecommission->setSort("");
				$customers_deal->Description->setSort("");
				$customers_deal->Format28car22EAmount2C_229->setSort("");
			}

		// Check for an Order parameter
		} elseif (@$_GET["order"] <> "") {
			$customers_deal->CurrentOrder = ewrpt_StripSlashes(@$_GET["order"]);
			$customers_deal->CurrentOrderType = @$_GET["ordertype"];
			$sSortSql = $customers_deal->SortSql();
			$customers_deal->setOrderBy($sSortSql);
			$customers_deal->setStartGroup(1);
		}
		return $customers_deal->getOrderBy();
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
