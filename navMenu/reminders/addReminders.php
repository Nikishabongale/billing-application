<?php include($_SERVER['DOCUMENT_ROOT'].'/BillingApplication/db.php');?>
<?php 
	if (count($_POST) > 0) 
	{
		$message = $_POST["msg"];
        	$reminder_date = $_POST["date"];

        //echo $name.' '.$phoneNumber.' '.$emailId.' <p style="white-space: pre-wrap;">'.$address.'</pre>';
        $sql = "INSERT INTO reminders(reminder_msg, date) VALUES ('".$message."','".$reminder_date."')";
        if (mysqli_query($conn, $sql)) 
        {
            //echo "New record created successfully";
            header('Location: /BillingApplication/navMenu/reminders/remindersPage.php?success=New record added!');
			exit;
        }
        else 
        {
            //echo $sql;
            header('Location: /BillingApplication/navMenu/reminders/remindersPage.php?error='.mysqli_error($conn).'!');
            exit;        
        }
    }

    mysqli_close($conn);
?>
