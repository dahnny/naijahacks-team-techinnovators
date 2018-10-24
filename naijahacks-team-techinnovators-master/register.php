<?php
session_start();

// initializing variables
$username = "";
$email    = "";
$password = "";
$FirstName ="";
$LastName ="";
$status = "";

$errors = array(); 

// connect to the database

$db = mysqli_connect('localhost', 'root', '', 'student_db')or die(mysqli_connect_error());

// REGISTER USER
if (isset($_POST['reg_user'])) {
  // receive all input values from the form
  echo "started";
  $username = mysqli_real_escape_string($db,$_POST['UserName']);
  $email = mysqli_real_escape_string($db,$_POST['email']);
  $password =mysqli_real_escape_string( $db,$_POST['Password']);
  $FirstName =mysqli_real_escape_string($db,$_POST['FirstName']);
  $LastName = mysqli_real_escape_string($db,$_POST['LastName']);
  $status =mysqli_real_escape_string($db,$_POST['status']);

  // form validation: ensure that the form is correctly filled ...
  // by adding (array_push()) corresponding error unto $errors array
  if (empty($_POST['UserName'])) { array_push($errors, "Username is required"); echo ("Username is required\n");}
  if (empty($email)) { array_push($errors, "Email is required"); echo"email is required\n";}
  if (empty($password)) { array_push($errors, "Password is required"); echo ("Password required\n");}
  if (empty($FirstName)) { array_push($errors, "FirstName is required"); } 
  if (empty($LastName)) { array_push($errors, "LastName is required"); }
  if (empty($status)) { array_push($errors, "status is required"); }
 

  // first check the database to make sure 
  // a user does not already exist with the same username and/or email
  $user_check_query = "SELECT * FROM tables WHERE username='_POST[UserName]' AND email='_POST[email]' ";
  $result = mysqli_query($db, $user_check_query);
  $user = mysqli_fetch_assoc($result);
  echo "still working";
  
  if ($user) { // if user exists
    if ($user['username'] === $username) {
      array_push($errors, "Username already exists");
	  echo "rubii";
    }

    if ($user['email'] === $email) {
      array_push($errors, "email already exists");
    }
  }

  // Finally, register user if there are no errors in the form
  if (count($errors) == 0) {
  	echo "fghjk";
	$password = md5($password);//encrypt the password before saving in the database

  	$query = "INSERT INTO tables (username, email, password,firstname,lastname,status) 
  			  VALUES('$username', '$email', '$password', '$FirstName','$LastName','$status')";
  	mysqli_query($db, $query);
  	$_SESSION['username'] = $username;
  	$_SESSION['success'] = "You are now logged in";
	echo "vbhjkl;";
	if ($_POST['status']== 'student'){
		header('Location:course-details.html');
		
	}
  else if ($_POST['status']== 'teacher' ){
	  header('Location:courses.html');
  }
  }
}