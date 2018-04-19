<!DOCTYPE html>
<html >
  <head>
    <meta charset="UTF-8">
    <title>POS Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="http://s.codepen.io/assets/libs/modernizr.js" type="text/javascript"></script>
    <!-- normalize & reset style -->
    <link rel="stylesheet" href="<?=base_url();?>assets/css/normalize.min.css"  type='text/css'>
    <link rel="stylesheet" href="<?=base_url();?>assets/css/reset.min.css"  type='text/css'>
    <!-- Bootstrap Core CSS -->
    <link href="<?=base_url();?>assets/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="<?=base_url()?>assets/css/Style-<?=$this->setting->theme?>.css" rel="stylesheet">
    <!-- favicon -->
    <link rel="shortcut icon" href="<?=base_url();?>/favicon.ico" type="image/x-icon">
    <link rel="icon" href="<?=base_url();?>/favicon.ico" type="image/x-icon">
    <style media="screen">
    body {
            background: url(<?=base_url()?>assets/img/login.jpg) no-repeat center center fixed;
            -webkit-background-size: cover;
            -moz-background-size: cover;
            -o-background-size: cover;
            background-size: cover;
         }
    </style>
  </head>
  <body>
     <div class="modal fade" id="login-modal" tabindex="-1" role="dialog">
       <div class="modal-dialog">
            <div class="loginmodal-container">

               <h1><?=label('Loginaccount');?></h1><br>
               <?php if(isset($message)){echo "<div class='red'>".$message."</div>";}?>
               <?php
              $attributes = array('class' => 'login');
              echo form_open('login', $attributes);
              ?>
               <input type="text" autofocus name="username" value="<?=isset($username)?$username:''?>" placeholder="<?=label("Username");?>" required>
               <input type="password" name="password" placeholder="<?=label("Password");?>" required>
               <?php
                  echo form_submit('submit', label("Login"), "class='login loginmodal-submit'");
               ?>

              <?=form_close()?>

              <div class="login-help">
               &copy; <?=date("Y");?> <?=$this->setting->companyname?>
              </div>
            </div>
         </div>
       </div>




      <!-- jQuery -->
      <script type="text/javascript" src="<?=base_url()?>assets/js/jquery-2.2.2.min.js"></script>
      <!-- waves material design effect -->
      <script type="text/javascript" src="<?=base_url()?>assets/js/waves.min.js"></script>
      <!-- Bootstrap Core JavaScript -->
      <script type="text/javascript" src="<?=base_url()?>assets/js/bootstrap.min.js"></script>

      <script type="text/javascript">
      $(document).ready(function() {
         $('#login-modal').modal('show').on('hide.bs.modal', function (e) {
            e.preventDefault();
         });
      });
      </script>
   </body>
</html>
