$(window).load(function() {
    $("#preloader").fadeOut("slow");
});

// máscara (input)
$("#cpf").mask("000.000.000-00");

$(document).ready(function(){

    //ajax form areas ...
    var form = $('.form-auditores'),
        grandesAreas = $('.grandes-areas'),
        areas = $('.areas'),
        subAreas = $('.sub-areas'),
        especialidades = $('.especialidades');

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
                    var novasOpcoes = '<option value="">Selecione</option>';
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
                    var novasOpcoes = '<option value="">Selecione</option>';
                    
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
        if($('.hotsite').length > 0){
            if ($(window).scrollTop() > 100) {
                $(".navbar-default").addClass("animated");
            } else {
                $(".navbar-default").removeClass('animated');
            }
        }
    });

    $('#countdown_dashboard').countDown({
        targetDate: {
            'day':      6,
            'month':    12,
            'year':     2016,
            'hour':     09,
            'min':      00,
            'sec':      00,
        },
        omitWeeks: true
    });

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

});

// When the window has finished loading create our google map below
//google.maps.event.addDomListener(window, 'load', init);

function iniciarMapa() {
    // Basic options for a simple Google Map
    // For more options see: https://developers.google.com/maps/documentation/javascript/reference#MapOptions
    var mapOptions = {
        // How zoomed in you want the map to start at (always required)
        zoom: 16,

        // The latitude and longitude to center the map (always required)
        center: new google.maps.LatLng(-9.639262, -35.698834), // Dhaka ,
        scrollwheel: false,

        // How you would like to style the map. 
        // This is where you would paste any style found on Snazzy Maps.
        styles: [{
            "featureType":"landscape.natural",
            "elementType":"geometry.fill",
            "stylers":[{"visibility":"on"},{"color":"#e0efef"}]},{"featureType":"poi","elementType":"geometry.fill","stylers":[{"visibility":"on"},{"hue":"#1900ff"},{"color":"#c0e8e8"}]},{"featureType":"road","elementType":"geometry","stylers":[{"lightness":100},{"visibility":"simplified"}]},{"featureType":"road","elementType":"labels","stylers":[{"visibility":"off"}]},{"featureType":"transit.line","elementType":"geometry","stylers":[{"visibility":"on"},{"lightness":700}]},{"featureType":"water","elementType":"all","stylers":[{"color":"#64B77B"}]}]
    };

    // Get the HTML DOM element that will contain your map 
    // We are using a div with id="map" seen below in the <body>
    var mapElement = document.getElementById('mapa-google');

    // Create the Google Map using our element and options defined above
    var map = new google.maps.Map(mapElement, mapOptions);

}
