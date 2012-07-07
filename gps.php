<?php
/**** Includes ****/
// Connect to Database
require_once('php/connect_to_mysql.php');

/**** Session Parameters ****/
// Start Session
session_start();
$site = $_SESSION['site'];

if($_SESSION['tracking'] != 'checked="checked"')
{
	header("Location: restricted.php");
}
else
{	
	// Set previous url
	$_SESSION['previous'] = $_SERVER['PHP_SELF'];
	
	// Set local variables
	$uName 		 = $_SESSION['uName'];
	$lastLogin 	 = $_SESSION['lastLogin'];
	$tracking    = $_SESSION['tracking'];
	$routes 	 = $_SESSION['routes'];
	$reports 	 = $_SESSION['reports'];
	$admin 		 = $_SESSION['admin'];
	$addedBy 	 = $_SESSION['addedBy'];
	$changedBy   = $_SESSION['lastChangedBy'];
	$dateChanged = $_SESSION['dateChanged'];
		
	// Check if logged in	
	if(!(isset($_SESSION['uName'])) || $_SESSION['logout'] == true)
	{
		session_destroy();
	header("Location: index.php");
	}
	else
	{	 
		$news = file('news.txt');
		$newsDate = $news[0];
		$newsMessage = $news[1];
	}
}
?>
<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>ARMS - GPS Tracking</title>
<link href="css/mainStyle.css" rel="stylesheet" type="text/css">
<link href="css/SpryMenuBarHorizontal.css" rel="stylesheet" type="text/css">
<script src="js/SpryMenuBar.js" type="text/javascript"></script>
<script type="text/javascript" 
	src="http://maps.googleapis.com/maps/api/js?key=AIzaSyAoFybZX6NkgG5g0kd7HPLprhlIX8nQRMI&sensor=false">
</script>
<style>
<!--
.control {
	width: 30%;
	height: auto;
	border: 1px solid black;	
	float: left;
}

.map {
	width: auto;
	height: auto;
	border: 1px solid red;	
	float: left;
}

-->
</style>
</head>

<body>
<div id="wrapper">

<div class="header">
    <a id="logo" alt="" href="index.php"><img id="logo" alt="Logo" src="<?php echo $site; ?>/images/logo.jpg" /></a>
	  
</div><!-- end .header -->

<div id="outsideContainer">
<div id="insideContainer">

	<ul id="MenuBar" class="MenuBarHorizontal">
	  <li id="routeMenu"><a id="routeButton" class="MenuBarItemSubmenu" href="routes.php"></a></li>
	  <li id="driverMenu"><a id="driverButton" href="drivers.php"></a>
      <ul>
	      <li><a href="managedrivers.php">Manage Drivers</a></li>
	      <li><a href="assigndrivers.php">Assign Drivers</a></li>
      </ul>
      </li>
	  <li id="operatorMenu"><a id="operatorButton" class="MenuBarItemSubmenu" href="operators.php"></a>
	  <ul><li><a href="manageusers.php">Manage Users</a></li>
	      <li><a href="mailinglist.php">Maintain Mailing List</a></li>
          <li><a href="callin.php">Schedule Call-In</a></li>
          <li><a href="managecalls.php">Manage Calls</a></li>
	      <li><a href="addcustomer.php">Add Customer</a></li>
	      <li><a href="routeresults.php">Route Results</a></li>
      </ul>
      </li>
	  <li id="gpsMenu"><a id="gpsButton" href=""></a></li>
  	</ul>
    <br /><br />
  
</div><!-- end #insideContainer -->
</div><!-- end #outsideContainer -->

<div class="control">
</div>
<div class="map">
</div>
      
</div><!-- end #wrapper -->

<div id="push"></div>

<div class="footer">
	<p>Powered by Epic Solutions</p>
</div><!-- end .footer -->
<script type="text/javascript">
var MenuBar = new Spry.Widget.MenuBar("MenuBar", {imgDown:"SpryAssets/SpryMenuBarDownHover.gif", imgRight:"SpryAssets/SpryMenuBarRightHover.gif"});
</script>
</body>
</html>