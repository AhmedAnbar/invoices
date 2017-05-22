<?php
include $_SERVER['DOCUMENT_ROOT'] . "/invoices/core/init.php";
if (!$user->hasPermission('admin')) {
	Session::flash('fmsg', 'You Don\'t have access to this page');
	Redirect::to("index.php");

}
?>
<!doctype html>
<html lang="en">
	<head>
		<?php include $INC_DIR . "head.php"; ?>
		<title>MLMSystem: Add new user to </title>

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
                    if (Input::exists()) {
    					if (Token::check(Input::get('token'))) {
							$validate = new Validate();
                            $validation = $validate->check($_POST, $items = array(
                            'userName' => array(
                                'name' => 'User Name',
                                'require' => true,
                                'min' => 2,
                                'max' => 20,
								'unique' => 'users'
                                ),
                            'emailAddress' => array(
                                'name' => 'Email Address',
								'require' => true
                                ),
                            'userPassword' => array(
								'name' => 'Password',
                                'require' =>true,
                                'min' => 6
                                ),
                            'confirmUserPassword' => array(
								'name' => 'Passwords',
								'require' => true,
                                'matche' => 'userPassword'
                                ),
                       		'fullName' => array(
								'name' => 'Full Name',
                                'require' => true,
                                'min' => 3,
                                'max' => 40
                                ),
                            'userGroup' => array(
								'name' => 'User group',
								'require' => TRUE
							)
                            ));
							if($validation->passed()){
                                
								
								$salt = Hash::salt(32);								
                                try{
                                    $user->create(array(
                                        'userFullName' => ucwords(escape(Input::get('fullName'))),
                                        'userName' => ucfirst(escape(Input::get('userName'))),
                                        'userEmailAddress' => Input::get('emailAddress'),
                                        'userPassword' => Hash::make(Input::get('userPassword'), $salt),
                                        'userSalt' => $salt,
                                        'userJoinDate' => date('Y-m-d H:i:s'),
                                        'userGroup' => escape(Input::get('userGroup'))
                                        
                                    ));
									 $newUser = new User(DB::getInstance()->lastId());

									Session::flash('smsg', "You have been add new user with <a href=\"../profile.php?user={$newUser->data()->userName}\">{$newUser->data()->userName}</a> user name");
									Redirect::to('pages/users.php');
                                } catch(Exception $e){
                                    Danger(die($e->getMessage()));
                                }
							}else {
							    foreach($validation->errors() as $error){
								Danger($error);
				    			}
							}
					    }
                    }
                 ?>
                <form action=" " method="post">
                    <div class="form-group">
                        <label for="userName">User Name</label>
                        <input type="text" class="form-control" id="userName" name="userName" value="<?php echo escape(Input::get('userName'));  ?>" placeholder="eg. Meto">
                    </div>
                    <div class="form-group">
                        <label for="emailAddress">Email address</label>
                        <input type="email" class="form-control" id="emailAddress" name="emailAddress" value="<?php echo escape(Input::get('emailAddress'));  ?>" placeholder="eg. Email@company.com">
                    </div>
                    <div class="form-group">
                        <label for="userPassword">Password</label>
                        <input type="password" class="form-control" id="userPassword" name="userPassword" placeholder="********">
                        <small id="passwordHelp" class="form-text text-muted">Never share your password with anyone.</small>
                    </div>
                    <div class="form-group">
                        <label for="confirmUserPassword">Confirm Password</label>
                        <input type="password" class="form-control" id="confirmUserPassword" name="confirmUserPassword" placeholder="********">
                        <small id="password_agineHelp" class="form-text text-muted">Enter your password agine.</small>
                    </div>
					<div class="form-group">
                        <label for="fullName">Full Name</label>
                        <input type="text" class="form-control" id="fullName" name="fullName" value="<?php echo escape(Input::get('fullName'));  ?>" placeholder="eg. Ahmed Sayed">
                    </div>
                    <div class="form-group">
                    	<label for="userGroup"><span class="fa fa-group"></span> Group</label>
						<select class="form-control" name="userGroup">
                                        <?php  
                                           $groups = DB::getInstance()->query("SELECT * FROM groups");
                                        foreach ($groups->results() as $group) {
                                        ?>  
                                            <option value="<?php echo $group->id; ?>"><?php echo $group->groupName; ?></option>
                                        <?php
                                        }
                                        ?>
                                        
                                    </select>
					</div>
						<input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
                   		<button class="btn btn-info" type="submit">Register</button>
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
		<?php include $INC_DIR . "slidebar.php"; ?>
		<?php include $INC_DIR . "footer.php"; ?>	
</body>
</html>
