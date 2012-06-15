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
<title>ARMS - Route Results</title>
<link href="css/mainStyle.css" rel="stylesheet" type="text/css">
<link href="css/SpryMenuBarHorizontal.css" rel="stylesheet" type="text/css">
<link type="text/css" href="css/jquery-ui-1.8.16.custom.css" rel="Stylesheet" />
<link href="css/jquery.alerts.css" rel="stylesheet" type="text/css" media="screen" />
<link href="css/operatorTableStyle.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" media="screen,projection" href="css/jquery-fallr-1.0.css" />
<script type="text/javascript" src="js/jquery-1.6.2.min.js"></script>
<script type="text/javascript" src="js/jquery-latest.js"></script>
<script type="text/javascript" src="js/jquery.livequery.js"></script> 
<script type="text/javascript" src="js/jquery.tablesorter.js"></script>
<script type="text/javascript" src="js/jquery-ui-1.8.16.custom.min.js"></script>
<script type="text/javascript" src="js/jquery-fallr-1.2.js"></script>
<script src="js/SpryMenuBar.js" type="text/javascript"></script>
<script src="js/datePicker.js" type="text/javascript"></script>
<script src="js/results.js" type="text/javascript"></script>

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

label
{
	width: 250px;
	margin-bottom: 10px;	
}

form
{
	border: 1px solid white;
	width: 600px;	
	margin: 0 auto;
}

option
{
	margin-left: 5px;
	text-align: left;	
}

select
{
	text-align: center;	
}

.inline
{
	display: inline;
	margin-right: -5px;	
}

.labelHolder
{
	width: 520px;
	margin: auto;	
}

.mailRadio
{
	float: none;
	position: relative;
	left: 0;
	top: 0;	
}

.footer
{
	position:fixed;
	bottom: -10px;	
}

.left
{
	float: left;
}

.left input, .left select
{
	float: right;
}

.right
{
	float: right;	
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
  
  <div class="content" style="border: none;">
  	<form id="mailListForm">
    <fieldset style="height: 375px;">
    <legend>Route Results</legend>
    
    	<p>Enter the information for the route results. The average will automatically be calculated.</p>
        	
            <div class="labelHolder">
                <label class="left">Driver
                    <select style="width: 156px;" id="driver" name="driver">
                    <option value="">Select a driver</option>
                    </select>
                </label>
                
                <label class="right">Helper 
                    <select style="width: 156px;" id="helper" name="helper">
                    <option value="">Select a helper</option>
                    </select>
                </label>
            </div>
         	
            <div class="labelHolder">
                <label class="left">Clothing
                    <input type="input" style="width: 150px;" id="clothLB" name="clothLB" /> 
                </label>
                
                <label class="right">lbs or
                    <input type="input" style="width: 150px; margin-left: 7px;" id="clothCart" name="clothCart" />
                    carts
                </label>
            </div>
            
            <div class="labelHolder">
                <label class="left">Furniture
                    <input type="input" style="width: 150px;" id="furnLB" name="furnLB" />  
                </label>
                
                <label class="right">lbs or
                    <input type="input" style="width: 150px; margin-left: 7px;" id="furnPiece" name="furnPiece" />
                    pieces
                </label>
            </div>
            
            <div class="labelHolder">
                <label class="left">MISC
                    <input type="input" style="width: 150px;" id="miscLB" name="miscLB" /> 
                </label>
                
                <label class="right">lbs or
                    <input type="input" style="width: 150px; margin-left: 7px;" id="miscCart" name="miscCart" />
                    carts
                </label>
            </div>
            
            <div class="labelHolder">
                <label class="left">Stops
                    <input type="input" style="width: 150px;" id="stop" name="stop" />
                </label>
                
                <label class="right" style="margin-right: 9px;">Average 
                    <input type="input" style="width: 150px;" disabled="disabled" id="avg" name="avg" />
                </label>
            </div>
            
            <div class="labelHolder">
                <label class="left">Route
                    <input type="input" style="width: 150px;" id="route" name="route" />
                </label>
                
                <label class="right" style="margin-right: 9px;">Date
                    <input type="input" style="margin-left: 22px; width: 150px;" class="datePicker" id="date" name="date" />
                </label>
            </div>
            
            <div class="labelHolder">
                <label class="left">Cards
                    <input type="input" style="width: 150px;" id="card" name="card" />
                </label>
                
                <label class="right" style="margin-right: 9px;">Calls
                    <input type="input" style="margin-left: 19px; width: 150px;" id="call" name="call" />
                </label>
            </div>
            
            <label style="display: table-cell; width: 500px;"><span style="vertical-align: top; margin-left: 26px;">Notes</span>
                <textarea style="position: relative; left: 53px; width: 375px;" id="notes" name="notes"></textarea>
            </label>
       
        <div style="width: 350px; margin: auto; margin-bottom: 50px; margin-top: 25px; position: relative; top: 0px;">
        	<input style="font-size: 16pt;" type="submit" id="submit" name="submit" value="Add Route Results" />
            <input style="font-size: 16pt;" type="submit" id="clear" name="clear" value="Clear Form" />
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