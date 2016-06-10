<!DOCTYPE html>
<html lang="en">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <!-- Meta, title, CSS, favicons, etc. -->
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>STRIVERS </title>

  <!-- Bootstrap core CSS -->

  <link href="<?php echo base_url(); ?>css/bootstrap.min.css" rel="stylesheet">


  <link href="<?php echo base_url(); ?>fonts/css/font-awesome.min.css" rel="stylesheet">
  <link href="<?php echo base_url(); ?>css/animate.min.css" rel="stylesheet">
  <link href="<?php echo base_url(); ?>js/datatables/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />

  <!-- Custom styling plus plugins -->
  <link href="<?php echo base_url(); ?>css/custom.css" rel="stylesheet">
  <link rel="stylesheet" type="<?php echo base_url(); ?>text/css" href="css/maps/jquery-jvectormap-2.0.3.css" />
  <link href="<?php echo base_url(); ?>css/icheck/flat/green.css" rel="stylesheet" />
  <link href="<?php echo base_url(); ?>css/floatexamples.css" rel="stylesheet" type="text/css" />
    <!-- editor -->
  <link href="<?php echo base_url(); ?>css/editor/external/google-code-prettify/prettify.css" rel="stylesheet">
  <link href="<?php echo base_url(); ?>css/editor/index.css" rel="stylesheet">
  <!-- select2 -->
  <link href="<?php echo base_url(); ?>css/select/select2.min.css" rel="stylesheet">
  <!-- switchery -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>css/switchery/switchery.min.css" />

  <script src="<?php echo base_url(); ?>js/jquery.min.js"></script>
  <script src="<?php echo base_url(); ?>js/nprogress.js"></script>
  <script src="<?php echo base_url(); ?>js/bootstrap.min.js"></script>
  <script src="<?php echo base_url(); ?>js/custom.js"></script>

  <!--[if lt IE 9]>
        <script src="../assets/js/ie8-responsive-file-warning.js"></script>
        <![endif]-->

  <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
  <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
          <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->

</head>


<body class="nav-md">

  <div class="container body">


    <div class="main_container">

      <div class="col-md-3 left_col">
        <div class="left_col scroll-view">

          <div class="navbar nav_title" style="border: 0;">
            <a href="index.html" class="site_title"><img src="<?php echo base_url(); ?>images/strivers-small.png"> <span>STRIVERS!</span></a>
          </div>
          <div class="clearfix"></div>

          <!-- menu prile quick info -->
          <div class="profile">
            <div class="profile_info">
              <span>Welcome,</span>
              <h2><?php echo $name; ?></h2>
            </div>
          </div>
          <!-- /menu prile quick info -->

          <br />
          <br />
          <br />
          <br />


          <!-- sidebar menu -->
          <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">

            <div class="menu_section">
              <h3>General</h3>
              <ul class="nav side-menu">
                <li><a><i class="fa fa-home"></i> Home <span class="fa fa-chevron-down"></span></a>
                  <ul class="nav child_menu" style="display: none">
                    <li><a href="<?php echo site_url(); ?>LandingController">Dashboard</a>
                    </li>
                </li>
              </ul>
              <?php if($this->ion_auth->in_group(array(1,2,4)) == TRUE): ?>
                <li><a><i class="fa fa-edit"></i> Manage Area Manager <span class="fa fa-chevron-down"></span></a>
                  <ul class="nav child_menu" style="display: none">
                    <li><a href="<?php echo site_url(); ?>LandingController/addAM">Add Area Manager</a>
                    </li>
                    <li><a href="<?php echo site_url(); ?>LandingController/viewAM">Edit/Delete Area Manager</a>
                    </li>
                  </ul>
                </li>
                <li><a><i class="fa fa-desktop"></i> Manage DSP <span class="fa fa-chevron-down"></span></a>
                  <ul class="nav child_menu" style="display: none">
                    <li><a href="<?php echo site_url(); ?>LandingController/addDSP">Add DSP</a>
                    </li>
                    <li><a href="<?php echo site_url(); ?>LandingController/editDSP">Edit/Delete DSP</a>
                    </li>
                  </ul>
                </li>
              <?php endif; ?>  
              <?php if($this->ion_auth->in_group(array(1,2,4)) == TRUE): ?>
                <li><a><i class="fa fa-table"></i> Manage Transactions <span class="fa fa-chevron-down"></span></a>
                  <ul class="nav child_menu" style="display: none">
<!--                     <li><a href="<?php echo site_url(); ?>LandingController/addPaymentAM">Add Payment (AM)</a>
                    </li> -->
                  
                    <li><a href="<?php echo site_url(); ?>LandingController/addPaymentUN">Add Payment</a>
                    </li>
                    <li><a href="<?php echo site_url(); ?>LandingController/addTransaction">Add Load Transaction</a>
                    </li>
                  <?php endif; ?>    
                  <?php if($this->ion_auth->in_group(array(1,2,3,4)) == TRUE): ?>
                    <li><a href="<?php echo site_url(); ?>LandingController/viewTransactionAM">View/Delete Payment (AM)</a>
                    </li>
                    <li><a href="<?php echo site_url(); ?>LandingController/viewTransactionUN">View/Delete Payment (UN)</a>
                    </li>
                    <li><a href="<?php echo site_url(); ?>LandingController/viewTransaction">View/Delete Transactions</a>
                    </li>
                  
                  </ul>
                </li>
              <?php endif; ?>    
                <?php if($this->ion_auth->in_group(array(1,2,4)) == TRUE): ?>
                <li><a><i class="fa fa-list"></i> Manage P . O . <span class="fa fa-chevron-down"></span></a>
                  <ul class="nav child_menu" style="display: none">
                    <li><a href="<?php echo site_url(); ?>LandingController/addPurchaseOrder">Add Purchase Order</a>
                    </li>
                    <li><a href="<?php echo site_url(); ?>LandingController/viewPurchaseOrder">View/Delete Purchase Order</a>
                    </li>
                  </ul>
                </li>
                <?php endif; ?>   
                <?php if($this->ion_auth->in_group(array(1,2,5)) == TRUE): ?>
                <li><a><i class="fa fa-list"></i> Inventory <span class="fa fa-chevron-down"></span></a>
                  <ul class="nav child_menu" style="display: none">
                    <li><a href="<?php echo site_url(); ?>LandingController/addInventoryItem">Add Item</a>
                    </li>
                    <li><a href="<?php echo site_url(); ?>LandingController/viewInventoryItems">View Items</a>
                    </li>
                    <li><a href="<?php echo site_url(); ?>LandingController/addInventoryPurchase">Inventory Purchase</a>
                    </li>
                    <li><a href="<?php echo site_url(); ?>LandingController/addInventorySales">Inventory Sales</a>
                    </li>
                    <li><a href="<?php echo site_url(); ?>LandingController/addSalesPayment">Add Sales Payment</a>
                    </li>
                    <li><a href="<?php echo site_url(); ?>LandingController/viewInventoryReport">Generate Inventory Report</a>
                    </li>
                    <li><a href="<?php echo site_url(); ?>LandingController/viewSalesTransactions">View Sales Transactions</a>
                    </li>
                    <li><a href="<?php echo site_url(); ?>LandingController/viewPurchaseTransactions">View Purchase Transactions</a>
                    </li>
                  </ul>
                </li>
                <?php endif; ?>
                <?php if($this->ion_auth->in_group('superadmin') == TRUE): ?>
                  <li><a><i class="fa fa-unlock-alt"></i> Admin Panel <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu" style="display: none">
                      <li><a href="<?php echo site_url(); ?>LandingController/addSimCard">Add Sim Card</a>
                      <li><a href="<?php echo site_url(); ?>LandingController/viewSimCard">Manage Sim Cards</a>
                      <li><a href="<?php echo site_url(); ?>LandingController/addUser">Add User</a>
                      </li>
<!--                       <li><a href="<?php echo site_url(); ?>LandingController/deleteUser">Delete User</a>
                      </li> -->
                    </ul>
                  </li>
                <?php endif; ?>  
                </li> 
                <li><a><i class="fa fa-user"></i> Account <span class="fa fa-chevron-down"></span></a>
                  <ul class="nav child_menu" style="display: none">
                    <li><a href="<?php echo site_url(); ?>LandingController/editAccount">Edit Account Information</a>
                    </li>
                  </ul>
                </li>               
              </ul>
            </div>

          </div>
          <!-- /sidebar menu -->

          <!-- /menu footer buttons -->
          <div class="sidebar-footer hidden-small">
            <a data-toggle="tooltip" data-placement="top" title="Logout" href="<?php echo site_url(); ?>/LogoutController">
              <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
            </a>
          </div>
          <!-- /menu footer buttons -->
        </div>
      </div>

      <!-- top navigation -->
      <div class="top_nav">

        <div class="nav_menu">
          <nav class="" role="navigation">
            <div class="nav toggle">
              <a id="menu_toggle"><i class="fa fa-bars"></i></a>
            </div>

            <ul class="nav navbar-nav navbar-right">
              <li class="">
                <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                  <?php echo $name; ?>
                  <span class=" fa fa-angle-down"></span>
                </a>
                <ul class="dropdown-menu dropdown-usermenu pull-right">
                  <li><a href="<?php echo site_url(); ?>LogoutController"><i class="fa fa-sign-out pull-right"></i> Log Out</a>
                  </li>
                </ul>
              </li>

            </ul>
          </nav>
        </div>

      </div>

