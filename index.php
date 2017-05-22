<?php 
require_once $_SERVER['DOCUMENT_ROOT'] . "/invoices/core/init.php"; 
?>
<!doctype html>
<html lang="en">
	<head>
		<?php include $INC_DIR . "head.php"; ?>
		<title>Wellcome To MLMSystem</title>

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
					?>
							
					<h1>Wellcom <?php echo escape($user->data()->userFullName); ?></h1>
					
					
					<?php		
						} else {
							Session::flash('fmsg', "<h5>You'r not logged in, please login here</h5>");		
							Redirect::to('login.php');
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
