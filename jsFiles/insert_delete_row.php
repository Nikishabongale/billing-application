<script>
//insert row
function addField(argument) {
    var myTable = document.getElementById("addSaleTable");
    var last = document.getElementsByName("hiddenIndex").length;
    var currentIndex = document.getElementsByName("hiddenIndex")[last-1].value;
    //add value to the index array
    var indexArray = document.getElementById("hiddenIndexArray").value;
    indexArray = indexArray.concat(",",currentIndex);
    document.getElementById("hiddenIndexArray").value=indexArray;

    var currentRowIndex = myTable.rows.length;

    var currentRow = myTable.insertRow(-1);

    var dropdownBox = document.createElement("select");
    dropdownBox.name="itemName"+currentIndex;
    dropdownBox.id="itemName"+currentIndex;
    dropdownBox.setAttribute("onclick", "assignWeightRowWise(this)");
    dropdownBox.setAttribute("class", "dropDown");
    dropdownBox.setAttribute("required", "required");
    var option = document.createElement("option");
    option.value = '';
    option.text = 'select item';
    dropdownBox.appendChild(option);
    
    <?php 
    $sql = "select item_name,p.purchase_id,gross_weight,net_weight,st.quantity,st.stock_id
    from purchase p,stock st
    where p.purchase_id=st.purchase_id";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) 
        {
            while($row = mysqli_fetch_assoc($result)) 
            {?>
            var dropdownValueObj={ "gweight":"<?php echo $row["gross_weight"]; ?>", 
                        "net_weight":"<?php echo $row["net_weight"];?>", 
                        "purchase_id":"<?php echo $row["purchase_id"];?>",
                        "quantity":"<?php echo $row["quantity"];?>",
                        "stock_id":"<?php echo $row["stock_id"];?>", 
                        "rowIndex":parseInt(currentIndex)
                    };
            var dropdownValue=JSON.stringify(dropdownValueObj);
            var option = document.createElement("option");
            option.value=dropdownValue;
            option.text="<?php echo $row["item_name"].' ('.$row["quantity"].' items)';?>";
            dropdownBox.appendChild(option);
            <?php 
            }
        }
?>
    var currentCell = currentRow.insertCell(-1);
    currentCell.appendChild(dropdownBox);

    var quantity = document.createElement("input");
    quantity.setAttribute("type", "number");
    quantity.name="quantity"+currentIndex;
    quantity.id="quantity"+currentIndex;
    quantity.setAttribute("placeholder", "quantity");
    quantity.setAttribute("required", "required");
    quantity.setAttribute("class", "readonly");
    quantity.setAttribute("min", "1");
    quantity.setAttribute("readonly", "readonly");
    quantity.setAttribute("onchange", "verifyQuantity('"+currentIndex+"')");
    quantity.setAttribute("onkeyup", "verifyQuantity('"+currentIndex+"')");
    quantity.setAttribute("onkeydown", "verifyQuantity('"+currentIndex+"')");
    var stockQuantity=document.createElement("input");
    stockQuantity.setAttribute("type","hidden");
    stockQuantity.name="stockQuantity"+currentIndex;
    stockQuantity.id="stockQuantity"+currentIndex;
    currentCell = currentRow.insertCell(-1);
    currentCell.appendChild(quantity);
    currentCell.appendChild(stockQuantity);

    var gweight = document.createElement("input");
    gweight.setAttribute("type", "number");
    gweight.setAttribute("readonly", "readonly");
    gweight.setAttribute("class", "readonly");
    gweight.name="gweight"+currentIndex;
    gweight.id="gweight"+currentIndex;
    currentCell = currentRow.insertCell(-1);
    currentCell.appendChild(gweight);
    //currentCell.appendChild(violationsBox);
    
    var netweight = document.createElement("input");
    netweight.setAttribute("type", "number");
    netweight.setAttribute("readonly", "readonly");
    netweight.setAttribute("class", "readonly");
    netweight.name="netweight"+currentIndex;
    netweight.id="netweight"+currentIndex;
    currentCell = currentRow.insertCell(-1);
    currentCell.appendChild(netweight);

    var priceUnit = document.createElement("input");
    priceUnit.setAttribute("type", "number");
    priceUnit.setAttribute("required", "required");
    priceUnit.name="priceUnit"+currentIndex;
    priceUnit.id="priceUnit"+currentIndex;
    priceUnit.setAttribute("placeholder", "price/unit");
    priceUnit.setAttribute("onchange", "calculateFinalAmount('"+currentIndex+"')");
    priceUnit.setAttribute("onkeyup", "calculateFinalAmount('"+currentIndex+"')");
    priceUnit.setAttribute("onkeydown", "calculateFinalAmount('"+currentIndex+"')");
    currentCell = currentRow.insertCell(-1);
    currentCell.appendChild(priceUnit);

    var less = document.createElement("input");
    less.setAttribute("type", "number");
    less.setAttribute("required", "required");
    less.name="less"+currentIndex;
    less.id="less"+currentIndex;
    less.setAttribute("placeholder", "less");
    less.setAttribute("onchange", "calculateFinalAmount('"+currentIndex+"')");
    less.setAttribute("onkeyup", "calculateFinalAmount('"+currentIndex+"')");
    less.setAttribute("onkeydown", "calculateFinalAmount('"+currentIndex+"')");
    currentCell = currentRow.insertCell(-1);
    currentCell.appendChild(less);

    var touch = document.createElement("input");
    touch.setAttribute("type", "number");
    touch.setAttribute("required", "required");
    touch.name="touch"+currentIndex;
    touch.id="touch"+currentIndex;
    touch.setAttribute("placeholder", "touch");
    touch.setAttribute("onchange", "calculateFinalAmount('"+currentIndex+"')");
    touch.setAttribute("onkeyup", "calculateFinalAmount('"+currentIndex+"')");
    touch.setAttribute("onkeydown", "calculateFinalAmount('"+currentIndex+"')");
    currentCell = currentRow.insertCell(-1);
    currentCell.appendChild(touch);
     
    //total
    var totalSpan = document.createElement("span");
    totalSpan.id="finalAmountSpan"+currentIndex;
    var total = document.createElement("input");
    total.setAttribute("type", "hidden");
    total.id="finalAmount"+currentIndex;
    total.name="finalAmount"+currentIndex;
    currentCell = currentRow.insertCell(-1);
    currentCell.appendChild(totalSpan);
    currentCell.appendChild(total);

    var receivedAmount = document.createElement("input");
    receivedAmount.setAttribute("type", "number");
    receivedAmount.setAttribute("required", "required");
    receivedAmount.name="receivedAmount"+currentIndex;
    receivedAmount.id="receivedAmount"+currentIndex;
    receivedAmount.setAttribute("placeholder", "received");
    receivedAmount.setAttribute("onchange", "calculateBalanceDue('"+currentIndex+"')");
    receivedAmount.setAttribute("onkeyup", "calculateBalanceDue('"+currentIndex+"')");
    receivedAmount.setAttribute("onkeydown", "calculateBalanceDue('"+currentIndex+"')");   
    currentCell = currentRow.insertCell(-1);
    currentCell.appendChild(receivedAmount);

    //balance due
    var balanceDueSpan = document.createElement("span");
    balanceDueSpan.id="balanceDueSpan"+currentIndex;
    var balanceDue = document.createElement("input");
    balanceDue.setAttribute("type", "hidden");
    balanceDue.id="balanceDue"+currentIndex;
    balanceDue.name="balanceDue"+currentIndex;
    currentCell = currentRow.insertCell(-1);
    currentCell.appendChild(balanceDueSpan);
    currentCell.appendChild(balanceDue);

    var addRowBox = document.createElement("button");
    addRowBox.setAttribute("type", "button");
    var icon = document.createElement("i");
    icon.className ="bx bx-plus-circle";
    addRowBox.appendChild(icon);
    addRowBox.setAttribute("onclick", "addField();");
    addRowBox.setAttribute("class","btn btn-info");
    addRowBox.setAttribute("style", "margin-right:5px;");
    currentCell = currentRow.insertCell(-1);
    currentCell.appendChild(addRowBox);
    //currentCell.appendChild(addRowBox);

    var minusRowBox = document.createElement("button");
    minusRowBox.setAttribute("type", "button");
    var minusIcon = document.createElement("i");
    minusIcon.className ="bx bx-trash";
    minusRowBox.appendChild(minusIcon);
    minusRowBox.setAttribute("onclick", "RemoveRow(this,"+currentIndex+")");
    minusRowBox.setAttribute("class","btn btn-danger");
    currentCell.appendChild(minusRowBox);

    var createdIndex = document.createElement("input");
    createdIndex.setAttribute("type", "hidden");
    createdIndex.name="hiddenIndex";
    createdIndex.value=parseInt(parseInt(currentIndex)+1);
    currentCell.appendChild(createdIndex);
}

function RemoveRow(r,index)
{
    var i = r.parentNode.parentNode.rowIndex;
    document.getElementsByTagName("tr")[i].remove();
    //remove value to the index array
    var indexArray = document.getElementById("hiddenIndexArray").value;
    indexArray = indexArray.replace(index+",","");
    indexArray = indexArray.replace(","+index,"");
    document.getElementById("hiddenIndexArray").value=indexArray;
}

function assignWeightRowWise(el)
{
    //alert(purchaseId.value);costOfItems
    if(el.value!='')
    {
        const obj = JSON.parse(el.value);
        var rowIndex = obj.rowIndex;
        document.getElementById("gweight"+rowIndex).value=obj.gweight;
        document.getElementById("netweight"+rowIndex).value=obj.net_weight;
        //document.getElementById("quantity"+rowIndex).value=obj.quantity;

        document.getElementById("quantity"+rowIndex).setAttribute("max",obj.quantity);
        document.getElementById("stockQuantity"+rowIndex).value=obj.quantity;
        document.getElementById("quantity"+rowIndex).removeAttribute("readonly");
        document.getElementById("quantity"+rowIndex).removeAttribute("class","readonly");
    }
    
    //remove selected option from other dropdown
    /*var dropFields = document.getElementsByName("hiddenIndex");
    var i;
    var d = document.getElementById("itemName"+rowIndex);
    for (i = 0; i <dropFields.length; i++) 
    {
        if(rowIndex!=i)
        {
            var x = document.getElementById("itemName"+i);
            x.remove(d.selectedIndex);
        }
    }*/
    //alert(obj.gweight);
}

function verifyQuantity(currentRowIndex)
{
   var maxQuantity = document.getElementById("stockQuantity"+currentRowIndex).value;
   //var quantity = document.getElementById("quantity"+currentRowIndex).value;
   var dropSelectedIndex = document.getElementById("itemName"+currentRowIndex).selectedIndex;
   var last = document.getElementsByName("hiddenIndex").length;
   var maxIndex = document.getElementsByName("hiddenIndex")[last-1].value;
   var i;
   var totalQuantity=0;
   var quantityInLoop;
   for(i=0;i<maxIndex;i++)
   {
      var remainingSelectedIndex = document.getElementById("itemName"+i).selectedIndex;
      if(remainingSelectedIndex==dropSelectedIndex)
      {
         //console.log(i+' '+remainingSelectedIndex+' '+dropSelectedIndex);
         quantityInLoop = document.getElementById("quantity"+i).value;
         //alert(quantityInLoop);
         totalQuantity=parseInt(totalQuantity)+parseInt(quantityInLoop);
         if(totalQuantity>maxQuantity)
         {
            document.getElementById("quantity"+currentRowIndex).value='';
         }
      } 
   }
   if(totalQuantity>maxQuantity)
   {
        fadingAlertBox("stock has less items! Please check item quantity");
   }
   calculateFinalAmount(currentRowIndex);
   //alert(totalQuantity);
}
function fadingAlertBox(alertText)
{
    var quantityAlert = document.getElementById("quantityAlert");
    quantityAlert.style.visibility="visible";
    quantityAlert.setAttribute("class","alert alert-warning");
    quantityAlert.innerHTML="<span style='float:right'><a href='#' onclick='hideElement()' class='close'>&times;</a></span>";
    quantityAlert.innerHTML+=alertText;
    fadeAlert();
}
function fadeAlert()
{
    const myTimeout = setTimeout(hideElement, 4000);
}
function hideElement()
{
    document.getElementById("quantityAlert").classList.remove("alert");
    document.getElementById("quantityAlert").classList.remove("alert-warning");
    document.getElementById("quantityAlert").innerHTML='';
    document.getElementById("quantityAlert").style.visibility='hidden';
}
function calculateFinalAmount(currentRowIndex)
{
    var priceUnit = document.getElementById("priceUnit"+currentRowIndex).value;
    var quantity = document.getElementById("quantity"+currentRowIndex).value;
    var less = document.getElementById("less"+currentRowIndex).value;
    var touch = document.getElementById("touch"+currentRowIndex).value;
    //logic
    var finalAmount = (parseInt(quantity)*parseInt(priceUnit))+(parseInt(quantity)*parseInt(less))-parseInt(touch);
    if((priceUnit!='')&&(quantity!='')&&(less!='')&&(touch!=''))
    {
        document.getElementById("finalAmountSpan"+currentRowIndex).innerHTML=finalAmount;
        document.getElementById("finalAmount"+currentRowIndex).value=finalAmount;
    }
    calculateBalanceDue(currentRowIndex);
}
function calculateBalanceDue(currentRowIndex)
{
    var finalAmount = document.getElementById("finalAmount"+currentRowIndex).value;
    var receivedAmount = document.getElementById("receivedAmount"+currentRowIndex).value;
    var balanceDue = parseInt(finalAmount)-parseInt(receivedAmount);
    if((receivedAmount!='')&&(finalAmount!=''))
    {
        if(balanceDue>=0)
        {
            document.getElementById("balanceDueSpan"+currentRowIndex).innerHTML = balanceDue;
            document.getElementById("balanceDue"+currentRowIndex).value=balanceDue;
        }
        else
        {
            fadingAlertBox("Received amount can't be greater than charged amount!");
            document.getElementById("receivedAmount"+currentRowIndex).value='';
        }
    }
}
</script>
