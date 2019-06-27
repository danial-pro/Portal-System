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

	if(isset($_POST['select']))
	{
		$cid = $_POST['select'];
		$name = $_SESSION['name'];
		$sid = $_SESSION['id'];
		// echo $_POST['select'];
		// return false;

		$sql = "SELECT * FROM att_list WHERE s_id = $sid AND c_id = $cid";
		$result = $conn->query($sql);
		if($result->num_rows > 0)
		{
			echo "This Course Already Exists!";
			return false;
		}
		else
		{
			$sql = "SELECT * FROM att_list WHERE s_id = $sid";
			$result = $conn->query($sql);

			// print_r($result->num_rows);
			// exit;

			if($result->num_rows < 6)
			{
				$sql = "SELECT * FROM course_list WHERE c_id = '$cid' ";
				$result = $conn->query($sql);
				if($result->num_rows > 0)
				{
					// print_r($result->num_rows);
					// exit;
					while($row = $result->fetch_assoc())
					{
						$sql = "INSERT INTO `att_list`(`s_id`, `c_id`, `t_id`) VALUES ('".$sid."', '".$cid."', '".$row['t_id']."')";
						if($conn->query($sql) == TRUE)
						{
							echo "<h4>Successfully Added</h4>";
							return false;
						}
						else
						{
							echo "Error inserting into table: " . $conn->error;
							return false;
						}
					}
				}
				else
				{
					echo "No result found!";
					return false;
				}
			}
			else
			{
				echo "You can select only 6 courses!";
			}	
		}		 
	}


	if(isset($_POST['att']))
	{
		$sid = $_SESSION['id'];
		// echo "in att";
		$sql="SELECT att_list.c_id, course_list.course, tec_list.name as teacherName, att_list.attend, 
		att_list.mark, att_list.req
		FROM att_list INNER JOIN course_list ON course_list.c_id = att_list.c_id 
		INNER JOIN tec_list ON att_list.t_id = tec_list.t_id WHERE att_list.s_id = $sid 
		ORDER BY att_list.c_id ASC";
		// echo $sql;
		// exit;
		$result = $conn->query($sql);
		// if (!$result) {
		  		// trigger_error('Invalid query: ' . $conn->error);
		// }
		if($result->num_rows > 0)
		{
			while($row = $result->fetch_assoc())
			{
				if($row['req']=='yes')
				{
				?>
					<tr class="active">
				        <td><?php echo $row['c_id']; ?></td>
				        <td><?php echo $row['course']; ?></td>
				        <td><?php echo $row['teacherName']; ?></td>
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
				else if($row['req']=='no')
				{
				?>
					<tr class="active">
						<td ><?php echo $row['c_id']; ?></td>
				        <td ><?php echo $row['course']; ?></td>
				        <td ><?php echo $row['teacherName']; ?></td>
						<td colspan="2" style="color: red">Request Pending!</td>
					</tr>
				<?php
				}
			}
		}
		else
		{
			echo "No Course Selected!";
			return false;
		}
	}

	if(isset($_POST['lg']))
	{ 
		session_start();
		session_unset();
		session_destroy();
		echo "done";
	}


	if(isset($_POST['gpa']))
	{
		$sid = $_SESSION['id'];
		$sql="SELECT att_list.c_id, course_list.course, tec_list.name as teacherName, att_list.attend, 
		att_list.mark, att_list.req
		FROM att_list INNER JOIN course_list ON course_list.c_id = att_list.c_id 
		INNER JOIN tec_list ON att_list.t_id = tec_list.t_id 
		WHERE att_list.s_id = $sid AND att_list.req = 'yes' 
		ORDER BY att_list.c_id ASC";
		$result = $conn->query($sql);

		if($result->num_rows > 0)
		{
			$flag = 0;
			$gpa = 0;
		    $tgpa = 0;
			while($row = $result->fetch_assoc())
			{
				?>

				<tr class="active">
			        <td><?php echo $row['c_id']; ?></td>
			        <td><?php echo $row['course']; ?></td>
			        <td><?php echo $row['teacherName']; ?></td>
			        <!-- marks -->
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
			        <!-- GPA -->
		        	<?php
		        	if($row['mark']<50)
		        	{
		        		$gpa = 0;
		        		?>
		        		<td style="color: red"><?php echo $gpa; ?></td>
		        		<?php
		        	}
		        	else if($row['mark']>=50 AND $row['mark']<=52)
		        	{
		        		$gpa = 1.0;
		        		?>
		        		<td style="color: green"><?php echo $gpa; ?></td>
		        		<?php
		        	}
		        	else if($row['mark']>=53 AND $row['mark']<=56)
		        	{
		        		$gpa = 1.4;
		        		?>
		        		<td style="color: green"><?php echo $gpa; ?></td>
		        		<?php
		        	}
		        	else if($row['mark']>=57 AND $row['mark']<=60)
		        	{
		        		$gpa = 1.8;
		        		?>
		        		<td style="color: green"><?php echo $gpa; ?></td>
		        		<?php
		        	}
		      		else if($row['mark']>=61 AND $row['mark']<=63)
		        	{
		        		$gpa = 2.0;
		        		?>
		        		<td style="color: green"><?php echo $gpa; ?></td>
		        		<?php
		        	}
		        	else if($row['mark']>=64 AND $row['mark']<=67)
		        	{
		        		$gpa = 2.4;
		        		?>
		        		<td style="color: green"><?php echo $gpa; ?></td>
		        		<?php
		        	}
		        	else if($row['mark']>=68 AND $row['mark']<=70)
		        	{
		        		$gpa = 2.8;
		        		?>
		        		<td style="color: green"><?php echo $gpa; ?></td>
		        		<?php
		        	}
		        	else if($row['mark']>=71 AND $row['mark']<75)
		        	{
		        		$gpa = 3.0;
		        		?>
		        		<td style="color: green"><?php echo $gpa; ?></td>
		        		<?php
		        	}
		        	else if($row['mark']>=75 AND $row['mark']<80)
		        	{
		        		$gpa = 3.4;
		        		?>
		        		<td style="color: green"><?php echo $gpa; ?></td>
		        		<?php
		        	}
		        	else if($row['mark']>=80 AND $row['mark']<85)
		        	{
		        		$gpa = 3.8;
		        		?>
		        		<td style="color: green"><?php echo $gpa; ?></td>
		        		<?php
		        	}
		        	else if($row['mark']>=85)
		        	{
		        		$gpa = 4.0;
		        		?>
		        		<td style="color: green"><?php echo $gpa; ?></td>
		        		<?php
		        	}
		        	?>
			    </tr>
				<?php
				$tgpa += $gpa;
				$flag++;
			}
			$avg = $tgpa/$flag;
			?>
			<tr class="active"><td><?php echo "GPA for this Semister: ".$avg; ?></td></tr>
			<?php
		}
		else
		{
			echo "<td>No Course Selected OR Course Request still pending!</td>";
			return false;
		}
	}

?>