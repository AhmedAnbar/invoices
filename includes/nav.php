<nav class="navbar navbar-inverse">
	<div class="container-fluid">
		<!-- Brand and toggle get grouped for better mobile display -->
		<div class="navbar-header">
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<span>
				<?php $img = new HTMLImage('', array('id' => 'logo', 'alt' => 'logo image', 'src' => 'img/logo.png', 'class' => 'img-round'));
				echo $img;
				?>
			</span>
			<a class="navbar-brand" href="/invoices/index.php">Invoices System</a>
		</div>

		<!-- Collect the nav links, forms, and other content for toggling -->
		<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
			<ul class="nav navbar-nav">
				<li class="">
					<a href="<?php linkto("pages/users/users.php"); ?>">Users</a>
				</li>
				<li class="">
                    <a href="<?php linkto("pages/invoices/invoices_list.php"); ?>">Invoices</a>
                </li>
                <li class="">
                    <a href="<?php linkto("pages/vendor/vendors_list.php"); ?>">Vendors</a>
                </li>
                <li class="">
                    <a href="<?php linkto("test.php"); ?>">Test OOP</a>
                </li>
			</ul>
			<?php 
			if ($user->isLoggedIn()){
			?>
				<ul class="nav navbar-nav navbar-right">
					<li class="dropdown"><li class="dropdown">
					<li class="dropdown">
						<a class="dropdown-toggle" data-toggle="dropdown" href=""> <span class="fa fa-user"></span> <?php echo $user->data()->userFullName  ?> </a>
						<ul class="dropdown-menu">
							<li>
								<a href="<?php linkto("profile.php?user={$user->data()->userName}"); ?>"> <span class="fa fa-user"></span> Profile </a>
							</li>
							<li>
								<a href="<?php linkto('logout.php'); ?>"><span class="fa fa-sign-in"></span> LogOut</a>
							</li>
						</ul>
					</li>
				</ul>
			<?php } else { ?>
				<span class="nav navbar-nav navbar-right">
					<a href="login.php"><button class="btn btn-primary navbar-btn"> <span class="fa fa-user"></span> Sign in</button></a>
			</span>
			<?php } ?>
				
			<!--
			<ul class="nav navbar-nav navbar-right">
				<li class="dropdown"><li class="dropdown">
				<li class="dropdown">
					<a class="dropdown-toggle" data-toggle="dropdown" href="#"> <span class="fa fa-user"></span> Admin </a>
					<ul class="dropdown-menu">
						<li>
							<a href="#"> <span class="fa fa-user"></span> Profile </a>
						</li>
					</ul>
				</li>
			</ul>
			-->
		</div><!-- /.navbar-collapse -->
	</div><!-- /.container-fluid -->
</nav>
<button type="button" class="hamburger is-closed js-toggle-left-slidebar navbar‐right" data-toggle="offcanvas">
	<span class="hamb-top"></span>
	<span class="hamb-middle"></span>
	<span class="hamb-middle2"></span>
	<span class="hamb-bottom"></span>
</button>

