<?php include($_SERVER['DOCUMENT_ROOT'].'/BillingApplication/common/sideNavBar.php');?>
<link href="https://cdn.datatables.net/1.11.3/css/dataTables.bootstrap5.min.css" rel="stylesheet">
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.3/js/dataTables.bootstrap5.min.js"></script>
<script>
$(document).ready(function() {
    $('#estimationTable').DataTable();
} );
</script>
<script>
function deleteData(confirmation,id,quantity) {
  if (confirmation == 'yes') {
	window.location="/BillingApplication/navMenu/estimation/deleteEstimation?estimationId="+id+"&quantity="+quantity;
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
			window.location.href="/BillingApplication/navMenu/estimation/editEstimationPage?estimationId="+selectedValue;
		}
        else if(selectedText=='Add to sale')
        {
            window.location.href="/BillingApplication/navMenu/sales/estimationToSalePage?estimationId="+selectedValue;
        }
        //alert("Selected Text: " + selectedText + " Value: " + selectedValue);
    }
</script>
<?php include($_SERVER['DOCUMENT_ROOT'].'/BillingApplication/db.php');?>
<?php 
$sql = "select s.estimation_id,c.customer_name,p.item_name,sk.quantity sk_quantity,s.quantity as s_quantity,s.amount,
s.date,s.purchase_id
from estimation s, purchase p, stock sk,customers c
where c.customer_id=s.customer_id and p.purchase_id=s.purchase_id and sk.stock_id=s.stock_id;";
//echo $sql;
$count=0;
$result = mysqli_query($conn, $sql);
?>
	<main class="col ps-md-2 pt-2">
		<div class="page-header pt-3">
			<h3>
				<div style="float:left">
					<a href="#" data-bs-target="#sidebar" data-bs-toggle="collapse"><button type="button" class="btn btn-dark"><i class='bx bx-menu'></i></button></a>
				</div>
				<span style="margin-left:auto">Estimation/Quotation</span>
				<div style="float:right">
					<a href="/BillingApplication/navMenu/estimation/addEstimationPage.php">
						<button class="btn btn-info"><i class="bx bx-plus"></i>Add estimation</button>
					</a>
				</div>
			</h3>
		</div>
		<hr>
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
				<table id="estimationTable" class="table table-striped" style="width:100%">
					<thead>
						<tr>
							<th>SNo</th>
							<th>Item</th>
							<th>Customer</th>
							<th>Quantity</th>
							<th>Total</th>
							<th>Date</th>
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
							echo "<td>".$row["amount"]."</td>";
							echo "<td>".$row["date"]."</td>";
                            echo "<td>";
							$idDelete = 'deleteData'.$count;?>
								<div class="modal" id="<?php echo $idDelete;?>">
									<div class="modal-dialog modal-fullscreen-sm-down">
										<div class="modal-content">
											<!-- Modal body -->
											<div class="modal-body">
												Are you sure to delete?
												<p><small>(It'll be deleted from stock page too.)</small></p>
											</div>
											<!-- Modal footer -->
											<div class="modal-footer">
												<button type="button" class="btn btn-success" data-bs-dismiss="modal" onclick="deleteData('yes','<?php echo $row['estimation_id']?>','<?php echo $row['s_quantity']?>')">Yes</button>
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
								<option value=".$row['estimation_id'].">Edit/View</option>
                                <option value=".$row['estimation_id'].">Add to sale</option>
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
</body>
</html>
