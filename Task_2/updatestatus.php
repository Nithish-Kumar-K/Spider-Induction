<!DOCTYPE html>
<?php
// define variables and set to empty values
session_start();
$conn = mysqli_connect("localhost", "Nithish", "Hohaahoh","student_database");
if(!$conn){
  die("Error! Cannot connect to the database");
}

$rollno=$_SESSION['rollno'];
$name=$_SESSION['name'];
$email=$_SESSION['email'];
$addr=$_SESSION['addr'];
$dept=$_SESSION['dept'];
$abtme=$_SESSION['abtme'];

$selquery="SELECT * FROM students WHERE ROLLNO = $rollno";
$result = $conn->query($selquery);

if ($result->num_rows > 0) {
  $row = $result->fetch_assoc();
  $passcodeorg  = $row["PASSCODE"];
}
//compare from original database and user's input here
if(strcmp($passcodeorg,$_SESSION['passcode']) == 0){
  $sqlinse=$conn->prepare("UPDATE students SET NAME=?, DEPARTMENT=?, EMAIL=?,
    ADDRESS=?, ABOUT_ME=?  WHERE ROLLNO=?");

  //this will prevent sql injection
   if($sqlinse) {
     $sqlinse->bind_param("sssssi",$name,$dept,$email,$addr,$abtme,$rollno);
   }
   else {
     die("Error preparing statements");
   }
   $regis = $sqlinse->execute();
   if($regis) {
     echo "You have updated successfully. <br>";
   }
  else {
     echo "Error Type : ",mysqli_error($conn),"<br>";
     die("Error updating into database");
   }
}
else{
  echo "You have given the incorrect password .Update failed! <br>";
}
  $sqlins->close();
  //close connection to improve efficiency
?>

	<html>
		<head>
			<link type="text/css" rel="stylesheet" href="studentdatabase.css"/>
			<title>
        Update Status
      </title>
      <style>
        body{
          text-align: left;
        }
        
        h1{
          transform: translate(38vw);
        }

      </style>
		</head>

		<body >

		</body>
	</html>
