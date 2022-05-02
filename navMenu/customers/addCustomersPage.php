<?php include($_SERVER['DOCUMENT_ROOT'].'/BillingApplication/common/sideNavBar.php');?>
		<?php
				if($_GET)
				{
					if(isset($_GET['error'])){
						echo "<div class='alert alert-warning'>". $_GET['error']."</div>";
					}
				}
		?>
	<script>
		document.getElementById("customer").classList.add("active");
	</script>
<main>
<div class="content">
	<div class="container row" style="margin:auto">
		<div class="container" style="margin:auto">
			  <div class="row shadowedBox col-sm-6" style="margin:auto">
				<div class="col-sm-12">
				<form action="/BillingApplication/navMenu/customers/addCustomer.php" method="post">
					<div>
					  <label for="name">Name:</label>
					  <input type="text" class="form-control" required placeholder="Enter name" name="name" id="name">
					</div>
					<div>
					  <label for="phoneNumber">Phone Number:</label>
					  <input type="text" class="form-control" id="phoneNumber" placeholder="Enter phone number" name="phoneNumber">
					</div>
					<div>
					  <label for="emailId">Email:</label>
					  <input type="email" class="form-control" placeholder="Enter email id" id="emailId" name="emailId">
					</div>
					<div>
						<div class="form-group">
							<label>Address:</label>
							<textarea class="form-control" name="address" id="address" rows="3"></textarea>
						</div>
					</div><br>
					<input type="submit" class="btn btn-info" name="submit">
				</form>
				</div>
			  </div>
		</div>
	</div>
</div>
</main>
