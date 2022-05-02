<?php include($_SERVER['DOCUMENT_ROOT'].'/BillingApplication/common/sideNavBar.php');?>
<?php include($_SERVER['DOCUMENT_ROOT'].'/BillingApplication/common/bootstrap_dt.php');?>
<?php include($_SERVER['DOCUMENT_ROOT'].'/BillingApplication/db.php');?>
<script>
function deleteData(confirmation,id,quantity) {
  if (confirmation == 'yes') {
	window.location="/BillingApplication/navMenu/sales/deleteSale.php?saleId="+id+"&quantity="+quantity;
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
	document.getElementById("sale").classList.add("active");
</script>

<script type="text/javascript">
    function GetSelectedTextValue(selectOperation) {
        var selectedText = selectOperation.options[selectOperation.selectedIndex].innerHTML;
        var selectedValue = selectOperation.value;
		if(selectedText=='delete')
		{
			document.getElementById("selectOperation").value='';
			var x = document.getElementById(selectedValue);
			x.style.display = "block";
			document.body.style.setProperty('background', 'grey', 'important');
			document.body.style.overflow = 'hidden';
		}
		else if(selectedText=='Edit/View')
		{
			window.location.href="/BillingApplication/navMenu/sales/editSalesPage.php?salesId="+selectedValue;
		}
        //alert("Selected Text: " + selectedText + " Value: " + selectedValue);
    }
</script>
<?php include($_SERVER['DOCUMENT_ROOT'].'/BillingApplication/db.php');?>
<?php 
$sql = "select s.sales_id,c.customer_name,p.item_name,sk.quantity sk_quantity,s.quantity as s_quantity,s.final_amount,s.balance_due,
s.date,s.purchase_id,s.touch,s.less
from sales s, purchase p, stock sk,customers c
where c.customer_id=s.customer_id and p.purchase_id=s.purchase_id and sk.stock_id=s.stock_id";
$count=0;
$result = mysqli_query($conn, $sql);
?>
<div class="container content">
	<main>
	<div class="row">
		<div class="col-sm-12">
					<a href="/BillingApplication/navMenu/sales/addSalesPage.php">
						<button class="btn btn-info"><i class="bx bx-plus"></i>Add sales</button>
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
							<th>Customer</th>
							<th>Quantity</th>
							<th>Touch</th>
							<th>Less</th>
							<th>Total</th>
							<th>Balance due</th>
							<th>Sold date</th>
							<th>Operation</th>
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
							echo "<td>".$row["customer_name"]."</td>";
							echo "<td>".$row["s_quantity"]."</td>";
							echo "<td>".$row["touch"]."</td>";
							echo "<td>".$row["less"]."</td>";
							echo "<td>".$row["final_amount"]."</td>";
							echo "<td>".$row["balance_due"]."</td>";
							echo "<td>".$row["date"]."</td>";
                            echo "<td>";
							$idDelete = 'deleteData'.$count;?>
								<div class="modal" id="<?php echo $idDelete;?>">
									<div class="modal-dialog modal-fullscreen-sm-down">
										<div class="modal-content">
											<!-- Modal body -->
											<div class="modal-body">
												Are you sure to delete?
											</div>
											<!-- Modal footer -->
											<div class="modal-footer">
												<button type="button" class="btn btn-success" data-bs-dismiss="modal" onclick="deleteData('yes','<?php echo $row['sales_id']?>','<?php echo $row['s_quantity']?>')">Yes</button>
												<button type="button" class="btn btn-danger" data-bs-dismiss="modal" onclick="deleteData('no','<?php echo $idDelete?>','')">Close</button>
											</div>
										</div>
									</div>
								</div>
							<?php
							echo "
							<select id='selectOperation' onchange='GetSelectedTextValue(this)'>
								<option value=''>select</option>
								<option value='$idDelete'>delete</option>
								<option value=".$row['sales_id'].">Edit/View</option>
							</select>
							</td></tr>";
							?>
						    <?php
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
</body>
</html>
