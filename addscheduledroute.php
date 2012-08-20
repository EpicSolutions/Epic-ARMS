<?php
/**** Includes ****/
// Connect to Database
require_once('php/connect_to_mysql.php');

/**** Session Parameters ****/
// Start Session
session_start();
$site = $_SESSION['site'];

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
<title>ARMS - Add Scheduled Route</title>
<link rel="stylesheet" type="text/css" media="screen" href="css/fixedHeader.css" />
<link href="css/mainStyle.css" rel="stylesheet" type="text/css">
<link href="css/SpryMenuBarHorizontal.css" rel="stylesheet" type="text/css">
<link type="text/css" href="css/jquery-ui-1.8.16.custom.css" rel="Stylesheet" />
<link href="css/jquery.alerts.css" rel="stylesheet" type="text/css" media="screen" />
<link href="css/tableStyle.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" media="screen,projection" href="css/jquery-fallr-1.0.css" /> 
<link rel="stylesheet" type="text/css" media="print" href="css/print.css" />
<script type="text/javascript" src="js/jquery-1.6.2.min.js"></script>
<script type="text/javascript" src="js/jquery-latest.js"></script>
<script type="text/javascript" src="js/jquery.livequery.js"></script>
<script type="text/javascript" src="js/cookie.js"></script>
<script type="text/javascript" src="js/dimensions.min.mjs"></script>
<script type="text/javascript" src="js/scrollableFixedTable.js"></script>
<script type="text/javascript" src="js/jquery.tablesorter.min.js"></script>
<script type="text/javascript" src="js/jquery-ui-1.8.16.custom.min.js"></script>
<script type="text/javascript" src="js/jquery-fallr-1.2.js"></script>
<script src="js/SpryMenuBar.js" type="text/javascript"></script>
<script type="text/javascript" src ="js/fixedHead.js"></script>
<script src="js/datePicker.js" type="text/javascript"></script>
<script src="js/addScheduledRoutes.js" type="text/javascript"></script>
<style>
<!--
#addRouteHolder
{
	margin: 0 auto;
	height: 320px;
	width: 98.1%;
	overflow: auto;
	border-bottom: 2px solid #ccc;
}

#addRouteTable
{
	font-size: 8pt;	
}

#addRouteTable td
{
	text-align: center;
	font-size: 8pt;	
}

#days
{
	width=98%;
	margin-bottom: 0;
}

#days a
{
	margin: 0 35px;
	font-size: 20px;
	color: #06F;
}

#days a:hover
{
	color: #39F;	
}

#days span
{
	margin: 0 35px;
	font-size: 20px;
	color: #000;
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

	<?php include_once('nav.phtml'); ?>
    <br /><br />
  	
    <div id="content">
        <p style="text-align: center;">To add routes select a date, check the appropriate boxes, and click "Add Routes."</p>
        
        <p class="center" style="width: 250px; margin-bottom: 15px;">Date for Routes:
            <input size="17" class="datePicker" type="text" name="datePicker" />
        </p>
        
        <p id="days"></p>
        
        <div id="addRouteHolder" class="tableHolder">
            <table id="addRouteTable" class="scrollableFixedHeaderTable tablesorter">
            <thead>
            <tr>
                <th style="width: 33px;">&nbsp;&nbsp;&nbsp;&nbsp;</th>
                <th>Route&nbsp;</th>
                <th>Maps&nbsp;</th>
                <th>&nbsp;Zips</th>
                <th>&nbsp;&nbsp;&nbsp;City&nbsp;&nbsp;&nbsp;</th>
                <th>Cards&nbsp;</th>
                <th>Demographics</th>
                <th>Last Scheduled&nbsp;</th>
                <th>Average Lbs&nbsp;</th>
                <th>History&nbsp;</th>
            </tr>
            </thead>
            <tbody>  
            </tbody>
            </table>
        </div><!-- end .tableHolder" -->
        <a href="" style="color: #009; margin-left: 5px;" id="clear">Clear All</a>
        
        <div id="bottomButtons" style="width: 300px;" class="center">
            <input style="margin-top: 15px; width: 100px;" id="addRoutes" type="submit" value="Add Routes" />
            <input style="margin-top: 15px; width: 170px;" id="back" type="submit" value="Back to Scheduled Routes" />
        </div><!-- End bottomButtons -->
	</div><!-- end #content -->
</div><!-- end #insideContainer -->
</div><!-- end #outsideContainer -->
      
</div><!-- end #wrapper -->

<div id="push"></div>

<div class="footer">
	<p>Powered by Epic Solutions</p>
</div><!-- end .footer -->

<!-- Hidden fields to process PHP in jQuery -->
<input type="hidden" id="sitePHP" value="<?php echo $site; ?>" />

<script type="text/javascript">
var MenuBar = new Spry.Widget.MenuBar("MenuBar", {imgDown:"SpryAssets/SpryMenuBarDownHover.gif", imgRight:"SpryAssets/SpryMenuBarRightHover.gif"});
</script>
</body>
</html>