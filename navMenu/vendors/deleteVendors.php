<?php include($_SERVER['DOCUMENT_ROOT'].'/BillingApplication/db.php');?>
<?php 
	if(isset($_GET['vendorId']))
    {
        $vendor_id=$_GET['vendorId'];
        $sql = "delete from vendors where vendor_id='".$vendor_id."'";
        //echo $sql; exit;
        if (mysqli_query($conn, $sql)) 
        {
            header('Location: /BillingApplication/navMenu/vendors/vendorsPage.php?success=Record deleted!');
            exit;
        }
        else
        {
            header('Location: /BillingApplication/navMenu/vendors/vendorsPage.php?error='.mysqli_error($conn));
            exit;
        }
    }
     mysqli_close($conn);
?>