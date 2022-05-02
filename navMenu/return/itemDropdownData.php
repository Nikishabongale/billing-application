<?php include($_SERVER['DOCUMENT_ROOT'].'/BillingApplication/db.php');?>
<?php 
if(isset($_GET['customer_id']))
{
    $customer_id = $_GET['customer_id'];
    $itemList = "select p.item_name,p.purchase_id from purchase p, sales s
    where p.purchase_id=s.purchase_id and s.customer_id='".$customer_id."' group by purchase_id";
    $result = mysqli_query($conn, $itemList);
    $emparray = array();
    if (mysqli_num_rows($result) > 0) 
    {
		while($row = mysqli_fetch_assoc($result)) 
        {
            $emparray[] = $row;
        }
    }
    //echo str_replace('\"',"",json_encode($item));exit;
    echo json_encode($emparray);
    //header('Location: /BillingApplication/navMenu/return/addReturnPage.php?customer_id='.$customer_id.'&itemData='.$item_json);
    
}
?>
