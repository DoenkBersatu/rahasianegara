<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "penyerapan_tkinfo.php" ?>
<?php include_once "userinfo.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$penyerapan_tk_delete = NULL; // Initialize page object first

class cpenyerapan_tk_delete extends cpenyerapan_tk {

	// Page ID
	var $PageID = 'delete';

	// Project ID
	var $ProjectID = "{711D4B7A-499A-4AB9-B89B-D8472076C077}";

	// Table name
	var $TableName = 'penyerapan_tk';

	// Page object name
	var $PageObjName = 'penyerapan_tk_delete';

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

		// Table object (penyerapan_tk)
		if (!isset($GLOBALS["penyerapan_tk"]) || get_class($GLOBALS["penyerapan_tk"]) == "cpenyerapan_tk") {
			$GLOBALS["penyerapan_tk"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["penyerapan_tk"];
		}

		// Table object (user)
		if (!isset($GLOBALS['user'])) $GLOBALS['user'] = new cuser();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'delete', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'penyerapan_tk', TRUE);

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
				$this->Page_Terminate(ew_GetUrl("penyerapan_tklist.php"));
			else
				$this->Page_Terminate(ew_GetUrl("login.php"));
		}
		if ($Security->IsLoggedIn()) {
			$Security->UserID_Loading();
			$Security->LoadUserID();
			$Security->UserID_Loaded();
		}
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action
		$this->id_penyerapan_tk->SetVisibility();
		$this->id_penyerapan_tk->Visible = !$this->IsAdd() && !$this->IsCopy() && !$this->IsGridAdd();
		$this->id_triwulan->SetVisibility();
		$this->id_sektor->SetVisibility();
		$this->id_subsektor->SetVisibility();
		$this->jumlah_penyerapan->SetVisibility();

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
		global $EW_EXPORT, $penyerapan_tk;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($penyerapan_tk);
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
			$this->Page_Terminate("penyerapan_tklist.php"); // Prevent SQL injection, return to list

		// Set up filter (SQL WHHERE clause) and get return SQL
		// SQL constructor in penyerapan_tk class, penyerapan_tkinfo.php

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
				$this->Page_Terminate("penyerapan_tklist.php"); // Return to list
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
		$this->id_penyerapan_tk->setDbValue($rs->fields('id_penyerapan_tk'));
		$this->id_triwulan->setDbValue($rs->fields('id_triwulan'));
		$this->id_sektor->setDbValue($rs->fields('id_sektor'));
		$this->id_subsektor->setDbValue($rs->fields('id_subsektor'));
		$this->jumlah_penyerapan->setDbValue($rs->fields('jumlah_penyerapan'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->id_penyerapan_tk->DbValue = $row['id_penyerapan_tk'];
		$this->id_triwulan->DbValue = $row['id_triwulan'];
		$this->id_sektor->DbValue = $row['id_sektor'];
		$this->id_subsektor->DbValue = $row['id_subsektor'];
		$this->jumlah_penyerapan->DbValue = $row['jumlah_penyerapan'];
	}

	// Render row values based on field settings
	function RenderRow() {
		global $Security, $Language, $gsLanguage;

		// Initialize URLs
		// Call Row_Rendering event

		$this->Row_Rendering();

		// Common render codes for all row types
		// id_penyerapan_tk
		// id_triwulan
		// id_sektor
		// id_subsektor
		// jumlah_penyerapan

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// id_penyerapan_tk
		$this->id_penyerapan_tk->ViewValue = $this->id_penyerapan_tk->CurrentValue;
		$this->id_penyerapan_tk->ViewCustomAttributes = "";

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

		// jumlah_penyerapan
		$this->jumlah_penyerapan->ViewValue = $this->jumlah_penyerapan->CurrentValue;
		$this->jumlah_penyerapan->ViewCustomAttributes = "";

			// id_penyerapan_tk
			$this->id_penyerapan_tk->LinkCustomAttributes = "";
			$this->id_penyerapan_tk->HrefValue = "";
			$this->id_penyerapan_tk->TooltipValue = "";

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

			// jumlah_penyerapan
			$this->jumlah_penyerapan->LinkCustomAttributes = "";
			$this->jumlah_penyerapan->HrefValue = "";
			$this->jumlah_penyerapan->TooltipValue = "";
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
				$sThisKey .= $row['id_penyerapan_tk'];
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
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("penyerapan_tklist.php"), "", $this->TableVar, TRUE);
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
if (!isset($penyerapan_tk_delete)) $penyerapan_tk_delete = new cpenyerapan_tk_delete();

// Page init
$penyerapan_tk_delete->Page_Init();

// Page main
$penyerapan_tk_delete->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$penyerapan_tk_delete->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "delete";
var CurrentForm = fpenyerapan_tkdelete = new ew_Form("fpenyerapan_tkdelete", "delete");

// Form_CustomValidate event
fpenyerapan_tkdelete.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fpenyerapan_tkdelete.ValidateRequired = true;
<?php } else { ?>
fpenyerapan_tkdelete.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fpenyerapan_tkdelete.Lists["x_id_triwulan"] = {"LinkField":"x_ID_triwulan","Ajax":true,"AutoFill":false,"DisplayFields":["x_triwulan","x_tahun","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"triwulan"};
fpenyerapan_tkdelete.Lists["x_id_sektor"] = {"LinkField":"x_id_sektor","Ajax":true,"AutoFill":false,"DisplayFields":["x_sektor","","",""],"ParentFields":[],"ChildFields":["x_id_subsektor"],"FilterFields":[],"Options":[],"Template":"","LinkTable":"sektor"};
fpenyerapan_tkdelete.Lists["x_id_subsektor"] = {"LinkField":"x_id_subsektor","Ajax":true,"AutoFill":false,"DisplayFields":["x_subsektor","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"subsektor"};

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php $penyerapan_tk_delete->ShowPageHeader(); ?>
<?php
$penyerapan_tk_delete->ShowMessage();
?>
<form name="fpenyerapan_tkdelete" id="fpenyerapan_tkdelete" class="form-inline ewForm ewDeleteForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($penyerapan_tk_delete->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $penyerapan_tk_delete->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="penyerapan_tk">
<input type="hidden" name="a_delete" id="a_delete" value="D">
<?php foreach ($penyerapan_tk_delete->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode($EW_COMPOSITE_KEY_SEPARATOR, $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?php echo ew_HtmlEncode($keyvalue) ?>">
<?php } ?>
<div class="ewGrid">
<div class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<table class="table ewTable table-bordered table-striped table-condensed table-hover">
<?php echo $penyerapan_tk->TableCustomInnerHtml ?>
	<thead>
	<tr class="ewTableHeader">
<?php if ($penyerapan_tk->id_penyerapan_tk->Visible) { // id_penyerapan_tk ?>
		<th><span id="elh_penyerapan_tk_id_penyerapan_tk" class="penyerapan_tk_id_penyerapan_tk"><?php echo $penyerapan_tk->id_penyerapan_tk->FldCaption() ?></span></th>
<?php } ?>
<?php if ($penyerapan_tk->id_triwulan->Visible) { // id_triwulan ?>
		<th><span id="elh_penyerapan_tk_id_triwulan" class="penyerapan_tk_id_triwulan"><?php echo $penyerapan_tk->id_triwulan->FldCaption() ?></span></th>
<?php } ?>
<?php if ($penyerapan_tk->id_sektor->Visible) { // id_sektor ?>
		<th><span id="elh_penyerapan_tk_id_sektor" class="penyerapan_tk_id_sektor"><?php echo $penyerapan_tk->id_sektor->FldCaption() ?></span></th>
<?php } ?>
<?php if ($penyerapan_tk->id_subsektor->Visible) { // id_subsektor ?>
		<th><span id="elh_penyerapan_tk_id_subsektor" class="penyerapan_tk_id_subsektor"><?php echo $penyerapan_tk->id_subsektor->FldCaption() ?></span></th>
<?php } ?>
<?php if ($penyerapan_tk->jumlah_penyerapan->Visible) { // jumlah_penyerapan ?>
		<th><span id="elh_penyerapan_tk_jumlah_penyerapan" class="penyerapan_tk_jumlah_penyerapan"><?php echo $penyerapan_tk->jumlah_penyerapan->FldCaption() ?></span></th>
<?php } ?>
	</tr>
	</thead>
	<tbody>
<?php
$penyerapan_tk_delete->RecCnt = 0;
$i = 0;
while (!$penyerapan_tk_delete->Recordset->EOF) {
	$penyerapan_tk_delete->RecCnt++;
	$penyerapan_tk_delete->RowCnt++;

	// Set row properties
	$penyerapan_tk->ResetAttrs();
	$penyerapan_tk->RowType = EW_ROWTYPE_VIEW; // View

	// Get the field contents
	$penyerapan_tk_delete->LoadRowValues($penyerapan_tk_delete->Recordset);

	// Render row
	$penyerapan_tk_delete->RenderRow();
?>
	<tr<?php echo $penyerapan_tk->RowAttributes() ?>>
<?php if ($penyerapan_tk->id_penyerapan_tk->Visible) { // id_penyerapan_tk ?>
		<td<?php echo $penyerapan_tk->id_penyerapan_tk->CellAttributes() ?>>
<span id="el<?php echo $penyerapan_tk_delete->RowCnt ?>_penyerapan_tk_id_penyerapan_tk" class="penyerapan_tk_id_penyerapan_tk">
<span<?php echo $penyerapan_tk->id_penyerapan_tk->ViewAttributes() ?>>
<?php echo $penyerapan_tk->id_penyerapan_tk->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($penyerapan_tk->id_triwulan->Visible) { // id_triwulan ?>
		<td<?php echo $penyerapan_tk->id_triwulan->CellAttributes() ?>>
<span id="el<?php echo $penyerapan_tk_delete->RowCnt ?>_penyerapan_tk_id_triwulan" class="penyerapan_tk_id_triwulan">
<span<?php echo $penyerapan_tk->id_triwulan->ViewAttributes() ?>>
<?php echo $penyerapan_tk->id_triwulan->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($penyerapan_tk->id_sektor->Visible) { // id_sektor ?>
		<td<?php echo $penyerapan_tk->id_sektor->CellAttributes() ?>>
<span id="el<?php echo $penyerapan_tk_delete->RowCnt ?>_penyerapan_tk_id_sektor" class="penyerapan_tk_id_sektor">
<span<?php echo $penyerapan_tk->id_sektor->ViewAttributes() ?>>
<?php echo $penyerapan_tk->id_sektor->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($penyerapan_tk->id_subsektor->Visible) { // id_subsektor ?>
		<td<?php echo $penyerapan_tk->id_subsektor->CellAttributes() ?>>
<span id="el<?php echo $penyerapan_tk_delete->RowCnt ?>_penyerapan_tk_id_subsektor" class="penyerapan_tk_id_subsektor">
<span<?php echo $penyerapan_tk->id_subsektor->ViewAttributes() ?>>
<?php echo $penyerapan_tk->id_subsektor->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($penyerapan_tk->jumlah_penyerapan->Visible) { // jumlah_penyerapan ?>
		<td<?php echo $penyerapan_tk->jumlah_penyerapan->CellAttributes() ?>>
<span id="el<?php echo $penyerapan_tk_delete->RowCnt ?>_penyerapan_tk_jumlah_penyerapan" class="penyerapan_tk_jumlah_penyerapan">
<span<?php echo $penyerapan_tk->jumlah_penyerapan->ViewAttributes() ?>>
<?php echo $penyerapan_tk->jumlah_penyerapan->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
	</tr>
<?php
	$penyerapan_tk_delete->Recordset->MoveNext();
}
$penyerapan_tk_delete->Recordset->Close();
?>
</tbody>
</table>
</div>
</div>
<div>
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("DeleteBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $penyerapan_tk_delete->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
</div>
</form>
<script type="text/javascript">
fpenyerapan_tkdelete.Init();
</script>
<?php
$penyerapan_tk_delete->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$penyerapan_tk_delete->Page_Terminate();
?>
