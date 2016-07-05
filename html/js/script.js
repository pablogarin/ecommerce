(function(){
    console.log("Inicializando Sitio...");
    // var url = "http://follert.neversaynever.cl"
    var title = $("title").text();
    $("body").on("click","#cart-container a[href='#cart']",function(evt){
        evt.preventDefault();
        $("#cart").toggle();
    });
})();
