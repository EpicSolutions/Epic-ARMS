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
<link href="css/reset.css" rel="stylesheet" type="text/css">
<link href="css/mainStyle.css" rel="stylesheet" type="text/css">
<link href="css/gps.css" rel="stylesheet" type="text/css">
<link href="css/SpryMenuBarHorizontal.css" rel="stylesheet" type="text/css">
<script type="text/javascript" 
	src="http://maps.googleapis.com/maps/api/js?key=AIzaSyAoFybZX6NkgG5g0kd7HPLprhlIX8nQRMI&sensor=false">
</script>
<script src="js/SpryMenuBar.js" type="text/javascript"></script>
<script type="text/javascript" src="js/jquery-1.6.2.min.js"></script>
<script type="text/javascript" src="js/jquery-latest.js"></script>
<script type="text/javascript" src="js/jquery.livequery.js"></script>
<script type="text/javascript" src="js/jquery.tablesorter.min.js"></script>
<script type="text/javascript" src="js/jquery-ui-1.8.16.custom.min.js"></script>
<script type="text/javascript" src="js/jquery-fallr-1.2.js"></script>
<script type="text/javascript" src="js/adjustHeight.js"></script>
<script type="text/javascript" src="js/gmap/jquery-ui-map.js"></script>
<script type="text/javascript" src="js/truckStop.js"></script>
<script type="text/javascript" src="js/map.js"></script>
<style>
<!--
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

	<!-- Nav menu -->
   	<?php include_once('nav.phtml'); ?>
    <br /><br />
  
</div><!-- end #insideContainer -->
</div><!-- end #outsideContainer -->

<div class="controlHolder">
<div class="control">
</div>
</div>
<div class="mapHolder">
<div class="map">
</div>
</div>
      
</div><!-- end #wrapper -->

<div class="footer">
	<p>Powered by Epic Solutions</p>
</div><!-- end .footer -->
<script type="text/javascript">
var MenuBar = new Spry.Widget.MenuBar("MenuBar", {imgDown:"SpryAssets/SpryMenuBarDownHover.gif", imgRight:"SpryAssets/SpryMenuBarRightHover.gif"});
</script>
</body>
</html>