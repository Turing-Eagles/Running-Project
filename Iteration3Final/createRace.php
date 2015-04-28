<!DOCTYPE html> 
<html>
<?php
require 'DbConnect.php';
session_start();
require ('login_functions.inc.php');
if(isset($_COOKIE['adminUsername'])){
	$username = $_COOKIE['adminUsername'];
}
else{
	redirect_user('adminLogin.php');
}
if($_SERVER['REQUEST_METHOD'] == 'POST'){
	$category=$mysqli->real_escape_string(trim($_POST['category']));
	$name=$mysqli->real_escape_string(trim($_POST['name']));
	$year=$mysqli->real_escape_string(trim($_POST['year']));
    $day=$mysqli->real_escape_string(trim($_POST['day']));
    $month=$mysqli->real_escape_string(trim($_POST['month']));
	$hour=$mysqli->real_escape_string(trim($_POST['hour']));
    $minute=$mysqli->real_escape_string(trim($_POST['minute']));
	$address=$mysqli->real_escape_string(trim($_POST['address']));
	$city=$mysqli->real_escape_string(trim($_POST['city']));
	$state=$mysqli->real_escape_string(trim($_POST['state']));
	$date = $month . '/' . $day . '/' . $year;
	$time = $hour . ':' . $minute . ':00';
	$date = $date . " " . $time;
	$q = "insert into races (category, name, race_date, address, city, state) VALUES ('$category', '$name', STR_TO_DATE('$date', '%m/%d/%Y %H:%i:%s'), '$address', '$city', '$state')";
	$mysqli->query($q);	
	if ($mysqli->affected_rows == 1) {
		$q = "SELECT MAX(race_id) as last_id FROM races";
		$r = $mysqli->query($q);
		$lastID = $r->fetch_object()->last_id;
		$q = "insert into organizer_participation (organizer_name, race_name) VALUES ('$username', '$lastID')";
		$mysqli->query($q);
		if ($mysqli->affected_rows == 1) {
			echo '<script type="text/javascript">';
			echo 'window.alert("Successful race creation")';
			echo '</script>';
		}
		else{
			echo '<script type="text/javascript">';
			echo 'window.alert("Error. Did not insert into cross-reference table.")';
			echo '</script>';
		}
	}
	else{
		echo '<script type="text/javascript">';
		echo 'window.alert("Error. Did not create race.")';
		echo '</script>';
	}
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
            <li class="current"><a href="createRace.php">Create Race</a></li>
            <li><a href="editRaces.php">Edit Races</a></li>
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
            <h2>Create Race</h2>
            <p>At this tab you can create races for other people to register for.<p>         
		  </div><!--close sidebar_item--> 
        </div><!--close sidebar-->
		<div class="sidebar">
          <div class="sidebar_item">
            <h3>Create Race</h3>
            <p>Only you can prevent forest fires.</p>         
		  </div><!--close sidebar_item--> 
        </div><!--close sidebar-->  		
        <div class="sidebar">
          <div class="sidebar_item">
            <h2>Contact</h2>
            <p>Phone: +44 (0)1234 567891</p>
            <p>Email: <a href="mailto:info@youremail.co.uk">yo momma</a></p>
          </div><!--close sidebar_item--> 
        </div><!--close sidebar-->
       </div><!--close sidebar_container-->
	
	  <div id="content">
        <div class="content_item">
		  <div class="form_settings">
            <h2>Race Information</h2>
			<form action="createRace.php" method="post">
			<table border="0">
					<td>Race Name</td>
					 <td><input type="text" name="name" maxlength="15" size="30"></td>
				  </tr>
				  <tr>
					<td>Address</td>
					 <td><input type="text" name="address" maxlength="35" size="30"></td>
				  </tr>
				  <tr>
					<td>City</td>
					 <td><input type="text" name="city" maxlength="15" size="30"></td>
				  </tr>
				  <tr>
					<td>State</td>
					 <td><input type="text" name="state" maxlength="15" size="30"></td>
				  </tr>
				  <tr>
					<td>Category</td>
					<td> 
					<select name="category">
					<?php
					$q = 'SELECT * FROM race_categories';
					$r = $mysqli->query ($q); // Run the query.
					while ($row = $r->fetch_object()) {
						echo '<option>' . $row->category . '</option>';
					}
					?>
					</select>
					</td>
				  </tr>
				  <tr>
					<td>Date</td>
					<td> Month: <select name="month" size="1">
							<?php 
							for ($x = 1; $x <= 12; $x++) {
								echo '<option value="' . $x .'">' . $x . '</option>';
							} 
							?>
						</select>
						Day: <select name="day" size="1">
							<?php 
							for ($x = 1; $x <= 30; $x++) {
								echo '<option value="' . $x .'">' . $x . '</option>';
							} 
							?>
						</select>
						Year: <select name="year" size="1">
							<?php 
							for ($x = 1900; $x <= 2015; $x++) {
								echo '<option value="' . $x .'">' . $x . '</option>';
							} 
							?>
						</select></td>
				  </tr>
				  <tr>
					<td>Time</td>
					<td> Hour: <select name="hour" size="1">
							<?php 
							for ($x = 1; $x <= 24; $x++) {
								echo '<option value="' . $x .'">' . $x . '</option>';
							} 
							?>
						</select>
						Minute: <select name="minute" size="1">
							<?php 
							for ($x = 0; $x <= 60; $x++) {
								echo '<option value="' . $x .'">' . $x . '</option>';
							} 
							?>
						</select></td>
				  </tr>
				  <tr>
					<td colspan="2"><input type="submit" value="Create Race"></td>
				  </tr>
				</table>
			</form>
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
