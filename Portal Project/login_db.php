<?php
	session_start();

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

	if (isset($_POST['pass'])) 
	{
		$select = $_POST["select"];
		$name = $_POST["name"];
		$pass = $_POST["pass"];

		if(empty($name) || empty($pass))
		{
			echo "E";
			return false;
		}

		///////////////////COMPARING PASSWORD AND NAME//////////////////////
		if($select == 'Student')
		{
			$sql = "SELECT * FROM std_list WHERE name = '$name' AND password = '$pass' ";
			$result = $conn->query($sql);
			if($result->num_rows > 0)
			{
				while($row = $result->fetch_assoc())
				{
					$_SESSION['name'] = $name;
					$_SESSION['pass'] = $pass;
					$_SESSION['id'] = $row['s_id'];
					$_SESSION['portal'] = 'Student';

					// print_r("Name: ".$_SESSION['name']." Pass: ".$_SESSION['pass']." id: ".$_SESSION['id']);
					// exit;

					echo  "YS";
					return false;
				}
			}
			else
			{
				echo "N";
				return false;
			}
		}
		else if($select == 'Teacher')
		{
			$sql = "SELECT * FROM tec_list WHERE name = '$name' AND password = '$pass' ";
			$result = $conn->query($sql);
			if($result->num_rows > 0)
			{
				while($row = $result->fetch_assoc())
				{
					$_SESSION['name'] = $name;
					$_SESSION['pass'] = $pass;
					$_SESSION['id'] = $row['t_id'];
					$_SESSION['portal'] = 'Teacher';

					// print_r("Name: ".$_SESSION['name']." Pass: ".$_SESSION['pass']." id: ".$_SESSION['id']);
					// exit;

					echo  "YT";
					return false;
				}
			}
			else
			{
				echo "N";
				return false;
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