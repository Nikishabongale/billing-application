<?php include($_SERVER['DOCUMENT_ROOT'].'/BillingApplication/db.php');?>
<?php 
	if(isset($_GET['estimationId']))
    {
        //echo $_GET['salesId'];exit;
        $estimation_id=$_GET['estimationId'];
        $quantity=$_GET['quantity'];
       //echo $addToStock;exit; 

        $deleteEstimation = "DELETE FROM estimation WHERE estimation_id=".$estimation_id;
        if (mysqli_query($conn, $deleteEstimation)) 
        {
            mysqli_close($conn);
            header('Location: /BillingApplication/navMenu/estimation/estimationPage.php?success=Record deleted!');
            exit;
        }
        else
        {
            header('Location: /BillingApplication/navMenu/estimation/estimationPage.php?error='.mysqli_error($conn));
            exit;
        }

    }
?>