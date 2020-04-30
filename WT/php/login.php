<?php
require_once 'database.php';
session_start();

$username=$password="";
if(isset($_POST['submit'])){
    $username=trim($_POST['username']);
    $password=trim($_POST['password']);
    $department=trim($_POST['department']);
    if(!$username=='' && !$password=='' && !empty($department))
    {
        $sql = "SELECT * FROM users where username='$username' and departement='$department' and password='$password'";
        $query=mysqli_query($conn,$sql);

        $count = mysqli_num_rows($query);
        if($count == 1){
            $_SESSION['username']=$username;
            header("location:welcome.php");
        }
        else{
            echo "<script>alert('Invalid Credentials')</script>";
        }
    }
    else{
        echo"<script>alert('All fields must be filled')</script>";
    }
}
?>


<html>
<head>
	<title>Login Form</title>
	<meta charset="utf-8">

	<link rel="stylesheet" href="wb.css" type="text/css">
</head>
<body bgcolor="aqua">
    <div>

	 	<h1 align="center" ><font color="red">LIBRARY MANAGEMENT SYSTEM</font>

		</h1>
		<hr>
		<h2 align="center">
			Login Form
		</h2>
        <form action="" autocomplete="on" method="post">

        <div class="row">
        <div class="col-20"><label>Username:</label></div>
		<div class="col-80"><input type="text" name="username" placeholder="Enter username" required></div>
        </div>

		<div class="row">
		<div class="col-20"><label>Password:</label></div>
		<div class="col-80"><input type="password" name="password" placeholder="Enter password" autocomplete="off" required></div>
		</div>

        <div class="row">
        <div class="col-20"><label>Department:</label></div>
	    <div class="col-80"><select name="department" id="department">
        <option value="">Select Department</option>
		<option value="Computer">Computer</option>
		<option value="Mechanical">Mechanical</option>
		<option value="Information Technology">Information Technology</option>
		<option value="ENTC">ENTC</option>
        </select></div>
    </div>
        <input type="checkbox" name="pass" value="pass" checked>Save Password>
            <br>
        <input type="submit" name="submit" value="Sign In"><br>
        <input type="reset" name="reset" value="Reset">

		<br>
		<a href="forgot.html">Forgot Password?</a>
            <a href="register.php">To Register</a>
	</form>
    </div>


</body>
</html>
