<?php include($_SERVER['DOCUMENT_ROOT'].'/BillingApplication/common/sideNavBar.php');?>
<?php include($_SERVER['DOCUMENT_ROOT'].'/BillingApplication/db.php');?>
<?php include($_SERVER['DOCUMENT_ROOT'].'/BillingApplication/jsFiles/insert_delete_row.php');?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<script src="/BillingApplication/jsFiles/add_edit_sales.js"></script>
<script>
function checkQuantityAddPage()
{
    quanityCalculatePrices();
    var actual_quantity = parseInt(document.getElementById("actual_quantity").value);
    var change_quantity = parseInt(document.getElementById("quantity").value);
    //alert(actual_quantity<change_quantity);
    if(actual_quantity<change_quantity)
    {
        alert("stock has only "+actual_quantity+" items");
        document.getElementById("quantity").value=actual_quantity;
    }
}
</script>
<script>
	document.getElementById("sale").classList.add("active");
</script>
<style>
input[type=number]
{
  width:80px;
  font-size:smaller;
}
.dropDown
{
  font-size:small; 
}
.readonly
{
  background: lightgrey;
}
</style>
<div class="content">
	<main>
			<?php
					if($_GET)
					{
						if(isset($_GET['error'])){
							echo "<div class='alert alert-warning'>". $_GET['error']."</div>";
						}
					}
			?>
		<div id="quantityAlert">
		</div>
		<div style="padding:10px;">
		<div class="table-responsive">
		<form action="/BillingApplication/navMenu/sales/addSale.php" method="post">
			<div>
			<span style="float:left"><b>Customer:&nbsp;</b></span><span style="float:left">
			  <select required name="customerName" id="customerName">
					<option value='' selected>select customer</option>
						<?php 
						$sql1 = "select customer_id,customer_name from customers";
						$result1 = mysqli_query($conn, $sql1);
						if (mysqli_num_rows($result1) > 0) 
						{
						  while($row = mysqli_fetch_assoc($result1)) 
							{
							  echo "<option required value='".$row["customer_id"]."'>".$row["customer_name"]."</option>";
							}
						}
						?>
				</select>
			</span><br>
			</div>
		<table id="addSaleTable" class="table table-bordered table-condensed">
			  <thead>
				<th>Item name</th>
				<th>Quantity</th>
				<th>G.weight<br>(gms)</th>
				<th>N.weight<br>(gms)</th>
				<th>Price/unit</th>
				<th>Less/Unit</th>
				<th>Touch</th>
				<th>Total</th>
				<th>Recieved</th>
				<th>Balance due</th>
				<th>Insert row</th>
			  </thead>
			  <tbody>
				<td>
				<select name="itemName0" id="itemName0" class="dropDown" onchange="assignWeightRowWise(this)">
				  <option value="" selected>select item</option>
					<?php 
					$sql = "select item_name,p.purchase_id,gross_weight,net_weight,st.quantity,st.stock_id
					from purchase p,stock st
					where p.purchase_id=st.purchase_id";
							$result = mysqli_query($conn, $sql);
							if (mysqli_num_rows($result) > 0) 
									{
										while($row = mysqli_fetch_assoc($result)) 
										{
											echo "<option value='{".'"'.'gweight'.'"'.':'.'"'.$row["gross_weight"].'"'.','.'"'.'net_weight'.'"'.':'.'"'.$row["net_weight"].'"'.
												','.'"'.'purchase_id'.'"'.':'.'"'.$row["purchase_id"].'"'.','.'"'.'quantity'.'"'.':'.'"'.$row["quantity"].'"'.','.
												'"'.'stock_id'.'"'.':'.'"'.$row["stock_id"].'"'.','.'"'.'rowIndex'.'"'.':'.'"'.'0'.'"'."}'>"
												.$row["item_name"]." (".$row["quantity"]." items)"
												."</option>";
										}
									}?>
				  </select>
				</td>
				<td>
				  <input type="number" class="readonly" readonly min=1 onchange="verifyQuantity('0')" onkeyup="verifyQuantity('0')" onkeydown="verifyQuantity('0')" required id="quantity0" min="1" placeholder="quantity" name="quantity0">
				  <input type="hidden" name="stockQuantity0" id="stockQuantity0">
				</td>
				<td>
				<input type="number" class="readonly" readonly step="0.001" min=0 id="gweight0" name="gweight0">
				</td>
				<td>
				<input type="number" class="readonly" readonly step="0.001" min=0 id="netweight0" name="netweight0">
				</td>
				<td>
				<input type="number" required step="0.001" min=0 id="priceUnit0" placeholder="price/unit" onchange="calculateFinalAmount('0')" onkeyup="calculateFinalAmount('0')" onkeydown="calculateFinalAmount('0')" name="priceUnit0">
				</td>
				<td><input  type="number" onchange="calculateFinalAmount('0')" onkeyup="calculateFinalAmount('0')" onkeydown="calculateFinalAmount('0')" name="less0" id="less0" placeholder="less"></td>
				<td><input  type="number" onchange="calculateFinalAmount('0')" onkeyup="calculateFinalAmount('0')" onkeydown="calculateFinalAmount('0')" name="touch0" id="touch0" placeholder="touch"></td>
				<td>
				<span id="finalAmountSpan0"></span>
				<input type="hidden" name="finalAmount0" id="finalAmount0">
				</td>
				<td>
				  <input type="number" required onchange="calculateBalanceDue('0')" onkeyup="calculateBalanceDue('0')" onkeydown="calculateBalanceDue('0')" step="0.001" min=0 id="receivedAmount0" placeholder="recieved" name="receivedAmount0">
				</td>
				<td><span id="balanceDueSpan0"></span>
				<input type="hidden" name="balanceDue0" id="balanceDue0">
				</td>
				<td>
				  <buton onclick="addField();" class="btn btn-info"><i class="bx bx-plus-circle"></i></button>
				  <input type="hidden" value="1" name="hiddenIndex">
				</td>
			  </tbody>
			</table>
			<input type="hidden" id="hiddenIndexArray" value="0" name="hiddenIndexArray">
			<input type="submit" class="btn btn-info" name="submit">
				</form>
		  <?php mysqli_close($conn);?>
		   </div>
			</div>
	</main>
</div>
