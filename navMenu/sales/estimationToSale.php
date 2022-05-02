<?php include($_SERVER['DOCUMENT_ROOT'].'/BillingApplication/db.php');?>
<?php
    if($_POST>0)
    {
        $estimation_id=$_POST["estimation_id"];
        $stock_id=$_POST["stock_id"];
        $customer_id=$_POST["customerId"];
        $quantity=$_POST["quantity"];
        $gross_weight=$_POST["gweight"];
        $net_weight=$_POST["netweight"];
        $amount=$_POST["finalAmount"];
        $received_amount=$_POST["receivedAmount"];
        $balance_due=$amount-$received_amount;
        $purchase_id=$_POST["purchase_id"];

        $discountMethod=$_POST["discountMethod"];
        $discUnit=$_POST["discUnit"];
        $discount=$discUnit.' '.$discountMethod;
        $taxMethod=$_POST["taxMethod"];
        $taxUnit=$_POST["taxUnit"];
        $tax=$taxUnit.' '.$taxMethod;

        $price_per_unit=$_POST["priceUnit"];
        $total_no_tax_disc=$price_per_unit*$quantity;
        $descpn=$_POST["desc"];

        //check for stock quantity
        $checkStockQuantity="select quantity from stock where purchase_id=".$purchase_id;
        $result = mysqli_query($conn, $checkStockQuantity);
        if (mysqli_num_rows($result) > 0) 
        {
            while($row = mysqli_fetch_assoc($result))
            {
                $stock_quantity=$row["quantity"];
            }
        }

        if($stock_quantity>=$quantity)
        {
            $insertToSale="INSERT INTO sales
            (stock_id, customer_id, quantity, date, amount, balance_due, discount, 
            purchase_id, tax, total_no_tax_disc, descpn, price_per_unit)
            VALUES ('".$stock_id."','".$customer_id."','".$quantity."',now(),'".$amount."','".$balance_due."','".$discount."',
            '".$purchase_id."','".$tax."','".$total_no_tax_disc."',".'"'.$descpn.'"'.",'".$price_per_unit."')";
            //echo $insertToSale;exit;
            if (mysqli_query($conn, $insertToSale)) 
            {
                $stockQuantity = "update stock set purchase_id='".$purchase_id."',quantity=(quantity-".$quantity.") where stock_id='".$stock_id."'";
                if (mysqli_query($conn, $stockQuantity)) 
                {
                    //delete from estimation
                    $deleteEstimation="delete from estimation where estimation_id=".$estimation_id;
                    if (mysqli_query($conn, $deleteEstimation)) 
                    {
                        mysqli_close($conn);
                        header('Location: /BillingApplication/navMenu/sales/salesPage.php?success=New record added!');
                        exit;
                    }
                }
                else
                {
                    header('Location: /BillingApplication/navMenu/sales/estimationToSalePage.php?error='.mysqli_error($conn).'!');
                    exit;
                }
            }
            else
            {
                header('Location: /BillingApplication/navMenu/sales/estimationToSalePage.php?error='.mysqli_error($conn).'!');
                exit;
            }
        }
        else
        {
            header('Location: /BillingApplication/navMenu/sales/estimationToSalePage.php?error=stock is less, please check stocks page&estimationId='.$estimation_id);
            exit;
        }

    }
?>