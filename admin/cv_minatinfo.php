<?php

// Global variable for table object
$cv_minat = NULL;

//
// Table class for cv_minat
//
class ccv_minat extends cTable {
	var $id_minat_investasi;
	var $nib;
	var $nama;
	var $penanaman_modal;
	var $jenis_perusahaan;
	var $id_kecamatan;
	var $id_jenis;

	//
	// Table class constructor
	//
	function __construct() {
		global $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();
		$this->TableVar = 'cv_minat';
		$this->TableName = 'cv_minat';
		$this->TableType = 'CUSTOMVIEW';

		// Update Table
		$this->UpdateTable = "minat_investasi";
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
		$this->id_minat_investasi = new cField('cv_minat', 'cv_minat', 'x_id_minat_investasi', 'id_minat_investasi', '`id_minat_investasi`', '`id_minat_investasi`', 3, -1, FALSE, '`id_minat_investasi`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'NO');
		$this->id_minat_investasi->Sortable = TRUE; // Allow sort
		$this->id_minat_investasi->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['id_minat_investasi'] = &$this->id_minat_investasi;

		// nib
		$this->nib = new cField('cv_minat', 'cv_minat', 'x_nib', 'nib', '`nib`', '`nib`', 200, -1, TRUE, '`nib`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'FILE');
		$this->nib->Sortable = TRUE; // Allow sort
		$this->fields['nib'] = &$this->nib;

		// nama
		$this->nama = new cField('cv_minat', 'cv_minat', 'x_nama', 'nama', '`nama`', '`nama`', 200, -1, FALSE, '`nama`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->nama->Sortable = TRUE; // Allow sort
		$this->fields['nama'] = &$this->nama;

		// penanaman_modal
		$this->penanaman_modal = new cField('cv_minat', 'cv_minat', 'x_penanaman_modal', 'penanaman_modal', '`penanaman_modal`', '`penanaman_modal`', 3, -1, FALSE, '`penanaman_modal`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->penanaman_modal->Sortable = TRUE; // Allow sort
		$this->penanaman_modal->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['penanaman_modal'] = &$this->penanaman_modal;

		// jenis_perusahaan
		$this->jenis_perusahaan = new cField('cv_minat', 'cv_minat', 'x_jenis_perusahaan', 'jenis_perusahaan', '`jenis_perusahaan`', '`jenis_perusahaan`', 3, -1, FALSE, '`jenis_perusahaan`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->jenis_perusahaan->Sortable = TRUE; // Allow sort
		$this->jenis_perusahaan->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['jenis_perusahaan'] = &$this->jenis_perusahaan;

		// id_kecamatan
		$this->id_kecamatan = new cField('cv_minat', 'cv_minat', 'x_id_kecamatan', 'id_kecamatan', '`id_kecamatan`', '`id_kecamatan`', 3, -1, FALSE, '`id_kecamatan`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->id_kecamatan->Sortable = TRUE; // Allow sort
		$this->id_kecamatan->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['id_kecamatan'] = &$this->id_kecamatan;

		// id_jenis
		$this->id_jenis = new cField('cv_minat', 'cv_minat', 'x_id_jenis', 'id_jenis', '`id_jenis`', '`id_jenis`', 3, -1, FALSE, '`id_jenis`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->id_jenis->Sortable = TRUE; // Allow sort
		$this->id_jenis->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['id_jenis'] = &$this->id_jenis;
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
		return ($this->_SqlFrom <> "") ? $this->_SqlFrom : "minat_investasi";
	}

	function SqlFrom() { // For backward compatibility
		return $this->getSqlFrom();
	}

	function setSqlFrom($v) {
		$this->_SqlFrom = $v;
	}
	var $_SqlSelect = "";

	function getSqlSelect() { // Select
		return ($this->_SqlSelect <> "") ? $this->_SqlSelect : "SELECT minat_investasi.* FROM " . $this->getSqlFrom();
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
		return "";
	}

	// Key filter
	function KeyFilter() {
		$sKeyFilter = $this->SqlKeyFilter();
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
			return "cv_minatlist.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// List URL
	function GetListUrl() {
		return "cv_minatlist.php";
	}

	// View URL
	function GetViewUrl($parm = "") {
		if ($parm <> "")
			$url = $this->KeyUrl("cv_minatview.php", $this->UrlParm($parm));
		else
			$url = $this->KeyUrl("cv_minatview.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
		return $this->AddMasterUrl($url);
	}

	// Add URL
	function GetAddUrl($parm = "") {
		if ($parm <> "")
			$url = "cv_minatadd.php?" . $this->UrlParm($parm);
		else
			$url = "cv_minatadd.php";
		return $this->AddMasterUrl($url);
	}

	// Edit URL
	function GetEditUrl($parm = "") {
		$url = $this->KeyUrl("cv_minatedit.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline edit URL
	function GetInlineEditUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=edit"));
		return $this->AddMasterUrl($url);
	}

	// Copy URL
	function GetCopyUrl($parm = "") {
		$url = $this->KeyUrl("cv_minatadd.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline copy URL
	function GetInlineCopyUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=copy"));
		return $this->AddMasterUrl($url);
	}

	// Delete URL
	function GetDeleteUrl() {
		return $this->KeyUrl("cv_minatdelete.php", $this->UrlParm());
	}

	// Add master url
	function AddMasterUrl($url) {
		return $url;
	}

	function KeyToJson() {
		$json = "";
		return "{" . $json . "}";
	}

	// Add key value to URL
	function KeyUrl($url, $parm = "") {
		$sUrl = $url . "?";
		if ($parm <> "") $sUrl .= $parm . "&";
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

			//return $arKeys; // Do not return yet, so the values will also be checked by the following code
		}

		// Check keys
		$ar = array();
		if (is_array($arKeys)) {
			foreach ($arKeys as $key) {
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
		$this->nib->Upload->DbValue = $rs->fields('nib');
		$this->nama->setDbValue($rs->fields('nama'));
		$this->penanaman_modal->setDbValue($rs->fields('penanaman_modal'));
		$this->jenis_perusahaan->setDbValue($rs->fields('jenis_perusahaan'));
		$this->id_kecamatan->setDbValue($rs->fields('id_kecamatan'));
		$this->id_jenis->setDbValue($rs->fields('id_jenis'));
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
		// id_kecamatan
		// id_jenis
		// id_minat_investasi

		$this->id_minat_investasi->ViewValue = $this->id_minat_investasi->CurrentValue;
		$this->id_minat_investasi->ViewCustomAttributes = "";

		// nib
		if (!ew_Empty($this->nib->Upload->DbValue)) {
			$this->nib->ViewValue = $this->nib->Upload->DbValue;
		} else {
			$this->nib->ViewValue = "";
		}
		$this->nib->ViewCustomAttributes = "";

		// nama
		$this->nama->ViewValue = $this->nama->CurrentValue;
		$this->nama->ViewCustomAttributes = "";

		// penanaman_modal
		$this->penanaman_modal->ViewValue = $this->penanaman_modal->CurrentValue;
		$this->penanaman_modal->ViewCustomAttributes = "";

		// jenis_perusahaan
		$this->jenis_perusahaan->ViewValue = $this->jenis_perusahaan->CurrentValue;
		$this->jenis_perusahaan->ViewCustomAttributes = "";

		// id_kecamatan
		$this->id_kecamatan->ViewValue = $this->id_kecamatan->CurrentValue;
		$this->id_kecamatan->ViewCustomAttributes = "";

		// id_jenis
		$this->id_jenis->ViewValue = $this->id_jenis->CurrentValue;
		$this->id_jenis->ViewCustomAttributes = "";

		// id_minat_investasi
		$this->id_minat_investasi->LinkCustomAttributes = "";
		$this->id_minat_investasi->HrefValue = "";
		$this->id_minat_investasi->TooltipValue = "";

		// nib
		$this->nib->LinkCustomAttributes = "";
		$this->nib->HrefValue = "";
		$this->nib->HrefValue2 = $this->nib->UploadPath . $this->nib->Upload->DbValue;
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

		// id_kecamatan
		$this->id_kecamatan->LinkCustomAttributes = "";
		$this->id_kecamatan->HrefValue = "";
		$this->id_kecamatan->TooltipValue = "";

		// id_jenis
		$this->id_jenis->LinkCustomAttributes = "";
		$this->id_jenis->HrefValue = "";
		$this->id_jenis->TooltipValue = "";

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
		$this->id_minat_investasi->PlaceHolder = ew_RemoveHtml($this->id_minat_investasi->FldCaption());

		// nib
		$this->nib->EditAttrs["class"] = "form-control";
		$this->nib->EditCustomAttributes = "";
		if (!ew_Empty($this->nib->Upload->DbValue)) {
			$this->nib->EditValue = $this->nib->Upload->DbValue;
		} else {
			$this->nib->EditValue = "";
		}
		if (!ew_Empty($this->nib->CurrentValue))
			$this->nib->Upload->FileName = $this->nib->CurrentValue;

		// nama
		$this->nama->EditAttrs["class"] = "form-control";
		$this->nama->EditCustomAttributes = "";
		$this->nama->EditValue = $this->nama->CurrentValue;
		$this->nama->PlaceHolder = ew_RemoveHtml($this->nama->FldCaption());

		// penanaman_modal
		$this->penanaman_modal->EditAttrs["class"] = "form-control";
		$this->penanaman_modal->EditCustomAttributes = "";
		$this->penanaman_modal->EditValue = $this->penanaman_modal->CurrentValue;
		$this->penanaman_modal->PlaceHolder = ew_RemoveHtml($this->penanaman_modal->FldCaption());

		// jenis_perusahaan
		$this->jenis_perusahaan->EditAttrs["class"] = "form-control";
		$this->jenis_perusahaan->EditCustomAttributes = "";
		$this->jenis_perusahaan->EditValue = $this->jenis_perusahaan->CurrentValue;
		$this->jenis_perusahaan->PlaceHolder = ew_RemoveHtml($this->jenis_perusahaan->FldCaption());

		// id_kecamatan
		$this->id_kecamatan->EditAttrs["class"] = "form-control";
		$this->id_kecamatan->EditCustomAttributes = "";
		$this->id_kecamatan->EditValue = $this->id_kecamatan->CurrentValue;
		$this->id_kecamatan->PlaceHolder = ew_RemoveHtml($this->id_kecamatan->FldCaption());

		// id_jenis
		$this->id_jenis->EditAttrs["class"] = "form-control";
		$this->id_jenis->EditCustomAttributes = "";
		$this->id_jenis->EditValue = $this->id_jenis->CurrentValue;
		$this->id_jenis->PlaceHolder = ew_RemoveHtml($this->id_jenis->FldCaption());

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
					if ($this->id_kecamatan->Exportable) $Doc->ExportCaption($this->id_kecamatan);
					if ($this->id_jenis->Exportable) $Doc->ExportCaption($this->id_jenis);
				} else {
					if ($this->id_minat_investasi->Exportable) $Doc->ExportCaption($this->id_minat_investasi);
					if ($this->nib->Exportable) $Doc->ExportCaption($this->nib);
					if ($this->nama->Exportable) $Doc->ExportCaption($this->nama);
					if ($this->penanaman_modal->Exportable) $Doc->ExportCaption($this->penanaman_modal);
					if ($this->jenis_perusahaan->Exportable) $Doc->ExportCaption($this->jenis_perusahaan);
					if ($this->id_kecamatan->Exportable) $Doc->ExportCaption($this->id_kecamatan);
					if ($this->id_jenis->Exportable) $Doc->ExportCaption($this->id_jenis);
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
						if ($this->id_kecamatan->Exportable) $Doc->ExportField($this->id_kecamatan);
						if ($this->id_jenis->Exportable) $Doc->ExportField($this->id_jenis);
					} else {
						if ($this->id_minat_investasi->Exportable) $Doc->ExportField($this->id_minat_investasi);
						if ($this->nib->Exportable) $Doc->ExportField($this->nib);
						if ($this->nama->Exportable) $Doc->ExportField($this->nama);
						if ($this->penanaman_modal->Exportable) $Doc->ExportField($this->penanaman_modal);
						if ($this->jenis_perusahaan->Exportable) $Doc->ExportField($this->jenis_perusahaan);
						if ($this->id_kecamatan->Exportable) $Doc->ExportField($this->id_kecamatan);
						if ($this->id_jenis->Exportable) $Doc->ExportField($this->id_jenis);
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
