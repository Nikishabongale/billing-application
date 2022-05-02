<?php include($_SERVER['DOCUMENT_ROOT'].'/BillingApplication/common/sideNavBar.php');?>
<?php include($_SERVER['DOCUMENT_ROOT'].'/BillingApplication/db.php');?>
<script src="/BillingApplication/jsFiles/add_edit_estimation.js"></script>
<main class="col ps-md-2 pt-2">
	    <div class="page-header pt-3">
			<h3>
			<div style="float:left">
				<a href="#" data-bs-target="#sidebar" data-bs-toggle="collapse"><button type="button" class="btn btn-dark"><i class='bx bx-menu'></i></button></a>
			</div>	
			Edit estimation</h3>
		</div>
		<hr>
<?php 
if($_GET)
{
    if(isset($_GET['error'])){
        echo "<div class='alert alert-warning'>". $_GET['error']."</div>";
    }
    $estimation_id='';
    $stock_id='';
    $customer_id='';
    $quantity='';
    $amount='';
    $discount='';
    $tax='';
    $total='';
    $item_name='';
    $cname='';
    $per_unit_price='';
    $descpn='';
    if(isset($_GET['estimationId'])){
        $estimation_id=$_GET['estimationId'];
        $sql="select s.descpn,s.estimation_id,c.customer_name as cname,p.item_name as db_item_name,sk.quantity sk_quantity,s.quantity as s_quantity,s.amount,
        s.date,s.discount,s.tax,s.total_no_tax_disc,s.purchase_id,p.gross_weight,p.net_weight
        from estimation s, purchase p, stock sk,customers c
        where c.customer_id=s.customer_id and p.purchase_id=s.purchase_id and sk.stock_id=s.stock_id
        and s.estimation_id='".$estimation_id."'";
        //echo $sql;exit;
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) 
        {
            while($row = mysqli_fetch_assoc($result))
            {
                $quantity=$row["s_quantity"];
                $sk_quantity=$row["sk_quantity"];
                $amount=$row["amount"];
                $discount=$row["discount"];
                $tax=$row["tax"];
                //seperate tax amount ant method
                $discAmount = preg_replace("/[^0-9.]/", "", $discount);
                $discAmount=(float)$discAmount;
                $discUnit = preg_replace("/[^a-zA-Z]+/", "", $discount);
                $taxAmount = preg_replace("/[^0-9.]/", "", $tax);
                $taxAmount=(float)$taxAmount;
                $taxUnit = preg_replace("/[^a-zA-Z]+/", "", $tax);
                //echo $taxUnit;exit;
                $total=$row["total_no_tax_disc"];
                $db_item_name=$row["db_item_name"];
                $cname=$row["cname"];
                $descpn=$row["descpn"];
                $gross_weight=$row["gross_weight"];
                $net_weight=$row["net_weight"];
                $per_unit_price = $total/$quantity;
            }
        }

    }
}
?>
<div class="container mt-2 col-sm-6" style="margin:auto">
		  <div class="row shadowedBox" style="margin:auto">
			<div>
			<form action="/BillingApplication/navMenu/estimation/editEstimation.php" method="post">
                <input type="hidden" value="<?php echo $estimation_id?>" name="estimation_id" id="estimation_id">
				<div class="mb-3">
				  <label for="itemName">Item name:</label>
                    <select name="itemName" id="itemName" class="form-control" onchange="assignWeight(this)">
                        <option value="" selected>select item</option>
                        <?php 
                        $sql = "select item_name,p.purchase_id,gross_weight,net_weight,st.quantity,p.price_unit,st.stock_id
                        from purchase p,stock st
                        where p.purchase_id=st.purchase_id";
                        echo $sql;
                        $result = mysqli_query($conn, $sql);
                        if (mysqli_num_rows($result) > 0) 
                        {
                            while($row = mysqli_fetch_assoc($result)) 
                            {
                                if($db_item_name==$row["item_name"])
                                {
                                    echo "<option selected value='{".'"'.'gweight'.'"'.':'.'"'.$row["gross_weight"].'"'.','.'"'.'net_weight'.'"'.':'.'"'.$row["net_weight"].'"'.
                                        ','.'"'.'purchase_id'.'"'.':'.'"'.$row["purchase_id"].'"'.','.'"'.'quantity'.'"'.':'.'"'.$row["quantity"].'"'.
                                        ','.'"'.'price_unit'.'"'.':'.'"'.$row["price_unit"].'"'.','.'"'.'stock_id'.'"'.':'.'"'.$row["stock_id"].'"'."}'>"
                                        .$row["item_name"]
                                        ."</option>";
                                }
                                else
                                {
                                    echo "<option value='{".'"'.'gweight'.'"'.':'.'"'.$row["gross_weight"].'"'.','.'"'.'net_weight'.'"'.':'.'"'.$row["net_weight"].'"'.
                                        ','.'"'.'purchase_id'.'"'.':'.'"'.$row["purchase_id"].'"'.','.'"'.'quantity'.'"'.':'.'"'.$row["quantity"].'"'.
                                        ','.'"'.'price_unit'.'"'.':'.'"'.$row["price_unit"].'"'.','.'"'.'stock_id'.'"'.':'.'"'.$row["stock_id"].'"'."}'>"
                                        .$row["item_name"]
                                        ."</option>";
                                }
       
                            }
                        }?>
                    </select>
				</div>
                <div class="mb-3">
				  <label for="customerName">Customer name:</label>
                    <select name="customerName" id="customerName" class="form-control">
                        <option value='' selected>select customer</option>
                        <?php 
                            $sql1 = "select customer_id,customer_name from customers";
                            $result1 = mysqli_query($conn, $sql1);
                            if (mysqli_num_rows($result1) > 0) 
                            {
                                while($row = mysqli_fetch_assoc($result1)) 
                                {
                                    if($cname==$row["customer_name"])
                                    {
                                        echo "<option selected value='".$row["customer_id"]."'>".$row["customer_name"]."</option>";
                                    }
                                    else
                                    {
                                        echo "<option value='".$row["customer_id"]."'>".$row["customer_name"]."</option>";
                                    }
                                }
                            }
                        ?>
                    </select>
                    <?php mysqli_close($conn);?>
                </div>
				<div class="mb-3">
				  <label for="quantity">Quantity:</label>
				  <input type="number" min=1 onchange="changePrices()" required class="form-control" id="quantity" value=<?php echo $quantity;?> placeholder="Enter item quantity" name="quantity">
                  <input type="hidden" value="<?php echo $quantity;?>" id="prevSaleQuantity" name="prevSaleQuantity">
                </div>
				<div class="mb-3">
				  <label for="gweight">Gross weight(grams):</label>
				  <input type="text" readonly value="<?php echo $gross_weight;?>" step="0.001" min=0 class="form-control" id="gweight" readonly name="gweight">
				</div>
				<div class="mb-3">
				  <label for="netweight">Net weight(grams):</label>
				  <input type="number" readonly step="0.001" value="<?php echo $net_weight;?>" min=0 class="form-control" id="netweight" readonly name="netweight">
				</div>
				<div class="mb-3">
				  <label for="priceUnit">Price per unit:</label><span><small  id="total">&nbsp;<u><i>total=<?php echo $total;  ?></i></u></small></span>
				  <input type="number" onchange="callTotalEditPage()" value="<?php echo $per_unit_price; ?>" step="0.001" min=0 class="form-control" id="priceUnit" placeholder="Enter price per unit" name="priceUnit">
                  <input type="hidden" name="costOfItems" id="costOfItems" value="<?php echo $total;?>">
                </div>
                <div class="mb-3">
				  <label for="tax">Discount in:
                      <select name="discountMethod" id="discountMethod" required>
                          <option value=''></option>
                          <?php if($discUnit=='rs')
                          {
                            echo "<option selected value='rs'>Rs</option>";
                            echo "<option value='percentage'>%</option>";
                          }
                          else{
                            echo "<option value='rs'>Rs</option>";
                            echo "<option selected value='percentage'>%</option>";
                          }
                          ?>
                      </select>
                      <input type="hidden" name="amountDiscAdded" id="amountDiscAdded">
                  </label>
                  <span><small  id="discountAdded"><i>&nbsp;<u>total=<?php echo (($per_unit_price*$quantity)-$discAmount); ?></u></i></small></span>
				  <input type="number" onchange="calDiscount()" value="<?php echo $discAmount; ?>" step="0.001" min=0 class="form-control" id="discUnit" placeholder="Enter discount" name="discUnit">
				</div>
                <div class="mb-3">
				  <label for="tax">Tax in:
                      <select name="taxMethod" id="taxMethod" required>
                          <option value=''></option>
                          <?php if($taxUnit=='rs')
                          {
                            echo "<option selected value='rs'>Rs</option>";
                            echo "<option value='percentage'>%</option>";
                          }
                          else{
                            echo "<option value='rs'>Rs</option>";
                            echo "<option selected value='percentage'>%</option>";
                          }
                          ?>
                      </select>
                      <input type="hidden" name="finalAmount" id="finalAmount" value="<?php echo $amount; ?>">
                  </label><span><small  id="taxAdded">&nbsp;<i><u>total:<?php echo $amount;?></u></i></small></span>
				  <input type="number" onchange="calTax()" value="<?php echo $taxAmount;?>" step="0.001" min=0 class="form-control" id="taxUnit" placeholder="Enter tax" name="taxUnit">
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