<?php include($_SERVER['DOCUMENT_ROOT'].'/BillingApplication/db.php');?>
<?php 
	if(isset($_GET['reminderId']))
    {
        $reminder_id=$_GET['reminderId'];
        $sql = "delete from reminders where reminder_id='".$reminder_id."'";
        //echo $sql; exit;
        if (mysqli_query($conn, $sql)) 
        {
            header('Location: /BillingApplication/navMenu/reminders/remindersPage.php?success=Record deleted!');
            exit;
        }
        else
        {
            header('Location: /BillingApplication/navMenu/reminders/remindersPage.php?error='.mysqli_error($conn));
            exit;
        }
    }
     mysqli_close($conn);
?>
