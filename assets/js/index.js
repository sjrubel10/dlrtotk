$(document).ready(function(){

    $("#buySellButtonHolder").on("click", ".getBtnType", function () {
        // $("#newCardHolder").empty();
        let clickedId = $(this).attr('id');
        let type = $("#"+clickedId).text().trim();
        let buySellForm = get_money_exchange_form( type );
        $("#buySellCardHolder").html( buySellForm );
    });
    $("body").on("click", ".submitBuySell", function () {
    // $("#transaction-form").submit(function(event) {
        event.preventDefault();
        var formData = $("#transaction-form").serialize();
        console.log( formData );
        $.ajax({
            type: "POST",
            url: 'main/jsvalidation/buysellvalidate.php',
            data: formData,
            success: function(response) {
                console.log( response );
                alert(response['success']);
                // $("#response").html(response);
            }
        });
    });


});