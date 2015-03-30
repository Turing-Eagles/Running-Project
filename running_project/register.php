<!DOCTYPE html> 
<html>
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
            <li><a href="index.html">Home</a></li>
            <li><a href="ourwork.html">Our Work</a></li>
            <li><a href="testimonials.html">Testimonials</a></li>
            <li><a href="projects.html">Projects</a></li>
            <li class="current"><a href="contact.html">Register</a></li>
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
            <p>WELL, WE NEED SOME DATA! SILLY!!</p>         
		  </div><!--close sidebar_item--> 
        </div><!--close sidebar-->
		<div class="sidebar">
          <div class="sidebar_item">
            <h3>5k of the Month</h3>
            <p>WELL, WE NEED SOME DATA! SILLY!!</p>         
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
					<td>First Name</td>
					 <td><input type="text" name="fName" maxlength="15" size="30"></td>
				  </tr>
				  <tr>
					<td>Last Name</td>
					<td> <input type="text" name="lName" maxlength="15" size="30"></td>
				  </tr>
				  <tr>
					<td>Age</td>
					<td> <input type="number" name="age" maxlength="2" size="5"></td>
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

<?php
require 'DbConnect.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  // create short variable names
  $fName=$mysqli->real_escape_string(trim($_POST['fName']));
  $lName=$mysqli->real_escape_string(trim($_POST['lName']));
  $age=$mysqli->real_escape_string(trim($_POST['age']));
  $sex=$mysqli->real_escape_string(trim($_POST['sex']));

  if (!$fName || !$lName || !$age || !$sex) {
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
  if(!isset($_POST['age'])){
  echo "You have not entered the age.<br />"
          ."Please go back and try again.";
     exit;
  }
  if(!isset($_POST['sex'])){
  echo "You have not entered the sex.<br />"
          ."Please go back and try again.";
     exit;
  }
  
  
  $q = "insert into sample_alpha_user (fName, lName, age, sex) values ('$fName', '$lName', '$age', '$sex')";
  $mysqli->query($q);	
 if ($mysqli->affected_rows == 1) {
 //success...
 } else {
 echo '<h1>System Error</h1>';
 // Debugging message:
echo '<p>' . $mysqli->error . '<br /><br />Query: ' . $q . '</p>';
}

  $mysqli->close(); // Close the database connection.
  }
?>

