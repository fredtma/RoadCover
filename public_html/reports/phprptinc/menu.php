<?php

// Menu
define("EWRPT_MENUBAR_CLASSNAME", "ewMenuBarVertical", TRUE);
define("EWRPT_MENUBAR_ITEM_CLASSNAME", "", TRUE);
define("EWRPT_MENUBAR_ITEM_LABEL_CLASSNAME", "", TRUE);
define("EWRPT_MENU_CLASSNAME", "ewMenuBarVertical", TRUE);
define("EWRPT_MENU_ITEM_CLASSNAME", "", TRUE);
define("EWRPT_MENU_ITEM_LABEL_CLASSNAME", "", TRUE);
?>
<?php

/**
 * Menu class
 */

class crMenu {
	var $Id;
	var $IsRoot = FALSE;
	var $NoItem = NULL;
	var $ItemData = array();

	function crMenu($id) {
		$this->Id = $id;
	}

	// Add a menu item
	function AddMenuItem($id, $text, $url, $parentid, $src, $target, $allowed = TRUE, $grouptitle = FALSE) {
		$item = new crMenuItem($id, $text, $url, $parentid, $src, $target, $allowed, $grouptitle);

		// Fire MenuItem_Adding event
		if (function_exists("MenuItem_Adding") && !MenuItem_Adding($item))
			return;
		if ($item->ParentId < 0) {
			$this->AddItem($item);
		} else {
			if ($oParentMenu =& $this->FindItem($item->ParentId))
				$oParentMenu->AddItem($item);
		}
	}

	// Add item to internal array
	function AddItem($item) {
		$this->ItemData[] = $item;
	}

	// Clear all menu items
	function Clear() {
		$this->ItemData = array();
	}

	// Find item
	function &FindItem($id) {
		$cnt = count($this->ItemData);
		for ($i = 0; $i < $cnt; $i++) {
			$item =& $this->ItemData[$i];
			if ($item->Id == $id) {
				return $item;
			} elseif (!is_null($item->SubMenu)) {
				if ($subitem =& $item->SubMenu->FindItem($id))
					return $subitem;
			}
		}
		return $this->NoItem;
	}

	// Get menu item count
	function Count() {
		return count($this->ItemData);
	}

	// Move item to position
	function MoveItem($Name, $Pos) {
		$cnt = count($this->ItemData);
		if ($Pos < 0) {
			$Pos = 0;
		} elseif ($Pos >= $cnt) {
			$Pos = $cnt - 1;
		}
		$item = array_key_exists($Name, $this->ItemData) ? $this->ItemData[$Name] : NULL;
		if ($item) {
			unset($this->ItemData[$Name]);
			$this->ItemData = array_merge(array_slice($this->ItemData, 0, $Pos),
				array($Name => $item), array_slice($this->ItemData, $Pos));
		}
	}

	// Check if a menu item should be shown
	function RenderItem($item) {
		if (!is_null($item->SubMenu)) {
			foreach ($item->SubMenu->ItemData as $subitem) {
				if ($item->SubMenu->RenderItem($subitem))
					return TRUE;
			}
		}
		return ($item->Allowed && $item->Url <> "");
	}

	// Check if this menu should be rendered
	function RenderMenu() {
		foreach ($this->ItemData as $item) {
			if ($this->RenderItem($item))
				return TRUE;
		}
		return FALSE;
	}

	// Render the menu
	function Render($ret = FALSE) {
		if (function_exists("Menu_Rendering")) Menu_Rendering($this);
		if (!$this->RenderMenu())
			return;
		$str = "<div";
		if ($this->Id <> "") {
			if (is_numeric($this->Id)) {
				$str .= " id=\"menu_" . $this->Id . "\"";
			} else {
				$str .= " id=\"" . $this->Id . "\"";
			}
		}
		$str .= " class=\"" . (($this->IsRoot) ? EWRPT_MENUBAR_CLASSNAME : EWRPT_MENU_CLASSNAME) . "\">";
		$str .= "<div class=\"bd" . (($this->IsRoot) ? " first-of-type": "") . "\">\n";
		$gopen = FALSE; // Group open status
		$gcnt = 0; // Group count
		$i = 0; // Menu item count
		$classfot = " class=\"first-of-type\"";
		foreach ($this->ItemData as $item) {
			if ($this->RenderItem($item)) {
				$i++;

				// Begin a group
				if ($i == 1 && !$item->GroupTitle) {
					$gcnt++;
					$str .= "<ul " . $classfot . ">\n";
					$gopen = TRUE;
				}
				$aclass = ($this->IsRoot) ? EWRPT_MENUBAR_ITEM_LABEL_CLASSNAME : EWRPT_MENU_ITEM_LABEL_CLASSNAME;
				$liclass = ($this->IsRoot) ? EWRPT_MENUBAR_ITEM_CLASSNAME : EWRPT_MENU_ITEM_CLASSNAME;
				if ($item->GroupTitle && EWRPT_MENU_ITEM_CLASSNAME <> "") { // Group title
					$gcnt++;
					if ($i > 1 && $gopen) {
						$str .= "</ul>\n"; // End last group
						$gopen = FALSE;
					}

					// Begin a new group with title
					if (strval($item->Text) <> "")
						$str .= "<h6" . (($gcnt == 1) ? $classfot : "") . ">" . $item->Text . "</h6>\n";
					$str .= "<ul" . (($gcnt == 1) ? $classfot : "") . ">\n";
					$gopen = TRUE;
					if (!is_null($item->SubMenu)) {
						foreach ($item->SubMenu->ItemData as $subitem) {
							if ($this->RenderItem($subitem))
								$str .= $subitem->Render($aclass, $liclass) . "\n"; // Create <LI>
						}
					}
					$str .= "</ul>\n"; // End the group
					$gopen = FALSE;
				} else { // Menu item
					if (!$gopen) { // Begin a group if no opened group
						$gcnt++;
						$str .= "<ul" . (($gcnt == 1) ? $classfot : "") . ">\n";
						$gopen = TRUE;
					}
					if ($this->IsRoot && $i == 1) // For horizontal menu
						$liclass .= " first-of-type";
					$str .= $item->Render($aclass, $liclass) . "\n"; // Create <LI>
				}
			}
		}
		if ($gopen)
			$str .= "</ul>\n"; // End last group
		$str .= "</div></div>\n";
		if ($ret) // Return as string
			return $str;
		echo $str; // Output
	}
}

// Menu item class
class crMenuItem {
	var $Id;
	var $Text;
	var $Url;
	var $ParentId; 
	var $SubMenu = NULL; // Data type = crMenu
	var $Source;
	var $Allowed = TRUE;
	var $Target;
	var $GroupTitle;

	function crMenuItem($id, $text, $url, $parentid, $src, $target, $allowed, $grouptitle = FALSE) {
		$this->Id = $id;
		$this->Text = $text;
		$this->Url = $url;
		$this->ParentId = $parentid;
		$this->Source = $src;
		$this->Target = $target;
		$this->Allowed = $allowed;
		$this->GroupTitle = $grouptitle;
	}

	function AddItem($item) { // Add submenu item
		if (is_null($this->SubMenu))
			$this->SubMenu = new crMenu($this->Id);
		$this->SubMenu->AddItem($item);
	}

	// Render
	function Render($aclass = "", $liclass = "") {

		// Create <A>
		$attrs = array("class" => $aclass, "href" => $this->Url, "target" => $this->Target);
		$innerhtml = ewrpt_HtmlElement("a", $attrs, $this->Text);
		if (!is_null($this->SubMenu))
			$innerhtml .= $this->SubMenu->Render(TRUE);

		// Create <LI>
		return ewrpt_HtmlElement("li", array("class" => $liclass), $innerhtml);
	}
}

// Menu Rendering event
function Menu_Rendering(&$Menu) {

	// Change menu items here
}

// MenuItem Adding event
function MenuItem_Adding(&$Item) {

	//var_dump($Item);
	// Return FALSE if menu item not allowed

	return TRUE;
}
?>
<!-- Begin Main Menu -->
<div class="phpreportmaker">
<?php

// Generate all menu items
$RootMenu = new crMenu("RootMenu");
$RootMenu->IsRoot = TRUE;
$RootMenu->AddMenuItem(66, $ReportLanguage->Phrase("DetailSummaryReportMenuItemPrefix") . $ReportLanguage->MenuPhrase("66", "MenuText") . $ReportLanguage->Phrase("DetailSummaryReportMenuItemSuffix"), "Canceled_Reportssmry.php", -1, "", "", IsLoggedIn(), FALSE);
$RootMenu->AddMenuItem(43, $ReportLanguage->Phrase("DetailSummaryReportMenuItemPrefix") . $ReportLanguage->MenuPhrase("43", "MenuText") . $ReportLanguage->Phrase("DetailSummaryReportMenuItemSuffix"), "customers_dealsmry.php", -1, "", "", IsLoggedIn(), FALSE);
$RootMenu->AddMenuItem(45, $ReportLanguage->Phrase("DetailSummaryReportMenuItemPrefix") . $ReportLanguage->MenuPhrase("45", "MenuText") . $ReportLanguage->Phrase("DetailSummaryReportMenuItemSuffix"), "dealers_reportssmry.php", -1, "", "", IsLoggedIn(), FALSE);
$RootMenu->AddMenuItem(59, $ReportLanguage->Phrase("ChartReportMenuItemPrefix") . $ReportLanguage->MenuPhrase("59", "MenuText") . $ReportLanguage->Phrase("ChartReportMenuItemSuffix"), "dealers_reportssmry.php#cht_Dealer27s_Reort", 45, "", "", IsLoggedIn(), FALSE);
$RootMenu->AddMenuItem(53, $ReportLanguage->Phrase("DetailSummaryReportMenuItemPrefix") . $ReportLanguage->MenuPhrase("53", "MenuText") . $ReportLanguage->Phrase("DetailSummaryReportMenuItemSuffix"), "deals_detailssmry.php", -1, "", "", IsLoggedIn(), FALSE);
$RootMenu->AddMenuItem(57, $ReportLanguage->Phrase("DetailSummaryReportMenuItemPrefix") . $ReportLanguage->MenuPhrase("57", "MenuText") . $ReportLanguage->Phrase("DetailSummaryReportMenuItemSuffix"), "dealer_salesman_reportsmry.php", -1, "", "", IsLoggedIn(), FALSE);
$RootMenu->AddMenuItem(58, $ReportLanguage->Phrase("ChartReportMenuItemPrefix") . $ReportLanguage->MenuPhrase("58", "MenuText") . $ReportLanguage->Phrase("ChartReportMenuItemSuffix"), "dealer_salesman_reportsmry.php#cht_Chart_Report", 57, "", "", IsLoggedIn(), FALSE);
$RootMenu->AddMenuItem(47, $ReportLanguage->Phrase("DetailSummaryReportMenuItemPrefix") . $ReportLanguage->MenuPhrase("47", "MenuText") . $ReportLanguage->Phrase("DetailSummaryReportMenuItemSuffix"), "dealers_salesmensmry.php", -1, "", "", IsLoggedIn(), FALSE);
$RootMenu->AddMenuItem(60, $ReportLanguage->Phrase("ChartReportMenuItemPrefix") . $ReportLanguage->MenuPhrase("60", "MenuText") . $ReportLanguage->Phrase("ChartReportMenuItemSuffix"), "dealers_salesmensmry.php#cht_Salesman_Chart", 47, "", "", IsLoggedIn(), FALSE);
$RootMenu->AddMenuItem(49, $ReportLanguage->Phrase("DetailSummaryReportMenuItemPrefix") . $ReportLanguage->MenuPhrase("49", "MenuText") . $ReportLanguage->Phrase("DetailSummaryReportMenuItemSuffix"), "dealers_transactionsmry.php", -1, "", "", IsLoggedIn(), FALSE);
$RootMenu->AddMenuItem(62, $ReportLanguage->Phrase("ChartReportMenuItemPrefix") . $ReportLanguage->MenuPhrase("62", "MenuText") . $ReportLanguage->Phrase("ChartReportMenuItemSuffix"), "dealers_transactionsmry.php#cht_Dealers_Transaction", 49, "", "", IsLoggedIn(), FALSE);
$RootMenu->AddMenuItem(68, $ReportLanguage->Phrase("DetailSummaryReportMenuItemPrefix") . $ReportLanguage->MenuPhrase("68", "MenuText") . $ReportLanguage->Phrase("DetailSummaryReportMenuItemSuffix"), "DealersAndGroupssmry.php", -1, "", "", IsLoggedIn(), FALSE);
$RootMenu->AddMenuItem(69, $ReportLanguage->Phrase("ChartReportMenuItemPrefix") . $ReportLanguage->MenuPhrase("69", "MenuText") . $ReportLanguage->Phrase("ChartReportMenuItemSuffix"), "DealersAndGroupssmry.php#cht_Dealers27_Chart", 68, "", "", IsLoggedIn(), FALSE);
$RootMenu->AddMenuItem(61, $ReportLanguage->Phrase("ChartReportMenuItemPrefix") . $ReportLanguage->MenuPhrase("61", "MenuText") . $ReportLanguage->Phrase("ChartReportMenuItemSuffix"), "dealersTransactionrpt.php#cht_Deals_Sold", 48, "", "", IsLoggedIn(), FALSE);
if (IsLoggedIn()) {
	$RootMenu->AddMenuItem(0xFFFFFFFF, $ReportLanguage->Phrase("Logout"), "rlogout.php", -1, "", "", TRUE);
} elseif (substr(ewrpt_ScriptName(), 0 - strlen("rlogin.php")) <> "rlogin.php") {
	$RootMenu->AddMenuItem(0xFFFFFFFF, $ReportLanguage->Phrase("Login"), "rlogin.php", -1, "", "", TRUE);
}
$RootMenu->Render();
?>
</div>
<!-- End Main Menu -->
