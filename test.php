<?php 
require_once $_SERVER['DOCUMENT_ROOT'] . "/invoices/core/init.php";
if (!$vendorid = Input::get('vendorid') || $user->exists()) {
Session::flash('fmsg', "You should choose a vendor to view.");
Redirect::to('index.php');							
}
$vendorid = Input::get('vendorid');
?>
<!doctype html>
<html lang="en">
	<head>
		<?php include $INC_DIR . "head.php"; ?>
		<title>MLM System: Test OOP with PHP</title>

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
							
					<div class="col-md-3"></div>
					<div class="col-md-6">
						<div class="jumbotron">
							<?php
								$para = new HTMLParagraph("Hello World", array('class' => 'btn btn-info'));
								echo "Tag changer " . $para;
								echo "<hr />";
								$img = new HTMLImage('', array('id' => 'logo', 'alt' => 'logo image', 'src' => 'img/logo.png'));
								echo "Image class " . $img;
								echo "<hr />";
								
							?>
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
