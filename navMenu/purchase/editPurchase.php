<?php include($_SERVER['DOCUMENT_ROOT'].'/BillingApplication/db.php');?>
<?php 
	if (count($_POST) > 0) 
	{
		$name = $_POST["name"];
        $quantity = $_POST["quantity"];
        $purchaseId = $_POST["purchaseId"];
        $gweight = $_POST["gweight"];
        $netweight = $_POST["netweight"];
        $desc = $_POST["desc"];
        $desc=str_replace('"',"'",$desc);
        $vendor = $_POST["vendor"];
        $price_unit=$_POST["priceUnit"];
        $prevQuantity=$_POST["prevQuantity"];
        $purchaseHistoryId=$_POST["purchaseHistoryId"];
        $stockQuantity='';

        if($vendor=='')
        {
            $vendor_string = ",vendor_id=NULL";
        }
        else
        {
            $vendor_string = ",vendor_id='".$vendor."'";
        }

        //update in purchase child table
        $updateChildPurchase = "update purchase_child set quantity='".$quantity."',price_unit='".$price_unit."',date=now()
        where p_history_id=".$purchaseHistoryId;
        $updatePurchase="UPDATE purchase SET item_name='".$name."',gross_weight='".$gweight."',net_weight='".$netweight."',descrptn=".'"'.$desc.'"'."$vendor_string 
        WHERE purchase_id='".$purchaseId."'";
        //update quanitity in child table if it's changed
        if($prevQuantity!=$quantity)
        {
            //if greater stock quantity gets added, lesser removed
            if($prevQuantity<$quantity)
            {
                $diff = $quantity-$prevQuantity;
                $updateStock = "update stock set quantity=quantity+".$diff."
                where stock_id=";
                //update purchase,purchase child and stock
                if ((mysqli_query($conn, $updateChildPurchase))&&(mysqli_query($conn, $updatePurchase))&&(mysqli_query($conn, $updateStock)))
                {
                    mysqli_close($conn);
                    header('Location: /BillingApplication/navMenu/purchase/purchasePage.php?success=Record Updated!');
                }
                else
                {
                    header('Location: /BillingApplication/navMenu/purchase/purchasePage.php?purchaseId='.$purchaseId.'&error='.mysqli_error($conn));
                }
            }
            else if($prevQuantity>$quantity)
            {
                $diff = $prevQuantity-$quantity;
                $stockQuantityQ="select quantity from stock where purchase_id='".$purchaseId."'";
                $purchaseQuantityQ="select sum(quantity) as quantity from purchase_child where purchase_id='".$purchaseId."'
                group by purchase_id";
                $result = mysqli_query($conn, $stockQuantityQ);
                if (mysqli_num_rows($result) > 0) 
                {
                    while($row = mysqli_fetch_assoc($result)) 
                    {
                        $stockQuantity=$row["quantity"];
                    }
                }
                $result = mysqli_query($conn, $purchaseQuantityQ);
                if (mysqli_num_rows($result) > 0) 
                {
                    while($row = mysqli_fetch_assoc($result)) 
                    {
                        $purchaseQuantity=$row["quantity"];
                    }
                }
                //sale quantity equals to purchase quantity-stock quanity
                $salesQuantity=$purchaseQuantity-$stockQuantity;
                $finalQuantity=($purchaseQuantity-$diff)-$salesQuantity;
                if($finalQuantity<0)
                {
                    mysqli_close($conn);
                    header('Location: /BillingApplication/navMenu/purchase/purchasePage.php?error=You have already sold this item! Check sales page');
                    exit;
                }
                else
                {
                    $updateStock = "update stock set quantity=quantity-".$diff."
                    where stock_id=".$purchaseId;
                    if ((mysqli_query($conn, $updateChildPurchase))&&(mysqli_query($conn, $updatePurchase))&&(mysqli_query($conn, $updateStock)))
                    {
                        mysqli_close($conn);
                        header('Location: /BillingApplication/navMenu/purchase/purchasePage.php?success=Record Updated!');
                    }
                    else
                    {
                        header('Location: /BillingApplication/navMenu/purchase/purchasePage.php?purchaseId='.$purchaseId.'&error='.mysqli_error($conn));
                    }
                }
            }
        }
        else
        {
            if ((mysqli_query($conn, $updateChildPurchase))&&(mysqli_query($conn, $updatePurchase)))
            {
                mysqli_close($conn);
                header('Location: /BillingApplication/navMenu/purchase/purchasePage.php?success=Record Updated!');
            }
            else
            {
                header('Location: /BillingApplication/navMenu/purchase/purchasePage.php?purchaseId='.$purchaseId.'&error='.mysqli_error($conn));
            }
        }
    }
?>