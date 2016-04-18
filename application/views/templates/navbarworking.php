<!DOCTYPE HTML>
<html>
<head>
	 <!--Import Google Icon Font-->
      <!--<link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">-->
      <!--Import materialize.css-->
      <link type="text/css" rel="stylesheet" href="css/materialize.min.css"  media="screen,projection"/>

      <!--Let browser know website is optimized for mobile-->
      <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
</head>


<body>  
<nav>
    <div class="nav-wrapper">
    	<!-- Add Strivers logo -->
      	<!--<a class="brand-logo">Register</a>-->
	    <ul id="nav-mobile" class="right hide-on-med-and-down">
	        <li<?php if ($page == 'login') echo ' class="active"'; ?>><a href="./login.php">Login</a></li>
	        <li<?php if ($page == 'register') echo ' class="active"' ?>><a href="./register.php">Register</a></li>
        </ul>
    </div>
  </nav>
<br>
<script type="text/javascript" src="js/jquery-2.1.1.min.js"></script>
<script type="text/javascript" src="js/materialize.min.js"></script>
</body>
</html>
