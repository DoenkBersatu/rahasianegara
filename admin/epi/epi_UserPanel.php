<?php 
if (!empty($EPI_UserExt) && !empty($EPIUser_AvatarField) && !empty($EPIUser_AvatarFolder) && !empty($EPIUser_IDField) && IsloggedIn() && !IsSysAdmin()) {
	$user_array = epi_GetAll("SELECT $EPIUser_AvatarField FROM $EPIUser_Table WHERE $EPIUser_IDField = ".CurrentUserID() );
	$image_folder = ew_UploadPathEx(FALSE, $EPIUser_AvatarFolder);
	$userpanel_image_path = $image_folder.$user_array[0][$EPIUser_AvatarField];
	if (!is_dir($userpanel_image_path) && file_exists($userpanel_image_path)) {
		$userpanel_smallimage =  '<img src="'.$userpanel_image_path.'" alt="'.CurrentUserName().'" class="online img-circle">';
	} else {
		$userpanel_smallimage =  "<i class='fa fa-3x fa-user text-black' title='Avatar missing'></i> <span></span>";
	}
}
if (IsSysAdmin()) {
		$userpanel_smallimage =  "<i class='fa fa-3x fa-user text-black' title='Administrator'></i> <span></span>";
}
if (!IsLoggedIn()) {
		$userpanel_smallimage =  "<i class='fa fa-3x fa-user text-black' title='Anonymous'></i> <span></span>";
}
?>
<div class="user-panel">
        <div class="pull-left image">
          <?php echo $userpanel_smallimage; ?>
        </div>
        <div class="pull-left info">
          <p><?php echo CurrentUserName(); ?></p>
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>