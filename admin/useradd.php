<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "userinfo.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$user_add = NULL; // Initialize page object first

class cuser_add extends cuser {

	// Page ID
	var $PageID = 'add';

	// Project ID
	var $ProjectID = "{711D4B7A-499A-4AB9-B89B-D8472076C077}";

	// Table name
	var $TableName = 'user';

	// Page object name
	var $PageObjName = 'user_add';

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

		// Table object (user)
		if (!isset($GLOBALS["user"]) || get_class($GLOBALS["user"]) == "cuser") {
			$GLOBALS["user"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["user"];
		}

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'add', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'user', TRUE);

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
				$this->Page_Terminate(ew_GetUrl("userlist.php"));
			else
				$this->Page_Terminate(ew_GetUrl("login.php"));
		}
		if ($Security->IsLoggedIn()) {
			$Security->UserID_Loading();
			$Security->LoadUserID();
			$Security->UserID_Loaded();
			if (strval($Security->CurrentUserID()) == "") {
				$this->setFailureMessage(ew_DeniedMsg()); // Set no permission
				$this->Page_Terminate(ew_GetUrl("userlist.php"));
			}
		}

		// Create form object
		$objForm = new cFormObj();
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action
		$this->username->SetVisibility();
		$this->password->SetVisibility();
		$this->_email->SetVisibility();
		$this->userlevel->SetVisibility();

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
		global $EW_EXPORT, $user;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($user);
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
			if (@$_GET["id_user"] != "") {
				$this->id_user->setQueryStringValue($_GET["id_user"]);
				$this->setKey("id_user", $this->id_user->CurrentValue); // Set up key
			} else {
				$this->setKey("id_user", ""); // Clear key
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
					$this->Page_Terminate("userlist.php"); // No matching record, return to list
				}
				break;
			case "A": // Add new record
				$this->SendEmail = TRUE; // Send email on add success
				if ($this->AddRow($this->OldRecordset)) { // Add successful
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("AddSuccess")); // Set up success message
					$sReturnUrl = $this->getReturnUrl();
					if (ew_GetPageName($sReturnUrl) == "userlist.php")
						$sReturnUrl = $this->AddMasterUrl($sReturnUrl); // List page, return to list page with correct master key if necessary
					elseif (ew_GetPageName($sReturnUrl) == "userview.php")
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
		$this->username->CurrentValue = NULL;
		$this->username->OldValue = $this->username->CurrentValue;
		$this->password->CurrentValue = NULL;
		$this->password->OldValue = $this->password->CurrentValue;
		$this->_email->CurrentValue = NULL;
		$this->_email->OldValue = $this->_email->CurrentValue;
		$this->userlevel->CurrentValue = NULL;
		$this->userlevel->OldValue = $this->userlevel->CurrentValue;
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->username->FldIsDetailKey) {
			$this->username->setFormValue($objForm->GetValue("x_username"));
		}
		if (!$this->password->FldIsDetailKey) {
			$this->password->setFormValue($objForm->GetValue("x_password"));
		}
		if (!$this->_email->FldIsDetailKey) {
			$this->_email->setFormValue($objForm->GetValue("x__email"));
		}
		if (!$this->userlevel->FldIsDetailKey) {
			$this->userlevel->setFormValue($objForm->GetValue("x_userlevel"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadOldRecord();
		$this->username->CurrentValue = $this->username->FormValue;
		$this->password->CurrentValue = $this->password->FormValue;
		$this->_email->CurrentValue = $this->_email->FormValue;
		$this->userlevel->CurrentValue = $this->userlevel->FormValue;
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

		// Check if valid user id
		if ($res) {
			$res = $this->ShowOptionLink('add');
			if (!$res) {
				$sUserIdMsg = ew_DeniedMsg();
				$this->setFailureMessage($sUserIdMsg);
			}
		}
		return $res;
	}

	// Load row values from recordset
	function LoadRowValues(&$rs) {
		if (!$rs || $rs->EOF) return;

		// Call Row Selected event
		$row = &$rs->fields;
		$this->Row_Selected($row);
		$this->id_user->setDbValue($rs->fields('id_user'));
		$this->username->setDbValue($rs->fields('username'));
		$this->password->setDbValue($rs->fields('password'));
		$this->_email->setDbValue($rs->fields('email'));
		$this->userlevel->setDbValue($rs->fields('userlevel'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->id_user->DbValue = $row['id_user'];
		$this->username->DbValue = $row['username'];
		$this->password->DbValue = $row['password'];
		$this->_email->DbValue = $row['email'];
		$this->userlevel->DbValue = $row['userlevel'];
	}

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($this->getKey("id_user")) <> "")
			$this->id_user->CurrentValue = $this->getKey("id_user"); // id_user
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
		// id_user
		// username
		// password
		// email
		// userlevel

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// id_user
		$this->id_user->ViewValue = $this->id_user->CurrentValue;
		$this->id_user->ViewCustomAttributes = "";

		// username
		$this->username->ViewValue = $this->username->CurrentValue;
		$this->username->ViewCustomAttributes = "";

		// password
		$this->password->ViewValue = $this->password->CurrentValue;
		$this->password->ViewCustomAttributes = "";

		// email
		$this->_email->ViewValue = $this->_email->CurrentValue;
		$this->_email->ViewCustomAttributes = "";

		// userlevel
		if ($Security->CanAdmin()) { // System admin
		if (strval($this->userlevel->CurrentValue) <> "") {
			$sFilterWrk = "`userlevelid`" . ew_SearchString("=", $this->userlevel->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `userlevelid`, `userlevelname` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `userlevels`";
		$sWhereWrk = "";
		$this->userlevel->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->userlevel, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->userlevel->ViewValue = $this->userlevel->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->userlevel->ViewValue = $this->userlevel->CurrentValue;
			}
		} else {
			$this->userlevel->ViewValue = NULL;
		}
		} else {
			$this->userlevel->ViewValue = $Language->Phrase("PasswordMask");
		}
		$this->userlevel->ViewCustomAttributes = "";

			// username
			$this->username->LinkCustomAttributes = "";
			$this->username->HrefValue = "";
			$this->username->TooltipValue = "";

			// password
			$this->password->LinkCustomAttributes = "";
			$this->password->HrefValue = "";
			$this->password->TooltipValue = "";

			// email
			$this->_email->LinkCustomAttributes = "";
			$this->_email->HrefValue = "";
			$this->_email->TooltipValue = "";

			// userlevel
			$this->userlevel->LinkCustomAttributes = "";
			$this->userlevel->HrefValue = "";
			$this->userlevel->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// username
			$this->username->EditAttrs["class"] = "form-control";
			$this->username->EditCustomAttributes = "";
			$this->username->EditValue = ew_HtmlEncode($this->username->CurrentValue);
			$this->username->PlaceHolder = ew_RemoveHtml($this->username->FldCaption());

			// password
			$this->password->EditAttrs["class"] = "form-control ewPasswordStrength";
			$this->password->EditCustomAttributes = "";
			$this->password->EditValue = ew_HtmlEncode($this->password->CurrentValue);
			$this->password->PlaceHolder = ew_RemoveHtml($this->password->FldCaption());

			// email
			$this->_email->EditAttrs["class"] = "form-control";
			$this->_email->EditCustomAttributes = "";
			$this->_email->EditValue = ew_HtmlEncode($this->_email->CurrentValue);
			$this->_email->PlaceHolder = ew_RemoveHtml($this->_email->FldCaption());

			// userlevel
			$this->userlevel->EditAttrs["class"] = "form-control";
			$this->userlevel->EditCustomAttributes = "";
			if (!$Security->CanAdmin()) { // System admin
				$this->userlevel->EditValue = $Language->Phrase("PasswordMask");
			} else {
			if (trim(strval($this->userlevel->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`userlevelid`" . ew_SearchString("=", $this->userlevel->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `userlevelid`, `userlevelname` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `userlevels`";
			$sWhereWrk = "";
			$this->userlevel->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->userlevel, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->userlevel->EditValue = $arwrk;
			}

			// Add refer script
			// username

			$this->username->LinkCustomAttributes = "";
			$this->username->HrefValue = "";

			// password
			$this->password->LinkCustomAttributes = "";
			$this->password->HrefValue = "";

			// email
			$this->_email->LinkCustomAttributes = "";
			$this->_email->HrefValue = "";

			// userlevel
			$this->userlevel->LinkCustomAttributes = "";
			$this->userlevel->HrefValue = "";
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
		if (!$this->username->FldIsDetailKey && !is_null($this->username->FormValue) && $this->username->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->username->FldCaption(), $this->username->ReqErrMsg));
		}
		if (!$this->password->FldIsDetailKey && !is_null($this->password->FormValue) && $this->password->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->password->FldCaption(), $this->password->ReqErrMsg));
		}
		if (!$this->_email->FldIsDetailKey && !is_null($this->_email->FormValue) && $this->_email->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->_email->FldCaption(), $this->_email->ReqErrMsg));
		}
		if (!$this->userlevel->FldIsDetailKey && !is_null($this->userlevel->FormValue) && $this->userlevel->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->userlevel->FldCaption(), $this->userlevel->ReqErrMsg));
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

		// Check if valid User ID
		$bValidUser = FALSE;
		if ($Security->CurrentUserID() <> "" && !ew_Empty($this->id_user->CurrentValue) && !$Security->IsAdmin()) { // Non system admin
			$bValidUser = $Security->IsValidUserID($this->id_user->CurrentValue);
			if (!$bValidUser) {
				$sUserIdMsg = str_replace("%c", CurrentUserID(), $Language->Phrase("UnAuthorizedUserID"));
				$sUserIdMsg = str_replace("%u", $this->id_user->CurrentValue, $sUserIdMsg);
				$this->setFailureMessage($sUserIdMsg);
				return FALSE;
			}
		}
		$conn = &$this->Connection();

		// Load db values from rsold
		if ($rsold) {
			$this->LoadDbValues($rsold);
		}
		$rsnew = array();

		// username
		$this->username->SetDbValueDef($rsnew, $this->username->CurrentValue, "", FALSE);

		// password
		$this->password->SetDbValueDef($rsnew, $this->password->CurrentValue, "", FALSE);

		// email
		$this->_email->SetDbValueDef($rsnew, $this->_email->CurrentValue, "", FALSE);

		// userlevel
		if ($Security->CanAdmin()) { // System admin
		$this->userlevel->SetDbValueDef($rsnew, $this->userlevel->CurrentValue, 0, FALSE);
		}

		// id_user
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

	// Show link optionally based on User ID
	function ShowOptionLink($id = "") {
		global $Security;
		if ($Security->IsLoggedIn() && !$Security->IsAdmin() && !$this->UserIDAllow($id))
			return $Security->IsValidUserID($this->id_user->CurrentValue);
		return TRUE;
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("userlist.php"), "", $this->TableVar, TRUE);
		$PageId = ($this->CurrentAction == "C") ? "Copy" : "Add";
		$Breadcrumb->Add("add", $PageId, $url);
	}

	// Setup lookup filters of a field
	function SetupLookupFilters($fld, $pageId = null) {
		global $gsLanguage;
		$pageId = $pageId ?: $this->PageID;
		switch ($fld->FldVar) {
		case "x_userlevel":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `userlevelid` AS `LinkFld`, `userlevelname` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `userlevels`";
			$sWhereWrk = "";
			$this->userlevel->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => '`userlevelid` = {filter_value}', "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->userlevel, $sWhereWrk); // Call Lookup selecting
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
if (!isset($user_add)) $user_add = new cuser_add();

// Page init
$user_add->Page_Init();

// Page main
$user_add->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$user_add->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "add";
var CurrentForm = fuseradd = new ew_Form("fuseradd", "add");

// Validate form
fuseradd.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_username");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $user->username->FldCaption(), $user->username->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_password");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $user->password->FldCaption(), $user->password->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_password");
			if (elm && $(elm).hasClass("ewPasswordStrength") && !$(elm).data("validated"))
				return this.OnError(elm, ewLanguage.Phrase("PasswordTooSimple"));
			elm = this.GetElements("x" + infix + "__email");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $user->_email->FldCaption(), $user->_email->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_userlevel");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $user->userlevel->FldCaption(), $user->userlevel->ReqErrMsg)) ?>");

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
fuseradd.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fuseradd.ValidateRequired = true;
<?php } else { ?>
fuseradd.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fuseradd.Lists["x_userlevel"] = {"LinkField":"x_userlevelid","Ajax":true,"AutoFill":false,"DisplayFields":["x_userlevelname","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"userlevels"};

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php if (!$user_add->IsModal) { ?>
<?php } ?>
<?php $user_add->ShowPageHeader(); ?>
<?php
$user_add->ShowMessage();
?>
<form name="fuseradd" id="fuseradd" class="<?php echo $user_add->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($user_add->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $user_add->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="user">
<input type="hidden" name="a_add" id="a_add" value="A">
<?php if ($user_add->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<!-- Fields to prevent google autofill -->
<input class="hidden" type="text" name="<?php echo ew_Encrypt(ew_Random()) ?>">
<input class="hidden" type="password" name="<?php echo ew_Encrypt(ew_Random()) ?>">
<div>
<?php if ($user->username->Visible) { // username ?>
	<div id="r_username" class="form-group">
		<label id="elh_user_username" for="x_username" class="col-sm-2 control-label ewLabel"><?php echo $user->username->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $user->username->CellAttributes() ?>>
<span id="el_user_username">
<input type="text" data-table="user" data-field="x_username" name="x_username" id="x_username" size="30" maxlength="32" placeholder="<?php echo ew_HtmlEncode($user->username->getPlaceHolder()) ?>" value="<?php echo $user->username->EditValue ?>"<?php echo $user->username->EditAttributes() ?>>
</span>
<?php echo $user->username->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($user->password->Visible) { // password ?>
	<div id="r_password" class="form-group">
		<label id="elh_user_password" for="x_password" class="col-sm-2 control-label ewLabel"><?php echo $user->password->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $user->password->CellAttributes() ?>>
<span id="el_user_password">
<div class="input-group" id="ig_password">
<input type="text" data-password-strength="pst_password" data-password-generated="pgt_password" data-table="user" data-field="x_password" name="x_password" id="x_password" value="<?php echo $user->password->EditValue ?>" size="30" maxlength="32" placeholder="<?php echo ew_HtmlEncode($user->password->getPlaceHolder()) ?>"<?php echo $user->password->EditAttributes() ?>>
<span class="input-group-btn">
	<button type="button" class="btn btn-default ewPasswordGenerator" title="<?php echo ew_HtmlTitle($Language->Phrase("GeneratePassword")) ?>" data-password-field="x_password" data-password-confirm="c_password" data-password-strength="pst_password" data-password-generated="pgt_password"><?php echo $Language->Phrase("GeneratePassword") ?></button>
</span>
</div>
<span class="help-block" id="pgt_password" style="display: none;"></span>
<div class="progress ewPasswordStrengthBar" id="pst_password" style="display: none;">
	<div class="progress-bar" role="progressbar"></div>
</div>
</span>
<?php echo $user->password->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($user->_email->Visible) { // email ?>
	<div id="r__email" class="form-group">
		<label id="elh_user__email" for="x__email" class="col-sm-2 control-label ewLabel"><?php echo $user->_email->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $user->_email->CellAttributes() ?>>
<span id="el_user__email">
<input type="text" data-table="user" data-field="x__email" name="x__email" id="x__email" size="30" maxlength="64" placeholder="<?php echo ew_HtmlEncode($user->_email->getPlaceHolder()) ?>" value="<?php echo $user->_email->EditValue ?>"<?php echo $user->_email->EditAttributes() ?>>
</span>
<?php echo $user->_email->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($user->userlevel->Visible) { // userlevel ?>
	<div id="r_userlevel" class="form-group">
		<label id="elh_user_userlevel" for="x_userlevel" class="col-sm-2 control-label ewLabel"><?php echo $user->userlevel->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $user->userlevel->CellAttributes() ?>>
<?php if (!$Security->IsAdmin() && $Security->IsLoggedIn()) { // Non system admin ?>
<span id="el_user_userlevel">
<p class="form-control-static"><?php echo $user->userlevel->EditValue ?></p>
</span>
<?php } else { ?>
<span id="el_user_userlevel">
<select data-table="user" data-field="x_userlevel" data-value-separator="<?php echo $user->userlevel->DisplayValueSeparatorAttribute() ?>" id="x_userlevel" name="x_userlevel"<?php echo $user->userlevel->EditAttributes() ?>>
<?php echo $user->userlevel->SelectOptionListHtml("x_userlevel") ?>
</select>
<input type="hidden" name="s_x_userlevel" id="s_x_userlevel" value="<?php echo $user->userlevel->LookupFilterQuery() ?>">
</span>
<?php } ?>
<?php echo $user->userlevel->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div>
<?php if (!$user_add->IsModal) { ?>
<div class="form-group">
	<div class="col-sm-offset-2 col-sm-10">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("AddBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $user_add->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div>
</div>
<?php } ?>
</form>
<script type="text/javascript">
fuseradd.Init();
</script>
<?php
$user_add->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$user_add->Page_Terminate();
?>
