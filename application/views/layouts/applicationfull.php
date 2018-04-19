<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <meta name="description" content="">
      <meta name="author" content="">
      <title><?=label('title');?> <?= $this->setting->companyname;?></title>
      <!-- jQuery -->
      <script type="text/javascript" src="<?=base_url()?>assets/js/jquery-2.2.2.min.js"></script>
      <script type="text/javascript" src="<?=base_url()?>assets/js/loading.js"></script>
      <!-- normalize & reset style -->
      <link rel="stylesheet" href="<?=base_url();?>assets/css/normalize.min.css"  type='text/css'>
      <link rel="stylesheet" href="<?=base_url();?>assets/css/reset.min.css"  type='text/css'>
      <link rel="stylesheet" href="<?=base_url();?>assets/css/jquery-ui.css"  type='text/css'>
      <!-- google lato/Kaushan/Pinyon fonts -->
      <link href='https://fonts.googleapis.com/css?family=Lato:400,700,900,300' rel='stylesheet' type='text/css'>
      <link href="https://fonts.googleapis.com/css?family=Kaushan+Script" rel="stylesheet">
      <link href="https://fonts.googleapis.com/css?family=Pinyon+Script" rel="stylesheet">
      <!-- Bootstrap Core CSS -->
      <link href="<?=base_url();?>assets/css/bootstrap.min.css" rel="stylesheet">
      <!-- bootstrap-horizon -->
      <link href="<?=base_url();?>assets/css/bootstrap-horizon.css" rel="stylesheet">
      <!-- datatable style -->
      <link href="<?php echo base_url('assets/datatables/css/dataTables.bootstrap.css')?>" rel="stylesheet">
      <!-- font awesome -->
      <link rel="stylesheet" href="<?=base_url();?>assets/css/font-awesome.min.css">
      <!-- include summernote css-->
      <link href="<?=base_url();?>assets/css/summernote.css" rel="stylesheet">
      <!-- waves -->
      <link rel="stylesheet" href="<?=base_url()?>assets/css/waves.min.css">
      <!-- daterangepicker -->
      <link rel="stylesheet" type="text/css" href="<?=base_url();?>assets/css/daterangepicker.css" />
      <!-- css for the preview keyset extension -->
      <link href="<?=base_url()?>assets/css/keyboard-previewkeyset.css" rel="stylesheet">
      <!-- keyboard widget style -->
      <link href="<?=base_url()?>assets/css/keyboard.css" rel="stylesheet">
      <!-- Select 2 style -->
      <link href="<?=base_url()?>assets/css/select2.min.css" rel="stylesheet">
      <!-- Sweet alert swal -->
      <link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/css/sweetalert.css">
      <!-- datepicker css -->
      <link rel="stylesheet" type="text/css" href="<?=base_url();?>assets/css/bootstrap-datepicker.min.css">
      <!-- Custom CSS -->
      <link href="<?=base_url()?>assets/css/Style-<?=$this->setting->theme?>.css" rel="stylesheet">
      <!-- favicon -->
      <link rel="shortcut icon" href="<?=base_url();?>/favicon.ico?v=2" type="image/x-icon">
      <link rel="icon" href="<?=base_url();?>/favicon.ico?v=2" type="image/x-icon">
      <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
      <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
      <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
      <![endif]-->
   </head>
   <body>
      <!-- Navigation -->
      <nav class="navbar navbar-default navbar-fixed-top" role="navigation">
         <div class="container-fluid">
            <div class="navbar-header">
               <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                 <span class="sr-only">Toggle navigation</span>
                 <span class="icon-bar"></span>
                 <span class="icon-bar"></span>
                 <span class="icon-bar"></span>
               </button>
			</div>
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
               <ul class="nav navbar-nav">
                  <?php if($this->user->role !== "kitchen"){?><li class="flat-box"><a href="<?=base_url();?>"><i class="fa fa-credit-card"></i> <span class="menu-text"><?=label("POS");?></span></a></li><?php } ?>
                  <?php if($this->user->role !== "waiter" && $this->user->role !== "kitchen"){?>
                  <li class="flat-box"><a href="<?=base_url()?>products"><i class="fa fa-archive"></i> <span class="menu-text"><?=label("Product");?></span></a></li>
                 <li class="flat-box"><a href="<?=base_url()?>stores"><i class="fa fa-hospital-o"></i> <span class="menu-text"><?=label("Stores");?></span></a></li>
                 <li class="dropdown">
                    <a href="#" class="dropdown-toggle flat-box" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-users"></i> <span class="menu-text"><?=label("People");?></span> <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                       <li class="flat-box"><a href="<?=base_url()?>waiters"><i class="fa fa-user"></i> <span class="menu-text"><?=label("Waiters");?></span></a></li>
                       <li class="flat-box"><a href="<?=base_url()?>customers"><i class="fa fa-user"></i> <span class="menu-text"><?=label("Customers");?></span></a></li>
                       <li class="flat-box"><a href="<?=base_url()?>suppliers"><i class="fa fa-truck"></i> <span class="menu-text"><?=label("Suppliers");?></span></a></li>
                    </ul>
                 </li>
                 <li class="flat-box"><a href="<?=base_url()?>expences"><i class="fa fa-usd"></i> <span class="menu-text"><?=label("Expense");?></span></a></li>
                 <li class="dropdown">
                    <a href="#" class="dropdown-toggle flat-box" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-bookmark"></i> <span class="menu-text"><?=label("Categories");?> </span><span class="caret"></span></a>
                    <ul class="dropdown-menu">
                       <li class="flat-box"><a href="<?=base_url()?>categories"><i class="fa fa-archive"></i> <span class="menu-text"><?=label("Product");?></span></a></li>
                       <li class="flat-box"><a href="<?=base_url()?>categorie_expences"><i class="fa fa-usd"></i> <span class="menu-text"><?=label("Expense");?></span></a></li>
                    </ul>
                 </li>
                 <?php if($this->user->role === "admin"){?><li class="flat-box"><a href="<?=base_url()?>settings?tab=setting"><i class="fa fa-cogs"></i> <span class="menu-text"><?=label("Setting");?></span></a></li><?php } ?>
               
				 
				 
				 <li class="dropdown">
                    <a href="#" class="dropdown-toggle flat-box" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-users"></i> <span class="menu-text"><?=label("Reports");?></span> <span class="caret"></span></a>
                    <ul class="dropdown-menu">
					 <li class="flat-box"><a href="<?=base_url()?>sales"><i class="fa fa-ticket"></i> <span class="menu-text"><?=label("Sales");?></span></a></li>
                      <li class="flat-box"><a href="<?=base_url()?>stats"><i class="fa fa-line-chart"></i> <span class="menu-text"><?=label("Reports");?></span></a></li>
                    </ul>
                 </li>
				 
				 
				 
                 <?php } ?>
               </ul>
               <ul class="nav navbar-nav navbar-right">
                  <li><a href="">
                        <img class="img-circle topbar-userpic hidden-xs" src="<?=$this->user->avatar ? base_url().'files/Avatars/'.$this->user->avatar : base_url().'assets/img/Avatar.jpg' ?>" width="30px" height="30px">
                        <span class="hidden-xs"> &nbsp;&nbsp;<?php echo $this->user->firstname." ".$this->user->lastname;?> </span>
                     </a>
                  </li>
                  <li class="dropdown language">
                     <a href="#" class="dropdown-toggle flat-box" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                        <img src="<?=base_url();?>assets/img/flags/<?=label('LnImage');?>" class="flag" alt="language">
                        <span class="caret"></span></a>
                     <ul class="dropdown-menu">
                        <li class="flat-box"><a href="<?=base_url()?>dashboard/change/english"><img src="<?=base_url()?>assets/img/flags/en.png" class="flag" alt="language"> English</a></li>
                        <li class="flat-box"><a href="<?=base_url()?>dashboard/change/francais"><img src="<?=base_url()?>assets/img/flags/fr.png" class="flag" alt="language"> Français</a></li>
                        <li class="flat-box"><a href="<?=base_url()?>dashboard/change/portuguese"><img src="<?=base_url()?>assets/img/flags/pr.png" class="flag" alt="language"> Portuguese</a></li>
                        <li class="flat-box"><a href="<?=base_url()?>dashboard/change/spanish"><img src="<?=base_url()?>assets/img/flags/sp.png" class="flag" alt="language"> Spanish</a></li>
                        <li class="flat-box"><a href="<?=base_url()?>dashboard/change/arabic"><img src="<?=base_url()?>assets/img/flags/ar.png" class="flag" alt="language"> العربية</a></li>
                        <li class="flat-box"><a href="<?=base_url()?>dashboard/change/danish"><img src="<?=base_url()?>assets/img/flags/da.png" class="flag" alt="language"> Danish</a></li>
                        <li class="flat-box"><a href="<?=base_url()?>dashboard/change/turkish"><img src="<?=base_url()?>assets/img/flags/tr.png" class="flag" alt="language"> Turkish</a></li>
                        <li class="flat-box"><a href="<?=base_url()?>dashboard/change/greek"><img src="<?=base_url()?>assets/img/flags/gr.png" class="flag" alt="language"> Greek</a></li>
                        <li class="flat-box"><a href="<?=base_url()?>dashboard/change/vietnam"><img src="<?=base_url()?>assets/img/flags/vn.png" class="flag" alt="language"> Vietnam</a></li>
                     </ul>
                  </li>
                  <li class="flat-box"><a href="<?=base_url()?>logout" title="<?=label('LogOut');?>"><i class="fa fa-sign-out fa-lg"></i></a></li>
               </ul>
            </div>
            <div id="loadingimg"></div>
         </div>
         <!-- /.container -->
      </nav>
      <!-- Page Content -->


      <?=$yield?>




      <!-- slim scroll script -->
      <script type="text/javascript" src="<?=base_url()?>assets/js/jquery.slimscroll.min.js"></script>
      <!-- waves material design effect -->
      <script type="text/javascript" src="<?=base_url()?>assets/js/waves.min.js"></script>
      <!-- Bootstrap Core JavaScript -->
      <script type="text/javascript" src="<?=base_url()?>assets/js/bootstrap.min.js"></script>
      <!-- keyboard widget dependencies -->
      <script type="text/javascript" src="<?=base_url()?>assets/js/jquery.keyboard.js"></script>
      <script type="text/javascript" src="<?=base_url()?>assets/js/jquery.keyboard.extension-all.js"></script>
      <script type="text/javascript" src="<?=base_url()?>assets/js/jquery.keyboard.extension-extender.js"></script>
      <script type="text/javascript" src="<?=base_url()?>assets/js/jquery.keyboard.extension-typing.js"></script>
      <script type="text/javascript" src="<?=base_url()?>assets/js/jquery.mousewheel.js"></script>
      <!-- select2 plugin script -->
      <script type="text/javascript" src="<?=base_url()?>assets/js/select2.min.js"></script>
      <!-- dalatable scripts -->
      <script src="<?php echo base_url('assets/datatables/js/jquery.dataTables.min.js')?>"></script>
      <script src="<?php echo base_url('assets/datatables/js/dataTables.bootstrap.js')?>"></script>
      <!-- summernote js -->
      <script src="<?=base_url()?>assets/js/summernote.js"></script>
      <!-- chart.js script -->
      <script src="<?=base_url()?>assets/js/Chart.js"></script>
      <!-- moment JS -->
      <script type="text/javascript" src="<?=base_url()?>assets/js/moment.min.js"></script>
      <!-- Include Date Range Picker -->
      <script type="text/javascript" src="<?=base_url()?>assets/js/daterangepicker.js"></script>
      <!-- Sweet Alert swal -->
      <script src="<?=base_url()?>assets/js/sweetalert.min.js"></script>
      <!-- datepicker script -->
      <script src="<?=base_url()?>assets/js/bootstrap-datepicker.min.js"></script>
      <!-- creditCardValidator script -->
      <script src="<?=base_url()?>assets/js/jquery.creditCardValidator.js"></script>
      <!-- creditCardValidator script -->
      <script src="<?=base_url()?>assets/js/credit-card-scanner.js"></script>
      <script src="<?=base_url()?>assets/js/jquery.redirect.js"></script>
      <!-- ajax form -->
      <script src="<?=base_url()?>assets/js/jquery.form.min.js"></script>
      <!-- custom script -->
      <script src="<?=base_url()?>assets/js/app.js"></script>
   </body>
</html>
