<!DOCTYPE html> 
<html>
<?php
require 'DbConnect.php';
session_start();
require ('login_functions.inc.php');
if($_SERVER['REQUEST_METHOD'] == 'POST'){
	$raceid = $mysqli->real_escape_string(trim($_POST['raceId']));
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
	$q = "UPDATE races SET category = '$category', name = '$name', race_date = STR_TO_DATE('$date', '%m/%d/%Y %H:%i:%s'), address = '$address', city = '$city', state = '$state' WHERE race_id = '$raceid'";
	$mysqli->query($q);	
	if ($mysqli->affected_rows == 1) {
		echo '<script type="text/javascript">';
		echo 'window.alert("Successful race update")';
		echo '</script>';
		redirect_user('editRace.php');
	}
	else{
		echo '<script type="text/javascript">';
		echo 'window.alert("Unsuccessful race update")';
		echo '</script>';
	}
}
else{
	if (!isset($_GET['race_name'])){ // From races.php
		redirect_user('editRaces.php');
	}
	else{
		$organizerName = ($_COOKIE["adminUsername"]);
		$raceName = ($_GET["race_name"]);
		$q = "SELECT * FROM organizer_participation WHERE organizer_name = '$organizerName' AND race_name = '$raceName'";
		$r = $mysqli->query ($q); // Run the query.
		if($r->num_rows != 1){
			redirect_user('adminLogin.php');
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
            <li><a href="adminLogin.php"><?php if(isset($_COOKIE['adminUsername'])){echo "Log Out";} else{echo "Admin Login";}?></a></li>
            <li><a href="createRace.php">Create Race</a></li>
            <li  class="current"><a href="editRace.php">Edit Race</a></li>
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
            <h3>Edit Race</h3>
            <p>Here, you can edit the information in a race that you have already created. </p>         
		  </div><!--close sidebar_item--> 
        </div><!--close sidebar-->
		<div class="sidebar">
          <div class="sidebar_item">
            <h3>Race Results</h3>
            <p>You can fill in the details for the race results in the next tab over.</p>         
		  </div><!--close sidebar_item--> 
        </div><!--close sidebar-->  	
       </div><!--close sidebar_container-->
	
	  <div id="content">
        <div class="content_item">
		  <div class="form_settings">
            <h2>Race Information</h2>
			<form action="editRace.php" method="post">
			<table border="0">
			<?php
				$racename = $_GET['race_name'];
				$q  = "SELECT * FROM races WHERE race_id = '$racename' LIMIT 1";
				$r = $mysqli->query($q); // Run the query.
				$row = $r->fetch_object();
				echo '<tr>';
				echo '<td>Race Name</td>';
				echo '<td><input type="text" name="name" maxlength="15" size="30" value="' . $row->name . '"></td>';
				echo '</tr>';
				echo '<tr>';
				echo	'<td>Address</td>';
				echo	'<td><input type="text" name="address" maxlength="35" size="30"value="' . $row->address . '"></td>';
				echo '</tr>';
				echo '<tr>';
				echo	'<td>City</td>';
				echo	'<td><input type="text" name="city" maxlength="15" size="30"value="' . $row->city . '"></td>';
				echo '</tr>';
				echo '<tr>';
				echo	'<td>State</td>';
				echo	'<td><input type="text" name="state" maxlength="15" size="30"value="' . $row->state . '"></td>';
				echo '</tr>';
				echo '<tr>';
				echo	'<td>Category</td>';
				echo	'<td> ';
				echo	'<select name="category">';
					$q = 'SELECT * FROM race_categories';
					$r2 = $mysqli->query ($q); // Run the query.
					while ($row2 = $r2->fetch_object()) {
						echo '<option';
						if($row2->category == $row->category){
							echo 'selected';
						}
						echo '>' . $row2->category . '</option>';
					}
				echo '</select>';
				echo '</td>';
				echo '</tr>';
				echo '<tr>';
				echo '<td>Date</td>';
				echo '<td> Month: <select name="month" size="1">';
							for ($x = 1; $x <= 12; $x++) {
								echo '<option value="' . $x .'"';
								if($x == substr($row->race_date, 5, 2)){
									echo 'selected';
								}
								echo '>' . $x . '</option>';
							}
						echo '</select>';
						echo 'Day: <select name="day" size="1">';
							for ($x = 1; $x <= 30; $x++) {
								echo '<option value="' . $x .'"';
								if($x == substr($row->race_date, 8, 2)){
									echo 'selected';
								}
								echo '>' . $x . '</option>';
							} 
						echo '</select>';
						echo 'Year: <select name="year" size="1">';
							for ($x = 1900; $x <= 2015; $x++) {
								echo '<option value="' . $x .'"';
								if($x == substr($row->race_date, 0, 4)){
									echo 'selected';
								}
								echo '>' . $x . '</option>';
							} 
						echo '</select></td>';
				echo '</tr>';
				echo '<tr>';
				echo '<td>Time</td>';
				echo '<td> Hour: <select name="hour" size="1">';
							for ($x = 1; $x <= 24; $x++) {
								echo '<option value="' . $x .'"';
								if($x == substr($row->race_date, 12, 2)){
									echo 'selected';
								}
								echo '>' . $x . '</option>';
							} 
						echo '</select>';
						echo 'Minute: <select name="minute" size="1">';
							for ($x = 1; $x <= 60; $x++) {
								echo '<option value="' . $x .'"';
								if($x == substr($row->race_date, 14, 2)){
									echo 'selected';
								}
								echo '>' . $x . '</option>';
							} 
						echo '</select></td>';
				echo '</tr>';
				echo '<tr>';
				echo '<input type="hidden" name="raceId" value="' . $_GET['race_name'] . '">';
				echo '<td colspan="2"><input type="submit" value="Update Race"></td>';
				echo '</tr>';
				?>
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
