<!DOCTYPE html>
<?php
// define variables and set to empty values
session_start();

$orderby=$dept="";
if ($_GET) {
     $dept=htmlspecialchars($_GET["dept"]);
     $orderby=htmlspecialchars($_GET["orderby"]);
     $secondary="NAME"; //secondary parameter for orderby

		 $conn = mysqli_connect("localhost", "Nithish", "Hohaahoh","student_database");
	   if(!$conn){
	     die("Error! Cannot connect to the database");
	   }

     if($orderby == "NAME")
      $secondary = "ROLLNO";

     if($dept == 'View All Departments')
      $dept = '%';
      if($orderby == "NAME")
      $selquery="SELECT * FROM students WHERE DEPARTMENT LIKE '$dept' ORDER BY  DEPARTMENT, NAME, ROLLNO";
     else{
      $selquery="SELECT * FROM students WHERE DEPARTMENT LIKE '$dept' ORDER BY  DEPARTMENT, ROLLNO, NAME";
     }
	   $result = $conn->query($selquery);
     if($result){
       if($result->num_rows > 0) {
              $rsltmess = $result->num_rows.' Results found'.'<br>';
              echo "<table align='center'>";
              echo '<tr><th>Name</th><th>Roll No</th><th>Department</th><th>Email</th><th>Address</th>
              <th>About Me</th></tr>';
              while($row = mysqli_fetch_assoc($result)) {
                echo '<tr><td>';
                echo $row['NAME'];
                echo '</td><td>';
                echo $row['ROLLNO'];
                echo '</td><td>';
                echo $row['DEPARTMENT'];
                echo '</td><td>';
                echo $row['EMAIL'];
                echo '</td><td>';
                echo $row['ADDRESS'];
                echo '</td><td>';
                echo $row['ABOUT_ME'];
                echo '</td></tr>';
              }
              //echo '</table>';
            }
            else {
              $rsltmess = "No results found!<br>";
            }
     }
     else{
       die("Error getting data!");
     }

	    $conn->close();
}
?>

	<html>
		<head>
			<link type="text/css" rel="stylesheet" href="studentdatabase.css"/>

			<title>
        View Student
      </title>
      <style>
        body {
          font-family: calibri,sans-serif;
          color: darkslategray;
        }
        th {
          background-color: #58FAF4;
          color:black;
          font-weight: 200;
        }
        th,td {
          text-align: center;
          font-family: calibri,sans-serif;
          padding: 7px;
          border-bottom: 1px solid darkgray;
        }
        tr:nth-child(odd) {
          background-color: lightgray;
          color : black;
        }
    </style>
		</head>

		<body >

			<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="get" name="studentview">
        <h2>Please select the options for your search</h2>
        <br/>
        <!--the spans are providing error message, rollnoError stores the error message-->
        <h3> Select the department you wish to view</h3>

        <br/>
        <select name="dept">
          <option value="View All Departments" > View All Departments </option>
          <option value="Computer Science and Engineering"> Computer Science and Engineering </option>
          <option value="Electronics and Communication Engineering"> Electronics and Communication Engineering </option>
          <option value="Electrical and Electronics Engineering"> Electrical and Electronics Engineering </option>
          <option value="Mechanical Engineering"> Mechanical Engineering </option>
          <option value="Instrumentation and Control Engineering"> Instrumentation and Control Engineering </option>
          <option value="Civil Engineering"> Civil Engineering </option>
          <option value="Production Engineering"> Production Engineering </option>
          <option value="Chemical Engineering"> Chemical Engineering </option>
          <option value="Metallurgical and Materials Engineering"> Metallurgical and Materials Engineering </option>
        </select>

        <br/><br/>
        <h3> Select the way you wish to sort the students</h3>
        <br/>
        <select name="orderby">
          <option value="ROLLNO" selected="selected"> Roll No </option>
          <option value="NAME"> Name </option>
        </select>

        <br/><br/>
				<input type="submit" name="submit" value="Search">
        <br/><br/>
        <h4><?php echo $rsltmess?></h4>

			</form>
		</body>
	</html>
