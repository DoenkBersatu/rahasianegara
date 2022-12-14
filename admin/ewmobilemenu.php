<!-- Begin Main Menu -->
<?php

// Generate all menu items
$RootMenu->IsRoot = TRUE;
$RootMenu->AddMenuItem(17, "mmi_jenis_perusahaan", $Language->MenuPhrase("17", "MenuText"), "jenis_perusahaanlist.php", -1, "", AllowListMenu('{711D4B7A-499A-4AB9-B89B-D8472076C077}jenis_perusahaan'), FALSE, FALSE);
$RootMenu->AddMenuItem(18, "mmi_status", $Language->MenuPhrase("18", "MenuText"), "statuslist.php", -1, "", AllowListMenu('{711D4B7A-499A-4AB9-B89B-D8472076C077}status'), FALSE, FALSE);
$RootMenu->AddMenuItem(3, "mmi_minat_investasi", $Language->MenuPhrase("3", "MenuText"), "minat_investasilist.php", -1, "", AllowListMenu('{711D4B7A-499A-4AB9-B89B-D8472076C077}minat_investasi'), FALSE, FALSE);
$RootMenu->AddMenuItem(14, "mmi_form2Dupload_php", $Language->MenuPhrase("14", "MenuText"), "form-upload.php", -1, "", AllowListMenu('{711D4B7A-499A-4AB9-B89B-D8472076C077}form-upload.php'), FALSE, TRUE);
$RootMenu->AddMenuItem(4, "mmi_penyerapan_tk", $Language->MenuPhrase("4", "MenuText"), "penyerapan_tklist.php", -1, "", AllowListMenu('{711D4B7A-499A-4AB9-B89B-D8472076C077}penyerapan_tk'), FALSE, FALSE);
$RootMenu->AddMenuItem(5, "mmi_realisasi_investasi", $Language->MenuPhrase("5", "MenuText"), "realisasi_investasilist.php", -1, "", AllowListMenu('{711D4B7A-499A-4AB9-B89B-D8472076C077}realisasi_investasi'), FALSE, FALSE);
$RootMenu->AddMenuItem(12, "mmci_Pengaturan", $Language->MenuPhrase("12", "MenuText"), "", -1, "", IsLoggedIn(), FALSE, TRUE);
$RootMenu->AddMenuItem(1, "mmi_jenis", $Language->MenuPhrase("1", "MenuText"), "jenislist.php", 12, "", AllowListMenu('{711D4B7A-499A-4AB9-B89B-D8472076C077}jenis'), FALSE, FALSE);
$RootMenu->AddMenuItem(2, "mmi_kecamatan", $Language->MenuPhrase("2", "MenuText"), "kecamatanlist.php", 12, "", AllowListMenu('{711D4B7A-499A-4AB9-B89B-D8472076C077}kecamatan'), FALSE, FALSE);
$RootMenu->AddMenuItem(6, "mmi_sektor", $Language->MenuPhrase("6", "MenuText"), "sektorlist.php", 12, "", AllowListMenu('{711D4B7A-499A-4AB9-B89B-D8472076C077}sektor'), FALSE, FALSE);
$RootMenu->AddMenuItem(7, "mmi_subsektor", $Language->MenuPhrase("7", "MenuText"), "subsektorlist.php", 12, "", AllowListMenu('{711D4B7A-499A-4AB9-B89B-D8472076C077}subsektor'), FALSE, FALSE);
$RootMenu->AddMenuItem(8, "mmi_triwulan", $Language->MenuPhrase("8", "MenuText"), "triwulanlist.php", 12, "", AllowListMenu('{711D4B7A-499A-4AB9-B89B-D8472076C077}triwulan'), FALSE, FALSE);
$RootMenu->AddMenuItem(9, "mmi_user", $Language->MenuPhrase("9", "MenuText"), "userlist.php", 12, "", AllowListMenu('{711D4B7A-499A-4AB9-B89B-D8472076C077}user'), FALSE, FALSE);
$RootMenu->AddMenuItem(10, "mmi_userlevels", $Language->MenuPhrase("10", "MenuText"), "userlevelslist.php", 12, "", (@$_SESSION[EW_SESSION_USER_LEVEL] & EW_ALLOW_ADMIN) == EW_ALLOW_ADMIN, FALSE, FALSE);
$RootMenu->AddMenuItem(-1, "mmi_logout", "<i class='fa fa-sign-out'></i><span>" . $Language->Phrase("Logout") . "</span>", "logout.php", -1, "", IsLoggedIn());
$RootMenu->AddMenuItem(-1, "mmi_login", "<i class='fa fa-sign-in'></i><span>" . $Language->Phrase("Login") . "</span>", "login.php", -1, "", !IsLoggedIn() && substr(@$_SERVER["URL"], -1 * strlen("login.php")) <> "login.php");
$RootMenu->Render();
?>
<!-- End Main Menu -->
