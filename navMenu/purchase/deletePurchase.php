<?php include($_SERVER['DOCUMENT_ROOT'].'/BillingApplication/db.php');?>
<?php 
	if(isset($_GET['purchaseHistoryId']))
    {
        $purchaseHistoryId=$_GET['purchaseHistoryId'];
        $quantity=$_GET['quantity'];
        $purchaseQuantity='';
        $salesQuantity='';
        $stockQuantity='';
        //delete from purchase child
        $deletePurchaseChild = "DELETE FROM purchase_child WHERE p_history_id='".$purchaseHistoryId."'";
        //check for sold quantity
        $purchaseIdQ = "select purchase_id from purchase_child where p_history_id='".$purchaseHistoryId."'";
        $result = mysqli_query($conn, $purchaseIdQ);
        if (mysqli_num_rows($result) > 0) 
        {
            while($row = mysqli_fetch_assoc($result)) 
            {
                $purchaseId=$row["purchase_id"];
            }
        
        }
        //echo "got purchase id".$purchaseId."<br>";
        //check sales quantity
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
        
        if(($purchaseQuantity-$salesQuantity-$quantity)>=0)
        {
            //echo "inside if condition <br>";
            $updateStock = "update stock set quantity=quantity-".$quantity." where purchase_id='".$purchaseId."'";
            if ((mysqli_query($conn, $deletePurchaseChild))&&(mysqli_query($conn, $updateStock))) 
            {
                //check if to delete from purchase table
                $purchaseData = "select purchase_id from purchase_child where purchase_id='".$purchaseId."'";
                $result = mysqli_query($conn, $purchaseData);
                if (mysqli_num_rows($result)==0)
                {
                    $deletePurchase="delete from purchase where purchase_id='".$purchaseId."'";
                    if(mysqli_query($conn, $deletePurchase))
                    {
                        mysqli_close($conn);
                        header('Location: /BillingApplication/navMenu/purchase/purchasePage.php?success=Record deleted!');
                        exit;
                    }
                    else
                    {
                        header('Location: /BillingApplication/navMenu/purchase/purchasePage.php?error='.mysqli_error($conn));
                        exit;
                    }
                }
                else
                {
                    mysqli_close($conn);
                    header('Location: /BillingApplication/navMenu/purchase/purchasePage.php?success=Record deleted!');
                    exit;
                }
            }
            else
            {
                header('Location: /BillingApplication/navMenu/purchase/purchasePage.php?error='.mysqli_error($conn));
                exit;
            }
        }
        else
        {
            mysqli_close($conn);
            header('Location: /BillingApplication/navMenu/purchase/purchasePage.php?error=You have already sold this item! Check sales page');
            exit;
        }
        
    }
     
?>