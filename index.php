<?php

/**** Includes ****/
// Connect to database
require_once('php/connect_to_mysql.php');

// Date formatted for Database
require_once('php/reformatDate.php');

/**** Session Parameters ****/
// Start Session
session_start();
$site = $_SESSION['site'];

// Check if username and password are set
if(isset($_SESSION['uName']) && isset($_SESSION['pass'])){
	$site = $_SESSION['site'];
	header("Location: arms.php"); 
} 
else if(isset($_POST['uName']) && isset($_POST['pass'])) 
{
	
	// Set local variables from POST
	$uName = $_POST['uName'];
	$pass = $_POST['pass'];
	
	// Query string
	$query = "SELECT * FROM users WHERE uName='$uName' AND pass='$pass'";
	
	$sql = mysql_query($query) or die(mysql_error());
	
	// Check credentials are valid
	if(mysql_num_rows($sql) > 0)
	{
		// Process results
		while($array = mysql_fetch_array($sql))
		{
			// Set session variables
			$_SESSION['uName']     	   = $array['uName'];
			$_SESSION['group']		   = $array['group'];
			$_SESSION['pass'] 	   	   = $array['pass'];
			$_SESSION['tracking']  	   = $array['tracking'];
			$_SESSION['routes']    	   = $array['routes'];
			$_SESSION['reports']   	   = $array['reports'];
			$_SESSION['admin']         = $array['admin'];
			$_SESSION['addedBy']       = $array['addedBy'];
			$_SESSION['lastChangedBy'] = $array['lastChangedBy'];
			$_SESSION['dateChanged']   = $array['dateChanged'];
			$_SESSION['site']		   = $array['site'];
			
			// Update last login date
			$lastLogin= getdate();
			$lastLogin = $lastLogin['mon'] . '/' . $lastLogin['mday'] . '/' . $lastLogin['year'];
			$lastLogin = ReformatDate($lastLogin, 'Y-m-d');
			
			$query = "UPDATE users SET lastLogin='$lastLogin' WHERE uName='$uName'";
			$sql = mysql_query($query) or die(mysql_error());
			
			// Set lastLogin session variable
			$_SESSION['lastLogin'] = ReformatDate($lastLogin, 'n/j/Y');;
			
			// Refresh page
			header("Location: #");
		}
	}
	else
	{
		$valid = "Sorry! That username/password combination is not correct.";
	}
}
?>
<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>ARMS - Login</title>
<link href="css/login.css" rel="stylesheet" type="text/css" />
<link rel="icon" href="images/ARMS_Logo_small.jpg" type="image/x-icon">
</head>
<body>

<div class="container">
  	<div class="header">
  		<a href="#">
  		<img src="images/ARMS_Logo_small.jpg" alt="Insert Logo Here" name="Insert_logo" width="180" height="90" id="Insert_logo" style="display:block;" />
  		</a> 
	</div><!-- end .header -->
    
  <div class="leftContent">
    <h1>What is ARMS?</h1>
    <p>ARMS is a fully integrated pick-up management system created for charitable organizations. This
       program gives operators the ability to manage:</p>
       
       <ul style="list-style: ;">
       	<li>Users</li>
        <li>Drivers</li>
        <li>Routes</li>
        <li>Addresses</li>
       </ul>
       
    <p>This system also allows operators to track vehicles using Google integrated maps.</p>
    
    
    <!-- end .leftContent --></div>
    
    <div class="rightContent">
        
        <div class="loginHolder">
        <h2>Customer Login</h2>
        
        <p style="color: red; font-size: 12px; text-align: center; height: 15px;"><? echo $valid ?></p>
        <form id="loginForm" method="post" action="#">
        	<label>Username: <input type="text" id="uName" name="uName" /></label>
            <label>Password: <input type="password" id="pass" name="pass" /></label>
            <label><input type="submit" value="Login" id="login" name="login" /></label>
        </form>
        </div><!-- end .loginHolder -->
        
    </div><!-- end .rightContent -->
    
  <div class="footer">
    <p>Powered by <a href="http://www.epicsolutions.com">Epic Solutions</a></p>
    <!-- end .footer --></div>
  <!-- end .container --></div>
</body>
</html>