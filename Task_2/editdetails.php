<!DOCTYPE html>
<?php
  session_start();
  // define variables and set to empty values
  $nameErr = $emailErr = $addrErr =  "";
  $flag=1;
  //give default values as original details
  $rollno=$_SESSION['rollno'];
  $name=$_SESSION['name'];
  $email=$_SESSION['email'];
  $addr=$_SESSION['addr'];
  $dept=$_SESSION['dept'];
  $abtme=$_SESSION['abtme'];

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $conn = mysqli_connect("localhost", "Nithish", "Hohaahoh","student_database");
    if(!$conn){
      die("Error! Cannot connect to the database");
    }

      $_SESSION['passcode']=htmlspecialchars($_POST["passcode"]);
     if(!preg_match("/^[a-zA-Z ]*$/",$_POST["name"])) {
        $nameErr = "*Name can have only letters and whitespaces";
        $flag=0;
     }
     //use of htmlspecialchars is to prevent hacking
     else
        $_SESSION['name'] = $name=htmlspecialchars($_POST["name"]);

     if(!filter_var($_POST["email"],FILTER_VALIDATE_EMAIL)) {
       $emailErr = "*Email format Invalid";
       $flag=0;
     }
     elseif(!preg_match("/(@nitt.edu)$/",$_POST["email"])) {
       $emailErr ="*Mail id must end with @nitt.edu";
       $flag=0;
     }
     else
       $_SESSION['email'] = $email=htmlspecialchars($_POST["email"]);
       $adr = trim($_POST["addr"]);
     if(empty($adr)) {
       $addrErr = "*Address field cannot be blank";
       $flag=0;
     }
     else
       $_SESSION['addr'] = $addr=htmlspecialchars($adr);

     $_SESSION['dept'] = $dept = htmlspecialchars($_POST["dept"]);
     $_SESSION['abtme'] = $abtme = htmlspecialchars($_POST["abtme"]);

     if($flag){
       header('Location: updatestatus.php');
       //go to page updatestatus
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
          transform: translate(38vw);
        }

      </style>
      <title>
        Edit Details
      </title>
		</head>

		<body >
        <h1 >Edit Details</h1>
        <h3>Roll Number:</h3><?php echo $rollno;?> <br/><br/>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" name="studentregistration">
          <h3>Name</h3>
          <input type="text" name="name"  placeholder="Type your name" size="40"
          value="<?php echo $name;?>" required >
          <!--the spans are providing error message, nameError stores the error message-->
          <span class="error"> <?php echo $nameErr;?></span><br/><br/>
          <h3>Department</h3>

          <input list="departments" name="dept" size="40" placeholder="Type your department"
          value="<?php echo $dept;?>" required>
          <br/><br/>
          <datalist id="departments">
            <option value="Computer Science and Engineering">
            <option value="Electronics and Communication Engineering">
            <option value="Electrical and Electronics Engineering">
            <option value="Mechanical Engineering">
            <option value="Instrumentation and Control Engineering">
            <option value="Civil Engineering">
            <option value="Production Engineering">
            <option value="Chemical Engineering">
            <option value="Metallurgical and Materials Engineering">
          </datalist>

          <h3>E-Mail</h3>
          <input type="text" name="email" size="40" placeholder="Type your email"
          value="<?php echo $email;?>" required>
          <span class="error"> <?php echo $emailErr;?></span><br/><br/>

          <h3>Residential address</h3>
          <textarea name="addr" cols="39" rows="3" placeholder="Type your address"><?php echo $addr;?> </textarea>
          <span class="error"> <?php echo $addrErr;?></span><br/><br/>

          <h3>About Me</h3>
          <textarea name="abtme" cols="39" rows="5" placeholder="Tell us something about yourself"><?php echo $abtme;?> </textarea>
          <br/><br/>

          <h3>Passcode</h3>
          <input type="password" name="passcode" placeholder="Type your passcode" required><br/><br/>

          <input type="submit" name="submit" value="Submit">
        </form>

		</body>
	</html>
