<!DOCTYPE html>
<html>
<head>
	<title>LogIn</title>
	<link rel="stylesheet" href='css/bootstrap.min.css'>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
	<!-- reCaptcha library -->
	<script src='https://www.google.com/recaptcha/api.js'></script>
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
	      	<li><a href="login.php">Log In</a></li>
        	<li><a href="#">Home</a></li>
	      </ul>
	      <ul class="nav navbar-nav navbar-right">
	        <li><a href="register.php">Sign Up</a></li>
	      </ul>
	    </div>
	  </div>
	</nav>
	<br><br>

	<!-- LOGIN FORMS -->
	<div class="jumbotron" style="background-color: #c5baba">
	<div class="container">
		<form class="form-horizontal" id="lg-form">
		  <fieldset>
		    <legend class="display-4">Log-In</legend>

		    <div class="form-group">
		      <label class="col-lg-2 control-label">Selects</label>
		     	<div class="col-lg-7">
			        <select class="form-control" id="select" name="select">
			          <option>Student</option>
			          <option>Teacher</option>
			        </select>
		    	</div>
		    </div>

		    <div class="form-group">
		      <label class="col-lg-2 control-label">Full Name</label>
		      <div class="col-lg-7">
		        <input type="text" class="form-control" id="inputName" placeholder="Full Name" name="inputName">
		        <div id="nameErr"></div>
		      </div>
		    </div>

			<div class="form-group">
		      <label class="col-lg-2 control-label">Password</label>
		      <div class="col-lg-7">
		        <input type="password" class="form-control" id="inputPassword" placeholder="Password" name="inputPassword">
		        <div id="passErr"></div>
		      </div>
		    </div>

		    <div class="form-group" align="center">
		      <div class="col-lg-10">
		      	<br><div class="g-recaptcha" data-sitekey="6LdF06MUAAAAAMc73GPpeF7QzXqHRZ27Z02jfq3x"></div><br>
		      </div>
		    </div>


		    <div class="form-group">
		      <div class="col-lg-6 col-lg-offset-2">
		        <button type="reset" class="btn btn-default">Clear</button>
		        <button id="submit" type="submit" class="btn btn-primary">Submit</button>
		      </div>
		    </div>
		    
		  </fieldset>
		</form>

		<div class="alert alert-warning" style="text-align: center; display: none;" action="#">
  			<strong id="Err"></strong>
		</div>
	</div>
	</div>

	<script>
		$(document).ready(function(){
			$("#submit").click(function(event){
		  		event.preventDefault();

		  		$.ajax({
		  			url: 're_captcha.php',
		  			type: 'POST',
		  			data: $("#lg-form").serialize(),

		  			success: function(data){
		  				console.log(data);
		  				if(data == 'N')
		  				{
		  					//console.log('here');
		  					$("#Err").text("Make sure you check the security CAPTCHA box");
							$(".alert-warning").show();
							$(".alert-warning").fadeOut(2000);
		  				}
		  				else if(data == 'Y')
		  				{
		  					var name = $("#inputName").val();
							var pass = $("#inputPassword").val();
							var select = $("#select").val();

							// alert(select);
							// return false;

					  		$.ajax({
					  			url: 'login_db.php',
								type: 'POST',
								data: {
									name:name,
									pass:pass,
									select:select
								},
								success: function(data)
								{
									// alert(data);
									// return false;

									if(data == "E")
									{
										$("#Err").text("Please fill in the field!");
										$(".alert-warning").show();
										$(".alert-warning").fadeOut(2000);
										grecaptcha.reset();
									}
									if(data == "N")
									{
										$("#Err").text("Invalid Name or Password");
										$(".alert-warning").show();
										$(".alert-warning").fadeOut(2000);
										grecaptcha.reset();
									}
									if(data == "YS")
									{
										$("#Err").text("Success");
										$(".alert-warning").show();
										$(".alert-warning").fadeOut(2000);
										window.location = "std_portal.php";
									}
									if(data == "YT")
									{
										$("#Err").text("Success");
										$(".alert-warning").show();
										$(".alert-warning").fadeOut(2000);
										window.location = "tec_portal.php";
									}
								}
					  		});
		  				}
		  			}
		  		});			  		
		  	});	
		});
	</script>
</body>
</html>