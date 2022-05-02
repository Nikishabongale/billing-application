<?php include($_SERVER['DOCUMENT_ROOT'].'/BillingApplication/db.php');?>
<?php
    $sql="select sum(s.quantity),p.gross_weight,p.net_weight,s.purchase_id,s.customer_id
    from sales s,purchase p
    where p.purchase_id=s.purchase_id
    group by s.customer_id";
    $result = mysqli_query($conn, $sql);
    $emparray = array();
    while($row =mysqli_fetch_assoc($result))
    {
        $emparray[] = $row;
    }
    echo json_encode($emparray);
    mysqli_close($conn);
?>