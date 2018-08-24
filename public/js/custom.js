/*jslint browser: true*/
/*global $, jQuery, alert*/



//CAPTACION

var direcciones = new Bloodhound({
    datumTokenizer: function (datum) {
        return Bloodhound.tokenizers.whitespace(datum.value);
    },
    queryTokenizer: Bloodhound.tokenizers.whitespace,
    prefetch: {
        url: "/",
        transform: function (response) {
            return $.map(response, function (dir) {
                return {value: 'Id: ' + dir.id + ', Dir: ' + dir.direccion + ', Nro: ' + dir.numero + ', Comuna: ' + dir.comuna_nombre};
            });
        }
    },
    remote: {
        wildcard: '%QUERY',
        url: "/inmuebles/%QUERY",
        transform: function (response) {
            return $.map(response, function (dir) {
                var num=dir.numero==null?'':dir.numero;
                var dpto=dir.departamento==null?'':dir.departamento;
                return {value: dir.direccion + ' ' + num  + ' Dpto '+ dpto +',  ' + dir.comuna_nombre,
                    option: dir.id};
            });
        }
    }
});




$('#i_direccion').typeahead({

    hint: false,
    highlight: true,
    minLength: 1,
    val:'',
    limit: 10
},
        {
            name: 'direcciones',
            display: 'value',
            source: direcciones,
            limit: 20
        });

jQuery('#i_direccion').on('typeahead:selected', function (e, datum) {
 
        swal({   
            title: "Esta seguro que desea utilizar la siguiente dirección?",   
            text: datum.value,   
            type: "warning",   
            showCancelButton: true,   
            confirmButtonColor: "#DD6B55",   
            confirmButtonText: "SI",   
            closeOnConfirm: false 
        }, function(){   
             window.location.href = '/captacion/agregarinmueble/'+$('#idcaptacion').val()+'/'+datum.option; 
        });

   
});


var personas = new Bloodhound({
    datumTokenizer: function (datum) {
        return Bloodhound.tokenizers.whitespace(datum.value);
    },
    queryTokenizer: Bloodhound.tokenizers.whitespace,
    prefetch: {
        url: "/",
        transform: function (response) {
            return $.map(response, function (per) {
                var nom=per.nombre==null?"":per.nombre;
                var ape=per.apellido_paterno==null?"":per.apellido_paterno;
                return {value: per.email + ' , ' + nom + ' ' + ape,
                    option: per.id};
            });
        }
    },
    remote: {
        wildcard: '%QUERY',
        url: "/personas/email/%QUERY",
        transform: function (response) {
            return $.map(response, function (per) {
                var nom=per.nombre==null?"":per.nombre;
                var ape=per.apellido_paterno==null?"":per.apellido_paterno;
                return {value: per.email + ' , ' + nom + ' ' + ape,
                    option: per.id};
            });
        }
    }
});



$('#p_email').typeahead({
    hint: false,
    highlight: true,
    minLength: 1,
    limit: 10
},
        {
            name: 'personas',
            display: 'value',
            source: personas,
            limit: 20
        });



var personas = new Bloodhound({
    datumTokenizer: function (datum) {
        return Bloodhound.tokenizers.whitespace(datum.value);
    },
    queryTokenizer: Bloodhound.tokenizers.whitespace,
    prefetch: {
        url: "/",
        transform: function (response) {
            return $.map(response, function (per) {
                var nom=per.nombre==null?"":per.nombre;
                var ape=per.apellido_paterno==null?"":per.apellido_paterno;
                return {value: per.email + ' , ' + nom + ' ' + ape,
                    option: per.id};
            });
        }
    },
    remote: {
        wildcard: '%QUERY',
        url: "/personas/fono/%QUERY",
        transform: function (response) {
            return $.map(response, function (per) {
                var nom=per.nombre==null?"":per.nombre;
                var ape=per.apellido_paterno==null?"":per.apellido_paterno;
                return {value: per.telefono + ' , ' + nom + ' ' + ape,
                    option: per.id};
            });
        }
    }
});



$('#p_telefono').typeahead({
    hint: false,
    highlight: true,
    minLength: 1,
    limit: 10
},
        {
            name: 'personas',
            display: 'value',
            source: personas,
            limit: 20
        });

jQuery('#p_email').on('typeahead:selected', function (e, datum) {
           swal({   
            title: "Esta seguro que desea utilizar al siguiente propietario?",   
            text: datum.value,   
            type: "warning",   
            showCancelButton: true,   
            confirmButtonColor: "#DD6B55",   
            confirmButtonText: "SI",   
            closeOnConfirm: false 
        }, function(){   
             window.location.href = '/captacion/agregarpersona/'+$('#idcaptacion').val()+'/'+datum.option; 
        });
});



$("#i_id_region").change(function (event) {
    $("#i_id_provincia").empty();
    $("#i_id_comuna").empty();
    $.get("/provincias/" + event.target.value + "", function (response, state) {
        $("#i_id_provincia").append("<option value=''>Seleccione provincia</option>");
        for (i = 0; i < response.length; i++) {
            $("#i_id_provincia").append("<option value='" + response[i].provincia_id + "'>" + response[i].provincia_nombre + "</option>");
        }
    });
});

$("#i_id_provincia").change(function (event) {
    $("#i_id_comuna").empty();
    $.get("/comunas/" + event.target.value + "", function (response, state) {
        $("#i_id_comuna").append("<option value=''>Seleccione comuna</option>");
        for (i = 0; i < response.length; i++) {
            $("#i_id_comuna").append("<option value='" + response[i].comuna_id + "'>" + response[i].comuna_nombre + "</option>");
        }
    });
});

$("#p_id_region").change(function (event) {
    $("#p_id_provincia").empty();
    $("#p_comunas").empty();
    $.get("/provincias/" + event.target.value + "", function (response, state) {
        $("#p_id_provincia").append("<option value=''>Seleccione provincia</option>");
        for (i = 0; i < response.length; i++) {
            $("#p_id_provincia").append("<option value='" + response[i].provincia_id + "'>" + response[i].provincia_nombre + "</option>");
        }
    });
});

$("#p_id_provincia").change(function (event) {
    $("#p_id_comuna").empty();
    $.get("/comunas/" + event.target.value + "", function (response, state) {
        $("#p_id_comuna").append("<option value=''>Seleccione comuna</option>");
        for (i = 0; i < response.length; i++) {
            $("#p_id_comuna").append("<option value='" + response[i].comuna_id + "'>" + response[i].comuna_nombre + "</option>");
        }
    });
});

$("#pe_region").change(function (event) {
    $("#pe_provincia").empty();
    $("#pe_comunas").empty();
    $.get("/provincias/" + event.target.value + "", function (response, state) {
        $("#pe_provincia").append("<option value=''>Seleccione provincia</option>");
        for (i = 0; i < response.length; i++) {
            $("#pe_provincia").append("<option value='" + response[i].provincia_id + "'>" + response[i].provincia_nombre + "</option>");
        }
    });
});

$("#pe_provincia").change(function (event) {
    $("#pe_comuna").empty();
    $.get("/comunas/" + event.target.value + "", function (response, state) {
        $("#pe_comuna").append("<option value=''>Seleccione comuna</option>");
        for (i = 0; i < response.length; i++) {
            $("#pe_comuna").append("<option value='" + response[i].comuna_id + "'>" + response[i].comuna_nombre + "</option>");
        }
    });
});



$("#in_region").change(function (event) {
    $("#in_provincia").empty();
    $("#in_comunas").empty();
    $.get("/provincias/" + event.target.value + "", function (response, state) {
        $("#in_provincia").append("<option value=''>Seleccione provincia</option>");
        for (i = 0; i < response.length; i++) {
            $("#in_provincia").append("<option value='" + response[i].provincia_id + "'>" + response[i].provincia_nombre + "</option>");
        }
    });
});

$("#in_provincia").change(function (event) {
    $("#in_comuna").empty();
    $.get("/comunas/" + event.target.value + "", function (response, state) {
        $("#in_comuna").append("<option value=''>Seleccione comuna</option>");
        for (i = 0; i < response.length; i++) {
            $("#in_comuna").append("<option value='" + response[i].comuna_id + "'>" + response[i].comuna_nombre + "</option>");
        }
    });
});
jQuery('#datepicker-fecha_publicacion').datepicker({
    format: 'dd-mm-yyyy',
    todayHighlight: true,
    autoclose: true, 
    daysOfWeekDisabled: "0",
    daysOfWeekHighlighted: "0",
    language: "es",
    locale: "es",
});

jQuery('#datepicker-fecha_expiracion').datepicker({
    format: 'dd-mm-yyyy',
    todayHighlight: true,
    autoclose: true, 
    daysOfWeekDisabled: "0",
    daysOfWeekHighlighted: "0",
    language: "es",
    locale: "es",
});

jQuery('#datepicker-fecha_contacto1').datepicker({
    format: 'dd-mm-yyyy',
    todayHighlight: true,
    autoclose: true, 
    daysOfWeekDisabled: "0",
    daysOfWeekHighlighted: "0",
    language: "es",
    locale: "es",
});

jQuery('#datepicker-fecha_contacto_e').datepicker({
    format: 'dd-mm-yyyy',
    todayHighlight: true,
    autoclose: true, 
    daysOfWeekDisabled: "0",
    daysOfWeekHighlighted: "0",
    language: "es",
    locale: "es",
});


$("#li_1").click(function (event) {
             $("#li_1").addClass("tab-current");
            $("#li_2").removeClass("tab-current");
            $("#section-iconbox-1").addClass("content-current");
            $("#section-iconbox-2").removeClass("content-current");
            
});
$("#li_4").click(function (event) {
             $("#li_4").addClass("tab-current");
            $("#li_2").removeClass("tab-current");
             $("#section-iconbox-4").addClass("content-current");
            $("#section-iconbox-2").removeClass("content-current");           
});
$("#li_5").click(function (event) {
             $("#li_5").addClass("tab-current");
            $("#li_2").removeClass("tab-current");
            $("#section-iconbox-5").addClass("content-current");
            $("#section-iconbox-2").removeClass("content-current");
            
});



        // Basic
        $('.dropify').dropify();
        // Translated
        $('.dropify-fr').dropify({
            messages: {
                default: 'Glissez-déposez un fichier ici ou cliquez',
                replace: 'Glissez-déposez un fichier ou cliquez pour remplacer',
                remove: 'Supprimer',
                error: 'Désolé, le fichier trop volumineux'
            }
        });
        // Used events
        var drEvent = $('#input-file-events').dropify();
        drEvent.on('dropify.beforeClear', function(event, element) {
            return confirm("Esta seguro de eliminar  \"" + element.file.name + "\" ?");
        });
        drEvent.on('dropify.afterClear', function(event, element) {
            alert('Archivo Borrado');
        });
        drEvent.on('dropify.errors', function(event, element) {
            console.log('Has Errors');
        });
        var drDestroy = $('#input-file-to-destroy').dropify();
        drDestroy = drDestroy.data('dropify')
        $('#toggleDropify').on('click', function(e) {
            e.preventDefault();
            if (drDestroy.isDropified()) {
                drDestroy.destroy();
            } else {
                drDestroy.init();
            }
        })
    


//FIN CAPTACION



//CAPTACION Corredor

var direcciones = new Bloodhound({
    datumTokenizer: function (datum) {
        return Bloodhound.tokenizers.whitespace(datum.value);
    },
    queryTokenizer: Bloodhound.tokenizers.whitespace,
    prefetch: {
        url: "/",
        transform: function (response) {
            return $.map(response, function (dir) {
                return {value: 'Id: ' + dir.id + ', Dir: ' + dir.direccion + ', Nro: ' + dir.numero + ', Comuna: ' + dir.comuna_nombre};
            });
        }
    },
    remote: {
        wildcard: '%QUERY',
        url: "/inmuebles/%QUERY",
        transform: function (response) {
            return $.map(response, function (dir) {
                var num=dir.numero==null?'':dir.numero;
                var dpto=dir.departamento==null?'':dir.departamento;
                return {value: dir.direccion + ' ' + num  + ' Dpto '+ dpto +',  ' + dir.comuna_nombre,
                    option: dir.id};
            });
        }
    }
});




$('#i_direccion_c').typeahead({

    hint: false,
    highlight: true,
    minLength: 1,
    val:'',
    limit: 10
},
        {
            name: 'direcciones',
            display: 'value',
            source: direcciones,
            limit: 20
        });

jQuery('#i_direccion_c').on('typeahead:selected', function (e, datum) {
 
        swal({   
            title: "Esta seguro que desea utilizar la siguiente dirección?",   
            text: datum.value,   
            type: "warning",   
            showCancelButton: true,   
            confirmButtonColor: "#DD6B55",   
            confirmButtonText: "SI",   
            closeOnConfirm: false 
        }, function(){   
             window.location.href = '/corredor/agregarinmueble/'+$('#idcaptacion_c').val()+'/'+datum.option; 
        });

   
});


var personas = new Bloodhound({
    datumTokenizer: function (datum) {
        return Bloodhound.tokenizers.whitespace(datum.value);
    },
    queryTokenizer: Bloodhound.tokenizers.whitespace,
    prefetch: {
        url: "/",
        transform: function (response) {
            return $.map(response, function (per) {
                var nom=per.nombre==null?"":per.nombre;
                var ape=per.apellido_paterno==null?"":per.apellido_paterno;
                return {value: per.email + ' , ' + nom + ' ' + ape,
                    option: per.id};
            });
        }
    },
    remote: {
        wildcard: '%QUERY',
        url: "/personas/email/%QUERY",
        transform: function (response) {
            return $.map(response, function (per) {
                var nom=per.nombre==null?"":per.nombre;
                var ape=per.apellido_paterno==null?"":per.apellido_paterno;
                return {value: per.email + ' , ' + nom + ' ' + ape,
                    option: per.id};
            });
        }
    }
});



$('#p_email_c').typeahead({
    hint: false,
    highlight: true,
    minLength: 1,
    limit: 10
},
        {
            name: 'personas',
            display: 'value',
            source: personas,

            templates: {
                header: '<h4 class="dropdown">Personas</h4>'
            }
        });



var personas = new Bloodhound({
    datumTokenizer: function (datum) {
        return Bloodhound.tokenizers.whitespace(datum.value);
    },
    queryTokenizer: Bloodhound.tokenizers.whitespace,
    prefetch: {
        url: "/",
        transform: function (response) {
            return $.map(response, function (per) {
                var nom=per.nombre==null?"":per.nombre;
                var ape=per.apellido_paterno==null?"":per.apellido_paterno;
                return {value: per.email + ' , ' + nom + ' ' + ape,
                    option: per.id};
            });
        }
    },
    remote: {
        wildcard: '%QUERY',
        url: "/personas/fono/%QUERY",
        transform: function (response) {
            return $.map(response, function (per) {
                var nom=per.nombre==null?"":per.nombre;
                var ape=per.apellido_paterno==null?"":per.apellido_paterno;
                return {value: per.telefono + ' , ' + nom + ' ' + ape,
                    option: per.id};
            });
        }
    }
});



$('#p_telefono_c').typeahead({
    hint: false,
    highlight: true,
    minLength: 1,
    limit: 10
},
        {
            name: 'personas',
            display: 'value',
            source: personas,

            templates: {
                header: '<h4 class="dropdown">Personas</h4>'
            }
        });

jQuery('#p_email_c').on('typeahead:selected', function (e, datum) {
           swal({   
            title: "Esta seguro que desea utilizar al siguiente propietario?",   
            text: datum.value,   
            type: "warning",   
            showCancelButton: true,   
            confirmButtonColor: "#DD6B55",   
            confirmButtonText: "SI",   
            closeOnConfirm: false 
        }, function(){   
             window.location.href = '/corredor/agregarpersona/'+$('#idcaptacion_c').val()+'/'+datum.option; 
        });
});



$("#i_id_region_c").change(function (event) {
    $("#i_id_provincia_c").empty();
    $("#i_id_comuna_c").empty();
    $.get("/provincias/" + event.target.value + "", function (response, state) {
        $("#i_id_provincia_c").append("<option value=''>Seleccione provincia</option>");
        for (i = 0; i < response.length; i++) {
            $("#i_id_provincia_c").append("<option value='" + response[i].provincia_id + "'>" + response[i].provincia_nombre + "</option>");
        }
    });
});

$("#i_id_provincia_c").change(function (event) {
    $("#i_id_comuna_c").empty();
    $.get("/comunas/" + event.target.value + "", function (response, state) {
        $("#i_id_comuna_c").append("<option value=''>Seleccione comuna</option>");
        for (i = 0; i < response.length; i++) {
            $("#i_id_comuna_c").append("<option value='" + response[i].comuna_id + "'>" + response[i].comuna_nombre + "</option>");
        }
    });
});

$("#p_id_region_c").change(function (event) {
    $("#p_id_provincia_c").empty();
    $("#p_comunas_c").empty();
    $.get("/provincias/" + event.target.value + "", function (response, state) {
        $("#p_id_provincia_c").append("<option value=''>Seleccione provincia</option>");
        for (i = 0; i < response.length; i++) {
            $("#p_id_provincia_c").append("<option value='" + response[i].provincia_id + "'>" + response[i].provincia_nombre + "</option>");
        }
    });
});

$("#p_id_provincia_c").change(function (event) {
    $("#p_id_comuna_c").empty();
    $.get("/comunas/" + event.target.value + "", function (response, state) {
        $("#p_id_comuna_c").append("<option value=''>Seleccione comuna</option>");
        for (i = 0; i < response.length; i++) {
            $("#p_id_comuna_c").append("<option value='" + response[i].comuna_id + "'>" + response[i].comuna_nombre + "</option>");
        }
    });
});


jQuery('#datepicker-fecha_publicacion_c').datepicker({
    format: 'dd-mm-yyyy',
    todayHighlight: true,
    autoclose: true, 
    language: "es",
    locale: "es",
});

jQuery('#datepicker-fecha_expiracion_c').datepicker({
    format: 'dd-mm-yyyy',
    todayHighlight: true,
    autoclose: true, 
    language: "es",
    locale: "es",
});

jQuery('#datepicker-fecha_contacto1_c').datepicker({
    format: 'dd-mm-yyyy',
    todayHighlight: true,
    autoclose: true, 
    language: "es",
    locale: "es",
});

jQuery('#datepicker-fecha_contacto_e_c').datepicker({
    format: 'dd-mm-yyyy',
    todayHighlight: true,
    autoclose: true, 
    language: "es",
    locale: "es",
});

jQuery('#datepicker-fecha_contrato_a_b').datepicker({
    format: 'dd-mm-yyyy',
    todayHighlight: true,
    autoclose: true, 
    language: "es",
    locale: "es",
});


$("#li_1_c").click(function (event) {
             $("#li_1_c").addClass("tab-current");
            $("#li_2_c").removeClass("tab-current");
            $("#section-iconbox-1_c").addClass("content-current");
            $("#section-iconbox-2_c").removeClass("content-current");
            
});
$("#li_4_c").click(function (event) {
             $("#li_4_c").addClass("tab-current");
            $("#li_2_c").removeClass("tab-current");
             $("#section-iconbox-4_c").addClass("content-current");
            $("#section-iconbox-2_c").removeClass("content-current");           
});
$("#li_5_c").click(function (event) {
             $("#li_5_c").addClass("tab-current");
            $("#li_2_c").removeClass("tab-current");
            $("#section-iconbox-5_c").addClass("content-current");
            $("#section-iconbox-2_c").removeClass("content-current");
            
});



        // Basic
        $('.dropify').dropify();
        // Translated
        $('.dropify-fr').dropify({
            messages: {
                default: 'Glissez-déposez un fichier ici ou cliquez',
                replace: 'Glissez-déposez un fichier ou cliquez pour remplacer',
                remove: 'Supprimer',
                error: 'Désolé, le fichier trop volumineux'
            }
        });
        // Used events
        var drEvent = $('#input-file-events').dropify();
        drEvent.on('dropify.beforeClear', function(event, element) {
            return confirm("Esta seguro de eliminar  \"" + element.file.name + "\" ?");
        });
        drEvent.on('dropify.afterClear', function(event, element) {
            alert('Archivo Borrado');
        });
        drEvent.on('dropify.errors', function(event, element) {
            console.log('Has Errors');
        });
        var drDestroy = $('#input-file-to-destroy').dropify();
        drDestroy = drDestroy.data('dropify')
        $('#toggleDropify').on('click', function(e) {
            e.preventDefault();
            if (drDestroy.isDropified()) {
                drDestroy.destroy();
            } else {
                drDestroy.init();
            }
        })
    


//FIN CAPTACION