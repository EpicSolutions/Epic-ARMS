<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>ARMS - Manage Users</title>
<link href="css/mainStyle.css" rel="stylesheet" type="text/css">
<link href="css/SpryMenuBarHorizontal.css" rel="stylesheet" type="text/css">
<link href="css/tableStyle.css" rel="stylesheet" type="text/css">
<link href="css/jquery.alerts.css" rel="stylesheet" type="text/css" media="screen" />
<link rel="stylesheet" type="text/css" media="screen,projection" href="css/jquery-fallr-1.0.css" />
<script src="js/SpryMenuBar.js" type="text/javascript"></script>
<script src="js/jquery-latest.js" type="javascript"></script>
<script type="text/javascript" src="js/jquery-1.6.2.min.js"></script>
<script type="text/javascript" src="js/jquery-ui-1.8.16.custom.min.js"></script>
<script src="js/jquery.tablesorter.js" type="text/javascript"></script>
<script type="text/javascript" src="js/jquery-fallr-1.2.js"></script>
<script src="js/manageUser.js" type="text/javascript"></script>

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
</div><!-- end .sidebar1 -->

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
  
<div class="content">
    <div id="tableContent">
    <table id="userTable" class="tablesorter" cellspacing="0" cellpadding="2"> 
    <thead> 
    <tr> 
        <th>Username</th> 
        <th>Tracking</th> 
        <th>Routes</th> 
        <th>Reports</th> 
        <th>Admin</th>
        <th></th> 
    </tr> 
    </thead> 
    <tbody> 
    <tr> 
        <td id="user">Apple</td> 
        <td id="tracking"><input type="checkbox" checked /></td> 
        <td id="routes"><input type="checkbox" checked /></td> 
        <td id="reports"><input type="checkbox" checked /></td> 
        <td id="admin"><input type="checkbox" checked /></td>
        <td id="edit"><a href="">Edit</a></td> 
    </tr> 
    <tr> 
        <td>Bach</td> 
        <td>Frank</td> 
        <td>fbach@yahoo.com</td> 
        <td>$50.00</td> 
        <td>http://www.frank.com</td>
        <td><a href="">Edit</a></td> 
    </tr> 
    <tr> 
        <td>Doe</td> 
        <td>Jason</td> 
        <td>jdoe@hotmail.com</td> 
        <td>$100.00</td> 
        <td>http://www.jdoe.com</td>
        <td><a href="">Edit</a></td> 
    </tr> 
    <tr> 
        <td>Conway</td> 
        <td>Tim</td> 
        <td>tconway@earthlink.net</td> 
        <td>$50.00</td> 
        <td>http://www.timconway.com</td>
        <td><a href="">Edit</a></td> 
    </tr>
    <tr> 
        <td>Smith</td> 
        <td>John</td> 
        <td>jsmith@gmail.com</td> 
        <td>$50.00</td> 
        <td>http://www.jsmith.com</td>
        <td><a href="">Edit</a></td> 
    </tr> 
    <tr> 
        <td>Bach</td> 
        <td>Frank</td> 
        <td>fbach@yahoo.com</td> 
        <td>$50.00</td> 
        <td>http://www.frank.com</td>
        <td><a href="">Edit</a></td> 
    </tr> 
    <tr> 
        <td>Doe</td> 
        <td>Jason</td> 
        <td>jdoe@hotmail.com</td> 
        <td>$100.00</td> 
        <td>http://www.jdoe.com</td>
        <td><a href="">Edit</a></td> 
    </tr> 
    <tr> 
        <td>Conway</td> 
        <td>Tim</td> 
        <td>tconway@earthlink.net</td> 
        <td>$50.00</td> 
        <td>http://www.timconway.com</td>
        <td><a href="">Edit</a></td> 
    </tr>
    <tr> 
        <td>Smith</td> 
        <td>John</td> 
        <td>jsmith@gmail.com</td> 
        <td>$50.00</td> 
        <td>http://www.jsmith.com</td>
        <td><a href="">Edit</a></td> 
    </tr> 
    <tr> 
        <td>Bach</td> 
        <td>Frank</td> 
        <td>fbach@yahoo.com</td> 
        <td>$50.00</td> 
        <td>http://www.frank.com</td>
        <td><a href="">Edit</a></td> 
    </tr> 
    <tr> 
        <td>Doe</td> 
        <td>Jason</td> 
        <td>jdoe@hotmail.com</td> 
        <td>$100.00</td> 
        <td>http://www.jdoe.com</td>
        <td><a href="">Edit</a></td> 
    </tr> 
    <tr> 
        <td>Conway</td> 
        <td>Tim</td> 
        <td>tconway@earthlink.net</td> 
        <td>$50.00</td> 
        <td>http://www.timconway.com</td>
        <td><a href="">Edit</a></td> 
    </tr> 
    </tbody> 
    </table>
    </div><!-- end #tableContent-->
    <hr />
    
    <form id="addUserForm" action="" method="post">
    	<fieldset>
        <legend>Add User:</legend>
        	<div id="topBox">
            <label><p>Username</p>
        	<input type="text" id="uName" name="uName" />
            </label>
            <label style="margin-right: 0;"><p>Password</p>
            <input type="text" id="pass" name="pass" />
            </label>
            </div>
            <p style="float: left; clear: both; margin-right: 10px;">Permissions: </p>
            <label class="fltrt"><p>Tracking</p>
            <input type="checkbox" id="tracking" name="tracking" />
            </label>
            <label class="fltrt"><p>Routes</p>
            <input type="checkbox" id="routes" name="routes" />
            </label>
            <label class="fltrt"><p>Reports</p>
            <input type="checkbox" id="reports" name="reports" />
            </label>
            <label class="fltrt"><p>Admin</p>
            <input type="checkbox" id="admin" name="admin" />
            </label>
            <button class="clear" type="submit" id="submit">Add User</button>
        </fieldset>
    </form>
    
    <div id="editUser"></div>
        
  </div><!-- end .content -->
</div><!-- end #insideContainer -->
</div><!-- end #outsideContainer -->
      
<div class="footer">
	<p>Powered by Epic Solutions</p>
<!-- end .footer --></div>
<script type="text/javascript">
var MenuBar = new Spry.Widget.MenuBar("MenuBar", {imgDown:"SpryAssets/SpryMenuBarDownHover.gif", imgRight:"SpryAssets/SpryMenuBarRightHover.gif"});
</script>
</body>
</html>