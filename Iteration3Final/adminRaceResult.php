<!DOCTYPE html> 
<html>
<?php
require 'DbConnect.php';
session_start();
require ('login_functions.inc.php');
if(!isset($_COOKIE['adminUsername'])){
	redirect_user('adminLogin.php');
}
if($_SERVER['REQUEST_METHOD'] == 'GET'){
	$organizerName = ($_COOKIE["adminUsername"]);
	$raceName = ($_GET["race_name"]);
	$q = "SELECT * FROM organizer_participation WHERE organizer_name = '$organizerName' AND race_name = '$raceName'";
	$r = $mysqli->query ($q); // Run the query.
	if($r->num_rows != 1){
		redirect_user('adminLogin.php');
	}
}
if($_SERVER['REQUEST_METHOD'] == 'POST'){
	for($i = 0; $i < count($_POST['runnerName']); $i++) {
		$runnerName = $_POST['runnerName'][$i];
		$raceName = $_POST['raceName'][$i];
		$hour = $_POST['hour'][$i];
		$min = $_POST['min'][$i];
		$sec = $_POST['sec'][$i];
		$time = $hour.":".$min.":".$sec;
		$place = $_POST['place'][$i];
		$q = "UPDATE racer_participation SET finishing_time = STR_TO_DATE('$time','%H:%i:%s'), finishing_place = '$place' WHERE racer_name = '$runnerName' AND race_name = '$raceName'";
		$mysqli->query($q);
		if ($mysqli->affected_rows != 1) {
			echo '<script type="text/javascript">';
			echo 'window.alert("We have problems, Central")';
			echo '</script>';
		}
	}
	redirect_user('adminRacesResult.php');
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
            <li><a href="editRace.php">Edit Race</a></li>
            <li class="current"><a href="adminRacesResult.php">Race Results</a></li>
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
            <h3>Edit Race Results</h3>
            <p>In this page, you can edit the results of your race with the finishing times and places of those who have registered.</p>         
		  </div><!--close sidebar_item--> 
        </div><!--close sidebar-->
		<div class="sidebar">
          <div class="sidebar_item">
            <h3>Race Results</h3>
            <p>As usual, only the organizer of a race can edit their own race results.</p>         
		  </div><!--close sidebar_item--> 
        </div><!--close sidebar-->  	
       </div><!--close sidebar_container-->
	
	  <div id="content">
        <div class="content_item">
		  <div class="form_settings">
            <h2>Race Results</h2>
			<form action="adminRaceResult.php" method="POST">
				<table border="1" align="center" cellspacing="3" cellpadding="3" width="75%">
				<th>Name</th><th>Time</th><th hidden="true">race</th><th>Place</th>
					<?php
					$raceName = ($_GET["race_name"]);
					$q = "SELECT * FROM racer_participation WHERE race_name = '$raceName'";
					$r = $mysqli->query ($q); // Run the query.
					while($row = $r->fetch_object()){
						echo '<tr>';
						echo '<td>';
						echo '<input readonly type="text" value="' . $row->racer_name .'" name="runnerName[]"/>';
						echo '</td>';
						echo '<td>';
						
						echo '<select name="hour[]" size="1">'; 
							for ($x = 0; $x <= 10; $x++) {
								echo '<option value="' . $x .'"';
								if($x == substr($row->finishing_time, 0, 2)){
									echo 'selected';
								}
								echo '>' . $x . '</option>';
							} 
						echo '</select>';
						echo '<select name="min[]" size="1">';
							for ($x = 0; $x <= 60; $x++) {
								echo '<option value="' . $x .'"';
								if($x == substr($row->finishing_time, 4, 2)){
									echo 'selected';
								}
								echo '>' . $x . '</option>';
							} 
						echo '</select>';
						echo '<select name="sec[]" size="1">';
							for ($x = 0; $x <= 60; $x++) {
								echo '<option value="' . $x .'"';
								if($x == substr($row->finishing_time, 6, 2)){
									echo 'selected';
								}
								echo '>' . $x . '</option>';
							} 
						echo '</select>';
						echo '</td>';
						echo '<td hidden="true">';
						echo '<input type="text" value="'. $row->race_name .'" name="raceName[]"/>';
						echo '</td>';
						echo '<td>';
						echo '<input type="text" name="place[]" value="' . $row->finishing_place . '"/>';
						echo '</td>';
						echo '</tr>';
					}
					?>
				</table>
				<td colspan="2"><input type="submit" value="Update Results"></td>
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
