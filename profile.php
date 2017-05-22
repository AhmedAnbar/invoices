<?php 
require_once $_SERVER['DOCUMENT_ROOT'] . "/invoices/core/init.php";
if (!$username = Input::get('userid') || $user->exists()) {
Session::flash('fmsg', "You should choose a user to view.");
Redirect::to('index.php');							
}
?>
<!doctype html>
<html lang="en">
	<head>
		<?php include $INC_DIR . "head.php"; ?>
		<title>MLM System: <?php echo escape($user->data()->userFullName); ?> Profile Page</title>

	</head>

	<body>
	<div class="container-fluid" canvas="container">
      <?php include $INC_DIR . "nav.php"; ?>
      

      <div class="row">
				<!--
				page content starts
				-->
        <div class="col-md-12">

					<?php
						if (Session::exists('smsg')) {
							Success(Session::flash('smsg'));
							
						}elseif (Session::exists('fmsg')) {
							Danger(Session::flash('fmsg'));
						}
						
						if ($user->isLoggedIn()) {
							if ($userid = Input::get('userid')) {
								$userProfile = new User($userid);
								if (!$userProfile->exists()) {
									Session::flash('fmsg', 'User dosn\'t exists');
									Redirect::to('pages/users.php');
								}
							} else {
								$userProfile = new User();
							}
					?>
							
					<h1 class="text-center">Wellcom to profile page for <?php echo escape($userProfile->data()->userFullName); ?></h1>
					<div class="col-md-3"></div>
					<div class="col-md-6">
						<div class="jumbotron">
							<?php
							if ($user->data()->id == $userProfile->data()->id || $user->hasPermission('admin')) {
								
							
							?>
							<div class="row">
							    <div class="col-md-3 text-left">
                                    <img class="img-responsive img-circle" alt="<?php echo $userProfile->data()->userName . " Profile Photo";  ?>" src="<?php linkto('img/users_img/default.jpg'); ?>" />
                                </div>
								<div class="col-md 9 text-right">
									<a href="update_profile.php?userid=<?php echo $userProfile->data()->id; ?>"><button class="btn btn-default btn-xs">
										<span class="fa fa-pencil"></span>
									</button></a>
									<a href="changepassword.php"><button class="btn btn-default btn-xs">
										<span class="fa fa-key"></span>
									</button></a>
								</div>
							</div>
							<?php } ?>
							<div class="space"></div>
							<div class="row">
							    <div class="col-md-12">
							        <table class="table-hover">
							            <tr>
							                <td><h5><span class="fa fa-user"></span> User Name:</h5></td>
							                <td><span class="text-left"><h5 class="text-left"><?php echo $userProfile->data()->userName; ?></h5></span></td>
							            </tr>
							            <tr>
							                <td><h5><span class="fa fa-user"></span> Full Name:</h5></td>
							                <td><span class="text-left"><h5 class="text-left"><?php echo $userProfile->data()->userFullName; ?></h5></span></td>
							            </tr>
							            <tr>
							                <td><h5><span class="fa fa-envelope"></span> Email Address:</h5></td>
							                <td><span class="text-left"><h5 class="text-left"><?php echo $userProfile->data()->userEmailAddress; ?></h5></span></td>
							            </tr>
							            <tr>
							                <td><h5><span class="fa fa-calendar"></span> Joined Date:</h5></td>
							                <td><span class="text-left"><h5 class="text-left"><?php echo $userProfile->data()->userJoinDate; ?></h5></span></td>
							            </tr>
							            <tr>
							                <td><h5><span class="fa fa-group"></span> User Group:</h5></td>
							                <td><?php 
                                                    $ugroups = DB::getInstance()->query("SELECT * FROM groups WHERE id = {$userProfile->data()->userGroup}"); 
                                                ?>
                                             <?php echo $ugroups->first()->groupName; ?></td>
							            </tr>
							        </table>
							    </div>
							</div>
		                </div>
		            </div>
		            <div class="col-md-3"></div>
					
					<?php		
						} else {		
							Redirect::to('index.php');
						}
					?>

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
