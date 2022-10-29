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

$penyerapan_tk_add = NULL; // Initialize page object first

class cpenyerapan_tk_add extends cpenyerapan_tk {

	// Page ID
	var $PageID = 'add';

	// Project ID
	var $ProjectID = "{711D4B7A-499A-4AB9-B89B-D8472076C077}";

	// Table name
	var $TableName = 'penyerapan_tk';

	// Page object name
	var $PageObjName = 'penyerapan_tk_add';

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
			define("EW_PAGE_ID", 'add', TRUE);

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
		if (!$Security->CanAdd()) {
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

		// Create form object
		$objForm = new cFormObj();
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action
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

		// Process auto fill
		if (@$_POST["ajax"] == "autofill") {
			$results = $this->GetAutoFill(@$_POST["name"], @$_POST["q"]);
			if ($results) {

				// Clean output buffer
				if (!EW_DEBUG_ENABLED && ob_get_length())
					ob_end_clean();
				echo $results;
				$this->Page_Terminate();
				exit();
			}
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

			// Handle modal response
			if ($this->IsModal) {
				$row = array();
				$row["url"] = $url;
				echo ew_ArrayToJson(array($row));
			} else {
				header("Location: " . $url);
			}
		}
		exit();
	}
	var $FormClassName = "form-horizontal ewForm ewAddForm";
	var $IsModal = FALSE;
	var $DbMasterFilter = "";
	var $DbDetailFilter = "";
	var $StartRec;
	var $Priv = 0;
	var $OldRecordset;
	var $CopyRecord;

	// 
	// Page main
	//
	function Page_Main() {
		global $objForm, $Language, $gsFormError;
		global $gbSkipHeaderFooter;

		// Check modal
		$this->IsModal = (@$_GET["modal"] == "1" || @$_POST["modal"] == "1");
		if ($this->IsModal)
			$gbSkipHeaderFooter = TRUE;

		// Process form if post back
		if (@$_POST["a_add"] <> "") {
			$this->CurrentAction = $_POST["a_add"]; // Get form action
			$this->CopyRecord = $this->LoadOldRecord(); // Load old recordset
			$this->LoadFormValues(); // Load form values
		} else { // Not post back

			// Load key values from QueryString
			$this->CopyRecord = TRUE;
			if (@$_GET["id_penyerapan_tk"] != "") {
				$this->id_penyerapan_tk->setQueryStringValue($_GET["id_penyerapan_tk"]);
				$this->setKey("id_penyerapan_tk", $this->id_penyerapan_tk->CurrentValue); // Set up key
			} else {
				$this->setKey("id_penyerapan_tk", ""); // Clear key
				$this->CopyRecord = FALSE;
			}
			if ($this->CopyRecord) {
				$this->CurrentAction = "C"; // Copy record
			} else {
				$this->CurrentAction = "I"; // Display blank record
			}
		}

		// Set up Breadcrumb
		$this->SetupBreadcrumb();

		// Validate form if post back
		if (@$_POST["a_add"] <> "") {
			if (!$this->ValidateForm()) {
				$this->CurrentAction = "I"; // Form error, reset action
				$this->EventCancelled = TRUE; // Event cancelled
				$this->RestoreFormValues(); // Restore form values
				$this->setFailureMessage($gsFormError);
			}
		} else {
			if ($this->CurrentAction == "I") // Load default values for blank record
				$this->LoadDefaultValues();
		}

		// Perform action based on action code
		switch ($this->CurrentAction) {
			case "I": // Blank record, no action required
				break;
			case "C": // Copy an existing record
				if (!$this->LoadRow()) { // Load record based on key
					if ($this->getFailureMessage() == "") $this->setFailureMessage($Language->Phrase("NoRecord")); // No record found
					$this->Page_Terminate("penyerapan_tklist.php"); // No matching record, return to list
				}
				break;
			case "A": // Add new record
				$this->SendEmail = TRUE; // Send email on add success
				if ($this->AddRow($this->OldRecordset)) { // Add successful
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("AddSuccess")); // Set up success message
					$sReturnUrl = $this->getReturnUrl();
					if (ew_GetPageName($sReturnUrl) == "penyerapan_tklist.php")
						$sReturnUrl = $this->AddMasterUrl($sReturnUrl); // List page, return to list page with correct master key if necessary
					elseif (ew_GetPageName($sReturnUrl) == "penyerapan_tkview.php")
						$sReturnUrl = $this->GetViewUrl(); // View page, return to view page with keyurl directly
					$this->Page_Terminate($sReturnUrl); // Clean up and return
				} else {
					$this->EventCancelled = TRUE; // Event cancelled
					$this->RestoreFormValues(); // Add failed, restore form values
				}
		}

		// Render row based on row type
		$this->RowType = EW_ROWTYPE_ADD; // Render add type

		// Render row
		$this->ResetAttrs();
		$this->RenderRow();
	}

	// Get upload files
	function GetUploadFiles() {
		global $objForm, $Language;

		// Get upload data
	}

	// Load default values
	function LoadDefaultValues() {
		$this->id_triwulan->CurrentValue = NULL;
		$this->id_triwulan->OldValue = $this->id_triwulan->CurrentValue;
		$this->id_sektor->CurrentValue = NULL;
		$this->id_sektor->OldValue = $this->id_sektor->CurrentValue;
		$this->id_subsektor->CurrentValue = NULL;
		$this->id_subsektor->OldValue = $this->id_subsektor->CurrentValue;
		$this->jumlah_penyerapan->CurrentValue = NULL;
		$this->jumlah_penyerapan->OldValue = $this->jumlah_penyerapan->CurrentValue;
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->id_triwulan->FldIsDetailKey) {
			$this->id_triwulan->setFormValue($objForm->GetValue("x_id_triwulan"));
		}
		if (!$this->id_sektor->FldIsDetailKey) {
			$this->id_sektor->setFormValue($objForm->GetValue("x_id_sektor"));
		}
		if (!$this->id_subsektor->FldIsDetailKey) {
			$this->id_subsektor->setFormValue($objForm->GetValue("x_id_subsektor"));
		}
		if (!$this->jumlah_penyerapan->FldIsDetailKey) {
			$this->jumlah_penyerapan->setFormValue($objForm->GetValue("x_jumlah_penyerapan"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadOldRecord();
		$this->id_triwulan->CurrentValue = $this->id_triwulan->FormValue;
		$this->id_sektor->CurrentValue = $this->id_sektor->FormValue;
		$this->id_subsektor->CurrentValue = $this->id_subsektor->FormValue;
		$this->jumlah_penyerapan->CurrentValue = $this->jumlah_penyerapan->FormValue;
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

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($this->getKey("id_penyerapan_tk")) <> "")
			$this->id_penyerapan_tk->CurrentValue = $this->getKey("id_penyerapan_tk"); // id_penyerapan_tk
		else
			$bValidKey = FALSE;

		// Load old recordset
		if ($bValidKey) {
			$this->CurrentFilter = $this->KeyFilter();
			$sSql = $this->SQL();
			$conn = &$this->Connection();
			$this->OldRecordset = ew_LoadRecordset($sSql, $conn);
			$this->LoadRowValues($this->OldRecordset); // Load row values
		} else {
			$this->OldRecordset = NULL;
		}
		return $bValidKey;
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
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// id_triwulan
			$this->id_triwulan->EditAttrs["class"] = "form-control";
			$this->id_triwulan->EditCustomAttributes = "";
			if (trim(strval($this->id_triwulan->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`ID_triwulan`" . ew_SearchString("=", $this->id_triwulan->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `ID_triwulan`, `triwulan` AS `DispFld`, `tahun` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `triwulan`";
			$sWhereWrk = "";
			$this->id_triwulan->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->id_triwulan, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->id_triwulan->EditValue = $arwrk;

			// id_sektor
			$this->id_sektor->EditAttrs["class"] = "form-control";
			$this->id_sektor->EditCustomAttributes = "";
			if (trim(strval($this->id_sektor->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`id_sektor`" . ew_SearchString("=", $this->id_sektor->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `id_sektor`, `sektor` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `sektor`";
			$sWhereWrk = "";
			$this->id_sektor->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->id_sektor, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->id_sektor->EditValue = $arwrk;

			// id_subsektor
			$this->id_subsektor->EditAttrs["class"] = "form-control";
			$this->id_subsektor->EditCustomAttributes = "";
			if (trim(strval($this->id_subsektor->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`id_subsektor`" . ew_SearchString("=", $this->id_subsektor->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `id_subsektor`, `subsektor` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, `id_sektor` AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `subsektor`";
			$sWhereWrk = "";
			$this->id_subsektor->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->id_subsektor, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->id_subsektor->EditValue = $arwrk;

			// jumlah_penyerapan
			$this->jumlah_penyerapan->EditAttrs["class"] = "form-control";
			$this->jumlah_penyerapan->EditCustomAttributes = "";
			$this->jumlah_penyerapan->EditValue = ew_HtmlEncode($this->jumlah_penyerapan->CurrentValue);
			$this->jumlah_penyerapan->PlaceHolder = ew_RemoveHtml($this->jumlah_penyerapan->FldCaption());

			// Add refer script
			// id_triwulan

			$this->id_triwulan->LinkCustomAttributes = "";
			$this->id_triwulan->HrefValue = "";

			// id_sektor
			$this->id_sektor->LinkCustomAttributes = "";
			$this->id_sektor->HrefValue = "";

			// id_subsektor
			$this->id_subsektor->LinkCustomAttributes = "";
			$this->id_subsektor->HrefValue = "";

			// jumlah_penyerapan
			$this->jumlah_penyerapan->LinkCustomAttributes = "";
			$this->jumlah_penyerapan->HrefValue = "";
		}
		if ($this->RowType == EW_ROWTYPE_ADD ||
			$this->RowType == EW_ROWTYPE_EDIT ||
			$this->RowType == EW_ROWTYPE_SEARCH) { // Add / Edit / Search row
			$this->SetupFieldTitles();
		}

		// Call Row Rendered event
		if ($this->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$this->Row_Rendered();
	}

	// Validate form
	function ValidateForm() {
		global $Language, $gsFormError;

		// Initialize form error message
		$gsFormError = "";

		// Check if validation required
		if (!EW_SERVER_VALIDATE)
			return ($gsFormError == "");
		if (!$this->id_triwulan->FldIsDetailKey && !is_null($this->id_triwulan->FormValue) && $this->id_triwulan->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->id_triwulan->FldCaption(), $this->id_triwulan->ReqErrMsg));
		}
		if (!$this->id_sektor->FldIsDetailKey && !is_null($this->id_sektor->FormValue) && $this->id_sektor->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->id_sektor->FldCaption(), $this->id_sektor->ReqErrMsg));
		}
		if (!$this->id_subsektor->FldIsDetailKey && !is_null($this->id_subsektor->FormValue) && $this->id_subsektor->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->id_subsektor->FldCaption(), $this->id_subsektor->ReqErrMsg));
		}
		if (!$this->jumlah_penyerapan->FldIsDetailKey && !is_null($this->jumlah_penyerapan->FormValue) && $this->jumlah_penyerapan->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->jumlah_penyerapan->FldCaption(), $this->jumlah_penyerapan->ReqErrMsg));
		}
		if (!ew_CheckInteger($this->jumlah_penyerapan->FormValue)) {
			ew_AddMessage($gsFormError, $this->jumlah_penyerapan->FldErrMsg());
		}

		// Return validate result
		$ValidateForm = ($gsFormError == "");

		// Call Form_CustomValidate event
		$sFormCustomError = "";
		$ValidateForm = $ValidateForm && $this->Form_CustomValidate($sFormCustomError);
		if ($sFormCustomError <> "") {
			ew_AddMessage($gsFormError, $sFormCustomError);
		}
		return $ValidateForm;
	}

	// Add record
	function AddRow($rsold = NULL) {
		global $Language, $Security;
		$conn = &$this->Connection();

		// Load db values from rsold
		if ($rsold) {
			$this->LoadDbValues($rsold);
		}
		$rsnew = array();

		// id_triwulan
		$this->id_triwulan->SetDbValueDef($rsnew, $this->id_triwulan->CurrentValue, 0, FALSE);

		// id_sektor
		$this->id_sektor->SetDbValueDef($rsnew, $this->id_sektor->CurrentValue, 0, FALSE);

		// id_subsektor
		$this->id_subsektor->SetDbValueDef($rsnew, $this->id_subsektor->CurrentValue, 0, FALSE);

		// jumlah_penyerapan
		$this->jumlah_penyerapan->SetDbValueDef($rsnew, $this->jumlah_penyerapan->CurrentValue, 0, FALSE);

		// Call Row Inserting event
		$rs = ($rsold == NULL) ? NULL : $rsold->fields;
		$bInsertRow = $this->Row_Inserting($rs, $rsnew);
		if ($bInsertRow) {
			$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
			$AddRow = $this->Insert($rsnew);
			$conn->raiseErrorFn = '';
			if ($AddRow) {
			}
		} else {
			if ($this->getSuccessMessage() <> "" || $this->getFailureMessage() <> "") {

				// Use the message, do nothing
			} elseif ($this->CancelMessage <> "") {
				$this->setFailureMessage($this->CancelMessage);
				$this->CancelMessage = "";
			} else {
				$this->setFailureMessage($Language->Phrase("InsertCancelled"));
			}
			$AddRow = FALSE;
		}
		if ($AddRow) {

			// Call Row Inserted event
			$rs = ($rsold == NULL) ? NULL : $rsold->fields;
			$this->Row_Inserted($rs, $rsnew);
		}
		return $AddRow;
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("penyerapan_tklist.php"), "", $this->TableVar, TRUE);
		$PageId = ($this->CurrentAction == "C") ? "Copy" : "Add";
		$Breadcrumb->Add("add", $PageId, $url);
	}

	// Setup lookup filters of a field
	function SetupLookupFilters($fld, $pageId = null) {
		global $gsLanguage;
		$pageId = $pageId ?: $this->PageID;
		switch ($fld->FldVar) {
		case "x_id_triwulan":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `ID_triwulan` AS `LinkFld`, `triwulan` AS `DispFld`, `tahun` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `triwulan`";
			$sWhereWrk = "";
			$this->id_triwulan->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => '`ID_triwulan` = {filter_value}', "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->id_triwulan, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_id_sektor":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `id_sektor` AS `LinkFld`, `sektor` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `sektor`";
			$sWhereWrk = "";
			$this->id_sektor->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => '`id_sektor` = {filter_value}', "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->id_sektor, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_id_subsektor":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `id_subsektor` AS `LinkFld`, `subsektor` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `subsektor`";
			$sWhereWrk = "{filter}";
			$this->id_subsektor->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => '`id_subsektor` = {filter_value}', "t0" => "3", "fn0" => "", "f1" => '`id_sektor` IN ({filter_value})', "t1" => "3", "fn1" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->id_subsektor, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
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

	// Form Custom Validate event
	function Form_CustomValidate(&$CustomError) {

		// Return error message in CustomError
		return TRUE;
	}
}
?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
if (!isset($penyerapan_tk_add)) $penyerapan_tk_add = new cpenyerapan_tk_add();

// Page init
$penyerapan_tk_add->Page_Init();

// Page main
$penyerapan_tk_add->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$penyerapan_tk_add->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "add";
var CurrentForm = fpenyerapan_tkadd = new ew_Form("fpenyerapan_tkadd", "add");

// Validate form
fpenyerapan_tkadd.Validate = function() {
	if (!this.ValidateRequired)
		return true; // Ignore validation
	var $ = jQuery, fobj = this.GetForm(), $fobj = $(fobj);
	if ($fobj.find("#a_confirm").val() == "F")
		return true;
	var elm, felm, uelm, addcnt = 0;
	var $k = $fobj.find("#" + this.FormKeyCountName); // Get key_count
	var rowcnt = ($k[0]) ? parseInt($k.val(), 10) : 1;
	var startcnt = (rowcnt == 0) ? 0 : 1; // Check rowcnt == 0 => Inline-Add
	var gridinsert = $fobj.find("#a_list").val() == "gridinsert";
	for (var i = startcnt; i <= rowcnt; i++) {
		var infix = ($k[0]) ? String(i) : "";
		$fobj.data("rowindex", infix);
			elm = this.GetElements("x" + infix + "_id_triwulan");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $penyerapan_tk->id_triwulan->FldCaption(), $penyerapan_tk->id_triwulan->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_id_sektor");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $penyerapan_tk->id_sektor->FldCaption(), $penyerapan_tk->id_sektor->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_id_subsektor");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $penyerapan_tk->id_subsektor->FldCaption(), $penyerapan_tk->id_subsektor->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_jumlah_penyerapan");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $penyerapan_tk->jumlah_penyerapan->FldCaption(), $penyerapan_tk->jumlah_penyerapan->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_jumlah_penyerapan");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($penyerapan_tk->jumlah_penyerapan->FldErrMsg()) ?>");

			// Fire Form_CustomValidate event
			if (!this.Form_CustomValidate(fobj))
				return false;
	}

	// Process detail forms
	var dfs = $fobj.find("input[name='detailpage']").get();
	for (var i = 0; i < dfs.length; i++) {
		var df = dfs[i], val = df.value;
		if (val && ewForms[val])
			if (!ewForms[val].Validate())
				return false;
	}
	return true;
}

// Form_CustomValidate event
fpenyerapan_tkadd.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fpenyerapan_tkadd.ValidateRequired = true;
<?php } else { ?>
fpenyerapan_tkadd.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fpenyerapan_tkadd.Lists["x_id_triwulan"] = {"LinkField":"x_ID_triwulan","Ajax":true,"AutoFill":false,"DisplayFields":["x_triwulan","x_tahun","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"triwulan"};
fpenyerapan_tkadd.Lists["x_id_sektor"] = {"LinkField":"x_id_sektor","Ajax":true,"AutoFill":false,"DisplayFields":["x_sektor","","",""],"ParentFields":[],"ChildFields":["x_id_subsektor"],"FilterFields":[],"Options":[],"Template":"","LinkTable":"sektor"};
fpenyerapan_tkadd.Lists["x_id_subsektor"] = {"LinkField":"x_id_subsektor","Ajax":true,"AutoFill":false,"DisplayFields":["x_subsektor","","",""],"ParentFields":["x_id_sektor"],"ChildFields":[],"FilterFields":["x_id_sektor"],"Options":[],"Template":"","LinkTable":"subsektor"};

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php if (!$penyerapan_tk_add->IsModal) { ?>
<?php } ?>
<?php $penyerapan_tk_add->ShowPageHeader(); ?>
<?php
$penyerapan_tk_add->ShowMessage();
?>
<form name="fpenyerapan_tkadd" id="fpenyerapan_tkadd" class="<?php echo $penyerapan_tk_add->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($penyerapan_tk_add->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $penyerapan_tk_add->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="penyerapan_tk">
<input type="hidden" name="a_add" id="a_add" value="A">
<?php if ($penyerapan_tk_add->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<div>
<?php if ($penyerapan_tk->id_triwulan->Visible) { // id_triwulan ?>
	<div id="r_id_triwulan" class="form-group">
		<label id="elh_penyerapan_tk_id_triwulan" for="x_id_triwulan" class="col-sm-2 control-label ewLabel"><?php echo $penyerapan_tk->id_triwulan->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $penyerapan_tk->id_triwulan->CellAttributes() ?>>
<span id="el_penyerapan_tk_id_triwulan">
<select data-table="penyerapan_tk" data-field="x_id_triwulan" data-value-separator="<?php echo $penyerapan_tk->id_triwulan->DisplayValueSeparatorAttribute() ?>" id="x_id_triwulan" name="x_id_triwulan"<?php echo $penyerapan_tk->id_triwulan->EditAttributes() ?>>
<?php echo $penyerapan_tk->id_triwulan->SelectOptionListHtml("x_id_triwulan") ?>
</select>
<input type="hidden" name="s_x_id_triwulan" id="s_x_id_triwulan" value="<?php echo $penyerapan_tk->id_triwulan->LookupFilterQuery() ?>">
</span>
<?php echo $penyerapan_tk->id_triwulan->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($penyerapan_tk->id_sektor->Visible) { // id_sektor ?>
	<div id="r_id_sektor" class="form-group">
		<label id="elh_penyerapan_tk_id_sektor" for="x_id_sektor" class="col-sm-2 control-label ewLabel"><?php echo $penyerapan_tk->id_sektor->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $penyerapan_tk->id_sektor->CellAttributes() ?>>
<span id="el_penyerapan_tk_id_sektor">
<?php $penyerapan_tk->id_sektor->EditAttrs["onchange"] = "ew_UpdateOpt.call(this); " . @$penyerapan_tk->id_sektor->EditAttrs["onchange"]; ?>
<select data-table="penyerapan_tk" data-field="x_id_sektor" data-value-separator="<?php echo $penyerapan_tk->id_sektor->DisplayValueSeparatorAttribute() ?>" id="x_id_sektor" name="x_id_sektor"<?php echo $penyerapan_tk->id_sektor->EditAttributes() ?>>
<?php echo $penyerapan_tk->id_sektor->SelectOptionListHtml("x_id_sektor") ?>
</select>
<input type="hidden" name="s_x_id_sektor" id="s_x_id_sektor" value="<?php echo $penyerapan_tk->id_sektor->LookupFilterQuery() ?>">
</span>
<?php echo $penyerapan_tk->id_sektor->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($penyerapan_tk->id_subsektor->Visible) { // id_subsektor ?>
	<div id="r_id_subsektor" class="form-group">
		<label id="elh_penyerapan_tk_id_subsektor" for="x_id_subsektor" class="col-sm-2 control-label ewLabel"><?php echo $penyerapan_tk->id_subsektor->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $penyerapan_tk->id_subsektor->CellAttributes() ?>>
<span id="el_penyerapan_tk_id_subsektor">
<select data-table="penyerapan_tk" data-field="x_id_subsektor" data-value-separator="<?php echo $penyerapan_tk->id_subsektor->DisplayValueSeparatorAttribute() ?>" id="x_id_subsektor" name="x_id_subsektor"<?php echo $penyerapan_tk->id_subsektor->EditAttributes() ?>>
<?php echo $penyerapan_tk->id_subsektor->SelectOptionListHtml("x_id_subsektor") ?>
</select>
<input type="hidden" name="s_x_id_subsektor" id="s_x_id_subsektor" value="<?php echo $penyerapan_tk->id_subsektor->LookupFilterQuery() ?>">
</span>
<?php echo $penyerapan_tk->id_subsektor->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($penyerapan_tk->jumlah_penyerapan->Visible) { // jumlah_penyerapan ?>
	<div id="r_jumlah_penyerapan" class="form-group">
		<label id="elh_penyerapan_tk_jumlah_penyerapan" for="x_jumlah_penyerapan" class="col-sm-2 control-label ewLabel"><?php echo $penyerapan_tk->jumlah_penyerapan->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $penyerapan_tk->jumlah_penyerapan->CellAttributes() ?>>
<span id="el_penyerapan_tk_jumlah_penyerapan">
<input type="text" data-table="penyerapan_tk" data-field="x_jumlah_penyerapan" name="x_jumlah_penyerapan" id="x_jumlah_penyerapan" size="30" placeholder="<?php echo ew_HtmlEncode($penyerapan_tk->jumlah_penyerapan->getPlaceHolder()) ?>" value="<?php echo $penyerapan_tk->jumlah_penyerapan->EditValue ?>"<?php echo $penyerapan_tk->jumlah_penyerapan->EditAttributes() ?>>
</span>
<?php echo $penyerapan_tk->jumlah_penyerapan->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div>
<?php if (!$penyerapan_tk_add->IsModal) { ?>
<div class="form-group">
	<div class="col-sm-offset-2 col-sm-10">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("AddBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $penyerapan_tk_add->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div>
</div>
<?php } ?>
</form>
<script type="text/javascript">
fpenyerapan_tkadd.Init();
</script>
<?php
$penyerapan_tk_add->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$penyerapan_tk_add->Page_Terminate();
?>
