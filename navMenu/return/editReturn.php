<?php include($_SERVER['DOCUMENT_ROOT'].'/BillingApplication/db.php');?>
<?php
if($_POST>0)
{
    $return_id=$_POST["returnId"];
    $quantity=$_POST["quantity"];
    $return_amount=$_POST["return_amount"];
    $desc=$_POST["desc"];
    $previousQuantity=$_POST["previousQuantity"];
    $stock_id=$_POST["stock_id"];
    //validate quantity
    $returnQuantity="select sum(return_quantity)-".$previousQuantity"+".$quantity." from returns 
    where customer_id=(select customer_id from returns where return_id=".$return_id.")";
    $saleQuantity="select sum(quantity) from sales 
    where customer_id=(select customer_id from returns where return_id=".$return_id.");";

    if($returnQuantity<=$saleQuantity)
    {
        //update stock
        if($previousQuantity>$quantity)
        {
            $updateStockQuantity = "update stock set quantity=quantity-".$quantity." where stock_id=".$stock_id;
        }
        else if($previousQuantity<$quantity)
        {
            $updateStockQuantity = "update stock set quantity=quantity+".$quantity." where stock_id=".$stock_id;
        }
    }
    else
    {

    }
    mysqli_close($conn);
}
?>