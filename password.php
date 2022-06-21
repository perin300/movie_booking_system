<?php
	/*
	*Template Name: forgot password
	*/
	get_header();

	/*if(isset($_REQUEST['email']) && $_REQUEST['email'] != ''){
		$user_data = array(
			'user_email' => $_POST['email'],
			'user_pass' => $_POST['password']
		);
		
		if(wp_update_user($user_data))
		{
			echo "Password changed successfully!!";
		}
		else{
			echo "not changed!!";
		}
	}*/
	if(isset($_REQUEST['email']) && $_REQUEST['email'] != ''){
		$user = $wpdb->get_results("SELECT `ID` FROM `wp_users` WHERE `user_email`='".$_POST['email']."'");
		$user_data = wp_update_user(array('ID'=>$user->ID, 'user_pass'=>md5($_POST['password']));
		/*$user = $wpdb->get_results("UPDATE `wp_users` SET `user_pass`='".md5($_POST['password'])."' WHERE `user_email`='".$_POST['email']."'");
		print_r("UPDATE `wp_users` SET `user_pass`='".md5($_POST['password'])."' WHERE `user_email`='".$_POST['email']."'");
		if($user)
		{
			echo "Password changed successfully!!";
		}
		else{
			echo "not changed!!";
		}*/
	}

?>

<form action="#" method="POST">
	  	<center>
        Enter email
        <input type="email" class="input-block-level" name="email"  title="Please enter a new password"  required><br><br>
        Enter a new password
        <input type="password" class="input-block-level" name="password"  title="Please enter a new password"  required><br><br>
        Confirm your password
        <input type="password" class="input-block-level" name="confirm_password" required><br><br>
		<input type="hidden" name="save" value="signin">
		<button type="submit" class="btn btn-info">
			<i class="icon-ok icon-white"></i> Done
		</button>
        
<?php
get_footer();
?>