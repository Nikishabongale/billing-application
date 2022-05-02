<?php include($_SERVER['DOCUMENT_ROOT'].'/BillingApplication/db.php');?>
<?php
if (count($_POST) > 0) 
{
    $estimation_id = $_POST["estimation_id"];
    $itemName = $_POST["itemName"];
    $obj = json_decode($itemName);
    $stock_id=$obj->stock_id;
    $purchase_id=$obj->purchase_id;
    $customer_id = $_POST["customerName"];
    $quantity = $_POST["quantity"];
    $priceUnit = $_POST["priceUnit"];
    $discUnit = $_POST["discUnit"];
    $taxUnit = $_POST["taxUnit"];
    $desc = $_POST["desc"];
    $desc=str_replace('"',"'",$desc);

    $amount=$_POST["finalAmount"];
    $discountMethod=$_POST["discountMethod"];
    $taxMethod=$_POST["taxMethod"];
    $costOfItems=$_POST["costOfItems"];

    $discount=$discUnit.' '.$discountMethod;
    $tax=$taxUnit.' '.$taxMethod;

    //echo $sql;exit;
    $sql="UPDATE estimation SET 
    stock_id='".$stock_id."',customer_id='".$customer_id."',quantity='".$quantity."',amount='".$amount."'
    ,discount='".$discount."',purchase_id='".$purchase_id."',tax='".$tax."'
    ,total_no_tax_disc='".$costOfItems."',descpn=".'"'.$desc.'"'.",price_per_unit='".$priceUnit."' 
     WHERE estimation_id='".$estimation_id."'";
    if (mysqli_query($conn, $sql)) 
    {
        mysqli_close($conn);
        header('Location: /BillingApplication/navMenu/estimation/estimationPage.php?success=Record Updated!');
    }
    else 
    {
        header('Location: /BillingApplication/navMenu/estimation/estimationPage.php?estimationId='.$estimation_id.'&error='.mysqli_error($conn));
    }
}
?>