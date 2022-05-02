<title>Billing application</title>
<?php include($_SERVER['DOCUMENT_ROOT'].'/BillingApplication/common/sideNavBar.php');?>
<?php include($_SERVER['DOCUMENT_ROOT'].'/BillingApplication/common/bootstrap_dt.php');?>
<?php include($_SERVER['DOCUMENT_ROOT'].'/BillingApplication/db.php');?>
<script src="/BillingApplication/jsFiles/purchase_stock.js"></script>
<script>
	document.getElementById("stock").classList.add("active");
</script>
<?php 
$sql = "select p.descrptn,p.purchase_id,s.quantity,p.item_name,p.gross_weight,p.net_weight from stock s, purchase p where s.purchase_id=p.purchase_id";
$count=0;
$result = mysqli_query($conn, $sql);
?>
<div class="container content">
	<main>
	<div class="row">
		<div class="col-sm-12">
		<div class="page-header pt-3">
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
							<th>Quantity</th>
							<th>Gross weight(grams)<br>(single piece)</th>
							<th>Net weight(grams)<br>(single piece)</th>
							<th>Description</th>
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
							echo "<td>".$row["quantity"]."</td>";
							echo "<td>".$row["gross_weight"]."</td>";
							echo "<td>".$row["net_weight"]."</td>";
							echo "<td style='white-space: pre-wrap;''>".$row["descrptn"]."</td>";
							echo "<td>
							<select id='selectOperation' onchange='GetSelectedTextValue(this)'>
								<option value=''>select</option>
								<option value=".$row['purchase_id'].">Add stock</option>
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
</body>
</html>
