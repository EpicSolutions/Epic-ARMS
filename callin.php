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
<title>ARMS - Schedule Pick-Up</title>
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
	display: block;
	margin: 10px;	
}

label input, label select, label textarea
{
	position: absolute;
	left: 150px;
	width: 300px;
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

.footer
{
	position:fixed;
	bottom: -10px;	
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
    <fieldset style="height: 630px;">
    <legend>Schedule a Pick-Up</legend>
    
    	<p>Enter the phone number and click "Look up" to check if customer is in database.
           You can scheduled a new pick-up or edit an existing one. This is where you select
           "Missed" if the items were not picked up.</p>
 		
        <input type="hidden" id="oldDate" />
        
        <fieldset style="width: 100%; position: relative; left: -14px; height: 265px; border-bottom: none;">
        <legend style="font-size: 11pt;">Donor Information</legend>
        
            <label style="display: inline;">Phone 
                <input type="input" style="width: 150px;" id="phone" name="phone" />
            </label>
            
            <input style="font-size: 11pt; position: absolute; left: 320px; top: 21px;" type="submit" id="lookUp" name="lookUp" value="Look Up" />
            
            <label>First Name
                <input type="input" id="fName" name="fName" />
            </label>
            
            <label>Last name 
                <input type="input" id="lName" name="lName" />
            </label>
            
            <label>Street
                <input type="input" id="street" name="street" />
            </label>
            
            <label class="inline">City, State, Zip
                <input style="width: 110px;" type="input" id="city" name="city" />
            </label>
            
            <label class="inline">
                <select style="width: 110px; left: 280px;" name="state" id="state">
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
                <input style="width: 50px; left: 400px;" type="input" id="zip" name="zip" />
            </label>
            
            <label>Email
                <input type="input" id="email" name="email" />
            </label>
            
            <label>Notes
                <textarea id="notes" name="notes"></textarea>
            </label>
        
        </fieldset>
        
        <fieldset style="width: 100%; position: relative; left: -14px; top: 0px; border-bottom: none;">
        <legend style="font-size: 11pt;">Special Instructions</legend>
        
            <label>Location of Items 
                <input type="input" id="locationItems" name="locationItems" />
            </label>
            
            <label>Driver Instructions
                <input type="input" id="driverInstruction" name="driveInstruction" />
            </label>
            
            <label>Scheduled Route 
                <input type="input" style="width: 100px;" id="route" name="route" />
            </label>
            
            <label>Pick-up Date
                <input type="input" style="width: 120px;" class="datePicker" id="date" name="date" />
            </label>
            
            <label>Missed
                <input style="left: 4px;" type="checkbox" id="miss" name="miss" value="miss" />
            </label>
            
            <label>Type
            	<select id="type" name="type" style="width: 100px;">
                	<option value="confirmed">Confirmed</option>
                    <option value="special">Special</option>
                </select>
         	</label>
        
        </fieldset>
 
        
            <div style="width: 260px; margin: auto; margin-bottom: 50px; margin-top: 0px; position: relative; top: 10px;">
                <input style="font-size: 16pt;" type="submit" id="submit" name="submit" value="Schedule" />
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