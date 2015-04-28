<!DOCTYPE html> 
<html>
<?php
require 'DbConnect.php';
session_start();
if(isset($_COOKIE['username'])){
	setcookie("username", "", time()-3600);//unset cookie
	setcookie("adminUsername", "", time()-3600);//unset cookie
}
require ('login_functions.inc.php');
if($_SERVER['REQUEST_METHOD'] == 'GET'){
	if(isset($_GET['username']) And isset($_GET['password'])){
		$username=$mysqli->real_escape_string(trim($_GET['username']));
		$password=sha1($mysqli->real_escape_string(trim($_GET['password'])));
		if(!$username || !$password){
			echo "You have not entered your username and password.<br />"
				  ."Please go back and try again.";
			exit;
		}
		$q = "SELECT (username) FROM organizer_account WHERE username='$username' AND password='$password'";		
		$r = $mysqli->query ($q); // Run the query.
		// Check the result:
		if (mysqli_num_rows($r) == 1) {
			$row = mysqli_fetch_array($r, MYSQLI_ASSOC);
			// Set the cookies:
			setcookie('adminUsername', $row['username']);
			// Redirect:
			redirect_user('createRace.php');
		}
		else{
				echo '<script type="text/javascript">';
				echo 'window.alert("Incorrect credentials. Please try again")';
				echo '</script>';
		}
	}
}
else if($_SERVER['REQUEST_METHOD'] == 'POST'){
	$newusername=$mysqli->real_escape_string(trim($_POST['newusername']));
	$newpassword=sha1($mysqli->real_escape_string(trim($_POST['newpassword'])));
	$password2=sha1($mysqli->real_escape_string(trim($_POST['password2'])));
	if($newpassword != $password2){
				echo '<script type="text/javascript">';
				echo 'window.alert("Passwords did not match. Please try again")';
				echo '</script>';
		exit;
    }
	if(strlen($_POST['newpassword']) < 7){
		echo '<script type="text/javascript">';
		echo 'window.alert("Password must be at least 7 characters long. Please try again.")';
		echo '</script>';
		exit;
	}
	$q = "insert into organizer_account (username, password) values ('$newusername', '$newpassword')";
	$mysqli->query($q);	
	if ($mysqli->affected_rows == 1) {
		setcookie('adminUsername', $newusername);
		redirect_user('createRace.php');
	}
	else{
		echo '<script type="text/javascript">';
		echo 'window.alert("Error")';
		echo '</script>';
	}
	$mysqli->close(); // Close the database connection.
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
            <li class="current"><a href="adminLogin.php">Race Admin</a></li>
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
            <h3>Admin Login</h3>
            <p>Admins are the people responsible for bringing races to this website. They also fill out the race results after a race is finished.</p>         
		  </div><!--close sidebar_item--> 
        </div><!--close sidebar-->
		<div class="sidebar">
          <div class="sidebar_item">
            <h3>Races</h3>
            <p>Admins can only edit their own races. If you see something wrong with a race, let the Admin of that race know!</p>         
		  </div><!--close sidebar_item--> 
        </div><!--close sidebar-->  	
       </div><!--close sidebar_container-->
	
	  <div id="content">
        <div class="content_item">
		  <div class="form_settings">
            <h2>Admin Login</h2>
			<form action="adminLogin.php" method="get">
			<table border="0">
				<tr>
					<td>User Name</td>
					<td><input type="text" name="username" maxlength="15" size="30"></td>
				</tr>
				<tr>
					<td>Password</td>
					<td><input type="password" name="password" maxlength="35" size="30"></td>
				</tr>
				</table>
				<td colspan="2"><input type="submit" value="Log in"></td>
			</form>
			<h2>Admin Create</h2>
			<form action="adminLogin.php" method="post">
			<table border="0">
				<tr>
					<td>User Name</td>
					<td><input type="text" name="newusername" maxlength="15" size="30"></td>
				</tr>
				<tr>
					<td>Password</td>
					<td><input type="password" name="newpassword" maxlength="35" size="30"></td>
				</tr>
				<tr>
					<td>Re-enter Password</td>
					 <td><input type="text" name="password2" maxlength="15" size="30"></td>
				</tr>
				</table>
				<td colspan="2"><input type="submit" value="Register"></td>
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
