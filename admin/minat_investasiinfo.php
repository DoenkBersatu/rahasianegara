<?php

// Global variable for table object
$minat_investasi = NULL;

//
// Table class for minat_investasi
//
class cminat_investasi extends cTable {
	var $id_minat_investasi;
	var $nib;
	var $nama;
	var $penanaman_modal;
	var $jenis_perusahaan;
	var $id_jenis;
	var $id_kecamatan;
	var $sysdate;

	//
	// Table class constructor
	//
	function __construct() {
		global $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();
		$this->TableVar = 'minat_investasi';
		$this->TableName = 'minat_investasi';
		$this->TableType = 'TABLE';

		// Update Table
		$this->UpdateTable = "`minat_investasi`";
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

		// id_minat_investasi
		$this->id_minat_investasi = new cField('minat_investasi', 'minat_investasi', 'x_id_minat_investasi', 'id_minat_investasi', '`id_minat_investasi`', '`id_minat_investasi`', 3, -1, FALSE, '`id_minat_investasi`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'NO');
		$this->id_minat_investasi->Sortable = TRUE; // Allow sort
		$this->id_minat_investasi->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['id_minat_investasi'] = &$this->id_minat_investasi;

		// nib
		$this->nib = new cField('minat_investasi', 'minat_investasi', 'x_nib', 'nib', '`nib`', '`nib`', 200, -1, FALSE, '`nib`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->nib->Sortable = TRUE; // Allow sort
		$this->fields['nib'] = &$this->nib;

		// nama
		$this->nama = new cField('minat_investasi', 'minat_investasi', 'x_nama', 'nama', '`nama`', '`nama`', 200, -1, FALSE, '`nama`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->nama->Sortable = TRUE; // Allow sort
		$this->fields['nama'] = &$this->nama;

		// penanaman_modal
		$this->penanaman_modal = new cField('minat_investasi', 'minat_investasi', 'x_penanaman_modal', 'penanaman_modal', '`penanaman_modal`', '`penanaman_modal`', 3, -1, FALSE, '`penanaman_modal`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->penanaman_modal->Sortable = TRUE; // Allow sort
		$this->penanaman_modal->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->penanaman_modal->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->penanaman_modal->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['penanaman_modal'] = &$this->penanaman_modal;

		// jenis_perusahaan
		$this->jenis_perusahaan = new cField('minat_investasi', 'minat_investasi', 'x_jenis_perusahaan', 'jenis_perusahaan', '`jenis_perusahaan`', '`jenis_perusahaan`', 3, -1, FALSE, '`jenis_perusahaan`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->jenis_perusahaan->Sortable = TRUE; // Allow sort
		$this->jenis_perusahaan->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->jenis_perusahaan->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->jenis_perusahaan->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['jenis_perusahaan'] = &$this->jenis_perusahaan;

		// id_jenis
		$this->id_jenis = new cField('minat_investasi', 'minat_investasi', 'x_id_jenis', 'id_jenis', '`id_jenis`', '`id_jenis`', 3, -1, FALSE, '`id_jenis`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->id_jenis->Sortable = TRUE; // Allow sort
		$this->id_jenis->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->id_jenis->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->id_jenis->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['id_jenis'] = &$this->id_jenis;

		// id_kecamatan
		$this->id_kecamatan = new cField('minat_investasi', 'minat_investasi', 'x_id_kecamatan', 'id_kecamatan', '`id_kecamatan`', '`id_kecamatan`', 3, -1, FALSE, '`id_kecamatan`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->id_kecamatan->Sortable = TRUE; // Allow sort
		$this->id_kecamatan->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->id_kecamatan->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->id_kecamatan->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['id_kecamatan'] = &$this->id_kecamatan;

		// sysdate
		$this->sysdate = new cField('minat_investasi', 'minat_investasi', 'x_sysdate', 'sysdate', '`sysdate`', ew_CastDateFieldForLike('`sysdate`', 0, "DB"), 135, 0, FALSE, '`sysdate`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->sysdate->Sortable = TRUE; // Allow sort
		$this->sysdate->FldDefaultErrMsg = str_replace("%s", $GLOBALS["EW_DATE_FORMAT"], $Language->Phrase("IncorrectDate"));
		$this->fields['sysdate'] = &$this->sysdate;
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
		return ($this->_SqlFrom <> "") ? $this->_SqlFrom : "`minat_investasi`";
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
			$this->id_minat_investasi->setDbValue($conn->Insert_ID());
			$rs['id_minat_investasi'] = $this->id_minat_investasi->DbValue;
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
			if (array_key_exists('id_minat_investasi', $rs))
				ew_AddFilter($where, ew_QuotedName('id_minat_investasi', $this->DBID) . '=' . ew_QuotedValue($rs['id_minat_investasi'], $this->id_minat_investasi->FldDataType, $this->DBID));
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
		return "`id_minat_investasi` = @id_minat_investasi@";
	}

	// Key filter
	function KeyFilter() {
		$sKeyFilter = $this->SqlKeyFilter();
		if (!is_numeric($this->id_minat_investasi->CurrentValue))
			$sKeyFilter = "0=1"; // Invalid key
		$sKeyFilter = str_replace("@id_minat_investasi@", ew_AdjustSql($this->id_minat_investasi->CurrentValue, $this->DBID), $sKeyFilter); // Replace key value
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
			return "minat_investasilist.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// List URL
	function GetListUrl() {
		return "minat_investasilist.php";
	}

	// View URL
	function GetViewUrl($parm = "") {
		if ($parm <> "")
			$url = $this->KeyUrl("minat_investasiview.php", $this->UrlParm($parm));
		else
			$url = $this->KeyUrl("minat_investasiview.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
		return $this->AddMasterUrl($url);
	}

	// Add URL
	function GetAddUrl($parm = "") {
		if ($parm <> "")
			$url = "minat_investasiadd.php?" . $this->UrlParm($parm);
		else
			$url = "minat_investasiadd.php";
		return $this->AddMasterUrl($url);
	}

	// Edit URL
	function GetEditUrl($parm = "") {
		$url = $this->KeyUrl("minat_investasiedit.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline edit URL
	function GetInlineEditUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=edit"));
		return $this->AddMasterUrl($url);
	}

	// Copy URL
	function GetCopyUrl($parm = "") {
		$url = $this->KeyUrl("minat_investasiadd.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline copy URL
	function GetInlineCopyUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=copy"));
		return $this->AddMasterUrl($url);
	}

	// Delete URL
	function GetDeleteUrl() {
		return $this->KeyUrl("minat_investasidelete.php", $this->UrlParm());
	}

	// Add master url
	function AddMasterUrl($url) {
		return $url;
	}

	function KeyToJson() {
		$json = "";
		$json .= "id_minat_investasi:" . ew_VarToJson($this->id_minat_investasi->CurrentValue, "number", "'");
		return "{" . $json . "}";
	}

	// Add key value to URL
	function KeyUrl($url, $parm = "") {
		$sUrl = $url . "?";
		if ($parm <> "") $sUrl .= $parm . "&";
		if (!is_null($this->id_minat_investasi->CurrentValue)) {
			$sUrl .= "id_minat_investasi=" . urlencode($this->id_minat_investasi->CurrentValue);
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
			if ($isPost && isset($_POST["id_minat_investasi"]))
				$arKeys[] = ew_StripSlashes($_POST["id_minat_investasi"]);
			elseif (isset($_GET["id_minat_investasi"]))
				$arKeys[] = ew_StripSlashes($_GET["id_minat_investasi"]);
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
			$this->id_minat_investasi->CurrentValue = $key;
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
		$this->id_minat_investasi->setDbValue($rs->fields('id_minat_investasi'));
		$this->nib->setDbValue($rs->fields('nib'));
		$this->nama->setDbValue($rs->fields('nama'));
		$this->penanaman_modal->setDbValue($rs->fields('penanaman_modal'));
		$this->jenis_perusahaan->setDbValue($rs->fields('jenis_perusahaan'));
		$this->id_jenis->setDbValue($rs->fields('id_jenis'));
		$this->id_kecamatan->setDbValue($rs->fields('id_kecamatan'));
		$this->sysdate->setDbValue($rs->fields('sysdate'));
	}

	// Render list row values
	function RenderListRow() {
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

   // Common render codes
		// id_minat_investasi
		// nib
		// nama
		// penanaman_modal
		// jenis_perusahaan
		// id_jenis
		// id_kecamatan
		// sysdate
		// id_minat_investasi

		$this->id_minat_investasi->ViewValue = $this->id_minat_investasi->CurrentValue;
		$this->id_minat_investasi->ViewCustomAttributes = "";

		// nib
		$this->nib->ViewValue = $this->nib->CurrentValue;
		$this->nib->ViewCustomAttributes = "";

		// nama
		$this->nama->ViewValue = $this->nama->CurrentValue;
		$this->nama->ViewCustomAttributes = "";

		// penanaman_modal
		if (strval($this->penanaman_modal->CurrentValue) <> "") {
			$sFilterWrk = "`id_status`" . ew_SearchString("=", $this->penanaman_modal->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `id_status`, `status` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `status`";
		$sWhereWrk = "";
		$this->penanaman_modal->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->penanaman_modal, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->penanaman_modal->ViewValue = $this->penanaman_modal->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->penanaman_modal->ViewValue = $this->penanaman_modal->CurrentValue;
			}
		} else {
			$this->penanaman_modal->ViewValue = NULL;
		}
		$this->penanaman_modal->ViewCustomAttributes = "";

		// jenis_perusahaan
		if (strval($this->jenis_perusahaan->CurrentValue) <> "") {
			$sFilterWrk = "`id_jp`" . ew_SearchString("=", $this->jenis_perusahaan->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `id_jp`, `jenis_perusahaan` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `jenis_perusahaan`";
		$sWhereWrk = "";
		$this->jenis_perusahaan->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->jenis_perusahaan, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->jenis_perusahaan->ViewValue = $this->jenis_perusahaan->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->jenis_perusahaan->ViewValue = $this->jenis_perusahaan->CurrentValue;
			}
		} else {
			$this->jenis_perusahaan->ViewValue = NULL;
		}
		$this->jenis_perusahaan->ViewCustomAttributes = "";

		// id_jenis
		if (strval($this->id_jenis->CurrentValue) <> "") {
			$sFilterWrk = "`id_jenis`" . ew_SearchString("=", $this->id_jenis->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `id_jenis`, `jenis` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `jenis`";
		$sWhereWrk = "";
		$this->id_jenis->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->id_jenis, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->id_jenis->ViewValue = $this->id_jenis->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->id_jenis->ViewValue = $this->id_jenis->CurrentValue;
			}
		} else {
			$this->id_jenis->ViewValue = NULL;
		}
		$this->id_jenis->ViewCustomAttributes = "";

		// id_kecamatan
		if (strval($this->id_kecamatan->CurrentValue) <> "") {
			$sFilterWrk = "`id_kecamatan`" . ew_SearchString("=", $this->id_kecamatan->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `id_kecamatan`, `kecamatan` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `kecamatan`";
		$sWhereWrk = "";
		$this->id_kecamatan->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->id_kecamatan, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->id_kecamatan->ViewValue = $this->id_kecamatan->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->id_kecamatan->ViewValue = $this->id_kecamatan->CurrentValue;
			}
		} else {
			$this->id_kecamatan->ViewValue = NULL;
		}
		$this->id_kecamatan->ViewCustomAttributes = "";

		// sysdate
		$this->sysdate->ViewValue = $this->sysdate->CurrentValue;
		$this->sysdate->ViewValue = ew_FormatDateTime($this->sysdate->ViewValue, 0);
		$this->sysdate->ViewCustomAttributes = "";

		// id_minat_investasi
		$this->id_minat_investasi->LinkCustomAttributes = "";
		$this->id_minat_investasi->HrefValue = "";
		$this->id_minat_investasi->TooltipValue = "";

		// nib
		$this->nib->LinkCustomAttributes = "";
		$this->nib->HrefValue = "";
		$this->nib->TooltipValue = "";

		// nama
		$this->nama->LinkCustomAttributes = "";
		$this->nama->HrefValue = "";
		$this->nama->TooltipValue = "";

		// penanaman_modal
		$this->penanaman_modal->LinkCustomAttributes = "";
		$this->penanaman_modal->HrefValue = "";
		$this->penanaman_modal->TooltipValue = "";

		// jenis_perusahaan
		$this->jenis_perusahaan->LinkCustomAttributes = "";
		$this->jenis_perusahaan->HrefValue = "";
		$this->jenis_perusahaan->TooltipValue = "";

		// id_jenis
		$this->id_jenis->LinkCustomAttributes = "";
		$this->id_jenis->HrefValue = "";
		$this->id_jenis->TooltipValue = "";

		// id_kecamatan
		$this->id_kecamatan->LinkCustomAttributes = "";
		$this->id_kecamatan->HrefValue = "";
		$this->id_kecamatan->TooltipValue = "";

		// sysdate
		$this->sysdate->LinkCustomAttributes = "";
		$this->sysdate->HrefValue = "";
		$this->sysdate->TooltipValue = "";

		// Call Row Rendered event
		$this->Row_Rendered();
	}

	// Render edit row values
	function RenderEditRow() {
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

		// id_minat_investasi
		$this->id_minat_investasi->EditAttrs["class"] = "form-control";
		$this->id_minat_investasi->EditCustomAttributes = "";
		$this->id_minat_investasi->EditValue = $this->id_minat_investasi->CurrentValue;
		$this->id_minat_investasi->ViewCustomAttributes = "";

		// nib
		$this->nib->EditAttrs["class"] = "form-control";
		$this->nib->EditCustomAttributes = "";
		$this->nib->EditValue = $this->nib->CurrentValue;
		$this->nib->PlaceHolder = ew_RemoveHtml($this->nib->FldCaption());

		// nama
		$this->nama->EditAttrs["class"] = "form-control";
		$this->nama->EditCustomAttributes = "";
		$this->nama->EditValue = $this->nama->CurrentValue;
		$this->nama->PlaceHolder = ew_RemoveHtml($this->nama->FldCaption());

		// penanaman_modal
		$this->penanaman_modal->EditAttrs["class"] = "form-control";
		$this->penanaman_modal->EditCustomAttributes = "";

		// jenis_perusahaan
		$this->jenis_perusahaan->EditAttrs["class"] = "form-control";
		$this->jenis_perusahaan->EditCustomAttributes = "";

		// id_jenis
		$this->id_jenis->EditAttrs["class"] = "form-control";
		$this->id_jenis->EditCustomAttributes = "";

		// id_kecamatan
		$this->id_kecamatan->EditAttrs["class"] = "form-control";
		$this->id_kecamatan->EditCustomAttributes = "";

		// sysdate
		$this->sysdate->EditAttrs["class"] = "form-control";
		$this->sysdate->EditCustomAttributes = "";
		$this->sysdate->EditValue = ew_FormatDateTime($this->sysdate->CurrentValue, 8);
		$this->sysdate->PlaceHolder = ew_RemoveHtml($this->sysdate->FldCaption());

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
					if ($this->id_minat_investasi->Exportable) $Doc->ExportCaption($this->id_minat_investasi);
					if ($this->nib->Exportable) $Doc->ExportCaption($this->nib);
					if ($this->nama->Exportable) $Doc->ExportCaption($this->nama);
					if ($this->penanaman_modal->Exportable) $Doc->ExportCaption($this->penanaman_modal);
					if ($this->jenis_perusahaan->Exportable) $Doc->ExportCaption($this->jenis_perusahaan);
					if ($this->id_jenis->Exportable) $Doc->ExportCaption($this->id_jenis);
					if ($this->id_kecamatan->Exportable) $Doc->ExportCaption($this->id_kecamatan);
					if ($this->sysdate->Exportable) $Doc->ExportCaption($this->sysdate);
				} else {
					if ($this->id_minat_investasi->Exportable) $Doc->ExportCaption($this->id_minat_investasi);
					if ($this->nib->Exportable) $Doc->ExportCaption($this->nib);
					if ($this->nama->Exportable) $Doc->ExportCaption($this->nama);
					if ($this->penanaman_modal->Exportable) $Doc->ExportCaption($this->penanaman_modal);
					if ($this->jenis_perusahaan->Exportable) $Doc->ExportCaption($this->jenis_perusahaan);
					if ($this->id_jenis->Exportable) $Doc->ExportCaption($this->id_jenis);
					if ($this->id_kecamatan->Exportable) $Doc->ExportCaption($this->id_kecamatan);
					if ($this->sysdate->Exportable) $Doc->ExportCaption($this->sysdate);
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
						if ($this->id_minat_investasi->Exportable) $Doc->ExportField($this->id_minat_investasi);
						if ($this->nib->Exportable) $Doc->ExportField($this->nib);
						if ($this->nama->Exportable) $Doc->ExportField($this->nama);
						if ($this->penanaman_modal->Exportable) $Doc->ExportField($this->penanaman_modal);
						if ($this->jenis_perusahaan->Exportable) $Doc->ExportField($this->jenis_perusahaan);
						if ($this->id_jenis->Exportable) $Doc->ExportField($this->id_jenis);
						if ($this->id_kecamatan->Exportable) $Doc->ExportField($this->id_kecamatan);
						if ($this->sysdate->Exportable) $Doc->ExportField($this->sysdate);
					} else {
						if ($this->id_minat_investasi->Exportable) $Doc->ExportField($this->id_minat_investasi);
						if ($this->nib->Exportable) $Doc->ExportField($this->nib);
						if ($this->nama->Exportable) $Doc->ExportField($this->nama);
						if ($this->penanaman_modal->Exportable) $Doc->ExportField($this->penanaman_modal);
						if ($this->jenis_perusahaan->Exportable) $Doc->ExportField($this->jenis_perusahaan);
						if ($this->id_jenis->Exportable) $Doc->ExportField($this->id_jenis);
						if ($this->id_kecamatan->Exportable) $Doc->ExportField($this->id_kecamatan);
						if ($this->sysdate->Exportable) $Doc->ExportField($this->sysdate);
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
