<?php
include $_SERVER['DOCUMENT_ROOT'] . "/invoices/core/init.php";
if ($user->isLoggedIn()) {
	Redirect::to('index.php');
}
?>
<!doctype html>
<html lang="en">
	<head>
		<?php include $INC_DIR . "head.php"; ?>
	
		<title>MLMSystem: Login page</title>

	</head>

<body>
	<div class="container-fluid" canvas="container">
	<?php include $INC_DIR . "nav.php"; ?>
		<div class="row">
		<!--
		page content starts
		-->
			<div class="col-md-12">
              <div class="col-md-3"></div>
              <div class="col-md-6">
              <div class="jumbotron">
              	<?php
              	if (Session::exists('smsg')) {
						Success(Session::flash('smsg'));
						
					}elseif (Session::exists('fmsg')) {
						Danger(Session::flash('fmsg'));
					}
              	if (Input::exists()) {
					  if (Token::check(Input::get('token'))) {
						  $validate = new Validate();
						  $validation = $validate->check($_POST, $items = array(
						  	'userName' => array(
								'name' => 'User Name',
								'require' => 'TRUE'
							),
						  	'userPassword' => array(
						  		'name' => 'Password',
						  		'require' => 'TRUE'
							)
						  ));
						  if ($validation->passed()) {
							  
							  $remember = (Input::get('remember') === 'on') ? TRUE : FALSE;
							  $login = $user->login(Input::get("userName"), Input::get("userPassword"), $remember);
							  
							  if ($login) {
								  Session::flash('smsg', 'You have been login successfuly.');
								  Redirect::to('index.php');
							  } else {
								  Danger("Sorry, login failed.");
							  }
							  
						  } else {
							  foreach($validation->errors() as $error) {
							  	Danger($error);
							  }
						  }
					  }
				  }
              	?>
                <form action=" " method="post">
                    <div class="form-group">
                        <label for="userName">User Name</label>
                        <input type="text" autocomplete="off" class="form-control" id="userName" name="userName" value="<?php echo escape(Input::get('userName'));  ?>" placeholder="eg. Meto">
                    </div>
                    <div class="form-group">
                        <label for="userPassword">Password</label>
                        <input type="password" autocomplete="off" class="form-control" id="userPassword" name="userPassword" placeholder="********">
                        <small id="passwordHelp" class="form-text text-muted">Never share your password with anyone.</small>
                   	</div>
					<div class="form-group">
						<div class="checkbox">
						<label>
							<input type="checkbox" name="remember" id="remember">
							<span class="cr"> <i class="cr-icon fa fa-check"></i> </span> Remember me
						</label>
					</div>
					</div>
						<input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
                   		<button class="btn btn-info" type="submit">Login</button>
                </form><br>
                </div>
                </div>
                <div class="col-md-3"></div>
            </div>
		<!--
		page content ends
		-->
  		</div>
	</div>
		<?php include $INC_DIR . "footer.php"; ?>
</body>
</html>
