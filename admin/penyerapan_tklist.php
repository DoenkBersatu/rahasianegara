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

$penyerapan_tk_list = NULL; // Initialize page object first

class cpenyerapan_tk_list extends cpenyerapan_tk {

	// Page ID
	var $PageID = 'list';

	// Project ID
	var $ProjectID = "{711D4B7A-499A-4AB9-B89B-D8472076C077}";

	// Table name
	var $TableName = 'penyerapan_tk';

	// Page object name
	var $PageObjName = 'penyerapan_tk_list';

	// Grid form hidden field names
	var $FormName = 'fpenyerapan_tklist';
	var $FormActionName = 'k_action';
	var $FormKeyName = 'k_key';
	var $FormOldKeyName = 'k_oldkey';
	var $FormBlankRowName = 'k_blankrow';
	var $FormKeyCountName = 'key_count';

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

		// Table object (penyerapan_tk)
		if (!isset($GLOBALS["penyerapan_tk"]) || get_class($GLOBALS["penyerapan_tk"]) == "cpenyerapan_tk") {
			$GLOBALS["penyerapan_tk"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["penyerapan_tk"];
		}

		// Initialize URLs
		$this->ExportPrintUrl = $this->PageUrl() . "export=print";
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel";
		$this->ExportWordUrl = $this->PageUrl() . "export=word";
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html";
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml";
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv";
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf";
		$this->AddUrl = "penyerapan_tkadd.php";
		$this->InlineAddUrl = $this->PageUrl() . "a=add";
		$this->GridAddUrl = $this->PageUrl() . "a=gridadd";
		$this->GridEditUrl = $this->PageUrl() . "a=gridedit";
		$this->MultiDeleteUrl = "penyerapan_tkdelete.php";
		$this->MultiUpdateUrl = "penyerapan_tkupdate.php";

		// Table object (user)
		if (!isset($GLOBALS['user'])) $GLOBALS['user'] = new cuser();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'list', TRUE);

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

		// List options
		$this->ListOptions = new cListOptions();
		$this->ListOptions->TableVar = $this->TableVar;

		// Export options
		$this->ExportOptions = new cListOptions();
		$this->ExportOptions->Tag = "div";
		$this->ExportOptions->TagClassName = "ewExportOption";

		// Other options
		$this->OtherOptions['addedit'] = new cListOptions();
		$this->OtherOptions['addedit']->Tag = "div";
		$this->OtherOptions['addedit']->TagClassName = "ewAddEditOption";
		$this->OtherOptions['detail'] = new cListOptions();
		$this->OtherOptions['detail']->Tag = "div";
		$this->OtherOptions['detail']->TagClassName = "ewDetailOption";
		$this->OtherOptions['action'] = new cListOptions();
		$this->OtherOptions['action']->Tag = "div";
		$this->OtherOptions['action']->TagClassName = "ewActionOption";

		// Filter options
		$this->FilterOptions = new cListOptions();
		$this->FilterOptions->Tag = "div";
		$this->FilterOptions->TagClassName = "ewFilterOption fpenyerapan_tklistsrch";

		// List actions
		$this->ListActions = new cListActions();
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
		if (!$Security->CanList()) {
			$Security->SaveLastUrl();
			$this->setFailureMessage(ew_DeniedMsg()); // Set no permission
			$this->Page_Terminate(ew_GetUrl("index.php"));
		}
		if ($Security->IsLoggedIn()) {
			$Security->UserID_Loading();
			$Security->LoadUserID();
			$Security->UserID_Loaded();
		}
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action

		// Get grid add count
		$gridaddcnt = @$_GET[EW_TABLE_GRID_ADD_ROW_COUNT];
		if (is_numeric($gridaddcnt) && $gridaddcnt > 0)
			$this->GridAddRowCount = $gridaddcnt;

		// Set up list options
		$this->SetupListOptions();
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

		// Setup other options
		$this->SetupOtherOptions();

		// Set up custom action (compatible with old version)
		foreach ($this->CustomActions as $name => $action)
			$this->ListActions->Add($name, $action);

		// Show checkbox column if multiple action
		foreach ($this->ListActions->Items as $listaction) {
			if ($listaction->Select == EW_ACTION_MULTIPLE && $listaction->Allow) {
				$this->ListOptions->Items["checkbox"]->Visible = TRUE;
				break;
			}
		}
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

	// Class variables
	var $ListOptions; // List options
	var $ExportOptions; // Export options
	var $SearchOptions; // Search options
	var $OtherOptions = array(); // Other options
	var $FilterOptions; // Filter options
	var $ListActions; // List actions
	var $SelectedCount = 0;
	var $SelectedIndex = 0;
	var $DisplayRecs = 20;
	var $StartRec;
	var $StopRec;
	var $TotalRecs = 0;
	var $RecRange = 10;
	var $Pager;
	var $DefaultSearchWhere = ""; // Default search WHERE clause
	var $SearchWhere = ""; // Search WHERE clause
	var $RecCnt = 0; // Record count
	var $EditRowCnt;
	var $StartRowCnt = 1;
	var $RowCnt = 0;
	var $Attrs = array(); // Row attributes and cell attributes
	var $RowIndex = 0; // Row index
	var $KeyCount = 0; // Key count
	var $RowAction = ""; // Row action
	var $RowOldKey = ""; // Row old key (for copy)
	var $RecPerRow = 0;
	var $MultiColumnClass;
	var $MultiColumnEditClass = "col-sm-12";
	var $MultiColumnCnt = 12;
	var $MultiColumnEditCnt = 12;
	var $GridCnt = 0;
	var $ColCnt = 0;
	var $DbMasterFilter = ""; // Master filter
	var $DbDetailFilter = ""; // Detail filter
	var $MasterRecordExists;	
	var $MultiSelectKey;
	var $Command;
	var $RestoreSearch = FALSE;
	var $DetailPages;
	var $Recordset;
	var $OldRecordset;

	//
	// Page main
	//
	function Page_Main() {
		global $objForm, $Language, $gsFormError, $gsSearchError, $Security;

		// Search filters
		$sSrchAdvanced = ""; // Advanced search filter
		$sSrchBasic = ""; // Basic search filter
		$sFilter = "";

		// Get command
		$this->Command = strtolower(@$_GET["cmd"]);
		if ($this->IsPageRequest()) { // Validate request

			// Process list action first
			if ($this->ProcessListAction()) // Ajax request
				$this->Page_Terminate();

			// Handle reset command
			$this->ResetCmd();

			// Set up Breadcrumb
			if ($this->Export == "")
				$this->SetupBreadcrumb();

			// Hide list options
			if ($this->Export <> "") {
				$this->ListOptions->HideAllOptions(array("sequence"));
				$this->ListOptions->UseDropDownButton = FALSE; // Disable drop down button
				$this->ListOptions->UseButtonGroup = FALSE; // Disable button group
			} elseif ($this->CurrentAction == "gridadd" || $this->CurrentAction == "gridedit") {
				$this->ListOptions->HideAllOptions();
				$this->ListOptions->UseDropDownButton = FALSE; // Disable drop down button
				$this->ListOptions->UseButtonGroup = FALSE; // Disable button group
			}

			// Hide options
			if ($this->Export <> "" || $this->CurrentAction <> "") {
				$this->ExportOptions->HideAllOptions();
				$this->FilterOptions->HideAllOptions();
			}

			// Hide other options
			if ($this->Export <> "") {
				foreach ($this->OtherOptions as &$option)
					$option->HideAllOptions();
			}

			// Set up sorting order
			$this->SetUpSortOrder();
		}

		// Restore display records
		if ($this->getRecordsPerPage() <> "") {
			$this->DisplayRecs = $this->getRecordsPerPage(); // Restore from Session
		} else {
			$this->DisplayRecs = 20; // Load default
		}

		// Load Sorting Order
		$this->LoadSortOrder();

		// Build filter
		$sFilter = "";
		if (!$Security->CanList())
			$sFilter = "(0=1)"; // Filter all records
		ew_AddFilter($sFilter, $this->DbDetailFilter);
		ew_AddFilter($sFilter, $this->SearchWhere);

		// Set up filter in session
		$this->setSessionWhere($sFilter);
		$this->CurrentFilter = "";

		// Load record count first
		if (!$this->IsAddOrEdit()) {
			$bSelectLimit = $this->UseSelectLimit;
			if ($bSelectLimit) {
				$this->TotalRecs = $this->SelectRecordCount();
			} else {
				if ($this->Recordset = $this->LoadRecordset())
					$this->TotalRecs = $this->Recordset->RecordCount();
			}
		}

		// Search options
		$this->SetupSearchOptions();
	}

	// Build filter for all keys
	function BuildKeyFilter() {
		global $objForm;
		$sWrkFilter = "";

		// Update row index and get row key
		$rowindex = 1;
		$objForm->Index = $rowindex;
		$sThisKey = strval($objForm->GetValue($this->FormKeyName));
		while ($sThisKey <> "") {
			if ($this->SetupKeyValues($sThisKey)) {
				$sFilter = $this->KeyFilter();
				if ($sWrkFilter <> "") $sWrkFilter .= " OR ";
				$sWrkFilter .= $sFilter;
			} else {
				$sWrkFilter = "0=1";
				break;
			}

			// Update row index and get row key
			$rowindex++; // Next row
			$objForm->Index = $rowindex;
			$sThisKey = strval($objForm->GetValue($this->FormKeyName));
		}
		return $sWrkFilter;
	}

	// Set up key values
	function SetupKeyValues($key) {
		$arrKeyFlds = explode($GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"], $key);
		if (count($arrKeyFlds) >= 1) {
			$this->id_penyerapan_tk->setFormValue($arrKeyFlds[0]);
			if (!is_numeric($this->id_penyerapan_tk->FormValue))
				return FALSE;
		}
		return TRUE;
	}

	// Set up sort parameters
	function SetUpSortOrder() {

		// Check for "order" parameter
		if (@$_GET["order"] <> "") {
			$this->CurrentOrder = ew_StripSlashes(@$_GET["order"]);
			$this->CurrentOrderType = @$_GET["ordertype"];
			$this->UpdateSort($this->id_penyerapan_tk); // id_penyerapan_tk
			$this->UpdateSort($this->id_triwulan); // id_triwulan
			$this->UpdateSort($this->id_sektor); // id_sektor
			$this->UpdateSort($this->id_subsektor); // id_subsektor
			$this->UpdateSort($this->jumlah_penyerapan); // jumlah_penyerapan
			$this->setStartRecordNumber(1); // Reset start position
		}
	}

	// Load sort order parameters
	function LoadSortOrder() {
		$sOrderBy = $this->getSessionOrderBy(); // Get ORDER BY from Session
		if ($sOrderBy == "") {
			if ($this->getSqlOrderBy() <> "") {
				$sOrderBy = $this->getSqlOrderBy();
				$this->setSessionOrderBy($sOrderBy);
			}
		}
	}

	// Reset command
	// - cmd=reset (Reset search parameters)
	// - cmd=resetall (Reset search and master/detail parameters)
	// - cmd=resetsort (Reset sort parameters)
	function ResetCmd() {

		// Check if reset command
		if (substr($this->Command,0,5) == "reset") {

			// Reset sorting order
			if ($this->Command == "resetsort") {
				$sOrderBy = "";
				$this->setSessionOrderBy($sOrderBy);
				$this->id_penyerapan_tk->setSort("");
				$this->id_triwulan->setSort("");
				$this->id_sektor->setSort("");
				$this->id_subsektor->setSort("");
				$this->jumlah_penyerapan->setSort("");
			}

			// Reset start position
			$this->StartRec = 1;
			$this->setStartRecordNumber($this->StartRec);
		}
	}

	// Set up list options
	function SetupListOptions() {
		global $Security, $Language;

		// Add group option item
		$item = &$this->ListOptions->Add($this->ListOptions->GroupOptionName);
		$item->Body = "";
		$item->OnLeft = FALSE;
		$item->Visible = FALSE;

		// "view"
		$item = &$this->ListOptions->Add("view");
		$item->CssStyle = "white-space: nowrap;";
		$item->Visible = $Security->CanView();
		$item->OnLeft = FALSE;

		// "edit"
		$item = &$this->ListOptions->Add("edit");
		$item->CssStyle = "white-space: nowrap;";
		$item->Visible = $Security->CanEdit();
		$item->OnLeft = FALSE;

		// "copy"
		$item = &$this->ListOptions->Add("copy");
		$item->CssStyle = "white-space: nowrap;";
		$item->Visible = $Security->CanAdd();
		$item->OnLeft = FALSE;

		// "delete"
		$item = &$this->ListOptions->Add("delete");
		$item->CssStyle = "white-space: nowrap;";
		$item->Visible = $Security->CanDelete();
		$item->OnLeft = FALSE;

		// List actions
		$item = &$this->ListOptions->Add("listactions");
		$item->CssStyle = "white-space: nowrap;";
		$item->OnLeft = FALSE;
		$item->Visible = FALSE;
		$item->ShowInButtonGroup = FALSE;
		$item->ShowInDropDown = FALSE;

		// "checkbox"
		$item = &$this->ListOptions->Add("checkbox");
		$item->Visible = FALSE;
		$item->OnLeft = FALSE;
		$item->Header = "<div class=\"checkbox\"><label><input class=\"magic-checkbox\" type=\"checkbox\" name=\"key\" id=\"key\" onclick=\"ew_SelectAllKey(this);\"><span></span></label></div>";
		$item->ShowInDropDown = FALSE;
		$item->ShowInButtonGroup = FALSE;

		// Drop down button for ListOptions
		$this->ListOptions->UseImageAndText = TRUE;
		$this->ListOptions->UseDropDownButton = FALSE;
		$this->ListOptions->DropDownButtonPhrase = $Language->Phrase("ButtonListOptions");
		$this->ListOptions->UseButtonGroup = FALSE;
		if ($this->ListOptions->UseButtonGroup && ew_IsMobile())
			$this->ListOptions->UseDropDownButton = TRUE;
		$this->ListOptions->ButtonClass = "btn-sm"; // Class for button group

		// Call ListOptions_Load event
		$this->ListOptions_Load();
		$this->SetupListOptionsExt();
		$item = &$this->ListOptions->GetItem($this->ListOptions->GroupOptionName);
		$item->Visible = $this->ListOptions->GroupOptionVisible();
	}

	// Render list options
	function RenderListOptions() {
		global $Security, $Language, $objForm;
		$this->ListOptions->LoadDefault();

		// "view"
		$oListOpt = &$this->ListOptions->Items["view"];
		$viewcaption = ew_HtmlTitle($Language->Phrase("ViewLink"));
		if ($Security->CanView()) {
			$oListOpt->Body = "<a class=\"btn btn-info btn-xs\" title=\"" . $viewcaption . "\" data-caption=\"" . $viewcaption . "\" href=\"" . ew_HtmlEncode($this->ViewUrl) . "\">" . $Language->Phrase("ViewLink") ." ". $viewcaption . "</a>";
		} else {
			$oListOpt->Body = "";
		}

		// "edit"
		$oListOpt = &$this->ListOptions->Items["edit"];
		$editcaption = ew_HtmlTitle($Language->Phrase("EditLink"));
		if ($Security->CanEdit()) {
			$oListOpt->Body = "<a class=\"btn btn-warning btn-xs\" title=\"" . ew_HtmlTitle($Language->Phrase("EditLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("EditLink")) . "\" href=\"" . ew_HtmlEncode($this->EditUrl) . "\">" . $Language->Phrase("EditLink") ." ". $editcaption . "</a>";
		} else {
			$oListOpt->Body = "";
		}

		// "copy"
		$oListOpt = &$this->ListOptions->Items["copy"];
		$copycaption = ew_HtmlTitle($Language->Phrase("CopyLink"));
		if ($Security->CanAdd()) {
			$oListOpt->Body = "<a class=\"btn btn-success btn-xs\" title=\"" . $copycaption . "\" data-caption=\"" . $copycaption . "\" href=\"" . ew_HtmlEncode($this->CopyUrl) . "\">" . $Language->Phrase("CopyLink") ." ". $copycaption . "</a>";
		} else {
			$oListOpt->Body = "";
		}

		// "delete"
		$oListOpt = &$this->ListOptions->Items["delete"];
		if ($Security->CanDelete())
			$oListOpt->Body = "<a class=\"btn btn-danger btn-xs\"" . "" . " title=\"" . ew_HtmlTitle($Language->Phrase("DeleteLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("DeleteLink")) . "\" href=\"" . ew_HtmlEncode($this->DeleteUrl) . "\">" . $Language->Phrase("DeleteLink") ." ". ew_HtmlTitle($Language->Phrase("DeleteLink")) . "</a>";
		else
			$oListOpt->Body = "";

		// Set up list action buttons
		$oListOpt = &$this->ListOptions->GetItem("listactions");
		if ($oListOpt && $this->Export == "" && $this->CurrentAction == "") {
			$body = "";
			$links = array();
			foreach ($this->ListActions->Items as $listaction) {
				if ($listaction->Select == EW_ACTION_SINGLE && $listaction->Allow) {
					$action = $listaction->Action;
					$caption = $listaction->Caption;
					$icon = ($listaction->Icon <> "") ? "<span class=\"" . ew_HtmlEncode(str_replace(" ewIcon", "", $listaction->Icon)) . "\" data-caption=\"" . ew_HtmlTitle($caption) . "\"></span> " : "";
					$links[] = "<li><a class=\"ewAction ewListAction\" data-action=\"" . ew_HtmlEncode($action) . "\" data-caption=\"" . ew_HtmlTitle($caption) . "\" href=\"\" onclick=\"ew_SubmitAction(event,jQuery.extend({key:" . $this->KeyToJson() . "}," . $listaction->ToJson(TRUE) . "));return false;\">" . $icon . $listaction->Caption . "</a></li>";
					if (count($links) == 1) // Single button
						$body = "<a class=\"ewAction ewListAction btn btn-xs btn-primary\" data-action=\"" . ew_HtmlEncode($action) . "\" title=\"" . ew_HtmlTitle($caption) . "\" data-caption=\"" . ew_HtmlTitle($caption) . "\" href=\"\" onclick=\"ew_SubmitAction(event,jQuery.extend({key:" . $this->KeyToJson() . "}," . $listaction->ToJson(TRUE) . "));return false;\">" . $Language->Phrase("ListActionButton") . "</a>";
				}
			}
			if (count($links) > 1) { // More than one buttons, use dropdown
				$body = "<button class=\"dropdown-toggle btn btn-default ewActions btn-xs line-2053\" title=\"" . ew_HtmlTitle($Language->Phrase("ListActionButton")) . "\" data-toggle=\"dropdown\">" . $Language->Phrase("ListActionButton") . "<b class=\"caret\"></b></button>";
				$content = "";
				foreach ($links as $link)
					$content .= "<li>" . $link . "</li>";
				$body .= "<ul class=\"dropdown-menu" . ($oListOpt->OnLeft ? "" : " dropdown-menu-right") . "\">". $content . "</ul>";
				$body = "<div class=\"btn-group\">" . $body . "</div>";
			}
			if (count($links) > 0) {
				$oListOpt->Body = $body;
				$oListOpt->Visible = TRUE;
			}
		}

		// "checkbox"
		$oListOpt = &$this->ListOptions->Items["checkbox"];
		$oListOpt->Body = "<label><input class=\"magic-checkbox ewPointer\" type=\"checkbox\" name=\"key_m[]\" value=\"" . ew_HtmlEncode($this->id_penyerapan_tk->CurrentValue) . "\" onclick='ew_ClickMultiCheckbox(event);'><span></span></label>";
		$this->RenderListOptionsExt();

		// Call ListOptions_Rendered event
		$this->ListOptions_Rendered();
	}

	// Set up other options
	function SetupOtherOptions() {
		global $Language, $Security;
		$options = &$this->OtherOptions;
		$option = $options["addedit"];

		// Add
		$item = &$option->Add("add");
		$addcaption = ew_HtmlTitle($Language->Phrase("AddLink"));
		$item->Body = "<a class=\"btn btn-success btn-xs\" title=\"" . $addcaption . "\" data-caption=\"" . $addcaption . "\" href=\"" . ew_HtmlEncode($this->AddUrl) . "\">" . $Language->Phrase("AddLink") . " $addcaption</a>";
		$item->Visible = ($this->AddUrl <> "" && $Security->CanAdd());
		$option = $options["action"];

		// Set up options default
		foreach ($options as &$option) {
			$option->UseImageAndText = TRUE;
			$option->UseDropDownButton = FALSE;
			$option->UseButtonGroup = TRUE;
			$option->ButtonClass = "btn-xs"; // Class for button group
			$item = &$option->Add($option->GroupOptionName);
			$item->Body = "";
			$item->Visible = FALSE;
		}
		$options["addedit"]->DropDownButtonPhrase = $Language->Phrase("ButtonAddEdit");
		$options["detail"]->DropDownButtonPhrase = $Language->Phrase("ButtonDetails");
		$options["action"]->DropDownButtonPhrase = $Language->Phrase("ButtonActions");

		// Filter button
		$item = &$this->FilterOptions->Add("savecurrentfilter");
		$item->Body = "<a class=\"ewSaveFilter\" data-form=\"fpenyerapan_tklistsrch\" href=\"#\">" . $Language->Phrase("SaveCurrentFilter") . "</a>";
		$item->Visible = FALSE;
		$item = &$this->FilterOptions->Add("deletefilter");
		$item->Body = "<a class=\"ewDeleteFilter\" data-form=\"fpenyerapan_tklistsrch\" href=\"#\">" . $Language->Phrase("DeleteFilter") . "</a>";
		$item->Visible = FALSE;
		$this->FilterOptions->UseDropDownButton = TRUE;
		$this->FilterOptions->UseButtonGroup = !$this->FilterOptions->UseDropDownButton;
		$this->FilterOptions->DropDownButtonPhrase = $Language->Phrase("Filters");

		// Add group option item
		$item = &$this->FilterOptions->Add($this->FilterOptions->GroupOptionName);
		$item->Body = "";
		$item->Visible = FALSE;
	}

	// Render other options
	function RenderOtherOptions() {
		global $Language, $Security;
		$options = &$this->OtherOptions;
			$option = &$options["action"];

			// Set up list action buttons
			foreach ($this->ListActions->Items as $listaction) {
				if ($listaction->Select == EW_ACTION_MULTIPLE) {
					$item = &$option->Add("custom_" . $listaction->Action);
					$caption = $listaction->Caption;
					$icon = ($listaction->Icon <> "") ? "<span class=\"" . ew_HtmlEncode($listaction->Icon) . "\" data-caption=\"" . ew_HtmlEncode($caption) . "\"></span> " : $caption;
					$item->Body = "<a class=\"btn btn-xs btn-default line-2540\" title=\"" . ew_HtmlEncode($caption) . "\" data-caption=\"" . ew_HtmlEncode($caption) . "\" href=\"\" onclick=\"ew_SubmitAction(event,jQuery.extend({f:document.fpenyerapan_tklist}," . $listaction->ToJson(TRUE) . "));return false;\">" . $icon . "</a>";
					$item->Visible = $listaction->Allow;
				}
			}

			// Hide grid edit and other options
			if ($this->TotalRecs <= 0) {
				$option = &$options["addedit"];
				$item = &$option->GetItem("gridedit");
				if ($item) $item->Visible = FALSE;
				$option = &$options["action"];
				$option->HideAllOptions();
			}
	}

	// Process list action
	function ProcessListAction() {
		global $Language, $Security;
		$userlist = "";
		$user = "";
		$sFilter = $this->GetKeyFilter();
		$UserAction = @$_POST["useraction"];
		if ($sFilter <> "" && $UserAction <> "") {

			// Check permission first
			$ActionCaption = $UserAction;
			if (array_key_exists($UserAction, $this->ListActions->Items)) {
				$ActionCaption = $this->ListActions->Items[$UserAction]->Caption;
				if (!$this->ListActions->Items[$UserAction]->Allow) {
					$errmsg = str_replace('%s', $ActionCaption, $Language->Phrase("CustomActionNotAllowed"));
					if (@$_POST["ajax"] == $UserAction) // Ajax
						echo "<p class=\"text-danger\">" . $errmsg . "</p>";
					else
						$this->setFailureMessage($errmsg);
					return FALSE;
				}
			}
			$this->CurrentFilter = $sFilter;
			$sSql = $this->SQL();
			$conn = &$this->Connection();
			$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
			$rs = $conn->Execute($sSql);
			$conn->raiseErrorFn = '';
			$this->CurrentAction = $UserAction;

			// Call row action event
			if ($rs && !$rs->EOF) {
				$conn->BeginTrans();
				$this->SelectedCount = $rs->RecordCount();
				$this->SelectedIndex = 0;
				while (!$rs->EOF) {
					$this->SelectedIndex++;
					$row = $rs->fields;
					$Processed = $this->Row_CustomAction($UserAction, $row);
					if (!$Processed) break;
					$rs->MoveNext();
				}
				if ($Processed) {
					$conn->CommitTrans(); // Commit the changes
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage(str_replace('%s', $ActionCaption, $Language->Phrase("CustomActionCompleted"))); // Set up success message
				} else {
					$conn->RollbackTrans(); // Rollback changes

					// Set up error message
					if ($this->getSuccessMessage() <> "" || $this->getFailureMessage() <> "") {

						// Use the message, do nothing
					} elseif ($this->CancelMessage <> "") {
						$this->setFailureMessage($this->CancelMessage);
						$this->CancelMessage = "";
					} else {
						$this->setFailureMessage(str_replace('%s', $ActionCaption, $Language->Phrase("CustomActionFailed")));
					}
				}
			}
			if ($rs)
				$rs->Close();
			$this->CurrentAction = ""; // Clear action
			if (@$_POST["ajax"] == $UserAction) { // Ajax
				if ($this->getSuccessMessage() <> "") {
					echo "<p class=\"text-success\">" . $this->getSuccessMessage() . "</p>";
					$this->ClearSuccessMessage(); // Clear message
				}
				if ($this->getFailureMessage() <> "") {
					echo "<p class=\"text-danger\">" . $this->getFailureMessage() . "</p>";
					$this->ClearFailureMessage(); // Clear message
				}
				return TRUE;
			}
		}
		return FALSE; // Not ajax request
	}

	// Set up search options
	function SetupSearchOptions() {
		global $Language;
		$this->SearchOptions = new cListOptions();
		$this->SearchOptions->Tag = "div";
		$this->SearchOptions->TagClassName = "ewSearchOption";

		// Button group for search
		$this->SearchOptions->UseDropDownButton = FALSE;
		$this->SearchOptions->UseImageAndText = TRUE;
		$this->SearchOptions->UseButtonGroup = TRUE;
		$this->SearchOptions->DropDownButtonPhrase = $Language->Phrase("ButtonSearch");

		// Add group option item
		$item = &$this->SearchOptions->Add($this->SearchOptions->GroupOptionName);
		$item->Body = "";
		$item->Visible = FALSE;

		// Hide search options
		if ($this->Export <> "" || $this->CurrentAction <> "")
			$this->SearchOptions->HideAllOptions();
		global $Security;
		if (!$Security->CanSearch()) {
			$this->SearchOptions->HideAllOptions();
			$this->FilterOptions->HideAllOptions();
		}
	}

	function SetupListOptionsExt() {
		global $Security, $Language;
	}

	function RenderListOptionsExt() {
		global $Security, $Language;
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
		$this->ViewUrl = $this->GetViewUrl();
		$this->EditUrl = $this->GetEditUrl();
		$this->InlineEditUrl = $this->GetInlineEditUrl();
		$this->CopyUrl = $this->GetCopyUrl();
		$this->InlineCopyUrl = $this->GetInlineCopyUrl();
		$this->DeleteUrl = $this->GetDeleteUrl();

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

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$url = preg_replace('/\?cmd=reset(all){0,1}$/i', '', $url); // Remove cmd=reset / cmd=resetall
		$Breadcrumb->Add("list", $this->TableVar, $url, "", $this->TableVar, TRUE);
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

	// Form Custom Validate event
	function Form_CustomValidate(&$CustomError) {

		// Return error message in CustomError
		return TRUE;
	}

	// ListOptions Load event
	function ListOptions_Load() {

		// Example:
		//$opt = &$this->ListOptions->Add("new");
		//$opt->Header = "xxx";
		//$opt->OnLeft = TRUE; // Link on left
		//$opt->MoveTo(0); // Move to first column

	}

	// ListOptions Rendered event
	function ListOptions_Rendered() {

		// Example: 
		//$this->ListOptions->Items["new"]->Body = "xxx";

	}

	// Row Custom Action event
	function Row_CustomAction($action, $row) {

		// Return FALSE to abort
		return TRUE;
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
if (!isset($penyerapan_tk_list)) $penyerapan_tk_list = new cpenyerapan_tk_list();

// Page init
$penyerapan_tk_list->Page_Init();

// Page main
$penyerapan_tk_list->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$penyerapan_tk_list->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "list";
var CurrentForm = fpenyerapan_tklist = new ew_Form("fpenyerapan_tklist", "list");
fpenyerapan_tklist.FormKeyCountName = '<?php echo $penyerapan_tk_list->FormKeyCountName ?>';

// Form_CustomValidate event
fpenyerapan_tklist.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fpenyerapan_tklist.ValidateRequired = true;
<?php } else { ?>
fpenyerapan_tklist.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fpenyerapan_tklist.Lists["x_id_triwulan"] = {"LinkField":"x_ID_triwulan","Ajax":true,"AutoFill":false,"DisplayFields":["x_triwulan","x_tahun","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"triwulan"};
fpenyerapan_tklist.Lists["x_id_sektor"] = {"LinkField":"x_id_sektor","Ajax":true,"AutoFill":false,"DisplayFields":["x_sektor","","",""],"ParentFields":[],"ChildFields":["x_id_subsektor"],"FilterFields":[],"Options":[],"Template":"","LinkTable":"sektor"};
fpenyerapan_tklist.Lists["x_id_subsektor"] = {"LinkField":"x_id_subsektor","Ajax":true,"AutoFill":false,"DisplayFields":["x_subsektor","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"subsektor"};

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php if ($penyerapan_tk_list->TotalRecs > 0 && $penyerapan_tk_list->ExportOptions->Visible()) { ?>
<?php $penyerapan_tk_list->ExportOptions->Render("body") ?>
<?php } ?>
<div class="clearfix"></div>
<?php
	$bSelectLimit = $penyerapan_tk_list->UseSelectLimit;
	if ($bSelectLimit) {
		if ($penyerapan_tk_list->TotalRecs <= 0)
			$penyerapan_tk_list->TotalRecs = $penyerapan_tk->SelectRecordCount();
	} else {
		if (!$penyerapan_tk_list->Recordset && ($penyerapan_tk_list->Recordset = $penyerapan_tk_list->LoadRecordset()))
			$penyerapan_tk_list->TotalRecs = $penyerapan_tk_list->Recordset->RecordCount();
	}
	$penyerapan_tk_list->StartRec = 1;
	if ($penyerapan_tk_list->DisplayRecs <= 0 || ($penyerapan_tk->Export <> "" && $penyerapan_tk->ExportAll)) // Display all records
		$penyerapan_tk_list->DisplayRecs = $penyerapan_tk_list->TotalRecs;
	if (!($penyerapan_tk->Export <> "" && $penyerapan_tk->ExportAll))
		$penyerapan_tk_list->SetUpStartRec(); // Set up start record position
	if ($bSelectLimit)
		$penyerapan_tk_list->Recordset = $penyerapan_tk_list->LoadRecordset($penyerapan_tk_list->StartRec-1, $penyerapan_tk_list->DisplayRecs);

	// Set no record found message
	if ($penyerapan_tk->CurrentAction == "" && $penyerapan_tk_list->TotalRecs == 0) {
		if (!$Security->CanList())
			$penyerapan_tk_list->setWarningMessage(ew_DeniedMsg());
		if ($penyerapan_tk_list->SearchWhere == "0=101")
			$penyerapan_tk_list->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$penyerapan_tk_list->setWarningMessage($Language->Phrase("NoRecord"));
	}
$penyerapan_tk_list->RenderOtherOptions();
?>
<?php $penyerapan_tk_list->ShowPageHeader(); ?>
<?php
$penyerapan_tk_list->ShowMessage();
?>
<?php if ($penyerapan_tk_list->TotalRecs > 0 || $penyerapan_tk->CurrentAction <> "") { ?>
<div class="panel panel-default ewGrid penyerapan_tk">
<form name="fpenyerapan_tklist" id="fpenyerapan_tklist" class="form-inline ewForm ewListForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($penyerapan_tk_list->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $penyerapan_tk_list->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="penyerapan_tk">
<div id="gmp_penyerapan_tk" class="table-responsive box box-primary ewGridMiddlePanel">
<?php if ($penyerapan_tk_list->TotalRecs > 0 || $penyerapan_tk->CurrentAction == "gridedit") { ?>
<table id="tbl_penyerapan_tklist" class="table ewTable table-bordered table-striped table-condensed table-hover">
<?php echo $penyerapan_tk->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Header row
$penyerapan_tk_list->RowType = EW_ROWTYPE_HEADER;

// Render list options
$penyerapan_tk_list->RenderListOptions();

// Render list options (header, left)
$penyerapan_tk_list->ListOptions->Render("header", "left");
?>
<?php if ($penyerapan_tk->id_penyerapan_tk->Visible) { // id_penyerapan_tk ?>
	<?php if ($penyerapan_tk->SortUrl($penyerapan_tk->id_penyerapan_tk) == "") { ?>
		<th data-name="id_penyerapan_tk"><div id="elh_penyerapan_tk_id_penyerapan_tk" class="penyerapan_tk_id_penyerapan_tk"><div class="ewTableHeaderCaption"><?php echo $penyerapan_tk->id_penyerapan_tk->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="id_penyerapan_tk"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $penyerapan_tk->SortUrl($penyerapan_tk->id_penyerapan_tk) ?>',1);"><div id="elh_penyerapan_tk_id_penyerapan_tk" class="penyerapan_tk_id_penyerapan_tk">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $penyerapan_tk->id_penyerapan_tk->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($penyerapan_tk->id_penyerapan_tk->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($penyerapan_tk->id_penyerapan_tk->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($penyerapan_tk->id_triwulan->Visible) { // id_triwulan ?>
	<?php if ($penyerapan_tk->SortUrl($penyerapan_tk->id_triwulan) == "") { ?>
		<th data-name="id_triwulan"><div id="elh_penyerapan_tk_id_triwulan" class="penyerapan_tk_id_triwulan"><div class="ewTableHeaderCaption"><?php echo $penyerapan_tk->id_triwulan->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="id_triwulan"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $penyerapan_tk->SortUrl($penyerapan_tk->id_triwulan) ?>',1);"><div id="elh_penyerapan_tk_id_triwulan" class="penyerapan_tk_id_triwulan">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $penyerapan_tk->id_triwulan->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($penyerapan_tk->id_triwulan->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($penyerapan_tk->id_triwulan->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($penyerapan_tk->id_sektor->Visible) { // id_sektor ?>
	<?php if ($penyerapan_tk->SortUrl($penyerapan_tk->id_sektor) == "") { ?>
		<th data-name="id_sektor"><div id="elh_penyerapan_tk_id_sektor" class="penyerapan_tk_id_sektor"><div class="ewTableHeaderCaption"><?php echo $penyerapan_tk->id_sektor->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="id_sektor"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $penyerapan_tk->SortUrl($penyerapan_tk->id_sektor) ?>',1);"><div id="elh_penyerapan_tk_id_sektor" class="penyerapan_tk_id_sektor">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $penyerapan_tk->id_sektor->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($penyerapan_tk->id_sektor->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($penyerapan_tk->id_sektor->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($penyerapan_tk->id_subsektor->Visible) { // id_subsektor ?>
	<?php if ($penyerapan_tk->SortUrl($penyerapan_tk->id_subsektor) == "") { ?>
		<th data-name="id_subsektor"><div id="elh_penyerapan_tk_id_subsektor" class="penyerapan_tk_id_subsektor"><div class="ewTableHeaderCaption"><?php echo $penyerapan_tk->id_subsektor->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="id_subsektor"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $penyerapan_tk->SortUrl($penyerapan_tk->id_subsektor) ?>',1);"><div id="elh_penyerapan_tk_id_subsektor" class="penyerapan_tk_id_subsektor">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $penyerapan_tk->id_subsektor->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($penyerapan_tk->id_subsektor->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($penyerapan_tk->id_subsektor->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($penyerapan_tk->jumlah_penyerapan->Visible) { // jumlah_penyerapan ?>
	<?php if ($penyerapan_tk->SortUrl($penyerapan_tk->jumlah_penyerapan) == "") { ?>
		<th data-name="jumlah_penyerapan"><div id="elh_penyerapan_tk_jumlah_penyerapan" class="penyerapan_tk_jumlah_penyerapan"><div class="ewTableHeaderCaption"><?php echo $penyerapan_tk->jumlah_penyerapan->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="jumlah_penyerapan"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $penyerapan_tk->SortUrl($penyerapan_tk->jumlah_penyerapan) ?>',1);"><div id="elh_penyerapan_tk_jumlah_penyerapan" class="penyerapan_tk_jumlah_penyerapan">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $penyerapan_tk->jumlah_penyerapan->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($penyerapan_tk->jumlah_penyerapan->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($penyerapan_tk->jumlah_penyerapan->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$penyerapan_tk_list->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
if ($penyerapan_tk->ExportAll && $penyerapan_tk->Export <> "") {
	$penyerapan_tk_list->StopRec = $penyerapan_tk_list->TotalRecs;
} else {

	// Set the last record to display
	if ($penyerapan_tk_list->TotalRecs > $penyerapan_tk_list->StartRec + $penyerapan_tk_list->DisplayRecs - 1)
		$penyerapan_tk_list->StopRec = $penyerapan_tk_list->StartRec + $penyerapan_tk_list->DisplayRecs - 1;
	else
		$penyerapan_tk_list->StopRec = $penyerapan_tk_list->TotalRecs;
}
$penyerapan_tk_list->RecCnt = $penyerapan_tk_list->StartRec - 1;
if ($penyerapan_tk_list->Recordset && !$penyerapan_tk_list->Recordset->EOF) {
	$penyerapan_tk_list->Recordset->MoveFirst();
	$bSelectLimit = $penyerapan_tk_list->UseSelectLimit;
	if (!$bSelectLimit && $penyerapan_tk_list->StartRec > 1)
		$penyerapan_tk_list->Recordset->Move($penyerapan_tk_list->StartRec - 1);
} elseif (!$penyerapan_tk->AllowAddDeleteRow && $penyerapan_tk_list->StopRec == 0) {
	$penyerapan_tk_list->StopRec = $penyerapan_tk->GridAddRowCount;
}

// Initialize aggregate
$penyerapan_tk->RowType = EW_ROWTYPE_AGGREGATEINIT;
$penyerapan_tk->ResetAttrs();
$penyerapan_tk_list->RenderRow();
while ($penyerapan_tk_list->RecCnt < $penyerapan_tk_list->StopRec) {
	$penyerapan_tk_list->RecCnt++;
	if (intval($penyerapan_tk_list->RecCnt) >= intval($penyerapan_tk_list->StartRec)) {
		$penyerapan_tk_list->RowCnt++;

		// Set up key count
		$penyerapan_tk_list->KeyCount = $penyerapan_tk_list->RowIndex;

		// Init row class and style
		$penyerapan_tk->ResetAttrs();
		$penyerapan_tk->CssClass = "";
		if ($penyerapan_tk->CurrentAction == "gridadd") {
		} else {
			$penyerapan_tk_list->LoadRowValues($penyerapan_tk_list->Recordset); // Load row values
		}
		$penyerapan_tk->RowType = EW_ROWTYPE_VIEW; // Render view

		// Set up row id / data-rowindex
		$penyerapan_tk->RowAttrs = array_merge($penyerapan_tk->RowAttrs, array('data-rowindex'=>$penyerapan_tk_list->RowCnt, 'id'=>'r' . $penyerapan_tk_list->RowCnt . '_penyerapan_tk', 'data-rowtype'=>$penyerapan_tk->RowType));

		// Render row
		$penyerapan_tk_list->RenderRow();

		// Render list options
		$penyerapan_tk_list->RenderListOptions();
?>
	<tr<?php echo $penyerapan_tk->RowAttributes() ?>>
<?php

// Render list options (body, left)
$penyerapan_tk_list->ListOptions->Render("body", "left", $penyerapan_tk_list->RowCnt);
?>
	<?php if ($penyerapan_tk->id_penyerapan_tk->Visible) { // id_penyerapan_tk ?>
		<td data-name="id_penyerapan_tk"<?php echo $penyerapan_tk->id_penyerapan_tk->CellAttributes() ?>>
<span id="el<?php echo $penyerapan_tk_list->RowCnt ?>_penyerapan_tk_id_penyerapan_tk" class="penyerapan_tk_id_penyerapan_tk">
<span<?php echo $penyerapan_tk->id_penyerapan_tk->ViewAttributes() ?>>
<?php echo $penyerapan_tk->id_penyerapan_tk->ListViewValue() ?></span>
</span>
<a id="<?php echo $penyerapan_tk_list->PageObjName . "_row_" . $penyerapan_tk_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($penyerapan_tk->id_triwulan->Visible) { // id_triwulan ?>
		<td data-name="id_triwulan"<?php echo $penyerapan_tk->id_triwulan->CellAttributes() ?>>
<span id="el<?php echo $penyerapan_tk_list->RowCnt ?>_penyerapan_tk_id_triwulan" class="penyerapan_tk_id_triwulan">
<span<?php echo $penyerapan_tk->id_triwulan->ViewAttributes() ?>>
<?php echo $penyerapan_tk->id_triwulan->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($penyerapan_tk->id_sektor->Visible) { // id_sektor ?>
		<td data-name="id_sektor"<?php echo $penyerapan_tk->id_sektor->CellAttributes() ?>>
<span id="el<?php echo $penyerapan_tk_list->RowCnt ?>_penyerapan_tk_id_sektor" class="penyerapan_tk_id_sektor">
<span<?php echo $penyerapan_tk->id_sektor->ViewAttributes() ?>>
<?php echo $penyerapan_tk->id_sektor->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($penyerapan_tk->id_subsektor->Visible) { // id_subsektor ?>
		<td data-name="id_subsektor"<?php echo $penyerapan_tk->id_subsektor->CellAttributes() ?>>
<span id="el<?php echo $penyerapan_tk_list->RowCnt ?>_penyerapan_tk_id_subsektor" class="penyerapan_tk_id_subsektor">
<span<?php echo $penyerapan_tk->id_subsektor->ViewAttributes() ?>>
<?php echo $penyerapan_tk->id_subsektor->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($penyerapan_tk->jumlah_penyerapan->Visible) { // jumlah_penyerapan ?>
		<td data-name="jumlah_penyerapan"<?php echo $penyerapan_tk->jumlah_penyerapan->CellAttributes() ?>>
<span id="el<?php echo $penyerapan_tk_list->RowCnt ?>_penyerapan_tk_jumlah_penyerapan" class="penyerapan_tk_jumlah_penyerapan">
<span<?php echo $penyerapan_tk->jumlah_penyerapan->ViewAttributes() ?>>
<?php echo $penyerapan_tk->jumlah_penyerapan->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$penyerapan_tk_list->ListOptions->Render("body", "right", $penyerapan_tk_list->RowCnt);
?>
	</tr>
<?php
	}
	if ($penyerapan_tk->CurrentAction <> "gridadd")
		$penyerapan_tk_list->Recordset->MoveNext();
}
?>
</tbody>
</table>
<?php } ?>
<?php if ($penyerapan_tk->CurrentAction == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
</div>
</form>
<?php

// Close recordset
if ($penyerapan_tk_list->Recordset)
	$penyerapan_tk_list->Recordset->Close();
?>
<div class="panel-footer ewGridLowerPanel">
<?php if ($penyerapan_tk->CurrentAction <> "gridadd" && $penyerapan_tk->CurrentAction <> "gridedit") { ?>
<form name="ewPagerForm" class="ewForm form-inline ewPagerForm" action="<?php echo ew_CurrentPage() ?>">
<?php if (!isset($penyerapan_tk_list->Pager)) $penyerapan_tk_list->Pager = new cPrevNextPager($penyerapan_tk_list->StartRec, $penyerapan_tk_list->DisplayRecs, $penyerapan_tk_list->TotalRecs) ?>
<?php if ($penyerapan_tk_list->Pager->RecordCount > 0 && $penyerapan_tk_list->Pager->Visible) { ?>
<div class="text-center">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ewPrevNext"><div class="input-group">
<div class="input-group-btn">
<!--first page button-->
	<?php if ($penyerapan_tk_list->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $penyerapan_tk_list->PageUrl() ?>start=<?php echo $penyerapan_tk_list->Pager->FirstButton->Start ?>"><span class="fa fa-fast-backward"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="fa fa-fast-backward"></span></a>
	<?php } ?>
<!--previous page button-->
	<?php if ($penyerapan_tk_list->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $penyerapan_tk_list->PageUrl() ?>start=<?php echo $penyerapan_tk_list->Pager->PrevButton->Start ?>"><span class="fa fa-step-backward"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerPrevious") ?>"><span class="fa fa-step-backward"></span></a>
	<?php } ?>
</div>
<!--current page number-->
	<input class="form-control input-sm" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $penyerapan_tk_list->Pager->CurrentPage ?>">
<div class="input-group-btn">
<!--next page button-->
	<?php if ($penyerapan_tk_list->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $penyerapan_tk_list->PageUrl() ?>start=<?php echo $penyerapan_tk_list->Pager->NextButton->Start ?>"><span class="fa fa-step-forward"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="fa fa-step-forward"></span></a>
	<?php } ?>
<!--last page button-->
	<?php if ($penyerapan_tk_list->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $penyerapan_tk_list->PageUrl() ?>start=<?php echo $penyerapan_tk_list->Pager->LastButton->Start ?>"><span class="fa fa-fast-forward"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerLast") ?>"><span class="fa fa-fast-forward"></span></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $penyerapan_tk_list->Pager->PageCount ?></span>
</div>
<div class="text-center">
	<span><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $penyerapan_tk_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $penyerapan_tk_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $penyerapan_tk_list->Pager->RecordCount ?></span>
</div>
<?php } ?>
</form>
<?php } ?>
<div class="ewListOtherOptions">
<?php
	foreach ($penyerapan_tk_list->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
</div>
</div>
<?php } ?>
<?php if ($penyerapan_tk_list->TotalRecs == 0 && $penyerapan_tk->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($penyerapan_tk_list->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<script type="text/javascript">
fpenyerapan_tklist.Init();
</script>
<?php
$penyerapan_tk_list->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$penyerapan_tk_list->Page_Terminate();
?>
