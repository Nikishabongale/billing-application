<?php include($_SERVER['DOCUMENT_ROOT'].'/BillingApplication/db.php');?>
<?php 
	if(isset($_GET['saleId']))
    {
        //echo $_GET['salesId'];exit;
        $sale_id=$_GET['saleId'];
        $quantity=$_GET['quantity'];
        //add to stock
       $addToStock = "update stock set quantity=quantity+".$quantity." where purchase_id=
       (select purchase_id from sales where sales_id=".$sale_id.")";
       //echo $addToStock;exit; 
       if (mysqli_query($conn, $addToStock)) 
       {
            $deleteSale = "DELETE FROM sales WHERE sales_id=".$sale_id;
            if (mysqli_query($conn, $deleteSale)) 
            {
                mysqli_close($conn);
                header('Location: /BillingApplication/navMenu/sales/salesPage.php?success=Record deleted!');
                exit;
            }
            else
            {
                header('Location: /BillingApplication/navMenu/sales/salesPage.php?error='.mysqli_error($conn));
                exit;
            }
        }
        else
        {
            header('Location: /BillingApplication/navMenu/sales/salesPage.php?error='.mysqli_error($conn));
            exit;
        }
    }
?>