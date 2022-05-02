<?php include($_SERVER['DOCUMENT_ROOT'].'/BillingApplication/db.php');?>
<?php 
if(isset($_GET['customer_id']))
{
	$customer_id = $_GET['customer_id'];
	$salesData = "select s.sales_id,s.quantity,s.date,s.final_amount,s.purchase_id,s.price_per_unit,s.customer_id,p.item_name, 			p.gross_weight,p.net_weight from sales s,purchase p where p.purchase_id=s.purchase_id and s.customer_id=". 				$customer_id;
	$result = mysqli_query($conn, $salesData);
	$billArray = array();
	    if (mysqli_num_rows($result) > 0) 
    	{
		while($row = mysqli_fetch_assoc($result)) 
		{
		    $billArray[] = $row;
		}
    	} 
    	$returnData = "select r.return_id,r.sales_id,r.return_quantity,r.return_date,r.return_amount, 		r.purchase_id,p.item_name,p.gross_weight,p.net_weight
    	from returns r,purchase p where p.purchase_id=r.purchase_id and r.customer_id=".$customer_id;
    	$result = mysqli_query($conn, $returnData);
	$returnArray = array();
	    if (mysqli_num_rows($result) > 0) 
    	{
		while($row = mysqli_fetch_assoc($result)) 
		{
		    $returnArray[] = $row;
		}
    	}
    	echo json_encode(array_merge($billArray,$returnArray));
}
?>
