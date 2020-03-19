$(document).ready(function() {

    if ($(this).scrollTop() > 120)
    {
        $(document.getElementById('menub')).fadeIn('fast');
    } else {
        $(document.getElementById('menub')).hide();
    }

    $(window).scroll(function ()
    {
        if ($(this).scrollTop() > 140)
        {
            $(document.getElementById('menub')).fadeIn('fast');
        }
        else{
            $(document.getElementById('menub')).hide();
        }
    });

    $('.fancybox').fancybox({
        autoSize: true,
        fitToView: true,
        closeClick: false,
        openEffect: 'none',
        closeEffect: 'none',
        padding: 4,
        helpers: {
            overlay: {
              locked: false
            }
        }
    });


    $('.fancybox-gallery').fancybox({
        showCloseButton: false,
        padding: 5,
        width: '450',
        autoSize: false,
    });  

});

$(document).ready(function() {

    var owl = $('.owl-carousel');

    owl.owlCarousel({
        items: 4,
        loop: false,
        margin: 10,
        autoplay: true,
        autoplayTimeout: 1000,
        autoplayHoverPause: true,
        responsiveClass:true,
        nav: false,
        dots: false,
        responsive: {
          0: {
            items: 2,
            nav: false,
            dots: false,
          },
          600: {
            items: 3,
            nav: false,
            dots: false,
          },
          1000: {
            items: 4,
            nav: false,
            loop: false,
            margin: 10,
            dots: false,
          }
        }
    });

    $('a.owl-carousel-product-left').click(function(event){
        event.preventDefault();
        owl.trigger('prev.owl.carousel', [300]);
    })
    
    $("a.owl-carousel-product-right").click(function(event){
        event.preventDefault();
        owl.trigger('next.owl.carousel', [300]);
    });
    calculoEnvioGratis();
    
});
function calculoEnvioGratis(argument)
{
    var inputEnvioMinimo = $("input#freeShipping");
    if (inputEnvioMinimo.length)
    {
        var valorMinimoCompraEnvio = parseFloat(inputEnvioMinimo.val());
        var valorTotalVenta = parseFloat($.trim($("#total").text()));
        var costoEnvio = '';
        if (valorMinimoCompraEnvio <= valorTotalVenta)
        {
            costoEnvio = 'ENVIO GRATIS ¡por superar el minino coste para el envio!';
            $("div#shipping_cost").html(costoEnvio);
            $("input[name='shipping_cost']").html(0);
        }
    }
}
function increaseQty(event, elemento) {
    event.preventDefault();
    var inputCantidad = $("#qty");
    var cantidadActual = inputCantidad.val();
    if ($.isNumeric(cantidadActual)) {
        cantidadActual = parseInt(cantidadActual);
        inputCantidad.val(cantidadActual + 1);
    }
    else{
        inputCantidad.val('1');
    }
}
function decreaseQty(event, elemento) {
    event.preventDefault();
    var inputCantidad = $("#qty");
    var cantidadActual = inputCantidad.val();
    if ($.isNumeric(cantidadActual)) {
        cantidadActual = parseInt(cantidadActual);
        if (cantidadActual > 1) {
            inputCantidad.val(cantidadActual - 1);
        }
    }
    else{
        inputCantidad.val('1');
    }
}
