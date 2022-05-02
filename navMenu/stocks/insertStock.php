<?php include($_SERVER['DOCUMENT_ROOT'].'/BillingApplication/db.php');?>
<?php
if (count($_POST) > 0) 
{
    $purchase_id=$_POST["purchase_id"];
    $priceUnit=$_POST["priceUnit"];
    $quantity=$_POST["quantity"];
    
    $sql = "INSERT INTO purchase_child
    (purchase_id, date, price_unit, quantity) VALUES 
    ('".$purchase_id."',now(),'".$priceUnit."','".$quantity."')";

    $updateStock = "update stock set quantity=quantity+".$quantity." where purchase_id=".$purchase_id;
    if (mysqli_query($conn, $sql)) 
	{
        if(mysqli_query($conn, $updateStock))
        {
            mysqli_close($conn);
            header('Location: /BillingApplication/navMenu/stocks/stocksPage.php?success=Stock inserted!');
        }
        else
        {
            header('Location: /BillingApplication/navMenu/stocks/insertStockPage.php?purchaseId='.$purchaseId.'&error='.mysqli_error($conn));
            exit;//echo "Error updating record: " . mysqli_error($conn);
        }
    }
    else 
    {
        header('Location: /BillingApplication/navMenu/stocks/insertStockPage.php?purchaseId='.$purchaseId.'&error='.mysqli_error($conn));
        exit;//echo "Error updating record: " . mysqli_error($conn);
    }
}
?>