<title>Billing application</title>
<?php include($_SERVER['DOCUMENT_ROOT'].'/BillingApplication/common/sideNavBar.php');?>
<?php include($_SERVER['DOCUMENT_ROOT'].'/BillingApplication/common/bootstrap_dt.php');?>
<script>
function deleteData(confirmation,id) {
  if (confirmation == 'yes') {
	window.location="/BillingApplication/navMenu/vendors/deleteVendors?vendorId="+id;
  }
}
</script>
<script>
	document.getElementById("vendor").classList.add("active");
</script>
<?php include($_SERVER['DOCUMENT_ROOT'].'/BillingApplication/db.php');?>
<?php 
$sql = "select * from vendors";
$count=0;
$result = mysqli_query($conn, $sql);
?>
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
		<div class="col-sm-12">
			<a href="/BillingApplication/navMenu/vendors/addVendorsPage.php">
				<button class="btn btn-info"><i class="bx bx-plus"></i>Add vendor</button>
			</a>
		</div>
		</div><br>
		<div class="row">
			<div class="col-sm-12">
				<table id="table" class="table table-striped" style="width:100%">
					<thead>
						<tr>
							<th>SNo</th>
							<th>Name</th>
							<th>Phone number</th>
							<th>Address</th>
							<th>Email id</th>
							<th>Update</th>
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
							echo "<td>".$row["name"]."</td>";
							echo "<td>".$row["phone_number"]."</td>";
							echo "<td style='white-space: pre-wrap;''>".$row["address"]."</td>";
							echo "<td>".$row["email_id"]."</td>";
							echo 
							"<td>
								<a href='/BillingApplication/navMenu/vendors/editVendorsPage?vendorId=".$row["vendor_id"]."'>
									<button class='btn btn-info'><i class='bx bx-pencil'></i></button>
								</a>
							</td><td>";
							$idDelete = 'deleteData'.$count;
							?>
								<div class="modal" id="<?php echo $idDelete;?>">
									<div class="modal-dialog modal-fullscreen-sm-down">
										<div class="modal-content">
											<!-- Modal body -->
											<div class="modal-body">
												Are you sure to delete?
											</div>
											<!-- Modal footer -->
											<div class="modal-footer">
												<button type="button" class="btn btn-success" data-bs-dismiss="modal" onclick="deleteData('yes','<?php echo $row['vendor_id']?>')">Yes</button>
												<button type="button" class="btn btn-danger" data-bs-dismiss="modal" onclick="deleteData('no','')">Close</button>
											</div>
										</div>
									</div>
								</div>
						<?php	
							echo 
							"	<a data-bs-toggle='modal' data-bs-target='#".$idDelete."'>
									<button class='btn btn-danger'><i class='bx bx-trash'></i></button>
								</a>
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
