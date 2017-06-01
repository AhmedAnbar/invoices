<?php 
require_once $_SERVER['DOCUMENT_ROOT'] . "/invoices/core/init.php";
if (!$user->isLoggedIn()) 
    {
	   Redirect::to('login.php' );
    }
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
							        <small class="text-muted">Vendor have invoices with total 
						  				<?php 
						  					$id = $vendorProfile->data()->id;
						                	$totalInvoices = DB::getInstance()->query("SELECT SUM(invoiceTotal) as total FROM invoices WHERE vendorId = $id");
						                	echo number_format($totalInvoices->first()->total,2); 
						                ?>
						            </small>
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
  	<div class="row">
  		<div class="col-md-2"></div>
  		<div class="col-md-8">
  			
            <!-- Nav tabs -->
			  <ul class="nav nav-tabs" role="tablist">
			    <li role="presentation" class="active"><a href="#invoices" aria-controls="invoices" role="tab" data-toggle="tab">Invoices</a></li>
			    <li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">Profile</a></li>
			    <li role="presentation"><a href="#messages" aria-controls="messages" role="tab" data-toggle="tab">Messages</a></li>
			    <li role="presentation"><a href="#settings" aria-controls="settings" role="tab" data-toggle="tab">Settings</a></li>
			  </ul>
			
			  <!-- Tab panes -->
			  <div class="tab-content">
			    <div role="tabpanel" class="tab-pane active" id="invoices">
			    	<table id="vendorinvoices" class="display table" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>Vendor Id</th>
                        <th>Vendor Name</th>
                        <th>Vendor Email</th>
                        <th>Created By</th>
                        <th>Bank Account</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                    </tr>
                </tfoot>
                
                <tbody>
                    <?php
                    $id = $vendorProfile->data()->id;
                    $invoices = DB::getInstance()->query("SELECT 
															invoices.id,
															invoiceTotal,
															invoiceCreatedDate,
															invoiceUserId,
															vendorId,
															vendors.id as vendorid,
															vendorName,
															vendorEmailAddress,
															vendorBankAccount,
															vendorType,
															vendorUserId,
															users.id as userid,
															userFullName
															 FROM invoices 
															 	JOIN vendors on invoices.vendorId = vendors.id 
															 	JOIN users on invoices.invoiceUserId = users.id
															 WHERE invoices.vendorId = $id");
                    foreach ($invoices->results() as $tinvoice) {
                    ?>
                    <tr>
                        <td><a href='<?php linkto("pages/invoices/invoice.php?invoiceid=$tinvoice->id"); ?>'><?php echo $tinvoice->id; ?></a></td>
                        <td><?php echo number_format($tinvoice->invoiceTotal, 2); ?></td>
                        <td><?php echo $tinvoice->invoiceCreatedDate; ?></td>
                        <td><a href='<?php linkto("profile.php?userid=$tinvoice->invoiceUserId"); ?>'><?php echo $tinvoice->userFullName; ?></td>
                        <td><a href='<?php linkto("pages/vendor/vendor.php?vendorid=$tinvoice->vendorId"); ?>'><?php echo $tinvoice->vendorBankAccount; ?></a></td>
                    </tr>
            
            <?php
                    }
            ?>
                </tbody>
            </table>  
			    </div>
			    <div role="tabpanel" class="tab-pane" id="profile">...</div>
			    <div role="tabpanel" class="tab-pane" id="messages">...</div>
			    <div role="tabpanel" class="tab-pane" id="settings">...</div>
			  </div>         
  		</div>
  		<div class="col-md-2"></div>
  	</div>
    </div>
		<?php include $INC_DIR . "slidebar.php"; ?>
		<?php include $INC_DIR . "footer.php"; ?>
</body>
</html>
