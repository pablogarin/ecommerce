// variables
var counts = {};
var opts = {
      lines: 13 // The number of lines to draw
      , length: 14 // The length of each line
      , width: 7 // The line thickness
      , radius: 14 // The radius of the inner circle
      , scale: 1 // Scales overall size of the spinner
      , corners: 1 // Corner roundness (0..1)
      , color: '#000' // #rgb or #rrggbb or array of colors
      , opacity: 0.25 // Opacity of the lines
      , rotate: 0 // The rotation offset
      , direction: 1 // 1: clockwise, -1: counterclockwise
      , speed: 1 // Rounds per second
      , trail: 60 // Afterglow percentage
      , fps: 20 // Frames per second when using setTimeout() as a fallback for CSS
      , zIndex: 2e9 // The z-index (defaults to 2000000000)
      , className: 'spinner' // The CSS class to assign to the spinner
      , top: '50%' // Top position relative to parent
      , left: '50%' // Left position relative to parent
      , shadow: false // Whether to render a shadow
      , hwaccel: false // Whether to use hardware acceleration
      , position: 'relative' // Element positioning
}
var spinner = new Spinner(opts);

var indexNew = 0;
// metodos, eventos y funciones
$(document).on("ready",setEvents);
function setEvents(){
    $('[data-toggle="tooltip"]').tooltip()
    console.log("setEvents...");
    $("select[name='orden']").off("change");
    $("select[name='orden']").on("change", function(){
        $(this).parents("form:first").submit();
    });
    $(".item-galeria").off("click");
    $(".item-galeria img").on("click",function(evt){
        var target = $(this).siblings(".upload-galery:first");
        $(target).click();
    });
    $(".upload-galery").off("change");
    $(".upload-galery").on("change",function(){
        var self = this;
        var form = new FormData();
        form.append('file',this.files[0]);
        $.ajax({
            url     : '/ajax/uploadPhoto.php',
            data    : form,
            type    : 'POST',
            async   : false,
            success : function (data) {
                var img = $(self).siblings("img:first");
                $(img).attr("src","/assets/"+data.name);
                $(self).siblings("input[type=hidden]").val(data.name);
            },
            cache   : false,
            contentType: false,
            processData: false
        }).done(function(){
        });
    });
    $("#add-galeria").off("click");
    $("#add-galeria").on("click",function(evt){
        evt.preventDefault();

        var row = document.createElement("tr");
        var fotoTd = document.createElement("td");

        var foto = document.createElement("img");
        foto.height="60";
        foto.src="/assets/noPhoto-icon.png";
        foto.addEventListener("click",function(){
            var target = $(this).siblings(".upload-galery:first");
            $(target).click();
        },false);

        var fotoInput = document.createElement("input");
        fotoInput.type = "hidden";
        fotoInput.name = "galeria[new]["+indexNew+"][foto]";

        var fotoUpload = document.createElement("input");
        fotoUpload.type = "file";
        fotoUpload.className = "upload-galery";
        fotoUpload.addEventListener("change",function(){
            var self = this;
            var form = new FormData();
            form.append('file',this.files[0]);
            $.ajax({
                url     : '/ajax/uploadPhoto.php',
                data    : form,
                type    : 'POST',
                async   : false,
                success : function (data) {
                    var img = $(self).siblings("img:first");
                    $(img).attr("src","/assets/"+data.name);
                    $(self).siblings("input[type=hidden]").val(data.name);
                },
                cache   : false,
                contentType: false,
                processData: false
            }).done(function(){
            });
        },false);

        fotoTd.appendChild(foto);
        fotoTd.appendChild(fotoInput);
        fotoTd.appendChild(fotoUpload);

        var ordenTd = document.createElement("td");
        var orden = document.createElement("input");
        orden.type="text";
        orden.name="galeria[new]["+indexNew+"][orden]";

        ordenTd.appendChild(orden);
        var actions = document.createElement("td");

        row.appendChild(fotoTd);
        row.appendChild(ordenTd);
        row.appendChild(actions);
        $(row).insertBefore($(this).parents("tr:first"));
        indexNew++;
    });
    $("input.date").datepicker({
        dateFormat:"d 'de' MM 'de' yy",
        yearRange: "-30:+0",
        changeYear: true
    });
    $("input.date").each(function(k,v){
        //console.log(this.value === "");
        if( this.value === "" ){
            $(this).datepicker("setDate", new Date() );
        } else {
            this.value = (this.value).substr(0,10).replace(/-/g,'\/');;
            console.log(new Date(this.value));
            $(this).datepicker("setDate", new Date(this.value) );
        }
    });
    $("input[accept='image/*']").off("change");
    $("input[accept='image/*']").on("change",function(evt){
        console.log('uploading photo...');
        var self = this;
        var form = new FormData();
        form.append('file',this.files[0]);
        $(self).parents('div.form-group:first').find('.thumb-container img').attr("src", "");
        $(self).parents('div.form-group:first').find('.thumb-container img').attr("alt", "Cargando...");
        showSpinner();
        $.ajax({
            url     : '/ajax/uploadPhoto.php',
            data    : form,
            type    : 'POST',
            async   : false,
            success : function (data) {
                $(self).parents('div.form-group:first').find('.thumb-container img').attr("alt", data.name);
                $(self).parents('div.form-group:first').find('.thumb-container img').attr("src", data.filePath);
                /*
                var imgTag = $(self).parents('div.thumb-loader:first').find('.thumb-container img');
                imgTag.attr("src",("/assets/"+data.name)).css({'height':'auto'});
                var imgTag = $(self).parents('div.thumb-loader:first').find('input[type=hidden]').val(data.name);
                //*/
            },
            cache   : false,
            contentType: false,
            processData: false
        }).done(function(){
            showSpinner();
        });
    });
    $("#add-banner").off("click");
    $("#add-banner").on("click",function(e){
        e.preventDefault();
        var table = $("table#banners");
        var row = document.createElement('tr');
        var td = document.createElement('td');
        var td2 = document.createElement('td');

        td.appendChild(getImageLoader('banners',true));

        var button = document.createElement('button');
        button.className = "btn btn-danger";
        button.appendChild(document.createTextNode("ELIMINAR"));
        $(button).on("click",function(e){
            e.preventDefault();
            $(this).parents("tr:first").remove();
        })
        td2.appendChild(button);

        row.appendChild(td);
        row.appendChild(td2);

        table.append(row);
        setEvents();
    });
    $("#add-frase").off("click");
    $("#add-frase").on("click",function(e){
        e.preventDefault();
        var table = $("table#frases");
        var row = document.createElement('tr');
        var td = document.createElement('td');
        var td2 = document.createElement('td');

        var input = document.createElement("textarea");
        if( typeof counts['frases'] === 'undefined' ){
            counts['frases'] = 0;
        } else {
            counts['frases']++;
        }
        input.name="frases[nuevo]["+counts['frases']+"]";
        input.className = "ckeditor";
        td.appendChild(input);

        var button = document.createElement('button');
        button.className = "btn btn-danger";
        button.appendChild(document.createTextNode("ELIMINAR"));
        $(button).on("click",function(e){
            e.preventDefault();
            $(this).parents("tr:first").remove();
        })
        td2.appendChild(button);

        row.appendChild(td);
        row.appendChild(td2);

        table.append(row);
        CKEDITOR.replace(input.name);
        setEvents();

    });
    $(".edit-cliente").off("click");
    $(".edit-cliente").on("click", function(evt){
        var id = $(this).attr("data-rel");
        $("#form-cliente").load("/admin/home?cliente="+id+" #form-cliente > *",null,function(data){
            $("#form-cliente").modal('show');
            setEvents();
        });
    });
    $(".imageupload").off("change");
    $(".imageupload").on("change",function(evt){
        var target = $(this).attr("data-rel");
        var form = new FormData();
        form.append('file',this.files[0]);
        $.ajax({
            url     : '/ajax/uploadPhoto.php',
            data    : form,
            type    : 'POST',
            async   : false,
            success : function (data) {
                $(target).val(data.name);
                $($(target).siblings("img")).attr("src","/assets/"+data.name)
            },
            cache   : false,
            contentType: false,
            processData: false
        });
    });
    $("a[href='#edit-banners']").off("click");
    $("a[href='#edit-banners']").on("click", function(e) {
        e.preventDefault();
        $("#banners.modal").modal();
    });
    $(".upload-image").off("click");
    $(".upload-image").on("click", function(e) {
        e.preventDefault();
        var self = this;
        var target = $(self).attr("data-rel");
        var dom = $("input[type='file'][name='upload["+target+"]']");
        dom.trigger("click");
        dom.off("change");
        dom.on("change", function(se){
            se.preventDefault();
            var form = new FormData();
            form.append('file',this.files[0]);
            showSpinner();
            $.ajax({
                url     : '/ajax/uploadPhoto.php',
                data    : form,
                type    : 'POST',
                async   : false,
                success : function (data) {
                    $("input[name='banner["+target+"][imagen]']").val(data.name);
                    $("img[data-rel='"+target+"']").attr("src","/assets/tmp/"+data.name)
                    showSpinner();
                },
                cache   : false,
                contentType: false,
                processData: false
            });
        });
    });
    $(".delete-image").off("click");
    $(".delete-image").on("click", function(e) {
        e.preventDefault();
        var target = $(this).attr("data-rel");
        $("[type='text'][name*='banner["+target+"]']").val("");
        $("input[name='banner["+target+"][imagen]']").val("DELETE");
        $("img[data-rel='"+target+"']").attr("src","");
    });
    $("#grabar-banners").off("click");
    $("#grabar-banners").on("click", function(evt) {
        evt.preventDefault();
        var form = $("form");
        var data = {};
        $("input[name*='banner[']").each(function(k, v){
            data[v.name] = v.value;
        });
        data['grabar-banners'] = true;
        console.log(data);
        showSpinner("Grabando&hellip;");
        $.ajax({
            url     : "/admin/home",
            data    : data,
            type    : 'POST',
            success : function( data ){
                if( data.ok ){
                    showSpinner();
                    $("#banners.modal").modal("hide");
                    window.location.reload();
                }
            }
        });
    });
    $("#slider-home").slick({
        autoplay        : true,
        autoplaySpeed   : 5000,
        fade            : true,
        cssEase         : 'linear'
    });
}
function getImageLoader(name,many){
    if( typeof counts[name] === 'undefined' ){
        counts[name] = 0;
    } else {
        counts[name]++;
    }
    var foto  = document.createElement("div");
    foto.className = "thumb-loader";
    var thumbContainer = document.createElement("div");
    thumbContainer.className = "thumb-container";
    var img = document.createElement('img');
    img.className = "thumb-foto";
    thumbContainer.appendChild(img);
    var loading = document.createElement("span");
    loading.className = "loading";
    $(loading).html("<i class='fa fa-spinner fa-spin'></i>");
    thumbContainer.appendChild(loading);
    foto.appendChild(thumbContainer);
    var hiddenInput = document.createElement('input');
    hiddenInput.type = "hidden";
    if(many){
        hiddenInput.name = name+"["+counts[name]+"]";
    } else {
        hiddenInput.name = name;
    }
    foto.appendChild(hiddenInput);
    // <button class="btn btn-primary" onclick="$('input[name=highlights-foto1]').click();return false;"><i class="fa fa-upload"></i> Seleccionar...</button>
    var button = document.createElement('button');
    button.className = "btn btn-primary";
    button.setAttribute("onclick","$('input[name=foto"+name+counts[name]+"').click();return false;");
    $(button).html('<i class="fa fa-upload"></i> Seleccionar...');
    foto.appendChild(button);
    // <input type="file" name="highlights-foto1" class="hidden" accept="image/*"/>
    var fileInput = document.createElement('input');
    fileInput.type = "file";
    fileInput.accept = "image/*";
    fileInput.className = "hidden";
    fileInput.name = 'foto'+name+counts[name];
    foto.appendChild(fileInput);
    return foto;
}
function load(url,target,callback){
    if( typeof callback !== 'undefined' ){
        console.log(url+" "+target+">*");
        $(target).load(url+" "+target+">*",function(){ callback(); });
    } else {
        $(target).load(url+" "+target+">*");
    }
}
var loading = false;
function showSpinner(message = "Cargando&hellip;") {
    var load = $("#loading");
    if( !loading ){
        load.find("p.message").html(message);
        load.modal();
        spinner.spin(load.find(".modal-body p.message")[0]);
    } else {
        load.modal('hide');
        spinner.stop();
    }
    loading = !loading;
}
function changeFoto(self, target){
    var form = new FormData();
    form.append('file',self.files[0]);
    $(self).siblings("a:first").find("img").attr("src", "");
    showSpinner();
    $.ajax({
        url     : '/ajax/uploadPhoto.php',
        data    : form,
        type    : 'POST',
        async   : false,
        success : function (data) {
            $(self).siblings("a:first").find("img").attr("src", data.filePath);
            $("[name='"+target+"']").val(data.name);
        },
        cache   : false,
        contentType: false,
        processData: false
    }).done(function(){
        showSpinner();
    });
}
(function($){
    $("body").on("click",".btn-edit",function(){
        e.preventDefault();
        alert("eeee");
    });
    try{
        $("textarea.ckeditor").each(function(k,v){ 
            var name = v.name; 
            if( $(v).hasClass("inline") )
                CKEDITOR.inline(name); 
            else
                CKEDITOR.replace(name); 
        });
    } catch(e){
        console.log(e);
    }
    $(window).on('scroll',function(e){
        if( window.pageYOffset > 35 ){
            $(".form .toolbox").addClass("fixed");
            $(".form").addClass("margin-toolbox");
        } else {
            $(".form .toolbox").removeClass("fixed");
            $(".form").removeClass("margin-toolbox");
        }
    });
})(jQuery);
