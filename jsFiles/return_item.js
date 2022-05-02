function checkQuantityReturn()
{
    var actual_quantity = parseInt(document.getElementById("actual_quantity").value);
    var change_quantity = parseInt(document.getElementById("quantity").value);
    calculateQuantity();
    if(actual_quantity==0)
    {
        alert("Customer has returned all sold items!");
        document.getElementById("quantity").value=actual_quantity;
    }
    else
    {
        if(change_quantity==0)
        {
            document.getElementById("quantity").value=1;
        }
        else
        {
            if(actual_quantity<change_quantity)
            {
                //alert(actual_quantity<change_quantity);
                alert("You have sold only "+actual_quantity+" product to customer");
                document.getElementById("quantity").value=actual_quantity;
            }
        } 
    }
}
function assignItem()
{
    var customer_id = document.getElementById("customerName").value;
    //window.location.href="/BillingApplication/navMenu/return/itemDropdownData.php?customer_id="+customer_id;
    const xhttp = new XMLHttpRequest();
    xhttp.onload = function() {
      console.log(this.responseText);
      var data=this.responseText;
      const obj = JSON.parse(data);
      //var s = "<option value=''>Select item name</option>";  
               for (var i = 0; i < obj.length; i++) {  
                  // s += '<option value="' + obj[i].purchase_id + '">' + obj[i].item_name + '</option>';  
                  item_name = obj[i].item_name
                  purchase_id=obj[i].purchase_id
               }
               var option = document.createElement("option");
		option.text = "Select item name";
		option.value = '';
		var select = document.getElementById("itemName");
		select.appendChild(option);
        var option = document.createElement("option");
		option.text = item_name;
		option.value = purchase_id;
		var select = document.getElementById("itemName");
		select.appendChild(option);
  
               //$("#itemName").html(s);  
    }
    xhttp.open("GET", "/BillingApplication/navMenu/return/itemDropdownData.php?customer_id="+customer_id);
    xhttp.send();
}
function assignRestContent()
{
    var customer_id = document.getElementById("customerName").value;
    var purchase_id = document.getElementById("itemName").value;
    //alert(customer_id+' '+item_id)
    const xhttp = new XMLHttpRequest();
    xhttp.onload = function() {
      console.log(this.responseText);
      var data=this.responseText;
      const obj = JSON.parse(data);
      document.getElementById("quantity").value=obj[0].quantity; 
      document.getElementById("actual_quantity").value=obj[0].quantity;
      document.getElementById("sales_id").value=obj[0].sales_id;
      document.getElementById("stock_id").value=obj[0].stock_id;
    }
    xhttp.open("GET", "/BillingApplication/navMenu/return/getQuantityReturnPage.php?customer_id="+customer_id+"&purchase_id="+purchase_id);
    xhttp.send();

}
