<?php include($_SERVER['DOCUMENT_ROOT'].'/BillingApplication/db.php');?>
<?php 
	if (count($_POST) > 0) 
	{
        $hiddenIndexArray = $_POST["hiddenIndexArray"];
        $indexArray = explode(',',$hiddenIndexArray);
        $customerId = $_POST["customerName"];
        //print_r($indexArray);exit;
        $success=0;
        foreach ($indexArray as $index) 
        {
            $itemName = $_POST["itemName".$index];
            $obj = json_decode($itemName);
            $stock_id=$obj->stock_id;
            $purchase_id=$obj->purchase_id;
            $quantity=$_POST["quantity".$index];
            $less=$_POST["less".$index];
            $touch=$_POST["touch".$index];
            $priceUnit = $_POST["priceUnit".$index];
            $finalAmount=$_POST["finalAmount".$index];
            $receivedAmount=$_POST["receivedAmount".$index];
            $balanceDue=$_POST["balanceDue".$index];

            $sql="INSERT INTO sales
            (stock_id, customer_id, quantity, touch, less, date, final_amount, balance_due, purchase_id, price_per_unit) 
            VALUES ('".$stock_id."','".$customerId."','".$quantity."','".$touch."','".$less."',now(),'".$finalAmount."','".$balanceDue."','".$purchase_id."','".$priceUnit."')";
            //echo $sql;
            if (mysqli_query($conn, $sql)) 
            {
                $stockQuantity = "update stock set purchase_id='".$purchase_id."',quantity=(quantity-".$quantity.") where stock_id='".$stock_id."'";
                //echo $stockQuantity."<br>";
                if (mysqli_query($conn, $stockQuantity)) 
                {
                    $success=$success+1;
                }
                else
                {
                    header('Location: /BillingApplication/navMenu/sales/addSalesPage.php?error='.mysqli_error($conn).'!');
                    exit;
                }
            }
            else
            {
                header('Location: /BillingApplication/navMenu/sales/addSalesPage.php?error='.mysqli_error($conn).'!');
                exit;
            }
        }
        //exit;
        if($success==sizeof($indexArray))
        {
            mysqli_close($conn);
            header('Location: /BillingApplication/navMenu/sales/salesPage.php?success=New record added!');
            exit;
        }
        else
        {
            mysqli_close($conn);
            header('Location: /BillingApplication/navMenu/sales/salesPage.php?error=Some error occured!');
            exit;
        }
    }
?>
