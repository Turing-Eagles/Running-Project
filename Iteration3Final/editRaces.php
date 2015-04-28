<!DOCTYPE html> 
<html>
<?php
require 'DbConnect.php';
session_start();
require ('login_functions.inc.php');
if(isset($_COOKIE['adminUsername'])){
	$name = ($_COOKIE["adminUsername"]);
	$q = "SELECT race_name, name FROM organizer_participation INNER JOIN races ON organizer_participation.race_name = races.race_id WHERE organizer_name = '$name'";
	$r = $mysqli->query ($q); // Run the query.
	
}
else{
	 redirect_user('adminLogin.php');
}
?>

<head>
  <title>The Running Project</title>
  <link rel="stylesheet" type="text/css" href="css/style.css" />
  <!-- modernizr enables HTML5 elements and feature detects -->
  <script type="text/javascript" src="js/modernizr-1.5.min.js"></script>  
</head>

<body>
  <div id="main">

    <header>
	  <div id="strapline">
	    <div id="welcome_slogan">
	      <h3>The Running Project <span></span></h3>
	    </div><!--close welcome_slogan-->
      </div><!--close strapline-->	  
	  <nav>
	    <div id="menubar">
          <ul id="nav">
            <li><a href="home.php">Home</a></li>
            <li><a href="adminLogin.php"><?php if(isset($_COOKIE['adminUsername'])){echo "Log Out";} else{echo "Admin Login";}?></a></li>
            <li><a href="createRace.php">Create Race</a></li>
            <li class="current"><a href="editRaces.php">Edit Race</a></li>
            <li><a href="adminRacesResult.php">Race Results</a></li>
          </ul>
        </div><!--close menubar-->	
      </nav>
    </header>
	
    <div id="slideshow_container">  
	  <div class="slideshow">
	    <ul class="slideshow">
          <li class="show"><img width="940" height="250" src="images/home_1.jpg" alt="&quot;&quot;" /></li>
          <li><img width="940" height="250" src="images/home_2.jpg" alt="&quot;&quot;" /></li>
        </ul> 
	  </div><!--close slideshow-->  	
	</div><!--close slideshow_container-->  	
    
	<div id="site_content">

	  <div class="sidebar_container">       
		<div class="sidebar">
          <div class="sidebar_item">
            <h2>The Running Project</h2>
            <p>The internet's finest (not to mention most secure) source for local road racing. </p>
          </div><!--close sidebar_item--> 
        </div><!--close sidebar-->     		
		<div class="sidebar">
          <div class="sidebar_item">
            <h2></h2>
            <h3>Edit Races</h3>
            <p>This is the tab that you navigate to in order to find races that you have personally created. Click on the EDIT button next to whatever race you would like to edit.</p>         
		  </div><!--close sidebar_item--> 
        </div><!--close sidebar-->
		<div class="sidebar">
          <div class="sidebar_item">
            <h3>Account</h3>
            <p>You can only edit the races that were created under the account you are currently using.</p>         
		  </div><!--close sidebar_item--> 
        </div><!--close sidebar-->  		
        <div class="sidebar">
          <div class="sidebar_item">
            <h2>Contact</h2>
            <p>Phone: +44 (0)1234 567891</p>
            <p>Email: <a href="mailto:info@youremail.co.uk">my email address</a></p>
          </div><!--close sidebar_item--> 
        </div><!--close sidebar-->
       </div><!--close sidebar_container-->
	
	  <div id="content">
        <div class="content_item">
		  <div class="form_settings">
            <h2>Races</h2>
			<?php			
			echo '<table align="center" cellspacing="3" cellpadding="3" width="75%">
			<tr><td align="left"><b>Race Name</b></td></td>';
			while ($row = $r->fetch_object()) {
				echo '<tr>';
				if(isset($_COOKIE['adminUsername'])){
					echo '<td align="left"><b>' . $row->name . '</b></td>';
				}
				if(isset($_COOKIE['adminUsername'])){
					echo '<td align="left"><a href="editRace.php?race_name=' . $row->race_name . '">EDIT</a></td>';
				}
				echo '</tr>';
			}
			echo '</table>'; // Close the table.
	
			$r->free(); // Free up the resources.
			unset($r);	
			?>
			</div><!--close form_settings-->
		</div><!--close content_item-->
      </div><!--close content-->   
	</div><!--close site_content-->  	 
  </div><!--close main-->

  <!-- javascript at the bottom for fast page loading -->
  <script type="text/javascript" src="js/jquery.min.js"></script>
  <script type="text/javascript" src="js/image_slide.js"></script>	
  
</body>
</html>
