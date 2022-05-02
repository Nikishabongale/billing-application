<?php include($_SERVER['DOCUMENT_ROOT'].'/BillingApplication/common/sideNavBar.php');?>
<?php include($_SERVER['DOCUMENT_ROOT'].'/BillingApplication/db.php');?>
<script src="/BillingApplication/jsFiles/add_edit_sales.js"></script>
<script>
	document.getElementById("sale").classList.add("active");
</script>
<main>
<div class="content">
<?php 
if($_GET)
{
    if(isset($_GET['error'])){
        echo "<div class='alert alert-warning'>". $_GET['error']."</div>";
    }
    $sales_id='';
    $stock_id='';
    $customer_id='';
    $quantity='';
    $amount='';
    $balance_due='';
    $discount='';
    $tax='';
    $total='';
    $item_name='';
    $cname='';
    $per_unit_price='';
    $received='';
    $descpn='';
    $gross_weight='';
    $net_weight='';
    if(isset($_GET['salesId'])){
        $sales_id=$_GET['salesId'];
		
		$sql = "select s.sales_id,c.customer_name as cname,p.item_name as db_item_name,sk.quantity sk_quantity,s.quantity as s_quantity,s.price_per_unit,
		s.balance_due, s.date,s.purchase_id,p.gross_weight,p.net_weight from sales s, purchase p, stock sk,customers c where c.customer_id=s.customer_id 
		and p.purchase_id=s.purchase_id and sk.stock_id=s.stock_id and s.sales_id='".$sales_id."'";
        
        //echo $sql;
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) 
        {
            while($row = mysqli_fetch_assoc($result))
            {
				$sales_id=$row["sales_id"];
				$customer_name=$row["cname"];
				$db_item_name=$row["db_item_name"];
                $sk_quantity=$row["sk_quantity"];
				$quantity=$row["s_quantity"];
				$price_per_unit=$row["price_per_unit"];
                $balance_due=$row["balance_due"];
                $date=$row["date"];
                $purchase_id=$row["purchase_id"];
                $gross_weight=$row["gross_weight"];
                $net_weight=$row["net_weight"];
				$total = $price_per_unit;
            }
        }

    }
}
?>
<div class="container row" style="margin:auto">
		  <div class="row shadowedBox col-sm-6" style="margin:auto">
			<div class="col-sm-12">
			<form action="/BillingApplication/navMenu/sales/editSales.php" method="post">
                <input type="hidden" value="<?php echo $sales_id?>" name="sales_id" id="sales_id">
				<div>
				  <label for="itemName">Item name:</label>
                    <select name="itemName" id="itemName" class="form-control" onchange="assignWeight(this)">
                        <option value="" selected>select item</option>
                        <?php 
                        $sql = "select item_name,p.purchase_id,gross_weight,net_weight,st.quantity,st.stock_id,pc.price_unit from purchase p,stock 
						st,purchase_child pc where p.purchase_id=st.purchase_id and pc.purchase_id=p.purchase_id group by item_name";
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
                <div>
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
                                    if($customer_name==$row["customer_name"])
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
				<div>
				  <label for="quantity">Quantity:</label>
				  <input type="number" min=1 onkeyup="validateQuantityEditPage()" onkeydown="validateQuantityEditPage()" onchange="validateQuantityEditPage()"  required class="form-control" id="quantity" value=<?php echo $quantity;?> placeholder="Enter item quantity" name="quantity">
                  <input type="hidden" value="<?php echo $quantity;?>" id="prevSaleQuantity" name="prevSaleQuantity">
                </div>
				<div>
				  <label for="gweight">Gross weight(grams):</label>
				  <input type="text" readonly value="<?php echo $gross_weight;?>" step="0.001" min=0 class="form-control" id="gweight" readonly name="gweight">
				</div>
				<div>
				  <label for="netweight">Net weight(grams):</label>
				  <input type="number" readonly value="<?php echo $net_weight;?>" step="0.001" min=0 class="form-control" id="netweight" readonly name="netweight">
				</div>
				<div>
				  <label for="priceUnit">Price per unit:</label><span><small  id="total">&nbsp;<u><i>total=<?php echo $total;  ?></i></u></small></span>
				  <input type="number" value="<?php echo $price_per_unit; ?>" step="0.001" min=0 class="form-control" id="priceUnit" placeholder="Enter price per unit" name="priceUnit">
                  <input type="hidden" name="amount" id="amount" value="<?php echo $total;?>">
                </div>
				<div>
				  <label for="priceUnit">Received:</label><span><small  id="total">&nbsp;<u><i>total=<?php echo $total;  ?></i></u></small></span>
				  <input type="number" value="<?php echo $price_per_unit*$quantity-$balance_due; ?>" step="0.001" min=1 class="form-control" id="receivedAmount" placeholder="Enter received amount" name="receivedAmount">
                </div>
                <input type="hidden" name="remainingAmount" id="remainingAmount" value='<?php echo $balance_due; ?>'><br>
				<input type="submit" class="btn btn-info" name="submit">
			</form>
			</div>
		  </div>
	</div>
</div>
</main>