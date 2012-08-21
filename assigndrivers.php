<?php
/**** Includes ****/
// Connect to Database
require_once('php/connect_to_mysql.php');

/**** Session Parameters ****/
// Start Session
session_start();
$site = $_SESSION['site'];

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
?>
<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>ARMS - Assign Drivers</title>
<?php require_once('head.phtml'); ?>
<script src="js/assignDrivers.js" type="text/javascript"></script>
<style>
<!--
#editDriver
{
	font-size: 14pt;	
}

#editDriver label
{
	display: block;
	font-size: 14pt;
}

#editDriver select
{
	font-size: 12pt;
	width: 180px;
	height: 20px;
	float: right;
	margin-right: 25px;	
}
-->
</style>
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
	
    <!-- Nav menu -->
   	<?php include_once('nav.phtml'); ?>
    <br /><br />
  	
    <div id="content">
        <p class="indent">To assign drivers first select a date to view schedule routes for that date.</p>
        
        <p class="indent">Date for Routes: 
            <input class="datePicker" type="text" name="datePicker" />
        </p>
        
        <div class="tableHolder">
            <table id="scheduledTable" class="tablesorter">
            <thead>
            <tr>
                <th>Date</th>
                <th>Route</th>
                <th>Driver</th>
                <th>Helper</th>
                <th>Stops</th>
                <th>Change Driver</th>
            </tr>
            </thead>
            <tbody>  
            </tbody>
            </table>
        </div><!-- end .tableHolder" -->
	</div><!-- end #content -->
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