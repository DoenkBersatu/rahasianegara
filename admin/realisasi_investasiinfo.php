<?php

// Global variable for table object
$realisasi_investasi = NULL;

//
// Table class for realisasi_investasi
//
class crealisasi_investasi extends cTable {
	var $id_realisasi_investasi;
	var $id_triwulan;
	var $id_sektor;
	var $id_subsektor;
	var $jumlah_investasi;

	//
	// Table class constructor
	//
	function __construct() {
		global $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();
		$this->TableVar = 'realisasi_investasi';
		$this->TableName = 'realisasi_investasi';
		$this->TableType = 'TABLE';

		// Update Table
		$this->UpdateTable = "`realisasi_investasi`";
		$this->DBID = 'DB';
		$this->ExportAll = TRUE;
		$this->ExportPageBreakCount = 0; // Page break per every n record (PDF only)
		$this->ExportPageOrientation = "portrait"; // Page orientation (PDF only)
		$this->ExportPageSize = "a4"; // Page size (PDF only)
		$this->ExportExcelPageOrientation = ""; // Page orientation (PHPExcel only)
		$this->ExportExcelPageSize = ""; // Page size (PHPExcel only)
		$this->DetailAdd = FALSE; // Allow detail add
		$this->DetailEdit = FALSE; // Allow detail edit
		$this->DetailView = FALSE; // Allow detail view
		$this->ShowMultipleDetails = FALSE; // Show multiple details
		$this->GridAddRowCount = 5;
		$this->AllowAddDeleteRow = ew_AllowAddDeleteRow(); // Allow add/delete row
		$this->UserIDAllowSecurity = 0; // User ID Allow
		$this->BasicSearch = new cBasicSearch($this->TableVar);

		// id_realisasi_investasi
		$this->id_realisasi_investasi = new cField('realisasi_investasi', 'realisasi_investasi', 'x_id_realisasi_investasi', 'id_realisasi_investasi', '`id_realisasi_investasi`', '`id_realisasi_investasi`', 3, -1, FALSE, '`id_realisasi_investasi`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'NO');
		$this->id_realisasi_investasi->Sortable = TRUE; // Allow sort
		$this->id_realisasi_investasi->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['id_realisasi_investasi'] = &$this->id_realisasi_investasi;

		// id_triwulan
		$this->id_triwulan = new cField('realisasi_investasi', 'realisasi_investasi', 'x_id_triwulan', 'id_triwulan', '`id_triwulan`', '`id_triwulan`', 3, -1, FALSE, '`id_triwulan`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->id_triwulan->Sortable = TRUE; // Allow sort
		$this->id_triwulan->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->id_triwulan->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->id_triwulan->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['id_triwulan'] = &$this->id_triwulan;

		// id_sektor
		$this->id_sektor = new cField('realisasi_investasi', 'realisasi_investasi', 'x_id_sektor', 'id_sektor', '`id_sektor`', '`id_sektor`', 3, -1, FALSE, '`id_sektor`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->id_sektor->Sortable = TRUE; // Allow sort
		$this->id_sektor->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->id_sektor->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->id_sektor->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['id_sektor'] = &$this->id_sektor;

		// id_subsektor
		$this->id_subsektor = new cField('realisasi_investasi', 'realisasi_investasi', 'x_id_subsektor', 'id_subsektor', '`id_subsektor`', '`id_subsektor`', 3, -1, FALSE, '`id_subsektor`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->id_subsektor->Sortable = TRUE; // Allow sort
		$this->id_subsektor->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->id_subsektor->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->id_subsektor->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['id_subsektor'] = &$this->id_subsektor;

		// jumlah_investasi
		$this->jumlah_investasi = new cField('realisasi_investasi', 'realisasi_investasi', 'x_jumlah_investasi', 'jumlah_investasi', '`jumlah_investasi`', '`jumlah_investasi`', 20, -1, FALSE, '`jumlah_investasi`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->jumlah_investasi->Sortable = TRUE; // Allow sort
		$this->jumlah_investasi->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['jumlah_investasi'] = &$this->jumlah_investasi;
	}

	// Set Field Visibility
	function SetFieldVisibility($fldparm) {
		global $Security;
		return $this->$fldparm->Visible; // Returns original value
	}

	// Single column sort
	function UpdateSort(&$ofld) {
		if ($this->CurrentOrder == $ofld->FldName) {
			$sSortField = $ofld->FldExpression;
			$sLastSort = $ofld->getSort();
			if ($this->CurrentOrderType == "ASC" || $this->CurrentOrderType == "DESC") {
				$sThisSort = $this->CurrentOrderType;
			} else {
				$sThisSort = ($sLastSort == "ASC") ? "DESC" : "ASC";
			}
			$ofld->setSort($sThisSort);
			$this->setSessionOrderBy($sSortField . " " . $sThisSort); // Save to Session
		} else {
			$ofld->setSort("");
		}
	}

	// Table level SQL
	var $_SqlFrom = "";

	function getSqlFrom() { // From
		return ($this->_SqlFrom <> "") ? $this->_SqlFrom : "`realisasi_investasi`";
	}

	function SqlFrom() { // For backward compatibility
		return $this->getSqlFrom();
	}

	function setSqlFrom($v) {
		$this->_SqlFrom = $v;
	}
	var $_SqlSelect = "";

	function getSqlSelect() { // Select
		return ($this->_SqlSelect <> "") ? $this->_SqlSelect : "SELECT * FROM " . $this->getSqlFrom();
	}

	function SqlSelect() { // For backward compatibility
		return $this->getSqlSelect();
	}

	function setSqlSelect($v) {
		$this->_SqlSelect = $v;
	}
	var $_SqlWhere = "";

	function getSqlWhere() { // Where
		$sWhere = ($this->_SqlWhere <> "") ? $this->_SqlWhere : "";
		$this->TableFilter = "";
		ew_AddFilter($sWhere, $this->TableFilter);
		return $sWhere;
	}

	function SqlWhere() { // For backward compatibility
		return $this->getSqlWhere();
	}

	function setSqlWhere($v) {
		$this->_SqlWhere = $v;
	}
	var $_SqlGroupBy = "";

	function getSqlGroupBy() { // Group By
		return ($this->_SqlGroupBy <> "") ? $this->_SqlGroupBy : "";
	}

	function SqlGroupBy() { // For backward compatibility
		return $this->getSqlGroupBy();
	}

	function setSqlGroupBy($v) {
		$this->_SqlGroupBy = $v;
	}
	var $_SqlHaving = "";

	function getSqlHaving() { // Having
		return ($this->_SqlHaving <> "") ? $this->_SqlHaving : "";
	}

	function SqlHaving() { // For backward compatibility
		return $this->getSqlHaving();
	}

	function setSqlHaving($v) {
		$this->_SqlHaving = $v;
	}
	var $_SqlOrderBy = "";

	function getSqlOrderBy() { // Order By
		return ($this->_SqlOrderBy <> "") ? $this->_SqlOrderBy : "";
	}

	function SqlOrderBy() { // For backward compatibility
		return $this->getSqlOrderBy();
	}

	function setSqlOrderBy($v) {
		$this->_SqlOrderBy = $v;
	}

	// Apply User ID filters
	function ApplyUserIDFilters($sFilter) {
		return $sFilter;
	}

	// Check if User ID security allows view all
	function UserIDAllow($id = "") {
		$allow = EW_USER_ID_ALLOW;
		switch ($id) {
			case "add":
			case "copy":
			case "gridadd":
			case "register":
			case "addopt":
				return (($allow & 1) == 1);
			case "edit":
			case "gridedit":
			case "update":
			case "changepwd":
			case "forgotpwd":
				return (($allow & 4) == 4);
			case "delete":
				return (($allow & 2) == 2);
			case "view":
				return (($allow & 32) == 32);
			case "search":
				return (($allow & 64) == 64);
			default:
				return (($allow & 8) == 8);
		}
	}

	// Get SQL
	function GetSQL($where, $orderby) {
		return ew_BuildSelectSql($this->getSqlSelect(), $this->getSqlWhere(),
			$this->getSqlGroupBy(), $this->getSqlHaving(), $this->getSqlOrderBy(),
			$where, $orderby);
	}

	// Table SQL
	function SQL() {
		$sFilter = $this->CurrentFilter;
		$sFilter = $this->ApplyUserIDFilters($sFilter);
		$sSort = $this->getSessionOrderBy();
		return ew_BuildSelectSql($this->getSqlSelect(), $this->getSqlWhere(),
			$this->getSqlGroupBy(), $this->getSqlHaving(), $this->getSqlOrderBy(),
			$sFilter, $sSort);
	}

	// Table SQL with List page filter
	function SelectSQL() {
		$sFilter = $this->getSessionWhere();
		ew_AddFilter($sFilter, $this->CurrentFilter);
		$sFilter = $this->ApplyUserIDFilters($sFilter);
		$this->Recordset_Selecting($sFilter);
		$sSort = $this->getSessionOrderBy();
		return ew_BuildSelectSql($this->getSqlSelect(), $this->getSqlWhere(), $this->getSqlGroupBy(),
			$this->getSqlHaving(), $this->getSqlOrderBy(), $sFilter, $sSort);
	}

	// Get ORDER BY clause
	function GetOrderBy() {
		$sSort = $this->getSessionOrderBy();
		return ew_BuildSelectSql("", "", "", "", $this->getSqlOrderBy(), "", $sSort);
	}

	// Try to get record count
	function TryGetRecordCount($sSql) {
		$cnt = -1;
		if (($this->TableType == 'TABLE' || $this->TableType == 'VIEW' || $this->TableType == 'LINKTABLE') && preg_match("/^SELECT \* FROM/i", $sSql)) {
			$sSql = "SELECT COUNT(*) FROM" . preg_replace('/^SELECT\s([\s\S]+)?\*\sFROM/i', "", $sSql);
			$sOrderBy = $this->GetOrderBy();
			if (substr($sSql, strlen($sOrderBy) * -1) == $sOrderBy)
				$sSql = substr($sSql, 0, strlen($sSql) - strlen($sOrderBy)); // Remove ORDER BY clause
		} else {
			$sSql = "SELECT COUNT(*) FROM (" . $sSql . ") EW_COUNT_TABLE";
		}
		$conn = &$this->Connection();
		if ($rs = $conn->Execute($sSql)) {
			if (!$rs->EOF && $rs->FieldCount() > 0) {
				$cnt = $rs->fields[0];
				$rs->Close();
			}
		}
		return intval($cnt);
	}

	// Get record count based on filter (for detail record count in master table pages)
	function LoadRecordCount($sFilter) {
		$origFilter = $this->CurrentFilter;
		$this->CurrentFilter = $sFilter;
		$this->Recordset_Selecting($this->CurrentFilter);

		//$sSql = $this->SQL();
		$sSql = $this->GetSQL($this->CurrentFilter, "");
		$cnt = $this->TryGetRecordCount($sSql);
		if ($cnt == -1) {
			if ($rs = $this->LoadRs($this->CurrentFilter)) {
				$cnt = $rs->RecordCount();
				$rs->Close();
			}
		}
		$this->CurrentFilter = $origFilter;
		return intval($cnt);
	}

	// Get record count (for current List page)
	function SelectRecordCount() {
		$sSql = $this->SelectSQL();
		$cnt = $this->TryGetRecordCount($sSql);
		if ($cnt == -1) {
			$conn = &$this->Connection();
			if ($rs = $conn->Execute($sSql)) {
				$cnt = $rs->RecordCount();
				$rs->Close();
			}
		}
		return intval($cnt);
	}

	// INSERT statement
	function InsertSQL(&$rs) {
		$names = "";
		$values = "";
		foreach ($rs as $name => $value) {
			if (!isset($this->fields[$name]) || $this->fields[$name]->FldIsCustom)
				continue;
			$names .= $this->fields[$name]->FldExpression . ",";
			$values .= ew_QuotedValue($value, $this->fields[$name]->FldDataType, $this->DBID) . ",";
		}
		while (substr($names, -1) == ",")
			$names = substr($names, 0, -1);
		while (substr($values, -1) == ",")
			$values = substr($values, 0, -1);
		return "INSERT INTO " . $this->UpdateTable . " ($names) VALUES ($values)";
	}

	// Insert
	function Insert(&$rs) {
		$conn = &$this->Connection();
		$bInsert = $conn->Execute($this->InsertSQL($rs));
		if ($bInsert) {

			// Get insert id if necessary
			$this->id_realisasi_investasi->setDbValue($conn->Insert_ID());
			$rs['id_realisasi_investasi'] = $this->id_realisasi_investasi->DbValue;
		}
		return $bInsert;
	}

	// UPDATE statement
	function UpdateSQL(&$rs, $where = "", $curfilter = TRUE) {
		$sql = "UPDATE " . $this->UpdateTable . " SET ";
		foreach ($rs as $name => $value) {
			if (!isset($this->fields[$name]) || $this->fields[$name]->FldIsCustom)
				continue;
			$sql .= $this->fields[$name]->FldExpression . "=";
			$sql .= ew_QuotedValue($value, $this->fields[$name]->FldDataType, $this->DBID) . ",";
		}
		while (substr($sql, -1) == ",")
			$sql = substr($sql, 0, -1);
		$filter = ($curfilter) ? $this->CurrentFilter : "";
		if (is_array($where))
			$where = $this->ArrayToFilter($where);
		ew_AddFilter($filter, $where);
		if ($filter <> "")	$sql .= " WHERE " . $filter;
		return $sql;
	}

	// Update
	function Update(&$rs, $where = "", $rsold = NULL, $curfilter = TRUE) {
		$conn = &$this->Connection();
		$bUpdate = $conn->Execute($this->UpdateSQL($rs, $where, $curfilter));
		return $bUpdate;
	}

	// DELETE statement
	function DeleteSQL(&$rs, $where = "", $curfilter = TRUE) {
		$sql = "DELETE FROM " . $this->UpdateTable . " WHERE ";
		if (is_array($where))
			$where = $this->ArrayToFilter($where);
		if ($rs) {
			if (array_key_exists('id_realisasi_investasi', $rs))
				ew_AddFilter($where, ew_QuotedName('id_realisasi_investasi', $this->DBID) . '=' . ew_QuotedValue($rs['id_realisasi_investasi'], $this->id_realisasi_investasi->FldDataType, $this->DBID));
		}
		$filter = ($curfilter) ? $this->CurrentFilter : "";
		ew_AddFilter($filter, $where);
		if ($filter <> "")
			$sql .= $filter;
		else
			$sql .= "0=1"; // Avoid delete
		return $sql;
	}

	// Delete
	function Delete(&$rs, $where = "", $curfilter = TRUE) {
		$conn = &$this->Connection();
		$bDelete = $conn->Execute($this->DeleteSQL($rs, $where, $curfilter));
		return $bDelete;
	}

	// Key filter WHERE clause
	function SqlKeyFilter() {
		return "`id_realisasi_investasi` = @id_realisasi_investasi@";
	}

	// Key filter
	function KeyFilter() {
		$sKeyFilter = $this->SqlKeyFilter();
		if (!is_numeric($this->id_realisasi_investasi->CurrentValue))
			$sKeyFilter = "0=1"; // Invalid key
		$sKeyFilter = str_replace("@id_realisasi_investasi@", ew_AdjustSql($this->id_realisasi_investasi->CurrentValue, $this->DBID), $sKeyFilter); // Replace key value
		return $sKeyFilter;
	}

	// Return page URL
	function getReturnUrl() {
		$name = EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL;

		// Get referer URL automatically
		if (ew_ServerVar("HTTP_REFERER") <> "" && ew_ReferPage() <> ew_CurrentPage() && ew_ReferPage() <> "login.php") // Referer not same page or login page
			$_SESSION[$name] = ew_ServerVar("HTTP_REFERER"); // Save to Session
		if (@$_SESSION[$name] <> "") {
			return $_SESSION[$name];
		} else {
			return "realisasi_investasilist.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// List URL
	function GetListUrl() {
		return "realisasi_investasilist.php";
	}

	// View URL
	function GetViewUrl($parm = "") {
		if ($parm <> "")
			$url = $this->KeyUrl("realisasi_investasiview.php", $this->UrlParm($parm));
		else
			$url = $this->KeyUrl("realisasi_investasiview.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
		return $this->AddMasterUrl($url);
	}

	// Add URL
	function GetAddUrl($parm = "") {
		if ($parm <> "")
			$url = "realisasi_investasiadd.php?" . $this->UrlParm($parm);
		else
			$url = "realisasi_investasiadd.php";
		return $this->AddMasterUrl($url);
	}

	// Edit URL
	function GetEditUrl($parm = "") {
		$url = $this->KeyUrl("realisasi_investasiedit.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline edit URL
	function GetInlineEditUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=edit"));
		return $this->AddMasterUrl($url);
	}

	// Copy URL
	function GetCopyUrl($parm = "") {
		$url = $this->KeyUrl("realisasi_investasiadd.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline copy URL
	function GetInlineCopyUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=copy"));
		return $this->AddMasterUrl($url);
	}

	// Delete URL
	function GetDeleteUrl() {
		return $this->KeyUrl("realisasi_investasidelete.php", $this->UrlParm());
	}

	// Add master url
	function AddMasterUrl($url) {
		return $url;
	}

	function KeyToJson() {
		$json = "";
		$json .= "id_realisasi_investasi:" . ew_VarToJson($this->id_realisasi_investasi->CurrentValue, "number", "'");
		return "{" . $json . "}";
	}

	// Add key value to URL
	function KeyUrl($url, $parm = "") {
		$sUrl = $url . "?";
		if ($parm <> "") $sUrl .= $parm . "&";
		if (!is_null($this->id_realisasi_investasi->CurrentValue)) {
			$sUrl .= "id_realisasi_investasi=" . urlencode($this->id_realisasi_investasi->CurrentValue);
		} else {
			return "javascript:ew_Alert(ewLanguage.Phrase('InvalidRecord'));";
		}
		return $sUrl;
	}

	// Sort URL
	function SortUrl(&$fld) {
		if ($this->CurrentAction <> "" || $this->Export <> "" ||
			in_array($fld->FldType, array(128, 204, 205))) { // Unsortable data type
				return "";
		} elseif ($fld->Sortable) {
			$sUrlParm = $this->UrlParm("order=" . urlencode($fld->FldName) . "&amp;ordertype=" . $fld->ReverseSort());
			return $this->AddMasterUrl(ew_CurrentPage() . "?" . $sUrlParm);
		} else {
			return "";
		}
	}

	// Get record keys from $_POST/$_GET/$_SESSION
	function GetRecordKeys() {
		global $EW_COMPOSITE_KEY_SEPARATOR;
		$arKeys = array();
		$arKey = array();
		if (isset($_POST["key_m"])) {
			$arKeys = ew_StripSlashes($_POST["key_m"]);
			$cnt = count($arKeys);
		} elseif (isset($_GET["key_m"])) {
			$arKeys = ew_StripSlashes($_GET["key_m"]);
			$cnt = count($arKeys);
		} elseif (!empty($_GET) || !empty($_POST)) {
			$isPost = ew_IsHttpPost();
			if ($isPost && isset($_POST["id_realisasi_investasi"]))
				$arKeys[] = ew_StripSlashes($_POST["id_realisasi_investasi"]);
			elseif (isset($_GET["id_realisasi_investasi"]))
				$arKeys[] = ew_StripSlashes($_GET["id_realisasi_investasi"]);
			else
				$arKeys = NULL; // Do not setup

			//return $arKeys; // Do not return yet, so the values will also be checked by the following code
		}

		// Check keys
		$ar = array();
		if (is_array($arKeys)) {
			foreach ($arKeys as $key) {
				if (!is_numeric($key))
					continue;
				$ar[] = $key;
			}
		}
		return $ar;
	}

	// Get key filter
	function GetKeyFilter() {
		$arKeys = $this->GetRecordKeys();
		$sKeyFilter = "";
		foreach ($arKeys as $key) {
			if ($sKeyFilter <> "") $sKeyFilter .= " OR ";
			$this->id_realisasi_investasi->CurrentValue = $key;
			$sKeyFilter .= "(" . $this->KeyFilter() . ")";
		}
		return $sKeyFilter;
	}

	// Load rows based on filter
	function &LoadRs($sFilter) {

		// Set up filter (SQL WHERE clause) and get return SQL
		//$this->CurrentFilter = $sFilter;
		//$sSql = $this->SQL();

		$sSql = $this->GetSQL($sFilter, "");
		$conn = &$this->Connection();
		$rs = $conn->Execute($sSql);
		return $rs;
	}

	// Load row values from recordset
	function LoadListRowValues(&$rs) {
		$this->id_realisasi_investasi->setDbValue($rs->fields('id_realisasi_investasi'));
		$this->id_triwulan->setDbValue($rs->fields('id_triwulan'));
		$this->id_sektor->setDbValue($rs->fields('id_sektor'));
		$this->id_subsektor->setDbValue($rs->fields('id_subsektor'));
		$this->jumlah_investasi->setDbValue($rs->fields('jumlah_investasi'));
	}

	// Render list row values
	function RenderListRow() {
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

   // Common render codes
		// id_realisasi_investasi
		// id_triwulan
		// id_sektor
		// id_subsektor
		// jumlah_investasi
		// id_realisasi_investasi

		$this->id_realisasi_investasi->ViewValue = $this->id_realisasi_investasi->CurrentValue;
		$this->id_realisasi_investasi->ViewCustomAttributes = "";

		// id_triwulan
		if (strval($this->id_triwulan->CurrentValue) <> "") {
			$sFilterWrk = "`ID_triwulan`" . ew_SearchString("=", $this->id_triwulan->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `ID_triwulan`, `triwulan` AS `DispFld`, `tahun` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `triwulan`";
		$sWhereWrk = "";
		$this->id_triwulan->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->id_triwulan, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$arwrk[2] = $rswrk->fields('Disp2Fld');
				$this->id_triwulan->ViewValue = $this->id_triwulan->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->id_triwulan->ViewValue = $this->id_triwulan->CurrentValue;
			}
		} else {
			$this->id_triwulan->ViewValue = NULL;
		}
		$this->id_triwulan->ViewCustomAttributes = "";

		// id_sektor
		if (strval($this->id_sektor->CurrentValue) <> "") {
			$sFilterWrk = "`id_sektor`" . ew_SearchString("=", $this->id_sektor->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `id_sektor`, `sektor` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `sektor`";
		$sWhereWrk = "";
		$this->id_sektor->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->id_sektor, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->id_sektor->ViewValue = $this->id_sektor->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->id_sektor->ViewValue = $this->id_sektor->CurrentValue;
			}
		} else {
			$this->id_sektor->ViewValue = NULL;
		}
		$this->id_sektor->ViewCustomAttributes = "";

		// id_subsektor
		if (strval($this->id_subsektor->CurrentValue) <> "") {
			$sFilterWrk = "`id_subsektor`" . ew_SearchString("=", $this->id_subsektor->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `id_subsektor`, `subsektor` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `subsektor`";
		$sWhereWrk = "";
		$this->id_subsektor->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->id_subsektor, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->id_subsektor->ViewValue = $this->id_subsektor->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->id_subsektor->ViewValue = $this->id_subsektor->CurrentValue;
			}
		} else {
			$this->id_subsektor->ViewValue = NULL;
		}
		$this->id_subsektor->ViewCustomAttributes = "";

		// jumlah_investasi
		$this->jumlah_investasi->ViewValue = $this->jumlah_investasi->CurrentValue;
		$this->jumlah_investasi->ViewCustomAttributes = "";

		// id_realisasi_investasi
		$this->id_realisasi_investasi->LinkCustomAttributes = "";
		$this->id_realisasi_investasi->HrefValue = "";
		$this->id_realisasi_investasi->TooltipValue = "";

		// id_triwulan
		$this->id_triwulan->LinkCustomAttributes = "";
		$this->id_triwulan->HrefValue = "";
		$this->id_triwulan->TooltipValue = "";

		// id_sektor
		$this->id_sektor->LinkCustomAttributes = "";
		$this->id_sektor->HrefValue = "";
		$this->id_sektor->TooltipValue = "";

		// id_subsektor
		$this->id_subsektor->LinkCustomAttributes = "";
		$this->id_subsektor->HrefValue = "";
		$this->id_subsektor->TooltipValue = "";

		// jumlah_investasi
		$this->jumlah_investasi->LinkCustomAttributes = "";
		$this->jumlah_investasi->HrefValue = "";
		$this->jumlah_investasi->TooltipValue = "";

		// Call Row Rendered event
		$this->Row_Rendered();
	}

	// Render edit row values
	function RenderEditRow() {
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

		// id_realisasi_investasi
		$this->id_realisasi_investasi->EditAttrs["class"] = "form-control";
		$this->id_realisasi_investasi->EditCustomAttributes = "";
		$this->id_realisasi_investasi->EditValue = $this->id_realisasi_investasi->CurrentValue;
		$this->id_realisasi_investasi->ViewCustomAttributes = "";

		// id_triwulan
		$this->id_triwulan->EditAttrs["class"] = "form-control";
		$this->id_triwulan->EditCustomAttributes = "";

		// id_sektor
		$this->id_sektor->EditAttrs["class"] = "form-control";
		$this->id_sektor->EditCustomAttributes = "";

		// id_subsektor
		$this->id_subsektor->EditAttrs["class"] = "form-control";
		$this->id_subsektor->EditCustomAttributes = "";

		// jumlah_investasi
		$this->jumlah_investasi->EditAttrs["class"] = "form-control";
		$this->jumlah_investasi->EditCustomAttributes = "";
		$this->jumlah_investasi->EditValue = $this->jumlah_investasi->CurrentValue;
		$this->jumlah_investasi->PlaceHolder = ew_RemoveHtml($this->jumlah_investasi->FldCaption());

		// Call Row Rendered event
		$this->Row_Rendered();
	}

	// Aggregate list row values
	function AggregateListRowValues() {
	}

	// Aggregate list row (for rendering)
	function AggregateListRow() {

		// Call Row Rendered event
		$this->Row_Rendered();
	}
	var $ExportDoc;

	// Export data in HTML/CSV/Word/Excel/Email/PDF format
	function ExportDocument(&$Doc, &$Recordset, $StartRec, $StopRec, $ExportPageType = "") {
		if (!$Recordset || !$Doc)
			return;
		if (!$Doc->ExportCustom) {

			// Write header
			$Doc->ExportTableHeader();
			if ($Doc->Horizontal) { // Horizontal format, write header
				$Doc->BeginExportRow();
				if ($ExportPageType == "view") {
					if ($this->id_realisasi_investasi->Exportable) $Doc->ExportCaption($this->id_realisasi_investasi);
					if ($this->id_triwulan->Exportable) $Doc->ExportCaption($this->id_triwulan);
					if ($this->id_sektor->Exportable) $Doc->ExportCaption($this->id_sektor);
					if ($this->id_subsektor->Exportable) $Doc->ExportCaption($this->id_subsektor);
					if ($this->jumlah_investasi->Exportable) $Doc->ExportCaption($this->jumlah_investasi);
				} else {
					if ($this->id_realisasi_investasi->Exportable) $Doc->ExportCaption($this->id_realisasi_investasi);
					if ($this->id_triwulan->Exportable) $Doc->ExportCaption($this->id_triwulan);
					if ($this->id_sektor->Exportable) $Doc->ExportCaption($this->id_sektor);
					if ($this->id_subsektor->Exportable) $Doc->ExportCaption($this->id_subsektor);
					if ($this->jumlah_investasi->Exportable) $Doc->ExportCaption($this->jumlah_investasi);
				}
				$Doc->EndExportRow();
			}
		}

		// Move to first record
		$RecCnt = $StartRec - 1;
		if (!$Recordset->EOF) {
			$Recordset->MoveFirst();
			if ($StartRec > 1)
				$Recordset->Move($StartRec - 1);
		}
		while (!$Recordset->EOF && $RecCnt < $StopRec) {
			$RecCnt++;
			if (intval($RecCnt) >= intval($StartRec)) {
				$RowCnt = intval($RecCnt) - intval($StartRec) + 1;

				// Page break
				if ($this->ExportPageBreakCount > 0) {
					if ($RowCnt > 1 && ($RowCnt - 1) % $this->ExportPageBreakCount == 0)
						$Doc->ExportPageBreak();
				}
				$this->LoadListRowValues($Recordset);

				// Render row
				$this->RowType = EW_ROWTYPE_VIEW; // Render view
				$this->ResetAttrs();
				$this->RenderListRow();
				if (!$Doc->ExportCustom) {
					$Doc->BeginExportRow($RowCnt); // Allow CSS styles if enabled
					if ($ExportPageType == "view") {
						if ($this->id_realisasi_investasi->Exportable) $Doc->ExportField($this->id_realisasi_investasi);
						if ($this->id_triwulan->Exportable) $Doc->ExportField($this->id_triwulan);
						if ($this->id_sektor->Exportable) $Doc->ExportField($this->id_sektor);
						if ($this->id_subsektor->Exportable) $Doc->ExportField($this->id_subsektor);
						if ($this->jumlah_investasi->Exportable) $Doc->ExportField($this->jumlah_investasi);
					} else {
						if ($this->id_realisasi_investasi->Exportable) $Doc->ExportField($this->id_realisasi_investasi);
						if ($this->id_triwulan->Exportable) $Doc->ExportField($this->id_triwulan);
						if ($this->id_sektor->Exportable) $Doc->ExportField($this->id_sektor);
						if ($this->id_subsektor->Exportable) $Doc->ExportField($this->id_subsektor);
						if ($this->jumlah_investasi->Exportable) $Doc->ExportField($this->jumlah_investasi);
					}
					$Doc->EndExportRow();
				}
			}

			// Call Row Export server event
			if ($Doc->ExportCustom)
				$this->Row_Export($Recordset->fields);
			$Recordset->MoveNext();
		}
		if (!$Doc->ExportCustom) {
			$Doc->ExportTableFooter();
		}
	}

	// Get auto fill value
	function GetAutoFill($id, $val) {
		$rsarr = array();
		$rowcnt = 0;

		// Output
		if (is_array($rsarr) && $rowcnt > 0) {
			$fldcnt = count($rsarr[0]);
			for ($i = 0; $i < $rowcnt; $i++) {
				for ($j = 0; $j < $fldcnt; $j++) {
					$str = strval($rsarr[$i][$j]);
					$str = ew_ConvertToUtf8($str);
					if (isset($post["keepCRLF"])) {
						$str = str_replace(array("\r", "\n"), array("\\r", "\\n"), $str);
					} else {
						$str = str_replace(array("\r", "\n"), array(" ", " "), $str);
					}
					$rsarr[$i][$j] = $str;
				}
			}
			return ew_ArrayToJson($rsarr);
		} else {
			return FALSE;
		}
	}

	// Table level events
	// Recordset Selecting event
	function Recordset_Selecting(&$filter) {

		// Enter your code here	
	}

	// Recordset Selected event
	function Recordset_Selected(&$rs) {

		//echo "Recordset Selected";
	}

	// Recordset Search Validated event
	function Recordset_SearchValidated() {

		// Example:
		//$this->MyField1->AdvancedSearch->SearchValue = "your search criteria"; // Search value

	}

	// Recordset Searching event
	function Recordset_Searching(&$filter) {

		// Enter your code here	
	}

	// Row_Selecting event
	function Row_Selecting(&$filter) {

		// Enter your code here	
	}

	// Row Selected event
	function Row_Selected(&$rs) {

		//echo "Row Selected";
	}

	// Row Inserting event
	function Row_Inserting($rsold, &$rsnew) {

		// Enter your code here
		// To cancel, set return value to FALSE

		return TRUE;
	}

	// Row Inserted event
	function Row_Inserted($rsold, &$rsnew) {

		//echo "Row Inserted"
	}

	// Row Updating event
	function Row_Updating($rsold, &$rsnew) {

		// Enter your code here
		// To cancel, set return value to FALSE

		return TRUE;
	}

	// Row Updated event
	function Row_Updated($rsold, &$rsnew) {

		//echo "Row Updated";
	}

	// Row Update Conflict event
	function Row_UpdateConflict($rsold, &$rsnew) {

		// Enter your code here
		// To ignore conflict, set return value to FALSE

		return TRUE;
	}

	// Grid Inserting event
	function Grid_Inserting() {

		// Enter your code here
		// To reject grid insert, set return value to FALSE

		return TRUE;
	}

	// Grid Inserted event
	function Grid_Inserted($rsnew) {

		//echo "Grid Inserted";
	}

	// Grid Updating event
	function Grid_Updating($rsold) {

		// Enter your code here
		// To reject grid update, set return value to FALSE

		return TRUE;
	}

	// Grid Updated event
	function Grid_Updated($rsold, $rsnew) {

		//echo "Grid Updated";
	}

	// Row Deleting event
	function Row_Deleting(&$rs) {

		// Enter your code here
		// To cancel, set return value to False

		return TRUE;
	}

	// Row Deleted event
	function Row_Deleted(&$rs) {

		//echo "Row Deleted";
	}

	// Email Sending event
	function Email_Sending(&$Email, &$Args) {

		//var_dump($Email); var_dump($Args); exit();
		return TRUE;
	}

	// Lookup Selecting event
	function Lookup_Selecting($fld, &$filter) {

		//var_dump($fld->FldName, $fld->LookupFilters, $filter); // Uncomment to view the filter
		// Enter your code here

	}

	// Row Rendering event
	function Row_Rendering() {

		// Enter your code here	
	}

	// Row Rendered event
	function Row_Rendered() {

		// To view properties of field class, use:
		//var_dump($this-><FieldName>); 

	}

	// User ID Filtering event
	function UserID_Filtering(&$filter) {

		// Enter your code here
	}
}
?>
