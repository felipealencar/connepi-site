$(document).on('ready', function(){

  // loading
  setTimeout(function(){$('body').removeClass('overlay')},300);
  $('.loading').fadeOut();

  // toggleNav
  $(document).on('click', '.toggleNav', function(){
    $(this).toggleClass('active');
    $('.sidebar-nav').toggleClass('active');
  });

  // sidebar
  $('.sidebar-nav > a').on('click', function(){
    if(!$(this).next().hasClass('active')){
      $('.sidebar-nav .sub').removeClass('active');
      $(this).next().addClass('active');
      $(this).find('.fa').removeClass('fa-chevron-down').addClass('fa-chevron-left')
    } else {
      $(this).find('.fa').removeClass('fa-chevron-left').addClass('fa-chevron-down')
      $('.sidebar-nav .sub').removeClass('active');
    }
  });

  // thumbs-roll
  var sliderPrev = $('.thumbs-roll span.prev');
  var sliderNext = $('.thumbs-roll span.next');
  var currentTraslate = (($('.thumbs-roll .thumbs').css('transform')).split(','))[4];

  $(document).on('click', '.thumbs-roll span', function(){
    var control = $(this).data('control');
    var slider = $('.thumbs-roll .thumbs');
    var maxPrev = -(slider.width() - 588);
    var currentTraslate = (($('.thumbs-roll .thumbs').css('transform')).split(','))[4];

    // Sliding
    if(control == 'next' && parseInt(currentTraslate) < -10){
      slider.css({'transform':'matrix(1, 0, 0, 1, '+ (parseInt(currentTraslate) + 160) +', 0)'});
    } else if (control == 'prev' && parseInt(currentTraslate) > maxPrev){
      slider.css({'transform':'matrix(1, 0, 0, 1, '+ (parseInt(currentTraslate) - 160) +', 0)'});
    }
  });

  // change current image
  $(document).on('click', '.img-tigger', function(){
    $('.img-tigger').removeClass('active');
    $('.img-target').attr('src', '');
    $('.img-target').attr('src', $(this).data('target'));
    $('.img-target-a').attr('href', $(this).data('target'));
    $('.img-target-a').data('lity-target', $(this).data('target'));
    $(this).addClass('active');
  });

});
