<?php include($_SERVER['DOCUMENT_ROOT'].'/BillingApplication/common/sideNavBar.php');?>
<?php include($_SERVER['DOCUMENT_ROOT'].'/BillingApplication/db.php');?>
<script src="/BillingApplication/jsFiles/add_edit_estimation.js"></script>
<script>
function checkQuantityAddPage()
{
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
<main class="col ps-md-2 pt-2">
	    <div class="page-header pt-3">
			<h3>
			<div style="float:left">
				<a href="#" data-bs-target="#sidebar" data-bs-toggle="collapse"><button type="button" class="btn btn-dark"><i class='bx bx-menu'></i></button></a>
			</div>	
			Add estimation</h3>
		</div>
		<hr>
		<?php
				if($_GET)
				{
					if(isset($_GET['error'])){
						echo "<div class='alert alert-warning'>". $_GET['error']."</div>";
					}
				}
		?>
    <div class="container mt-2 col-sm-6" style="margin:auto">
		  <div class="row shadowedBox" style="margin:auto">
			<div>
			<form action="/BillingApplication/navMenu/estimation/addEstimation.php" method="post">
				<div class="mb-3">
				  <label for="itemName">Item name:</label>
                    <select name="itemName" id="itemName" class="form-control" onchange="assignWeight(this)">
                        <option value="" selected>select item</option>
                        <?php 
                        $sql = "select item_name,pc.purchase_id,gross_weight,net_weight,st.quantity,st.stock_id,pc.price_unit
			from purchase p,stock st,purchase_child pc
			where p.purchase_id=st.purchase_id and pc.purchase_id=p.purchase_id;";
                        $result = mysqli_query($conn, $sql);
                        if (mysqli_num_rows($result) > 0) 
                                {
                                    while($row = mysqli_fetch_assoc($result)) 
                                    {
                                        echo "<option value='{".'"'.'gweight'.'"'.':'.'"'.$row["gross_weight"].'"'.','.'"'.'net_weight'.'"'.':'.'"'.$row["net_weight"].'"'.
                                            ','.'"'.'purchase_id'.'"'.':'.'"'.$row["purchase_id"].'"'.','.'"'.'quantity'.'"'.':'.'"'.$row["quantity"].'"'.','.
                                            '"'.'price_unit'.'"'.':'.'"'.$row["price_unit"].'"'.','.'"'.'stock_id'.'"'.':'.'"'.$row["stock_id"].'"'."}'>"
                                            .$row["item_name"]
                                            ."</option>";
                                    }
                                }?>
                    </select>
				</div>
                <div class="mb-3">
				  <label for="customerName">Customer name:</label>
                    <select required name="customerName" id="customerName" class="form-control">
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
                    <?php mysqli_close($conn);?>
                </div>
				<div class="mb-3">
				  <label for="quantity">Quantity:</label>
				  <input type="number" min=1 required class="form-control" id="quantity" placeholder="Enter item quantity" name="quantity">
                    <input type="hidden" name="actual_quantity" id="actual_quantity">
                </div>
				<div class="mb-3">
				  <label for="gweight">Gross weight(grams):</label>
				  <input type="text" readonly step="0.001" min=0 class="form-control" id="gweight" placeholder="Enter gross weight" name="gweight">
				</div>
				<div class="mb-3">
				  <label for="netweight">Net weight(grams):</label>
				  <input type="number" readonly step="0.001" min=0 class="form-control" id="netweight" placeholder="Enter net weight" name="netweight">
				</div>
				<div class="mb-3">
				  <label for="priceUnit">Price per unit:</label><span><small  id="total"></small></span>
				  <input type="number" required onchange="calTotal()" step="0.001" min=0 class="form-control" id="priceUnit" placeholder="Enter price per unit" name="priceUnit">
                  <input type="hidden" name='costOfItems' id='costOfItems'>
                </div>
       <!--         <div class="mb-3">
		<label for="tax">Discount in:
                      <select name="discountMethod" id="discountMethod" required>
                          <option value=''></option>
                          <option value='rs'>Rs</option>
                          <option value='percentage'>%</option>
                      </select>
                      <input type="hidden" name="amountDiscAdded" id="amountDiscAdded">
                  </label><span><small  id="discountAdded"></small></span>
				  <input type="number" onchange="calDiscount()" step="0.001" min=0 class="form-control" id="discUnit" placeholder="Enter discount" name="discUnit">
				</div>
                <div class="mb-3">
				  <label for="tax">Tax in:
                      <select name="taxMethod" id="taxMethod" required>
                          <option value=''></option>
                          <option value='rs'>Rs</option>
                          <option value='percentage'>%</option>
                      </select>
                  </label><span><small  id="taxAdded"></small></span>
				  <input type="number" onchange="calTax()" step="0.001" min=0 class="form-control" id="taxUnit" placeholder="Enter tax" name="taxUnit">
                  <input type="hidden" name="finalAmount" id="finalAmount">
                </div>
				<div class="col-lg-12">
                    <div class="form-group">
                        <label>Descriptioin:</label>
                        <textarea class="form-control" name="desc" id="desc" rows="3"></textarea>
                    </div>
                </div> -->
                <br>
				<input type="submit" class="btn btn-info" name="submit">
			</form>
			</div>
		  </div>
	</div>
</main>
