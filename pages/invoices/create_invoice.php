<?php
include $_SERVER['DOCUMENT_ROOT'] . "/invoices/core/init.php";
if (!$user->hasPermission('superuser')) {
    Session::flash('fmsg', 'You Don\'t have access to this page');
    Redirect::to("index.php");

}
?>
<!doctype html>
<html lang="en">
    <head>
        <?php include $INC_DIR . "head.php"; ?>
        <title>MLMSystem: Add new invoice </title>

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
                            'invoiceTotal' => array(
                                'name' => 'Invoice Total',
                                'require' => true,
                                'min' => 2,
                                'max' => 20,
                                'type' => 'number'
                                ),
                           
                            ));
                            if($validation->passed()){
                                
                                
                                $salt = Hash::salt(32);                             
                                try{
                                    $invoice = new Invoice();
                                    $invoice->create(array(
                                        'invoiceTotal' => escape(Input::get('invoiceTotal')),
                                        'invoiceCreatedDate' => date('Y-m-d H:i:s'),
                                        'invoiceUserId' => $user->data()->id
                                        
                                    ));
                                    Session::flash('smsg', "You have been add new invoice");
                                    Redirect::to('pages/invoices/invoices_list.php');
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
                        <label for="invoiceTotal">Invoice Total</label>
                        <input type="number" step="0.05" class="form-control" id="invoiceTotal" name="invoiceTotal" value="<?php echo escape(Input::get('invoiceTotal'));  ?>" placeholder="eg. 300.00">
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
