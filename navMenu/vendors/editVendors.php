<?php include($_SERVER['DOCUMENT_ROOT'].'/BillingApplication/db.php');?>
<?php 
	if (count($_POST) > 0) 
	{
		$name = $_POST["name"];
        $phoneNumber = $_POST["phoneNumber"];
        $emailId = $_POST["emailId"];
        $address = $_POST["address"];
        $vendor_id = $_POST["vendor_id"];
        
        $sql = "UPDATE vendors SET name='".$name."',phone_number='".$phoneNumber."',email_id='".$emailId."',address='".$address."' WHERE vendor_id='".$vendor_id."'";
        if (mysqli_query($conn, $sql)) 
        {
            header('Location: /BillingApplication/navMenu/vendors/vendorsPage.php?success=Record Updated!');
            //echo "Record updated successfully";
        }
        else 
        {
            header('Location: /BillingApplication/navMenu/vendors/editVendorsPage.php?vendorId='.$vendor_id.'&error='.mysqli_error($conn));
            //echo "Error updating record: " . mysqli_error($conn);
        }
    }
    mysqli_close($conn);
?>