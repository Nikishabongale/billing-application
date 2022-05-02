<?php include($_SERVER['DOCUMENT_ROOT'].'/BillingApplication/db.php');?>
<?php
require('FPDF-master/fpdf.php');
//get the post data
$returnDataArr =array();
$saleDataArrN=array();
$saleDataArr=array();
$mergerArray=array();
class PDF extends FPDF
{
// Simple table
	function BasicTable($header,$saleDataArr,$returnDataArr,$rowsIndex)
	{
		$count=0;
		$this->Cell(140,10,"Jewellery shop",1);
		$this->Cell(40,10,"Date:".date("d/m/Y"),1);
		$this->Ln();
		$this->Ln();
		$objSaleDataArr= json_decode($saleDataArr);
		$objReturnDataArr=json_decode($returnDataArr);
		foreach($header as $col)
		{
			if($count==0)
			{
				$this->Cell(40,8,$col,1);
			}
			else
			{
				$this->Cell(35,8,$col,1);
			}
			$count++;
		}
		$this->Ln();
		
		$total=0;
		if(count($objSaleDataArr)>0)
		{
			for($x=0;$x<count($objSaleDataArr);$x++)
			{
				$total = $total + $objSaleDataArr[$x]->final_amount;
				$this->Cell(40,5,$objSaleDataArr[$x]->item_name,1);
				$this->Cell(35,5,$objSaleDataArr[$x]->quantity,1);
				$this->Cell(35,5,$objSaleDataArr[$x]->gross_weight,1);
				$this->Cell(35,5,$objSaleDataArr[$x]->net_weight,1);
				$this->Cell(35,5,$objSaleDataArr[$x]->final_amount,1);
				$this->Ln();	
			}
		}
		
		if(count($objReturnDataArr)>0)
		{
			for($x=0;$x<count($objReturnDataArr);$x++)
			{
				$total=$total-$objReturnDataArr[$x]->return_amount;
				$this->Cell(40,5,$objReturnDataArr[$x]->item_name,1);
				$this->Cell(35,5,$objReturnDataArr[$x]->return_quantity,1);
				$this->Cell(35,5,$objReturnDataArr[$x]->gross_weight,1);
				$this->Cell(35,5,$objReturnDataArr[$x]->net_weight,1);
				$this->Cell(35,5,'-'.$objReturnDataArr[$x]->return_amount,1);
				$this->Ln();
			}
		}
		$this->Cell(145,5,'Total',1);
		$this->Cell(35,5,$total,1);
		$this->Ln();
	}
}


if (count($_POST) > 0)
{
	$allData = $_POST["allData"];
	$saleDataArr = [];
	$returnDataArr= [];
	$rowsIndex=$_POST["rowsIndex"];
	if (isset($_POST['returnIndex'])) 
	{
		$returnIndex=$_POST["returnIndex"];
		for($x=0;$x<=(int)$returnIndex;$x++)
		{

			$t = "return".$x;
			$return_id = $_POST[$t];
			//get sale data
			if($return_id!='' or $return_id!=NULL)
			{
				$return_detail = "select r.return_id,r.sales_id,r.return_quantity,r.return_date,r.return_amount,r.purchase_id,p.item_name,p.gross_weight,p.net_weight
	from returns r,purchase p where p.purchase_id=r.purchase_id and r.return_id=".$return_id;

				$result = mysqli_query($conn, $return_detail);
				if (mysqli_num_rows($result) > 0) 
				{
					$returnDataArrN=array();
					while($row = mysqli_fetch_assoc($result)) 
					{
						$returnDataArrN[] = $row;
						$returnDataArr = array_merge($returnDataArrN, $returnDataArr); 
					}

				}
			}

				 
		}
	}
	//echo $saleIndex;
	//echo $_POST["sale0"];
	//echo $_POST["sale1"];
	//check for the sale data
	if (isset($_POST['saleIndex']))
	{
		$saleIndex = $_POST["saleIndex"];
		for($x=0;$x<=(int)$saleIndex;$x++)
		{

			$t = "sale".$x;
			$sales_id = $_POST[$t];
			//echo $sales_id;
			//get sale data
			if($sales_id!=NULL or $sales_id!='')
			{
			$sale_detail = "select s.sales_id,s.quantity,s.date,s.final_amount,s.purchase_id,s.price_per_unit,s.customer_id,p.item_name,p.gross_weight,p.net_weight from sales s,purchase p where p.purchase_id=s.purchase_id and s.sales_id=". 				$sales_id;
				//echo $sale_detail;
				$result = mysqli_query($conn, $sale_detail);
				if (mysqli_num_rows($result) > 0) 
				{
					$saleDataArrN=array();
					while($row = mysqli_fetch_assoc($result)) 
					{
						$saleDataArrN[] = $row;
						$saleDataArr = array_merge($saleDataArrN, $saleDataArr); 
					}

				}
			}
				 
		}
	}
	//echo print_r($saleDataArr);
	//exit;
	$mergerArray = array_merge($saleDataArr,$returnDataArr);
	//print_r($mergerArray);exit;
	
	
	$pdf = new PDF();
	$pdf->AddPage();
	$pdf->SetFont('Arial','',12);
	$header = array('Description', 'Pcs', 'Gr Wt','Net Wt','Amount');
	//$header = array('Description', 'Pcs', 'Gr Wt', 'Less','Net Wt','Touch','Labour','Silver','Amount');
	$pdf->BasicTable($header,json_encode($saleDataArr),json_encode($returnDataArr),$rowsIndex);
	$pdf->Output(); 
}


?>
<?php mysqli_close($conn);?>
