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

$minat_investasi_view = NULL; // Initialize page object first

class cminat_investasi_view extends cminat_investasi {

	// Page ID
	var $PageID = 'view';

	// Project ID
	var $ProjectID = "{711D4B7A-499A-4AB9-B89B-D8472076C077}";

	// Table name
	var $TableName = 'minat_investasi';

	// Page object name
	var $PageObjName = 'minat_investasi_view';

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

	// Page URLs
	var $AddUrl;
	var $EditUrl;
	var $CopyUrl;
	var $DeleteUrl;
	var $ViewUrl;
	var $ListUrl;

	// Export URLs
	var $ExportPrintUrl;
	var $ExportHtmlUrl;
	var $ExportExcelUrl;
	var $ExportWordUrl;
	var $ExportXmlUrl;
	var $ExportCsvUrl;
	var $ExportPdfUrl;

	// Custom export
	var $ExportExcelCustom = FALSE;
	var $ExportWordCustom = FALSE;
	var $ExportPdfCustom = FALSE;
	var $ExportEmailCustom = FALSE;

	// Update URLs
	var $InlineAddUrl;
	var $InlineCopyUrl;
	var $InlineEditUrl;
	var $GridAddUrl;
	var $GridEditUrl;
	var $MultiDeleteUrl;
	var $MultiUpdateUrl;

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
		$KeyUrl = "";
		if (@$_GET["id_minat_investasi"] <> "") {
			$this->RecKey["id_minat_investasi"] = $_GET["id_minat_investasi"];
			$KeyUrl .= "&amp;id_minat_investasi=" . urlencode($this->RecKey["id_minat_investasi"]);
		}
		$this->ExportPrintUrl = $this->PageUrl() . "export=print" . $KeyUrl;
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html" . $KeyUrl;
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel" . $KeyUrl;
		$this->ExportWordUrl = $this->PageUrl() . "export=word" . $KeyUrl;
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml" . $KeyUrl;
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv" . $KeyUrl;
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf" . $KeyUrl;

		// Table object (user)
		if (!isset($GLOBALS['user'])) $GLOBALS['user'] = new cuser();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'view', TRUE);

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

		// Export options
		$this->ExportOptions = new cListOptions();
		$this->ExportOptions->Tag = "div";
		$this->ExportOptions->TagClassName = "ewExportOption";

		// Other options
		$this->OtherOptions['action'] = new cListOptions();
		$this->OtherOptions['action']->Tag = "div";
		$this->OtherOptions['action']->TagClassName = "ewActionOption";
		$this->OtherOptions['detail'] = new cListOptions();
		$this->OtherOptions['detail']->Tag = "div";
		$this->OtherOptions['detail']->TagClassName = "ewDetailOption";
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
		if (!$Security->CanView()) {
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
		$this->id_minat_investasi->SetVisibility();
		$this->id_minat_investasi->Visible = !$this->IsAdd() && !$this->IsCopy() && !$this->IsGridAdd();
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
	var $ExportOptions; // Export options
	var $OtherOptions = array(); // Other options
	var $DisplayRecs = 1;
	var $DbMasterFilter;
	var $DbDetailFilter;
	var $StartRec;
	var $StopRec;
	var $TotalRecs = 0;
	var $RecRange = 10;
	var $RecCnt;
	var $RecKey = array();
	var $IsModal = FALSE;
	var $Recordset;

	//
	// Page main
	//
	function Page_Main() {
		global $Language;
		global $gbSkipHeaderFooter;

		// Check modal
		$this->IsModal = (@$_GET["modal"] == "1" || @$_POST["modal"] == "1");
		if ($this->IsModal)
			$gbSkipHeaderFooter = TRUE;
		$sReturnUrl = "";
		$bMatchRecord = FALSE;
		if ($this->IsPageRequest()) { // Validate request
			if (@$_GET["id_minat_investasi"] <> "") {
				$this->id_minat_investasi->setQueryStringValue($_GET["id_minat_investasi"]);
				$this->RecKey["id_minat_investasi"] = $this->id_minat_investasi->QueryStringValue;
			} elseif (@$_POST["id_minat_investasi"] <> "") {
				$this->id_minat_investasi->setFormValue($_POST["id_minat_investasi"]);
				$this->RecKey["id_minat_investasi"] = $this->id_minat_investasi->FormValue;
			} else {
				$sReturnUrl = "minat_investasilist.php"; // Return to list
			}

			// Get action
			$this->CurrentAction = "I"; // Display form
			switch ($this->CurrentAction) {
				case "I": // Get a record to display
					if (!$this->LoadRow()) { // Load record based on key
						if ($this->getSuccessMessage() == "" && $this->getFailureMessage() == "")
							$this->setFailureMessage($Language->Phrase("NoRecord")); // Set no record message
						$sReturnUrl = "minat_investasilist.php"; // No matching record, return to list
					}
			}
		} else {
			$sReturnUrl = "minat_investasilist.php"; // Not page request, return to list
		}
		if ($sReturnUrl <> "")
			$this->Page_Terminate($sReturnUrl);

		// Set up Breadcrumb
		if ($this->Export == "")
			$this->SetupBreadcrumb();

		// Render row
		$this->RowType = EW_ROWTYPE_VIEW;
		$this->ResetAttrs();
		$this->RenderRow();
	}

	// Set up other options
	function SetupOtherOptions() {
		global $Language, $Security;
		$options = &$this->OtherOptions;
		$option = &$options["action"];

		// Add
		$item = &$option->Add("add");
		$addcaption = ew_HtmlTitle($Language->Phrase("ViewPageAddLink"));
		if ($this->IsModal) // Modal
			$item->Body = "<a class=\"ewAction ewAdd\" title=\"" . $addcaption . "\" data-caption=\"" . $addcaption . "\" href=\"javascript:void(0);\" onclick=\"ew_ModalDialogShow({lnk:this,url:'" . ew_HtmlEncode($this->AddUrl) . "',caption:'" . $addcaption . "'});\">" . $Language->Phrase("ViewPageAddLink") . "</a>";
		else
			$item->Body = "<a class=\"ewAction ewAdd\" title=\"" . $addcaption . "\" data-caption=\"" . $addcaption . "\" href=\"" . ew_HtmlEncode($this->AddUrl) . "\">" . $Language->Phrase("ViewPageAddLink") . "</a>";
		$item->Visible = ($this->AddUrl <> "" && $Security->CanAdd());

		// Edit
		$item = &$option->Add("edit");
		$editcaption = ew_HtmlTitle($Language->Phrase("ViewPageEditLink"));
		if ($this->IsModal) // Modal
			$item->Body = "<a class=\"ewAction ewEdit\" title=\"" . $editcaption . "\" data-caption=\"" . $editcaption . "\" href=\"javascript:void(0);\" onclick=\"ew_ModalDialogShow({lnk:this,url:'" . ew_HtmlEncode($this->EditUrl) . "',caption:'" . $editcaption . "'});\">" . $Language->Phrase("ViewPageEditLink") . "</a>";
		else
			$item->Body = "<a class=\"ewAction ewEdit\" title=\"" . $editcaption . "\" data-caption=\"" . $editcaption . "\" href=\"" . ew_HtmlEncode($this->EditUrl) . "\">" . $Language->Phrase("ViewPageEditLink") . "</a>";
		$item->Visible = ($this->EditUrl <> "" && $Security->CanEdit());

		// Copy
		$item = &$option->Add("copy");
		$copycaption = ew_HtmlTitle($Language->Phrase("ViewPageCopyLink"));
		if ($this->IsModal) // Modal
			$item->Body = "<a class=\"ewAction ewCopy\" title=\"" . $copycaption . "\" data-caption=\"" . $copycaption . "\" href=\"javascript:void(0);\" onclick=\"ew_ModalDialogShow({lnk:this,url:'" . ew_HtmlEncode($this->CopyUrl) . "',caption:'" . $copycaption . "'});\">" . $Language->Phrase("ViewPageCopyLink") . "</a>";
		else
			$item->Body = "<a class=\"ewAction ewCopy\" title=\"" . $copycaption . "\" data-caption=\"" . $copycaption . "\" href=\"" . ew_HtmlEncode($this->CopyUrl) . "\">" . $Language->Phrase("ViewPageCopyLink") . "</a>";
		$item->Visible = ($this->CopyUrl <> "" && $Security->CanAdd());

		// Delete
		$item = &$option->Add("delete");
		if ($this->IsModal) // Handle as inline delete
			$item->Body = "<a onclick=\"return ew_ConfirmDelete(this);\" class=\"ewAction ewDelete\" title=\"" . ew_HtmlTitle($Language->Phrase("ViewPageDeleteLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("ViewPageDeleteLink")) . "\" href=\"" . ew_HtmlEncode(ew_AddQueryStringToUrl($this->DeleteUrl, "a_delete=1")) . "\">" . $Language->Phrase("ViewPageDeleteLink") . "</a>";
		else
			$item->Body = "<a class=\"ewAction ewDelete\" title=\"" . ew_HtmlTitle($Language->Phrase("ViewPageDeleteLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("ViewPageDeleteLink")) . "\" href=\"" . ew_HtmlEncode($this->DeleteUrl) . "\">" . $Language->Phrase("ViewPageDeleteLink") . "</a>";
		$item->Visible = ($this->DeleteUrl <> "" && $Security->CanDelete());

		// Set up action default
		$option = &$options["action"];
		$option->DropDownButtonPhrase = $Language->Phrase("ButtonActions");
		$option->UseImageAndText = TRUE;
		$option->UseDropDownButton = FALSE;
		$option->UseButtonGroup = TRUE;
		$item = &$option->Add($option->GroupOptionName);
		$item->Body = "";
		$item->Visible = FALSE;
	}

	// Set up starting record parameters
	function SetUpStartRec() {
		if ($this->DisplayRecs == 0)
			return;
		if ($this->IsPageRequest()) { // Validate request
			if (@$_GET[EW_TABLE_START_REC] <> "") { // Check for "start" parameter
				$this->StartRec = $_GET[EW_TABLE_START_REC];
				$this->setStartRecordNumber($this->StartRec);
			} elseif (@$_GET[EW_TABLE_PAGE_NO] <> "") {
				$PageNo = $_GET[EW_TABLE_PAGE_NO];
				if (is_numeric($PageNo)) {
					$this->StartRec = ($PageNo-1)*$this->DisplayRecs+1;
					if ($this->StartRec <= 0) {
						$this->StartRec = 1;
					} elseif ($this->StartRec >= intval(($this->TotalRecs-1)/$this->DisplayRecs)*$this->DisplayRecs+1) {
						$this->StartRec = intval(($this->TotalRecs-1)/$this->DisplayRecs)*$this->DisplayRecs+1;
					}
					$this->setStartRecordNumber($this->StartRec);
				}
			}
		}
		$this->StartRec = $this->getStartRecordNumber();

		// Check if correct start record counter
		if (!is_numeric($this->StartRec) || $this->StartRec == "") { // Avoid invalid start record counter
			$this->StartRec = 1; // Reset start record counter
			$this->setStartRecordNumber($this->StartRec);
		} elseif (intval($this->StartRec) > intval($this->TotalRecs)) { // Avoid starting record > total records
			$this->StartRec = intval(($this->TotalRecs-1)/$this->DisplayRecs)*$this->DisplayRecs+1; // Point to last page first record
			$this->setStartRecordNumber($this->StartRec);
		} elseif (($this->StartRec-1) % $this->DisplayRecs <> 0) {
			$this->StartRec = intval(($this->StartRec-1)/$this->DisplayRecs)*$this->DisplayRecs+1; // Point to page boundary
			$this->setStartRecordNumber($this->StartRec);
		}
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
		$this->AddUrl = $this->GetAddUrl();
		$this->EditUrl = $this->GetEditUrl();
		$this->CopyUrl = $this->GetCopyUrl();
		$this->DeleteUrl = $this->GetDeleteUrl();
		$this->ListUrl = $this->GetListUrl();
		$this->SetupOtherOptions();

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
		}

		// Call Row Rendered event
		if ($this->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$this->Row_Rendered();
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("minat_investasilist.php"), "", $this->TableVar, TRUE);
		$PageId = "view";
		$Breadcrumb->Add("view", $PageId, $url);
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

	// Page Exporting event
	// $this->ExportDoc = export document object
	function Page_Exporting() {

		//$this->ExportDoc->Text = "my header"; // Export header
		//return FALSE; // Return FALSE to skip default export and use Row_Export event

		return TRUE; // Return TRUE to use default export and skip Row_Export event
	}

	// Row Export event
	// $this->ExportDoc = export document object
	function Row_Export($rs) {

		//$this->ExportDoc->Text .= "my content"; // Build HTML with field value: $rs["MyField"] or $this->MyField->ViewValue
	}

	// Page Exported event
	// $this->ExportDoc = export document object
	function Page_Exported() {

		//$this->ExportDoc->Text .= "my footer"; // Export footer
		//echo $this->ExportDoc->Text;

	}
}
?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
if (!isset($minat_investasi_view)) $minat_investasi_view = new cminat_investasi_view();

// Page init
$minat_investasi_view->Page_Init();

// Page main
$minat_investasi_view->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$minat_investasi_view->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "view";
var CurrentForm = fminat_investasiview = new ew_Form("fminat_investasiview", "view");

// Form_CustomValidate event
fminat_investasiview.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fminat_investasiview.ValidateRequired = true;
<?php } else { ?>
fminat_investasiview.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fminat_investasiview.Lists["x_penanaman_modal"] = {"LinkField":"x_id_status","Ajax":true,"AutoFill":false,"DisplayFields":["x_status","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"status"};
fminat_investasiview.Lists["x_jenis_perusahaan"] = {"LinkField":"x_id_jp","Ajax":true,"AutoFill":false,"DisplayFields":["x_jenis_perusahaan","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"jenis_perusahaan"};
fminat_investasiview.Lists["x_id_jenis"] = {"LinkField":"x_id_jenis","Ajax":true,"AutoFill":false,"DisplayFields":["x_jenis","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"jenis"};
fminat_investasiview.Lists["x_id_kecamatan"] = {"LinkField":"x_id_kecamatan","Ajax":true,"AutoFill":false,"DisplayFields":["x_kecamatan","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"kecamatan"};

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php if (!$minat_investasi_view->IsModal) { ?>
<?php } ?>
<?php $minat_investasi_view->ExportOptions->Render("body") ?>
<?php
	foreach ($minat_investasi_view->OtherOptions as &$option)
		$option->Render("body");
?>
<?php if (!$minat_investasi_view->IsModal) { ?>
<?php echo $Language->SelectionForm(); ?>
<?php } ?>
<div class="clearfix"></div>
<?php $minat_investasi_view->ShowPageHeader(); ?>
<?php
$minat_investasi_view->ShowMessage();
?>
<form name="fminat_investasiview" id="fminat_investasiview" class="form-inline ewForm ewViewForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($minat_investasi_view->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $minat_investasi_view->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="minat_investasi">
<?php if ($minat_investasi_view->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<table class="table table-bordered table-striped table-condensedtable-hover ewViewTable">
<?php if ($minat_investasi->id_minat_investasi->Visible) { // id_minat_investasi ?>
	<tr id="r_id_minat_investasi">
		<td><span id="elh_minat_investasi_id_minat_investasi"><?php echo $minat_investasi->id_minat_investasi->FldCaption() ?></span></td>
		<td data-name="id_minat_investasi"<?php echo $minat_investasi->id_minat_investasi->CellAttributes() ?>>
<span id="el_minat_investasi_id_minat_investasi">
<span<?php echo $minat_investasi->id_minat_investasi->ViewAttributes() ?>>
<?php echo $minat_investasi->id_minat_investasi->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($minat_investasi->nib->Visible) { // nib ?>
	<tr id="r_nib">
		<td><span id="elh_minat_investasi_nib"><?php echo $minat_investasi->nib->FldCaption() ?></span></td>
		<td data-name="nib"<?php echo $minat_investasi->nib->CellAttributes() ?>>
<span id="el_minat_investasi_nib">
<span<?php echo $minat_investasi->nib->ViewAttributes() ?>>
<?php echo $minat_investasi->nib->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($minat_investasi->nama->Visible) { // nama ?>
	<tr id="r_nama">
		<td><span id="elh_minat_investasi_nama"><?php echo $minat_investasi->nama->FldCaption() ?></span></td>
		<td data-name="nama"<?php echo $minat_investasi->nama->CellAttributes() ?>>
<span id="el_minat_investasi_nama">
<span<?php echo $minat_investasi->nama->ViewAttributes() ?>>
<?php echo $minat_investasi->nama->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($minat_investasi->penanaman_modal->Visible) { // penanaman_modal ?>
	<tr id="r_penanaman_modal">
		<td><span id="elh_minat_investasi_penanaman_modal"><?php echo $minat_investasi->penanaman_modal->FldCaption() ?></span></td>
		<td data-name="penanaman_modal"<?php echo $minat_investasi->penanaman_modal->CellAttributes() ?>>
<span id="el_minat_investasi_penanaman_modal">
<span<?php echo $minat_investasi->penanaman_modal->ViewAttributes() ?>>
<?php echo $minat_investasi->penanaman_modal->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($minat_investasi->jenis_perusahaan->Visible) { // jenis_perusahaan ?>
	<tr id="r_jenis_perusahaan">
		<td><span id="elh_minat_investasi_jenis_perusahaan"><?php echo $minat_investasi->jenis_perusahaan->FldCaption() ?></span></td>
		<td data-name="jenis_perusahaan"<?php echo $minat_investasi->jenis_perusahaan->CellAttributes() ?>>
<span id="el_minat_investasi_jenis_perusahaan">
<span<?php echo $minat_investasi->jenis_perusahaan->ViewAttributes() ?>>
<?php echo $minat_investasi->jenis_perusahaan->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($minat_investasi->id_jenis->Visible) { // id_jenis ?>
	<tr id="r_id_jenis">
		<td><span id="elh_minat_investasi_id_jenis"><?php echo $minat_investasi->id_jenis->FldCaption() ?></span></td>
		<td data-name="id_jenis"<?php echo $minat_investasi->id_jenis->CellAttributes() ?>>
<span id="el_minat_investasi_id_jenis">
<span<?php echo $minat_investasi->id_jenis->ViewAttributes() ?>>
<?php echo $minat_investasi->id_jenis->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($minat_investasi->id_kecamatan->Visible) { // id_kecamatan ?>
	<tr id="r_id_kecamatan">
		<td><span id="elh_minat_investasi_id_kecamatan"><?php echo $minat_investasi->id_kecamatan->FldCaption() ?></span></td>
		<td data-name="id_kecamatan"<?php echo $minat_investasi->id_kecamatan->CellAttributes() ?>>
<span id="el_minat_investasi_id_kecamatan">
<span<?php echo $minat_investasi->id_kecamatan->ViewAttributes() ?>>
<?php echo $minat_investasi->id_kecamatan->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($minat_investasi->sysdate->Visible) { // sysdate ?>
	<tr id="r_sysdate">
		<td><span id="elh_minat_investasi_sysdate"><?php echo $minat_investasi->sysdate->FldCaption() ?></span></td>
		<td data-name="sysdate"<?php echo $minat_investasi->sysdate->CellAttributes() ?>>
<span id="el_minat_investasi_sysdate">
<span<?php echo $minat_investasi->sysdate->ViewAttributes() ?>>
<?php echo $minat_investasi->sysdate->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
</table>
</form>
<script type="text/javascript">
fminat_investasiview.Init();
</script>
<?php
$minat_investasi_view->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$minat_investasi_view->Page_Terminate();
?>
