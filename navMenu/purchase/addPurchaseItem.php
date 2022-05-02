<?php include($_SERVER['DOCUMENT_ROOT'].'/BillingApplication/db.php');?>
<?php 
	if (count($_POST) > 0) 
	{
		$itemName = $_POST["itemName"];
        $quantity = $_POST["quantity"];
        $gweight = $_POST["gweight"];
        $netweight = $_POST["netweight"];
        $desc = $_POST["desc"];
        $desc=str_replace('"',"'",$desc);
        $vendor_id = $_POST["vendor"];
        $price_unit=$_POST["priceUnit"];

        //echo $price_unit;exit;

        if($gweight=='')
        {
            $gweight = 0.0;
        }
        if($netweight=='')
        {
            $netweight = 0.0;
        }
        if($price_unit=='')
        {
            $price_unit = 0.0;
        }
        if($vendor_id=='')
        {
            $sql = "INSERT INTO purchase(item_name, gross_weight,net_weight,descrptn,vendor_id) 
            VALUES ('".$itemName."','".$gweight."','".$netweight."',".'"'.$desc.'"'.",NULL)";
            //echo $sql;exit;
        }
        else
        {
            $sql = "INSERT INTO purchase(item_name, gross_weight,net_weight,descrptn, vendor_id) 
            VALUES ('".$itemName."','".$gweight."','".$netweight."',".'"'.$desc.'"'.",'".$vendor_id."')";
        //echo $sql;exit;
        }
        if (mysqli_query($conn, $sql)) 
        {
            //echo "New record created successfully";
            $sql = "select purchase_id from purchase where item_name='".$itemName."'";
            $result = mysqli_query($conn, $sql);
            if (mysqli_num_rows($result) > 0) 
			{
			    while($row = mysqli_fetch_assoc($result)) 
            	{
                   $purchase_id = $row["purchase_id"];
                }
            }
            $insertPurchaseChild = "INSERT INTO purchase_child
            (purchase_id, date, price_unit, quantity) VALUES 
            ('".$purchase_id."',now(),'".$price_unit."','".$quantity."')";
            $insertSql = "INSERT INTO stock(purchase_id, quantity) VALUES ('".$purchase_id."','".$quantity."')";
            if ((mysqli_query($conn, $insertSql))&&(mysqli_query($conn, $insertPurchaseChild)))
            {
                mysqli_close($conn);
                header('Location: /BillingApplication/navMenu/purchase/purchasePage.php?success=New record added!');
			    exit;
            }
        }
        else 
        {
            //echo $sql;
            header('Location: /BillingApplication/navMenu/purchase/addPurchaseItemPage.php?error='.mysqli_error($conn).'!');
            exit;        
        }
    }

?>