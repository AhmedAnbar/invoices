<?php 
require_once $_SERVER['DOCUMENT_ROOT'] . "/invoices/core/init.php"; 
if (!$invoiceId = Input::get('invoiceid')) {
Session::flash('fmsg', "You should choose a invoice to view.");
Redirect::to('index.php');                          
}
$invoiceId = escape(Input::get('invoiceid'))
?>
<!doctype html>
<html lang="en">
    <head>
        <?php include $INC_DIR . "head.php"; ?>
        <title>Wellcome To MLMSystem: Invoice Page</title>

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
                            if (!empty($invoiceId)) {
                                    $Invoice = new Invoice($invoiceId);
                                    if (!$Invoice->exists()) {
                                        Session::flash('fmsg', "Invoice dosn't exists");
                                        if ($user->hasPermission('admin')) {
                                            Redirect::to('index.php');
                                        } else {
                                            Redirect::to('index.php');
                                        }
                                    }
                                }
                            
                    ?>
                        
                    <h1>Invoice total is :  <?php echo $Invoice->data()->invoiceTotal; ?></h1>
                    
                    <?php if ($user->hasPermission('admin')) { ?>
                        <h4>You are adminstrator</h4>
                    <?php } ?>
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
