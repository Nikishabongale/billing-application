<title>Billing application</title>
<?php include($_SERVER['DOCUMENT_ROOT'].'/BillingApplication/common/sideNavBar.php');?>
<?php include($_SERVER['DOCUMENT_ROOT'].'/BillingApplication/db.php');?>
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
                $item_name='';
                $quantity='';
                $purchase_id='';
				$gross_weight='';
				$net_weight='';
				$description='';
				$name='';
				$price_unit='';
				$purchase_history_id='';

				if($_GET)
				{
					if(isset($_GET['error'])){
						echo "<div class='alert alert-warning'>". $_GET['error']."</div>";
					}
                    if(isset($_GET['purchaseHistoryId'])){
						$purchase_history_id = $_GET['purchaseHistoryId'];
						$sql = "SELECT p.purchase_id,p.item_name,pc.quantity,p.gross_weight,p.net_weight,p.descrptn,pc.date,v.name,v.vendor_id, 
						pc.price_unit FROM purchase_child pc,purchase p left join vendors v 
						on p.vendor_id=v.vendor_id 
						where p.purchase_id=pc.purchase_id and pc.p_history_id='".$_GET['purchaseHistoryId']."'";
						//echo $sql;exit;
                        $result = mysqli_query($conn, $sql);
                        if (mysqli_num_rows($result) > 0) 
                        {
                            while($row = mysqli_fetch_assoc($result)) 
                            {
                                $item_name = $row["item_name"];
                                $quantity = $row["quantity"];
                                $purchase_id=$row["purchase_id"];
								$gross_weight=$row["gross_weight"];
								$net_weight=$row["net_weight"];
								$descrptn=$row["descrptn"];
								$name=$row["name"];
								$price_unit=$row["price_unit"];
                            }
                        }
					}
				}
                //echo "price ".$price_unit;exit;
		?>
    <div class="container" style="margin:auto">
		  <div class="row shadowedBox col-sm-6" style="margin:auto">
			<div class="col-sm-12">
			<form action="/BillingApplication/navMenu/purchase/editPurchase.php" method="post">
				<div>
				  <label for="name">Item name:</label>
				  <input type="text" class="form-control" value="<?php echo $item_name;?>" required placeholder="Enter name" name="name" id="name">
				</div>
				<div>
				  <label for="quantity">Quantity:</label>
				  <input type="number" min=0 onchange="calculateTotal()" onkeyup="calculateTotal()" onkeydown="calculateTotal()" value="<?php echo $quantity;?>" class="form-control" id="quantity" placeholder="Enter quantity" name="quantity">
				  <input type="hidden" name="prevQuantity" id="prevQuantity" value="<?php echo $quantity;?>">
				</div>
				<?php 
					$sql = "select * from vendors";
					$result = mysqli_query($conn, $sql);
				?>
				<div>
				  <label for="vendor">Vendor:</label>
					<select class="form-control" id="vendor" name="vendor">
						<option value=''></option>
						<?php
							if (mysqli_num_rows($result) > 0) 
							{
								while($row = mysqli_fetch_assoc($result)) 
            					{
									if($name!='')
									{
										if($name==$row["name"])
										{
											echo "<option selected value='".$row["vendor_id"]."'>".$row["name"]."</option>";	
										}
										else
										{
											echo "<option value='".$row["vendor_id"]."'>".$row["name"]."</option>";
										}
									}
									else
									{
										echo "<option value='".$row["vendor_id"]."'>".$row["name"]."</option>";
									}
									
								}
							}
						?>
					</select>				
				</div>
				<?php mysqli_close($conn);?>
				<div>
				  <label for="gweight">Gross weight(grams):</label>
				  <input type="number" step="0.001" min=0 value="<?php echo $gross_weight;?>" class="form-control" id="gweight" placeholder="Enter gross weight" name="gweight">
				</div>
				<div>
				  <label for="netweight">Net weight(grams):</label>
				  <input type="number" step="0.001" min=0 value="<?php echo $net_weight;?>" class="form-control" id="netweight" placeholder="Enter net weight" name="netweight">
				</div>
				<div>
				  <label for="netweight">Price per unit:</label><span id="total">&nbsp;<u><i>(total:<?php echo $price_unit*$quantity;?>)</i></u></span>
				  <input type="number" onkeyup="calculateTotal()"  onkeydown="calculateTotal()" onchange="calculateTotal()" step="0.001" min=0 value="<?php echo $price_unit;?>" class="form-control" id="priceUnit" placeholder="Enter price per unit" name="priceUnit">
				</div>
				<div>
                    <div class="form-group">
                        <label>Descriptioin:</label>
                        <textarea class="form-control" name="desc" id="desc" rows="3"><?php echo $descrptn;?></textarea>
                    </div>
                </div><br>
				<input type="hidden" id="purchaseId" name="purchaseId" value="<?php echo $purchase_id;?>">
                <input type="hidden" id="purchaseHistoryId" name="purchaseHistoryId" value="<?php echo $purchase_history_id;?>">
				<input type="submit" class="btn btn-info" name="submit">
			</form>
			</div>
		  </div>
	</div>
	</div>
	</div>
</main>
