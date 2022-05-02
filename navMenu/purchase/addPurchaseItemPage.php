<title>Billing application</title>
<?php include($_SERVER['DOCUMENT_ROOT'].'/BillingApplication/common/sideNavBar.php');?>
<script>
function calculateTotal()
{
	var price_per_unit = document.getElementById("priceUnit").value;
	var quantity = document.getElementById("quantity").value;
	var total= price_per_unit*quantity;
	//alert(total);
	document.getElementById("total").innerHTML="&nbsp;<u><i>total:"+total+"</i></i>";
}
</script>
<script>
	document.getElementById("purchase").classList.add("active");
</script>
<main>
	<div class="content">
		<div class="container row" style="margin:auto">
		<?php
				if($_GET)
				{
					if(isset($_GET['error'])){
						echo "<div class='alert alert-warning'>". $_GET['error']."</div>";
					}
				}
		?>
		  <div class="row shadowedBox col-sm-6" style="margin:auto">
			<div class="col-sm-12">
			<form action="/BillingApplication/navMenu/purchase/addPurchaseItem.php" method="post">
				<div class="mb-3">
				  <label for="itemName">Item name:</label>
				  <input type="text" class="form-control" required placeholder="Enter item name" name="itemName" id="itemName">
				</div>
				<div class="mb-3">
				  <label for="quantity">Quantity:</label>
				  <input type="number" min=0 required class="form-control" onchange="calculateTotal()" onkeyup="calculateTotal()" onkeydown="calculateTotal()" id="quantity" placeholder="Enter item quantity" name="quantity">
				</div>

				<?php include($_SERVER['DOCUMENT_ROOT'].'/BillingApplication/db.php');
					$sql = "select * from vendors";
					$result = mysqli_query($conn, $sql);
				?>
				<div class="mb-3">
				  <label for="vendor">Vendor:</label>
					<select class="form-control" id="vendor" name="vendor">
						<option value=''></option>
						<?php
							if (mysqli_num_rows($result) > 0) 
							{
								while($row = mysqli_fetch_assoc($result)) 
            					{
									echo "<option value='".$row["vendor_id"]."'>".$row["name"]."</option>";
								}
							}
						?>
					</select>				
				</div>
				<?php mysqli_close($conn);?>

				<div class="mb-3">
				  <label for="gweight">Gross weight(grams):</label>
				  <input type="number" step="0.001" min=0 class="form-control" id="gweight" placeholder="Enter gross weight" name="gweight">
				</div>
				<div class="mb-3">
				  <label for="netweight">Net weight(grams):</label>
				  <input type="number" step="0.001" min=0 class="form-control" id="netweight" placeholder="Enter net weight" name="netweight">
				</div>
				<div class="mb-3">
				  <label for="netweight">Price per unit:</label><span id="total"></span>
				  <input type="number" required onkeyup="calculateTotal()"  onkeydown="calculateTotal()" onchange="calculateTotal()" step="0.001" min=0 class="form-control" id="priceUnit" placeholder="Enter price per unit" name="priceUnit">
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
</main>
