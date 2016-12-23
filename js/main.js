$(window).load(function() {
    $("#preloader").fadeOut("slow");
});

// máscara (input)
$("#cpf").mask("000.000.000-00");

$(document).ready(function(){

    //ajax form areas ...
    var form = $('.form-ajax'),
        grandesAreas = $('.grandes-areas'),
        areas = $('.areas'),
        subAreas = $('.sub-areas'),
        especialidades = $('.especialidades');

    form.on('submit', function(e){

        e.preventDefault();

        var dados   = $(this).serialize(),
            url     = $(this).attr('action'),
            metodo  = $(this).attr('method'),
            retorno = $('.retorno'),
            self    = $(this);

        $.ajax({

            data:   dados,
            type:   metodo,
            url:    url,

            beforeSend: function()
            {
                retorno.removeClass('hidden').empty().append('<div class="alert alert-warning"><p>Aguarde...</p></div>');
            },
            error: function(response)
            {
							response = JSON.parse(response.responseText);
							if(response.erros)
                {
										retorno.removeClass('hidden').empty().append('<div class="alert alert-danger"><p><strong>Erros de validação:</strong></p><hr /><ul class="erros"></ul></div>');
                    var ul = retorno.find('.erros');

                    $.each(response.erros, function(indice, msg){
                        ul.append('<li>'+ msg +'</li>');
                    });

                }else{
                    retorno.empty().append('<div class="alert alert-danger"><p>'+response.erros+'</p></div>');
                }
            },
            success: function(response)
            {
				if(response.sucesso)
                {
                    retorno.empty().append('<div class="alert alert-success"><p>'+response.sucesso+'</p></div>');
                }

                $(':input','.form-ajax')
                      .not(':button, :submit, :reset, :hidden')
                      .val('')
                      .removeAttr('checked')
                      .removeAttr('selected');

                self[0].reset();
            }

        });

        return false;

    });

    grandesAreas.on('change', function(){

        var self = $(this);
        if(self.val() == undefined)
        {
            return false;
        }

        //se for Outras vai rodar algum ajax? acho que não
        if(self.val() == '90000005')
        {
					return false;
        }

        $.ajax({
            url : 'ajax.php',
            type: 'get',
            data: {
                cod_grande_area : self.val()
            },
            success: function(response)
            {
                var novasOpcoes = '<option value="">Selecione</option>';
                $.each(response, function(indice, obj){
                    novasOpcoes += '<option value="'+obj.cod_area+'">'+obj.nome_area+'</option>';
                });

                areas.empty().append(novasOpcoes);
            },
            error: function(response)
            {
                alert('Entrar em contato com o suporte, algo não está legal');
            }
        });

    });

    areas.on('change', function(){

        var self = $(this);
        if(self.val() == undefined)
        {
            return false;
        }

        $.ajax({
            url : 'ajax.php',
            type: 'get',
            data: {
                cod_area : self.val()
            },
            success: function(response)
            {
                if(response.length > 0){
                    var novasOpcoes = '';
                    $.each(response, function(indice, obj){
                        novasOpcoes += '<option value="'+obj.cod_sub_area+'">'+obj.nome_sub_area+'</option>';
                    });

                }else{
                    var novasOpcoes = '<option value="">Nada Encontrado</option>';
                }

                subAreas.empty().append(novasOpcoes);
            },
            error: function(response)
            {
                alert('Entrar em contato com o suporte, algo não está legal');
            }
        });

    });

    subAreas.on('change', function(){

        var self = $(this);
        if(self.val() == undefined)
        {
            return false;
        }

        $.ajax({
            url : 'ajax.php',
            type: 'get',
            data: {
                cod_sub_area : self.val()
            },
            success: function(response)
            {
                if(response.length > 0){
                    var novasOpcoes = '';

                    $.each(response, function(indice, obj){
                        novasOpcoes += '<option value="'+obj.cod_especialidade+'">'+obj.nome_especialidade+'</option>';
                    });

                }else{
                    var novasOpcoes = '<option value="">Nada Encontrado</option>';
                }

                especialidades.empty().append(novasOpcoes);

            },
            error: function(response)
            {
                alert('Entrar em contato com o suporte, algo não está legal');
            }
        });

    });

    wow = new WOW({
        mobile:       false,       // default
      }
    )
    wow.init();

     $('#top-nav').onePageNav({
        currentClass: 'current',
        changeHash: true,
        scrollSpeed: 1200
    });


    //animated header class
    $(window).scroll(function () {
            if ($(window).scrollTop() > 100) {
                $(".navbar-default").addClass("animated");
            } else if ($(window).scrollTop() <= 100 && $('[name="form"]').val() != 'avaliador') {
                $(".navbar-default").removeClass('animated');
            }
        });

    // $('#countdown_dashboard').countDown({
    //     targetDate: {
    //         'day':      6,
    //         'month':    12,
    //         'year':     2016,
    //         'hour':     09,
    //         'min':      00,
    //         'sec':      00,
    //     },
    //     omitWeeks: true
    // });

    $('.init-slider').owlCarousel({
        items:1,
        merge:true,
        loop:true,
        video:true,
        smartSpeed: 600
    });

    /*$('input, textarea').data('holder', $('input, textarea').attr('placeholder'));

    $('input, textarea').focusin(function () {
        $(this).attr('placeholder', '');
    });
    $('input, textarea').focusout(function () {
        $(this).attr('placeholder', $(this).data('holder'));
    });*/


    //contact form validation
    $("#contact-form").validate({
        rules: {
            name: {
                required: true,
                minlength: 2
            },
            message: {
                required: true,
                minlength: 2
            },
            email: {
                required: true,
                email: true
            }
        },
        messages: {
            name: {
                required: "Please enter Your Name",
                minlength: "Your name must consist of at least 2 characters"
            },
            message: {
                required: "Please Write Something",
                minlength: "Your message must consist of at least 2 characters"
            },
            email: "Please enter a valid email address"
        },
        submitHandler: function(form) {
            $(form).ajaxSubmit({
                type:"POST",
                data: $(form).serialize(),
                url:"mail.php",
                success: function() {
                    $('#contact-form :input').attr('disabled', 'disabled');
                    $('#contact-form').fadeTo( "slow", 0.15, function() {
                        $(this).find(':input').attr('disabled', 'disabled');
                        $(this).find('label').css('cursor','default');
                        $('#success').fadeIn();
                    });
                },
                error: function() {
                    $('#contact-form').fadeTo( "slow", 0.15, function() {
                        $('#error').fadeIn();
                    });
                }
            });
        }
    });

	// Configure/customize these variables.
    var showChar = 500;  // How many characters are shown by default
    var ellipsestext = "...";
    var moretext = "<p class=\"btn btn-default btn-more\">Leia mais</p>";
    var lesstext = "Ocultar";

    $('.more').each(function() {
        var content = $(this).html();

        if(content.length > showChar) {

            var c = content.substr(0, showChar);
            var h = content.substr(showChar, content.length - showChar);

            var html = c + '<span class="moreellipses">' + ellipsestext+ '&nbsp;</span><span class="morecontent"><span>' + h + '</span>&nbsp;&nbsp;<a href="" class="morelink">' + moretext + '</a></span>';

            $(this).html(html);
        }

    });

    $(".morelink").click(function(){
        if($(this).hasClass("less")) {
            $(this).removeClass("less");
            $(this).html(moretext);
        } else {
            $(this).addClass("less");
            $(this).html(lesstext);
        }
        $(this).parent().prev().toggle();
        $(this).prev().toggle();
        return false;
    });
});

// When the window has finished loading create our google map below
//google.maps.event.addDomListener(window, 'load', init);

function init() {
    // Basic options for a simple Google Map
    // For more options see: https://developers.google.com/maps/documentation/javascript/reference#MapOptions
    var mapOptions = {
        // How zoomed in you want the map to start at (always required)
        zoom: 16,

        // The latitude and longitude to center the map (always required)
        center: new google.maps.LatLng(23.751945, 90.384590), // Dhaka ,
        scrollwheel: false,

        // How you would like to style the map.
        // This is where you would paste any style found on Snazzy Maps.
        styles: [{"featureType":"landscape.natural","elementType":"geometry.fill","stylers":[{"visibility":"on"},{"color":"#e0efef"}]},{"featureType":"poi","elementType":"geometry.fill","stylers":[{"visibility":"on"},{"hue":"#1900ff"},{"color":"#c0e8e8"}]},{"featureType":"road","elementType":"geometry","stylers":[{"lightness":100},{"visibility":"simplified"}]},{"featureType":"road","elementType":"labels","stylers":[{"visibility":"off"}]},{"featureType":"transit.line","elementType":"geometry","stylers":[{"visibility":"on"},{"lightness":700}]},{"featureType":"water","elementType":"all","stylers":[{"color":"#7dcdcd"}]}]
    };

    // Get the HTML DOM element that will contain your map
    // We are using a div with id="map" seen below in the <body>
    var mapElement = document.getElementById('map-canvas');

    // Create the Google Map using our element and options defined above
    var map = new google.maps.Map(mapElement, mapOptions);

    // Let's also add a marker while we're at it
    var marker = new google.maps.Marker({
        position: new google.maps.LatLng(23.751945, 90.384590),
        map: map,
        icon: 'img/map.png',
        title: 'Twing!'
    });
}
