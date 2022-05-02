<?php include($_SERVER['DOCUMENT_ROOT'].'/BillingApplication/db.php');?>
<?php 
	if(isset($_GET['customerId']))
    {
        $customer_id=$_GET['customerId'];
        $sql = "delete from customers where customer_id='".$customer_id."'";
        //echo $sql; exit;
        if (mysqli_query($conn, $sql)) 
        {
            header('Location: /BillingApplication/navMenu/customers/customersPage.php?success=Record deleted!');
            exit;
        }
        else
        {
            header('Location: /BillingApplication/navMenu/customers/customersPage.php?error='.mysqli_error($conn));
            exit;
        }
    }
     mysqli_close($conn);
?>