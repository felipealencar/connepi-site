$(document).ready(function(){

  // exibe o loading
  $("form[name='form-gerador']").on('submit', function(){
    $("#carregando").css('display', 'block');
  });

  var intro = $("#intro");
  var continuar = $("#continuar");
  var formulario = $("#formulario");

  continuar.on("click", function(){
    intro.animate({
      opacity: 0
    }, 1000, function(){
      $(this).css({"display":"none"});
      formulario.css({"display":"block"});
    });
    formulario.animate({
      opacity: 1,
      marginTop: "0px"
    }, 2000, function(){

    });
  });

});

window.onload = function(){
  $("#carregando").css('display', 'none');
}
