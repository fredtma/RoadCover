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
$reportPerDealerPerSalesman = NULL;

//
// Table class for reportPerDealerPerSalesman
//
class crreportPerDealerPerSalesman {
	var $TableVar = 'reportPerDealerPerSalesman';
	var $TableName = 'reportPerDealerPerSalesman';
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
	var $Code;
	var $Salesman;
	var $DateCreated;
	var $Fullname;
	var $Quote_Status;
	var $Period;
	var $Collection_Method;
	var $Dealer;
	var $Salesman_ID;
	var $Customer_ID2FCompany_Reg;
	var $Status;
	var $Amount;
	var $TotalAmount;
	var $_28quot2ETotalAmount_2D_res2EAmount29;
	var $Deal_Number;
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
	function crreportPerDealerPerSalesman() {
		global $ReportLanguage;

		// Code
		$this->Code = new crField('reportPerDealerPerSalesman', 'reportPerDealerPerSalesman', 'x_Code', 'Code', 'dealer.Id', 3, EWRPT_DATATYPE_NUMBER, -1);
		$this->Code->FldDefaultErrMsg = $ReportLanguage->Phrase("IncorrectInteger");
		$this->fields['Code'] =& $this->Code;
		$this->Code->DateFilter = "";
		$this->Code->SqlSelect = "";
		$this->Code->SqlOrderBy = "";

		// Salesman
		$this->Salesman = new crField('reportPerDealerPerSalesman', 'reportPerDealerPerSalesman', 'x_Salesman', 'Salesman', 'Concat(agent.FullNames, \' \', agent.Surname)', 200, EWRPT_DATATYPE_STRING, -1);
		$this->fields['Salesman'] =& $this->Salesman;
		$this->Salesman->DateFilter = "";
		$this->Salesman->SqlSelect = "";
		$this->Salesman->SqlOrderBy = "";

		// DateCreated
		$this->DateCreated = new crField('reportPerDealerPerSalesman', 'reportPerDealerPerSalesman', 'x_DateCreated', 'DateCreated', 'trans.DateCreated', 135, EWRPT_DATATYPE_DATE, 7);
		$this->DateCreated->FldDefaultErrMsg = str_replace("%s", "-", $ReportLanguage->Phrase("IncorrectDateDMY"));
		$this->fields['DateCreated'] =& $this->DateCreated;
		$this->DateCreated->DateFilter = "";
		$this->DateCreated->SqlSelect = "";
		$this->DateCreated->SqlOrderBy = "";

		// Fullname
		$this->Fullname = new crField('reportPerDealerPerSalesman', 'reportPerDealerPerSalesman', 'x_Fullname', 'Fullname', 'If(member.Surname != \'\', Concat(member.FullNames, \' \', member.Surname), Concat(\'[Company]: \', member.Name))', 200, EWRPT_DATATYPE_STRING, -1);
		$this->fields['Fullname'] =& $this->Fullname;
		$this->Fullname->DateFilter = "";
		$this->Fullname->SqlSelect = "";
		$this->Fullname->SqlOrderBy = "";

		// Quote Status
		$this->Quote_Status = new crField('reportPerDealerPerSalesman', 'reportPerDealerPerSalesman', 'x_Quote_Status', 'Quote Status', '`Quote Status`', 200, EWRPT_DATATYPE_STRING, -1);
		$this->fields['Quote_Status'] =& $this->Quote_Status;
		$this->Quote_Status->DateFilter = "";
		$this->Quote_Status->SqlSelect = "";
		$this->Quote_Status->SqlOrderBy = "";

		// Period
		$this->Period = new crField('reportPerDealerPerSalesman', 'reportPerDealerPerSalesman', 'x_Period', 'Period', 'quot.Period_cd', 200, EWRPT_DATATYPE_STRING, -1);
		$this->fields['Period'] =& $this->Period;
		$this->Period->DateFilter = "";
		$this->Period->SqlSelect = "";
		$this->Period->SqlOrderBy = "";

		// Collection Method
		$this->Collection_Method = new crField('reportPerDealerPerSalesman', 'reportPerDealerPerSalesman', 'x_Collection_Method', 'Collection Method', '`Collection Method`', 200, EWRPT_DATATYPE_STRING, -1);
		$this->fields['Collection_Method'] =& $this->Collection_Method;
		$this->Collection_Method->DateFilter = "";
		$this->Collection_Method->SqlSelect = "";
		$this->Collection_Method->SqlOrderBy = "";

		// Dealer
		$this->Dealer = new crField('reportPerDealerPerSalesman', 'reportPerDealerPerSalesman', 'x_Dealer', 'Dealer', 'dealer.Name', 200, EWRPT_DATATYPE_STRING, -1);
		$this->fields['Dealer'] =& $this->Dealer;
		$this->Dealer->DateFilter = "";
		$this->Dealer->SqlSelect = "";
		$this->Dealer->SqlOrderBy = "";

		// Salesman ID
		$this->Salesman_ID = new crField('reportPerDealerPerSalesman', 'reportPerDealerPerSalesman', 'x_Salesman_ID', 'Salesman ID', '`Salesman ID`', 200, EWRPT_DATATYPE_STRING, -1);
		$this->fields['Salesman_ID'] =& $this->Salesman_ID;
		$this->Salesman_ID->DateFilter = "";
		$this->Salesman_ID->SqlSelect = "";
		$this->Salesman_ID->SqlOrderBy = "";

		// Customer ID/Company Reg
		$this->Customer_ID2FCompany_Reg = new crField('reportPerDealerPerSalesman', 'reportPerDealerPerSalesman', 'x_Customer_ID2FCompany_Reg', 'Customer ID/Company Reg', '`Customer ID/Company Reg`', 200, EWRPT_DATATYPE_STRING, -1);
		$this->fields['Customer_ID2FCompany_Reg'] =& $this->Customer_ID2FCompany_Reg;
		$this->Customer_ID2FCompany_Reg->DateFilter = "";
		$this->Customer_ID2FCompany_Reg->SqlSelect = "";
		$this->Customer_ID2FCompany_Reg->SqlOrderBy = "";

		// Status
		$this->Status = new crField('reportPerDealerPerSalesman', 'reportPerDealerPerSalesman', 'x_Status', 'Status', 'trans.Status', 200, EWRPT_DATATYPE_STRING, -1);
		$this->fields['Status'] =& $this->Status;
		$this->Status->DateFilter = "";
		$this->Status->SqlSelect = "";
		$this->Status->SqlOrderBy = "";

		// Amount
		$this->Amount = new crField('reportPerDealerPerSalesman', 'reportPerDealerPerSalesman', 'x_Amount', 'Amount', 'res.Amount', 4, EWRPT_DATATYPE_NUMBER, -1);
		$this->Amount->FldDefaultErrMsg = $ReportLanguage->Phrase("IncorrectFloat");
		$this->fields['Amount'] =& $this->Amount;
		$this->Amount->DateFilter = "";
		$this->Amount->SqlSelect = "";
		$this->Amount->SqlOrderBy = "";

		// TotalAmount
		$this->TotalAmount = new crField('reportPerDealerPerSalesman', 'reportPerDealerPerSalesman', 'x_TotalAmount', 'TotalAmount', 'quot.TotalAmount', 4, EWRPT_DATATYPE_NUMBER, -1);
		$this->TotalAmount->FldDefaultErrMsg = $ReportLanguage->Phrase("IncorrectFloat");
		$this->fields['TotalAmount'] =& $this->TotalAmount;
		$this->TotalAmount->DateFilter = "";
		$this->TotalAmount->SqlSelect = "";
		$this->TotalAmount->SqlOrderBy = "";

		// (quot.TotalAmount - res.Amount)
		$this->_28quot2ETotalAmount_2D_res2EAmount29 = new crField('reportPerDealerPerSalesman', 'reportPerDealerPerSalesman', 'x__28quot2ETotalAmount_2D_res2EAmount29', '(quot.TotalAmount - res.Amount)', '`(quot.TotalAmount - res.Amount)`', 5, EWRPT_DATATYPE_NUMBER, -1);
		$this->_28quot2ETotalAmount_2D_res2EAmount29->FldDefaultErrMsg = $ReportLanguage->Phrase("IncorrectFloat");
		$this->fields['_28quot2ETotalAmount_2D_res2EAmount29'] =& $this->_28quot2ETotalAmount_2D_res2EAmount29;
		$this->_28quot2ETotalAmount_2D_res2EAmount29->DateFilter = "";
		$this->_28quot2ETotalAmount_2D_res2EAmount29->SqlSelect = "";
		$this->_28quot2ETotalAmount_2D_res2EAmount29->SqlOrderBy = "";

		// Deal Number
		$this->Deal_Number = new crField('reportPerDealerPerSalesman', 'reportPerDealerPerSalesman', 'x_Deal_Number', 'Deal Number', '`Deal Number`', 3, EWRPT_DATATYPE_NUMBER, -1);
		$this->Deal_Number->FldDefaultErrMsg = $ReportLanguage->Phrase("IncorrectInteger");
		$this->fields['Deal_Number'] =& $this->Deal_Number;
		$this->Deal_Number->DateFilter = "";
		$this->Deal_Number->SqlSelect = "";
		$this->Deal_Number->SqlOrderBy = "";
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
		return "road_FandI agent Inner Join road_Transactions trans On trans.FandI = agent.Id Inner Join road_Holder member On member.Id = trans.Holder Inner Join road_Intermediary dealer On dealer.Id = trans.Intermediary Left Join road_QuoteTransactions quot On quot.transaction = trans.Id Left Join road_QuoteResultItems res On res.QuoteResult = quot.Id And res.PremiumType_cd = 'Commission'";
	}

	function SqlSelect() { // Select
		return "SELECT dealer.Name As Dealer, dealer.Id As Code, Concat(agent.FullNames, ' ', agent.Surname) As Salesman, agent.IdentificationNumber As \"Salesman ID\", trans.DateCreated, If(member.Surname != '', Concat(member.FullNames, ' ', member.Surname), Concat('[Company]: ', member.Name)) As Fullname, If(member.IdentificationNumber != '', member.IdentificationNumber, member.RegistrationNumber) As \"Customer ID/Company Reg\", trans.Status, quot.Status As \"Quote Status\", quot.Period_cd Period, quot.CollectionMethod_cd \"Collection Method\", res.Amount, quot.TotalAmount, (quot.TotalAmount - res.Amount), trans.Id as \"Deal Number\" FROM " . $this->SqlFrom();
	}

	function SqlWhere() { // Where
		return "";
	}

	function SqlGroupBy() { // Group By
		return "trans.Id";
	}

	function SqlHaving() { // Having
		return "";
	}

	function SqlOrderBy() { // Order By
		return "dealer.Name, Salesman";
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
$reportPerDealerPerSalesman_rpt = new crreportPerDealerPerSalesman_rpt();
$Page =& $reportPerDealerPerSalesman_rpt;

// Page init
$reportPerDealerPerSalesman_rpt->Page_Init();

// Page main
$reportPerDealerPerSalesman_rpt->Page_Main();
?>
<?php include_once "phprptinc/header.php"; ?>
<?php if ($reportPerDealerPerSalesman->Export == "" || $reportPerDealerPerSalesman->Export == "print" || $reportPerDealerPerSalesman->Export == "email") { ?>
<script type="text/javascript">

// Create page object
var reportPerDealerPerSalesman_rpt = new ewrpt_Page("reportPerDealerPerSalesman_rpt");

// page properties
reportPerDealerPerSalesman_rpt.PageID = "rpt"; // page ID
reportPerDealerPerSalesman_rpt.FormID = "freportPerDealerPerSalesmanrptfilter"; // form ID
var EWRPT_PAGE_ID = reportPerDealerPerSalesman_rpt.PageID;

// extend page with Chart_Rendering function
reportPerDealerPerSalesman_rpt.Chart_Rendering =  
 function(chart, chartid) { // DO NOT CHANGE THIS LINE!

 	//alert(chartid);
 }

// extend page with Chart_Rendered function
reportPerDealerPerSalesman_rpt.Chart_Rendered =  
 function(chart, chartid) { // DO NOT CHANGE THIS LINE!

 	//alert(chartid);
 }
</script>
<?php } ?>
<?php if ($reportPerDealerPerSalesman->Export == "") { ?>
<script language="JavaScript" type="text/javascript">
<!--

// Write your client script here, no need to add script tags.
//-->

</script>
<?php } ?>
<?php if ($reportPerDealerPerSalesman->Export == "" || $reportPerDealerPerSalesman->Export == "print" || $reportPerDealerPerSalesman->Export == "email") { ?>
<script src="<?php echo EWRPT_FUSIONCHARTS_FREE_JSCLASS_FILE; ?>" type="text/javascript"></script>
<?php } ?>
<?php if ($reportPerDealerPerSalesman->Export == "") { ?>
<div id="ewrpt_PopupFilter"><div class="bd"></div></div>
<script src="phprptjs/ewrptpop.js" type="text/javascript"></script>
<script type="text/javascript">

// popup fields
</script>
<?php } ?>
<?php if ($reportPerDealerPerSalesman->Export == "" || $reportPerDealerPerSalesman->Export == "print" || $reportPerDealerPerSalesman->Export == "email") { ?>
<!-- Table Container (Begin) -->
<table id="ewContainer" cellspacing="0" cellpadding="0" border="0">
<!-- Top Container (Begin) -->
<tr><td colspan="3"><div id="ewTop" class="phpreportmaker">
<!-- top slot -->
<a name="top"></a>
<?php } ?>
<p class="phpreportmaker ewTitle"><?php echo $reportPerDealerPerSalesman->TableCaption() ?>
&nbsp;&nbsp;<?php $reportPerDealerPerSalesman_rpt->ExportOptions->Render("body"); ?></p>
<?php $reportPerDealerPerSalesman_rpt->ShowPageHeader(); ?>
<?php $reportPerDealerPerSalesman_rpt->ShowMessage(); ?>
<br><br>
<?php if ($reportPerDealerPerSalesman->Export == "" || $reportPerDealerPerSalesman->Export == "print" || $reportPerDealerPerSalesman->Export == "email") { ?>
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
<table class="<?php echo $reportPerDealerPerSalesman_rpt->ReportTableClass ?>" cellspacing="0">
<?php

// Set the last group to display if not export all
if ($reportPerDealerPerSalesman->ExportAll && $reportPerDealerPerSalesman->Export <> "") {
	$reportPerDealerPerSalesman_rpt->StopGrp = $reportPerDealerPerSalesman_rpt->TotalGrps;
} else {
	$reportPerDealerPerSalesman_rpt->StopGrp = $reportPerDealerPerSalesman_rpt->StartGrp + $reportPerDealerPerSalesman_rpt->DisplayGrps - 1;
}

// Stop group <= total number of groups
if (intval($reportPerDealerPerSalesman_rpt->StopGrp) > intval($reportPerDealerPerSalesman_rpt->TotalGrps))
	$reportPerDealerPerSalesman_rpt->StopGrp = $reportPerDealerPerSalesman_rpt->TotalGrps;
$reportPerDealerPerSalesman_rpt->RecCount = 0;

// Get first row
if ($reportPerDealerPerSalesman_rpt->TotalGrps > 0) {
	$reportPerDealerPerSalesman_rpt->GetRow(1);
	$reportPerDealerPerSalesman_rpt->GrpCount = 1;
}
while (($rs && !$rs->EOF && $reportPerDealerPerSalesman_rpt->GrpCount <= $reportPerDealerPerSalesman_rpt->DisplayGrps) || $reportPerDealerPerSalesman_rpt->ShowFirstHeader) {

	// Show header
	if ($reportPerDealerPerSalesman_rpt->ShowFirstHeader) {
?>
	<thead>
	<tr>
<td class="ewTableHeader">
<?php if ($reportPerDealerPerSalesman->Export <> "") { ?>
<?php echo $reportPerDealerPerSalesman->Code->FldCaption() ?>
<?php } else { ?>
	<table cellspacing="0" class="ewTableHeaderBtn"><tr>
<?php if ($reportPerDealerPerSalesman->SortUrl($reportPerDealerPerSalesman->Code) == "") { ?>
		<td style="vertical-align: bottom;"><?php echo $reportPerDealerPerSalesman->Code->FldCaption() ?></td>
<?php } else { ?>
		<td class="ewPointer" onmousedown="ewrpt_Sort(event,'<?php echo $reportPerDealerPerSalesman->SortUrl($reportPerDealerPerSalesman->Code) ?>',0);"><?php echo $reportPerDealerPerSalesman->Code->FldCaption() ?></td><td style="width: 10px;">
		<?php if ($reportPerDealerPerSalesman->Code->getSort() == "ASC") { ?><img src="phprptimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($reportPerDealerPerSalesman->Code->getSort() == "DESC") { ?><img src="phprptimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td>
<?php } ?>
	</tr></table>
<?php } ?>
</td>
<td class="ewTableHeader">
<?php if ($reportPerDealerPerSalesman->Export <> "") { ?>
<?php echo $reportPerDealerPerSalesman->Salesman->FldCaption() ?>
<?php } else { ?>
	<table cellspacing="0" class="ewTableHeaderBtn"><tr>
<?php if ($reportPerDealerPerSalesman->SortUrl($reportPerDealerPerSalesman->Salesman) == "") { ?>
		<td style="vertical-align: bottom;"><?php echo $reportPerDealerPerSalesman->Salesman->FldCaption() ?></td>
<?php } else { ?>
		<td class="ewPointer" onmousedown="ewrpt_Sort(event,'<?php echo $reportPerDealerPerSalesman->SortUrl($reportPerDealerPerSalesman->Salesman) ?>',0);"><?php echo $reportPerDealerPerSalesman->Salesman->FldCaption() ?></td><td style="width: 10px;">
		<?php if ($reportPerDealerPerSalesman->Salesman->getSort() == "ASC") { ?><img src="phprptimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($reportPerDealerPerSalesman->Salesman->getSort() == "DESC") { ?><img src="phprptimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td>
<?php } ?>
	</tr></table>
<?php } ?>
</td>
<td class="ewTableHeader">
<?php if ($reportPerDealerPerSalesman->Export <> "") { ?>
<?php echo $reportPerDealerPerSalesman->DateCreated->FldCaption() ?>
<?php } else { ?>
	<table cellspacing="0" class="ewTableHeaderBtn"><tr>
<?php if ($reportPerDealerPerSalesman->SortUrl($reportPerDealerPerSalesman->DateCreated) == "") { ?>
		<td style="vertical-align: bottom;"><?php echo $reportPerDealerPerSalesman->DateCreated->FldCaption() ?></td>
<?php } else { ?>
		<td class="ewPointer" onmousedown="ewrpt_Sort(event,'<?php echo $reportPerDealerPerSalesman->SortUrl($reportPerDealerPerSalesman->DateCreated) ?>',0);"><?php echo $reportPerDealerPerSalesman->DateCreated->FldCaption() ?></td><td style="width: 10px;">
		<?php if ($reportPerDealerPerSalesman->DateCreated->getSort() == "ASC") { ?><img src="phprptimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($reportPerDealerPerSalesman->DateCreated->getSort() == "DESC") { ?><img src="phprptimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td>
<?php } ?>
	</tr></table>
<?php } ?>
</td>
<td class="ewTableHeader">
<?php if ($reportPerDealerPerSalesman->Export <> "") { ?>
<?php echo $reportPerDealerPerSalesman->Fullname->FldCaption() ?>
<?php } else { ?>
	<table cellspacing="0" class="ewTableHeaderBtn"><tr>
<?php if ($reportPerDealerPerSalesman->SortUrl($reportPerDealerPerSalesman->Fullname) == "") { ?>
		<td style="vertical-align: bottom;"><?php echo $reportPerDealerPerSalesman->Fullname->FldCaption() ?></td>
<?php } else { ?>
		<td class="ewPointer" onmousedown="ewrpt_Sort(event,'<?php echo $reportPerDealerPerSalesman->SortUrl($reportPerDealerPerSalesman->Fullname) ?>',0);"><?php echo $reportPerDealerPerSalesman->Fullname->FldCaption() ?></td><td style="width: 10px;">
		<?php if ($reportPerDealerPerSalesman->Fullname->getSort() == "ASC") { ?><img src="phprptimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($reportPerDealerPerSalesman->Fullname->getSort() == "DESC") { ?><img src="phprptimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td>
<?php } ?>
	</tr></table>
<?php } ?>
</td>
<td class="ewTableHeader">
<?php if ($reportPerDealerPerSalesman->Export <> "") { ?>
<?php echo $reportPerDealerPerSalesman->Quote_Status->FldCaption() ?>
<?php } else { ?>
	<table cellspacing="0" class="ewTableHeaderBtn"><tr>
<?php if ($reportPerDealerPerSalesman->SortUrl($reportPerDealerPerSalesman->Quote_Status) == "") { ?>
		<td style="vertical-align: bottom;"><?php echo $reportPerDealerPerSalesman->Quote_Status->FldCaption() ?></td>
<?php } else { ?>
		<td class="ewPointer" onmousedown="ewrpt_Sort(event,'<?php echo $reportPerDealerPerSalesman->SortUrl($reportPerDealerPerSalesman->Quote_Status) ?>',0);"><?php echo $reportPerDealerPerSalesman->Quote_Status->FldCaption() ?></td><td style="width: 10px;">
		<?php if ($reportPerDealerPerSalesman->Quote_Status->getSort() == "ASC") { ?><img src="phprptimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($reportPerDealerPerSalesman->Quote_Status->getSort() == "DESC") { ?><img src="phprptimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td>
<?php } ?>
	</tr></table>
<?php } ?>
</td>
<td class="ewTableHeader">
<?php if ($reportPerDealerPerSalesman->Export <> "") { ?>
<?php echo $reportPerDealerPerSalesman->Period->FldCaption() ?>
<?php } else { ?>
	<table cellspacing="0" class="ewTableHeaderBtn"><tr>
<?php if ($reportPerDealerPerSalesman->SortUrl($reportPerDealerPerSalesman->Period) == "") { ?>
		<td style="vertical-align: bottom;"><?php echo $reportPerDealerPerSalesman->Period->FldCaption() ?></td>
<?php } else { ?>
		<td class="ewPointer" onmousedown="ewrpt_Sort(event,'<?php echo $reportPerDealerPerSalesman->SortUrl($reportPerDealerPerSalesman->Period) ?>',0);"><?php echo $reportPerDealerPerSalesman->Period->FldCaption() ?></td><td style="width: 10px;">
		<?php if ($reportPerDealerPerSalesman->Period->getSort() == "ASC") { ?><img src="phprptimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($reportPerDealerPerSalesman->Period->getSort() == "DESC") { ?><img src="phprptimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td>
<?php } ?>
	</tr></table>
<?php } ?>
</td>
<td class="ewTableHeader">
<?php if ($reportPerDealerPerSalesman->Export <> "") { ?>
<?php echo $reportPerDealerPerSalesman->Collection_Method->FldCaption() ?>
<?php } else { ?>
	<table cellspacing="0" class="ewTableHeaderBtn"><tr>
<?php if ($reportPerDealerPerSalesman->SortUrl($reportPerDealerPerSalesman->Collection_Method) == "") { ?>
		<td style="vertical-align: bottom;"><?php echo $reportPerDealerPerSalesman->Collection_Method->FldCaption() ?></td>
<?php } else { ?>
		<td class="ewPointer" onmousedown="ewrpt_Sort(event,'<?php echo $reportPerDealerPerSalesman->SortUrl($reportPerDealerPerSalesman->Collection_Method) ?>',0);"><?php echo $reportPerDealerPerSalesman->Collection_Method->FldCaption() ?></td><td style="width: 10px;">
		<?php if ($reportPerDealerPerSalesman->Collection_Method->getSort() == "ASC") { ?><img src="phprptimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($reportPerDealerPerSalesman->Collection_Method->getSort() == "DESC") { ?><img src="phprptimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td>
<?php } ?>
	</tr></table>
<?php } ?>
</td>
<td class="ewTableHeader">
<?php if ($reportPerDealerPerSalesman->Export <> "") { ?>
<?php echo $reportPerDealerPerSalesman->Dealer->FldCaption() ?>
<?php } else { ?>
	<table cellspacing="0" class="ewTableHeaderBtn"><tr>
<?php if ($reportPerDealerPerSalesman->SortUrl($reportPerDealerPerSalesman->Dealer) == "") { ?>
		<td style="vertical-align: bottom;"><?php echo $reportPerDealerPerSalesman->Dealer->FldCaption() ?></td>
<?php } else { ?>
		<td class="ewPointer" onmousedown="ewrpt_Sort(event,'<?php echo $reportPerDealerPerSalesman->SortUrl($reportPerDealerPerSalesman->Dealer) ?>',0);"><?php echo $reportPerDealerPerSalesman->Dealer->FldCaption() ?></td><td style="width: 10px;">
		<?php if ($reportPerDealerPerSalesman->Dealer->getSort() == "ASC") { ?><img src="phprptimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($reportPerDealerPerSalesman->Dealer->getSort() == "DESC") { ?><img src="phprptimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td>
<?php } ?>
	</tr></table>
<?php } ?>
</td>
<td class="ewTableHeader">
<?php if ($reportPerDealerPerSalesman->Export <> "") { ?>
<?php echo $reportPerDealerPerSalesman->Salesman_ID->FldCaption() ?>
<?php } else { ?>
	<table cellspacing="0" class="ewTableHeaderBtn"><tr>
<?php if ($reportPerDealerPerSalesman->SortUrl($reportPerDealerPerSalesman->Salesman_ID) == "") { ?>
		<td style="vertical-align: bottom;"><?php echo $reportPerDealerPerSalesman->Salesman_ID->FldCaption() ?></td>
<?php } else { ?>
		<td class="ewPointer" onmousedown="ewrpt_Sort(event,'<?php echo $reportPerDealerPerSalesman->SortUrl($reportPerDealerPerSalesman->Salesman_ID) ?>',0);"><?php echo $reportPerDealerPerSalesman->Salesman_ID->FldCaption() ?></td><td style="width: 10px;">
		<?php if ($reportPerDealerPerSalesman->Salesman_ID->getSort() == "ASC") { ?><img src="phprptimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($reportPerDealerPerSalesman->Salesman_ID->getSort() == "DESC") { ?><img src="phprptimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td>
<?php } ?>
	</tr></table>
<?php } ?>
</td>
<td class="ewTableHeader">
<?php if ($reportPerDealerPerSalesman->Export <> "") { ?>
<?php echo $reportPerDealerPerSalesman->Customer_ID2FCompany_Reg->FldCaption() ?>
<?php } else { ?>
	<table cellspacing="0" class="ewTableHeaderBtn"><tr>
<?php if ($reportPerDealerPerSalesman->SortUrl($reportPerDealerPerSalesman->Customer_ID2FCompany_Reg) == "") { ?>
		<td style="vertical-align: bottom;"><?php echo $reportPerDealerPerSalesman->Customer_ID2FCompany_Reg->FldCaption() ?></td>
<?php } else { ?>
		<td class="ewPointer" onmousedown="ewrpt_Sort(event,'<?php echo $reportPerDealerPerSalesman->SortUrl($reportPerDealerPerSalesman->Customer_ID2FCompany_Reg) ?>',0);"><?php echo $reportPerDealerPerSalesman->Customer_ID2FCompany_Reg->FldCaption() ?></td><td style="width: 10px;">
		<?php if ($reportPerDealerPerSalesman->Customer_ID2FCompany_Reg->getSort() == "ASC") { ?><img src="phprptimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($reportPerDealerPerSalesman->Customer_ID2FCompany_Reg->getSort() == "DESC") { ?><img src="phprptimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td>
<?php } ?>
	</tr></table>
<?php } ?>
</td>
<td class="ewTableHeader">
<?php if ($reportPerDealerPerSalesman->Export <> "") { ?>
<?php echo $reportPerDealerPerSalesman->Status->FldCaption() ?>
<?php } else { ?>
	<table cellspacing="0" class="ewTableHeaderBtn"><tr>
<?php if ($reportPerDealerPerSalesman->SortUrl($reportPerDealerPerSalesman->Status) == "") { ?>
		<td style="vertical-align: bottom;"><?php echo $reportPerDealerPerSalesman->Status->FldCaption() ?></td>
<?php } else { ?>
		<td class="ewPointer" onmousedown="ewrpt_Sort(event,'<?php echo $reportPerDealerPerSalesman->SortUrl($reportPerDealerPerSalesman->Status) ?>',0);"><?php echo $reportPerDealerPerSalesman->Status->FldCaption() ?></td><td style="width: 10px;">
		<?php if ($reportPerDealerPerSalesman->Status->getSort() == "ASC") { ?><img src="phprptimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($reportPerDealerPerSalesman->Status->getSort() == "DESC") { ?><img src="phprptimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td>
<?php } ?>
	</tr></table>
<?php } ?>
</td>
<td class="ewTableHeader">
<?php if ($reportPerDealerPerSalesman->Export <> "") { ?>
<?php echo $reportPerDealerPerSalesman->Amount->FldCaption() ?>
<?php } else { ?>
	<table cellspacing="0" class="ewTableHeaderBtn"><tr>
<?php if ($reportPerDealerPerSalesman->SortUrl($reportPerDealerPerSalesman->Amount) == "") { ?>
		<td style="vertical-align: bottom;"><?php echo $reportPerDealerPerSalesman->Amount->FldCaption() ?></td>
<?php } else { ?>
		<td class="ewPointer" onmousedown="ewrpt_Sort(event,'<?php echo $reportPerDealerPerSalesman->SortUrl($reportPerDealerPerSalesman->Amount) ?>',0);"><?php echo $reportPerDealerPerSalesman->Amount->FldCaption() ?></td><td style="width: 10px;">
		<?php if ($reportPerDealerPerSalesman->Amount->getSort() == "ASC") { ?><img src="phprptimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($reportPerDealerPerSalesman->Amount->getSort() == "DESC") { ?><img src="phprptimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td>
<?php } ?>
	</tr></table>
<?php } ?>
</td>
<td class="ewTableHeader">
<?php if ($reportPerDealerPerSalesman->Export <> "") { ?>
<?php echo $reportPerDealerPerSalesman->TotalAmount->FldCaption() ?>
<?php } else { ?>
	<table cellspacing="0" class="ewTableHeaderBtn"><tr>
<?php if ($reportPerDealerPerSalesman->SortUrl($reportPerDealerPerSalesman->TotalAmount) == "") { ?>
		<td style="vertical-align: bottom;"><?php echo $reportPerDealerPerSalesman->TotalAmount->FldCaption() ?></td>
<?php } else { ?>
		<td class="ewPointer" onmousedown="ewrpt_Sort(event,'<?php echo $reportPerDealerPerSalesman->SortUrl($reportPerDealerPerSalesman->TotalAmount) ?>',0);"><?php echo $reportPerDealerPerSalesman->TotalAmount->FldCaption() ?></td><td style="width: 10px;">
		<?php if ($reportPerDealerPerSalesman->TotalAmount->getSort() == "ASC") { ?><img src="phprptimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($reportPerDealerPerSalesman->TotalAmount->getSort() == "DESC") { ?><img src="phprptimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td>
<?php } ?>
	</tr></table>
<?php } ?>
</td>
<td class="ewTableHeader">
<?php if ($reportPerDealerPerSalesman->Export <> "") { ?>
<?php echo $reportPerDealerPerSalesman->_28quot2ETotalAmount_2D_res2EAmount29->FldCaption() ?>
<?php } else { ?>
	<table cellspacing="0" class="ewTableHeaderBtn"><tr>
<?php if ($reportPerDealerPerSalesman->SortUrl($reportPerDealerPerSalesman->_28quot2ETotalAmount_2D_res2EAmount29) == "") { ?>
		<td style="vertical-align: bottom;"><?php echo $reportPerDealerPerSalesman->_28quot2ETotalAmount_2D_res2EAmount29->FldCaption() ?></td>
<?php } else { ?>
		<td class="ewPointer" onmousedown="ewrpt_Sort(event,'<?php echo $reportPerDealerPerSalesman->SortUrl($reportPerDealerPerSalesman->_28quot2ETotalAmount_2D_res2EAmount29) ?>',0);"><?php echo $reportPerDealerPerSalesman->_28quot2ETotalAmount_2D_res2EAmount29->FldCaption() ?></td><td style="width: 10px;">
		<?php if ($reportPerDealerPerSalesman->_28quot2ETotalAmount_2D_res2EAmount29->getSort() == "ASC") { ?><img src="phprptimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($reportPerDealerPerSalesman->_28quot2ETotalAmount_2D_res2EAmount29->getSort() == "DESC") { ?><img src="phprptimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td>
<?php } ?>
	</tr></table>
<?php } ?>
</td>
<td class="ewTableHeader">
<?php if ($reportPerDealerPerSalesman->Export <> "") { ?>
<?php echo $reportPerDealerPerSalesman->Deal_Number->FldCaption() ?>
<?php } else { ?>
	<table cellspacing="0" class="ewTableHeaderBtn"><tr>
<?php if ($reportPerDealerPerSalesman->SortUrl($reportPerDealerPerSalesman->Deal_Number) == "") { ?>
		<td style="vertical-align: bottom;"><?php echo $reportPerDealerPerSalesman->Deal_Number->FldCaption() ?></td>
<?php } else { ?>
		<td class="ewPointer" onmousedown="ewrpt_Sort(event,'<?php echo $reportPerDealerPerSalesman->SortUrl($reportPerDealerPerSalesman->Deal_Number) ?>',0);"><?php echo $reportPerDealerPerSalesman->Deal_Number->FldCaption() ?></td><td style="width: 10px;">
		<?php if ($reportPerDealerPerSalesman->Deal_Number->getSort() == "ASC") { ?><img src="phprptimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($reportPerDealerPerSalesman->Deal_Number->getSort() == "DESC") { ?><img src="phprptimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td>
<?php } ?>
	</tr></table>
<?php } ?>
</td>
	</tr>
	</thead>
	<tbody>
<?php
		$reportPerDealerPerSalesman_rpt->ShowFirstHeader = FALSE;
	}
	$reportPerDealerPerSalesman_rpt->RecCount++;

		// Render detail row
		$reportPerDealerPerSalesman->ResetCSS();
		$reportPerDealerPerSalesman->RowType = EWRPT_ROWTYPE_DETAIL;
		$reportPerDealerPerSalesman_rpt->RenderRow();
?>
	<tr<?php echo $reportPerDealerPerSalesman->RowAttributes(); ?>>
		<td<?php echo $reportPerDealerPerSalesman->Code->CellAttributes() ?>>
<span<?php echo $reportPerDealerPerSalesman->Code->ViewAttributes(); ?>><?php echo $reportPerDealerPerSalesman->Code->ListViewValue(); ?></span></td>
		<td<?php echo $reportPerDealerPerSalesman->Salesman->CellAttributes() ?>>
<span<?php echo $reportPerDealerPerSalesman->Salesman->ViewAttributes(); ?>><?php echo $reportPerDealerPerSalesman->Salesman->ListViewValue(); ?></span></td>
		<td<?php echo $reportPerDealerPerSalesman->DateCreated->CellAttributes() ?>>
<span<?php echo $reportPerDealerPerSalesman->DateCreated->ViewAttributes(); ?>><?php echo $reportPerDealerPerSalesman->DateCreated->ListViewValue(); ?></span></td>
		<td<?php echo $reportPerDealerPerSalesman->Fullname->CellAttributes() ?>>
<span<?php echo $reportPerDealerPerSalesman->Fullname->ViewAttributes(); ?>><?php echo $reportPerDealerPerSalesman->Fullname->ListViewValue(); ?></span></td>
		<td<?php echo $reportPerDealerPerSalesman->Quote_Status->CellAttributes() ?>>
<span<?php echo $reportPerDealerPerSalesman->Quote_Status->ViewAttributes(); ?>><?php echo $reportPerDealerPerSalesman->Quote_Status->ListViewValue(); ?></span></td>
		<td<?php echo $reportPerDealerPerSalesman->Period->CellAttributes() ?>>
<span<?php echo $reportPerDealerPerSalesman->Period->ViewAttributes(); ?>><?php echo $reportPerDealerPerSalesman->Period->ListViewValue(); ?></span></td>
		<td<?php echo $reportPerDealerPerSalesman->Collection_Method->CellAttributes() ?>>
<span<?php echo $reportPerDealerPerSalesman->Collection_Method->ViewAttributes(); ?>><?php echo $reportPerDealerPerSalesman->Collection_Method->ListViewValue(); ?></span></td>
		<td<?php echo $reportPerDealerPerSalesman->Dealer->CellAttributes() ?>>
<span<?php echo $reportPerDealerPerSalesman->Dealer->ViewAttributes(); ?>><?php echo $reportPerDealerPerSalesman->Dealer->ListViewValue(); ?></span></td>
		<td<?php echo $reportPerDealerPerSalesman->Salesman_ID->CellAttributes() ?>>
<span<?php echo $reportPerDealerPerSalesman->Salesman_ID->ViewAttributes(); ?>><?php echo $reportPerDealerPerSalesman->Salesman_ID->ListViewValue(); ?></span></td>
		<td<?php echo $reportPerDealerPerSalesman->Customer_ID2FCompany_Reg->CellAttributes() ?>>
<span<?php echo $reportPerDealerPerSalesman->Customer_ID2FCompany_Reg->ViewAttributes(); ?>><?php echo $reportPerDealerPerSalesman->Customer_ID2FCompany_Reg->ListViewValue(); ?></span></td>
		<td<?php echo $reportPerDealerPerSalesman->Status->CellAttributes() ?>>
<span<?php echo $reportPerDealerPerSalesman->Status->ViewAttributes(); ?>><?php echo $reportPerDealerPerSalesman->Status->ListViewValue(); ?></span></td>
		<td<?php echo $reportPerDealerPerSalesman->Amount->CellAttributes() ?>>
<span<?php echo $reportPerDealerPerSalesman->Amount->ViewAttributes(); ?>><?php echo $reportPerDealerPerSalesman->Amount->ListViewValue(); ?></span></td>
		<td<?php echo $reportPerDealerPerSalesman->TotalAmount->CellAttributes() ?>>
<span<?php echo $reportPerDealerPerSalesman->TotalAmount->ViewAttributes(); ?>><?php echo $reportPerDealerPerSalesman->TotalAmount->ListViewValue(); ?></span></td>
		<td<?php echo $reportPerDealerPerSalesman->_28quot2ETotalAmount_2D_res2EAmount29->CellAttributes() ?>>
<span<?php echo $reportPerDealerPerSalesman->_28quot2ETotalAmount_2D_res2EAmount29->ViewAttributes(); ?>><?php echo $reportPerDealerPerSalesman->_28quot2ETotalAmount_2D_res2EAmount29->ListViewValue(); ?></span></td>
		<td<?php echo $reportPerDealerPerSalesman->Deal_Number->CellAttributes() ?>>
<span<?php echo $reportPerDealerPerSalesman->Deal_Number->ViewAttributes(); ?>><?php echo $reportPerDealerPerSalesman->Deal_Number->ListViewValue(); ?></span></td>
	</tr>
<?php

		// Accumulate page summary
		$reportPerDealerPerSalesman_rpt->AccumulateSummary();

		// Get next record
		$reportPerDealerPerSalesman_rpt->GetRow(2);
	$reportPerDealerPerSalesman_rpt->GrpCount++;
} // End while
?>
	</tbody>
	<tfoot>
	</tfoot>
</table>
</div>
<?php if ($reportPerDealerPerSalesman->Export == "") { ?>
<div class="ewGridLowerPanel">
<form action="<?php echo ewrpt_CurrentPage() ?>" name="ewpagerform" id="ewpagerform" class="ewForm">
<table border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td style="white-space: nowrap;">
<?php if (!isset($Pager)) $Pager = new crPrevNextPager($reportPerDealerPerSalesman_rpt->StartGrp, $reportPerDealerPerSalesman_rpt->DisplayGrps, $reportPerDealerPerSalesman_rpt->TotalGrps) ?>
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
	<?php if ($reportPerDealerPerSalesman_rpt->Filter == "0=101") { ?>
	<span class="phpreportmaker"><?php echo $ReportLanguage->Phrase("EnterSearchCriteria") ?></span>
	<?php } else { ?>
	<span class="phpreportmaker"><?php echo $ReportLanguage->Phrase("NoRecord") ?></span>
	<?php } ?>
<?php } ?>
		</td>
<?php if ($reportPerDealerPerSalesman_rpt->TotalGrps > 0) { ?>
		<td style="white-space: nowrap;">&nbsp;&nbsp;&nbsp;&nbsp;</td>
		<td align="right" style="vertical-align: top; white-space: nowrap;"><span class="phpreportmaker"><?php echo $ReportLanguage->Phrase("RecordsPerPage"); ?>&nbsp;
<select name="<?php echo EWRPT_TABLE_GROUP_PER_PAGE; ?>" onchange="this.form.submit();">
<option value="1"<?php if ($reportPerDealerPerSalesman_rpt->DisplayGrps == 1) echo " selected=\"selected\"" ?>>1</option>
<option value="2"<?php if ($reportPerDealerPerSalesman_rpt->DisplayGrps == 2) echo " selected=\"selected\"" ?>>2</option>
<option value="3"<?php if ($reportPerDealerPerSalesman_rpt->DisplayGrps == 3) echo " selected=\"selected\"" ?>>3</option>
<option value="4"<?php if ($reportPerDealerPerSalesman_rpt->DisplayGrps == 4) echo " selected=\"selected\"" ?>>4</option>
<option value="5"<?php if ($reportPerDealerPerSalesman_rpt->DisplayGrps == 5) echo " selected=\"selected\"" ?>>5</option>
<option value="10"<?php if ($reportPerDealerPerSalesman_rpt->DisplayGrps == 10) echo " selected=\"selected\"" ?>>10</option>
<option value="20"<?php if ($reportPerDealerPerSalesman_rpt->DisplayGrps == 20) echo " selected=\"selected\"" ?>>20</option>
<option value="50"<?php if ($reportPerDealerPerSalesman_rpt->DisplayGrps == 50) echo " selected=\"selected\"" ?>>50</option>
<option value="ALL"<?php if ($reportPerDealerPerSalesman->getGroupPerPage() == -1) echo " selected=\"selected\"" ?>><?php echo $ReportLanguage->Phrase("AllRecords") ?></option>
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
<?php if ($reportPerDealerPerSalesman->Export == "" || $reportPerDealerPerSalesman->Export == "print" || $reportPerDealerPerSalesman->Export == "email") { ?>
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
<?php $reportPerDealerPerSalesman_rpt->ShowPageFooter(); ?>
<?php if (EWRPT_DEBUG_ENABLED) echo ewrpt_DebugMsg(); ?>
<?php

// Close recordsets
if ($rsgrp) $rsgrp->Close();
if ($rs) $rs->Close();
?>
<?php if ($reportPerDealerPerSalesman->Export == "") { ?>
<script language="JavaScript" type="text/javascript">
<!--

// Write your table-specific startup script here
// document.write("page loaded");
//-->

</script>
<?php } ?>
<?php include_once "phprptinc/footer.php"; ?>
<?php
$reportPerDealerPerSalesman_rpt->Page_Terminate();
?>
<?php

//
// Page class
//
class crreportPerDealerPerSalesman_rpt {

	// Page ID
	var $PageID = 'rpt';

	// Table name
	var $TableName = 'reportPerDealerPerSalesman';

	// Page object name
	var $PageObjName = 'reportPerDealerPerSalesman_rpt';

	// Page name
	function PageName() {
		return ewrpt_CurrentPage();
	}

	// Page URL
	function PageUrl() {
		$PageUrl = ewrpt_CurrentPage() . "?";
		global $reportPerDealerPerSalesman;
		if ($reportPerDealerPerSalesman->UseTokenInUrl) $PageUrl .= "t=" . $reportPerDealerPerSalesman->TableVar . "&"; // Add page token
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
		global $reportPerDealerPerSalesman;
		if ($reportPerDealerPerSalesman->UseTokenInUrl) {
			if (ewrpt_IsHttpPost())
				return ($reportPerDealerPerSalesman->TableVar == @$_POST("t"));
			if (@$_GET["t"] <> "")
				return ($reportPerDealerPerSalesman->TableVar == @$_GET["t"]);
		} else {
			return TRUE;
		}
	}

	//
	// Page class constructor
	//
	function crreportPerDealerPerSalesman_rpt() {
		global $conn, $ReportLanguage;

		// Language object
		$ReportLanguage = new crLanguage();

		// Table object (reportPerDealerPerSalesman)
		$GLOBALS["reportPerDealerPerSalesman"] = new crreportPerDealerPerSalesman();
		$GLOBALS["Table"] =& $GLOBALS["reportPerDealerPerSalesman"];

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
			define("EWRPT_TABLE_NAME", 'reportPerDealerPerSalesman', TRUE);

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
		global $reportPerDealerPerSalesman;

		// Security
		$Security = new crAdvancedSecurity();
		if (!$Security->IsLoggedIn()) $Security->AutoLogin(); // Auto login
		if (!$Security->IsLoggedIn()) {
			$Security->SaveLastUrl();
			$this->Page_Terminate("rlogin.php");
		}

		// Get export parameters
		if (@$_GET["export"] <> "") {
			$reportPerDealerPerSalesman->Export = $_GET["export"];
		}
		$gsExport = $reportPerDealerPerSalesman->Export; // Get export parameter, used in header
		$gsExportFile = $reportPerDealerPerSalesman->TableVar; // Get export file, used in header
		if ($reportPerDealerPerSalesman->Export == "excel") {
			header('Content-Type: application/vnd.ms-excel;charset=utf-8');
			header('Content-Disposition: attachment; filename=' . $gsExportFile .'.xls');
		}
		if ($reportPerDealerPerSalesman->Export == "word") {
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
		global $ReportLanguage, $reportPerDealerPerSalesman;

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
		$item->Body = "<a name=\"emf_reportPerDealerPerSalesman\" id=\"emf_reportPerDealerPerSalesman\" href=\"javascript:void(0);\" onclick=\"ewrpt_EmailDialogShow({lnk:'emf_reportPerDealerPerSalesman',hdr:ewLanguage.Phrase('ExportToEmail')});\">" . $ReportLanguage->Phrase("ExportToEmail") . "</a>";
		$item->Visible = FALSE;

		// Reset filter
		$item =& $this->ExportOptions->Add("resetfilter");
		$item->Body = "<a href=\"" . ewrpt_CurrentPage() . "?cmd=reset\">" . $ReportLanguage->Phrase("ResetAllFilter") . "</a>";
		$item->Visible = FALSE;
		$this->SetupExportOptionsExt();

		// Hide options for export
		if ($reportPerDealerPerSalesman->Export <> "")
			$this->ExportOptions->HideAllOptions();

		// Set up table class
		if ($reportPerDealerPerSalesman->Export == "word" || $reportPerDealerPerSalesman->Export == "excel" || $reportPerDealerPerSalesman->Export == "pdf")
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
		global $reportPerDealerPerSalesman;

		// Page Unload event
		$this->Page_Unload();

		// Global Page Unloaded event (in userfn*.php)
		Page_Unloaded();

		// Export to Email (use ob_file_contents for PHP)
		if ($reportPerDealerPerSalesman->Export == "email") {
			$sContent = ob_get_contents();
			$this->ExportEmail($sContent);
			ob_end_clean();

			 // Close connection
			$conn->Close();
			header("Location: " . ewrpt_CurrentPage());
			exit();
		}

		// Export to PDF (use ob_file_contents for PHP)
		if ($reportPerDealerPerSalesman->Export == "pdf") {
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
		global $reportPerDealerPerSalesman;
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
		$reportPerDealerPerSalesman->Filters_Load();

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
		$this->ExportOptions->GetItem("resetfilter")->Visible = $this->FilterApplied;

		// Get sort
		$this->Sort = $this->GetSort();

		// Get total count
		$sSql = ewrpt_BuildReportSql($reportPerDealerPerSalesman->SqlSelect(), $reportPerDealerPerSalesman->SqlWhere(), $reportPerDealerPerSalesman->SqlGroupBy(), $reportPerDealerPerSalesman->SqlHaving(), $reportPerDealerPerSalesman->SqlOrderBy(), $this->Filter, $this->Sort);
		$this->TotalGrps = $this->GetCnt($sSql);
		if ($this->DisplayGrps <= 0) // Display all groups
			$this->DisplayGrps = $this->TotalGrps;
		$this->StartGrp = 1;

		// Show header
		$this->ShowFirstHeader = ($this->TotalGrps > 0);

		//$this->ShowFirstHeader = TRUE; // Uncomment to always show header
		// Set up start position if not export all

		if ($reportPerDealerPerSalesman->ExportAll && $reportPerDealerPerSalesman->Export <> "")
		    $this->DisplayGrps = $this->TotalGrps;
		else
			$this->SetUpStartGroup(); 

		// Hide all options if export
		if ($reportPerDealerPerSalesman->Export <> "") {
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
		global $reportPerDealerPerSalesman;
		if (!$rs)
			return;
		if ($opt == 1) { // Get first row

	//		$rs->MoveFirst(); // NOTE: no need to move position
		} else { // Get next row
			$rs->MoveNext();
		}
		if (!$rs->EOF) {
			$reportPerDealerPerSalesman->Code->setDbValue($rs->fields('Code'));
			$reportPerDealerPerSalesman->Salesman->setDbValue($rs->fields('Salesman'));
			$reportPerDealerPerSalesman->DateCreated->setDbValue($rs->fields('DateCreated'));
			$reportPerDealerPerSalesman->Fullname->setDbValue($rs->fields('Fullname'));
			$reportPerDealerPerSalesman->Quote_Status->setDbValue($rs->fields('Quote Status'));
			$reportPerDealerPerSalesman->Period->setDbValue($rs->fields('Period'));
			$reportPerDealerPerSalesman->Collection_Method->setDbValue($rs->fields('Collection Method'));
			$reportPerDealerPerSalesman->Dealer->setDbValue($rs->fields('Dealer'));
			$reportPerDealerPerSalesman->Salesman_ID->setDbValue($rs->fields('Salesman ID'));
			$reportPerDealerPerSalesman->Customer_ID2FCompany_Reg->setDbValue($rs->fields('Customer ID/Company Reg'));
			$reportPerDealerPerSalesman->Status->setDbValue($rs->fields('Status'));
			$reportPerDealerPerSalesman->Amount->setDbValue($rs->fields('Amount'));
			$reportPerDealerPerSalesman->TotalAmount->setDbValue($rs->fields('TotalAmount'));
			$reportPerDealerPerSalesman->_28quot2ETotalAmount_2D_res2EAmount29->setDbValue($rs->fields('(quot.TotalAmount - res.Amount)'));
			$reportPerDealerPerSalesman->Deal_Number->setDbValue($rs->fields('Deal Number'));
			$this->Val[1] = $reportPerDealerPerSalesman->Code->CurrentValue;
			$this->Val[2] = $reportPerDealerPerSalesman->Salesman->CurrentValue;
			$this->Val[3] = $reportPerDealerPerSalesman->DateCreated->CurrentValue;
			$this->Val[4] = $reportPerDealerPerSalesman->Fullname->CurrentValue;
			$this->Val[5] = $reportPerDealerPerSalesman->Quote_Status->CurrentValue;
			$this->Val[6] = $reportPerDealerPerSalesman->Period->CurrentValue;
			$this->Val[7] = $reportPerDealerPerSalesman->Collection_Method->CurrentValue;
			$this->Val[8] = $reportPerDealerPerSalesman->Dealer->CurrentValue;
			$this->Val[9] = $reportPerDealerPerSalesman->Salesman_ID->CurrentValue;
			$this->Val[10] = $reportPerDealerPerSalesman->Customer_ID2FCompany_Reg->CurrentValue;
			$this->Val[11] = $reportPerDealerPerSalesman->Status->CurrentValue;
			$this->Val[12] = $reportPerDealerPerSalesman->Amount->CurrentValue;
			$this->Val[13] = $reportPerDealerPerSalesman->TotalAmount->CurrentValue;
			$this->Val[14] = $reportPerDealerPerSalesman->_28quot2ETotalAmount_2D_res2EAmount29->CurrentValue;
			$this->Val[15] = $reportPerDealerPerSalesman->Deal_Number->CurrentValue;
		} else {
			$reportPerDealerPerSalesman->Code->setDbValue("");
			$reportPerDealerPerSalesman->Salesman->setDbValue("");
			$reportPerDealerPerSalesman->DateCreated->setDbValue("");
			$reportPerDealerPerSalesman->Fullname->setDbValue("");
			$reportPerDealerPerSalesman->Quote_Status->setDbValue("");
			$reportPerDealerPerSalesman->Period->setDbValue("");
			$reportPerDealerPerSalesman->Collection_Method->setDbValue("");
			$reportPerDealerPerSalesman->Dealer->setDbValue("");
			$reportPerDealerPerSalesman->Salesman_ID->setDbValue("");
			$reportPerDealerPerSalesman->Customer_ID2FCompany_Reg->setDbValue("");
			$reportPerDealerPerSalesman->Status->setDbValue("");
			$reportPerDealerPerSalesman->Amount->setDbValue("");
			$reportPerDealerPerSalesman->TotalAmount->setDbValue("");
			$reportPerDealerPerSalesman->_28quot2ETotalAmount_2D_res2EAmount29->setDbValue("");
			$reportPerDealerPerSalesman->Deal_Number->setDbValue("");
		}
	}

	//  Set up starting group
	function SetUpStartGroup() {
		global $reportPerDealerPerSalesman;

		// Exit if no groups
		if ($this->DisplayGrps == 0)
			return;

		// Check for a 'start' parameter
		if (@$_GET[EWRPT_TABLE_START_GROUP] != "") {
			$this->StartGrp = $_GET[EWRPT_TABLE_START_GROUP];
			$reportPerDealerPerSalesman->setStartGroup($this->StartGrp);
		} elseif (@$_GET["pageno"] != "") {
			$nPageNo = $_GET["pageno"];
			if (is_numeric($nPageNo)) {
				$this->StartGrp = ($nPageNo-1)*$this->DisplayGrps+1;
				if ($this->StartGrp <= 0) {
					$this->StartGrp = 1;
				} elseif ($this->StartGrp >= intval(($this->TotalGrps-1)/$this->DisplayGrps)*$this->DisplayGrps+1) {
					$this->StartGrp = intval(($this->TotalGrps-1)/$this->DisplayGrps)*$this->DisplayGrps+1;
				}
				$reportPerDealerPerSalesman->setStartGroup($this->StartGrp);
			} else {
				$this->StartGrp = $reportPerDealerPerSalesman->getStartGroup();
			}
		} else {
			$this->StartGrp = $reportPerDealerPerSalesman->getStartGroup();
		}

		// Check if correct start group counter
		if (!is_numeric($this->StartGrp) || $this->StartGrp == "") { // Avoid invalid start group counter
			$this->StartGrp = 1; // Reset start group counter
			$reportPerDealerPerSalesman->setStartGroup($this->StartGrp);
		} elseif (intval($this->StartGrp) > intval($this->TotalGrps)) { // Avoid starting group > total groups
			$this->StartGrp = intval(($this->TotalGrps-1)/$this->DisplayGrps) * $this->DisplayGrps + 1; // Point to last page first group
			$reportPerDealerPerSalesman->setStartGroup($this->StartGrp);
		} elseif (($this->StartGrp-1) % $this->DisplayGrps <> 0) {
			$this->StartGrp = intval(($this->StartGrp-1)/$this->DisplayGrps) * $this->DisplayGrps + 1; // Point to page boundary
			$reportPerDealerPerSalesman->setStartGroup($this->StartGrp);
		}
	}

	// Set up popup
	function SetupPopup() {
		global $conn, $ReportLanguage;
		global $reportPerDealerPerSalesman;

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
		global $reportPerDealerPerSalesman;
		$this->StartGrp = 1;
		$reportPerDealerPerSalesman->setStartGroup($this->StartGrp);
	}

	// Set up number of groups displayed per page
	function SetUpDisplayGrps() {
		global $reportPerDealerPerSalesman;
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
			$reportPerDealerPerSalesman->setGroupPerPage($this->DisplayGrps); // Save to session

			// Reset start position (reset command)
			$this->StartGrp = 1;
			$reportPerDealerPerSalesman->setStartGroup($this->StartGrp);
		} else {
			if ($reportPerDealerPerSalesman->getGroupPerPage() <> "") {
				$this->DisplayGrps = $reportPerDealerPerSalesman->getGroupPerPage(); // Restore from session
			} else {
				$this->DisplayGrps = 50; // Load default
			}
		}
	}

	function RenderRow() {
		global $conn, $rs, $Security;
		global $reportPerDealerPerSalesman;
		if ($reportPerDealerPerSalesman->RowTotalType == EWRPT_ROWTOTAL_GRAND) { // Grand total

			// Get total count from sql directly
			$sSql = ewrpt_BuildReportSql($reportPerDealerPerSalesman->SqlSelectCount(), $reportPerDealerPerSalesman->SqlWhere(), $reportPerDealerPerSalesman->SqlGroupBy(), $reportPerDealerPerSalesman->SqlHaving(), "", $this->Filter, "");
			$rstot = $conn->Execute($sSql);
			if ($rstot) {
				$this->TotCount = ($rstot->RecordCount()>1) ? $rstot->RecordCount() : $rstot->fields[0];
				$rstot->Close();
			} else {
				$this->TotCount = 0;
			}
		}

		// Call Row_Rendering event
		$reportPerDealerPerSalesman->Row_Rendering();

		//
		// Render view codes
		//

		if ($reportPerDealerPerSalesman->RowType == EWRPT_ROWTYPE_TOTAL) { // Summary row
		} else {

			// Code
			$reportPerDealerPerSalesman->Code->ViewValue = $reportPerDealerPerSalesman->Code->CurrentValue;
			$reportPerDealerPerSalesman->Code->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";

			// Salesman
			$reportPerDealerPerSalesman->Salesman->ViewValue = $reportPerDealerPerSalesman->Salesman->CurrentValue;
			$reportPerDealerPerSalesman->Salesman->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";

			// DateCreated
			$reportPerDealerPerSalesman->DateCreated->ViewValue = $reportPerDealerPerSalesman->DateCreated->CurrentValue;
			$reportPerDealerPerSalesman->DateCreated->ViewValue = ewrpt_FormatDateTime($reportPerDealerPerSalesman->DateCreated->ViewValue, 7);
			$reportPerDealerPerSalesman->DateCreated->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";

			// Fullname
			$reportPerDealerPerSalesman->Fullname->ViewValue = $reportPerDealerPerSalesman->Fullname->CurrentValue;
			$reportPerDealerPerSalesman->Fullname->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";

			// Quote Status
			$reportPerDealerPerSalesman->Quote_Status->ViewValue = $reportPerDealerPerSalesman->Quote_Status->CurrentValue;
			$reportPerDealerPerSalesman->Quote_Status->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";

			// Period
			$reportPerDealerPerSalesman->Period->ViewValue = $reportPerDealerPerSalesman->Period->CurrentValue;
			$reportPerDealerPerSalesman->Period->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";

			// Collection Method
			$reportPerDealerPerSalesman->Collection_Method->ViewValue = $reportPerDealerPerSalesman->Collection_Method->CurrentValue;
			$reportPerDealerPerSalesman->Collection_Method->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";

			// Dealer
			$reportPerDealerPerSalesman->Dealer->ViewValue = $reportPerDealerPerSalesman->Dealer->CurrentValue;
			$reportPerDealerPerSalesman->Dealer->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";

			// Salesman ID
			$reportPerDealerPerSalesman->Salesman_ID->ViewValue = $reportPerDealerPerSalesman->Salesman_ID->CurrentValue;
			$reportPerDealerPerSalesman->Salesman_ID->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";

			// Customer ID/Company Reg
			$reportPerDealerPerSalesman->Customer_ID2FCompany_Reg->ViewValue = $reportPerDealerPerSalesman->Customer_ID2FCompany_Reg->CurrentValue;
			$reportPerDealerPerSalesman->Customer_ID2FCompany_Reg->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";

			// Status
			$reportPerDealerPerSalesman->Status->ViewValue = $reportPerDealerPerSalesman->Status->CurrentValue;
			$reportPerDealerPerSalesman->Status->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";

			// Amount
			$reportPerDealerPerSalesman->Amount->ViewValue = $reportPerDealerPerSalesman->Amount->CurrentValue;
			$reportPerDealerPerSalesman->Amount->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";

			// TotalAmount
			$reportPerDealerPerSalesman->TotalAmount->ViewValue = $reportPerDealerPerSalesman->TotalAmount->CurrentValue;
			$reportPerDealerPerSalesman->TotalAmount->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";

			// (quot.TotalAmount - res.Amount)
			$reportPerDealerPerSalesman->_28quot2ETotalAmount_2D_res2EAmount29->ViewValue = $reportPerDealerPerSalesman->_28quot2ETotalAmount_2D_res2EAmount29->CurrentValue;
			$reportPerDealerPerSalesman->_28quot2ETotalAmount_2D_res2EAmount29->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";

			// Deal Number
			$reportPerDealerPerSalesman->Deal_Number->ViewValue = $reportPerDealerPerSalesman->Deal_Number->CurrentValue;
			$reportPerDealerPerSalesman->Deal_Number->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";

			// Code
			$reportPerDealerPerSalesman->Code->HrefValue = "";

			// Salesman
			$reportPerDealerPerSalesman->Salesman->HrefValue = "";

			// DateCreated
			$reportPerDealerPerSalesman->DateCreated->HrefValue = "";

			// Fullname
			$reportPerDealerPerSalesman->Fullname->HrefValue = "";

			// Quote Status
			$reportPerDealerPerSalesman->Quote_Status->HrefValue = "";

			// Period
			$reportPerDealerPerSalesman->Period->HrefValue = "";

			// Collection Method
			$reportPerDealerPerSalesman->Collection_Method->HrefValue = "";

			// Dealer
			$reportPerDealerPerSalesman->Dealer->HrefValue = "";

			// Salesman ID
			$reportPerDealerPerSalesman->Salesman_ID->HrefValue = "";

			// Customer ID/Company Reg
			$reportPerDealerPerSalesman->Customer_ID2FCompany_Reg->HrefValue = "";

			// Status
			$reportPerDealerPerSalesman->Status->HrefValue = "";

			// Amount
			$reportPerDealerPerSalesman->Amount->HrefValue = "";

			// TotalAmount
			$reportPerDealerPerSalesman->TotalAmount->HrefValue = "";

			// (quot.TotalAmount - res.Amount)
			$reportPerDealerPerSalesman->_28quot2ETotalAmount_2D_res2EAmount29->HrefValue = "";

			// Deal Number
			$reportPerDealerPerSalesman->Deal_Number->HrefValue = "";
		}

		// Call Cell_Rendered event
		if ($reportPerDealerPerSalesman->RowType == EWRPT_ROWTYPE_TOTAL) { // Summary row
		} else {

			// Code
			$CurrentValue = $reportPerDealerPerSalesman->Code->CurrentValue;
			$ViewValue =& $reportPerDealerPerSalesman->Code->ViewValue;
			$ViewAttrs =& $reportPerDealerPerSalesman->Code->ViewAttrs;
			$CellAttrs =& $reportPerDealerPerSalesman->Code->CellAttrs;
			$HrefValue =& $reportPerDealerPerSalesman->Code->HrefValue;
			$reportPerDealerPerSalesman->Cell_Rendered($reportPerDealerPerSalesman->Code, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue);

			// Salesman
			$CurrentValue = $reportPerDealerPerSalesman->Salesman->CurrentValue;
			$ViewValue =& $reportPerDealerPerSalesman->Salesman->ViewValue;
			$ViewAttrs =& $reportPerDealerPerSalesman->Salesman->ViewAttrs;
			$CellAttrs =& $reportPerDealerPerSalesman->Salesman->CellAttrs;
			$HrefValue =& $reportPerDealerPerSalesman->Salesman->HrefValue;
			$reportPerDealerPerSalesman->Cell_Rendered($reportPerDealerPerSalesman->Salesman, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue);

			// DateCreated
			$CurrentValue = $reportPerDealerPerSalesman->DateCreated->CurrentValue;
			$ViewValue =& $reportPerDealerPerSalesman->DateCreated->ViewValue;
			$ViewAttrs =& $reportPerDealerPerSalesman->DateCreated->ViewAttrs;
			$CellAttrs =& $reportPerDealerPerSalesman->DateCreated->CellAttrs;
			$HrefValue =& $reportPerDealerPerSalesman->DateCreated->HrefValue;
			$reportPerDealerPerSalesman->Cell_Rendered($reportPerDealerPerSalesman->DateCreated, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue);

			// Fullname
			$CurrentValue = $reportPerDealerPerSalesman->Fullname->CurrentValue;
			$ViewValue =& $reportPerDealerPerSalesman->Fullname->ViewValue;
			$ViewAttrs =& $reportPerDealerPerSalesman->Fullname->ViewAttrs;
			$CellAttrs =& $reportPerDealerPerSalesman->Fullname->CellAttrs;
			$HrefValue =& $reportPerDealerPerSalesman->Fullname->HrefValue;
			$reportPerDealerPerSalesman->Cell_Rendered($reportPerDealerPerSalesman->Fullname, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue);

			// Quote Status
			$CurrentValue = $reportPerDealerPerSalesman->Quote_Status->CurrentValue;
			$ViewValue =& $reportPerDealerPerSalesman->Quote_Status->ViewValue;
			$ViewAttrs =& $reportPerDealerPerSalesman->Quote_Status->ViewAttrs;
			$CellAttrs =& $reportPerDealerPerSalesman->Quote_Status->CellAttrs;
			$HrefValue =& $reportPerDealerPerSalesman->Quote_Status->HrefValue;
			$reportPerDealerPerSalesman->Cell_Rendered($reportPerDealerPerSalesman->Quote_Status, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue);

			// Period
			$CurrentValue = $reportPerDealerPerSalesman->Period->CurrentValue;
			$ViewValue =& $reportPerDealerPerSalesman->Period->ViewValue;
			$ViewAttrs =& $reportPerDealerPerSalesman->Period->ViewAttrs;
			$CellAttrs =& $reportPerDealerPerSalesman->Period->CellAttrs;
			$HrefValue =& $reportPerDealerPerSalesman->Period->HrefValue;
			$reportPerDealerPerSalesman->Cell_Rendered($reportPerDealerPerSalesman->Period, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue);

			// Collection Method
			$CurrentValue = $reportPerDealerPerSalesman->Collection_Method->CurrentValue;
			$ViewValue =& $reportPerDealerPerSalesman->Collection_Method->ViewValue;
			$ViewAttrs =& $reportPerDealerPerSalesman->Collection_Method->ViewAttrs;
			$CellAttrs =& $reportPerDealerPerSalesman->Collection_Method->CellAttrs;
			$HrefValue =& $reportPerDealerPerSalesman->Collection_Method->HrefValue;
			$reportPerDealerPerSalesman->Cell_Rendered($reportPerDealerPerSalesman->Collection_Method, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue);

			// Dealer
			$CurrentValue = $reportPerDealerPerSalesman->Dealer->CurrentValue;
			$ViewValue =& $reportPerDealerPerSalesman->Dealer->ViewValue;
			$ViewAttrs =& $reportPerDealerPerSalesman->Dealer->ViewAttrs;
			$CellAttrs =& $reportPerDealerPerSalesman->Dealer->CellAttrs;
			$HrefValue =& $reportPerDealerPerSalesman->Dealer->HrefValue;
			$reportPerDealerPerSalesman->Cell_Rendered($reportPerDealerPerSalesman->Dealer, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue);

			// Salesman ID
			$CurrentValue = $reportPerDealerPerSalesman->Salesman_ID->CurrentValue;
			$ViewValue =& $reportPerDealerPerSalesman->Salesman_ID->ViewValue;
			$ViewAttrs =& $reportPerDealerPerSalesman->Salesman_ID->ViewAttrs;
			$CellAttrs =& $reportPerDealerPerSalesman->Salesman_ID->CellAttrs;
			$HrefValue =& $reportPerDealerPerSalesman->Salesman_ID->HrefValue;
			$reportPerDealerPerSalesman->Cell_Rendered($reportPerDealerPerSalesman->Salesman_ID, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue);

			// Customer ID/Company Reg
			$CurrentValue = $reportPerDealerPerSalesman->Customer_ID2FCompany_Reg->CurrentValue;
			$ViewValue =& $reportPerDealerPerSalesman->Customer_ID2FCompany_Reg->ViewValue;
			$ViewAttrs =& $reportPerDealerPerSalesman->Customer_ID2FCompany_Reg->ViewAttrs;
			$CellAttrs =& $reportPerDealerPerSalesman->Customer_ID2FCompany_Reg->CellAttrs;
			$HrefValue =& $reportPerDealerPerSalesman->Customer_ID2FCompany_Reg->HrefValue;
			$reportPerDealerPerSalesman->Cell_Rendered($reportPerDealerPerSalesman->Customer_ID2FCompany_Reg, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue);

			// Status
			$CurrentValue = $reportPerDealerPerSalesman->Status->CurrentValue;
			$ViewValue =& $reportPerDealerPerSalesman->Status->ViewValue;
			$ViewAttrs =& $reportPerDealerPerSalesman->Status->ViewAttrs;
			$CellAttrs =& $reportPerDealerPerSalesman->Status->CellAttrs;
			$HrefValue =& $reportPerDealerPerSalesman->Status->HrefValue;
			$reportPerDealerPerSalesman->Cell_Rendered($reportPerDealerPerSalesman->Status, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue);

			// Amount
			$CurrentValue = $reportPerDealerPerSalesman->Amount->CurrentValue;
			$ViewValue =& $reportPerDealerPerSalesman->Amount->ViewValue;
			$ViewAttrs =& $reportPerDealerPerSalesman->Amount->ViewAttrs;
			$CellAttrs =& $reportPerDealerPerSalesman->Amount->CellAttrs;
			$HrefValue =& $reportPerDealerPerSalesman->Amount->HrefValue;
			$reportPerDealerPerSalesman->Cell_Rendered($reportPerDealerPerSalesman->Amount, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue);

			// TotalAmount
			$CurrentValue = $reportPerDealerPerSalesman->TotalAmount->CurrentValue;
			$ViewValue =& $reportPerDealerPerSalesman->TotalAmount->ViewValue;
			$ViewAttrs =& $reportPerDealerPerSalesman->TotalAmount->ViewAttrs;
			$CellAttrs =& $reportPerDealerPerSalesman->TotalAmount->CellAttrs;
			$HrefValue =& $reportPerDealerPerSalesman->TotalAmount->HrefValue;
			$reportPerDealerPerSalesman->Cell_Rendered($reportPerDealerPerSalesman->TotalAmount, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue);

			// (quot.TotalAmount - res.Amount)
			$CurrentValue = $reportPerDealerPerSalesman->_28quot2ETotalAmount_2D_res2EAmount29->CurrentValue;
			$ViewValue =& $reportPerDealerPerSalesman->_28quot2ETotalAmount_2D_res2EAmount29->ViewValue;
			$ViewAttrs =& $reportPerDealerPerSalesman->_28quot2ETotalAmount_2D_res2EAmount29->ViewAttrs;
			$CellAttrs =& $reportPerDealerPerSalesman->_28quot2ETotalAmount_2D_res2EAmount29->CellAttrs;
			$HrefValue =& $reportPerDealerPerSalesman->_28quot2ETotalAmount_2D_res2EAmount29->HrefValue;
			$reportPerDealerPerSalesman->Cell_Rendered($reportPerDealerPerSalesman->_28quot2ETotalAmount_2D_res2EAmount29, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue);

			// Deal Number
			$CurrentValue = $reportPerDealerPerSalesman->Deal_Number->CurrentValue;
			$ViewValue =& $reportPerDealerPerSalesman->Deal_Number->ViewValue;
			$ViewAttrs =& $reportPerDealerPerSalesman->Deal_Number->ViewAttrs;
			$CellAttrs =& $reportPerDealerPerSalesman->Deal_Number->CellAttrs;
			$HrefValue =& $reportPerDealerPerSalesman->Deal_Number->HrefValue;
			$reportPerDealerPerSalesman->Cell_Rendered($reportPerDealerPerSalesman->Deal_Number, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue);
		}

		// Call Row_Rendered event
		$reportPerDealerPerSalesman->Row_Rendered();
	}

	function SetupExportOptionsExt() {
		global $ReportLanguage, $reportPerDealerPerSalesman;
	}

	// Return poup filter
	function GetPopupFilter() {
		global $reportPerDealerPerSalesman;
		$sWrk = "";
		return $sWrk;
	}

	//-------------------------------------------------------------------------------
	// Function GetSort
	// - Return Sort parameters based on Sort Links clicked
	// - Variables setup: Session[EWRPT_TABLE_SESSION_ORDER_BY], Session["sort_Table_Field"]
	function GetSort() {
		global $reportPerDealerPerSalesman;

		// Check for a resetsort command
		if (strlen(@$_GET["cmd"]) > 0) {
			$sCmd = @$_GET["cmd"];
			if ($sCmd == "resetsort") {
				$reportPerDealerPerSalesman->setOrderBy("");
				$reportPerDealerPerSalesman->setStartGroup(1);
				$reportPerDealerPerSalesman->Code->setSort("");
				$reportPerDealerPerSalesman->Salesman->setSort("");
				$reportPerDealerPerSalesman->DateCreated->setSort("");
				$reportPerDealerPerSalesman->Fullname->setSort("");
				$reportPerDealerPerSalesman->Quote_Status->setSort("");
				$reportPerDealerPerSalesman->Period->setSort("");
				$reportPerDealerPerSalesman->Collection_Method->setSort("");
				$reportPerDealerPerSalesman->Dealer->setSort("");
				$reportPerDealerPerSalesman->Salesman_ID->setSort("");
				$reportPerDealerPerSalesman->Customer_ID2FCompany_Reg->setSort("");
				$reportPerDealerPerSalesman->Status->setSort("");
				$reportPerDealerPerSalesman->Amount->setSort("");
				$reportPerDealerPerSalesman->TotalAmount->setSort("");
				$reportPerDealerPerSalesman->_28quot2ETotalAmount_2D_res2EAmount29->setSort("");
				$reportPerDealerPerSalesman->Deal_Number->setSort("");
			}

		// Check for an Order parameter
		} elseif (@$_GET["order"] <> "") {
			$reportPerDealerPerSalesman->CurrentOrder = ewrpt_StripSlashes(@$_GET["order"]);
			$reportPerDealerPerSalesman->CurrentOrderType = @$_GET["ordertype"];
			$sSortSql = $reportPerDealerPerSalesman->SortSql();
			$reportPerDealerPerSalesman->setOrderBy($sSortSql);
			$reportPerDealerPerSalesman->setStartGroup(1);
		}
		return $reportPerDealerPerSalesman->getOrderBy();
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
