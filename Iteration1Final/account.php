<!DOCTYPE html> 
<html>
<?php
require 'DbConnect.php';
session_start();
require ('login_functions.inc.php');
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  // create short variable names
  $fName=$mysqli->real_escape_string(trim($_POST['fName']));
  $lName=$mysqli->real_escape_string(trim($_POST['lName']));
  $password=$mysqli->real_escape_string(trim($_POST['password']));
  $password2=$mysqli->real_escape_string(trim($_POST['password2']));
  $sex=$mysqli->real_escape_string(trim($_POST['sex']));
  $year=$mysqli->real_escape_string(trim($_POST['year']));
  $day=$mysqli->real_escape_string(trim($_POST['day']));
  $month=$mysqli->real_escape_string(trim($_POST['month']));
  $uName = $_COOKIE['username'];

  if (!$fName || !$lName || !$sex || !$password) {
     echo "You have not entered all the required details.<br />"
          ."Please go back and try again.";
     exit;
  }
  if(!isset($_POST['fName'])){
  echo "You have not entered the fName.<br />"
          ."Please go back and try again.";
     exit;
  }
  if(!isset($_POST['lName'])){
  echo "You have not entered the lName.<br />"
          ."Please go back and try again.";
     exit;
  }
  if(!isset($_POST['sex'])){
  echo "You have not entered the sex.<br />"
          ."Please go back and try again.";
     exit;
  }
  if(!isset($_POST['password'])){
  echo "You have not entered the password.<br />"
          ."Please go back and try again.";
     exit;
  }
  if($password != $password2){
  echo "Passwords do not match.<br />"
          ."Please go back and try again.";
     exit;
  }
  
  if(strlen($password) < 7){
  echo "Password must be at least 7 characters.<br />"
          ."Please go back and try again.";
     exit;
  }
  
  $birthString = $month . '/' . $day . '/' . $year;
  $q = "update racer_account set first_name = '$fName', last_name = '$lName',  password = '$password', birthdate = STR_TO_DATE('$birthString', '%m/%d/%Y'), sex = '$sex' where username = '$uName'";
  $mysqli->query($q);	
  $mysqli->close(); // Close the database connection.
  redirect_user('races.php');
}
else if($_SERVER['REQUEST_METHOD'] == 'GET'){
  
}

?>
<head>
  <title>The Running Project</title>
  <meta name="description" content="website description" />
  <meta name="keywords" content="website keywords, website keywords" />
  <meta http-equiv="content-type" content="text/html; charset=windows-1252" />
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
            <li><a href="placeholder.php">Placeholder</a></li>
            <li class="current"><a href="account.php">Account</a></li>
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
            <h2>New Website</h2>
            <p>Welcome to our new website. Please have a look around, any feedback is much appreciated.</p>
          </div><!--close sidebar_item--> 
        </div><!--close sidebar-->     		
		<div class="sidebar">
          <div class="sidebar_item">
            <h2>Latest Update</h2>
            <h3>March 2013</h3>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque cursus tempor enim.</p>         
		  </div><!--close sidebar_item--> 
        </div><!--close sidebar-->
		<div class="sidebar">
          <div class="sidebar_item">
            <h3>February 2013</h3>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque cursus tempor enim.</p>         
		  </div><!--close sidebar_item--> 
        </div><!--close sidebar-->  		
        <div class="sidebar">
          <div class="sidebar_item">
            <h2>Contact</h2>
            <p>Phone: +44 (0)1234 567891</p>
            <p>Email: <a href="mailto:info@youremail.co.uk">info@youremail.co.uk</a></p>
          </div><!--close sidebar_item--> 
        </div><!--close sidebar-->
       </div><!--close sidebar_container-->
	
	  	  <div id="content">
        <div class="content_item">
		  <div class="form_settings">
            <h2>Edit Account Information</h2>
			  <form action="account.php" method="post">
				<?php
				$userName = $_COOKIE['username'];
				$q = 'SELECT * FROM racer_account WHERE username = "' . $userName . '"';
				$r = $mysqli->query ($q); // Run the query.
				if (mysqli_num_rows($r) == 1) {
					$row = mysqli_fetch_array($r, MYSQLI_ASSOC);
					// Set the cookies:
					$password =  $row['password'];
					$sex = $row['sex'];
					$firstName = $row['first_name'];
					$lastName = $row['last_name'];
					$birthDate = $sex = $row['birthdate'];
				}
				?>
				<table border="0">
				  <tr>
					<td>Change Password</td>
					 <td><input type="text" name="password" maxlength="15" size="30"
					 <?php
					 echo 'value=" ' . $password . '"'
					 ?>
					 ></td>
				  </tr>
				  <tr>
					<td>Re-enter Password</td>
					 <td><input type="text" name="password2" maxlength="15" size="30"
					 <?php
					 echo 'value=" ' . $password . '"'
					 ?>
					 ></td>
				  </tr>
				  <tr>
					<td>Change First Name</td>
					 <td><input type="text" name="fName" maxlength="15" size="30"
					 <?php
					 echo 'value=" ' . $firstName . '"'
					 ?>
					 ></td>
				  </tr>
				  <tr>
					<td>Change Last Name</td>
					<td> <input type="text" name="lName" maxlength="15" size="30"
					<?php
					 echo 'value=" ' . $lastName . '"'
					 ?>
					></td>
				  </tr>
				  <tr>
					<td>Change Birthday</td>
					<td> Month: <select name="month" size="1">
							<?php 
							for ($x = 1; $x <= 12; $x++) {
								echo '<option ';
								if($x == substr($birthDate, 5, 2)){
									echo 'selected';
								}
								echo ' value="' . $x .'">' . $x . '</option>';
							} 
							?>
						</select>
						Day: <select name="day" size="1">
							<?php 
							for ($x = 1; $x <= 30; $x++) {
								echo '<option ';
								if($x == substr($birthDate, 8, 2)){
									echo 'selected';
								}
								echo ' value="' . $x .'">' . $x . '</option>';
							} 
							?>
						</select>
						Year: <select name="year" size="1">
							<?php 
							for ($x = 1900; $x <= 2015; $x++) {
								echo '<option ';
								if($x == substr($birthDate, 0, 4)){
									echo 'selected';
								}
								echo ' value="' . $x .'">' . $x . '</option>';
							} 
							?>
						</select></td>
				  </tr>
				  <tr>
					<td>Change Sex</td>
					<td><select name="sex" size="1">
						<option value="M"
						<?php
						if($sex == 'M'){
							echo 'selected';
						}
						?>
						>Male</option>
						<option value="F"
						<?php
						if($sex == 'F'){
							echo 'selected';
						}
						?>
						>Female</option>
						</select></td>
				  </tr>
				  <tr>
					<td colspan="2"><input type="submit" value="Submit"></td>
				  </tr>
				</table>
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
