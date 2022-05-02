<?php include($_SERVER['DOCUMENT_ROOT'].'/BillingApplication/db.php');?>
<?php
//echo 'test';
if(isset($_GET['returnId']))
{
    $return_id = $_GET["returnId"];
    $quantity = $_GET["quantity"];
    $stock_id=$_GET["stock_id"];
    //echo ' '.$return_id;
    $updateStockQuantity = "update stock set quantity=quantity-".$quantity." where stock_id=".$stock_id;

    //stock
    if (mysqli_query($conn, $updateStockQuantity)) 
    {
        //echo $updateStockQuantity;
        $deleteReturn="DELETE FROM returns WHERE return_id=".$return_id;
        //echo $deleteReturn;exit;
        if (mysqli_query($conn, $deleteReturn)) 
        {
            mysqli_close($conn);
            header('Location: /BillingApplication/navMenu/return/returnPage.php?success=Record deleted!');
            exit;            
        }
        else
        {
            header('Location: /BillingApplication/navMenu/return/returnPage.php?error='.mysqli_error($conn));
            exit;
        }
    }else
    {
        header('Location: /BillingApplication/navMenu/return/returnPage.php?error='.mysqli_error($conn));
        exit;
    }
}
?>