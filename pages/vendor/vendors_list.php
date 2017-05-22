<?php 
require_once $_SERVER['DOCUMENT_ROOT'] . "/invoices/core/init.php"; 
?>
<!doctype html>
<html lang="en">
    <head>
        <?php include $INC_DIR . "head.php"; ?>
        <title>Invoices System: Users List</title>

    </head>
    <body>
    <div class="container-fluid" canvas="container">
      <?php include $INC_DIR . "nav.php"; ?>
      
      <div class="row vertical-align">
        <div class="col-md-12">
            <a href="<?php linkto('pages/invoices/create_invoice.php'); ?>" class="align-top"><span class="fa fa-plus"></span> Add New Invoice</a>
            <hr />
        </div>
      </div>
      <div class="row">
                <!--
                page content starts
                -->
        <div class="col-md-12">
            <?php
            $invoices = DB::getInstance()->query("SELECT * FROM invoices");
                    if (Session::exists('smsg')) {
                        Success(Session::flash('smsg'));
                        
                    }elseif (Session::exists('fmsg')) {
                        Danger(Session::flash('fmsg'));
                    }
                if (!$invoices->count()) {
                    Danger("No invoice in your database");
                } else { ?>
            <table id="invoicetable" class="display table" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>Vendor Id</th>
                        <th>Vendor Name</th>
                        <th>Vendor Email</th>
                        <th>Created By</th>
                        <th>Total Invoicies</th>
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
                    $vendors = new Vendor();
                    foreach ($vendors->data() as $tvendor) {
                    ?>
                    <tr>
                        <td><a href='<?php linkto("pages/invoices/vendor.php?vendorid=$tvendor->id"); ?>'><?php echo $tvendor->id; ?></a></td>
                        <td><?php echo $tvendor->vendorName; ?></td>
                        <td><?php echo $tvendor->vendorEmailAddress; ?></td>
                        <td><a href='<?php linkto("profile.php?userid=$tvendor->userId"); ?>'><?php echo $tvendor->userName; ?></a></td>
                        <td><?php echo number_format($tvendor->invoicesTotal, 2); ?></td>
                    </tr>
            
            <?php
                    }
            ?>
                </tbody>
            </table>            
            <?php
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

