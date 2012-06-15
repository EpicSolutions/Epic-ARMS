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
<title>ARMS - Maintain Mailing List</title>
<link href="css/mainStyle.css" rel="stylesheet" type="text/css">
<link href="css/SpryMenuBarHorizontal.css" rel="stylesheet" type="text/css">
<link type="text/css" href="css/jquery-ui-1.8.16.custom.css" rel="Stylesheet" />
<link href="css/jquery.alerts.css" rel="stylesheet" type="text/css" media="screen" />
<link href="css/operatorTableStyle.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" media="screen,projection" href="css/jquery-fallr-1.0.css" />
<script type="text/javascript" src="js/jquery-1.6.2.min.js"></script>
<script type="text/javascript" src="js/jquery-latest.js"></script>
<script type="text/javascript" src="js/jquery.livequery.js"></script>
<script type="text/javascript" src="js/jquery.tablesorter.min.js"></script>
<script type="text/javascript" src="js/jquery-ui-1.8.16.custom.min.js"></script>
<script type="text/javascript" src="js/jquery-fallr-1.2.js"></script>
<script src="js/SpryMenuBar.js" type="text/javascript"></script>
<script src="js/datePicker.js" type="text/javascript"></script>
<script src="js/maillist.js" type="text/javascript"></script>

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
	width: 605px;	
	margin: 0 auto;
}

label
{
	display: block;
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
    <fieldset>
    <legend>Mailing List Maintenance</legend>
    
    	<p>Add or remove addresses from Mailing List</p>
        
        	<label style="display: inline;">Add to Mailing List<input type="radio" class="mailRadio" name="type" value="add" /></label>
			<label style="display: inline;">Add to Do Not Mail List<input type="radio" class="mailRadio" name="type" value="doNot" /></label>
        
        <br />
        
        <label>Address 
        	<input type="input" style="margin-left: 54px;" id="address" size="50" name="address" />
        </label>
        
        <label class="inline">City, State, Zip
        	<input style="margin-left: 13px;" type="input" id="city" name="city" />,
        </label>
   
   		<label class="inline">
            <select name="state" id="state">
                <option value="" selected="selected">Select a State</option> 
                <option value="AL">Alabama</option> 
                <option value="AK">Alaska</option> 
                <option value="AZ">Arizona</option> 
                <option value="AR">Arkansas</option> 
                <option value="CA">California</option> 
                <option value="CO">Colorado</option> 
                <option value="CT">Connecticut</option> 
                <option value="DE">Delaware</option> 
                <option value="DC">District Of Columbia</option> 
                <option value="FL">Florida</option> 
                <option value="GA">Georgia</option> 
                <option value="HI">Hawaii</option> 
                <option value="ID">Idaho</option> 
                <option value="IL">Illinois</option> 
                <option value="IN">Indiana</option> 
                <option value="IA">Iowa</option> 
                <option value="KS">Kansas</option> 
                <option value="KY">Kentucky</option> 
                <option value="LA">Louisiana</option> 
                <option value="ME">Maine</option> 
                <option value="MD">Maryland</option> 
                <option value="MA">Massachusetts</option> 
                <option value="MI">Michigan</option> 
                <option value="MN">Minnesota</option> 
                <option value="MS">Mississippi</option> 
                <option value="MO">Missouri</option> 
                <option value="MT">Montana</option> 
                <option value="NE">Nebraska</option> 
                <option value="NV">Nevada</option> 
                <option value="NH">New Hampshire</option> 
                <option value="NJ">New Jersey</option> 
                <option value="NM">New Mexico</option> 
                <option value="NY">New York</option> 
                <option value="NC">North Carolina</option> 
                <option value="ND">North Dakota</option> 
                <option value="OH">Ohio</option> 
                <option value="OK">Oklahoma</option> 
                <option value="OR">Oregon</option> 
                <option value="PA">Pennsylvania</option> 
                <option value="RI">Rhode Island</option> 
                <option value="SC">South Carolina</option> 
                <option value="SD">South Dakota</option> 
                <option value="TN">Tennessee</option> 
                <option value="TX">Texas</option> 
                <option value="UT">Utah</option> 
                <option value="VT">Vermont</option> 
                <option value="VA">Virginia</option> 
                <option value="WA">Washington</option> 
                <option value="WV">West Virginia</option> 
                <option value="WI">Wisconsin</option> 
                <option value="WY">Wyoming</option>
            </select>
        </label>
        
        <label class="inline">
            <input type="input" size="10" id="zip" name="zip" />
       	</label>
        
        <div style="width: 400px; margin: 10px auto;">
        	<input type="submit" id="submit" name="submit" value="Submit Change" />
        	<input type="submit" id="viewDoNot" name="viewDoNot" value="View Do Not Mail List" />
        	<input type="submit" id="viewList" name="viewList" value="View Mailing List" />
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