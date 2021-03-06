<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>ARMS - Manage Drivers</title>
<link href="css/mainStyle.css" rel="stylesheet" type="text/css">
<link href="css/SpryMenuBarHorizontal.css" rel="stylesheet" type="text/css">
<link type="text/css" href="css/jquery-ui-1.8.16.custom.css" rel="Stylesheet" />
<link href="css/jquery.alerts.css" rel="stylesheet" type="text/css" media="screen" />
<link href="css/tableStyle.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" media="screen,projection" href="css/jquery-fallr-1.0.css" />
<script type="text/javascript" src="js/jquery-1.6.2.min.js"></script>
<script type="text/javascript" src="js/jquery-latest.js"></script>
<script type="text/javascript" src="js/jquery.livequery.js"></script>
<script type="text/javascript" src="js/jquery.tablesorter.js"></script>
<script type="text/javascript" src="js/jquery-ui-1.8.16.custom.min.js"></script>
<script type="text/javascript" src="js/jquery-fallr-1.2.js"></script>
<script src="js/SpryMenuBar.js" type="text/javascript"></script>
<script src="js/datePicker.js" type="text/javascript"></script>
<script src="js/manageDrivers.js" type="text/javascript"></script>

<style>
<!--
#manageDriversTable
{
	width: 50%;	
}
-->
</style>
</head>

<body>

<div class="header">
    <a id="logo" alt="" href="index.php"><img id="logo" alt="Logo" src="images/logo.jpg" /></a>
	  
</div><!-- end .header -->
  
<div class="sidebar">
	
    <img src="images/redGradient.png" />

    <h2>Welcome</h2>
    <p></p>
    <p>Last login:</p>
    <p></p>
    
    <hr />
    
    <h2>Current News</h2>
    <p style="font: 12px bold;">Monday, Oct 1</p>
    <p>Today we are offering a special deal on something important.</p>
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
	  <ul>
	      <li><a href="manageusers.php">Manage Users</a></li>
	      <li><a href="mailinglist.php">Maintain Mailing List</a></li>
	      <li><a href="callreport.php">Create Call Report</a></li>
          <li><a href="callin.php">Schedule Call-In</a></li>
	      <li><a href="addcustomer.php">Add Customer</a></li>
	      <li><a href="routeresults.php">Route Results</a></li>
      </ul>
      </li>
	  <li id="gpsMenu"><a id="gpsButton" href="gps.php"></a></li>
  	</ul>
    <br /><br />
  	
    <p style="text-align: center;">To view the scheduled route for a date, select the date by clicking in the field below.</p>
    
    <div id="nameInput">
    	First name: <input id="firstName" name="firstName" type="text" />
        Last Name: <input id="lastName" name="lastName" type="text" />
        <input style="width: 100px; font-size: 14pt; display: block;" type="submit" value="Add Driver" />
    </div>
    
    <div class="tableHolder">
    	<table id="manageDriversTable" class="tablesorter">
		<thead>
        <tr>
        	<th>Driver</th>
            <th></th>
            <th></th>
        </tr>
        </thead>
        <tbody>  
		</tbody>
        </table>
    </div><!-- end .tableHolder" -->

</div><!-- end #insideContainer -->
</div><!-- end #outsideContainer -->
      
<div class="footer">
	<p>Powered by Epic Solutions</p>
</div><!-- end .footer -->

<script type="text/javascript">
var MenuBar = new Spry.Widget.MenuBar("MenuBar", {imgDown:"SpryAssets/SpryMenuBarDownHover.gif", imgRight:"SpryAssets/SpryMenuBarRightHover.gif"});
</script>
</body>
</html>