<?php include($_SERVER['DOCUMENT_ROOT'].'/BillingApplication/common/sideNavBar.php');?>
<?php include($_SERVER['DOCUMENT_ROOT'].'/BillingApplication/common/bootstrap_dt.php');?>
<?php include($_SERVER['DOCUMENT_ROOT'].'/BillingApplication/db.php');?>
<script>
	document.getElementById("return").classList.add("active");
</script>
<script>
function deleteData(confirmation,id,quantity,stock_id) {
  if (confirmation == 'yes') {
	window.location="/BillingApplication/navMenu/return/deleteReturn?returnId="+id+"&quantity="+quantity+"&stock_id="+stock_id;
  }
  else{
	var x = document.getElementById(id);
	x.style.display = "none";
	document.body.style.background="white";
	document.body.style.overflow = 'auto';
  }
}
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
			window.location.href="/BillingApplication/navMenu/return/editReturnPage?returnId="+selectedValue;
		}
        //alert("Selected Text: " + selectedText + " Value: " + selectedValue);
    }
</script>
<?php
$sql="select s.stock_id,r.return_id,r.purchase_id,p.item_name,c.customer_id,c.customer_name,r.return_quantity,
r.return_amount,p.gross_weight,p.net_weight,s.balance_due,r.return_date,r.descpn
from returns r, purchase p,customers c, sales s
where r.purchase_id=p.purchase_id and c.customer_id=r.customer_id and s.sales_id=r.sales_id";
$count=0;
$result = mysqli_query($conn, $sql);
?>
<div class="container content">
<main>
		<div class="row">
		<div class="col-sm-12">
					<a href="/BillingApplication/navMenu/return/addReturnPage.php">
						<button class="btn btn-info"><i class="bx bx-plus"></i>Add return</button>
					</a>
				</div>
		</div>
		<br>
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
							<th>Return amount</th>
							<th>Description</th>
							<th>Return date</th>
							<th>Delete</th>
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
							echo "<td>".$row["return_quantity"]."</td>";
							echo "<td>".$row["return_amount"]."</td>";
							echo "<td>".$row["descpn"]."</td>";
							echo "<td>".$row["return_date"]."</td>";
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
												<button type="button" class="btn btn-success" data-bs-dismiss="modal" onclick="deleteData('yes','<?php echo $row['return_id']?>','<?php echo $row['return_quantity']?>','<?php echo $row['stock_id'];?>')">Yes</button>
												<button type="button" class="btn btn-danger" data-bs-dismiss="modal" onclick="deleteData('no','<?php echo $idDelete?>','','')">Close</button>
											</div>
										</div>
									</div>
								</div>
							<?php
							echo "
							<a data-bs-toggle='modal' data-bs-target='#".$idDelete."'>
								<button class='btn btn-danger'><i class='bx bx-trash'></i></button>
							</a>
							<!-- <select id='selectOperation' onchange='GetSelectedTextValue(this)'>
								<option value=''>select</option>
								<option value='$idDelete'>delete</option>
								 <option value=".$row['return_id'].">Edit/View</option> 
							</select>-->
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
