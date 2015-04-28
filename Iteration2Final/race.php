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
		echo '<script type="text/javascript">';
		echo 'window.alert("'. $q .'")';
		echo '</script>';
	$mysqli->query($q);	
	if ($mysqli->affected_rows == 1) {
		redirect_user('races.php');
		echo '<script type="text/javascript">';
		echo 'window.alert("successful insertion")';
		echo '</script>';
	}
	else{
		echo '<script type="text/javascript">';
		echo 'window.alert("failure insertion")';
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
            <li><a href="createRace.php">Create Race</a></li>
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
			echo 'TIME: ' . $row->race_time . '<br>';
			
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
