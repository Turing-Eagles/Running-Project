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
 echo "<p>The user was inserted.</p>";
 } else {
 echo '<h1>System Error</h1>';
 // Debugging message:
echo '<p>' . $mysqli->error . '<br /><br />Query: ' . $q . '</p>';
}

  $mysqli->close(); // Close the database connection.
  }
?>
