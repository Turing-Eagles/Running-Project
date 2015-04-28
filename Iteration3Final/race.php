<!DOCTYPE html> 
<html>
<?php
require 'DbConnect.php';
session_start();
if($_SERVER['REQUEST_METHOD'] == 'POST'){
	require ('login_functions.inc.php');
	$username=$mysqli->real_escape_string(trim($_POST['username']));
	$raceid=$mysqli->real_escape_string(trim($_POST['raceid']));
	$q = "insert into racer_participation (racer_name, race_name) values ('$username', '$raceid')";
	$mysqli->query($q);	
	if ($mysqli->affected_rows == 1) {
		redirect_user('races.php');
		echo '<script type="text/javascript">';
		echo 'window.alert("successful insertion")';
		echo '</script>';
	}
	else{
		echo '<script type="text/javascript">';
		echo 'window.alert("You are already registered for this race!")';
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
          <li class="show"><img width="940" height="250" src="images/home_1.jpg" alt="&quot;Unscramble the sentence&quot;" /></li>
          <li><img width="940" height="250" src="images/home_2.jpg" alt="&quot;Matt Kuhn is programmer best&quot;" /></li>
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
			if (isset($_GET['race_id'])){ // From races.php
				$raceid = $_GET['race_id'];
			}
			$q = 'SELECT * FROM races WHERE race_id = ' . $raceid;
			$r = $mysqli->query ($q); // Run the query.
			$row = $r->fetch_object();
			echo 'NAME: ' . $row->name . '<br>';
			echo 'CATEGORY: ' . $row->category . '<br>';
			echo 'DATE: ' . $row->race_date . '<br>';
			
			echo '<form action="race.php" method="post">';
			echo '<input type="hidden" name="raceid" value="' . $raceid . '"/>';
			echo '<input type="hidden" name="username" value="' . $_COOKIE['username'] . '"/>';
			echo '<input type="submit" value="Register">';
			
			echo '<h2>Racers</h2>';
			$q = 'SELECT * FROM racer_participation WHERE race_name=' . $raceid;
			$r = $mysqli->query ($q); // Run the query.
			$num = $r->num_rows;
			if($num > 0){
				while ($row = $r->fetch_object()) {
						echo $row->racer_name .' <br> ';
				}
			}
			?>
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
