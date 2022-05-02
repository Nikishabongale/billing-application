<?php include($_SERVER['DOCUMENT_ROOT'].'/BillingApplication/db.php');?>
<?php
if (count($_POST) > 0) 
{
    $sales_id = $_POST["sales_id"];
    $itemName = $_POST["itemName"];
    $obj = json_decode($itemName);
    $stock_id=$obj->stock_id;
    $purchase_id=$obj->purchase_id;
    $customer_id = $_POST["customerName"];
    $quantity = $_POST["quantity"];
    $gweight = $_POST["gweight"];
    $netweight = $_POST["netweight"];
    $priceUnit = $_POST["priceUnit"];

    $amount=$_POST["amount"];
    $receivedAmount=$_POST["receivedAmount"];
    $remainingAmount=$_POST["remainingAmount"];
    $updateStock='';
    $prevSaleQuantity=$_POST["prevSaleQuantity"];
    //echo $prevSaleQuantity.' '.$quantity;exit;
    if($prevSaleQuantity>$quantity)
    {
        $stockUpdateQuantity=$prevSaleQuantity-$quantity;
        $updateStock="update stock set quantity=(quantity+".$stockUpdateQuantity.")";
    }
    else if($prevSaleQuantity<$quantity)
    {
        $stockUpdateQuantity=$quantity-$prevSaleQuantity;
        $updateStock="update stock set quantity=(quantity-".$stockUpdateQuantity.")";
    }
	
	$sql = "UPDATE sales SET stock_id='".$stock_id."',customer_id='".$customer_id."',quantity='".$quantity."',final_amount='".$amount."' ,balance_due='".$remainingAmount."',
	purchase_id='".$purchase_id."',price_per_unit='".$priceUnit."' WHERE sales_id='".$sales_id."'";
    
    if (mysqli_query($conn, $sql)) 
    {
        if($updateStock!='')
        {
            if (mysqli_query($conn, $updateStock)) 
            {
                mysqli_close($conn);
                header('Location: /BillingApplication/navMenu/sales/salesPage.php?success=Record Updated!');
            }
        }
        else
        {
            mysqli_close($conn);
            header('Location: /BillingApplication/navMenu/sales/salesPage.php?success=Record Updated!');
        }
        
    }
    else 
    {
        header('Location: /BillingApplication/navMenu/sales/salesPage.php?salesId='.$sales_id.'&error='.mysqli_error($conn));
        //echo "Error updating record: " . mysqli_error($conn);
    }
}
?>