<?php
session_start();

if(isset($_SESSION['logout']) && $_SESSION['logout'] == true)
	session_destroy();
	
if(isset($_POST['uName']) && isset($_POST['pass']))
{
	$uName = strtolower($_POST['uName']);
	$pass = $_POST['pass'];
	
	if (($uName == 'sean' || $uName == 'rick') && ($pass == 'pass'))
		{
			$_SESSION['uName'] = ucfirst($uName);
			$_SESSION['pass'] = $pass;
		}
}

// Initialize login variable
if(isset($_SESSION['uName'])){
	$login = '<h2>Welcome, ' . $_SESSION["uName"] . '</h2>'
		   . '<a id="logout" href="index.php">Logout</a>';
	$_SESSION['logout'] = true;
} else{
	$login = '<form id="loginForm" method="post" action="index.php">'
			. '<fieldset>'
			. '<legend>Login</legend>'
			. '<label>Username: <input id="uName" name="uName" type="text" /></label>'
			. 	'<label>Password: <input id="pass" name="pass" type="password" /></label>'
			. 	'<input id="loginSubmit" name="loginSubmit" type="submit" value="Go" />'
			. '</fieldset>'
		   . '</form>';
}

?>
<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>ARMS</title>
<link href="css/mainStyle.css" rel="stylesheet" type="text/css">
<link href="css/SpryMenuBarHorizontal.css" rel="stylesheet" type="text/css">
<script src="js/SpryMenuBar.js" type="text/javascript"></script>

</head>

<body>

<div class="header">
    <a id="logo" alt="" href="index.php"><img id="logo" alt="Logo" src="images/logo.jpg" /></a>
    
    <div id="rightHeader">
    	<div id="login"><?php echo $login; ?></div><!-- end #login -->
    </div><!-- end #rightHeader --> 
    
</div><!-- end .header -->
  
<div class="sidebar">
	
    <img src="images/redGradient.png" />

    <h2>Welcome</h2>
    <p></p>
    <p>Last login:</p>
    <p></p>
    
    <hr />
    
    <h2>Current News</h2>
    <p style="font: 12px bold;">Monday, Oct 1</p>
    <p>Today we are offering a special deal on something important.</p>
</div><!-- end .sidebar1 -->

<div id="outsideContainer">
<div id="insideContainer">

	<ul id="MenuBar" class="MenuBarHorizontal">
	<li id="routeMenu"><a id="routeButton" class="MenuBarItemSubmenu" href="routes.php"></a>
	  <ul>
	      <li><a href="scheduledroutes.php">Scheduled<br />Routes</a></li>
	      <li><a href="viewspecialroutes.php">View Special Routes</a></li>
	      <li><a href="managespecialroutes.php">Manage Special Routes</a></li>
      </ul>
      </li>
	  <li id="driverMenu"><a id="driverButton" href="drivers.php"></a>
      <ul>
	      <li><a href="managedrivers.php">Manage Drivers</a></li>
	      <li><a href="assigndrivers.php">Assign Drivers</a></li>
      </ul>
      </li>
	  <li id="operatorMenu"><a id="operatorButton" class="MenuBarItemSubmenu" href="operators.php"></a>
	  <ul>
	      <li><a href="manageusers.php">Manage Users</a></li>
	      <li><a href="mailinglist.php">Maintain Mailing List</a></li>
	      <li><a href="callreport.php">Create Call Report</a></li>
          <li><a href="callin.php">Schedule Call-In</a></li>
	      <li><a href="addcustomer.php">Add Customer</a></li>
	      <li><a href="routeresults.php">Route Results</a></li>
      </ul>
      </li>
	  <li id="gpsMenu"><a id="gpsButton" href="gps.php"></a></li>
  	</ul>
    </li>
    </ul>
    <br /><br />
  
	<div class="content">
    	<h1 style="text-align: center;"><img id="mainImage" alt="The Arc" src="images/arcImage.jpg" /></h1>
        
	</div><!-- end .content -->
</div><!-- end #insideContainer -->
</div><!-- end #outsideContainer -->
      
<div class="footer">
	<p>Powered by Epic Solutions</p>
<!-- end .footer --></div>
<script type="text/javascript">
var MenuBar = new Spry.Widget.MenuBar("MenuBar", {imgDown:"SpryAssets/SpryMenuBarDownHover.gif", imgRight:"SpryAssets/SpryMenuBarRightHover.gif"});
</script>
</body>
</html>