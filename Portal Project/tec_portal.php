<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Teacher Portal</title>
	<link rel="stylesheet" href='css/bootstrap.min.css'>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
</head>
<body>
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
	        <li><a href="login.php" onclick="return logout()">log Out</a></li>
	      </ul>
	    </div>
	  </div>
	</nav>

	<!-- ///////MAIN//////// -->

	<div class="container-fluid">
		<div class="page-header">
    		<h1><?php echo $_SESSION["name"] ?></h1>      
  		</div>

  		<!-- ////////////Student list for the perticular course////////////// -->
		<div class="jumbotron" style="background-color: #c5baba">
			<div class="page-header">
    			<h3>Student List</h3>      
  			</div>
			<p>This section will show you the current students in the course.</p>
			<p>Here, when the students <b>apply</b> for your course, you will have a <b>prompt</b> to accept the student in your course OR <b>Drop</b> the student from your course.</p>
			<br>
			<div class="table-responsive text-center">
				<table class="table table-bordered">
				    <thead style='background-color: #cecaca'>
				      <tr>
				        <th class="text-center">Student ID</th>
				        <th class="text-center">Student Name</th>
				        <th class="text-center">Attendence(%)</th>
				        <th class="text-center">Result(%)</th>
				      </tr>
				    </thead>
				    <tbody id="tbody">
				      
				    </tbody>
			  	</table>
			</div>
		</div>
		<br>

		<!-- ///////Attendence Change/////// -->
		<div class="jumbotron" style="background-color: #c5baba">
			<div class="page-header">
    			<h3>Attendence Sheet</h3>      
  			</div>
  			<p>In this section you can <b>Modify</b> the <b>Attendence</b> of current students in the course.</p>
  			<p>Also in this section you can <b>Kick</b> a <b>Student</b> from the current course.</p>
  			<p>This can be done if the student: </p>
  			<ul>
  				<li>Breaks any rules.</li>
  				<li>Can not meet the grade requirements.</li>
  				<li>Is short of attendence.</li>
  			</ul>
			<br>
			<div class="table-responsive text-center">
				<table class="table table-bordered">
				    <thead style='background-color: #cecaca'>
				      <tr>
				        <th class="text-center">Student ID</th>
				        <th class="text-center">Student Name</th>
				        <th class="text-center">Student Attendence</th>
				        <th class="text-center">Modify Attendence</th>
				        <th class="text-center">Drop Student</th>
				      </tr>
				    </thead>
				    <tbody id="atbody">
				      
				    </tbody>
			  	</table>
			</div>
			<div id="Err" class="text-center alert alert-info" style="display: none;">
  				<strong ></strong>
			</div>
		</div>

		<!-- ///////Result Change/////// -->
		<div class="jumbotron" style="background-color: #c5baba">
			<div class="page-header">
    			<h3>Result Sheet</h3>      
  			</div>
  			<p>In this section you can <b>Modify</b> the <b>Result</b> of the students in this course.</p>
			<br>
			<div class="table-responsive text-center">
				<table class="table table-bordered">
				    <thead style='background-color: #cecaca'>
				      <tr>
				        <th class="text-center">Student ID</th>
				        <th class="text-center">Student Name</th>
				        <th class="text-center">Student Result</th>
				        <th class="text-center">Modify Result</th>
				      </tr>
				    </thead>
				    <tbody id="rtbody">
				      
				    </tbody>
			  	</table>
			</div>
			<div id="rErr" class="text-center alert alert-info" style="display: none;">
  				<strong ></strong>
			</div>
		</div>

		<!-- //////MODAL FOR RESULT////// -->

		<div id="myModal" class="modal">
		  <div class="modal-dialog">
		    <div class="modal-content">
		      <div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		        <h4 class="modal-title">Modal title</h4>
		      </div>
		      <div class="modal-body">
		      	Obtained Marks: <input type="number" class="form-control" id="inputRes">  
		      </div>
		      <div class="modal-footer">
		        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		        <button id="suc" type="button" class="btn btn-primary">Submit</button>
		      </div>
		    </div>
		  </div>
		</div>

	</div>
	<script type="text/javascript">
		
		function logout()
		{
			var lg;
			$.ajax({
				url:"tec_db.php",
				type:"POST",
				data:{ lg:lg },
				success:function(data)
				{
					// console.log(data);
				}
			});
		}

		function displayStdList()
		{
			var slist = 1;
			$.ajax({
				url: "tec_db.php",
				type: "POST",
				data: {
					slist:slist
				},
				success: function(data)
				{
					// console.log(data);
					$("#tbody").html(data);
				}
			});
		}

		function attendenceTable()
		{
			var att_cng = 1;
			$.ajax({
				url: "tec_db.php",
				type: "POST",
				data: {
					att_cng:att_cng
				},
				success: function(data)
				{
					// console.log(data);
					$("#atbody").html(data);
				}
			});
		}

		function absent(abs)
		{
			$.ajax({
				url: "tec_db.php",
				type: "POST",
				data: {
					abs:abs
				},
				success: function(data){
					console.log(data);
					displayStdList();
					attendenceTable();
					$("#Err").show();
					$("#Err").html(data);
					$("#Err").fadeOut(1500);
				}
			});	
		}

		function present(pre)
		{
			$.ajax({
				url: "tec_db.php",
				type: "POST",
				data: {
					pre:pre
				},
				success: function(data){
					console.log(data);
					displayStdList();
					attendenceTable();
					$("#Err").show();
					$("#Err").html(data);
					$("#Err").fadeOut(1500);
				}
			});	
		}

		function dropCourse(dp)
		{
			$.ajax({
				url: "tec_db.php",
				type: "POST",
				data: {
					dp:dp
				},
				success: function(data)
				{
					console.log(data);
					displayStdList();
					attendenceTable();
					$("#Err").show();
					$("#Err").html(data);
					$("#Err").fadeOut(1500);
				}
			});
		}


		function resultTable()
		{
			var res_cng = 1;
			$.ajax({
				url: "tec_db.php",
				type: "POST",
				data: {
					res_cng:res_cng
				},
				success: function(data)
				{
					console.log(data);
					$("#rtbody").html(data);
				}
			});
		}


		function resultUpdate(ru)
		{
			$("#result").show();
			$("#suc").click(function(){
				var mrk = $('#inputRes').val();
				// alert(ru);
				// return false;
				$.ajax({
					url: "tec_db.php",
					type: "POST",
					data: {
						ru:ru,
						mrk:mrk
					},
					success: function(data)
					{
						// console.log(data);
						// $("#rtbody").html(data);
						resultTable();
						displayStdList();
					}
				});
			});		
		}


		function request(rid)
		{
			// console.log(rid);
			// return false;
			$.ajax({
				url:"tec_db.php",
				type: "POST",
				data: { rid:rid },
				success: function(data)
				{
					console.log(data);
					// $("#reqbody").html(data);
					attendenceTable();
					resultTable();
					displayStdList();
				}
			});
		}

	$(document).ready(function(){
		displayStdList();
		attendenceTable();
		resultTable();
	});

	</script>
</body>
</html>

