<!DOCTYPE html>
<?php
  session_start();
  // define variables and set to empty values

  $name = $email  = $addr = $rollno = $dept =$abtme= "";
  $flag=1;
  //use details of student from database
  $rollno=$_SESSION['rollno'];
  $name=$_SESSION['name'];
  $email=$_SESSION['email'];
  $addr=$_SESSION['addr'];
  $dept=$_SESSION['dept'];
  $abtme=$_SESSION['abtme'];
  ?>

  <html>
		<head>
			<link type="text/css" rel="stylesheet" href="studentdatabase.css"/>
      <style>
        body{
          text-align: left;
        }
        h1{
          transform: translate(38vw);
        }

      </style>
      <title>
        Add Student
      </title>
		</head>

		<body >
        <h1 >Student Details</h1>
          <h3>Roll number:</h3><?php echo $rollno;?><br/>
          <h3>Name:</h3><?php echo $name;?><br/>
          <h3>Depatment:</h3><?php echo $dept;?><br/>
          <h3>E-Mail:</h3><?php echo $email;?><br/>
          <h3>Residential address:</h3><?php echo $addr;?><br/>
          <h3>About Me:</h3><?php echo $abtme;?><br/><br/>
          <!--go to page editdetails-->
          <button type="button" onclick="location.href='editdetails.php'">Edit details</button>

		</body>
	</html>
