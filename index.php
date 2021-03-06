<!DOCTYPE html>
<html lang="en">
<head>
  <link rel="icon" href="/BillingApplication/imgs/calculator.png">
  <title>Billing Application</title>
  <?php include($_SERVER['DOCUMENT_ROOT'].'/BillingApplication/common/bootstrap_link.php');?>
  <link rel="stylesheet" type="text/css" href="cssFiles/authentication/login.css">
  <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</head>
   <body class="loginBody">
      <div class="container">
      <br><br>
         <div class="container col-sm-8">
            <div class="row">
               <div class="col-sm-5"><br>
               <?php
		if($_GET)
		{
			if( isset($_GET['success']))
			{
				echo "<div class='alert alert-success'><strong>". $_GET['success']."</strong></div>";
			}
			else if(isset($_GET['error']))
			{
				echo "<div class='alert alert-warning'>". $_GET['error']."</div>";
			}
		}
				
	    ?>
                  <br>
                  <h3>LOGIN</h3>
                  <hr style="background-color:darkblue;height:1px">
                  <form action="authentication/loginAuthentication.php" method="post" class="form">
                     <div class="form-group">
                        <label class="control-label" for="name">Name:</label>
                        <div class="input-group">
                           <div class="input-group-prepend">
                              <span class="input-group-text" id="basic-addon1"><i class="fas fa-user"></i></span>
                           </div>
                           <input required  type="text" class="form-control" id="uname" name="uname" placeholder="Enter name">
                        </div>
                     </div>
                     <div class="form-group">
                        <label class="control-label" for="pwd">Password:</label>
                        <div class="input-group">
                           <div class="input-group-prepend">
                              <span class="input-group-text" id="basic-addon1"><i class="fas fa-lock"></i></span>
                           </div>
                           <input required  type="password" class="form-control" id="pswd" name="pswd" placeholder="Enter password">
                        </div>
                     </div>
                     <br>
                     <button class="btn btn-block btn-info" type="submit">Submit</button>
                  </form>
                  <br>
               </div>
               <div class="col-sm-7">
                  <div id="demo" class="carousel slide" data-ride="carousel" data-interval="3000">
                     <!-- Indicators -->
                     <ul class="carousel-indicators">
                        <li data-target="#demo" data-slide-to="0" class="active"></li>
                        <li data-target="#demo" data-slide-to="1"></li>
                        <li data-target="#demo" data-slide-to="2"></li>
                     </ul>
                     <!-- The slideshow -->
                     <div class="carousel-inner">
                        <div class="carousel-item active">
                           <img class="img-responsive"  src="./imgs/1a.jpeg" alt="Los Angeles" width="500px" height="400px">
                           <div class="carousel-caption">
                              <p class="caption">Easy track of profit & loss</p>
                           </div>
                        </div>
                        <div class="carousel-item">
                           <img class="img-responsive"  src="./imgs/1b.jpg" alt="Chicago" width="500px" height="400px">
                           <div class="carousel-caption">
                              <p class="caption">Bill generation on single click</p>
                           </div>
                        </div>
                        <div class="carousel-item">
                           <img class="img-responsive"  src="./imgs/1c.jpg" alt="New York" width="500px" height="400px">
                           <div class="carousel-caption">
                              <p class="caption">Record of sale,purchase and customers</p>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </body>
</html>
