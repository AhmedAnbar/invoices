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
            $invoices = DB::getInstance()->query("SELECT 
                                         invoices.id,
                                         invoiceTotal,
                                         invoiceCreatedDate,
                                         invoiceUserId,
                                         users.id as userId,
                                         userName
                                       FROM invoices, users
                                       WHERE invoiceUserId = users.id
                                       ");
                    if (Session::exists('smsg')) {
                        Success(Session::flash('smsg'));
                        
                    }elseif (Session::exists('fmsg')) {
                        Danger(Session::flash('fmsg'));
                    }
                if (!$invoices->count()) {
                    Danger("No incoice in your database");
                } else { ?>
            <table id="invoicetable" class="display table" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>Incoice ID</th>
                        <th>Invoice Total</th>
                        <th>Created Date</th>
                        <th>Created By</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th></th>
                        <th><?php 
                            $totalInvoices = DB::getInstance()->query("SELECT SUM(invoiceTotal) as total FROM invoices");
                            echo number_format($totalInvoices->first()->total,2); ?></th>
                        <th></th>
                        <th></th>
                    </tr>
                </tfoot>
                
                <tbody>
                    <?php
                    $invoices = DB::getInstance()->query("SELECT 
                                         invoices.id,
                                         invoiceTotal,
                                         invoiceCreatedDate,
                                         invoiceUserId,
                                         users.id as userId,
                                         userName
                                       FROM invoices, users
                                       WHERE invoiceUserId = users.id
                                       ");
                    foreach ($invoices->results() as $tinvoice) {
                    ?>
                    <tr>
                        <td><?php echo $tinvoice->id; ?></td>
                        <td><?php echo number_format($tinvoice->invoiceTotal, 2); ?></td>
                        <td><?php echo $tinvoice->invoiceCreatedDate; ?></td>
                        <td><?php echo $tinvoice->userName; ?></td>
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

