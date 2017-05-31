<?php 
require_once $_SERVER['DOCUMENT_ROOT'] . "/invoices/core/init.php"; 
if (!$user->hasPermission('admin')) {
	Session::flash('fmsg', 'You Don\'t have access to this page');
	Redirect::to('index.php');
}
if ($duser = escape(Input::get('deleteUser'))) {
	$user->delete($duser);
    Session::flash('smsg', "User Deleted");
}

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
	  		<a href="<?php linkto('register.php'); ?>" class="align-top"><span class="fa fa-plus"></span> Add New User</a>
	  		<hr />
	  	</div>
	  </div>
      <div class="row">
				<!--
				page content starts
				-->
        <div class="col-md-12">
			<?php
			$users = DB::getInstance()->query("SELECT 
                                         users.id,
                                         userName,
                                         userFullName,
                                         userGroup,
                                         userEmailAddress,
                                         userJoinDate,
                                         groups.id as groupID,
                                         groupName 
                                       FROM users, groups
                                       WHERE users.userGroup = groups.id
                                       ");
					if (Session::exists('smsg')) {
						Success(Session::flash('smsg'));
						
					}elseif (Session::exists('fmsg')) {
						Danger(Session::flash('fmsg'));
					}
				if (!$users->count()) {
					Danger("No users in your database");
				} else { ?>
            <table id="userstable" class="display table" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>User ID</th>
                        <th>User Name</th>
                        <th>Full Name</th>
                        <th>Email Address</th>
                        <th>Created Date</th>
                        <th>Rolle</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>User ID</th>
                        <th>User Name</th>
                        <th>Full Name</th>
                        <th>Email Address</th>
                        <th>Created Date</th>
                        <th>Rolle</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </tr>
                </tfoot>
                
                <tbody>
                    <?php
					foreach ($users->results() as $tuser) {
					?>
					<tr>
					    <td><?php echo $tuser->id; ?></td>
						<td><span class="fa fa-user"> <a href='<?php linkto("profile.php?userid=$tuser->id"); ?>'><?php echo $tuser->userName; ?></a></span></td>
						<td><?php echo $tuser->userFullName; ?></td>
						<td><?php echo $tuser->userEmailAddress; ?></td>
						<td><?php echo $tuser->userJoinDate; ?></td>
						<td><?php echo $tuser->groupName; ?></td>
						<td>
							<button class="btn btn-info btn-xs" data-target="#edit<?php echo $tuser->id; ?>" data-toggle="modal" data-title="Edit">
								<span class="fa fa-pencil"></span>
							</button>
						</td>
						<td>
							<button class="btn btn-danger btn-xs" data-target="#delete<?php echo $tuser->id; ?>" data-toggle="modal" data-title="Delete">
								<span class="fa fa-trash"></span>
							</button>
						</td>
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
    <?php
		foreach ($users->results() as $tuser) {
	?>
	<div id="edit<?php echo $tuser->id; ?>" class="modal fade" aria-hidden="true" aria-labelledby="edit" role="dialog" tabindex="-1">
		<div class="modal-dialog">
			<div class="modal-content">
				<form action="" method="post">
					<div class="modal-header">
						<button class="close" aria-hidden="true" data-dismiss="modal" type="button">
							<span class="fa fa-remove" aria-hidden="true"></span>
						</button>
						<h4 id="Heading" class="modal-title custom_align"><span class="fa fa-user"></span> </h4>
					</div>
						<div class="modal-body">
							<div class="form-group">
								<label for="userName">User Name</label>
								<input class="form-control" name="userName" id="userName" type="text" placeholder="Mohsin" value="<?php echo $tuser->userName; ?>">
							</div>
							<div class="form-group">
								<label for="userFullName">Full Name</label>
								<input name="userFullName" id="userFullName" class="form-control " type="text" placeholder="Irshad" value="<?php echo $tuser->userFullName; ?>">
							</div>
							<div class="form-group">
								<label for="userEmailAddress"><span class="fa fa-envelope"></span> Email Address</label>
								<input class="form-control" name="userEmailAddress" id="userEmailAddress" placeholder="email@company.com" type="email" value="<?php echo $tuser->userEmailAddress; ?>">
							</div>
							<div class="form-group">
								<label for="userJoinDate"><span class="fa fa-calendar"></span> Created Date</label>
								<input class="form-control" disabled="on" name="userJoinDate" id="userJoinDate" placeholder="email@company.com" type="date" value="<?php echo $tuser->userJoinDate; ?>">
							</div>
						</div>
					<div class="modal-footer ">
						<input type="hidden" name="token" value="<?php echo Token::generate(); ?>" />
						<button class="btn btn-info btn-lg" style="width: 100%;" type="submit">
							<span class="fa fa-check-circle"></span> Update
						</button>
					</div>
				</form>
			</div>
		</div>
	</div>		
	
    
	<!--
		End Edit Panel
	-->
	<div id="delete<?php echo $tuser->id; ?>" class="modal fade" aria-hidden="true" aria-labelledby="edit" role="dialog" tabindex="-1">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button class="close" aria-hidden="true" data-dismiss="modal" type="button">
						<span class="fa fa-remove" aria-hidden="true"></span>
					</button>
                        <h4 id="Heading" class="modal-title custom_align">Delete <?php echo $tuser->userName; ?> user</h4>
				</div>
				<form action="" method="post">
				<div class="modal-body">
					<div class="alert alert-danger">
						<span class="fa fa-warning"></span> Are you sure you want to delete this Record?
					</div>
					<input type="hidden" name="deleteUser" value="<?php echo $tuser->id; ?>" />
				</div>
				<div class="modal-footer ">
					<button class="btn btn-success" type="submit">
						<span class="fa fa-check"></span> Yes
					</button>
					<button class="btn btn-default" data-dismiss="modal" type="button">
						<span class="fa fa-remove"></span> No
					</button>
				</div>
				</form>
			</div>
		</div>
	</div>
	<!--
		End Delete Panel
	-->
<?php
		}
	?>
		<?php include $INC_DIR . "slidebar.php"; ?>
		<?php include $INC_DIR . "footer.php"; ?>
</body>
</html>

