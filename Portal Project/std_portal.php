<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Student Portal</title>
	<link rel="stylesheet" href='css/bootstrap.min.css'>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
</head>
<body style="background-color: white">
	<!-- NAV BARR -->
	<nav class="navbar navbar-inverse">
	  <div class="container-fluid">
	    <div class="navbar-header">
	      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-2">
	        <span class="sr-only">Toggle navigation</span>
	        <span class="icon-bar"></span>
	        <span class="icon-bar"></span>
	        <span class="icon-bar"></span>
	      </button>
	      <a class="navbar-brand" href="#">Portal System</a>
	    </div>

	    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-2">
	      <ul class="nav navbar-nav">
	      	<li><a href="#">Home</a></li>
	      	<li><a href="login.php">Log In</a></li>
        	<li><a href="register.php">Sign Up</a></li>
	      </ul>
	      <ul class="nav navbar-nav navbar-right">
	        	<li><a id="logout" href="login.php" onclick="return logout()">log Out</a></li>
	      </ul>
	    </div>
	  </div>
	</nav>

	<!-- ///////MAIN//////// -->

	<div class="container-fluid">
		<div class="page-header">
    		<h1><?php echo $_SESSION["name"] ?></h1>      
  		</div>

  		<!-- ////////////SELECT COURSE////////////// -->
		<div class="jumbotron" style="background-color: #c5baba">
			<div class="page-header">
    			<h3>Select Course</h3>      
  			</div>
			<form class="form-horizontal">
				<p>Welcome to the <b>Portal System</b>.</p>
				<p>This is the student portal, here you can select the courses you want to opt for this semister.</p>
				<p>Below you have been given a list of the courses, you can add any of the 6, given:</p>
				<p>This will send a request to the Teacher to accept you in the perticular course. If they accept, you will be added into the course.</p>
				<div class="form-group">
			     	<div class="col-lg-7">
				        <select class="form-control" id="select" name="select">
				          <option value="401">DCDF</option>
				          <option value="403">Assembly</option>
				          <option value="405">Linear Algebra</option>
				          <option value="409">Semi Conductor</option>
				          <option value="411">Discrete Mathematics</option>
				          <option value="413">Object Oriented</option>
				          <option value="501">Automata</option>
				          <option value="503">Networking</option>
				          <option value="507">Operational Research</option>
				          <option value="509">Database</option>
				          <option value="511">Computer Architecture</option>
				          <option value="515">Artifical Intellegence</option>

				        </select><br>
				        <button id="sel_btn" class="btn btn-primary">ADD</button>
			    	</div>
		    	</div>
			</form>
			<div class="text-center alert alert-info" style="display: none;">
  				<strong id="Err"></strong>
			</div>
		</div>
		<br>

		<!-- ///////Attendence/////// -->
		<div class="jumbotron" style="background-color: #c5baba">
			<div class="page-header">
    			<h3>Attendence Sheet</h3>      
  			</div>
			<p>This section will show you the current <b>Attendence</b> in a perticular course.</p>
			<p>Please be vary, as these attendence are final and will see no further change.</p>
			<br>
			<div class="table-responsive text-center">
				<table class="table table-bordered">
				    <thead style='background-color: #cecaca'>
				      <tr>
				        <th class="text-center">Course ID</th>
				        <th class="text-center">Course Title</th>
				        <th class="text-center">Teacher</th>
				        <th class="text-center">Attendence</th>
				        <th class="text-center">Marks</th>
				      </tr>
				    </thead>
				    <tbody id="tbody">
				      
				    </tbody>
			  	</table>
			</div>
		</div>


		<!-- //////GPA Calculation/////// -->
		<div class="jumbotron" style="background-color: #c5baba">
				<div class="page-header">
	    			<h3>Automatic GPA Calculation</h3>      
	  			</div>
				<p>This section will show you the current <b>Grade Point Average</b> in a perticular course.</p>
				<p>The result are updated by the respective teacher of the course and the <b>GPA</b> will change accordingly.</p>
				<br>
				<div class="table-responsive text-center">
					<table class="table table-bordered">
					    <thead style='background-color: #cecaca'>
					      <tr>
					        <th class="text-center">Course ID</th>
					        <th class="text-center">Course Title</th>
					        <th class="text-center">Teacher</th>
					        <th class="text-center">Marks</th>
					        <th class="text-center">GPA</th>
					      </tr>
					    </thead>
					    <tbody id="gpabody">
					      
					    </tbody>
				  	</table>
				</div>
			</div>
		</div>
		
	</div>
	
	<script type="text/javascript">

		function displayTable()
		{
			var att = 1;
			$.ajax({
				url: "std_db.php",
				type: "POST",
				data: {
					att:att
				},
				success: function(data)
				{
					// console.log(data);
					$("#tbody").html(data);
				}
			});
		}

		function displayGPA()
		{
			var gpa = 1;
			$.ajax({
				url: "std_db.php",
				type: "POST",
				data: {
					gpa:gpa
				},
				success: function(data)
				{
					// console.log(data);
					$("#gpabody").html(data);
				}
			});
		}

	$(document).ready(function(){
		displayTable();
		displayGPA();
		$("#sel_btn").click(function(event){
			event.preventDefault();
			var select = $("#select").val();
			// alert(select);
			$.ajax({
				url: "std_db.php",
				type: "POST",
				data: {
					select:select
				},
				success: function(data){
					// alert(data);
					
					$(".alert-info").show();
					$(".alert-info").html(data);
					$(".alert-info").fadeOut(2000);
					//return false;

					displayTable();
					displayGPA();
				}
			});	
	  	});

		function logout()
		{
			$("#logout").click(function(){
				lg=1;
				$.ajax({
					url:"std_db.php",
					type:"POST",
					data:{ lg:lg },
					success:function(data)
					{
						console.log(data);
					}
				});
			});
		}
	});
	</script>
</body>
</html>

