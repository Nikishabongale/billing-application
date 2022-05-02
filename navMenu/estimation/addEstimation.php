<?php include($_SERVER['DOCUMENT_ROOT'].'/BillingApplication/db.php');?>
<?php 
	if (count($_POST) > 0) 
	{
	$itemName = $_POST["itemName"];
	echo $itemName->stock_id;
	//echo $itemName;
        //$obj = json_decode($itemName);
        $stock_id=$obj->stock_id;
        $purchase_id=$obj->purchase_id;
        echo $obj->item_name;
	
        $customer_id = $_POST["customerName"];
        $quantity = $_POST["quantity"];
        $gweight = $_POST["gweight"];
        $netweight = $_POST["netweight"];
        $priceUnit = $_POST["priceUnit"];
        $amount=$priceUnit*quantity;
        
        $sql="INSERT INTO estimation
        (stock_id, customer_id, quantity, date, amount,purchase_id,price_per_unit) 
        VALUES ('".$stock_id."','".$customer_id."','".$quantity."',now(),'".$amount."',
        '".$purchase_id."','".$costOfItems."','".$priceUnit."')";

        echo $sql;exit;
        
        if (mysqli_query($conn, $sql)) 
        {

            mysqli_close($conn);
            header('Location: /BillingApplication/navMenu/estimation/estimationPage.php?success=New record added!');
            exit;
        }
        else
        {
            header('Location: /BillingApplication/navMenu/estimation/addEstimationPage.php?error='.mysqli_error($conn).'!');
            exit;
        }

    }
?>
