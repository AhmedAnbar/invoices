<?php 
require_once $_SERVER['DOCUMENT_ROOT'] . "/invoices/core/init.php";
if (!$vendorid = Input::get('vendorid') || $user->exists()) {
Session::flash('fmsg', "You should choose a vendor to view.");
Redirect::to('index.php');							
}
$vendorid = Input::get('vendorid')
?>
<!doctype html>
<html lang="en">
	<head>
		<?php include $INC_DIR . "head.php"; ?>
		<title>MLM System: Vendor Profile Page</title>

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
							if (!empty($vendorid)) {
								$vendorProfile = new Vendor($vendorid);
								
								if (!$vendorProfile->exists()) {
									Session::flash('fmsg', 'Vendor dosn\'t exists');
									Redirect::to('index.php');
								}
							} else {
								//$userProfile = new User();
							}
					?>
							
					<div class="col-md-3"></div>
					<div class="col-md-6">
						<div class="jumbotron">
							<?php
							if ($user->data()->id == $vendorProfile->data()->vendorUserId || $user->hasPermission('admin')) {
							?>
							<div class="row">
							    <div class="col-md-3 text-left">
                                    <img class="img-responsive img-circle" alt="" src="<?php linkto('img/users_img/default.jpg'); ?>" />
                                </div>
								<div class="col-md 9 text-right">
									<a href="#"><button class="btn btn-default btn-xs">
										<span class="fa fa-pencil"></span>
									</button></a>
									<a href="#"><button class="btn btn-default btn-xs">
										<span class="fa fa-key"></span>
									</button></a>
								</div>
							</div>
							<?php } ?>
							<div class="space"></div>
							<div class="row">
							    <div class="col-md-12">
							        <table class="table-hover table-striped">
							            <tr>
							                <td><h5><span class="fa fa-user"></span> Vendor Name:</h5></td>
							                <td><span class="text-left"><h5 class="text-left"><?php echo $vendorProfile->data()->vendorName; ?></h5></span></td>
							            </tr>
							            <tr>
							                <td><h5><span class="fa fa-user"></span> Full Name:</h5></td>
							                <td><span class="text-left"><h5 class="text-left"><?php echo $vendorProfile->data()->vendorEmailAddress; ?></h5></span></td>
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
