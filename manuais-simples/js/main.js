$(window).load(function(){
  $('#etapa-0').css('display', 'block');
})

$(document).ready(function(){
  $('button').on('click', function(){
    $('.etapa').each(function(){
      $(this).css('display', 'none');
      $(this).addClass('animated fadeIn');
    });
    $('#' + $(this).val()).css('display', 'block');
  });
});
