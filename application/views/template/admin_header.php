<!DOCTYPE html>
<?php 
$user_data = $this->session->userdata('logged_in');
// echo '<pre>'; print_r($user_data); die;
?>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?php echo SITE_NAME; ?> | Dashboard</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="<?php echo base_url('assets/bootstrap/css/bootstrap.min.css'); ?>">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
    <!-- DataTables -->
  <link rel="stylesheet" href="<?php echo base_url('assets/plugins/datatables/dataTables.bootstrap.css'); ?>">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo base_url('assets/dist/css/AdminLTE.min.css'); ?>">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="<?php echo base_url('assets/dist/css/skins/_all-skins.min.css'); ?>">
  <!-- iCheck -->
  <link rel="stylesheet" href="<?php echo base_url('assets/plugins/iCheck/flat/blue.css'); ?>">
  <!-- Morris chart -->
  <link rel="stylesheet" href="<?php echo base_url('assets/plugins/morris/morris.css'); ?>">
  <!-- jvectormap -->
  <link rel="stylesheet" href="<?php echo base_url('assets/plugins/jvectormap/jquery-jvectormap-1.2.2.css'); ?>">
  <!-- Date Picker -->
  <!-- <link rel="stylesheet" href="<?php //echo base_url('assets/plugins/datepicker/datepicker3.css'); ?>"> -->
  <!-- Daterange picker -->
  <!-- <link rel="stylesheet" href="<?php //echo base_url('assets/plugins/daterangepicker/daterangepicker.css'); ?>"> -->
  <!-- bootstrap wysihtml5 - text editor -->
  <link rel="stylesheet" href="<?php echo base_url('assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css'); ?>">
  <!-- Datetime Picker -->
  <link rel="stylesheet" href="<?php echo base_url('assets/plugins/datetimepicker/datetimepicker.css'); ?>">
  <!-- MultiSelect CSS -->
  <link rel="stylesheet" href="<?php echo base_url('assets/plugins/multiselect/jquery.multiselect.css'); ?>">

  <!-- Full calender -->
  <link rel="stylesheet" href="<?php echo base_url('assets/plugins/fullcalendar/fullcalendar.min.css'); ?>">
  <!-- ckedito css-->
 <!--  <link rel="stylesheet" href="<?php echo base_url('assets/plugins/ckeditor/samples/css/samples.css');?>">
  <link rel="stylesheet" href="<?php echo base_url('assets/plugins/ckeditor/samples/toolbarconfigurator/lib/codemirror/neo.css'); ?>"> -->
  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
  
  <script src="<?php echo base_url('assets/plugins/jQuery/jquery-2.2.3.min.js'); ?>"></script>
<!-- jQuery UI 1.11.4 -->
<script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.20.1/moment.min.js"></script>
<script src="<?php echo base_url('assets/plugins/fullcalendar/fullcalendar.js'); ?>"></script>
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

  <header class="main-header">
    <!-- Logo -->
    
    <a href="<?php echo base_url('admin'); ?>" class="logo">
    
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>L</b>DA</span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b><?php echo SITE_NAME; ?></b></span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown">
              <img src="<?php echo SHOW_ADMIN_PROFILE_PATH.$user_data['profileimage'] ?>" class="user-image" alt="User Image">
              <span class="hidden-xs"><?php echo $user_data['fullname']; ?></span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <img src="<?php echo SHOW_ADMIN_PROFILE_PATH.$user_data['profileimage'] ?>" class="img-circle" alt="User Image">

                <p>
                  <?php echo $user_data['fullname']; ?>
                  <small>Member since <?php echo date("M. Y", strtotime($user_data['membersince'])); ?></small>
                </p>
              </li>              
              <li class="user-footer">
                <div class="pull-left">
                  <a href="<?php echo BASE_URL.'/user/profile/'.$user_data['id']; ?>" class="btn btn-default btn-flat">Profile</a>
                </div>
                <div class="pull-right">
                  <a href="<?php echo BASE_URL.'/user/logout'; ?>" class="btn btn-default btn-flat">Sign out</a>
                </div>
              </li>
            </ul>
          </li>
          <!-- Control Sidebar Toggle Button -->
          <?php /*<li>
            <a href="javascript:void(0)" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
          </li>*/?>
        </ul>
      </div>
    </nav>
  </header>
  <script type="text/javascript">var BASE_URL = '<?php echo BASE_URL; ?>';</script>
  <script type="text/javascript">var CURRENT_DATE = '<?php echo CURRENT_DATE; ?>';</script>
