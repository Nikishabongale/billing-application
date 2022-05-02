<?php include($_SERVER['DOCUMENT_ROOT'].'/BillingApplication/db.php');?>
<?php 
	if (count($_POST) > 0) 
	{
		$name = $_POST["name"];
        $phoneNumber = $_POST["phoneNumber"];
        $emailId = $_POST["emailId"];
        $address = $_POST["address"];
        $customer_id = $_POST["customer_id"];
        
        $sql = "UPDATE customers SET customer_name='".$name."',phone_number='".$phoneNumber."',email_id='".$emailId."',address='".$address."' WHERE customer_id='".$customer_id."'";
        if (mysqli_query($conn, $sql)) 
        {
            header('Location: /BillingApplication/navMenu/customers/customersPage.php?success=Record Updated!');
            //echo "Record updated successfully";
        }
        else 
        {
            header('Location: /BillingApplication/navMenu/customers/editCustomersPage.php?customerId='.$customer_id.'&error='.mysqli_error($conn));
            //echo "Error updating record: " . mysqli_error($conn);
        }
    }
    mysqli_close($conn);
?>