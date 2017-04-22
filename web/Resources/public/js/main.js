var is_postal_code_valide = false;
var current_price_delivery = 0;
var DELIVERY_MAX_PRICE = 10;
var DELIVERY_MIN_PRICE = 5;
var MIN_FREE_DELIVERY = 60;
var CP_RIVIERE_DES_PRAIRIES = "Riviere-des-Prairies—Pointe-aux-Trembles";
var CP_ANJOU = "Anjou";
var CP_MONTREAL_NORD = "Montréal-Nord";
var CP_ST_LEONARD = "Saint Leonard";
var CP_MONTREAL_EAST = "Montreal East";
var CP_MERCIER_HOCHELAGA_MAISONNEUVE = "Mercier-Hochelaga-Maisonneuve";
var CP_ROSEMONT_PETIT_PATRIE = "Rosemont-La Petite-Patrie";
var CP_VILLE_MARIE = "Ville-Marie";
var CP_PLATEAU = "Le Plateau-Mont-Royal";
var CP_VILLERAY = "Villeray—Saint-Michel—Parc-Extension";
var CP_AHUNTSIC = "Ahuntsic-Cartierville";
var CP_ST_LAURENT = "Saint-Laurent";
var CP_OUTREMONT = "Outremont";
var CP_CDN_NDG = "Côte-Des-Neiges—Notre-Dame-De-Grâce";
var CP_MOUNT_ROYAL = "Mount Royal";
var CP_SOUTH_WEST = "Southwest";
var CP_LASALLE = "Lasalle";
var CP_VERDUN = "Verdun";
var CP_LACHINE = "Lachine";
var CP_PIERREFONDS_ROXBORO = "Pierrefonds-Roxboro";
var CP_ILE_BIZARD = "L'Île-Bizard—Sainte-Geneviève";
var CP_COTE_ST_LUC = "Côte Saint-Luc";
var CP_HAMPSTEAD = "Hampstead";
var CP_MONTREAL_WEST = "Montreal-West";
var CP_WESTMOUNT = "Westmount";
var CP_DORVAL = "Dorval";
var CP_POINTE_CLAIRE = "Pointe-Claire";
var CP_DOLLARD_DES_ORMEAUX = "Dollard-Des Ormeaux";
var CP_BEACONSFIELD = "Beaconsfield";
var CP_SENNEVILLE = "Senneville";
var CP_BAIE_D_URFE = "Baie-D'Urfe";
var CP_STE_ANNE = "Sainte-Anne-de-Bellevue";
var localityArray = [
    CP_RIVIERE_DES_PRAIRIES,
    CP_ANJOU,
    CP_MONTREAL_NORD,
    CP_ST_LEONARD,
    CP_MONTREAL_EAST,
    CP_MERCIER_HOCHELAGA_MAISONNEUVE,
    CP_ROSEMONT_PETIT_PATRIE,
    CP_VILLE_MARIE,
    CP_PLATEAU,
    CP_VILLERAY,
    CP_AHUNTSIC,
    CP_ST_LAURENT,
    CP_OUTREMONT,
    CP_CDN_NDG,
    CP_MOUNT_ROYAL,
    CP_SOUTH_WEST,
    CP_LASALLE,
    CP_VERDUN,
    CP_LACHINE,
    CP_PIERREFONDS_ROXBORO,
    CP_ILE_BIZARD,
    CP_COTE_ST_LUC,
    CP_HAMPSTEAD,
    CP_MONTREAL_WEST,
    CP_WESTMOUNT,
    CP_DORVAL,
    CP_POINTE_CLAIRE,
    CP_DOLLARD_DES_ORMEAUX,
    CP_BEACONSFIELD,
    CP_SENNEVILLE,
    CP_BAIE_D_URFE,
    CP_STE_ANNE
];
var prices = [];
prices[CP_RIVIERE_DES_PRAIRIES] = DELIVERY_MAX_PRICE;
prices[CP_ANJOU] = DELIVERY_MAX_PRICE;
prices[CP_MONTREAL_NORD] = DELIVERY_MAX_PRICE;
prices[CP_ST_LEONARD] = DELIVERY_MAX_PRICE;
prices[CP_MONTREAL_EAST] = DELIVERY_MAX_PRICE;
prices[CP_MERCIER_HOCHELAGA_MAISONNEUVE] = DELIVERY_MAX_PRICE;
prices[CP_MERCIER_HOCHELAGA_MAISONNEUVE] = DELIVERY_MAX_PRICE;
prices[CP_ROSEMONT_PETIT_PATRIE] = DELIVERY_MAX_PRICE;
prices[CP_VILLE_MARIE] = DELIVERY_MAX_PRICE;
prices[CP_PLATEAU] = DELIVERY_MAX_PRICE;
prices[CP_VILLERAY] = DELIVERY_MAX_PRICE;
prices[CP_AHUNTSIC] = DELIVERY_MAX_PRICE;
prices[CP_ILE_BIZARD] = DELIVERY_MAX_PRICE;
prices[CP_SENNEVILLE] = DELIVERY_MAX_PRICE;
prices[CP_BAIE_D_URFE] = DELIVERY_MAX_PRICE;
prices[CP_STE_ANNE] = DELIVERY_MAX_PRICE;
prices[CP_ST_LAURENT] = DELIVERY_MIN_PRICE;
prices[CP_OUTREMONT] = DELIVERY_MIN_PRICE;
prices[CP_CDN_NDG] = DELIVERY_MIN_PRICE;
prices[CP_MOUNT_ROYAL] = DELIVERY_MIN_PRICE;
prices[CP_SOUTH_WEST] = DELIVERY_MIN_PRICE;
prices[CP_LASALLE] = DELIVERY_MIN_PRICE;
prices[CP_VERDUN] = DELIVERY_MIN_PRICE;
prices[CP_LACHINE] = DELIVERY_MIN_PRICE;
prices[CP_PIERREFONDS_ROXBORO] = DELIVERY_MIN_PRICE;
prices[CP_COTE_ST_LUC] = DELIVERY_MIN_PRICE;
prices[CP_HAMPSTEAD] = DELIVERY_MIN_PRICE;
prices[CP_MONTREAL_WEST] = DELIVERY_MIN_PRICE;
prices[CP_WESTMOUNT] = DELIVERY_MIN_PRICE;
prices[CP_DORVAL] = DELIVERY_MIN_PRICE;
prices[CP_POINTE_CLAIRE] = DELIVERY_MIN_PRICE;
prices[CP_DOLLARD_DES_ORMEAUX] = DELIVERY_MIN_PRICE;
prices[CP_BEACONSFIELD] = DELIVERY_MIN_PRICE;
$(document).ready(function () {

    $("#aboutText").on("hide.bs.collapse", function () {
        $(".btn").html('<span class="glyphicon glyphicon-collapse-down"></span> Open');
    });
    $("#aboutText").on("show.bs.collapse", function () {
        $(".btn").html('<span class="glyphicon glyphicon-collapse-up"></span> Close');
    });
    addUnitPrice();
    addDeliveryPrice();
    $("input.chartQte").on("change paste keyup", changeQte);
    $("span[data-minus^='_']").click(downQte);
    $("span[data-plus^='_']").click(upQte);
    $("span[data-delete^='_']").click(deleteItem);
    $("form.js_cart").submit(addCart);
    $(document).scroll(navFixed);
    $('input[type=radio][name=shipping]').change(hideOrShowPCInput);
    $("form#order_form").submit(validateOrder);
    $("#btn_newsletter").click(addToNewsletter);
});

function addToNewsletter(e){
    e.preventDefault();
    
    $(".js_invalid_mail").addClass('hidden');
    $(".js_add_newsletter_ok").addClass('hidden');
    $(".js_already_newsletter").addClass('hidden');
    $(".js_problem_newslleter").addClass('hidden');
    var email_newsletter = $("#newsletter").val();
    if (!email_newsletter.match(/^.{2,30}@.{2,30}\.[a-z]{2,4}$/)) {
        $(".js_invalid_mail").removeClass('hidden');
        $("#newsletter").addClass("error");
        $("#newsletter").focus();
        $("#modal_newsletter").modal("show");
        return;
    }
    
    $.ajax({
        type: "POST",
        url: "/addToNewsletter",
        data: {email: email_newsletter}

    }).done(function (msg) {
        if ("OK" == msg.message) {
            $(".js_add_newsletter_ok").removeClass('hidden');
        } else if ("ALREADY_EXISTS" == msg.message) {
            $(".js_already_newsletter").removeClass('hidden');
        }
    }).fail(function (msg) {
        $(".js_problem_newslleter").removeClass('hidden');
    });
    $("#modal_newsletter").modal("show");
}

function validateOrder(e) {
    e.preventDefault();
    
    if (validateOrderForm()) {
        $("form#order_form").off('submit',validateOrder);
        $("form#order_form").submit();
    }
    
}

function validateOrderForm() {
    var validator = 0;

    //NAME
    if (!$("#name").val().match(/^[a-zA-ZÀ-ÿ\s\’-]{1,29}$/)) {
        $("#name").addClass("error");
        $("#name").focus();
        validator += 1;
    }
    //email
    if (!$("#email").val().match(/^.{2,30}@.{2,30}\.[a-z]{2,4}$/)) {
        $("#email").addClass("error");
        $("#email").focus();
        validator += 1;
    }//phone
    if (!$("#tel").val().match(/^(\+1)? ?\(?[0-9]{3}\)? ?-?[0-9]{3} ?-?[0-9]{2} ?-?[0-9]{2}$/)) {
        $("#tel").addClass("error");
        $("#tel").focus();
        validator += 1;
    }

    if ($('input[type=radio][name=shipping]:checked').val() == 1) {

        if (!$("#address").val().match(/^[a-zA-Z0-9À-ÿ\s\’-]{1,80}$/)) {
            $("#address").addClass("error");
            $("#address").focus();
            validator += 1;
        }

        if (!$("#postalCode").val().match(/^(h|H){1}[0-9]{1}([a-z]|[A-Z]){1}\s{0,1}[0-9]{1}([a-z]|[A-Z])[0-9]{1}$/)) {
            $("#pc").addClass("error");
            $("#pc").focus();
            $("#error_zip_code").modal('show');
            validator += 1;
        }
    }

    if (validator == 0) {
        return true;
    }
    return false;
}

function selectCodePostal() {

    var pc_input = document.getElementById('pc');
    if (pc_input.value.match(/^(h|H){1}[0-9]{1}([a-z]|[A-Z]){1}\s{0,1}[0-9]{1}([a-z]|[A-Z])[0-9]{1}$/)) {
        if (false === is_postal_code_valide) {
            $.ajax({
                url: "http://maps.googleapis.com/maps/api/geocode/json?address=" + this.value + "&language=en",
                type: 'get',
                async: true,
                cache: false,
                success: function (return_data) {

                    if (return_data.status == "ZERO_RESULTS") {
                        //modal code postale introuvable
                        $('#error_zip_code').modal("show");
                        return;
                    } else {
                        var components = return_data.results[0].address_components;
                        for (var i = 0, b = components.length; i < b; i++) {
                            if (components[i].types.indexOf("sublocality") > -1) {
                                var price = determinePrice(components[i].long_name);
                                $("#deli_total").val(price);
                                $("#postalCode").val(pc_input.value.toUpperCase());
                                calculateTaxes();
                                return;
                            }
                        }
                        for (var j = 0, c = components.length; j < c; j++) {
                            if (components[j].types.indexOf("locality") > -1) {
                                var price = determinePrice(components[j].long_name);
                                $("#deli_total").val(price);
                                $("#postalCode").val(pc_input.value.toUpperCase());
                                calculateTaxes();
                                return;
                            }
                        }
                    }
                },
                error: function (XMLHttpRequest, textStatus, errorThrown) {
                    $("#postalCode").val('');
                    $("#deli_total").val(0);
                    console.log(XMLHttpRequest);
                    console.log(textStatus);
                    console.log(errorThrown);
                }
            });
        } else {
            var totalPrice = 0;
            $("input.bfTaxes").each(function () {
                totalPrice = totalPrice + parseFloat($(this).val());
            });

            if (totalPrice > MIN_FREE_DELIVERY) {
                console.log('hola gratis')
                var zero = 0;
                $("#deli_total").val(zero.toFixed(2));
            } else {
                console.log('hola 5 dolares');
                $("#deli_total").val(current_price_delivery);
            }
            calculateTaxes();
        }
    } else if (pc_input.value.match(/^([a-z]|[A-Z]){1}[0-9]{1}([a-z]|[A-Z]){1}\s{0,1}[0-9]{1}([a-z]|[A-Z])[0-9]{1}$/)) {
        //modal desole livrasion juast a montreal
        $("#postalCode").val('');
        $("#deli_total").val(0);
        calculateTaxes();
        is_postal_code_valide = false;
        current_price_delivery = 0;
    } else {
        //affichar nada campo del valor
        //en el estilo mostrar que esta mal
        is_postal_code_valide = false;
        current_price_delivery = 0;
        calculateTaxes();
        $("#postalCode").val('');
        $("#deli_total").val(0);
    }

}

function determinePrice(locality) {

    if (localityArray.indexOf(locality) > -1) {
        var totalPrice = 0;
        $("input.bfTaxes").each(function () {
            totalPrice = totalPrice + parseFloat($(this).val());
        });
        is_postal_code_valide = true;
        current_price_delivery = prices[locality].toFixed(2);
        if (totalPrice > MIN_FREE_DELIVERY) {
            var zero = 0;
            return zero.toFixed(2);
        }
        return prices[locality];
    } else {
        is_postal_code_valide = false;
        current_price_delivery = 0;
        return false;
    }

}

function hideOrShowPCInput() {
    if (this.value == 1) {
        $('.js_hidde_show').removeClass('hiddenCP');
        $('.js_hidde_show').addClass('showCP');
        $('.js_form_hidde_show').removeClass('hidden');
        $('.js_form_hidde_show').addClass('show');
        $("#pc").on("keyup", selectCodePostal);
    } else {
        $('.js_hidde_show').removeClass('showCP');
        $('.js_hidde_show').addClass('hiddenCP');
        $('.js_form_hidde_show').removeClass('show');
        $('.js_form_hidde_show').addClass('hidden');
    }
    addDeliveryPrice();
}

function addCart(e) {
    e.preventDefault();
    $.ajax({
        type: $(this).attr('method'),
        url: $(this).attr('action'),
        data: $(this).serialize()
    }).done(function (msg) {
        $("#cartBody").html(msg.cart.body);
        $("#cartFooter").html(msg.cart.footer);
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

    if (body.scrollTop > 50) {
        $("#nav").addClass("navbar-sticky");
        $("div#home").addClass("hidden");
        $("body").css("padding-top", "130px");
        //setTimeout(paddTop, 500);
        
    } else {
        $("#nav").removeClass("navbar-sticky");
        $("div#home").removeClass("hidden");
        $("body").css("padding-top", "130px");
    }

}

/*function paddTop(){
    $("body").css("padding-top", "59px");
}*/

function deleteItem() {
    var itemId = $(this).attr("data-delete");
    var item = $("tr#item" + $(this).attr("data-delete"))[0];
    $.ajax({
        type: "POST",
        url: "/deleteItemCart",
        data: {item: itemId.substring(1)}

    }).done(function (msg) {
        if ("OK" == msg.message) {
            item.remove();
        } else if ("view" == msg.message) {
            $("#cartBody").html(msg.view.body);
            $("#cartFooter").html(msg.view.footer);
            if ($('input[type=radio][name=shipping]:checked').val() == 0 ||
                    $('input[type=radio][name=shipping]:checked').val() == 1) {
                window.location.href = "/order";
            }
        }
        addDeliveryPrice();
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

    //calculateTaxes();
    addDeliveryPrice();
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

    addDeliveryPrice();

}

function addDeliveryPrice() {

    if ($('input[type=radio][name=shipping]:checked').val() == 0) {
        var totalPrice = 0;
        $("input.bfTaxes").each(function () {
            totalPrice = totalPrice + parseFloat($(this).val());
        });
        var deliveryReduction = -parseFloat(totalPrice) * 0.05;
        $("#deli_total").val(deliveryReduction.toFixed(2));
        calculateTaxes();
        return;
    }

    if ($('input[type=radio][name=shipping]:checked').val() == 1) {
        $("#deli_total").val(parseFloat(0).toFixed(2));
        calculateTaxes();
        selectCodePostal();
        return;
    }
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