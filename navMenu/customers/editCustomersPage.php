<?php include($_SERVER['DOCUMENT_ROOT'].'/BillingApplication/common/sideNavBar.php');?>
<?php include($_SERVER['DOCUMENT_ROOT'].'/BillingApplication/db.php');?>
<script>
	document.getElementById("customer").classList.add("active");
</script>
<div class="content">
	<main>
			<?php
					$name = '';
					$phoneNumber='';
					$emailId='';
					$address='';
					$customer_id='';
					if($_GET)
					{
						if(isset($_GET['error'])){
							echo "<div class='alert alert-warning'>". $_GET['error']."</div>";
						}
						if(isset($_GET['customerId'])){
							$sql = "select * from customers where customer_id='".$_GET['customerId']."'";
							$result = mysqli_query($conn, $sql);
							if (mysqli_num_rows($result) > 0) 
							{
								while($row = mysqli_fetch_assoc($result)) 
								{
									$name = $row["customer_name"];
									$phoneNumber = $row["phone_number"];
									$emailId = $row["email_id"];
									$address = $row["address"];
									$customer_id=$row["customer_id"];
								}
							}
						}
					}
					//echo $name;
					mysqli_close($conn);
			?>
		<div class="container row" style="margin:auto">
			<div class="container">
			  <div class="row shadowedBox col-sm-6" style="margin:auto">
				<div class="col-sm-12">
				<form action="/BillingApplication/navMenu/customers/editCustomers.php" method="post">
					<div>
					  <label for="name">Name:</label>
					  <input type="text" class="form-control" value="<?php echo $name;?>" required placeholder="Enter name" name="name" id="name">
					</div>
					<div>
					  <label for="phoneNumber">Phone Number:</label>
					  <input type="text" value="<?php echo $phoneNumber;?>" class="form-control" id="phoneNumber" placeholder="Enter phone number" name="phoneNumber">
					</div>
					<div>
					  <label for="emailId">Email:</label>
					  <input type="email" class="form-control" value="<?php echo $emailId;?>"  placeholder="Enter email id" id="emailId" name="emailId">
					</div>
					<div>
						<div class="form-group">
							<label>Address:</label>
							<textarea class="form-control" name="address" id="address" rows="3"><?php echo $address;?></textarea>
						</div>
					</div><br>
					<input type="hidden" id="customer_id" name="customer_id" value="<?php echo $customer_id;?>">
					<input type="submit" class="btn btn-info" name="submit">
				</form>
				</div>
			  </div>
			</div>
		</div>
	</main>
</div>
