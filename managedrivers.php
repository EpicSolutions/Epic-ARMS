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
<title>ARMS - Manage Drivers</title>
<?php require_once('head.phtml'); ?>
<script src="js/manageDrivers.js" type="text/javascript"></script>

<style>
<!--
#manageDriversTable
{
	width: 465px;	
	margin: auto;
}

#editName input
{
	border: 1px solid rgb(100,100,100);	
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
        <p style="text-align: center;">To add a driver, enter the First and Last name and click Add Driver.</p>
        
        <div id="nameInput">
            First name: <input id="firstName" name="firstName" type="text" />
            Last name: <input id="lastName" name="lastName" type="text" />
            <input id="addDriverButton" style="width: 100px; margin: auto; margin-top: 5px; font-size: 14pt; display: block;" type="submit" value="Add Driver" />
        </div>
        
        <div class="tableHolder">
            <table id="manageDriversTable" class="tablesorter">
            <thead>
            <tr>
                <th>Driver</th>
                <th> </th>
                <th> </th>
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