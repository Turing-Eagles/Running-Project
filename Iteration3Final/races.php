<!DOCTYPE html> 
<html>
<?php
require 'DbConnect.php';
session_start();
if($_SERVER['REQUEST_METHOD'] == 'POST'){
	$searchCity = $mysqli->real_escape_string(trim($_POST['searchCity']));
	$searchCategory = $mysqli->real_escape_string(trim($_POST['searchCategory']));
	$searchState = $mysqli->real_escape_string(trim($_POST['searchState']));
	$searchName = $mysqli->real_escape_string(trim($_POST['searchName']));
	$searchDay = $mysqli->real_escape_string(trim($_POST['searchDay']));
	$searchMonth = $mysqli->real_escape_string(trim($_POST['searchMonth']));
	$searchYear = $mysqli->real_escape_string(trim($_POST['searchYear']));
	$searchDate;
	if(isset($searchDay) && isset($searchMonth) && isset($searchYear)){
		$searchDate = $searchMonth . '/' . $searchDay . '/' . $searchYear;	
	}
	$q = 'SELECT * FROM races WHERE 1=1 ';
	if($searchDate != '1/1/1900'){
		$q .= " AND race_date = STR_TO_DATE('$searchDate','%m/%d/%Y') ";
	}
	if($searchCity != ''){
		$q .= " AND city = '$searchCity'";
	}
	if($searchState != ''){
		$q .= " AND state = '$searchState'";
	}
	if($searchName != ''){
		$q .= " AND name = '$searchName'";
	}
	if($searchCategory != ''){
		$q .= " AND category = '$searchCategory'";
	}
	$r = $mysqli->query ($q); // Run the query.
}
else{
	$q = 'SELECT * FROM races';
	$r = $mysqli->query ($q); // Run the query.
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
            <li><a href="adminLogin.php">Race Admin</a></li>
            <li><a href="account.php">Account</a></li>
            <li class="current"><a href="races.php">Races</a></li>
            <li><a href="register.php"><?php if(isset($_COOKIE['username'])){echo "Log Out";} else{echo "Register";}?></a></li>
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
            <h3>Races</h3>
            <p>This is the tab that you navigate to in order to find races that you would like to register for. So get searching!</p>         
		  </div><!--close sidebar_item--> 
        </div><!--close sidebar-->
		<div class="sidebar">
          <div class="sidebar_item">
            <h3>Account</h3>
            <p>An account is required in order to register for a race. If you don't see a link to register, try clicking on the register tab at the top right.</p>         
		  </div><!--close sidebar_item--> 
        </div><!--close sidebar-->  	
       </div><!--close sidebar_container-->
	
	  <div id="content">
        <div class="content_item">
		  <div class="form_settings">
            <h2>Races</h2>
			<?php			
			echo '<table align="center" cellspacing="3" cellpadding="3" width="75%">
			<tr><td align="left"><b>Race Name</b></td><td align="left"><b>Race Date</b></td>
			';
			if(isset($_COOKIE['username'])){
				echo '<td align="left"><b>Register</b></td>';
			}
			echo '<td align="left"><b>View Results</b></td>';
			echo '</tr>';
			while ($row = $r->fetch_object()) {
					echo '<tr><td align="left">' . $row->name . '</td><td align="left">' . $row->race_date;
					if(isset($_COOKIE['username'])){
						echo '</td><td align="left"><a href="race.php?race_id=' . $row->race_id . '">REGISTER</a></td>';
					}
					echo '</td><td align="left"><a href="raceResult.php?race_name=' . $row->race_id . '">RESULTS</a></td>';
					echo '</tr>';
			}
			echo '</table>'; // Close the table.
	
			$r->free(); // Free up the resources.
			unset($r);	
			?>
			</div><!--close form_settings-->
		  <div class="form_settings">
		  <h2>Search Criteria</h2>
		  <h3>Fill out any search criteria relevant to your interest</h3>
		  <form action="races.php" method="POST">
		  <?php
		  $q2 = 'SELECT * FROM race_categories';
		  $r2 = $mysqli->query ($q2); // Run the query.
		  echo '<table align="center" cellspacing="3" cellpadding="3" width="75%">';
		  echo '<tr><td>';
		  echo 'Race Category';
		  echo '</td><td>';
		  echo '<select name="searchCategory">';
		  echo '<option value=""></option>';
		  while ($row = $r2->fetch_object()) {
			echo '<option>' . $row->category . '</option>';
		  }
		  echo '</select>';
		  echo '</td></tr><tr><td>';
		  echo 'Race City';
		  echo '</td><td>';
		  echo '<input type="text" name="searchCity"/>';
		  echo '</td</tr><tr><td>';
		  echo 'Race State';
		  echo '</td><td>';
		  echo '<input type="text" name="searchState"/>';
		  echo '</td></tr><tr><td>';
		  echo 'Race Name';
		  echo '</td><td>';
		  echo '<input type="text" name="searchName"/>';
		  echo '</td></tr><tr><td>';
		  echo 'Race Date';
		  echo '</td><td>';
		  ?>
		   Month: <select name="searchMonth" size="1">
				<?php 
				for ($x = 1; $x <= 12; $x++) {
					echo '<option value="' . $x .'">' . $x . '</option>';
				} 
				?>
			</select>
			Day: <select name="searchDay" size="1">
				<?php 
				for ($x = 1; $x <= 30; $x++) {
					echo '<option value="' . $x .'">' . $x . '</option>';
				} 
				?>
			</select>
			Year: <select name="searchYear" size="1">
				<?php 
				for ($x = 1900; $x <= 2015; $x++) {
					echo '<option value="' . $x .'">' . $x . '</option>';
				} 
				?>
			</select>
			</tr>
			</table>
			<input type="submit" value="Search">
			</form>
		  </div>
		</div><!--close content_item-->
      </div><!--close content-->   
	</div><!--close site_content-->  	 
  </div><!--close main-->

  <!-- javascript at the bottom for fast page loading -->
  <script type="text/javascript" src="js/jquery.min.js"></script>
  <script type="text/javascript" src="js/image_slide.js"></script>	
  
</body>
</html>
