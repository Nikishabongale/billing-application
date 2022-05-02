<?php include($_SERVER['DOCUMENT_ROOT'].'/BillingApplication/db.php');?>
<?php 
	if (count($_POST) > 0) 
	{
		$name = $_POST["name"];
        $phoneNumber = $_POST["phoneNumber"];
        $emailId = $_POST["emailId"];
        $address = $_POST["address"];

        //echo $name.' '.$phoneNumber.' '.$emailId.' <p style="white-space: pre-wrap;">'.$address.'</pre>';
        $sql = "INSERT INTO vendors( name, phone_number, email_id, address) VALUES ('".$name."','".$phoneNumber."','".$emailId."','".$address."')";
        if (mysqli_query($conn, $sql)) 
        {
            //echo "New record created successfully";
            header('Location: /BillingApplication/navMenu/vendors/vendorsPage.php?success=New record added!');
			exit;
        }
        else 
        {
            //echo $sql;
            header('Location: /BillingApplication/navMenu/vendors/addVendorsPage.php?error='.mysqli_error($conn).'!');
            exit;        
        }
    }

    mysqli_close($conn);
?>