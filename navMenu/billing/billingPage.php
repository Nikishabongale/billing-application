<?php include($_SERVER['DOCUMENT_ROOT'].'/BillingApplication/common/sideNavBar.php');?>
<?php include($_SERVER['DOCUMENT_ROOT'].'/BillingApplication/db.php');?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<script src="/BillingApplication/jsFiles/bill.js"></script>
<script>
	document.getElementById("billing").classList.add("active");
</script>
<div class="container content">
<main>
		<?php
		if($_GET)
		{
			if( isset($_GET['success'])){
				echo "<div class='alert alert-success'><strong>". $_GET['success']."</strong></div>";
			}
			else if(isset($_GET['error'])){
				echo "<div class='alert alert-warning'>". $_GET['error']."</div>";
			}
		}
		
		?>
		<div class="row">
			<div class="col-12">
				<form action="createPdf.php" method="post">
					<div class="form-group col-sm-3">
						<label for="customerName">Customer:</label>
						<select class="form-control" required name="customerName" id="customerName" onchange="getSaleReturn(this)">
							<option value=''>Select Customer</option>
							<?php 
								$sql="select * from customers";
								$result = mysqli_query($conn, $sql);
								if (mysqli_num_rows($result) > 0) 
								{
									while($row = mysqli_fetch_assoc($result))
									{
										echo "<option value='".$row["customer_id"]."'>";
										echo $row["customer_name"];
										echo "</option>";
									}
								}
								?>				
						</select>
					</div>
				<h4>Sales</h4>
				<table id="saleBilling" class="table table-striped" style="width:100%">
					<thead>
						<tr>
							<th></th>
							<th>Item</th>
							<th>Sale Quantity</th>
							<th>Sale amount</th>
							<th>Date</th>
						</tr>
					</thead>
					<tbody id="saleBody">
					</tbody>
				</table>
				<h4>Returns</h4>
				<table id="returnBilling" class="table table-striped" style="width:100%">
					<thead>
					<tr>
						<th></th>
						<th>Item</th>
						<th>Return Quantity</th>
						<th>Return amount</th>
						<th>Date</th>
					</tr>
					</thead>
					<tbody id="returnBody">
					</tbody>
				</table>
				<div id="hiddenElement"></div>
				<button type="submit" class="btn btn-info">PRINT BILL</button>
				</form>
				<?php mysqli_close($conn);?>
			</div>
		</div>
	</div>
	</body>
</html>
