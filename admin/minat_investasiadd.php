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

$minat_investasi_add = NULL; // Initialize page object first

class cminat_investasi_add extends cminat_investasi {

	// Page ID
	var $PageID = 'add';

	// Project ID
	var $ProjectID = "{711D4B7A-499A-4AB9-B89B-D8472076C077}";

	// Table name
	var $TableName = 'minat_investasi';

	// Page object name
	var $PageObjName = 'minat_investasi_add';

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
			define("EW_PAGE_ID", 'add', TRUE);

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
		if (!$Security->CanAdd()) {
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

		// Create form object
		$objForm = new cFormObj();
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
			if (@$_GET["id_minat_investasi"] != "") {
				$this->id_minat_investasi->setQueryStringValue($_GET["id_minat_investasi"]);
				$this->setKey("id_minat_investasi", $this->id_minat_investasi->CurrentValue); // Set up key
			} else {
				$this->setKey("id_minat_investasi", ""); // Clear key
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
					$this->Page_Terminate("minat_investasilist.php"); // No matching record, return to list
				}
				break;
			case "A": // Add new record
				$this->SendEmail = TRUE; // Send email on add success
				if ($this->AddRow($this->OldRecordset)) { // Add successful
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("AddSuccess")); // Set up success message
					$sReturnUrl = $this->getReturnUrl();
					if (ew_GetPageName($sReturnUrl) == "minat_investasilist.php")
						$sReturnUrl = $this->AddMasterUrl($sReturnUrl); // List page, return to list page with correct master key if necessary
					elseif (ew_GetPageName($sReturnUrl) == "minat_investasiview.php")
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
		$this->nib->CurrentValue = NULL;
		$this->nib->OldValue = $this->nib->CurrentValue;
		$this->nama->CurrentValue = NULL;
		$this->nama->OldValue = $this->nama->CurrentValue;
		$this->penanaman_modal->CurrentValue = NULL;
		$this->penanaman_modal->OldValue = $this->penanaman_modal->CurrentValue;
		$this->jenis_perusahaan->CurrentValue = NULL;
		$this->jenis_perusahaan->OldValue = $this->jenis_perusahaan->CurrentValue;
		$this->id_jenis->CurrentValue = NULL;
		$this->id_jenis->OldValue = $this->id_jenis->CurrentValue;
		$this->id_kecamatan->CurrentValue = NULL;
		$this->id_kecamatan->OldValue = $this->id_kecamatan->CurrentValue;
		$this->sysdate->CurrentValue = NULL;
		$this->sysdate->OldValue = $this->sysdate->CurrentValue;
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->nib->FldIsDetailKey) {
			$this->nib->setFormValue($objForm->GetValue("x_nib"));
		}
		if (!$this->nama->FldIsDetailKey) {
			$this->nama->setFormValue($objForm->GetValue("x_nama"));
		}
		if (!$this->penanaman_modal->FldIsDetailKey) {
			$this->penanaman_modal->setFormValue($objForm->GetValue("x_penanaman_modal"));
		}
		if (!$this->jenis_perusahaan->FldIsDetailKey) {
			$this->jenis_perusahaan->setFormValue($objForm->GetValue("x_jenis_perusahaan"));
		}
		if (!$this->id_jenis->FldIsDetailKey) {
			$this->id_jenis->setFormValue($objForm->GetValue("x_id_jenis"));
		}
		if (!$this->id_kecamatan->FldIsDetailKey) {
			$this->id_kecamatan->setFormValue($objForm->GetValue("x_id_kecamatan"));
		}
		if (!$this->sysdate->FldIsDetailKey) {
			$this->sysdate->setFormValue($objForm->GetValue("x_sysdate"));
			$this->sysdate->CurrentValue = ew_UnFormatDateTime($this->sysdate->CurrentValue, 0);
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadOldRecord();
		$this->nib->CurrentValue = $this->nib->FormValue;
		$this->nama->CurrentValue = $this->nama->FormValue;
		$this->penanaman_modal->CurrentValue = $this->penanaman_modal->FormValue;
		$this->jenis_perusahaan->CurrentValue = $this->jenis_perusahaan->FormValue;
		$this->id_jenis->CurrentValue = $this->id_jenis->FormValue;
		$this->id_kecamatan->CurrentValue = $this->id_kecamatan->FormValue;
		$this->sysdate->CurrentValue = $this->sysdate->FormValue;
		$this->sysdate->CurrentValue = ew_UnFormatDateTime($this->sysdate->CurrentValue, 0);
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

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($this->getKey("id_minat_investasi")) <> "")
			$this->id_minat_investasi->CurrentValue = $this->getKey("id_minat_investasi"); // id_minat_investasi
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
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// nib
			$this->nib->EditAttrs["class"] = "form-control";
			$this->nib->EditCustomAttributes = "";
			$this->nib->EditValue = ew_HtmlEncode($this->nib->CurrentValue);
			$this->nib->PlaceHolder = ew_RemoveHtml($this->nib->FldCaption());

			// nama
			$this->nama->EditAttrs["class"] = "form-control";
			$this->nama->EditCustomAttributes = "";
			$this->nama->EditValue = ew_HtmlEncode($this->nama->CurrentValue);
			$this->nama->PlaceHolder = ew_RemoveHtml($this->nama->FldCaption());

			// penanaman_modal
			$this->penanaman_modal->EditAttrs["class"] = "form-control";
			$this->penanaman_modal->EditCustomAttributes = "";
			if (trim(strval($this->penanaman_modal->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`id_status`" . ew_SearchString("=", $this->penanaman_modal->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `id_status`, `status` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `status`";
			$sWhereWrk = "";
			$this->penanaman_modal->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->penanaman_modal, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->penanaman_modal->EditValue = $arwrk;

			// jenis_perusahaan
			$this->jenis_perusahaan->EditAttrs["class"] = "form-control";
			$this->jenis_perusahaan->EditCustomAttributes = "";
			if (trim(strval($this->jenis_perusahaan->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`id_jp`" . ew_SearchString("=", $this->jenis_perusahaan->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `id_jp`, `jenis_perusahaan` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `jenis_perusahaan`";
			$sWhereWrk = "";
			$this->jenis_perusahaan->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->jenis_perusahaan, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->jenis_perusahaan->EditValue = $arwrk;

			// id_jenis
			$this->id_jenis->EditAttrs["class"] = "form-control";
			$this->id_jenis->EditCustomAttributes = "";
			if (trim(strval($this->id_jenis->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`id_jenis`" . ew_SearchString("=", $this->id_jenis->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `id_jenis`, `jenis` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `jenis`";
			$sWhereWrk = "";
			$this->id_jenis->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->id_jenis, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->id_jenis->EditValue = $arwrk;

			// id_kecamatan
			$this->id_kecamatan->EditAttrs["class"] = "form-control";
			$this->id_kecamatan->EditCustomAttributes = "";
			if (trim(strval($this->id_kecamatan->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`id_kecamatan`" . ew_SearchString("=", $this->id_kecamatan->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `id_kecamatan`, `kecamatan` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `kecamatan`";
			$sWhereWrk = "";
			$this->id_kecamatan->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->id_kecamatan, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->id_kecamatan->EditValue = $arwrk;

			// sysdate
			$this->sysdate->EditAttrs["class"] = "form-control";
			$this->sysdate->EditCustomAttributes = "";
			$this->sysdate->EditValue = ew_HtmlEncode(ew_FormatDateTime($this->sysdate->CurrentValue, 8));
			$this->sysdate->PlaceHolder = ew_RemoveHtml($this->sysdate->FldCaption());

			// Add refer script
			// nib

			$this->nib->LinkCustomAttributes = "";
			$this->nib->HrefValue = "";

			// nama
			$this->nama->LinkCustomAttributes = "";
			$this->nama->HrefValue = "";

			// penanaman_modal
			$this->penanaman_modal->LinkCustomAttributes = "";
			$this->penanaman_modal->HrefValue = "";

			// jenis_perusahaan
			$this->jenis_perusahaan->LinkCustomAttributes = "";
			$this->jenis_perusahaan->HrefValue = "";

			// id_jenis
			$this->id_jenis->LinkCustomAttributes = "";
			$this->id_jenis->HrefValue = "";

			// id_kecamatan
			$this->id_kecamatan->LinkCustomAttributes = "";
			$this->id_kecamatan->HrefValue = "";

			// sysdate
			$this->sysdate->LinkCustomAttributes = "";
			$this->sysdate->HrefValue = "";
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
		if (!$this->id_jenis->FldIsDetailKey && !is_null($this->id_jenis->FormValue) && $this->id_jenis->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->id_jenis->FldCaption(), $this->id_jenis->ReqErrMsg));
		}
		if (!$this->id_kecamatan->FldIsDetailKey && !is_null($this->id_kecamatan->FormValue) && $this->id_kecamatan->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->id_kecamatan->FldCaption(), $this->id_kecamatan->ReqErrMsg));
		}
		if (!ew_CheckDateDef($this->sysdate->FormValue)) {
			ew_AddMessage($gsFormError, $this->sysdate->FldErrMsg());
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

		// nib
		$this->nib->SetDbValueDef($rsnew, $this->nib->CurrentValue, NULL, FALSE);

		// nama
		$this->nama->SetDbValueDef($rsnew, $this->nama->CurrentValue, NULL, FALSE);

		// penanaman_modal
		$this->penanaman_modal->SetDbValueDef($rsnew, $this->penanaman_modal->CurrentValue, NULL, FALSE);

		// jenis_perusahaan
		$this->jenis_perusahaan->SetDbValueDef($rsnew, $this->jenis_perusahaan->CurrentValue, NULL, FALSE);

		// id_jenis
		$this->id_jenis->SetDbValueDef($rsnew, $this->id_jenis->CurrentValue, 0, FALSE);

		// id_kecamatan
		$this->id_kecamatan->SetDbValueDef($rsnew, $this->id_kecamatan->CurrentValue, 0, FALSE);

		// sysdate
		$this->sysdate->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->sysdate->CurrentValue, 0), NULL, FALSE);

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
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("minat_investasilist.php"), "", $this->TableVar, TRUE);
		$PageId = ($this->CurrentAction == "C") ? "Copy" : "Add";
		$Breadcrumb->Add("add", $PageId, $url);
	}

	// Setup lookup filters of a field
	function SetupLookupFilters($fld, $pageId = null) {
		global $gsLanguage;
		$pageId = $pageId ?: $this->PageID;
		switch ($fld->FldVar) {
		case "x_penanaman_modal":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `id_status` AS `LinkFld`, `status` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `status`";
			$sWhereWrk = "";
			$this->penanaman_modal->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => '`id_status` = {filter_value}', "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->penanaman_modal, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_jenis_perusahaan":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `id_jp` AS `LinkFld`, `jenis_perusahaan` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `jenis_perusahaan`";
			$sWhereWrk = "";
			$this->jenis_perusahaan->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => '`id_jp` = {filter_value}', "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->jenis_perusahaan, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_id_jenis":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `id_jenis` AS `LinkFld`, `jenis` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `jenis`";
			$sWhereWrk = "";
			$this->id_jenis->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => '`id_jenis` = {filter_value}', "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->id_jenis, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_id_kecamatan":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `id_kecamatan` AS `LinkFld`, `kecamatan` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `kecamatan`";
			$sWhereWrk = "";
			$this->id_kecamatan->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => '`id_kecamatan` = {filter_value}', "t0" => "19", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->id_kecamatan, $sWhereWrk); // Call Lookup selecting
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
if (!isset($minat_investasi_add)) $minat_investasi_add = new cminat_investasi_add();

// Page init
$minat_investasi_add->Page_Init();

// Page main
$minat_investasi_add->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$minat_investasi_add->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "add";
var CurrentForm = fminat_investasiadd = new ew_Form("fminat_investasiadd", "add");

// Validate form
fminat_investasiadd.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_id_jenis");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $minat_investasi->id_jenis->FldCaption(), $minat_investasi->id_jenis->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_id_kecamatan");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $minat_investasi->id_kecamatan->FldCaption(), $minat_investasi->id_kecamatan->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_sysdate");
			if (elm && !ew_CheckDateDef(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($minat_investasi->sysdate->FldErrMsg()) ?>");

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
fminat_investasiadd.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fminat_investasiadd.ValidateRequired = true;
<?php } else { ?>
fminat_investasiadd.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fminat_investasiadd.Lists["x_penanaman_modal"] = {"LinkField":"x_id_status","Ajax":true,"AutoFill":false,"DisplayFields":["x_status","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"status"};
fminat_investasiadd.Lists["x_jenis_perusahaan"] = {"LinkField":"x_id_jp","Ajax":true,"AutoFill":false,"DisplayFields":["x_jenis_perusahaan","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"jenis_perusahaan"};
fminat_investasiadd.Lists["x_id_jenis"] = {"LinkField":"x_id_jenis","Ajax":true,"AutoFill":false,"DisplayFields":["x_jenis","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"jenis"};
fminat_investasiadd.Lists["x_id_kecamatan"] = {"LinkField":"x_id_kecamatan","Ajax":true,"AutoFill":false,"DisplayFields":["x_kecamatan","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"kecamatan"};

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php if (!$minat_investasi_add->IsModal) { ?>
<?php } ?>
<?php $minat_investasi_add->ShowPageHeader(); ?>
<?php
$minat_investasi_add->ShowMessage();
?>
<form name="fminat_investasiadd" id="fminat_investasiadd" class="<?php echo $minat_investasi_add->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($minat_investasi_add->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $minat_investasi_add->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="minat_investasi">
<input type="hidden" name="a_add" id="a_add" value="A">
<?php if ($minat_investasi_add->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<div>
<?php if ($minat_investasi->nib->Visible) { // nib ?>
	<div id="r_nib" class="form-group">
		<label id="elh_minat_investasi_nib" for="x_nib" class="col-sm-2 control-label ewLabel"><?php echo $minat_investasi->nib->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $minat_investasi->nib->CellAttributes() ?>>
<span id="el_minat_investasi_nib">
<input type="text" data-table="minat_investasi" data-field="x_nib" name="x_nib" id="x_nib" size="30" maxlength="255" placeholder="<?php echo ew_HtmlEncode($minat_investasi->nib->getPlaceHolder()) ?>" value="<?php echo $minat_investasi->nib->EditValue ?>"<?php echo $minat_investasi->nib->EditAttributes() ?>>
</span>
<?php echo $minat_investasi->nib->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($minat_investasi->nama->Visible) { // nama ?>
	<div id="r_nama" class="form-group">
		<label id="elh_minat_investasi_nama" for="x_nama" class="col-sm-2 control-label ewLabel"><?php echo $minat_investasi->nama->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $minat_investasi->nama->CellAttributes() ?>>
<span id="el_minat_investasi_nama">
<input type="text" data-table="minat_investasi" data-field="x_nama" name="x_nama" id="x_nama" size="30" maxlength="255" placeholder="<?php echo ew_HtmlEncode($minat_investasi->nama->getPlaceHolder()) ?>" value="<?php echo $minat_investasi->nama->EditValue ?>"<?php echo $minat_investasi->nama->EditAttributes() ?>>
</span>
<?php echo $minat_investasi->nama->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($minat_investasi->penanaman_modal->Visible) { // penanaman_modal ?>
	<div id="r_penanaman_modal" class="form-group">
		<label id="elh_minat_investasi_penanaman_modal" for="x_penanaman_modal" class="col-sm-2 control-label ewLabel"><?php echo $minat_investasi->penanaman_modal->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $minat_investasi->penanaman_modal->CellAttributes() ?>>
<span id="el_minat_investasi_penanaman_modal">
<select data-table="minat_investasi" data-field="x_penanaman_modal" data-value-separator="<?php echo $minat_investasi->penanaman_modal->DisplayValueSeparatorAttribute() ?>" id="x_penanaman_modal" name="x_penanaman_modal"<?php echo $minat_investasi->penanaman_modal->EditAttributes() ?>>
<?php echo $minat_investasi->penanaman_modal->SelectOptionListHtml("x_penanaman_modal") ?>
</select>
<input type="hidden" name="s_x_penanaman_modal" id="s_x_penanaman_modal" value="<?php echo $minat_investasi->penanaman_modal->LookupFilterQuery() ?>">
</span>
<?php echo $minat_investasi->penanaman_modal->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($minat_investasi->jenis_perusahaan->Visible) { // jenis_perusahaan ?>
	<div id="r_jenis_perusahaan" class="form-group">
		<label id="elh_minat_investasi_jenis_perusahaan" for="x_jenis_perusahaan" class="col-sm-2 control-label ewLabel"><?php echo $minat_investasi->jenis_perusahaan->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $minat_investasi->jenis_perusahaan->CellAttributes() ?>>
<span id="el_minat_investasi_jenis_perusahaan">
<select data-table="minat_investasi" data-field="x_jenis_perusahaan" data-value-separator="<?php echo $minat_investasi->jenis_perusahaan->DisplayValueSeparatorAttribute() ?>" id="x_jenis_perusahaan" name="x_jenis_perusahaan"<?php echo $minat_investasi->jenis_perusahaan->EditAttributes() ?>>
<?php echo $minat_investasi->jenis_perusahaan->SelectOptionListHtml("x_jenis_perusahaan") ?>
</select>
<input type="hidden" name="s_x_jenis_perusahaan" id="s_x_jenis_perusahaan" value="<?php echo $minat_investasi->jenis_perusahaan->LookupFilterQuery() ?>">
</span>
<?php echo $minat_investasi->jenis_perusahaan->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($minat_investasi->id_jenis->Visible) { // id_jenis ?>
	<div id="r_id_jenis" class="form-group">
		<label id="elh_minat_investasi_id_jenis" for="x_id_jenis" class="col-sm-2 control-label ewLabel"><?php echo $minat_investasi->id_jenis->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $minat_investasi->id_jenis->CellAttributes() ?>>
<span id="el_minat_investasi_id_jenis">
<select data-table="minat_investasi" data-field="x_id_jenis" data-value-separator="<?php echo $minat_investasi->id_jenis->DisplayValueSeparatorAttribute() ?>" id="x_id_jenis" name="x_id_jenis"<?php echo $minat_investasi->id_jenis->EditAttributes() ?>>
<?php echo $minat_investasi->id_jenis->SelectOptionListHtml("x_id_jenis") ?>
</select>
<input type="hidden" name="s_x_id_jenis" id="s_x_id_jenis" value="<?php echo $minat_investasi->id_jenis->LookupFilterQuery() ?>">
</span>
<?php echo $minat_investasi->id_jenis->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($minat_investasi->id_kecamatan->Visible) { // id_kecamatan ?>
	<div id="r_id_kecamatan" class="form-group">
		<label id="elh_minat_investasi_id_kecamatan" for="x_id_kecamatan" class="col-sm-2 control-label ewLabel"><?php echo $minat_investasi->id_kecamatan->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $minat_investasi->id_kecamatan->CellAttributes() ?>>
<span id="el_minat_investasi_id_kecamatan">
<select data-table="minat_investasi" data-field="x_id_kecamatan" data-value-separator="<?php echo $minat_investasi->id_kecamatan->DisplayValueSeparatorAttribute() ?>" id="x_id_kecamatan" name="x_id_kecamatan"<?php echo $minat_investasi->id_kecamatan->EditAttributes() ?>>
<?php echo $minat_investasi->id_kecamatan->SelectOptionListHtml("x_id_kecamatan") ?>
</select>
<input type="hidden" name="s_x_id_kecamatan" id="s_x_id_kecamatan" value="<?php echo $minat_investasi->id_kecamatan->LookupFilterQuery() ?>">
</span>
<?php echo $minat_investasi->id_kecamatan->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($minat_investasi->sysdate->Visible) { // sysdate ?>
	<div id="r_sysdate" class="form-group">
		<label id="elh_minat_investasi_sysdate" for="x_sysdate" class="col-sm-2 control-label ewLabel"><?php echo $minat_investasi->sysdate->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $minat_investasi->sysdate->CellAttributes() ?>>
<span id="el_minat_investasi_sysdate">
<input type="text" data-table="minat_investasi" data-field="x_sysdate" name="x_sysdate" id="x_sysdate" placeholder="<?php echo ew_HtmlEncode($minat_investasi->sysdate->getPlaceHolder()) ?>" value="<?php echo $minat_investasi->sysdate->EditValue ?>"<?php echo $minat_investasi->sysdate->EditAttributes() ?>>
</span>
<?php echo $minat_investasi->sysdate->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div>
<?php if (!$minat_investasi_add->IsModal) { ?>
<div class="form-group">
	<div class="col-sm-offset-2 col-sm-10">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("AddBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $minat_investasi_add->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div>
</div>
<?php } ?>
</form>
<script type="text/javascript">
fminat_investasiadd.Init();
</script>
<?php
$minat_investasi_add->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$minat_investasi_add->Page_Terminate();
?>
