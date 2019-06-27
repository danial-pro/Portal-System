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

	if(isset($_POST['lg']))
	{ 
		session_start();
		session_unset();
		session_destroy();
		echo "done";
	}

	if(isset($_POST['slist']))
	{
		$tid = $_SESSION['id'];

		$sql = "SELECT c_id FROM tec_list WHERE t_id = '".$tid."' ";
		$result = $conn->query($sql);
		if($result->num_rows > 0)
		{
			$cid = $result->fetch_assoc();
			$course = $cid['c_id'];
			$sql = "SELECT att_list.s_id, std_list.name as stdName, att_list.attend, att_list.mark, att_list.req 
			FROM att_list 
			INNER JOIN std_list ON std_list.s_id = att_list.s_id 
			WHERE att_list.c_id = '$course' 
			ORDER BY `att_list`.`s_id` ASC";
			$result = $conn->query($sql);
			if($result->num_rows > 0)
			{
				while($row = $result->fetch_assoc())
				{
					if($row['req']=='yes')
					{
						?>

						<tr class="active">
					        <td><?php echo $row['s_id']; ?></td>
					        <td><?php echo $row['stdName']; ?></td>
					        <?php
						        if($row['attend']<65)
						        {
						        	?>
						        	<td style="color: red"><?php echo $row['attend'];?></td>
						        	<?php
						        }
						        else
						        {
						        	?>
						        	<td style="color: green"><?php echo $row['attend'];?></td>
						        	<?php
						        }
						        ?>
						        <?php
						        if($row['mark']<50)
						        {
						        	?>
						        	<td style="color: red"><?php echo $row['mark'];?></td>
						        	<?php
						        }
						        else
						        {
						        	?>
						        	<td style="color: green"><?php echo $row['mark'];?></td>
						        	<?php
						        }
						    ?>
					    </tr>

						<?php
					}
					else
					{
						?>

						<tr class="active">
					        <td><?php echo $row['s_id']; ?></td>
					        <td><?php echo $row['stdName']; ?></td>
					        <td colspan="2" class="b_middle">
					        	<button id="abs" class="btn btn-primary col-sm-5 " onclick='request(<?php echo $row["s_id"]; ?>)'>Accept</button>
					        	<p class="col-sm-2">/</p>
					        	<button id="drop" class="btn btn-danger col-sm-5" onclick='dropCourse(<?php echo $row["s_id"]; ?>)'>Drop</button>		 
					        </td>
					    </tr>

						<?php	
					}
				}
			}
			else
			{
				echo "No Students have selected the course";
			}
		}
		else
		{
			echo "something wrong";
		}
	}


	if(isset($_POST['att_cng']))
	{
		$tid = $_SESSION['id'];
		$sql = "SELECT c_id FROM tec_list WHERE t_id = '".$tid."' ";
		$result = $conn->query($sql);
		if($result->num_rows > 0)
		{
			$cid = $result->fetch_assoc();
			$course = $cid['c_id'];
			$sql = "SELECT att_list.s_id, std_list.name as stdName, att_list.attend, att_list.req 
			FROM att_list 
			INNER JOIN std_list ON std_list.s_id = att_list.s_id 
			WHERE att_list.c_id = $course AND att_list.req = 'yes'
			ORDER BY `att_list`.`s_id` ASC";
			$result = $conn->query($sql);
			if($result->num_rows > 0)
			{
				while($row = $result->fetch_assoc())
				{
					?>

					<tr class="active">
				        <td><?php echo $row['s_id']; ?></td>
				        <td><?php echo $row['stdName']; ?></td>
				        <?php
					        if($row['attend']<65)
					        {
					        	?>
					        	<td style="color: red"><?php echo $row['attend'];?></td>
					        	<?php
					        }
					        else
					        {
					        	?>
					        	<td style="color: green"><?php echo $row['attend'];?></td>
					        	<?php
					        }
						?>
				        <td>
				        	<button id="abs" class="btn btn-primary col-sm-5" 
				        	onclick='absent(<?php echo $row["s_id"]; ?>)'>Absent</button>
				        	<p class="col-sm-2"> / </p>
				        	<button id="pre" class="btn btn-success col-sm-5" 
				        	onclick='present(<?php echo $row["s_id"]; ?>)'>Present</button>
				        </td>
				        <td>
				        	<button id="drop" class="btn btn-danger" 
				        	onclick='dropCourse(<?php echo $row["s_id"]; ?>)'>Drop</button>
				        </td>
				    </tr>

					<?php
				}
			}
			else
			{
				echo "No Students have selected the course";
			}
		}
		else
		{
			echo "something wrong";
		}
	}

	if(isset($_POST['pre']))
	{
		$aid = $_SESSION['id'];
		$sid = $_POST['pre'];
		$sql = "SELECT att, days, attend FROM att_list WHERE t_id = $aid AND s_id = '".$_POST['pre']."' ";
		$result = $conn->query($sql);
		if($result->num_rows > 0)
		{
			while($row = $result->fetch_assoc())
			{
				$att = $row['att'];
				$days = $row['days'];
				$att = (int)$att;
				$days = (int)$days;
				$att+=1;
				$days+=1;

				$attend = ($att/$days)*100;

				// echo ""attendence: ".$attend." days: ".$days." att ".$att;
				// exit;

				if($days > 15)
				{
					echo "Attendence Completed!";
				}
				else
				{
					$q = "UPDATE `att_list` SET `attend`= $attend, att = $att, days = $days WHERE s_id = $sid AND t_id = $aid";
					$res = $conn->query($q);
					if (!$res) 
					{
	    				trigger_error('Invalid query: ' . $conn->error);
					}
					else
					{
						echo "Done!";
					}
				}	
			}
		}
	}

	if(isset($_POST['abs']))
	{
		$aid = $_SESSION['id'];
		$sid = $_POST['abs'];
		$sql = "SELECT att, days, attend FROM att_list WHERE t_id = $aid AND s_id = '".$_POST['abs']."' ";
		$result = $conn->query($sql);
		if($result->num_rows > 0)
		{
			while($row = $result->fetch_assoc())
			{
				$att = $row['att'];
				$days = $row['days'];
				$att = (int)$att;
				$days = (int)$days;
				$days+=1;

				$attend = ($att/$days)*100;

				// echo "attendence: ".$attend." days: ".$days." att ".$att;
				// exit;

				if($days > 15)
				{
					echo "Attendence Completed!";
				}
				else
				{
					$q = "UPDATE `att_list` SET `attend`= $attend, att = $att, days = $days WHERE s_id = $sid AND t_id = $aid";
					$res = $conn->query($q);
					if (!$res) 
					{
	    				trigger_error('Invalid query: ' . $conn->error);
					}
					else
					{
						echo "Done!";
					}
				}
			}
		}
	}


	if(isset($_POST['dp']))
	{
		$aid = $_SESSION['id'];
		$sid = $_POST['dp'];
		$sql = "DELETE FROM `att_list` WHERE s_id = $sid AND t_id = $aid ";
		$result = $conn->query($sql);
		if (!$result) 
		{
			trigger_error('Invalid query: ' . $conn->error);
		}
		else
		{
			echo "Done!";
		}
	}


	if(isset($_POST['res_cng']))
	{
		$tid = $_SESSION['id'];
		$sql = "SELECT c_id FROM att_list WHERE t_id = '".$tid."' ";
		$result = $conn->query($sql);
		if($result->num_rows > 0)
		{
			$cid = $result->fetch_assoc();
			$course = $cid['c_id'];
			$sql = "SELECT att_list.s_id, std_list.name as stdName, att_list.mark, att_list.req 
			FROM att_list 
			INNER JOIN std_list ON std_list.s_id = att_list.s_id 
			WHERE att_list.c_id = $course AND att_list.req = 'yes' 
			ORDER BY `att_list`.`s_id` ASC";
			$result = $conn->query($sql);
			if($result->num_rows > 0)
			{
				while($row = $result->fetch_assoc())
				{
					?>

					<tr class="active">
				        <td><?php echo $row['s_id']; ?></td>
				        <td><?php echo $row['stdName']; ?></td>
				        <?php
					        if($row['mark']<50)
					        {
					        	?>
					        	<td style="color: red"><?php echo $row['mark'];?></td>
					        	<?php
					        }
					        else
					        {
					        	?>
					        	<td style="color: green"><?php echo $row['mark'];?></td>
					        	<?php
					        }
						 ?>
				        <td>
				        	<button id="rCng" class="btn btn-danger" 
				        	data-toggle='modal' data-target='#myModal' 
				        	onclick='resultUpdate(<?php echo $row["s_id"]; ?>)'>Edit</button>
				        </td>
				    </tr>

					<?php
				}
			}
			else
			{
				echo "No Students have selected the course";
			}
		}
		else
		{
			echo "something wrong";
		}
	}


	if(isset($_POST['ru']))
	{
		$tid = $_SESSION['id'];
		$sid = $_POST['ru'];
		$mrk = $_POST['mrk'];
		// echo $tid;
		// exit;
		$sql = "UPDATE `att_list` SET mark = $mrk WHERE t_id = $tid AND s_id = $sid ";
		$result = $conn->query($sql);
		if (!$result) 
		{
			trigger_error('Invalid query: ' . $conn->error);
		}
		else
		{
			echo "Done!";
		}
		// echo "hello";
	}

	if(isset($_POST['rid']))
	{
		$rid = $_POST['rid'];
		$tid = $_SESSION['id'];
		// $req = "yes";

		//print_r($req)

		$sql = "UPDATE att_list SET req = 'yes' WHERE s_id = $rid AND t_id = $tid";
		$result = $conn->query($sql);
		if (!$result) 
		{
			trigger_error('Invalid query: ' . $conn->error);
		}
		else
		{
			echo "Done!";
		}
	}

?>

