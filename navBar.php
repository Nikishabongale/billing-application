<html>
<head>
	<link rel="icon" href="/BillingApplication/imgs/calculator.png">
	<title>Billing application</title>
	<?php include($_SERVER['DOCUMENT_ROOT'].'/wap_proj/common/bootStrap.php');?>
	<link rel="stylesheet" type="text/css" href="/wap_proj/cssFiles/common/sideNavBar.css">
	<link href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css" rel="stylesheet">
	<script>$('ul.nav > li').click(function (e) {
    e.preventDefault();
    $('ul.nav > li').removeClass('active');
    $(this).addClass('active');
});
$(window).scroll(function() {    
    var scroll = $(window).scrollTop();

     //>=, not <=
    if (scroll >= 300) {
        //clearHeader, not clearheader - caps H
        $("#nav_wrapper").addClass("scrolled");
    }
  else{
    $("#nav_wrapper").removeClass("scrolled");
  }
});

</script>
<style>

#vendour.active, #pur.active{ background-color:blue } 
</style>
</head>
<?php 
    session_start();
    $user_id = $_SESSION["user_id"];
	if(!isset($_SESSION["user_id"]))
    {
        header('Location: /BillingApplication/index.php?error=You are not logged in!');
        exit;
    }
?>

<body>



<nav class="navbar navbar-expand-md bg-dark navbar-dark position-sticky" >

  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
  <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="collapsibleNavbar">
   <div class="container justify-content-center" id="nav_wrapper"> 
    <ul class="navbar-nav ">
      <li class="nav-item active" id="vendor">
        <a class="nav-link " href="/BillingApplication/navMenu/vendors/vendorsPage.php">Vendor</a>
      </li>
      <li class="nav-item" id="pur">
        <a class="nav-link" href="/BillingApplication/navMenu/purchase/purchasePage.php">Purchase</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="/BillingApplication/navMenu/stocks/stocksPage.php">stock</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="/BillingApplication/navMenu/customers/customersPage.php">Customer</a>
      </li> 
      <li class="nav-item">
        <a class="nav-link" href="/BillingApplication/navMenu/sales/salesPage.php">Sales</a>
      </li> 
     
      <li class="nav-item">
        <a class="nav-link" href="/BillingApplication/navMenu/return/returnPage.php">Return</a>
      </li> 
       <li class="nav-item" >
        <img src="../img/logo.png" width="150px" height="50px">
      </li>
      <li class="nav-item">
        <a class="nav-link" href="/BillingApplication/navMenu/estimation/estimationPage.php">Estimation</a>
      </li> 
      <li class="nav-item">
        <a class="nav-link" href="#">Scheme</a>
      </li> 
      <li class="nav-item">
        <a class="nav-link" href="#">Statistic</a>
      </li> 
      <li class="nav-item">
        <a class="nav-link" href="#">Reminders</a>
      </li>      
    </ul>
    </div>
    <ul class="nav navbar-nav ml-auto">
     <li class="nav-item ">
        <a class="nav-link" href="/BillingApplication/authentication/logout.php ">Logout</a>
      </li>
    </ul>
</nav>	

		<!-- </div>
	</div> -->
	<img scr="/home/bhavyashree/Desktop/moonmo.jpg" height="500px" width="400px">
</body>
</main>
</html>
			
