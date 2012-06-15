<?php
/*session_start();

if(isset($_SESSION['logout']) && $_SESSION['logout'] == true)
	session_destroy();
	
if(isset($_POST['uName']) && isset($_POST['pass']))
{
	$uName = strtolower($_POST['uName']);
	$pass = $_POST['pass'];
	
	if (($uName == 'sean' || $uName == 'rick') && ($pass == 'pass'))
		{
			$_SESSION['uName'] = ucfirst($uName);
			$_SESSION['pass'] = $pass;
		}
}

// Initialize login variable
if(isset($_SESSION['uName'])){
	$login = '<h2>Welcome, ' . $_SESSION["uName"] . '</h2>'
		   . '<a id="logout" href="index.php">Logout</a>';
	$_SESSION['logout'] = true;
} else{
	$login = '<form id="loginForm" method="post" action="index.php">'
			. '<fieldset>'
			. '<legend>Login</legend>'
			. '<label>Username: <input id="uName" name="uName" type="text" /></label>'
			. 	'<label>Password: <input id="pass" name="pass" type="password" /></label>'
			. 	'<input id="loginSubmit" name="loginSubmit" type="submit" value="Go" />'
			. '</fieldset>'
		   . '</form>';
}*/

$uName = 'User';
$lastLogin = getdate();
$lastLogin = $lastLogin['mon'] . '/' . $lastLogin['mday'] . '/' . $lastLogin['year']; 
$news = file('http://epicsolweb.com/arms/news.txt');
$newsDate = $news[0];
$newsMessage = $news[1];

?>
<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>ARMS - Add Scheduled Route</title>
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
<script src="js/test.js" type="text/javascript"></script>
<style>
<!--
.addRouteHolder
{
	margin: 0 auto;
	height: 320px;
	width: 98%;
	overflow: auto;
}

#addRouteTable
{
	font-size: 8pt;	
}

#addRouteTable td
{
	text-align: center;
	font-size: 8pt;	
}
-->
</style>
</head>

<body>
   	 <div class="addRouteHolder">
    	<table id="addRouteTable">
		<thead>
        <tr>
        	<th></th>
        	<th>Route&nbsp;</th>
            <th>Maps&nbsp;</th>
            <th>Zips</th>
            <th>City&nbsp;</th>
            <th>Cards&nbsp;</th>
            <th>Demographics</th>
            <th>Last Scheduled&nbsp;</th>
            <th>Average Lbs&nbsp;</th>
            <th>History&nbsp;</th>
        </tr>
        </thead>
        <tbody>  
		</tbody>
        </table>
    </div><!-- end .tableHolder" -->
   
</body>
</html>