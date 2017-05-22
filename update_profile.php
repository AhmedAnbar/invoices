<?php 
require_once $_SERVER['DOCUMENT_ROOT'] . "/invoices/core/init.php";
if (!$user->isLoggedIn()) 
    {
	   Redirect::to('login.php' );
    }
    if (!$userid = Input::get('userid') || $user->exists()) {
        Session::flash('fmsg', "You must login to choose a user to view.");
        Redirect::to('login.php');                          
    }
    $userid = escape(Input::get('userid'));
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
					<h1 class="text-center">Wellcom to edit profile page for <?php echo escape($user->data()->userFullName); ?></h1>
					<div class="col-md-3"></div>
					<div class="col-md-6">
						<div class="jumbotron">
							<?php
    							if (!empty($userid)) {
                                    $userProfile = new User($userid);
                                    if (!$userProfile->exists()) {
                                        Session::flash('fmsg', "User dosn't exists");
                                        if ($user->hasPermission('admin')) {
                                            Redirect::to('index.php');
                                        } else {
                                            Redirect::to('index.php');
                                        }
                                    }
                                } else {
                                    $userProfile = new User();
                                    
                                }
							 if (Input::exists()) {
								if (Token::check(Input::get('token'))) {
									$validate = new Validate();
		                            $validation = $validate->check($_POST, $items = array(
		                            'userName' => array(
		                                'name' => 'User Name',
		                                'require' => true,
		                                'min' => 2,
		                                'max' => 20,
		                                ),
		                            'userEmailAddress' => array(
		                                'name' => 'Email Address',
										'require' => true
		                                ),
		                       		'userFullName' => array(
										'name' => 'Full Name',
		                                'require' => true,
		                                'min' => 3,
		                                'max' => 40
		                                )
		                            ));
									if ($validation->passed()) {
										try {
											$user->update(array(
												'userName' => ucfirst(escape(Input::get('userName'))),
												'userFullName' => ucwords(escape(Input::get('userFullName'))),
												'userEmailAddress' => escape(Input::get('userEmailAddress')),
												'userGroup' => escape(Input::get('userGroup'))
											), $userProfile->data()->id);
											
											Session::flash('smsg', "Account have been updated");
                                            Redirect::to("profile.php?userid=" . Input::get('userid'));
										} catch(Exception $e) {
											die($e->getMessage());
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
									<label for="userName">User Name: </label>
									<input type="text" class="form-control" name="userName" id="userName" placeholder="eg. Meto" value="<?php echo escape($userProfile->data()->userName); ?>" />
								</div>
								<div class="form-group">
									<label for="userFullName">User FullName: </label>
									<input type="text" class="form-control" name="userFullName" id="userFullName" placeholder="eg. Ahmed Sayed" value="<?php echo escape($userProfile->data()->userFullName); ?>" />
								</div>
								<div class="form-group">
									<label for="userEmailAddress">User Email Address: </label>
									<input type="email" class="form-control" name="userEmailAddress" id="userEmailAddress" placeholder="eg. meto@company.com" value="<?php echo escape($userProfile->data()->userEmailAddress); ?>" />
								</div>
								<?php if($user->hasPermission('admin')){ ?>
								<div class="form-group">
									<label for="userGroup"><span class="fa fa-group"></span> Group</label>
									<?php 
									$ugroups = DB::getInstance()->query("SELECT * FROM groups WHERE id = {$userProfile->data()->userGroup}"); 
									?>
									<small class="text-muted">User has joined to <u><?php echo $ugroups->first()->groupName; ?></u> group change it form here</small>
									<select class="form-control" name="userGroup">
									    <option value="<?php echo $ugroups->first()->id; ?>">
									        <?php echo $ugroups->first()->groupName; ?>
									    </option>
									    <?php  
									       $groups = DB::getInstance()->query("SELECT * FROM groups WHERE id <> {$userProfile->data()->userGroup}");
									    foreach ($groups->results() as $group) {
								        ?>  
											<option value="<?php echo $group->id; ?>"><?php echo $group->groupName; ?></option>
									    <?php
										}
									    ?>
										
									</select>
								</div>
								<div class="form-group">
                                    <label for="userGroup"><span class="fa fa-group"></span> Group</label>
                                    <input type="file" class="form-control" name="userImage" id="userImage" />
                                </div>
								<?php } ?>
								<input type="hidden" name="token" value="<?php echo Token::generate(); ?>" />
								<input type="hidden" name="userid" value="<?php echo escape($userProfile->data()->id); ?>" id="userid" />
								<button class="btn btn-info">Update</button>
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
