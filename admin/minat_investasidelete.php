<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "minat_investasiinfo.php" ?>
<?php include_once "userinfo.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$minat_investasi_delete = NULL; // Initialize page object first

class cminat_investasi_delete extends cminat_investasi {

	// Page ID
	var $PageID = 'delete';

	// Project ID
	var $ProjectID = "{711D4B7A-499A-4AB9-B89B-D8472076C077}";

	// Table name
	var $TableName = 'minat_investasi';

	// Page object name
	var $PageObjName = 'minat_investasi_delete';

	// Page name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page URL
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
		if ($this->UseTokenInUrl) $PageUrl .= "t=" . $this->TableVar . "&"; // Add page token
		return $PageUrl;
	}

	// Message
	function getMessage() {
		return @$_SESSION[EW_SESSION_MESSAGE];
	}

	function setMessage($v) {
		ew_AddMessage($_SESSION[EW_SESSION_MESSAGE], $v);
	}

	function getFailureMessage() {
		return @$_SESSION[EW_SESSION_FAILURE_MESSAGE];
	}

	function setFailureMessage($v) {
		ew_AddMessage($_SESSION[EW_SESSION_FAILURE_MESSAGE], $v);
	}

	function getSuccessMessage() {
		return @$_SESSION[EW_SESSION_SUCCESS_MESSAGE];
	}

	function setSuccessMessage($v) {
		ew_AddMessage($_SESSION[EW_SESSION_SUCCESS_MESSAGE], $v);
	}

	function getWarningMessage() {
		return @$_SESSION[EW_SESSION_WARNING_MESSAGE];
	}

	function setWarningMessage($v) {
		ew_AddMessage($_SESSION[EW_SESSION_WARNING_MESSAGE], $v);
	}

	// Methods to clear message
	function ClearMessage() {
		$_SESSION[EW_SESSION_MESSAGE] = "";
	}

	function ClearFailureMessage() {
		$_SESSION[EW_SESSION_FAILURE_MESSAGE] = "";
	}

	function ClearSuccessMessage() {
		$_SESSION[EW_SESSION_SUCCESS_MESSAGE] = "";
	}

	function ClearWarningMessage() {
		$_SESSION[EW_SESSION_WARNING_MESSAGE] = "";
	}

	function ClearMessages() {
		$_SESSION[EW_SESSION_MESSAGE] = "";
		$_SESSION[EW_SESSION_FAILURE_MESSAGE] = "";
		$_SESSION[EW_SESSION_SUCCESS_MESSAGE] = "";
		$_SESSION[EW_SESSION_WARNING_MESSAGE] = "";
	}

	// Show message
	function ShowMessage() {
		$hidden = FALSE;
		$html = "";

		// Message
		$sMessage = $this->getMessage();
		if (method_exists($this, "Message_Showing"))
			$this->Message_Showing($sMessage, "");
		if ($sMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sMessage;
			$html .= "<div class=\"alert alert-info ewInfo\">" . $sMessage . "</div>";
			$_SESSION[EW_SESSION_MESSAGE] = ""; // Clear message in Session
		}

		// Warning message
		$sWarningMessage = $this->getWarningMessage();
		if (method_exists($this, "Message_Showing"))
			$this->Message_Showing($sWarningMessage, "warning");
		if ($sWarningMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sWarningMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sWarningMessage;
			$html .= "<div class=\"alert alert-warning ewWarning\">" . $sWarningMessage . "</div>";
			$_SESSION[EW_SESSION_WARNING_MESSAGE] = ""; // Clear message in Session
		}

		// Success message
		$sSuccessMessage = $this->getSuccessMessage();
		if (method_exists($this, "Message_Showing"))
			$this->Message_Showing($sSuccessMessage, "success");
		if ($sSuccessMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sSuccessMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sSuccessMessage;
			$html .= "<div class=\"alert alert-success ewSuccess\">" . $sSuccessMessage . "</div>";
			$_SESSION[EW_SESSION_SUCCESS_MESSAGE] = ""; // Clear message in Session
		}

		// Failure message
		$sErrorMessage = $this->getFailureMessage();
		if (method_exists($this, "Message_Showing"))
			$this->Message_Showing($sErrorMessage, "failure");
		if ($sErrorMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sErrorMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sErrorMessage;
			$html .= "<div class=\"alert alert-danger ewError\">" . $sErrorMessage . "</div>";
			$_SESSION[EW_SESSION_FAILURE_MESSAGE] = ""; // Clear message in Session
		}
		echo "<div class=\"ewMessageDialog\"" . (($hidden) ? " style=\"display: none;\"" : "") . ">" . $html . "</div>";
	}
	var $PageHeader;
	var $PageFooter;

	// Show Page Header
	function ShowPageHeader() {
		$sHeader = $this->PageHeader;
		$this->Page_DataRendering($sHeader);
		if ($sHeader <> "") { // Header exists, display
			echo "<p>" . $sHeader . "</p>";
		}
	}

	// Show Page Footer
	function ShowPageFooter() {
		$sFooter = $this->PageFooter;
		$this->Page_DataRendered($sFooter);
		if ($sFooter <> "") { // Footer exists, display
			echo "<p>" . $sFooter . "</p>";
		}
	}

	// Validate page request
	function IsPageRequest() {
		global $objForm;
		if ($this->UseTokenInUrl) {
			if ($objForm)
				return ($this->TableVar == $objForm->GetValue("t"));
			if (@$_GET["t"] <> "")
				return ($this->TableVar == $_GET["t"]);
		} else {
			return TRUE;
		}
	}
	var $Token = "";
	var $TokenTimeout = 0;
	var $CheckToken = EW_CHECK_TOKEN;
	var $CheckTokenFn = "ew_CheckToken";
	var $CreateTokenFn = "ew_CreateToken";

	// Valid Post
	function ValidPost() {
		if (!$this->CheckToken || !ew_IsHttpPost())
			return TRUE;
		if (!isset($_POST[EW_TOKEN_NAME]))
			return FALSE;
		$fn = $this->CheckTokenFn;
		if (is_callable($fn))
			return $fn($_POST[EW_TOKEN_NAME], $this->TokenTimeout);
		return FALSE;
	}

	// Create Token
	function CreateToken() {
		global $gsToken;
		if ($this->CheckToken) {
			$fn = $this->CreateTokenFn;
			if ($this->Token == "" && is_callable($fn)) // Create token
				$this->Token = $fn();
			$gsToken = $this->Token; // Save to global variable
		}
	}

	//
	// Page class constructor
	//
	function __construct() {
		global $conn, $Language;
		global $UserTable, $UserTableConn;
		$GLOBALS["Page"] = &$this;
		$this->TokenTimeout = ew_SessionTimeoutTime();

		// Language object
		if (!isset($Language)) $Language = new cLanguage();

		// Parent constuctor
		parent::__construct();

		// Table object (minat_investasi)
		if (!isset($GLOBALS["minat_investasi"]) || get_class($GLOBALS["minat_investasi"]) == "cminat_investasi") {
			$GLOBALS["minat_investasi"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["minat_investasi"];
		}

		// Table object (user)
		if (!isset($GLOBALS['user'])) $GLOBALS['user'] = new cuser();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'delete', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'minat_investasi', TRUE);

		// Start timer
		if (!isset($GLOBALS["gTimer"])) $GLOBALS["gTimer"] = new cTimer();

		// Open connection
		if (!isset($conn)) $conn = ew_Connect($this->DBID);

		// User table object (user)
		if (!isset($UserTable)) {
			$UserTable = new cuser();
			$UserTableConn = Conn($UserTable->DBID);
		}
	}

	//
	//  Page_Init
	//
	function Page_Init() {
		global $gsExport, $gsCustomExport, $gsExportFile, $UserProfile, $Language, $Security, $objForm;

		// Security
		$Security = new cAdvancedSecurity();
		if (!$Security->IsLoggedIn()) $Security->AutoLogin();
		if ($Security->IsLoggedIn()) $Security->TablePermission_Loading();
		$Security->LoadCurrentUserLevel($this->ProjectID . $this->TableName);
		if ($Security->IsLoggedIn()) $Security->TablePermission_Loaded();
		if (!$Security->CanDelete()) {
			$Security->SaveLastUrl();
			$this->setFailureMessage(ew_DeniedMsg()); // Set no permission
			if ($Security->CanList())
				$this->Page_Terminate(ew_GetUrl("minat_investasilist.php"));
			else
				$this->Page_Terminate(ew_GetUrl("login.php"));
		}
		if ($Security->IsLoggedIn()) {
			$Security->UserID_Loading();
			$Security->LoadUserID();
			$Security->UserID_Loaded();
		}
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action
		$this->nib->SetVisibility();
		$this->nama->SetVisibility();
		$this->penanaman_modal->SetVisibility();
		$this->jenis_perusahaan->SetVisibility();
		$this->id_jenis->SetVisibility();
		$this->id_kecamatan->SetVisibility();
		$this->sysdate->SetVisibility();

		// Global Page Loading event (in userfn*.php)
		Page_Loading();

		// Page Load event
		$this->Page_Load();

		// Check token
		if (!$this->ValidPost()) {
			echo $Language->Phrase("InvalidPostRequest");
			$this->Page_Terminate();
			exit();
		}

		// Create Token
		$this->CreateToken();
	}

	//
	// Page_Terminate
	//
	function Page_Terminate($url = "") {
		global $gsExportFile, $gTmpImages;

		// Page Unload event
		$this->Page_Unload();

		// Global Page Unloaded event (in userfn*.php)
		Page_Unloaded();

		// Export
		global $EW_EXPORT, $minat_investasi;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($minat_investasi);
				$doc->Text = $sContent;
				if ($this->Export == "email")
					echo $this->ExportEmail($doc->Text);
				else
					$doc->Export();
				ew_DeleteTmpImages(); // Delete temp images
				exit();
			}
		}
		$this->Page_Redirecting($url);

		 // Close connection
		ew_CloseConn();

		// Go to URL if specified
		if ($url <> "") {
			if (!EW_DEBUG_ENABLED && ob_get_length())
				ob_end_clean();
			header("Location: " . $url);
		}
		exit();
	}
	var $DbMasterFilter = "";
	var $DbDetailFilter = "";
	var $StartRec;
	var $TotalRecs = 0;
	var $RecCnt;
	var $RecKeys = array();
	var $Recordset;
	var $StartRowCnt = 1;
	var $RowCnt = 0;

	//
	// Page main
	//
	function Page_Main() {
		global $Language;

		// Set up Breadcrumb
		$this->SetupBreadcrumb();

		// Load key parameters
		$this->RecKeys = $this->GetRecordKeys(); // Load record keys
		$sFilter = $this->GetKeyFilter();
		if ($sFilter == "")
			$this->Page_Terminate("minat_investasilist.php"); // Prevent SQL injection, return to list

		// Set up filter (SQL WHHERE clause) and get return SQL
		// SQL constructor in minat_investasi class, minat_investasiinfo.php

		$this->CurrentFilter = $sFilter;

		// Get action
		if (@$_POST["a_delete"] <> "") {
			$this->CurrentAction = $_POST["a_delete"];
		} elseif (@$_GET["a_delete"] == "1") {
			$this->CurrentAction = "D"; // Delete record directly
		} else {
			$this->CurrentAction = "I"; // Display record
		}
		if ($this->CurrentAction == "D") {
			$this->SendEmail = TRUE; // Send email on delete success
			if ($this->DeleteRows()) { // Delete rows
				if ($this->getSuccessMessage() == "")
					$this->setSuccessMessage($Language->Phrase("DeleteSuccess")); // Set up success message
				$this->Page_Terminate($this->getReturnUrl()); // Return to caller
			} else { // Delete failed
				$this->CurrentAction = "I"; // Display record
			}
		}
		if ($this->CurrentAction == "I") { // Load records for display
			if ($this->Recordset = $this->LoadRecordset())
				$this->TotalRecs = $this->Recordset->RecordCount(); // Get record count
			if ($this->TotalRecs <= 0) { // No record found, exit
				if ($this->Recordset)
					$this->Recordset->Close();
				$this->Page_Terminate("minat_investasilist.php"); // Return to list
			}
		}
	}

	// Load recordset
	function LoadRecordset($offset = -1, $rowcnt = -1) {

		// Load List page SQL
		$sSql = $this->SelectSQL();
		$conn = &$this->Connection();

		// Load recordset
		$dbtype = ew_GetConnectionType($this->DBID);
		if ($this->UseSelectLimit) {
			$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
			if ($dbtype == "MSSQL") {
				$rs = $conn->SelectLimit($sSql, $rowcnt, $offset, array("_hasOrderBy" => trim($this->getOrderBy()) || trim($this->getSessionOrderBy())));
			} else {
				$rs = $conn->SelectLimit($sSql, $rowcnt, $offset);
			}
			$conn->raiseErrorFn = '';
		} else {
			$rs = ew_LoadRecordset($sSql, $conn);
		}

		// Call Recordset Selected event
		$this->Recordset_Selected($rs);
		return $rs;
	}

	// Load row based on key values
	function LoadRow() {
		global $Security, $Language;
		$sFilter = $this->KeyFilter();

		// Call Row Selecting event
		$this->Row_Selecting($sFilter);

		// Load SQL based on filter
		$this->CurrentFilter = $sFilter;
		$sSql = $this->SQL();
		$conn = &$this->Connection();
		$res = FALSE;
		$rs = ew_LoadRecordset($sSql, $conn);
		if ($rs && !$rs->EOF) {
			$res = TRUE;
			$this->LoadRowValues($rs); // Load row values
			$rs->Close();
		}
		return $res;
	}

	// Load row values from recordset
	function LoadRowValues(&$rs) {
		if (!$rs || $rs->EOF) return;

		// Call Row Selected event
		$row = &$rs->fields;
		$this->Row_Selected($row);
		$this->id_minat_investasi->setDbValue($rs->fields('id_minat_investasi'));
		$this->nib->setDbValue($rs->fields('nib'));
		$this->nama->setDbValue($rs->fields('nama'));
		$this->penanaman_modal->setDbValue($rs->fields('penanaman_modal'));
		$this->jenis_perusahaan->setDbValue($rs->fields('jenis_perusahaan'));
		$this->id_jenis->setDbValue($rs->fields('id_jenis'));
		$this->id_kecamatan->setDbValue($rs->fields('id_kecamatan'));
		$this->sysdate->setDbValue($rs->fields('sysdate'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->id_minat_investasi->DbValue = $row['id_minat_investasi'];
		$this->nib->DbValue = $row['nib'];
		$this->nama->DbValue = $row['nama'];
		$this->penanaman_modal->DbValue = $row['penanaman_modal'];
		$this->jenis_perusahaan->DbValue = $row['jenis_perusahaan'];
		$this->id_jenis->DbValue = $row['id_jenis'];
		$this->id_kecamatan->DbValue = $row['id_kecamatan'];
		$this->sysdate->DbValue = $row['sysdate'];
	}

	// Render row values based on field settings
	function RenderRow() {
		global $Security, $Language, $gsLanguage;

		// Initialize URLs
		// Call Row_Rendering event

		$this->Row_Rendering();

		// Common render codes for all row types
		// id_minat_investasi
		// nib
		// nama
		// penanaman_modal
		// jenis_perusahaan
		// id_jenis
		// id_kecamatan
		// sysdate

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

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
		}

		// Call Row Rendered event
		if ($this->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$this->Row_Rendered();
	}

	//
	// Delete records based on current filter
	//
	function DeleteRows() {
		global $Language, $Security;
		if (!$Security->CanDelete()) {
			$this->setFailureMessage($Language->Phrase("NoDeletePermission")); // No delete permission
			return FALSE;
		}
		$DeleteRows = TRUE;
		$sSql = $this->SQL();
		$conn = &$this->Connection();
		$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
		$rs = $conn->Execute($sSql);
		$conn->raiseErrorFn = '';
		if ($rs === FALSE) {
			return FALSE;
		} elseif ($rs->EOF) {
			$this->setFailureMessage($Language->Phrase("NoRecord")); // No record found
			$rs->Close();
			return FALSE;

		//} else {
		//	$this->LoadRowValues($rs); // Load row values

		}
		$rows = ($rs) ? $rs->GetRows() : array();
		$conn->BeginTrans();

		// Clone old rows
		$rsold = $rows;
		if ($rs)
			$rs->Close();

		// Call row deleting event
		if ($DeleteRows) {
			foreach ($rsold as $row) {
				$DeleteRows = $this->Row_Deleting($row);
				if (!$DeleteRows) break;
			}
		}
		if ($DeleteRows) {
			$sKey = "";
			foreach ($rsold as $row) {
				$sThisKey = "";
				if ($sThisKey <> "") $sThisKey .= $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"];
				$sThisKey .= $row['id_minat_investasi'];
				$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
				$DeleteRows = $this->Delete($row); // Delete
				$conn->raiseErrorFn = '';
				if ($DeleteRows === FALSE)
					break;
				if ($sKey <> "") $sKey .= ", ";
				$sKey .= $sThisKey;
			}
		} else {

			// Set up error message
			if ($this->getSuccessMessage() <> "" || $this->getFailureMessage() <> "") {

				// Use the message, do nothing
			} elseif ($this->CancelMessage <> "") {
				$this->setFailureMessage($this->CancelMessage);
				$this->CancelMessage = "";
			} else {
				$this->setFailureMessage($Language->Phrase("DeleteCancelled"));
			}
		}
		if ($DeleteRows) {
			$conn->CommitTrans(); // Commit the changes
		} else {
			$conn->RollbackTrans(); // Rollback changes
		}

		// Call Row Deleted event
		if ($DeleteRows) {
			foreach ($rsold as $row) {
				$this->Row_Deleted($row);
			}
		}
		return $DeleteRows;
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("minat_investasilist.php"), "", $this->TableVar, TRUE);
		$PageId = "delete";
		$Breadcrumb->Add("delete", $PageId, $url);
	}

	// Setup lookup filters of a field
	function SetupLookupFilters($fld, $pageId = null) {
		global $gsLanguage;
		$pageId = $pageId ?: $this->PageID;
		switch ($fld->FldVar) {
		}
	}

	// Setup AutoSuggest filters of a field
	function SetupAutoSuggestFilters($fld, $pageId = null) {
		global $gsLanguage;
		$pageId = $pageId ?: $this->PageID;
		switch ($fld->FldVar) {
		}
	}

	// Page Load event
	function Page_Load() {

		//echo "Page Load";
	}

	// Page Unload event
	function Page_Unload() {

		//echo "Page Unload";
	}

	// Page Redirecting event
	function Page_Redirecting(&$url) {

		// Example:
		//$url = "your URL";

	}

	// Message Showing event
	// $type = ''|'success'|'failure'|'warning'
	function Message_Showing(&$msg, $type) {
		if ($type == 'success') {

			//$msg = "your success message";
		} elseif ($type == 'failure') {

			//$msg = "your failure message";
		} elseif ($type == 'warning') {

			//$msg = "your warning message";
		} else {

			//$msg = "your message";
		}
	}

	// Page Render event
	function Page_Render() {

		//echo "Page Render";
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
}
?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
if (!isset($minat_investasi_delete)) $minat_investasi_delete = new cminat_investasi_delete();

// Page init
$minat_investasi_delete->Page_Init();

// Page main
$minat_investasi_delete->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$minat_investasi_delete->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "delete";
var CurrentForm = fminat_investasidelete = new ew_Form("fminat_investasidelete", "delete");

// Form_CustomValidate event
fminat_investasidelete.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fminat_investasidelete.ValidateRequired = true;
<?php } else { ?>
fminat_investasidelete.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fminat_investasidelete.Lists["x_penanaman_modal"] = {"LinkField":"x_id_status","Ajax":true,"AutoFill":false,"DisplayFields":["x_status","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"status"};
fminat_investasidelete.Lists["x_jenis_perusahaan"] = {"LinkField":"x_id_jp","Ajax":true,"AutoFill":false,"DisplayFields":["x_jenis_perusahaan","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"jenis_perusahaan"};
fminat_investasidelete.Lists["x_id_jenis"] = {"LinkField":"x_id_jenis","Ajax":true,"AutoFill":false,"DisplayFields":["x_jenis","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"jenis"};
fminat_investasidelete.Lists["x_id_kecamatan"] = {"LinkField":"x_id_kecamatan","Ajax":true,"AutoFill":false,"DisplayFields":["x_kecamatan","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"kecamatan"};

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php $minat_investasi_delete->ShowPageHeader(); ?>
<?php
$minat_investasi_delete->ShowMessage();
?>
<form name="fminat_investasidelete" id="fminat_investasidelete" class="form-inline ewForm ewDeleteForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($minat_investasi_delete->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $minat_investasi_delete->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="minat_investasi">
<input type="hidden" name="a_delete" id="a_delete" value="D">
<?php foreach ($minat_investasi_delete->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode($EW_COMPOSITE_KEY_SEPARATOR, $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?php echo ew_HtmlEncode($keyvalue) ?>">
<?php } ?>
<div class="ewGrid">
<div class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<table class="table ewTable table-bordered table-striped table-condensed table-hover">
<?php echo $minat_investasi->TableCustomInnerHtml ?>
	<thead>
	<tr class="ewTableHeader">
<?php if ($minat_investasi->nib->Visible) { // nib ?>
		<th><span id="elh_minat_investasi_nib" class="minat_investasi_nib"><?php echo $minat_investasi->nib->FldCaption() ?></span></th>
<?php } ?>
<?php if ($minat_investasi->nama->Visible) { // nama ?>
		<th><span id="elh_minat_investasi_nama" class="minat_investasi_nama"><?php echo $minat_investasi->nama->FldCaption() ?></span></th>
<?php } ?>
<?php if ($minat_investasi->penanaman_modal->Visible) { // penanaman_modal ?>
		<th><span id="elh_minat_investasi_penanaman_modal" class="minat_investasi_penanaman_modal"><?php echo $minat_investasi->penanaman_modal->FldCaption() ?></span></th>
<?php } ?>
<?php if ($minat_investasi->jenis_perusahaan->Visible) { // jenis_perusahaan ?>
		<th><span id="elh_minat_investasi_jenis_perusahaan" class="minat_investasi_jenis_perusahaan"><?php echo $minat_investasi->jenis_perusahaan->FldCaption() ?></span></th>
<?php } ?>
<?php if ($minat_investasi->id_jenis->Visible) { // id_jenis ?>
		<th><span id="elh_minat_investasi_id_jenis" class="minat_investasi_id_jenis"><?php echo $minat_investasi->id_jenis->FldCaption() ?></span></th>
<?php } ?>
<?php if ($minat_investasi->id_kecamatan->Visible) { // id_kecamatan ?>
		<th><span id="elh_minat_investasi_id_kecamatan" class="minat_investasi_id_kecamatan"><?php echo $minat_investasi->id_kecamatan->FldCaption() ?></span></th>
<?php } ?>
<?php if ($minat_investasi->sysdate->Visible) { // sysdate ?>
		<th><span id="elh_minat_investasi_sysdate" class="minat_investasi_sysdate"><?php echo $minat_investasi->sysdate->FldCaption() ?></span></th>
<?php } ?>
	</tr>
	</thead>
	<tbody>
<?php
$minat_investasi_delete->RecCnt = 0;
$i = 0;
while (!$minat_investasi_delete->Recordset->EOF) {
	$minat_investasi_delete->RecCnt++;
	$minat_investasi_delete->RowCnt++;

	// Set row properties
	$minat_investasi->ResetAttrs();
	$minat_investasi->RowType = EW_ROWTYPE_VIEW; // View

	// Get the field contents
	$minat_investasi_delete->LoadRowValues($minat_investasi_delete->Recordset);

	// Render row
	$minat_investasi_delete->RenderRow();
?>
	<tr<?php echo $minat_investasi->RowAttributes() ?>>
<?php if ($minat_investasi->nib->Visible) { // nib ?>
		<td<?php echo $minat_investasi->nib->CellAttributes() ?>>
<span id="el<?php echo $minat_investasi_delete->RowCnt ?>_minat_investasi_nib" class="minat_investasi_nib">
<span<?php echo $minat_investasi->nib->ViewAttributes() ?>>
<?php echo $minat_investasi->nib->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($minat_investasi->nama->Visible) { // nama ?>
		<td<?php echo $minat_investasi->nama->CellAttributes() ?>>
<span id="el<?php echo $minat_investasi_delete->RowCnt ?>_minat_investasi_nama" class="minat_investasi_nama">
<span<?php echo $minat_investasi->nama->ViewAttributes() ?>>
<?php echo $minat_investasi->nama->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($minat_investasi->penanaman_modal->Visible) { // penanaman_modal ?>
		<td<?php echo $minat_investasi->penanaman_modal->CellAttributes() ?>>
<span id="el<?php echo $minat_investasi_delete->RowCnt ?>_minat_investasi_penanaman_modal" class="minat_investasi_penanaman_modal">
<span<?php echo $minat_investasi->penanaman_modal->ViewAttributes() ?>>
<?php echo $minat_investasi->penanaman_modal->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($minat_investasi->jenis_perusahaan->Visible) { // jenis_perusahaan ?>
		<td<?php echo $minat_investasi->jenis_perusahaan->CellAttributes() ?>>
<span id="el<?php echo $minat_investasi_delete->RowCnt ?>_minat_investasi_jenis_perusahaan" class="minat_investasi_jenis_perusahaan">
<span<?php echo $minat_investasi->jenis_perusahaan->ViewAttributes() ?>>
<?php echo $minat_investasi->jenis_perusahaan->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($minat_investasi->id_jenis->Visible) { // id_jenis ?>
		<td<?php echo $minat_investasi->id_jenis->CellAttributes() ?>>
<span id="el<?php echo $minat_investasi_delete->RowCnt ?>_minat_investasi_id_jenis" class="minat_investasi_id_jenis">
<span<?php echo $minat_investasi->id_jenis->ViewAttributes() ?>>
<?php echo $minat_investasi->id_jenis->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($minat_investasi->id_kecamatan->Visible) { // id_kecamatan ?>
		<td<?php echo $minat_investasi->id_kecamatan->CellAttributes() ?>>
<span id="el<?php echo $minat_investasi_delete->RowCnt ?>_minat_investasi_id_kecamatan" class="minat_investasi_id_kecamatan">
<span<?php echo $minat_investasi->id_kecamatan->ViewAttributes() ?>>
<?php echo $minat_investasi->id_kecamatan->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($minat_investasi->sysdate->Visible) { // sysdate ?>
		<td<?php echo $minat_investasi->sysdate->CellAttributes() ?>>
<span id="el<?php echo $minat_investasi_delete->RowCnt ?>_minat_investasi_sysdate" class="minat_investasi_sysdate">
<span<?php echo $minat_investasi->sysdate->ViewAttributes() ?>>
<?php echo $minat_investasi->sysdate->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
	</tr>
<?php
	$minat_investasi_delete->Recordset->MoveNext();
}
$minat_investasi_delete->Recordset->Close();
?>
</tbody>
</table>
</div>
</div>
<div>
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("DeleteBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $minat_investasi_delete->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
</div>
</form>
<script type="text/javascript">
fminat_investasidelete.Init();
</script>
<?php
$minat_investasi_delete->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$minat_investasi_delete->Page_Terminate();
?>
