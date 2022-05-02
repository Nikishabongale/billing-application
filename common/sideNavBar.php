<head>
	<link rel="icon" href="/BillingApplication/imgs/calculator.png">
	<title>Billing application</title>
	<?php include($_SERVER['DOCUMENT_ROOT'].'/BillingApplication/common/bootstrap_link.php');?>
	<link rel="stylesheet" type="text/css" href="/BillingApplication/cssFiles/common/sideNavBar.css">
	<link href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css" rel="stylesheet">
	<script>
  window.onscroll = function() {scrollFunction()};

	function scrollFunction() {
	  if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
		document.getElementById("logoImgLeft").style.display = "none";
	  } else {
		document.getElementById("logoImgCenter").style.display = "block";
	  }
	}
	</script>
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
<nav class="navbar navbar-expand-md navbar-dark fixed-top" id="navbar">
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="collapsibleNavbar">
    <ul class="navbar-nav">
      <li class="nav-item">
      	<a class="nav-link" href="#" style="padding-top: 0px;">
       <span id="logoImgLeft">
        <img src="https://thumbs.dreamstime.com/b/modern-professional-logo-ornament-green-theme-143623956.jpg"  height="40px" width="40px" alt="jewell" class="img-responsive"></a>
       </span>
      </li>
      <li class="nav-item" id="home">
        <a class="nav-link" href="/BillingApplication/navMenu/home/homePage.php">&nbsp;Home</a>
      </li>
      <li class="nav-item" id="vendor">
        <a class="nav-link" href="/BillingApplication/navMenu/vendors/vendorsPage.php">&nbsp;Vendor</a>
      </li>
      <li class="nav-item" id="purchase">
        <a class="nav-link" href="/BillingApplication/navMenu/purchase/purchasePage.php">&nbsp;Purchase</a>
      </li>
      <li class="nav-item" id="stock">
        <a class="nav-link" href="/BillingApplication/navMenu/stocks/stocksPage.php">&nbsp;Stock</a>
      </li>
      <li class="nav-item" id="customer">
        <a class="nav-link" href="/BillingApplication/navMenu/customers/customersPage.php">&nbsp;Customer</a>
      </li>
      <li class="nav-item" id="sale">
        <a class="nav-link" href="/BillingApplication/navMenu/sales/salesPage.php">&nbsp;Sale</a>
      </li>  
      <li class="nav-item" id="return">
        <a class="nav-link" href="/BillingApplication/navMenu/return/returnPage.php">&nbsp;Return</a>
      </li>
	  <li class="nav-item" id="billing">
        <a class="nav-link" href="/BillingApplication/navMenu/billing/billingPage.php">&nbsp;Billing</a>
      </li>
      <li class="nav-item" id="reminder">
        <a class="nav-link" href="/BillingApplication/navMenu/reminders/remindersPage.php">&nbsp;Reminders</a>
      </li>
		<li class="nav-item">
      	<a class="nav-link" href="#" style="padding-top: 0px;">
        <span id="logoImgCenter">
        <img src="https://thumbs.dreamstime.com/b/modern-professional-logo-ornament-green-theme-143623956.jpg" height="40px" width="40px" alt="jewell">
        </span>
		</a>
      </li>	  
    </ul>
    <ul class="navbar-nav ml-auto">
      <li class="nav-item">
        <a class="nav-link" href="/BillingApplication/authentication/logout.php">
		<i class="bx bx-power-off"></i>Logout</a>
      </li>
    </ul>
  </div>  
</nav>