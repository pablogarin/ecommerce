// variables
var counts = {};
CKEDITOR.editorConfig = function( config ) {
    config.language = 'es';
    config.uiColor = '#F7B42C';
    config.height = 300;
    config.toolbarCanCollapse = true;
};

var indexNew = 0;
// metodos, eventos y funciones
$(document).on("ready",setEvents);
function setEvents(){
    console.log("setEvents...");
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
    $("input.date").datepicker({dateFormat:'yy-mm-dd',yearRange: "-30:+0",changeYear: true});
    $("input[accept='image/*']").off("change");
    $("input[accept='image/*']").on("change",function(evt){
        console.log('uploading photo...');
        var self = this;
        var form = new FormData();
        form.append('file',this.files[0]);
        $(self).parents('div.thumb-loader:first').find('.thumb-container .loading').show();
        $.ajax({
            url     : '/ajax/uploadPhoto.php',
            data    : form,
            type    : 'POST',
            async   : false,
            success : function (data) {
                var imgTag = $(self).parents('div.thumb-loader:first').find('.thumb-container img');
                imgTag.attr("src",("/assets/"+data.name)).css({'height':'auto'});
                var imgTag = $(self).parents('div.thumb-loader:first').find('input[type=hidden]').val(data.name);
            },
            cache   : false,
            contentType: false,
            processData: false
        }).done(function(){
            $(self).parents('div.thumb-loader:first').find('.thumb-container .loading').hide();
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
(function(){
    $("body").on("click",".btn-edit",function(){
        e.preventDefault();
        alert("eeee");
    });
    try{
        $("textarea.ckeditor").each(function(k,v){ 
            var name = v.name; 
            CKEDITOR.replace(name); 
        });
    } catch(e){
        console.log(e);
    }
    $(window).on('scroll',function(e){
        if( window.pageYOffset > 35 ){
            $(".form .toolbox").addClass("fixed");
        } else {
            $(".form .toolbox").removeClass("fixed");
        }
    });
})();
