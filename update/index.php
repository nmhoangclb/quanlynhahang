<?php

error_reporting(E_ALL); //Setting this to E_ALL showed that that cause of not redirecting were few blank lines added in some php files.

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
	 <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta charset="UTF-8">
    <title>POS Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="http://s.codepen.io/assets/libs/modernizr.js" type="text/javascript"></script>
	 <!-- google lato font -->
   <link href='https://fonts.googleapis.com/css?family=Lato:400,700,900,300' rel='stylesheet' type='text/css'>
	<!-- font awesome -->
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
    <!-- normalize & reset style -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/4.0.0/normalize.min.css"  type='text/css'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css"  type='text/css'>
    <!-- Bootstrap Core CSS -->
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet">
    <style media="screen">
    body {
            background: url(../assets/img/login.jpg) no-repeat center center fixed;
            -webkit-background-size: cover;
            -moz-background-size: cover;
            -o-background-size: cover;
            background-size: cover;
				color: #34495e;
				font-family: 'Lato', sans-serif;
         }
			.installmodal-container {
			  padding: 30px;
			  max-width: 700px;
			  width: 100% !important;
			  background-color: #F7F7F7;
			  margin: 0 auto;
			  margin-top: 150px;
			  border-radius: 2px;
			  box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
			  overflow: hidden;
			}
			.modal-backdrop {
				background: none;
			}
			.logo {
				margin-top: 50px;
			}
			.nav-tabs>li.active>a, .nav-tabs>li.active>a:focus, .nav-tabs>li.active>a:hover {
				background: none;
				border: none;
				background-color: #34495E;
				color: white;
				border-radius: 3px;
			}
			.nav-tabs>li>a {
				text-align: center;
			    color: #34495e;
				 font-weight: 400;
				 text-transform: uppercase;
				 border: none;
				 font-size: 18px;
			}
			.nav-tabs>li>a>p {
				font-weight: 500;
				font-size: 10px;
				margin: 0;
				text-transform: capitalize;
			}
			.nav-tabs>li>a:hover {
			   background: none;
				border: none;
			}
			.nav-tabs {
				border: none;
		   }
			.label-success {
					background-color: #1ABC9C;
			}
			.btn-next {
				background-color: #34495E;
				color: white;
				float: right;
			}
			.btn-next:hover {
				background-color: #425c77;
				color: white;
			}
    </style>
  </head>
  <body>
<?php
	require_once('includes/core_class.php');
	require_once('includes/database_class.php');
	$db_config_path = "../application/config/database.php";
	$installPos = "../INSTALL_POS";
?>
<center><img src="../assets/img/logo.png" alt="logo" class="logo"></center>
     <div class="modal fade" id="install-modal" tabindex="-1" role="dialog">
       <div class="modal-dialog">
            <div class="installmodal-container">
<?php
if (is_file($installPos)) {
$step  = isset($_GET['step']) ? $_GET['step'] : '0';
	switch($step){
	default:

	$error = FALSE;
	if(phpversion() < "5.3"){$error = TRUE; $check1 = "<span class='label label-danger'>Your PHP version is ".phpversion()."</span>";}else{$check1 = "<span class='label label-success'>v.".phpversion()."</span>";}
	if(!extension_loaded('mcrypt')){$error = TRUE; $check2 = "<span class='label label-danger'><i class='fa fa-times' aria-hidden='true'></i></span>";}else{$check2 = "<span class='label label-success'><i class='fa fa-check' aria-hidden='true'></i></span>";}
   if(!extension_loaded('mbstring')){$error = TRUE; $check4 = "<span class='label label-danger'><i class='fa fa-times' aria-hidden='true'></i></span>";}else{$check4 = "<span class='label label-success'><i class='fa fa-check' aria-hidden='true'></i></span>";}
	if(!extension_loaded('mysqli')){$error = TRUE; $check12 = "<span class='label label-danger'><i class='fa fa-times' aria-hidden='true'></i></span>";}else{$check12 = "<span class='label label-success'><i class='fa fa-check' aria-hidden='true'></i></span>";}
	if(!extension_loaded('gd')){$check5 = "<span class='label label-danger'><i class='fa fa-times' aria-hidden='true'></i></span>";}else{$check5 = "<span class='label label-success'><i class='fa fa-check' aria-hidden='true'></i></span>";}
	if(!extension_loaded('pdo')){$error = TRUE; $check6 = "<span class='label label-danger'><i class='fa fa-times' aria-hidden='true'></i></span>";}else{$check6 = "<span class='label label-success'><i class='fa fa-check' aria-hidden='true'></i></span>";}
	if(!extension_loaded('dom')){$check7 = "<span class='label label-danger'><i class='fa fa-times' aria-hidden='true'></i></span>";}else{$check7 = "<span class='label label-success'><i class='fa fa-check' aria-hidden='true'></i></span>";}
	if(!extension_loaded('curl')){$error = TRUE; $check8 = "<span class='label label-danger'><i class='fa fa-times' aria-hidden='true'></i></span>";}else{$check8 = "<span class='label label-success'><i class='fa fa-check' aria-hidden='true'></i></span>";}
   if(!is_writeable($db_config_path)){$error = TRUE; $check9 = "<span class='label label-danger'>Please make the application/config/database.php file writable.</span>";}else{$check9 = "<span class='label label-success'><i class='fa fa-check' aria-hidden='true'></i></span>";}
	if(!is_writeable("../files")){$check10 = "<span class='label label-danger'>files folder is not writeable!</span>";}else{$check10 = "<span class='label label-success'><i class='fa fa-check' aria-hidden='true'></i></span>";}
	if(ini_get('allow_url_fopen') != "1"){$check11 = "<span class='label label-warning'>Allow_url_fopen is not enabled!</span>";}else{$check11 = "<span class='label label-success'><i class='fa fa-check' aria-hidden='true'></i></span>";}

?>
					<ul class="nav nav-tabs">
		            <li class="active"><a>Checklist<p>Pre-update Checklist</p></a></li>
						<li class=""><a>Database<p>Database Config</p></a></li>
		            <li class=""><a>Done<p>success !</p></a></li>
		         </ul>
				<div class="tab-content">
	            <div class="tab-pane fade in active" id="Checklist">
						<h3>Pre-update Checklist</h3>
			          <table class="table table-striped">
					      <thead><tr><th>Requirement</th><th>Result</th></tr></thead>
					      <tbody>
								<tr><td>PHP 5.3+ </td><td><?php echo $check1; ?></td></tr>
								<tr><td>GD PHP extension</td><td><?php echo $check5; ?></td></tr>
								<tr><td>Mysqli PHP extension</td><td><?php echo $check12; ?></td></tr>
								<tr><td>Mcrypt PHP extension</td><td><?php echo $check2; ?></td></tr>
								<tr><td>MBString PHP extension</td><td><?php echo $check4; ?></td></tr>
								<tr><td>DOM PHP extension</td><td><?php echo $check7; ?></td></tr>
								<tr><td>files folder is writeable</td><td><?php echo $check10; ?></td></tr>
								<tr><td>PDO PHP extension</td><td><?php echo $check6; ?></td></tr>
								<tr><td>CURL PHP extension</td><td><?php echo $check8; ?></td></tr>
								<tr><td>Allow_url_fopen is enabled!</td><td><?php echo $check11; ?></td></tr>
								<tr><td>Database file (database.php) writeable</td><td><?php echo $check9; ?></td></tr>
					      </tbody>
					    </table>
						 <form method="get"><input type="hidden" name="step" value="1" />
				 	 	<button type="submit" class="btn btn-next <?=$error ? 'disabled' : '';?>" href="">next ></button>
					</form>
					</div>
<?php
	break;
	case "1": ?>
	<ul class="nav nav-tabs">
		<li class=""><a>Checklist<p>Pre-update Checklist</p></a></li>
		<li class="active"><a>Database<p>Database Config</p></a></li>
		<li class=""><a>Done<p>success !</p></a></li>
	</ul>
<div class="tab-content">
					<div class="tab-pane fade in active" id="Database">


							 <form id="install_form" method="post" action="?step=1">
							 <fieldset>
								<legend style="padding-top:20px">Database settings</legend>
								<p style="padding:3px;border: 1px solid #1ABC9C; border-radius:2px;color:#1ABC9C">If the database does not exist the system will try to create it.</p>
								<?php
								$hide = '';
								 	if($_POST) {
												// Load the classes and create the new objects
												$core = new Core();
												$database = new Database();
												// Validate the post data
												if($core->validate_post($_POST) == true)
												{
													// First create the database, then create tables, then write config file
													if ($database->create_tables($_POST) == false) {
														echo "<p style='color:#ED5565'>The database tables could not be updated, please verify your settings.</p>";
														$error = 1;
													}
													// If no errors, redirect to registration page
													if(!isset($error)) {
														echo '<a href="index.php?step=2" class="label label-success" style="float:right;font-size:20px;"> success go to the next step </a>';
														$hide = 'hide';
													}
												}
											}?>
								<div class="form-group <?=$hide;?>">
									<label for="hostname">Hostname</label>
									<input type="text" required id="hostname" class="form-control" name="hostname" />
								</div>
								<div class="form-group <?=$hide;?>">
									<label for="username">Username</label>
									<input type="text" required id="username" class="form-control" name="username" />
								</div>
								<div class="form-group <?=$hide;?>">
									<label for="password">Password</label>
									<input type="password" id="password" class="form-control" name="password" />
								</div>
								<div class="form-group <?=$hide;?>">
									<label for="database">Database Name</label>
									<input type="text" required id="database" class="form-control" name="database" />
								</div>
									<input type="submit" class="btn btn-next <?=$hide;?>" value="Install" id="submit" />
							 </fieldset>
							 </form>

					</div>
<?php
	break;
	case "2": ?>
	<ul class="nav nav-tabs">
		<li class=""><a>Checklist<p>Pre-update Checklist</p></a></li>
		<li class=""><a>Database<p>Database Config</p></a></li>
		<li class="active"><a>Done<p>success !</p></a></li>
	</ul>
<div class="tab-content">
					<div class="tab-pane fade in active" id="Done">
						<?php
							$domain = "http://".$_SERVER["SERVER_NAME"].substr($_SERVER["REQUEST_URI"], 0, -24);
							$core = new Core();
							$core->write_config($domain);
							?>
						<h1>Update completed!</h1>
						<a href="<?php echo "http://".$_SERVER["SERVER_NAME"].substr($_SERVER["REQUEST_URI"], 0, -24); ?>" class="btn btn-next">Go to Login</a>
					</div>
            </div>
				<?php } ?>
				<?php }else{ ?>
					<div class="tab-content">
						<h1><i class="fa fa-lock" aria-hidden="true" style="margin-right:10px"></i>Installation Locked!</h1>
				<?php } ?>
         </div>
       </div>

      <!-- jQuery -->
      <script type="text/javascript" src="https://code.jquery.com/jquery-2.2.2.min.js"></script>
      <!-- waves material design effect -->
      <script type="text/javascript" src="../assets/js/waves.min.js"></script>
      <!-- Bootstrap Core JavaScript -->
      <script type="text/javascript" src="../assets/js/bootstrap.min.js"></script>

      <script type="text/javascript">
      $(document).ready(function() {
         $('#install-modal').modal('show').on('hide.bs.modal', function (e) {
            e.preventDefault();
         });
      });
		var currency = document.getElementById("Currency");

		function validatecurrency(){
		  if(currency.value.length < 3) {
		    currency.setCustomValidity("The Currency code must be at least 3 characters length");
		  } else {
		    currency.setCustomValidity('');
		  }
		}
		if(currency) currency.onchange = validatecurrency;
      </script>
   </body>
</html>
