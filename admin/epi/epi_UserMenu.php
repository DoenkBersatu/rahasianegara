<li class="dropdown user user-menu">
	<?php
	if (!empty($EPI_UserExt) && !empty($EPIUser_AvatarField) && !empty($EPIUser_AvatarFolder) && !empty($EPIUser_IDField) && IsloggedIn() && !IsSysAdmin()) {
		$user_array = epi_GetAll("SELECT $EPIUser_AvatarField FROM $EPIUser_Table WHERE $EPIUser_IDField = ".CurrentUserID() );
		$image_folder = ew_UploadPathEx(FALSE, $EPIUser_AvatarFolder);
		$usermenu_image_path = $image_folder.$user_array[0][$EPIUser_AvatarField];
		if (!is_dir($usermenu_image_path) && file_exists($usermenu_image_path)) {
			$usermenu_lgimage =  '<img src="'.$usermenu_image_path.'" alt="'.CurrentUserName().'" class="img-circle">';
			$usermenu_image =  '<img src="'.$usermenu_image_path.'" alt="'.CurrentUserName().'" class="user-image">';
		} else {
			$usermenu_lgimage =  "<i class='fa fa-4x fa-user text-info' title='Avatar missing'></i> <span></span>";	
			$usermenu_image =  "<i class='fa fa-user' title='Avatar missing'></i> <span></span>";	
		}
		$profile_edit_url = $EPIUser_Table.'edit.php?'.$EPIUser_IDField.'='.CurrentUserID();
	} 
	if (empty($EPI_UserExt)) {
		$usermenu_lgimage =  "<i class='fa fa-4x fa-user text-info' title='Avatar missing'></i> <span></span>";	
		$usermenu_image =  "<i class='fa fa-user' title='EPI User Extension not enabled'></i> <span></span>";
		$profile_edit_url = '#';
	} else {
		$profile_edit_url = $EPIUser_Table.'edit.php?'.$EPIUser_IDField.'='.CurrentUserID();
	}
	if (IsSysAdmin()) {
		$usermenu_lgimage =  "<i class='fa fa-4x fa-user text-info' title='SysAdmin Avatar'></i> <span></span>";	
		$usermenu_image =  "<i class='fa fa-user' title='SysAdmin Avatar'></i> <span></span>";
		$profile_edit_url = '#';
		}
	if (!IsLoggedIn()) {
		$usermenu_lgimage =  "<i class='fa fa-4x fa-user text-info' title='Anonymous User'></i> <span></span>";	
		$usermenu_image =  "<i class='fa fa-user' title='Anonymous User'></i> <span></span>";
		$profile_edit_url = '#';
		}
	?>
	<a href="#" class="dropdown-toggle" data-toggle="dropdown">
    <?php if (!empty($usermenu_image)) echo $usermenu_image; ?>
	<span class="hidden-xs"><?php echo CurrentUserInfo('pd_nickname'); ?></span>
	</a>
	<ul class="dropdown-menu">
	<!-- User image -->
	<li class="user-header">
    <?php echo $usermenu_lgimage; ?>
    <p>
	<?php echo CurrentUserInfo('pd_nickname'); ?> (<?php echo CurrentUserName(); ?>)<br />
    <small><?php echo Security()->CurrentUserLevelName(); ?></small>
    </p>
    </li>
    <!-- Menu Body -->
    <li class="user-body">
		<div class="row">
		<div class="col-xs-4 text-center"><a href="#">Followers</a></div>
		<div class="col-xs-4 text-center"><a href="#">Sales</a></div>
		<div class="col-xs-4 text-center"><a href="#">Friends</a></div>
	</div>
	</li>
        
    <!-- Menu Footer-->
    <li class="user-footer">
        <div class="pull-left"><a href="<?php echo $profile_edit_url; ?>" class="btn btn-default btn-flat">Profile</a></div>
        <div class="pull-right"><a href="logout.php" class="btn btn-default btn-flat">Sign out</a></div>
    </li>
	</ul>
</li>