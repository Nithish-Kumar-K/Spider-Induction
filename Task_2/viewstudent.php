<!DOCTYPE html>
<?php
// define variables and set to empty values
session_start();
$rollnoErr = "";
$rollno = "";
$flag=1;

if ($_GET) {
		//use of htmlspecialchars is to prevent hacking
   if(!preg_match("/^\d{9}$/",$_GET["rollno"])) {
     $rollnoErr = "*Roll number should have exactly nine digits";
     $flag=0;
   }
   else {
     $rollno=htmlspecialchars($_GET["rollno"]);
   }
	 $_SESSION['rollno'] = $rollno;
   //if roll no is valid
   if($flag){
		 $conn = mysqli_connect("localhost", "Nithish", "Hohaahoh","student_database");
	   if(!$conn){
	     die("Error! Cannot connect to the database");
	   }
	   $selquery="SELECT * FROM students WHERE ROLLNO = $rollno";
	   $result = $conn->query($selquery);
	   if ($result->num_rows > 0) {
	     //non empty
	     $row = $result->fetch_assoc();
	     $_SESSION['name']  = $row["NAME"];
	     $_SESSION['email']  = $row["EMAIL"];
	     $_SESSION['addr']  = $row["ADDRESS"];
	     $_SESSION['dept']  = $row["DEPARTMENT"];
	     $_SESSION['abtme']  = $row["ABOUT_ME"];
			 header('Location: detailspage.php');
       //go to page detailspage.php
	 }
	 else {
	     echo '<script type="text/javascript">alert("No such student");</script>';
	     //header('Location: viewstudent.php');
	 }
	    $conn->close();

	 }
}
?>

	<html>
		<head>
			<link type="text/css" rel="stylesheet" href="studentdatabase.css"/>
			<title>
        View Student
      </title>
		</head>

		<body >

			<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="get" name="studentview">

				<!--the spans are providing error message, rollnoError stores the error message-->

				<h3>Please give the Roll Number of the student</h3>
				<input type="number" name="rollno" style="width:24.7em" placeholder="Type your roll number"
				value="<?php echo $rollno;?>" >
				<span class="error"> <?php echo $rollnoErr;?></span><br/><br/>
				<input type="submit" name="submit" value="Search">
        <button type="button" id="advancedoptions" onclick="location.href='advanced_options.php'">Advanced Options</button>
			</form>
		</body>
	</html>
