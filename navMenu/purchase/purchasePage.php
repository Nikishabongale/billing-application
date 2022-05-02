<title>Billing application</title>
<?php include($_SERVER['DOCUMENT_ROOT'].'/BillingApplication/common/sideNavBar.php');?>
<?php include($_SERVER['DOCUMENT_ROOT'].'/BillingApplication/common/bootstrap_dt.php');?>
<script src="/BillingApplication/jsFiles/purchase_stock.js"></script>
<script>
function deleteData(confirmation,id,quantity) {
  if (confirmation == 'yes') {
	window.location="/BillingApplication/navMenu/purchase/deletePurchase?purchaseHistoryId="+id+"&quantity="+quantity;
  }
  else{
	var x = document.getElementById(id);
	x.style.display = "none";
	document.body.style.background="white";
	document.body.style.overflow = 'auto';
  }
}
</script>
<script>
	document.getElementById("purchase").classList.add("active");
</script>
<?php include($_SERVER['DOCUMENT_ROOT'].'/BillingApplication/db.php');?>
<?php 
$sql = "select p.item_name,p.vendor_id,pc.quantity,p.gross_weight,p.net_weight,
pc.price_unit,pc.date,v.name,p.purchase_id,pc.p_history_id
from purchase p right join purchase_child pc 
on pc.purchase_id=p.purchase_id
left join vendors v on v.vendor_id=p.vendor_id";
$count=0;
$result = mysqli_query($conn, $sql);
?>
<div class="container content">
	<main>
	  <div class="row">
		<div class="col-sm-12">
				<a href="/BillingApplication/navMenu/purchase/addPurchaseItemPage.php">
						<button class="btn btn-info"><i class="bx bx-plus"></i>Add purchase item</button>
					</a>
		   </div>
		</div><br>
		
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
			<div class="col-sm-12">
				<table id="table" class="table table-striped" style="width:100%">
					<thead>
						<tr>
							<th>SNo</th>
							<th>Item</th>
							<th>Vendor</th>
							<th>Quantity</th>
							<th>Gross weight(grams)<br>(single piece)</th>
							<th>Net weight(grams)<br>(single piece)</th>
							<th>Price/unit</th>
							<th>Total</th>
							<th>Inserted/<br>updated date</th>
							<th>Operate</th>
						</tr>
					</thead>
					<tbody>
					<?php 
					if (mysqli_num_rows($result) > 0) 
					{
						while($row = mysqli_fetch_assoc($result)) 
            			{
							$count++;
							echo "<tr>";
							echo "<td>".$count."</td>";
							echo "<td>".$row["item_name"]."</td>";
							echo "<td>".$row["name"]."</td>";
							echo "<td>".$row["quantity"]."</td>";
							echo "<td>".$row["gross_weight"]."</td>";
							echo "<td>".$row["net_weight"]."</td>";
							echo "<td>".$row["price_unit"]."</td>";
							echo "<td>".(float)$row["price_unit"]*(float)$row["quantity"]."</td>";
							echo "<td>".$row["date"];
							$idDelete = 'deleteData'.$count;
							?>
								<div class="modal" name="modalOpen" id="<?php echo $idDelete;?>">
									<div class="modal-dialog modal-fullscreen-sm-down">
										<div class="modal-content" id="modaleBody">
											<!-- Modal body -->
											<div class="modal-body">
												Are you sure to delete?
												<p><small>(It'll be deleted from stock page too.)</small></p>
											</div>
											<!-- Modal footer -->
											<div class="modal-footer">
												<button type="button" class="btn btn-success" data-bs-dismiss="modal" onclick="deleteData('yes','<?php echo $row['p_history_id']?>','<?php echo $row['quantity'];?>')">Yes</button>
												<button type="button" class="btn btn-danger" data-bs-dismiss="modal" onclick="deleteData('no','<?php echo $idDelete?>')">Close</button>
											</div>
										</div>
									</div>
								</div>
						    <?php	
							echo"</td><td>
								<select id='selectOperation' onchange='GetSelectedTextValue(this)'>
									<option value=''>select</option>
									<option value='$idDelete'>delete</option>
									<option value=".$row['p_history_id'].">Edit/View</option>
								</select>
								</td>";
							echo "</tr>";
						}
					}
	 				mysqli_close($conn);
					 ?>	
					</tbody>
				</table>
			</div>
		</div>
	</main>
</div>
</div>
</body>
</html>
