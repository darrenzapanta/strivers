<!DOCTYPE HTML>
<html>
<head>
   <!--Import Google Icon Font-->
      <!--<link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">-->
      <!--Import materialize.css-->
      <link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>css/materialize.min.css"  media="screen,projection"/>
      <script type="text/javascript" src="<?php echo base_url();?>js/jquery-2.1.1.min.js"></script>
      <script type="text/javascript" src="<?php echo base_url();?>js/materialize.min.js"></script>
      <!--Let browser know website is optimized for mobile-->
      <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
      <style>
        .side-nav.fixed {
          left: 0;
          top: 64px;
          position: fixed;
        }
        <?php 
          if ($page == 'viewtransaction') {
            echo '.viewtrans { padding-left: 240px;}';
          }

        ?>
      .container {
          padding-left: 240px;
        }

        @media only screen and (max-width : 992px) {
          header, main, footer {
            padding-left: 0;
          }
        }
      </style>
      <meta name="viewport" content="width=device-width, initial-scale=1.0"/>      
</head>


<body>  
<nav>
    <div class="nav-wrapper">
      <!-- Add Strivers logo -->
        <!--<a class="brand-logo">Register</a>-->
      <ul id="nav-mobile" class="right hide-on-med-and-down">
          <li<?php if ($page == 'login') echo ' class="active"'; ?>><a href="./login">Login</a></li>
          <!--<li<?php if ($page == 'register') echo ' class="active"' ?>><a href="./register">Register</a></li>-->
          <li<?php if ($page == 'register') echo ' class="active"' ?>><a href="<?php echo site_url(); ?>/logoutController";>Logout</a></li>
        </ul>
    </div>
  </nav>
<br>

<ul id="slide-out" class="side-nav fixed">
    <li<?php if ($page == 'search') echo ' class="active"'; ?>>
      <!--<a href="<?php echo site_url(); ?>/landingController/search">Search</a>-->
      <a href="<?php echo site_url(); ?>landingController/searchTransaction">Searching</a>
    </li>
    <li<?php if ($page == 'adddss') echo ' class="active"'; ?>>
      <a href="<?php echo site_url(); ?>landingController/addDSS">Add DSS</a>
    </li>
    <li<?php if ($page == 'viewdss') echo ' class="active"'; ?>>
      <a href="<?php echo site_url(); ?>landingController/viewDSS">View DSS</a>
    </li>
    <li class="no-padding">
      <ul class="collapsible collapsible-accordion">
        <li>
          <!--<a class="collapsible-header active">Manage DSPs</a>-->
          <a class=<?php echo '"collapsible-header'; if ($page == 'adddsp' || $page == 'editdsp') echo ' active"'; else echo '"'; ?>>Manage DSPs</a>
          <div class="collapsible-body">
            <ul>
              <li<?php if ($page == 'adddsp') echo ' class="active"'; ?>><a href="<?php echo site_url(); ?>landingController/addDSP";>Add DSP</a></li>
              <li<?php if ($page == 'editdsp') echo ' class="active"'; ?>><a href="<?php echo site_url(); ?>landingController/editDSP">Edit/View DSP</a></li>
            </ul>
          </div>
        </li>
        </ul>
      </li>
      <li class="no-padding">
        <ul class="collapsible collapsible-accordion">
          <li>
            <a class=<?php echo '"collapsible-header'; if ($page == 'viewtransaction' || $page == 'addtransaction') echo ' active"'; else echo '"'; ?>>Manage Transactions</a>
            <div class="collapsible-body">
              <ul>
                <li<?php if ($page == 'addtransaction') echo ' class="active"'; ?>><a href="<?php echo site_url(); ?>landingController/addTransaction";>Add Transaction</a></li>
                <li<?php if ($page == 'viewtransaction') echo ' class="active"'; ?>><a href="<?php echo site_url(); ?>landingController/viewTransaction">Edit/View Transactions</a></li>
              </ul>
            </div>
          </li>
        </ul>
      </li>
      </ul>
    </li>
    
  </ul>
<br>



