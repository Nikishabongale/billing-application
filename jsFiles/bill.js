function getSaleReturn()
{
    var customer_id = document.getElementById("customerName").value;
    //window.location.href="/BillingApplication/navMenu/return/itemDropdownData.php?customer_id="+customer_id;
    const xhttp = new XMLHttpRequest();
    xhttp.onload = function() {
      console.log(this.responseText);
      var data=this.responseText;
      const obj = JSON.parse(data);
      var hiddenVal = document.createElement("input");
      hiddenVal.setAttribute("type","hidden");
      hiddenVal.setAttribute("value",data);
      hiddenVal.setAttribute("name","allData");
      hiddenVal.setAttribute("id","allData");
      document.getElementById("hiddenElement").appendChild(hiddenVal);
      //var s = "<option value=''>Select item name</option>";
      		//empty the tbody
               document.getElementById("saleBody").innerHTML='';
               document.getElementById("returnBody").innerHTML='';
      		property = "return_id";
      		count=0;  
               for (var i = 0; i < obj.length; i++) {  
                  // s += '<option value="' + obj[i].purchase_id + '">' + obj[i].item_name + '</option>'; 
                  //sale data
                  if (!obj[i].hasOwnProperty(property))
                  {
                  	sales_id=obj[i].sales_id
                  	sales_quantity = obj[i].quantity
                  	sales_date = obj[i].date
                  	final_amount=obj[i].final_amount
                  	purchase_id = obj[i].purchase_id
                  	price_per_unit = obj[i].price_per_unit
                  	customer_id=obj[i].customer_id
                  	item_name=obj[i].item_name
                  	sales_date=obj[i].date
                  	
                  	var tbl = document.getElementById("saleBody");
                  	var currentRow = tbl.insertRow(-1);
			//create checkbox
			var currentCell = currentRow.insertCell(-1);
			var checkBox = document.createElement("input");
			checkBox.setAttribute("type","checkbox");
			checkBox.setAttribute("value",sales_id);
			checkBox.setAttribute("id","sale"+i);
			checkBox.setAttribute("checked","checked");
			checkBox.setAttribute("name","sale"+i);
			currentCell.appendChild(checkBox);
			
			//item_name
			var currentCell = currentRow.insertCell(-1);
			var span= document.createElement("span");
			span.innerHTML=item_name;
			currentCell.appendChild(span);
			
			//sale quantity
			var currentCell = currentRow.insertCell(-1);
			var span= document.createElement("span");
			span.innerHTML=sales_quantity;
			currentCell.appendChild(span);
			
			//final_amount
			var currentCell = currentRow.insertCell(-1);
			var span= document.createElement("span");
			span.innerHTML=final_amount;
			currentCell.appendChild(span);
			
			//date
			var currentCell = currentRow.insertCell(-1);
			var span= document.createElement("span");
			span.innerHTML=sales_date;
			currentCell.appendChild(span);
			
			var saleIndex = document.createElement("input");
			saleIndex.setAttribute("value",i);
			saleIndex.setAttribute("type","hidden");
			saleIndex.setAttribute("name","rowsIndex");
			currentCell.appendChild(saleIndex);
			
			var saleIndex = document.createElement("input");
			saleIndex.setAttribute("value",i);
			saleIndex.setAttribute("type","hidden");
			saleIndex.setAttribute("name","saleIndex");
			currentCell.appendChild(saleIndex);
				
                  }
                  //else for return data
                  else
                  {
                  	return_id=obj[i].return_id
                  	return_quantity = obj[i].return_quantity
                  	return_date = obj[i].return_date
                  	return_amount = obj[i].return_amount
                  	purchase_id = obj[i].purchase_id
                  	item_name = obj[i].item_name
                  	
                  	var tbl = document.getElementById("returnBody");
                  	var currentRow = tbl.insertRow(-1);
			//create checkbox
			var currentCell = currentRow.insertCell(-1);
			var checkBox = document.createElement("input");
			checkBox.setAttribute("type","checkbox");
			checkBox.setAttribute("checked","checked");
			checkBox.setAttribute("id","return"+count);
			checkBox.setAttribute("name","return"+count);
			checkBox.setAttribute("value",return_id);
			currentCell.appendChild(checkBox);
			
			//item_name
			var currentCell = currentRow.insertCell(-1);
			var span= document.createElement("span");
			span.innerHTML=item_name;
			currentCell.appendChild(span);
			
			//return quantity
			var currentCell = currentRow.insertCell(-1);
			var span= document.createElement("span");
			span.innerHTML=return_quantity;
			currentCell.appendChild(span);
			
			//return amount
			var currentCell = currentRow.insertCell(-1);
			var span= document.createElement("span");
			span.innerHTML=return_amount;
			currentCell.appendChild(span);
			
			//return date
			var currentCell = currentRow.insertCell(-1);
			var span= document.createElement("span");
			span.innerHTML=return_date;
			currentCell.appendChild(span);
			var rowsIndex = document.createElement("input");
			rowsIndex.setAttribute("value",i);
			rowsIndex.setAttribute("type","hidden");
			rowsIndex.setAttribute("name","rowsIndex");
			currentCell.appendChild(rowsIndex);
			
			var returnIndex = document.createElement("input");
			returnIndex.setAttribute("value",count);
			returnIndex.setAttribute("type","hidden");
			returnIndex.setAttribute("name","returnIndex");
			currentCell.appendChild(returnIndex);
			count=count+1;                  	
                  }
               }

               //$("#itemName").html(s);  
    }
    xhttp.open("GET", "/BillingApplication/navMenu/billing/billingDropdownData.php?customer_id="+customer_id);
    xhttp.send();
}
