<!DOCTYPE html> 
<html>
<?php
require 'DbConnect.php';
session_start();
require ('login_functions.inc.php');
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
		    <h2>Search Criteria</h2>
		    <form action="raceResult.php" method="GET">
				First Name <input name="searchFName" type="text"/><br>
				Last Name <input name="searchLName" type="text"/><br>
				Sex <select name="searchSex"><option selected></option><option>M</option><option>F</option></select><br>
				<input type="hidden" value="<?php echo $_GET['race_name']?>" name="race_name"/><br>
				Sort By <select name="sortBy"><option value="finishing_place">Finishing Place</option><option value="Sex">Sex</option><option value="birthdate">Birth Date</option></select><br>
				<input type="submit" value="Search"/>
			</form>
            <h2>Race Results</h2>
				<table border="1" align="center" cellspacing="3" cellpadding="3" width="75%">
				<th>Name</th><th>Time</th><th>Place</th><th>Sex</th><th>Age At Race</th>
					<?php
					$raceName = ($_GET["race_name"]);
					$fName;
					$lName;
					$sex;
					$orderBy;
					if(isset($_GET['searchFName'])){
						$fName = $_GET['searchFName'];
					}
					if(isset($_GET['sortBy'])){
						$orderBy = $_GET['sortBy'];
					}
					else{
						$orderBy = "finishing_place";
					}
					if(isset($_GET['searchLName'])){
						$lName = $_GET['searchLName'];
					}
					if(isset($_GET['searchSex'])){
						$sex = $_GET['searchSex'];
					}
					$q = "SELECT * FROM racer_participation INNER JOIN racer_account ON username = racer_name INNER JOIN races ON race_id = race_name WHERE race_name = '$raceName'";
					if(isset($_GET['searchFName']) && $_GET['searchFName'] != ''){
						$q = $q . " AND first_name = '$fName'";
					}
					if(isset($_GET['searchLName']) && $_GET['searchLName'] != ''){
						$q = $q . " AND last_name = '$lName'";
					}
					if(isset($_GET['searchSex']) && $_GET['searchSex'] != ''){
						$q = $q . " AND sex = '$sex'";
					}
					$q = $q . " " .	"ORDER BY " .  $orderBy;
					$r = $mysqli->query ($q); // Run the query.
					while($row = $r->fetch_object()){
						echo '<tr>';
						echo '<td>';
						echo $row->first_name . " " . $row->last_name;
						echo '</td>';
						echo '<td>';
						echo $row->finishing_time;
						echo '</td>';
						echo '<td>';
						echo $row->finishing_place;
						echo '</td>';
						echo '<td>';
						echo $row->sex;
						echo '</td>';
						echo '<td>';
						echo floor(abs(strtotime($row->race_date) - strtotime($row->birthdate)) / (365*60*60*24));
						echo '</td>';
						echo '</tr>';
					}
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
