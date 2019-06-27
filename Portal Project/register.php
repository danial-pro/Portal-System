<!DOCTYPE html>
<html>
<head>
	<title>Sign Up</title>
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
	      	</li><li><a href="register.php">Sign Up</a></li>
	      </ul>
	      <ul class="nav navbar-nav navbar-right">
	        <li><a href="login.php">logIn</a></li>
	      </ul>
	    </div>
	  </div>
	</nav>
	<br><br>

	<!-- REGISTRATION FORMS -->
	<div class="container panel-body" style="background-color: #cfd4da">
		<form class="form-horizontal" method="post" onsubmit = "return validateall()" action="register_db.php">
		  <fieldset>
		    <legend class="display-4">Sign Up</legend>
		    <div class="form-group">
		      <label class="col-lg-2 control-label">Full Name</label>
		      <div class="col-lg-7">
		        <input type="text" class="form-control" id="inputName" placeholder="Full Name" name="inputName">
		        <div id="nameErr"></div>
		      </div>
		    </div>
		    <div class="form-group">
		      <label class="col-lg-2 control-label">Roll Number/Teacher ID</label>
		      <div class="col-lg-7">
		        <input type="number" class="form-control" id="inputId" placeholder="Roll Number/Teacher ID" name="inputId">
		        <div id="idErr"></div>
		      </div>
		    </div>
			<div class="form-group">
		      <label class="col-lg-2 control-label">Password</label>
		      <div class="col-lg-7">
		        <input type="password" class="form-control" id="inputPassword" placeholder="Password" name="inputPassword">
		        <div id="passErr"></div>
		      </div>
		    </div>
		    <div class="form-group">
		      <label class="col-lg-2 control-label">Email</label>
		      <div class="col-lg-7">
		        <input type="email" class="form-control" id="inputEmail" placeholder="Email" name="inputEmail">
		        <div id="emailErr"></div>
		      </div>
		    </div>
		    <div class="form-group">
		      <label class="col-lg-2 control-label">Selects</label>
		     	<div class="col-lg-7">
			        <select class="form-control" id="select" name="select">
			          <option>Student</option>
			          <option>Teacher</option>
			        </select>
		    	</div>
		    </div>
		    <div id="semNo" class="form-group">
		      <label class="col-lg-2 control-label">Semister</label>
		      <div class="col-lg-7">
		        <input type="number" class="form-control" id="sem" placeholder="Semister no." name="sem">
		        <div id="semErr"></div>
		      </div>
		    </div>
		    <div id="courseNo" class="form-group" style="display: none">
		      <label class="col-lg-2 control-label">Course</label>
		     	<div class="col-lg-7">
			        <select class="form-control" id="course" name="course">
						<option>401</option>
						<option>403</option>
						<option>405</option>
						<option>409</option>
						<option>411</option>
						<option>413</option>
						<option>501</option>
						<option>503</option>
						<option>507</option>
						<option>509</option>
						<option>511</option>
						<option>515</option>
			        </select>
		    	</div>
		    </div>
		    <div class="form-group">
		      <div class="col-lg-6 col-lg-offset-2">
		        <button type="reset" class="btn btn-default">Clear</button>
		        <button type="submit" class="btn btn-primary">Submit</button>
		      </div>
		    </div>
		    
		  </fieldset>
		</form>
	</div>

	<script>

	function validateall()
	{
		var name = $("#inputName").val();
		var id = $("#inputId").val();
		var email = $("#inputEmail").val();
		var password = $("#inputPassword").val();
		var nre = /^[a-zA-Z ]*$/;
		var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;

		if(name == '')
		{
			$("#nameErr").text("Don't leave it blank!");
			//return false;
		}
		else{$("#nameErr").text("");}
		if(!name.match(nre))
		{
			$("#nameErr").text("Enter the correct format!");
			return false;
		}
		else{$("#nameErr").text("");}
		if(id == '')
		{
			$("#idErr").text("Don't leave it blank!");
			return false;
		}
		else{$("#idErr").text("");}
		if(password == '')
		{
			$("#passErr").text("Don't leave it blank!");
			return false;
		}
		else{$("#passErr").text("");}
		if(email == '')
		{
			$("#emailErr").text("Don't leave it blank!");
			return false;
		}
		else{$("#emailErr").text("");}
		if(!email.match(re))
		{
			$("#emailErr").text("Enter the correct format!");
			return false;
		}
		else{$("#emailErr").text("");}
	}

	$(document).ready(function(){
		$("#select").change(function(){
			var select = $("#select").val();
			if(select == 'Student')
			{
				$('#semNo').show();
				$('#courseNo').hide();
			}
			else if(select == 'Teacher')
			{
				$('#semNo').hide();
				$('#courseNo').show();
			}	
	  });	
	});
	</script>
</body>
</html>