<?php
/**** Session Parameters ****/
// Start Session
session_start();
$site = $_SESSION['site'];

/**** Includes ****/
// Connect to Database
require_once("$site/php/connect_to_mysql.php");

if($_SESSION['routes'] != 'checked="checked"')
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
<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>ARMS - Scheduled Routes</title>
<link href="css/mainStyle.css" rel="stylesheet" type="text/css">
<link href="css/SpryMenuBarHorizontal.css" rel="stylesheet" type="text/css">
<link type="text/css" href="css/jquery-ui-1.8.16.custom.css" rel="Stylesheet" />
<link href="css/jquery.alerts.css" rel="stylesheet" type="text/css" media="screen" />
<link href="css/tableStyle.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" media="screen,projection" href="css/jquery-fallr-1.0.css" />
<script type="text/javascript" src="js/jquery-1.6.2.min.js"></script>
<script type="text/javascript" src="js/jquery-latest.js"></script>
<script type="text/javascript" src="js/jquery.livequery.js"></script>
<script type="text/javascript" src="js/jquery.tablesorter.min.js"></script>
<script type="text/javascript" src="js/jquery-ui-1.8.16.custom.min.js"></script>
<script type="text/javascript" src="js/jquery-fallr-1.2.js"></script>
<script src="js/SpryMenuBar.js" type="text/javascript"></script>
<script src="js/datePicker.js" type="text/javascript"></script>
<script src="js/routes.js" type="text/javascript"></script>
</head>

<body>
<div id="wrapper">

<div class="header">
    <a id="logo" alt="" href="index.php"><img id="logo" alt="Logo" src="<?php echo $site; ?>/images/logo.jpg" /></a>
	  
</div><!-- end .header -->
  
<div class="sidebar">
	
    <img src="images/redGradient.png" />

    <h2 style="font-size: 11pt;">Welcome, <? echo $uName; ?>!</h2>
    <p id="logout">
    	<a style="color: blue;" href="change.php">Change Password</a>
    	<a style="color: blue;" href="logout.php">Logout</a>
   	</p>
    <p></p>
    <p>Last login: <? echo $lastLogin; ?></p>
    <p></p>
    
    <hr />
    
    <h2>Current News</h2>
    <p style="font-size: 12px; font-weight: bold;"><?php echo $newsDate; ?></p>
    <p style="overflow: auto;"><?php echo $newsMessage; ?></p>
</div><!-- end .sidebar -->

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
	  <li id="gpsMenu"><a id="gpsButton" href="gps.php"></a></li>
  	</ul>
    <br /><br />
  	
    <div id="content">
        <p class="indent">To view the scheduled route for a date, select the date by clicking in the field below.</p>
        
        <p class="indent">Date for Routes: 
            <input class="datePicker" type="text" name="datePicker" />
            <input type="radio" name="viewType" id="viewType" value="day">By Day
            <input type="radio" name="viewType" id="viewType" value="week">By Week
        </p>
        
        <h3 id="addRoute"><a href="addscheduledroute.php">Add Route</a></h3>
        
        <div class="tableHolder">
            <table id="scheduledTable" class="tablesorter">
            <thead>
            <tr>
                <th>Date</th>
                <th>Route</th>
                <th>Location</th>
                <th>Cards</th>
                <th>Calls</th>
                <th></th>
                <th></th>
            </tr>
            </thead>
            <tbody>  
            </tbody>
            </table>
        </div><!-- end .tableHolder" -->
	</div><!-- end .content -->
</div><!-- end #insideContainer -->
</div><!-- end #outsideContainer -->
      
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