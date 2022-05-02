<?php include($_SERVER['DOCUMENT_ROOT'].'/BillingApplication/common/sideNavBar.php');?>
<?php include($_SERVER['DOCUMENT_ROOT'].'/BillingApplication/db.php');?>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
<script src="/BillingApplication/jsFiles/return_item.js"></script>

<main class="col ps-md-2 pt-2">
	    <div class="page-header pt-3">
			<h3>
			<div style="float:left">
				<a href="#" data-bs-target="#sidebar" data-bs-toggle="collapse"><button type="button" class="btn btn-dark"><i class='bx bx-menu'></i></button></a>
			</div>	
			Edit return</h3>
		</div>
		<hr>
		<?php
		$return_id='';
		if($_GET)
		{
			if(isset($_GET['error']))
			{
				echo "<div class='alert alert-warning'>". $_GET['error']."</div>";
			}
			//return id
			$customer_id='';
			$purchase_id='';
			$quantity='';
			$return_amount='';
			$descpn='';
			$item_name='';
			$stock_id='';
			if($_GET['returnId'])
			{
				$return_id=$_GET['returnId'];
				$return_data="select s.stock_id,c.customer_name,r.customer_id,r.purchase_id,r.return_quantity as quantity,r.return_amount,r.descpn,p.item_name
				from returns r,customers c, purchase p,sales s 
				where return_id=".$return_id." and c.customer_id=r.customer_id and p.purchase_id=r.purchase_id
				and s.sales_id=r.sales_id";
				//echo $return_data;
				$result1 = mysqli_query($conn, $return_data);
				if (mysqli_num_rows($result1) > 0) 
                {
					while($row = mysqli_fetch_assoc($result1))
					{
						$customer_name=$row["customer_name"];
						$customer_id=$row["customer_id"];
						$purchase_id=$row["purchase_id"];
						$quantity=$row["quantity"];
						$return_amount=$row["return_amount"];
						$descpn=$row["descpn"];
						$item_name=$row["item_name"];
						$stock_id=$row["stock_id"];
					}
				}
			}
		}
		?>
		<?php mysqli_close($conn);?>
    <div class="container mt-2 col-sm-6" style="margin:auto">
		  <div class="row shadowedBox" style="margin:auto">
			<div>
			<form action="/BillingApplication/navMenu/return/editReturn.php" method="post">
            	<div class="mb-3">
				  <label for="customerName">Customer name:</label>
                   <input class="form-control" type="text" readonly value="<?php echo $customer_name;?>" name="customerName" id="customerName">
                </div>
				<div class="mb-3">
				  <label for="itemName">Item name:</label>
				  <input class="form-control" type="text" readonly value="<?php echo $item_name;?>" name="itemName" id="itemName">
				</div>
				<input type="hidden" name="return_id" id="return_id" value="<?php echo $return_id?>">
				<div class="mb-3">
				  <label for="quantity">Quantity:</label>
				  <input type="number" value="<?php echo $quantity;?>" min=1 required class="form-control" id="quantity" placeholder="Enter item quantity" name="quantity">
				  <input type="hidden" value="<?php echo $quantity;?>" name="previousQuantity" id="previousQuantity">
				  <input type="hidden" value="<?php echo $stock_id;?>" name="stock_id" id="stock_id"> 
				</div>
				<div class="mb-3">
				  <label for="quantity">Return amount:</label>
				  <input type="number" value="<?php echo $return_amount;?>" min=1 required class="form-control" id="return_amount" placeholder="Enter return amount" name="return_amount">
                </div>
				<div class="col-lg-12">
                    <div class="form-group">
                        <label>Descriptioin:</label>
                        <textarea class="form-control" name="desc" id="desc" rows="3"><?php echo $descpn;?></textarea>
                    </div>
                </div><br>
				<input type="submit" class="btn btn-info" name="submit">
			</form>
			</div>
		  </div>
	</div>
</main>
</body>
</html>