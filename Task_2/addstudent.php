<!DOCTYPE html>
<?php
// define variables and set to empty values
$nameErr = $emailErr = $addrErr = $rollnoErr = "";
$name = $email  = $addr = $rollno = $dept =$abtme= "";
$flag=1;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $conn = mysqli_connect("localhost", "Nithish", "Hohaahoh","student_database");
  if(!$conn){
    die("Error! Cannot connect to the database");
  }

   if(!preg_match("/^[a-zA-Z ]*$/",$_POST["name"])) {
      $nameErr = "*Name can have only letters and whitespaces";
      $flag=0;
   }
   //use of htmlspecialchars is to prevent hacking
   else
      $name=htmlspecialchars($_POST["name"]);

   if(!filter_var($_POST["email"],FILTER_VALIDATE_EMAIL)) {
     $emailErr = "*Email format Invalid";
     $flag=0;
   }
   elseif(!preg_match("/(@nitt.edu)$/",$_POST["email"])) {
     $emailErr ="*Mail id must end with @nitt.edu";
     $flag=0;
   }
   else
     $email=htmlspecialchars($_POST["email"]);
     $adr = trim($_POST["addr"]);
   if(empty($adr)) {
     $addrErr = "*Address field cannot be blank";
     $flag=0;
   }
   else
     $addr=htmlspecialchars($adr);

   if(!preg_match("/^\d{9}$/",$_POST["rollno"])) {
     $rollnoErr = "*Roll number should have exactly nine digits";
     $flag=0;
   }
   else {
     $rollno=htmlspecialchars($_POST["rollno"]);
   }

   $dept=htmlspecialchars($_POST["dept"]);
   $abtme=htmlspecialchars($_POST["abtme"]);
  //flag is one if data is valid
   if($flag){
     $passcode = mt_rand(100000,999999);
     //get 6 digit passcode
     $sqlins=$conn->prepare("INSERT INTO students (NAME, ROLLNO, DEPARTMENT, EMAIL, ADDRESS, ABOUT_ME, PASSCODE)
     VALUES(?,?,?,?,?,?,?)");
     //this will prevent sql injection
      if($sqlins) {

        $sqlins->bind_param("sisssss",$name,$rollno,$dept,$email,$addr,$abtme,$passcode);
      }
      else {
        die("Error preparing statements");
      }
      $regis = $sqlins->execute();
      if($regis) {

     }
     else {
        echo "Error Type : ",mysqli_error($conn),"<br>";
        die("Error inserting into database");
     }
     $sqlins->close();
     //close connection to improve efficiency
   }
   $conn->close();
}


?>

  <html>
		<head>
			<link type="text/css" rel="stylesheet" href="studentdatabase.css"/>
      <style>
        body{
          text-align: left;
        }

        h1{
          /*transform: translate(38vw);*/
          text-align: center;
        }

      </style>
      <title>
        Add Student
      </title>
		</head>

		<body >
        <h1 >Student Registration Form</h1>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" name="studentregistration">
          <h3>Name</h3>
          <input type="text" name="name"  placeholder="Type your name" size="33.8"
          value="<?php echo $name;?>" required >
          <!--the spans are providing error message, nameError stores the error message for name-->
          <span class="error"> <?php echo $nameErr;?></span><br/><br/>

          <h3>Roll Number</h3>
          <input type="number" name="rollno" style="width:21.2em" placeholder="Type your roll number"
          value="<?php echo $rollno;?>" required>
          <span class="error"> <?php echo $rollnoErr;?></span><br/><br/>

          <h3>Department</h3>
          <select name="dept" style="width='48px'">
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
          <h3>E-Mail</h3>
          <input type="text" name="email" placeholder="Type your email" size="33.8"
          value="<?php echo $email;?>" required>
          <span class="error"> <?php echo $emailErr;?></span><br/><br/>

          <h3>Residential address</h3>
          <textarea name="addr" cols="32" rows="3" placeholder="Type your address"><?php echo $addr;?> </textarea>
          <span class="error"> <?php echo $addrErr;?></span><br/><br/>

          <h3>About Me</h3>
          <textarea name="abtme" cols="32" rows="5" placeholder="Tell us something about yourself"><?php echo $abtme;?> </textarea>
          <br/><br/>
          <input type="submit" name="submit" value="Submit">
          <br/><br/>
          <span>
              <?php
              if($regis) {
                echo "You have registered successfully. <br>";
                echo "Your passcode is ",$passcode,".Please use this passcode for future editing.<br>";
           }
           ?>
         </span>
        </form>

		</body>
	</html>
