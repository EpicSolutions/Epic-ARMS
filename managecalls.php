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
<script src="js/managecalls.js" type="text/javascript"></script>
<style>
<!--
#callTable td {
	font-size: 10pt;	
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
        <p class="indent">Enter your query and select the field and criteria below.</p>
        
        <table class="indent" style="text-align: left; margin: 0 0 10px 5px;">
            <tr>
            <th>
                Keyword(s)
            </th>
            <th>
                Search Field
            </th>
            <th>
                Criterion
            </th>
            <th>
            </th>
        </tr>
        <tr>
        	<td>
        		<input type="text" id="key" name="key" />
        	</td>
            <td>
                <select id="field" name="field">
                    <option value="all">ALL</option>
                    <option value="firstName">First Name</option>
                    <option value="lastName">Last Name</option>
                    <option value="fullName">Full Name</option>
                    <option value="primaryPhone">Phone Number</option>
                    <option value="route">Route</option>
                    <option value="city">City</option>
                    <option value="zip">Zip Code</option>
                    <option value="datePickup">Date (DD/MM/YYYY)</option>
                </select>
			</td>
            <td>            
                <select id="method" name="method">
                    <option value="exact">Exact</option>
                    <option value="contains">Contains</option>
                </select>
            </td>
            <td>
            	<input type="submit" value="Search" id="submit" name="submit" />
          	</td>
        </table>
        
        <div class="tableHolder" style="width: 100%;">
            <table id="callTable" class="tablesorter">
            <thead>
            <tr>
                <th>Name</th>
                <th>Phone</th>
                <th>City</th>
                <th>Zip</th>
                <th>Route</th>
                <th>Pickup Date</th>
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