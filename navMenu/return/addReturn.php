<?php include($_SERVER['DOCUMENT_ROOT'].'/BillingApplication/db.php');?>
<?php
if($_POST>0)
{
    $customerId=$_POST["customerName"];
    $purchase_id=$_POST["itemName"];
    $sales_id=$_POST["sales_id"];
    $stock_id=$_POST["stock_id"];
    $return_quantity=$_POST["quantity"];
    $return_amount=$_POST["return_amount"];
    $description=$_POST["desc"];
    //replace double quote by single quote in description
    $description = str_replace('"',"'",$description);

    $insertReturn="INSERT INTO returns
    (customer_id, return_quantity, return_amount, sales_id, purchase_id, descpn, return_date) 
    VALUES ('".$customerId."','".$return_quantity."','".$return_amount."','".$sales_id."','".$purchase_id."',".'"'.$description.'"'.",now())";
    //echo $insertReturn;exit;
    if (mysqli_query($conn, $insertReturn)) 
    {
        $stockQuantity = "update stock set quantity=(quantity+".$return_quantity.") where stock_id='".$stock_id."'";
        if (mysqli_query($conn, $stockQuantity)) 
        {
            mysqli_close($conn);
            header('Location: /BillingApplication/navMenu/return/returnPage.php?success=New record added!');
            exit;
        }
    }
    else
    {
        header('Location: /BillingApplication/navMenu/return/returnPage.php?error='.mysqli_error($conn).'!');
        exit;
    }
}
?>