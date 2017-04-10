$(document).ready(function () {

    $("#aboutText").on("hide.bs.collapse", function () {
        $(".btn").html('<span class="glyphicon glyphicon-collapse-down"></span> Open');
    });
    $("#aboutText").on("show.bs.collapse", function () {
        $(".btn").html('<span class="glyphicon glyphicon-collapse-up"></span> Close');
    });

    addUnitPrice();
    $("input.chartQte").on("change paste keyup", changeQte);
    $("span[data-minus^='_']").click(downQte);
    $("span[data-plus^='_']").click(upQte);
    $("span[data-delete^='_']").click(deleteItem);
    $("form.js_cart").submit(addCart);
    $(document).scroll(navFixed);

});

function addCart(e) {
    e.preventDefault();

    $.ajax({
        type: $(this).attr('method'),
        url: $(this).attr('action'),
        data: $(this).serialize()
    }).done(function (msg) {
        $("#results").html(msg.cart);
        $("input.chartQte").on("change paste keyup", changeQte);
        $("span[data-minus^='_']").click(downQte);
        $("span[data-plus^='_']").click(upQte);
        $("span[data-delete^='_']").click(deleteItem);
        addUnitPrice();
        $("#myModal").modal('show');
    }).fail(function (msg) {

        console.log("failed: " + msg);
    });

}

function navFixed() {
    var body = document.body; // For Chrome, Safari and Opera
    //var html = document.documentElement;
    //console.log(body.scrollTop);
    //console.log(html.scrollTop);

    if (0 == body.scrollTop) {
        $("#nav").addClass("CLASE PARA FIJAR");
    } else {
        $("#nav").removeClass("CLASE PARA FIJAR");
    }

}

function deleteItem() {
    var itemId = $(this).attr("data-delete");
    var item = $("tr#item" + $(this).attr("data-delete"))[0];
    $.ajax({
        type: "POST",
        url: "/deleteItemCart",
        data: {item: itemId.substring(1)}
        
    }).done(function (msg) {
        item.remove();
        addUnitPrice();
    }).fail(function (msg) {
        console.log("failed: " + msg.message);
    });
}

function changeQte() {

    if (isNaN($(this).val()) || $(this).val() == 0 || parseFloat($(this).val()) > 99) {
        $(this).val(1);
    }
    
    var itemId = $(this).attr("data-total").substring(1);
    var qte = $(this).val();
    console.log(itemId);
    console.log(qte);
    $.ajax({
        type: "POST",
        url: "/updateQteCart",
        data: {item: itemId, qte: qte}
        
    }).done(function (msg) {
        console.log("ok: " + msg.message);
    }).fail(function (msg) {
        console.log("failed: " + msg.message);
    });
    
    var totalPrice = parseFloat($(this).val()) * parseFloat($("#price" + $(this).attr("data-total")).val());
    $("#total" + $(this).attr("data-total")).val(totalPrice.toFixed(2));

    calculateTaxes();

}

function downQte(e) {

    var inpuQte = $("#qte" + e.target.getAttribute("data-minus"));
    if (isNaN(parseInt(inpuQte[0].value)) || parseInt(inpuQte[0].value) < 2) {
        return;
    }

    inpuQte[0].value = parseInt(inpuQte[0].value) - 1;
    inpuQte.trigger("change");
}

function upQte(e) {

    var inpuQte = $("#qte" + e.target.getAttribute("data-plus"));
    if (isNaN(parseInt(inpuQte[0].value)) || parseInt(inpuQte[0].value) > 99) {
        return;
    }

    inpuQte[0].value = parseInt(inpuQte[0].value) + 1;
    inpuQte.trigger("change");
}

function addUnitPrice() {

    $("input.chartQte").each(function () {
        var totalPrice = parseFloat($(this).val()) * parseFloat($("#price" + $(this).attr("data-total")).val());
        $("#total" + $(this).attr("data-total")).val(totalPrice.toFixed(2));
    });

    calculateTaxes();

}

function calculateTaxes() {

    var priceBeforeTx = 0;
    $("input.orderTotal").each(function () {
        priceBeforeTx = priceBeforeTx + parseFloat($(this).val());
    });
    var tps = parseFloat(priceBeforeTx) * 0.05;
    var tvq = parseFloat(priceBeforeTx) * 0.0975;
    $("#tps_total").val(tps.toFixed(2));
    $("#tvq_total").val(tvq.toFixed(2));

    addTotalPrice();

}

function addTotalPrice() {

    var totalPrice = 0;
    $("input.chartTotal").each(function () {
        totalPrice = totalPrice + parseFloat($(this).val());
    });

    $("#total_total").val(totalPrice.toFixed(2));

}