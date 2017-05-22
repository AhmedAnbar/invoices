<div class="container">
<?php  includeScript('includes/nav.php'); ?>
                <div class="row">

                    <div class="col-lg-8 col-lg-offset-2">
                    <?php
                      $user = DB::getInstance()->query("SELECT * FROM users");
                      if (!$user->count()) {
                        echo "<h1>You'r not wellcome here</h1>";
                      } else {
                        echo "<h1>Wellcome back {$user->first()->username}</h1>";
                      }
                    ?>
                    <p>Bacon ipsum dolor sit amet tri-tip shoulder tenderloin shankle. Bresaola tail pancetta ball tip doner meatloaf corned beef. Kevin pastrami tri-tip prosciutto ham hock pork belly bacon pork loin salami pork chop shank corned beef tenderloin meatball cow. Pork bresaola meatloaf tongue, landjaeger tail andouille strip steak tenderloin sausage chicken tri-tip. Pastrami tri-tip kielbasa sausage porchetta pig sirloin boudin rump meatball andouille chuck tenderloin biltong shank </p>
                    </div>
                </div>
</div>
