<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<!-- TemplateBeginEditable name="doctitle" -->
<title>ARMS</title>
<!-- TemplateEndEditable -->
<link href="css/mainStyle.css" rel="stylesheet" type="text/css">
<link href="css/SpryMenuBarHorizontal.css" rel="stylesheet" type="text/css">
<script src="js/SpryMenuBar.js" type="text/javascript"></script>
<!-- TemplateBeginEditable name="head" -->
<!-- TemplateEndEditable -->
</head>

<body>

<div class="header">
    The Logo goes here!
    <a id="" alt="" href=""><img id="" alt="" src="" /></a>
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
	  <li id="routeMenu"><a id="routeButton" class="MenuBarItemSubmenu" href="#"></a>
	  <ul>
	      <li><a href="#">Scheduled<br />Routes</a></li>
	      <li><a href="#">View Special Routes</a></li>
	      <li><a href="#">Manage Special Routes</a></li>
      </ul>
      </li>
	  <li id="driverMenu"><a id="driverButton" href="#"></a>
      <ul>
	      <li><a href="#">Manage Drivers</a></li>
	      <li><a href="#">Assign Drivers</a></li>
      </ul>
      </li>
	  <li id="operatorMenu"><a id="operatorButton" class="MenuBarItemSubmenu" href="#"></a>
	  <ul>
	      <li><a href="#">Manage Users</a></li>
	      <li><a href="#">Maintain Mailing List</a></li>
	      <li><a href="#">Create Call Report</a></li>
          <li><a href="#">Schedule Call-In</a></li>
	      <li><a href="#">Add Customer</a></li>
	      <li><a href="#">Route Results</a></li>
      </ul>
      </li>
	  <li id="gpsMenu"><a id="gpsButton" href="#"></a></li>
  	</ul>
    <br /><br />
  
<div class="content">
    <h1>Instructions</h1>
        <p>Be aware that the CSS for these layouts is heavily commented. If you do most of your work in Design view, have a peek at the code to get tips on working with the CSS for the fixed layouts. You can remove these comments before you launch your site. To learn more about the techniques used in these CSS Layouts, read this article at Adobe's Developer Center - <a href="http://www.adobe.com/go/adc_css_layouts">http://www.adobe.com/go/adc_css_layouts</a>.</p>
        <h2>Clearing Method</h2>
        <p>Because all the columns are floated, this layout uses a clear:both declaration in the .footer rule.  This clearing technique forces the .container to understand where the columns end in order to show any borders or background colors you place on the .container. If your design requires you to remove the .footer from the .container, you'll need to use a different clearing method. The most reliable will be to add a &lt;br class=&quot;clearfloat&quot; /&gt; or &lt;div  class=&quot;clearfloat&quot;&gt;&lt;/div&gt; after your final floated column (but before the .container closes). This will have the same clearing effect.</p>
        
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