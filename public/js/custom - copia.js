/*jslint browser: true*/
/*global $, jQuery, alert*/

$(document).ready(function () {

    "use strict";

    var body = $("body");

    $(function () {
        $(".preloader").fadeOut();
        $('#side-menu').metisMenu();
    });

    /* ===== Theme Settings ===== */

    $(".open-close").on("click", function () {
        body.toggleClass("show-sidebar").toggleClass("hide-sidebar");
        $(".sidebar-head .open-close i").toggleClass("ti-menu");
    });

    /* ===== Open-Close Right Sidebar ===== */

    $(".right-side-toggle").on("click", function () {
        $(".right-sidebar").slideDown(50).toggleClass("shw-rside");
        $(".fxhdr").on("click", function () {
            body.toggleClass("fix-header"); /* Fix Header JS */
        });
        $(".fxsdr").on("click", function () {
            body.toggleClass("fix-sidebar"); /* Fix Sidebar JS */
        });

        /* ===== Service Panel JS ===== */

        var fxhdr = $('.fxhdr');
        if (body.hasClass("fix-header")) {
            fxhdr.attr('checked', true);
        } else {
            fxhdr.attr('checked', false);
        }
    });

    /* ===========================================================
        Loads the correct sidebar on window load.
        collapses the sidebar on window resize.
        Sets the min-height of #page-wrapper to window size.
    =========================================================== */

    $(function () {
        var set = function () {
                var topOffset = 60,
                    width = (window.innerWidth > 0) ? window.innerWidth : this.screen.width,
                    height = ((window.innerHeight > 0) ? window.innerHeight : this.screen.height) - 1;
                if (width < 768) {
                    $('div.navbar-collapse').addClass('collapse');
                    topOffset = 100; /* 2-row-menu */
                } else {
                    $('div.navbar-collapse').removeClass('collapse');
                }

                /* ===== This is for resizing window ===== */

                if (width < 1170) {
                    body.addClass('content-wrapper');
                    $(".sidebar-nav, .slimScrollDiv").css("overflow-x", "visible").parent().css("overflow", "visible");
                } else {
                    body.removeClass('content-wrapper');
                }

                height = height - topOffset;
                if (height < 1) {
                    height = 1;
                }
                if (height > topOffset) {
                    $("#page-wrapper").css("min-height", (height) + "px");
                }
            },
            url = window.location,
            element = $('ul.nav a').filter(function () {
                return this.href === url || url.href.indexOf(this.href) === 0;
            }).addClass('active').parent().parent().addClass('in').parent();
        if (element.is('li')) {
            element.addClass('active');
        }
        $(window).ready(set);
        $(window).bind("resize", set);
    });

    /* ===== Collapsible Panels JS ===== */

    (function ($, window, document) {
        var panelSelector = '[data-perform="panel-collapse"]',
            panelRemover = '[data-perform="panel-dismiss"]';
        $(panelSelector).each(function () {
            var collapseOpts = {
                    toggle: false
                },
                parent = $(this).closest('.panel'),
                wrapper = parent.find('.panel-wrapper'),
                child = $(this).children('i');
            if (!wrapper.length) {
                wrapper = parent.children('.panel-heading').nextAll().wrapAll('<div/>').parent().addClass('panel-wrapper');
                collapseOpts = {};
            }
            wrapper.collapse(collapseOpts).on('hide.bs.collapse', function () {
                child.removeClass('ti-minus').addClass('ti-plus');
            }).on('show.bs.collapse', function () {
                child.removeClass('ti-plus').addClass('ti-minus');
            });
        });

        /* ===== Collapse Panels ===== */

        $(document).on('click', panelSelector, function (e) {
            e.preventDefault();
            var parent = $(this).closest('.panel'),
                wrapper = parent.find('.panel-wrapper');
            wrapper.collapse('toggle');
        });

        /* ===== Remove Panels ===== */

        $(document).on('click', panelRemover, function (e) {
            e.preventDefault();
            var removeParent = $(this).closest('.panel');

            function removeElement() {
                var col = removeParent.parent();
                removeParent.remove();
                col.filter(function () {
                    return ($(this).is('[class*="col-"]') && $(this).children('*').length === 0);
                }).remove();
            }
            removeElement();
        });
    }(jQuery, window, document));

    /* ===== Tooltip Initialization ===== */

    $(function () {
        $('[data-toggle="tooltip"]').tooltip();
    });

    /* ===== Popover Initialization ===== */

    $(function () {
        $('[data-toggle="popover"]').popover();
    });

    /* ===== Task Initialization ===== */

    $(".list-task li label").on("click", function () {
        $(this).toggleClass("task-done");
    });
    $(".settings_box a").on("click", function () {
        $("ul.theme_color").toggleClass("theme_block");
    });

    /* ===== Collepsible Toggle ===== */

    $(".collapseble").on("click", function () {
        $(".collapseblebox").fadeToggle(350);
    });

    /* ===== Sidebar ===== */

    $('.slimscrollright').slimScroll({
        height: '100%',
        position: 'right',
        size: "5px",
        color: '#dcdcdc'
    });
    $('.slimscrollsidebar').slimScroll({
        height: '100%',
        position: 'left',
        size: "6px",
        color: 'rgba(0,0,0,0.5)'
    });
    $('.chat-list').slimScroll({
        height: '100%',
        position: 'right',
        size: "0px",
        color: '#dcdcdc'
    });

    /* ===== Resize all elements ===== */

    body.trigger("resize");

    /* ===== Visited ul li ===== */

    $('.visited li a').on("click", function (e) {
        $('.visited li').removeClass('active');
        var $parent = $(this).parent();
        if (!$parent.hasClass('active')) {
            $parent.addClass('active');
        }
        e.preventDefault();
    });

    /* ===== Login and Recover Password ===== */

    $('#to-recover').on("click", function () {
        $("#loginform").slideUp();
        $("#recoverform").fadeIn();
    });

    /* ================================================================= 
        Update 1.5
        this is for close icon when navigation open in mobile view
    ================================================================= */

    $(".navbar-toggle").on("click", function () {
        $(".navbar-toggle i").toggleClass("ti-menu").addClass("ti-close");
    });


});


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
                return {value: dir.direccion + '      , ' + dir.numero + ' ,  ' + dir.comuna_nombre,
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

                templates: {
                header: '<h4 class="dropdown">Direcciones</h4>'
            }
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
                return {value: per.email + ' , ' + per.nombre + ' ' + per.apellido,
                    option: per.id};
            });
        }
    },
    remote: {
        wildcard: '%QUERY',
        url: "/personas/email/%QUERY",
        transform: function (response) {
            return $.map(response, function (per) {
                return {value: per.email + ' , ' + per.nombre + ' ' + per.apellido_paterno,
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

            templates: {
                header: '<h4 class="dropdown">Personas</h4>'
            }
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

jQuery('#datepicker-fecha_publicacion').datepicker({
    autoclose: true,
    todayHighlight: true,
    format: 'dd/mm/yyyy'
});

jQuery('#datepicker-fecha_expiracion').datepicker({
    autoclose: true,
    todayHighlight: true,
    format: 'dd/mm/yyyy'
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