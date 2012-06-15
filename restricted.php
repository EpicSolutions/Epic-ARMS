<?php

/**** Includes ****/
// Connect to database
require_once('php/connect_to_mysql.php');

// Clear valid
$valid = "";

/**** Session Parameters ****/
// Start Session
session_start();
$site = $_SESSION['site'];

// Check if username and password are set
if(isset($_SESSION['uName'])) 
{
	// Set local variables from session
	$uName = $_SESSION['uName'];
	
	// Set local variables from POST
	
	$pass    = $_POST['pass'];
	$newPass = $_POST['newPass'];
	$verPass = $_POST['verPass'];
	
	// Check if back was clicked
	if($_POST['back'])
	{
		$url = htmlspecialchars($_SESSION['previous']);
		header("Location: " . $url);
	}
	else
	{
		if($newPass == "" && isset($_POST['newPass']))
		{
			$valid = "<p style=\"color: red; font-size: 12px; text-align: center; height: 15px;\">You must enter a new password!";
		}
		else if($verPass == "" && isset($_POST['verPass']))
		{
			$valid = "<p style=\"color: red; font-size: 12px; text-align: center; height: 15px;\">You must verify your new password!";
		}
		else if ($newPass == $verPass && isset($_POST['newPass']) && isset($_POST['verPass']))
		{
			// Query string
			$query = "SELECT * FROM users WHERE uName='$uName' AND pass='$pass'";
			
			$sql = mysql_query($query) or die(mysql_error());
			
			// Check credentials are valid
			if(mysql_num_rows($sql) > 0)
			{
				$query = "UPDATE users SET pass='$newPass' WHERE uName='$uName'";
				
				$sql = mysql_query($query) or die(mysql_error());
				
				$valid = "<p style=\"color: green; font-size: 12px; text-align: center; height: 15px;\">Password successfully changed.";
			} // end valid crediential check
			else
			{
				$valid = "<p style=\"color: red; font-size: 12px; text-align: center; height: 15px;\">Sorry! The old password is not correct.";
			}
		}
		else if (isset($_POST['newPass']) && isset($_POST['verPass']))
		{
			$valid = "<p style=\"color: red; font-size: 12px; text-align: center; height: 15px;\">The new passwords do not match.";
		} // End password match
	} // End back check
}
else
{
	session_destroy();
	header("Location: index.php");	
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
    
  	<div class="restrictedContent">
        
        <div class="restrictedHolder">
        <h2 style="font-size: 22pt; margin-bottom: 5px; color: #900;">Restricted Area</h2>
        
        <p>You do not have access to this area. If you feel you are receiving this message in error, please
           contact your administrator.</p>
        <form id="restrictedForm" method="post" action="#">
            <label><button style="float: right; font-size: 14pt;" type="submit" value="back" id="back" name="back">Back</button></label>
        </form>
        </div><!-- end .loginHolder -->
        
    </div><!-- end .changeContent -->
    
  <div class="footer">
    <p>Powered by <a href="http://www.epicsolutions.com">Epic Solutions</a></p>
    <!-- end .footer --></div>
  <!-- end .container --></div>
</body>
</html>