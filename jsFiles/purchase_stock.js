function GetSelectedTextValue(selectOperation) {
    var selectedText = selectOperation.options[selectOperation.selectedIndex].innerHTML;
    var selectedValue = selectOperation.value;
    if(selectedText=='delete')
    {
        document.getElementById("selectOperation").value='';
        var x = document.getElementById(selectedValue);
        x.style.display = "block";
        document.body.style.setProperty('background', 'grey', 'important');
        //document.getElementById("modaleBody").style.setProperty('filter', 'brightness(0.5)');
        //document.body.style.setProperty('filter', 'brightness(0.5)');
        document.body.style.overflow = 'hidden';
    }
    else if(selectedText=='Edit/View')
    {
        window.location.href="/BillingApplication/navMenu/purchase/editPurchasePage?purchaseHistoryId="+selectedValue;
    }
    else if(selectedText=="Add stock")
    {
        window.location.href="/BillingApplication/navMenu/stocks/insertStockPage.php?purchaseId="+selectedValue;
    }
    //alert("Selected Text: " + selectedText + " Value: " + selectedValue);
}