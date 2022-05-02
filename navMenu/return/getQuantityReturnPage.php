<?php include($_SERVER['DOCUMENT_ROOT'].'/BillingApplication/db.php');?>
<?php
    if($_GET>0)
    {
        $return_quantity_sum=0;
        $customer_id=$_GET["customer_id"];
        $purchase_id=$_GET["purchase_id"];
        $return_sum_quantity = "select sum(return_quantity) as return_quantity_sum from returns 
		where purchase_id='".$purchase_id."' and customer_id='".$customer_id."' group by customer_id,purchase_id";
		$result = mysqli_query($conn, $return_sum_quantity);
        while($row =mysqli_fetch_assoc($result))
		{
			$return_quantity_sum = $row["return_quantity_sum"];
		}       
		if($return_quantity_sum==NULL)
		{
			$return_quantity_sum=0;
		}
        else if($return_quantity_sum=='')
        {
            $return_quantity_sum=0;
        }
        //echo "after assignment return_quantity_sum ".$return_quantity_sum."\n";
        $sql="select sum(s.quantity)-".$return_quantity_sum."
		as quantity,s.purchase_id,s.customer_id,s.sales_id,s.stock_id
		from sales s,purchase p
		where p.purchase_id=s.purchase_id and p.purchase_id='".$purchase_id."' and s.customer_id='".$customer_id."'
		group by s.customer_id";
        //echo $sql;exit;
        $result = mysqli_query($conn, $sql);
        $emparray = array();
		while($row =mysqli_fetch_assoc($result))
		{
			$emparray[] = $row;
		}
        echo json_encode($emparray);
        mysqli_close($conn);
    }
?>