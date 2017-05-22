<?php 
require_once $_SERVER['DOCUMENT_ROOT'] . "/invoices/core/init.php";
if (!$user->isLoggedIn()) {
	Redirect::to('index.php');
}

?>
<!doctype html>
<html lang="en">
	<head>
		<?php include $INC_DIR . "head.php"; ?>
		<title>MLM System:Update <?php echo escape($user->data()->userFullName); ?> Profile Page</title>

	</head>

	<body>
	<div class="container-fluid" canvas="container">
      <?php include $INC_DIR . "nav.php"; ?>
      

      <div class="row">
				<!--
				page content starts
				-->
        <div class="col-md-12">
					<h1 class="text-center">Wellcom to change password page for <?php echo escape($user->data()->userFullName); ?></h1>
					<div class="col-md-3"></div>
					<div class="col-md-6">
						<div class="jumbotron">
							<?php
							if (Input::exists()) {
								if (Token::check(Input::get('token'))) {
									$validate = new Validate();
									$validation = $validate->check($_POST, $items = array(
										'userOldPassword' => array(
											'name' => 'Old Password',
											'require' => TRUE,
											'min' => 6
										),
										'userNewPassword' => array(
											'name' => 'New Password',
											'require' => TRUE,
											'min' => 6
										),
										'userNewPasswordAgain' => array(
											'name' => 'New Password Again',
											'require' => TRUE,
											'min' => 6,
											'matche' => 'userNewPassword'
										),
									));
									if ($validation->passed()) {
										if (Hash::make(Input::get('userOldPassword'), $user->data()->userSalt) !== $user->data()->userPassword) {
											Danger('Your current password is wrong');
										}
										if (Hash::make(Input::get('userNewPassword'), $user->data()->userSalt) == $user->data()->userPassword) {
											Danger('Your new password is same as old one');
										} else {
											$salt = Hash::salt(32);
											$user->update(array(
												'userPassword' =>Hash::make(Input::get('userNewPassword'), $salt),
												'userSalt' => $salt
											));
											Session::flash('profileSuccess', 'Your password have been updated.');
											Redirect::to('profile.php');
										}
										
										
									} else {
										foreach ($validation->errors() as $error) {
											Danger($error);
										}
									}
								}
							}
							?>
							<form action="" method="post">
								<div class="form-group">
									<label for="userOldPassword">Old Password: </label>
									<input class="form-control" type="password" name="userOldPassword" id="userOldPassword" placeholder="********" />
								</div>
								<div class="form-group">
									<label for="userNewPassword">New Password: </label>
									<input class="form-control" type="password" name="userNewPassword" id="userNewPassword" placeholder="********" />
								</div>
								<div class="form-group">
									<label for="userNewPasswordAgain">Confirm New Password: </label>
									<input class="form-control" type="password" name="userNewPasswordAgain" id="userNewPasswordAgain" placeholder="********" />
								</div>
								<input type="hidden" name="token" value="<?php echo Token::generate(); ?>" />
								<button class="btn btn-info" type="submit">Change Password</button>
								
							</form>
		                </div>
		            </div>
		            <div class="col-md-3"></div>
        </div>
				<!--
				page content ends
				-->
  	</div>
    </div>
		<?php include $INC_DIR . "slidebar.php"; ?>
		<?php include $INC_DIR . "footer.php"; ?>
</body>
</html>
