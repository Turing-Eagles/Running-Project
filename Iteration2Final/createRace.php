<!DOCTYPE html> 
<html>
<?php
require 'DbConnect.php';
session_start();
if($_SERVER['REQUEST_METHOD'] == 'POST'){
	require ('login_functions.inc.php');
	$username=$mysqli->real_escape_string(trim($_POST['username']));
	$password=$mysqli->real_escape_string(trim($_POST['password']));
	$category=$mysqli->real_escape_string(trim($_POST['category']));
	$name=$mysqli->real_escape_string(trim($_POST['name']));
	$year=$mysqli->real_escape_string(trim($_POST['year']));
    $day=$mysqli->real_escape_string(trim($_POST['day']));
    $month=$mysqli->real_escape_string(trim($_POST['month']));
	$hour=$mysqli->real_escape_string(trim($_POST['hour']));
    $minute=$mysqli->real_escape_string(trim($_POST['minute']));
	if(!$username || !$password){
		echo "You have not entered your username and password.<br />"
			  ."Please go back and try again.";
		 exit;
	}
	$q = "SELECT (username) FROM organizer_account WHERE username='$username' AND password='$password'";		
	$r = $mysqli->query ($q); // Run the query.
	// Check the result:
	if (mysqli_num_rows($r) == 1) {
		if (!$category || !$name || !$year || !$day || !$month || !$hour || !$minute) {
		 echo "You have not entered all the required details.<br />"
			  ."Please go back and try again.";
		 exit;
		}
		else{
			$date = $month . '/' . $day . '/' . $year;
			$time = $hour . ':' . $minute;
			$q = "insert into races (category, name, race_date) values ('$category', '$name', STR_TO_DATE('$date', '%m/%d/%Y'))";
			$mysqli->query($q);	
			if ($mysqli->affected_rows == 1) {
				echo '<script type="text/javascript">';
				echo 'window.alert("successful race creation")';
				echo '</script>';
			}
			else{
				echo 'Didnt fuckin work';
			}
		}
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
            <li class="current"><a href="createRace.php">Create Race</a></li>
            <li><a href="account.php">Account</a></li>
            <li><a href="races.php">Races</a></li>
            <li><a href="register.php"><?php if(isset($_COOKIE['username'])){echo "Log Out";} else{echo "Register";}?></a></li>
          </ul>
        </div><!--close menubar-->	
      </nav>
    </header>
	
    <div id="slideshow_container">  
	  <div class="slideshow">
	    <ul class="slideshow">
          <li class="show"><img width="940" height="250" src="images/home_1.jpg" alt="&quot;Enter your caption here&quot;" /></li>
          <li><img width="940" height="250" src="images/home_2.jpg" alt="&quot;Enter your caption here&quot;" /></li>
        </ul> 
	  </div><!--close slideshow-->  	
	</div><!--close slideshow_container-->  	
    
	<div id="site_content">

	  <div class="sidebar_container">       
		<div class="sidebar">
          <div class="sidebar_item">
            <h2>The Running Project</h2>
            <p>This is the best.</p>
          </div><!--close sidebar_item--> 
        </div><!--close sidebar-->     		
		<div class="sidebar">
          <div class="sidebar_item">
            <h2>Header...</h2>
            <h3>5k of the Week</h3>
            <p>What a good website!</p>         
		  </div><!--close sidebar_item--> 
        </div><!--close sidebar-->
		<div class="sidebar">
          <div class="sidebar_item">
            <h3>5k of the Month</h3>
            <p>Very well designed</p>         
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
				  <tr>
					<td>Username</td>
					 <td><input type="text" name="username" maxlength="15" size="30"></td>
				  </tr>
				  <tr>
					<td>Password</td>
					 <td><input type="text" name="password" maxlength="15" size="30"></td>
				  </tr>
				  <tr>
					<td>Race Name</td>
					 <td><input type="text" name="name" maxlength="15" size="30"></td>
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
							for ($x = 1; $x <= 60; $x++) {
								echo '<option value="' . $x .'">' . $x . '</option>';
							} 
							?>
						</select></td>
				  </tr>
				  <tr>
					<td colspan="2"><input type="submit" value="Create Race"></td>
				  </tr>
				</table>
			<?php
			$q = 'SELECT * FROM race_categories';
			$r = $mysqli->query ($q); // Run the query.
			$row = $r->fetch_object();
			while ($row = $r->fetch_object()) {
				
			}
			
			?>
			</form>
			</div><!--close form_settings-->
		</div><!--close content_item-->
      </div><!--close content-->   
	</div><!--close site_content-->  	
    <footer>
	  <a href="index.html">Home</a> | <a href="ourwork.html">Our Work</a> | <a href="testimonials.html">Testimonials</a> | <a href="projects.html">Projects</a> | <a href="contact.html">Contact</a><br/><br/>
	  <a href="http://fotogrph.com">Images</a> |  <a href="http://www.heartinternet.co.uk/vps/">Virtual Server</a>  | website template by <a href="http://www.freehtml5templates.co.uk">Free HTML5 Templates</a>
    </footer>  
  </div><!--close main-->

  <!-- javascript at the bottom for fast page loading -->
  <script type="text/javascript" src="js/jquery.min.js"></script>
  <script type="text/javascript" src="js/image_slide.js"></script>	
  
</body>
</html>
