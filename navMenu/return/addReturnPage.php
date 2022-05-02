<?php include($_SERVER['DOCUMENT_ROOT'].'/BillingApplication/common/sideNavBar.php');?>
<?php include($_SERVER['DOCUMENT_ROOT'].'/BillingApplication/db.php');?>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
<script src="/BillingApplication/jsFiles/return_item.js"></script>
<script>
function calculateQuantity()
{
	var quantity = document.getElementById("quantity").value;
	var price_per_unit = document.getElementById("return_amount_display").value;
	var total = quantity*price_per_unit;
	document.getElementById("total").innerHTML="&nbsp;<u><i>total:"+total+"</i></u>";
	document.getElementById("return_amount").value=total;
}
</script>
<script>
	document.getElementById("return").classList.add("active");
</script>
<main>
		<?php
		if($_GET)
		{
			if(isset($_GET['error'])){
				echo "<div class='alert alert-warning'>". $_GET['error']."</div>";
					}
		}
		?>
<div class="content">
	<div class="container row" style="margin:auto">	
		<div class="container" style="margin:auto">
			  <div class="row shadowedBox col-sm-6" style="margin:auto">
				<div class="col-sm-12">
				<form action="/BillingApplication/navMenu/return/addReturn.php" method="post">
				<div>
					  <label for="customerName">Customer name:</label>
						<select required onchange="assignItem()" name="customerName" id="customerName" class="form-control">
							<option value='' selected>select customer</option>
							<?php
							if($_GET)
							{
								$customer_id=$_GET["customer_id"];

								$sql1 = "select s.customer_id,c.customer_name from sales s,customers c where s.customer_id=c.customer_id group by c.customer_id";
								$result1 = mysqli_query($conn, $sql1);
								if (mysqli_num_rows($result1) > 0) 
								{
									while($row = mysqli_fetch_assoc($result1)) 
									{
										if($row["customer_id"]==$customer_id)
										{
											echo "<option selected value='".$row["customer_id"]."'>".$row["customer_name"]."</option>";
										}
										else
										{
											echo "<option required value='".$row["customer_id"]."'>".$row["customer_name"]."</option>";
										}
									}
								}

							}
							else
							{
								$sql1 = "select s.customer_id,c.customer_name from sales s,customers c where s.customer_id=c.customer_id group by c.customer_id";
								$result1 = mysqli_query($conn, $sql1);
								if (mysqli_num_rows($result1) > 0) 
								{
									while($row = mysqli_fetch_assoc($result1)) 
									{
										echo "<option required value='".$row["customer_id"]."'>".$row["customer_name"]."</option>";
									}
								}
							} 
							?>
						</select>
					</div>
					<div>
					  <label for="itemName">Item name:</label>
					   <select required onchange="assignRestContent()" name="itemName" id="itemName" class="form-control">
					   </select>
					</div>
					<input type="hidden" name="sales_id" id="sales_id">
					<input type="hidden" name="stock_id" id="stock_id">
					<?php mysqli_close($conn);?>
					<div>
					  <label for="quantity">Quantity:</label>
					  <input type="number" onchange="checkQuantityReturn()" min=1 required class="form-control" id="quantity" placeholder="Enter item quantity" name="quantity">
					  <input type="hidden" name="actual_quantity" id="actual_quantity">
					</div>
					<div>
					  <label for="quantity">Return amount(Per unit):</label><span id="total"></span>
					  <input type="number" onchange="calculateQuantity()" onkeyup="calculateQuantity()" onkeydown="calculateQuantity()" min=1 required  class="form-control" id="return_amount_display" placeholder="Enter return amount" name="return_amount_display">
					  <input type="hidden" name="return_amount" id="return_amount">
					</div>
					<div>
						<div class="form-group">
							<label>Descriptioin:</label>
							<textarea class="form-control" name="desc" id="desc" rows="3"></textarea>
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
</body>
</html>
