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
<title>ARMS - Call Reports</title>
<?php require_once('head.phtml'); ?>
<link href="css/operatorTableStyle.css" rel="stylesheet" type="text/css" />
<script src="js/callIn.js" type="text/javascript"></script>

<style>
<!--

fieldset
{
	border: 2px solid rgb(48,227,0);
}

legend
{
	font-size: 19pt;	
}

form
{
	border: 1px solid white;
	width: 600px;	
	margin: 0 auto;
}

label
{
	margin: 10px;	
}

label input, label select
{
	margin-right: 10px;	
}

.inline
{
	display: inline;
	margin-right: -5px;	
}

.mailRadio
{
	float: none;
	position: relative;
	left: 0;
	top: 0;	
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
  
  <div class="content" style="border: none;">
  	<form id="mailListForm">
    <fieldset>
    <legend>Call Report</legend>
    
    	<p>Create a report using any of the fields below.</p>
        
        <label style="float: left; width: 250px;">Phone 
        	<input style="float: right;" type="input" id="phone" name="phone" />
        </label>
        
        <label style="float: right;">Route
        	<input type="input" id="route" name="route" />
        </label>
        
        <br />
        
        <label style="float: left; width: 250px;">First Name
        	<input style="float: right;" type="input" id="fName" name="fName" />
        </label>
        
        <label style="float: right;">Last name 
        	<input type="input" id="lName" name="lName" />
        </label>
        
        <br />
        
        <label style="float: left; width: 250px;">Street
        	<input style="float: right;" type="input" id="street" name="street" />
        </label>
        
        <label style="float: right;">Zip
        	<input type="input" id="zip" name="zip" />
        </label>
        
        <br />
        
        <label style="float: left; width: 250px;">Date Range
        	<input class="datePicker" style="float: right;" type="input" id="dateBegin" name="dateBegin" />
        </label>
        
        <label style="float: right;">To
        	<input class="datePicker" type="input" id="dateEnd" name="dateEnd" />
        </label>
        
        <div style="width: 400px; margin: 10px auto; position: relative; top: 110px;">
        	<input style="font-size: 16pt;" type="submit" id="submit" name="submit" value="Search" />
        </div>
    
    </fieldset>    
    </form>
        
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