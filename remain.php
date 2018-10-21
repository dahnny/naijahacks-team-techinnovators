<?php


 define('DB_HOST', 'localhost');
 define('DB_NAME', 'student_db');
 define('DB_USER','root');
 define('DB_PASSWORD','');

$con=mysql_connect(DB_HOST,DB_USER,DB_PASSWORD) or die("Failed to connect to MySQL: " . mysql_error()); 
$db=mysql_select_db(DB_NAME,$con) or die("Failed to connect to MySQL: " . mysql_error());


function SignIn(){
session_start();

if($_SERVER["REQUEST_METHOD"]=="POST"){
if(empty($_POST["pass"])){$passErr = "Password required";}
if(empty($_POST["name"])){
	$nameErr = "Name is required";}


else{
	$name = test_input($_POST["name"]);
if(!preg_match("/^[a-zA-Z]*$/",$name)){
	$nameErr  = "Only letters and white space allowed";}

$query = mysql_query("SELECT username,password,status FROM tables where username =
'$_POST[name]'AND password = '$_POST[pass]'AND status = '$_POST[status]'")or die(mysql_error());
$row = mysql_fetch_array($query);

if(!empty($row['username']) AND !empty($row['password'])AND !empty($row['status']))
{
if($row['status'] == "student"){
header("Location: student.html");
exit();}
if($row['status'] == "teacher"){
header("Location:teacher.html");
exit();}
}
 
else{$mainErr = "Sorry You entered Incorrect Id and password";
echo "fghjkl";

}
if(empty($_POST["status"])){
	$statusErr = "Status required";
}
}

}
}
function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
if(isset($_POST['submit'])) 
{ SignIn(); } 
?>
