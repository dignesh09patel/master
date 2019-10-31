<html>
	<head>
	<title>Login Form</title>
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/style.css">
	<link href='http://fonts.googleapis.com/css?family=Source+Sans+Pro|Open+Sans+Condensed:300|Raleway' rel='stylesheet' type='text/css'>
	</head>
	<body>
		<div id="main">
			<div id="login">
				<h2>Login Form</h2>
				<hr/>
				<?php
				  if ($this->session->flashdata('messg') != '') {
				?>
				  <div>
					<span class="glyphicon glyphicon-info-sign"></span> <?php echo $this->session->flashdata('messg'); ?>
				  </div>
				<?php
				  }
				?>
				<?php echo form_open('admin/login/admin_login'); ?>
					<label>UserName :</label>
						<input type="text" class="form-control" name="username" placeholder="Username" />
						<span><?php echo form_error('username'); ?></span>
						<i class="ace-icon fa fa-user"></i>
					<label>Password :</label>
					<input type="password" class="form-control" name="password" placeholder="Password" />
					<span><?php echo form_error('password'); ?></span>
					<div class="clearfix">
						<button type="submit" class="width-35 pull-right btn btn-sm btn-primary">
							<i class="ace-icon fa fa-key"></i>
							<span class="bigger-110">Login</span>
						</button>
					</div>
				<?php echo form_close(); ?>
			</div>
		</div>
	</body>
</html>
