<?php

	$servername = "localhost";
	$username = "root"; 
	$password = "";
	$dbname = "portal_system";
	$conn = new mysqli($servername,$username,$password,$dbname);
	if($conn->connect_error)
	{
		die("Connection failed: " . $conn->connect_error);
		return false;
	}

	if ($_SERVER['REQUEST_METHOD'] === 'POST') 
	{
		$select = $_POST["select"];
		$name = $_POST["inputName"];
		$id = $_POST["inputId"];
		$pass = $_POST["inputPassword"];
		$email = $_POST["inputEmail"];
		$semister = $_POST["sem"];
		$course = $_POST["course"];


		/////////////////INSERT FOR STUDENT OR TEACHER//////////////////
		if($select == 'Student')
		{
			//print_r($semister);
			$q = "INSERT INTO `std_list`(`s_id`, `name`, `password`, `email`, `semister`) VALUES ('".$id."','".$name."','".$pass."', '".$email."', '".$semister."')";
			if($conn->query($q) == TRUE)
			{
				echo "<h4>Successfully Added</h4>";
				header('Location: login.php');
				exit();
			}
			else
			{
				echo "Error inserting into table: " . $conn->error;
			}
		}
		else if($select == 'Teacher')
		{
			$q = "INSERT INTO `tec_list`(`t_id`, `name`, `password`, `email`, `c_id`) VALUES ('".$id."','".$name."','".$pass."', '".$email."', '".$course."')";
			if($conn->query($q) == TRUE)
			{
				//echo "<h4>Successfully Added</h4>";
				header('Location: login.php');
				exit();

			}
			else
			{
				echo "Error inserting into table: " . $conn->error;
			}
		}
	}
	else
	{
		echo "<div class='alert alert-dismissible alert-warning'>
	  <button type='button' class='close' data-dismiss='alert'>&times;</button>
	  <h4>Warning!</h4></div>";
	}
	
	
?>