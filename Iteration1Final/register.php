<!DOCTYPE html> 
<html>
<?php
require 'DbConnect.php';
// For processing the login:
require ('login_functions.inc.php');
  if(isset($_COOKIE['username'])){
	setcookie("username", "", time()-3600);//unset cookie
  }
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  // create short variable names
  $fName=$mysqli->real_escape_string(trim($_POST['fName']));
  $lName=$mysqli->real_escape_string(trim($_POST['lName']));
  $uName=$mysqli->real_escape_string(trim($_POST['uName']));
  $password=$mysqli->real_escape_string(trim($_POST['password']));
  $password2=$mysqli->real_escape_string(trim($_POST['password2']));
  $sex=$mysqli->real_escape_string(trim($_POST['sex']));
  $year=$mysqli->real_escape_string(trim($_POST['year']));
  $day=$mysqli->real_escape_string(trim($_POST['day']));
  $month=$mysqli->real_escape_string(trim($_POST['month']));

  if (!$fName || !$lName || !$uName || !$sex || !$password) {
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
  if(!isset($_POST['uName'])){
  echo "You have not entered the Username.<br />"
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
  $q = "insert into racer_account (first_name, last_name, username, password, birthdate, sex) values ('$fName', '$lName', '$uName', '$password', STR_TO_DATE('$birthString', '%m/%d/%Y'), '$sex')";
  $mysqli->query($q);	
  if ($mysqli->affected_rows == 1) {
  setcookie('username', $uName);
  redirect_user('races.php');
  }
  $mysqli->close(); // Close the database connection.
}
else if($_SERVER['REQUEST_METHOD'] == 'GET'){
  if(isset($_GET['logInUsername']) && isset($_GET['logInPassword'])){
  $uName=$mysqli->real_escape_string(trim($_GET['logInUsername']));
  $pass=$mysqli->real_escape_string(trim($_GET['logInPassword']));
  // Retrieve the user_id and first_name for that email/password combination:
  $q = "SELECT (username) FROM racer_account WHERE username='$uName' AND password='$pass'";		
  $r = $mysqli->query ($q); // Run the query.
  // Check the result:
  if (mysqli_num_rows($r) == 1) {
    $row = mysqli_fetch_array($r, MYSQLI_ASSOC);
	// Set the cookies:
	setcookie('username', $row['username']);
	// Redirect:
	redirect_user('races.php');
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
            <li><a href="placeholder.php">Placeholder</a></li>
            <li><a href="account.php">Account</a></li>
            <li><a href="races.php">Races</a></li>
            <li class="current"><a href="register.php">Register</a></li>
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
            <p>The community for local racing.</p>
          </div><!--close sidebar_item--> 
        </div><!--close sidebar-->     		
		<div class="sidebar">
          <div class="sidebar_item">
            <h2>Header...</h2>
            <h3>5k of the Week</h3>
            <p>I love this website</p>         
		  </div><!--close sidebar_item--> 
        </div><!--close sidebar-->
		<div class="sidebar">
          <div class="sidebar_item">
            <h3>5k of the Month</h3>
            <p>This website is better than the best thing</p>         
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
            <h2>Registration</h2>
			  <form action="register.php" method="post">
				<table border="0">
				  <tr>
					<td>Username</td>
					 <td><input type="text" name="uName" maxlength="15" size="30"></td>
				  </tr>
				  <tr>
					<td>Password</td>
					 <td><input type="text" name="password" maxlength="15" size="30"></td>
				  </tr>
				  <tr>
					<td>Re-enter Password</td>
					 <td><input type="text" name="password2" maxlength="15" size="30"></td>
				  </tr>
				  <tr>
					<td>First Name</td>
					 <td><input type="text" name="fName" maxlength="15" size="30"></td>
				  </tr>
				  <tr>
					<td>Last Name</td>
					<td> <input type="text" name="lName" maxlength="15" size="30"></td>
				  </tr>
				  <tr>
					<td>Birthday</td>
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
					<td>Sex</td>
					<td><select name="sex" size="1">
						<option value="M">Male</option>
						<option value="F">Female</option>
						</select></td>
				  </tr>
				  <tr>
					<td colspan="2"><input type="submit" value="Register"></td>
				  </tr>
				</table>
			  </form>
			  <h2>Already have an account?</h2>
			  <form action="register.php" method="get">
				<table border="0">
				  <tr>
					<td>Username</td>
					 <td><input type="text" name="logInUsername" maxlength="15" size="30"></td>
				  </tr>
				  <tr>
					<td>Password</td>
					 <td><input type="text" name="logInPassword" maxlength="15" size="30"></td>
				  </tr>
				  <tr>
					<td colspan="2"><input type="submit" value="Log In"></td>
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
