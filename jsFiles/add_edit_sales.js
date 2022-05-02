
function assignWeight(el)
{
    //alert(purchaseId.value);costOfItems
    const obj = JSON.parse(el.value);
    document.getElementById("gweight").value=obj.gweight;
    document.getElementById("netweight").value=obj.net_weight;
    document.getElementById("quantity").value=obj.quantity;
    document.getElementById("quantity").setAttribute("max",obj.quantity);
    document.getElementById("actual_quantity").value=obj.quantity;
    //alert(obj.gweight);
}
function quanityCalculatePrices()
{
    calTotal();
    if(document.getElementById("discountMethod").value!='')
    {
        calDiscount();
    }
    if(document.getElementById("taxMethod").value!='')
    {
        calTax();
    }
}

function calDiscountDropDown()
{
    calDiscount();
    if(document.getElementById("taxMethod").value!='')
    {
        calTax();
    }
}

function calTotalDiscTax()
{
    calTotal();
    calDiscount();
    calTax();
    if(document.getElementById("receivedAmount").value!='')
    {
        document.getElementById("receivedAmount").value='';
        document.getElementById("remainingAmountSpan").innerHTML='';   
    }
}

function calTotal()
{
    var price = document.getElementById("priceUnit").value;
    var quantity = document.getElementById("quantity").value;
    document.getElementById("total").innerHTML="&nbsp;<u><i>total="+price*quantity+"</i></u>";
    document.getElementById("costOfItems").value=price*quantity;
}

function calTaxEditPage()
{
    if(document.getElementById("taxMethod").value=='')
    {
        document.getElementById("taxUnit").value='';
        window.alert('Please select tax method!');
    }
    else{
    var tax = parseFloat(document.getElementById("taxUnit").value);
    var discountAmountAdded = parseFloat(document.getElementById("amountDiscAdded").value);
    var taxMethod = document.getElementById("taxMethod");
    var selectedValue = taxMethod.value;
    if(selectedValue=='percentage')
    {
        var taxAmount = parseFloat(discountAmountAdded + (discountAmountAdded*tax/100));
    }
    else if(selectedValue=='rs')
    {
        var taxAmount = parseFloat(discountAmountAdded + tax);
    }
    document.getElementById("taxAdded").innerHTML="&nbsp;<u><i>total="+taxAmount+"</i></u>";
    document.getElementById("finalAmount").value=taxAmount;
    }
}
function calTax()
{

    if(document.getElementById("taxUnit").value)
        {
            var tax = parseFloat(document.getElementById("taxUnit").value);
            var discountAmountAdded = parseFloat(document.getElementById("amountDiscAdded").value);
            var taxMethod = document.getElementById("taxMethod");
            var selectedValue = taxMethod.value;
            if(selectedValue=='percentage')
            {
                var taxAmount = parseFloat(discountAmountAdded + (discountAmountAdded*tax/100));
            }
            else if(selectedValue=='rs')
            {
                var taxAmount = parseFloat(discountAmountAdded + tax);
            }
            document.getElementById("taxAdded").innerHTML="&nbsp;<u><i>total="+taxAmount+"</i></u>";
            document.getElementById("finalAmount").value=taxAmount;
        }
}
function calDiscount()
{
    
    if(document.getElementById("discUnit").value!='')
    {
            var price = parseFloat(document.getElementById("priceUnit").value);
            var quantity = parseFloat(document.getElementById("quantity").value);
            var total=parseFloat(price*quantity);
            var discMethod = document.getElementById("discountMethod");
            var selectedValue = discMethod.value;
            var discount = parseFloat(document.getElementById("discUnit").value);
        
            if(selectedValue=='percentage')
            {
                var discAmount = parseFloat(total - (total*discount/100));
            }
            else if(selectedValue=='rs')
            {
                var discAmount = parseFloat(total - discount);
            }
            if(discAmount>=0)
            {
                document.getElementById("amountDiscAdded").value=discAmount;
                document.getElementById("discountAdded").innerHTML="&nbsp;<u><i>total="+discAmount+"</i></u>";
            }
            else{
                document.getElementById("discUnit").value='';
                window.alert("Discount can't be greater than amount!");
            }
    }  
}
function verRecAmount()
{
    //alert("hi");
    var total = document.getElementById("finalAmount").value;
    var receivedAmount = document.getElementById("receivedAmount").value;
    var remainingAmount = total-receivedAmount;
    //alert(total+" "+receivedAmount+' '+remainingAmount);
    if(remainingAmount<0)
    {
        alert('Received amount can not be greater than total amount!');
        document.getElementById("receivedAmount").value='';
    }
    else
    {
        document.getElementById("remainingAmountSpan").innerHTML="&nbsp;<u><i>remaining="+remainingAmount+"</i></u>";
        document.getElementById("remainingAmount").value=remainingAmount;
    }
}

function validateQuantity(maxValue)
{
    //alert('hi');
    var quantity = document.getElementById("quantity").value;
    var maxValue=maxValue;
    var diff = maxValue-quantity;
    //alert(quantity+' '+maxValue+' '+diff);
    if(diff<0)
    {
        alert("Stock only has "+maxValue+" items");
        document.getElementById("quantity").value=maxValue;
    }

}
function validateStockQuantityEditPage(maxValue)
{
    //alert('hi');
    var quantity = document.getElementById("quantity").value;
    var maxValue=maxValue;
    var diff = maxValue-quantity;
    //alert(quantity+' '+maxValue+' '+diff);
    if(diff<0)
    {
        alert("Stock only has "+maxValue+" items");
        document.getElementById("quantity").value=maxValue;
    }

}

function validateQuantityEditPage()
{
    validateQuantity();
    calTotal();
    calDiscount();
    calTax();
}
function callTotalEditPage()
{
    calTotal();
    calDiscount();
    calTax();
    verRecAmount();
}
function calTaxEditPage()
{
    calDiscount();
    calTax();
    verRecAmount();
}